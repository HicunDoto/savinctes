<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Events;
use \App\Models\Bookings;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function listEvent()
    {
        $getID = Session::get('id');
        $cekRole = User::find($getID);
        if (!$cekRole) {
            return false;
        }else{
            if ($cekRole->role == 'Admin') {
                $event = Events::get();
            } else {
                $event = Events::where('created_by_user_id',$cekRole->id)->get();
            }
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
            if ($cekBookingUser > 0 || $cekRole->role == 1) {
                $arrTemp['booking_status'] = 1;
            } else {
                $arrTemp['booking_status'] = 0;
            }
            
            array_push($data,$arrTemp);
        }
        return view('admin.listEvent',[
            'data' => $data,
        ]);
    }

    public function listEventUser(Request $request)
    {
        $getID = Session::get('id');
        $cekRole = User::find($getID);
        if (!$cekRole) {
            return false;
        }else{
            $event = Events::get();
            $eventUser = Events::where('created_by_user_id',$cekRole->id)->get();
            $data = [];
            $dataUser = [];
            foreach ($eventUser as $key => $value) {
                $arrTemp = [];
                $arrTemp['ID'] = $value->id;
                $arrTemp['title'] = $value->title;
                $arrTemp['description'] = $value->description;
                $arrTemp['date'] = $value->date;
                $arrTemp['time'] = $value->time;
                $arrTemp['location'] = $value->location;
                $arrTemp['slots_available'] = $value->slots_available;
                $arrTemp['created_by_user_id'] = $value->created_by_user_id;
                $arrTemp['highlight'] = ($value->created_by_user_id == $cekRole->id ? '1' : '0');
                $cekBookingUser = Bookings::where('user_id',$cekRole->id)->get()->count();
                if ($cekBookingUser > 0 || $cekRole->role == 1) {
                    $arrTemp['booking_status'] = 1;
                } else {
                    $arrTemp['booking_status'] = 0;
                }
                
                array_push($dataUser,$arrTemp);
            }

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
                $arrTemp['highlight'] = ($value->created_by_user_id == $cekRole->id ? '1' : '0');
                $cekBookingUser = Bookings::where('user_id',$cekRole->id)->get()->count();
                $cekBooking = Bookings::where('event_id',$value->id)->get()->count();
                $totalBooking = $value->slots_available - $cekBooking;
                if ($cekBookingUser > 0 || $cekRole->role == 1) {
                    $arrTemp['booking_status'] = 1; // sudah booking / admin tidak bisa booking
                } elseif ($totalBooking == 0) {
                    $arrTemp['booking_status'] = 2; // full booking
                } else {
                    $arrTemp['booking_status'] = 0; // bisa booking
                }
                $hariIni = strtotime(date('d-m-Y H:i:s'));
                $hariEvent = strtotime($value->date.' '.$value->time);
                $arrTemp['status_event'] = $hariEvent>=$hariIni ? '1' : '0'; // 1 = upcoming, 0 = selesai
                
                array_push($data,$arrTemp);
            }
            return view('user.listEvent',[
                'dataUser' => $dataUser,
                'data' => $data,
            ]);
        }
    }

    public function detailBooking(Request $request)
    {
        $booking = Bookings::where('event_id',$request->id)->get();
        
        return view('user.listBooking',[
            'data' => $booking
        ]);
    }

    public function createEvent()
    {
        return view('createEvent');
    }

    public function storeEvent(Request $request){
      
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'slots_available' => 'required',
            'created_by_user_id' => 'required',
            ]);
            $event = Events::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'location' => $request->location,
                'slots_available' => $request->slots_available,
                'created_by_user_id' => $request->created_by_user_id,
            ]);
            return redirect('/createEvent')->with('status', 'Berhasil membuat event');
    }

    public function editEvent($id)
    {
        $event = Events::where('id_soal',$id)->firstOrFail();
        return view('admin.editEvent',[
            'event' => $event,
        ]);
    }

    public function storeEditEvent(Request $request){
      
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'slots_available' => 'required',
            'created_by_user_id' => 'required',
            ]);
            $event = Events::find($request->id);
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date = $request->date;
            $event->time = $request->time;
            $event->location = $request->location;
            $event->slots_available = $request->slots_available;
            $event->save();

            return redirect('/editEvent')->with('status', 'Berhasil mengedit event');
    }

    public function destroy(Request $request,$id)
    {
        $booking = Bookings::where('event_id',$id)->delete();
        $event = Events::find($id)->delete();
        return redirect('/admin/listEvent')->with('status', 'Event berhasil dihapus!');
    }
}
