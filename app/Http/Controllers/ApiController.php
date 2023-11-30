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
    public function addBooking(Request $request) {
        $booking = Bookings::where('event_id',$request->event_id)->where('user_id',$request->UserID)->get()->count();
        if ($booking > 0) {
            return response()->json([
                'status_code' => 404,
                'data' => []
            ],200);
        }else{
            $booking = new Bookings();
            $booking->event_id = $request->event_id;
            $booking->user_id = $request->UserID;
            $booking->booked_at = date('Y-m-d H:i:s');
            $booking->save();
            return response()->json([
                'status_code' => 200,
                'data' => $booking->toArray()
            ],200);
        }
        
    }
    public function detailEvent(Request $request)
    {
        $getID = $request->UserID;
        $cekRole = User::find($getID);
        if (!$cekRole) {
            return response()->json([
                'status_code' => 404,
                'data' => []
            ],404);
        }else{
            $event = Events::find($request->id);
            if ($event == null) {
                return response()->json([
                    'status_code' => 404,
                    'data' => []
                ],404);
            }
            // dd($event);
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
            if ($event->created_by_user_id == $cekRole->id || $cekRole->role == 1) {
                $bookings = Bookings::where('event_id',$event->id)->get();
                $no = 1;
                foreach ($bookings as $key => $value) {
                    $arrTemp = [];
                    $arrTemp['no'] = $no++;
                    $arrTemp['Nama_booking'] = $value->user->name;
                    $arrTemp['Tanggal_booking'] = date('d-M-Y H:i', strtotime($value->booked_at));
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
