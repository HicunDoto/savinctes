<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Events;
use \App\Models\Bookings;
use Auth;
use Session;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function detailEvent(Request $request)
    {
        $getID = Session::get('id');
        $cekRole = User::find($getID);
        if (!$cekRole) {
            return false;
        }else{
            $event = Events::find($request->id);
            $data = [];
            $data['ID'] = $event->id;
            $data['title'] = $event->title;
            $data['description'] = $event->description;
            $data['date'] = $event->date;
            $data['time'] = $event->time;
            $data['location'] = $event->location;
            $data['slots_available'] = $event->slots_available;
            $data['created_by_user_id'] = $event->created_by_user_id;
            $data['highlight'] = ($event->created_by_user_id == $cekRole->ID ? '1' : '0');
            $cekBookingUser = Bookings::where('user_id',$cekRole->id)->get()->count();
            $cekBooking = Bookings::where('event_id',$event->id)->get()->count();
            $totalBooking = $event->slots_available - $cekBooking;
            if ($cekBookingUser > 0 || $cekRole->role == 1) {
                $data['booking_status'] = 1;
            } elseif ($totalBooking == 0) {
                $data['booking_status'] = 2;
            } else {
                $data['booking_status'] = 0;
            }
            $data['creator'] = $event->user->name;
            $data['bookings'] = [];
            if ($event->created_by_user_id == $cekRole->ID || $cekRole->role == 1) {
                $bookings = Bookings::where('event_id',$event->id)->get();
                foreach ($bookings as $key => $value) {
                    $arrTemp = [];
                    $arrTemp['Nama yang sudah booking'] = $value->user->name;
                    $arrTemp['Tanggal booking'] = date('d-m-Y', strtotime($value->booked_at));
                    array_push($data['bookings'], $arrTemp);
                }
            }
            
            return response()->json([
                'status_code' => 200,
                'data' => $data
            ],200);
        }
    }
}
