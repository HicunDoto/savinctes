<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\User;
use \App\Models\Events;
use \App\Models\Bookings;
use Auth;
use Illuminate\Contracts\Session\Session as SessionSession;
use Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as HttpFoundationSessionSession;

class DashboardController extends Controller
{
    public function listEvent()
    {
        // return view('admin.listEvent');
        $getID = Session::get('id');
        $cekRole = User::find($getID);
        // dd($cekRole->id);
        if (!$cekRole) {
            return false;
        }else{
            if ($cekRole->role == 'admin') {
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
            $arrTemp['highlight'] = ($value->created_by_user_id == $cekRole->id) ? '1' : '0';
            $cekBookingUser = Bookings::where('user_id',$cekRole->id)->get()->count();
            if ($cekBookingUser > 0 || $cekRole->role == 1) {
                $arrTemp['booking_status'] = 1;
            } else {
                $arrTemp['booking_status'] = 0;
            }
            $hariIni = strtotime(date('d-m-Y H:i:s'));
            $hariEvent = strtotime($value->date.' '.$value->time);
            $arrTemp['status_event'] = $hariEvent>$hariIni ? '1' : '0'; // 1 = upcoming, 0 = selesai
            
            array_push($data,$arrTemp);
        }
        $data = $this->paginate($data);
        // dd(json_encode($data));
        return view('admin.listEvent',[
            'data' => $data,
        ]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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
                $hariIni = strtotime(date('d-m-Y H:i:s'));
                $hariEvent = strtotime($value->date.' '.$value->time);
                $arrTemp['status_event'] = $hariEvent>$hariIni ? '1' : '0'; // 1 = upcoming, 0 = selesai
                
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
                $arrTemp['status_user'] = ($value->created_by_user_id == $cekRole->id) ? 1 : 0; // 1 = pembuat event, 0 = bukan pembuat event
                $arrTemp['status_event'] = $hariEvent>$hariIni ? '1' : '0'; // 1 = upcoming, 0 = selesai
                
                array_push($data,$arrTemp);
            }
            $data = $this->paginate($data);
            $dataUser = $this->paginate($dataUser);
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
        $role = Session::get('role');
        if ($role == 'admin') {
            return view('admin.formEvent');
        } else {
            return view('user.formEvent');
        }
        
    }

    public function storeEvent(Request $request){
        $role = Session::get('role');
        $idUser = Session::get('id');
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'slots_available' => 'required',
        ]);
        $event = Events::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'slots_available' => $request->slots_available,
            'created_by_user_id' => $idUser,
        ]);
        if ($role == 'admin') {
            return redirect('/admin')->with('status', 'Berhasil membuat event');
        } else {
            return redirect('/user')->with('status', 'Berhasil membuat event');
        }
    }

    public function editEvent($id)
    {
        // dd($id);
        $event = Events::find($id);
        $role = Session::get('role');
        if ($role == 'admin') {
            return view('admin.formEvent',[
                'data' => $event,
            ]);
        } else {
            return view('user.formEvent',[
                'data' => $event,
            ]);
        }
    }

    public function storeEditEvent(Request $request,$id)
    {
        $role = Session::get('role');
        // dd($request);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'slots_available' => 'required',
        ]);
        $event = Events::where('id',$id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'slots_available' => $request->slots_available,
        ]);
        if ($role == 'admin') {
            return redirect('/admin')->with('status', 'Berhasil mengedit event');
        } else {
            return redirect('/user')->with('status', 'Berhasil mengedit event');
        }
    }

    public function destroy(Request $request,$id)
    {
        $booking = Bookings::where('event_id',$id)->delete();
        $event = Events::find($id)->delete();
        $role = Session::get('role');
        if ($role == 'admin') {
            return redirect('/admin')->with('status', 'Event berhasil dihapus!');
        } else {
            return redirect('/user')->with('status', 'Event berhasil dihapus!');
        }
    }

    public function detailEvent($id)
    {
        $event = Events::find($id);
        $event['loggin_userid'] = Session::get('id'); // get login userid
        $booking = Bookings::where('event_id',$event->id);
        $total_booking = $booking->get()->count();
        $total = $event->slots_available-$total_booking;
        $cek_user = $booking->where('user_id',Session::get('id'))->get()->count();
        $event['status_event_full'] = ($total == 0) ? 1 : 0; // cek status booking full atau tidak, 1 = full, 0 = belum full
        $event['role'] = Session::get('role'); // cek status user, ketika user statusnya admin tidak bisa booking
        $event['status_user_book'] = ( $cek_user > 0 ) ? 1 : 0; // cek status user apakah sudah pernah booking?, 1 = sudah ada, 0 belum ada
        $event['creator_event'] = $event->user->name; // Nama Pembuat Event

        $hariIni = strtotime(date('d-m-Y H:i:s'));
        $hariEvent = strtotime($event->date.' '.$event->time);
        $event['status_event'] = $hariEvent>$hariIni ? '1' : '0'; // 1 = upcoming, 0 = selesai
        $role = Session::get('role');
        if ($role == 'admin') {
            return view('admin.detailEvent',[
                'data' => $event,
            ]);
        } else {
            return view('user.detailEvent',[
                'data' => $event,
            ]);
        }
    }
}
