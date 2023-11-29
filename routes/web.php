<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[LoginController::class,'home'])->name('login');
Route::post('/login',[LoginController::class,'login'])->name('post.login');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::get('/registrasi',[LoginController::Class,'registrasi'])->name('get.registrasi');
Route::post('/registrasi',[LoginController::Class,'store'])->name('post.registrasi');

// Route::get('/program',[MarketingController::class,'program'])->name('program');
// Route::post('/program',[MarketingController::class,'saveProgram'])->name('saveProgram');

Route::group(['middleware'=>['admin']], function(){
    Route::get('/program',[DashboardController::class,'program'])->name('program');
    Route::get('/addprogram',[DashboardController::class,'formProgram'])->name('addProgram');
    Route::get('/editprogram/{id}',[DashboardController::class,'formProgram'])->name('editProgram');
    Route::get('/addsales',[DashboardController::class,'formSales'])->name('addSales');
    Route::get('/sales',[DashboardController::class,'sales'])->name('sales');
    Route::get('/exportPDF',[DashboardController::class,'exportPDF'])->name('exportPDF');
});

Route::group(['middleware'=>['user']], function(){
    Route::get('/customer',[DashboardController::class,'customer'])->name('customer');
    Route::get('/addcustomer',[DashboardController::class,'formCustomer'])->name('addCustomer');
    Route::get('/editcustomer/{id}',[DashboardController::class,'formCustomer'])->name('editCustomer');
    Route::get('/updatepassword/{id}',[DashboardController::class,'updatePassword'])->name('updatePassword');
});