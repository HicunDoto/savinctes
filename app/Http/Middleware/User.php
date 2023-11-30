<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ( ! auth()->user() ){
            return redirect('/')->with('status', 'Mohon Login Terlebih Dahulu!');; 
        }elseif(auth()->user()->role == "user"){
            //dd($request->all());
            return $next($request);
        }else{
            return redirect('/admin'); 
        }
    }
}