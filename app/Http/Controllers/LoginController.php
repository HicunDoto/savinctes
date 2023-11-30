<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Auth;
use Session;
class LoginController extends Controller
{
    public function home()
    {
        $cek = Session::get('username');
        $cekLevel = Session::get('role');
        if ($cek == null) {
            return view('login');
        } else {
            if ($cekLevel == 'admin') {
                return redirect()->route('dashboard.admin');
            } else {
                return redirect()->route('indexSales');
            }
            
        }
        
    }
    public function registrasi()
    {
        return view('registrasi');
    }

    public function store (Request $request){
      
        $request->validate([
            'nama' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5',
            'confirm-password' => 'required|same:password',
            ]);
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'remember_token' => Str::random(60),
            ]);
            return redirect('/')->with('status', 'Berhasil membuat akun');
    }

    public function login (Request $request){
        $validasi = $request->all();

        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required','min:5'],
        ]);
        if(auth()->attempt(array('email' => $validasi['email'], 'password' => $validasi['password']))){
            $user = Auth::user();
            if (auth()->user()->role == "admin") {
                Session::put('email', $user->email);
                Session::put('role', $user->role);
                Session::put('id', $user->id);
                return redirect()->intended('admin');
            }else{
                Session::put('email', $user->email);
                Session::put('role', $user->role);
                Session::put('id', $user->id);
                return redirect()->intended('user')->with('status', 'Selamat Datang '.$user->name);
            }
        }else{
            return redirect('/')->with('status', 'Username & Password Salah!!');
        }
    }
    
    public function logout (Request $request){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function editProfile(){
        $role = Session::get('role');
        $id = Session::get('id');
        $user = User::find($id);
        if ($role == 'admin') {
            return view('admin.formProfile',[
                'user' => $user
            ]);
        } else {
            return view('user.formProfile',[
                'user' => $user
            ]);
        }
    }

    public function editStoreProfile(Request $request,$id){
        $role = Session::get('role');
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        if ($role == 'admin') {
            return redirect('/admin');
        } else {
            return redirect('/user');
        }
    }
}
