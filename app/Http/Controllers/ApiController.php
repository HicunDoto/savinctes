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
            if ($request->post() && $request->post()['id'] != '') {
                $event = Events::where('id',$request->post()['id'])->get();
            } else {
                $event = Events::where(DB::raw("CONCAT(`date`, ' ', `time`)"), '>', date('Y-m-d H:i:s'))->get();
            }
            if ($event == null) {
                return response()->json([
                    'status_code' => 404,
                    'data' => []
                ],404);
            }
            $data = [];
            foreach ($event as $key => $value) {
                $arrTemp = [];
                $arrTemp['ID'] = $value->id;
                $arrTemp['title'] = $value->title;
                $arrTemp['description'] = $value->description;
                $arrTemp['date'] = $value->date;
                $arrTemp['time'] = $value->time;
                $arrTemp['location'] = $value->location;
                $arrTemp['slots_available'] = $value->slots_available;
                $arrTemp['created_by_user_id'] = $value->created_by_user_id;
                $arrTemp['highlight'] = ($value->created_by_user_id == $cekRole->ID ? '1' : '0');
                $cekBookingUser = Bookings::where('user_id',$cekRole->id)->get()->count();
                $cekBooking = Bookings::where('event_id',$value->id)->get()->count();
                $totalBooking = $value->slots_available - $cekBooking;
                if ($cekBookingUser > 0 || $cekRole->role == 1) {
                    $arrTemp['booking_status'] = 1;
                } elseif ($totalBooking == 0) {
                    $arrTemp['booking_status'] = 2;
                } else {
                    $arrTemp['booking_status'] = 0;
                }
                $arrTemp['creator'] = $value->user->name;
                $arrTemp['bookings'] = [];
                if ($value->created_by_user_id == $cekRole->id || $cekRole->role == 1) {
                    $bookings = Bookings::where('event_id',$value->id)->get();
                    $no = 1;
                    foreach ($bookings as $key => $value1) {
                        $arrTempBook = [];
                        $arrTempBook['no'] = $no++;
                        $arrTempBook['Nama_booking'] = $value1->user->name;
                        $arrTempBook['Tanggal_booking'] = date('d-M-Y H:i', strtotime($value1->booked_at));
                        array_push($arrTemp['bookings'], $arrTempBook);
                    }
                }
                array_push($data, $arrTemp);
            }
            
            return response()->json([
                'status_code' => 200,
                'data' => $data
            ],200);
        }
    }
}
