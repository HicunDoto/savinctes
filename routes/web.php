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
Route::get('/registrasi',[LoginController::class,'registrasi'])->name('get.registrasi');
Route::post('/registrasi',[LoginController::class,'store'])->name('post.registrasi');

Route::group(['middleware'=>['admin']], function(){
    Route::get('/admin',[DashboardController::class,'listEvent'])->name('dashboard.admin');
    Route::get('/admin/edit-profile/{id}',[LoginController::class,'editProfile'])->name('dashboard.editProfile');
    Route::put('/admin/{id}/edit-profile',[LoginController::class,'editStoreProfile'])->name('dashboard.editStoreProfile');
    Route::get('/admin/create-event', [DashboardController::class, 'createEvent'])->name('dashboard.createEvent');
    Route::post('/admin', [DashboardController::class, 'storeEvent'])->name('dashboard.postCreateEvent');
    Route::post('/admin/event/{id}', [DashboardController::class, 'destroy'])->name('dashboard.postDeletedestroy');
    Route::get('/admin/{id}/edit',[DashboardController::class,'editEvent'])->name('dashboard.editEvent');
    Route::put('/admin/{id}/edit-event',[DashboardController::class,'storeEditEvent'])->name('dashboard.postEditEvent');
    Route::get('/admin/{id}/detail-event',[DashboardController::class,'detailEvent'])->name('dashboard.detailEvent');
});

Route::group(['middleware'=>['user']], function(){
    Route::get('/user',[DashboardController::class,'listEventUser'])->name('dashboard.user');
    Route::get('/user/edit-profile/{id}',[LoginController::class,'editProfile'])->name('dashboard.user.editProfile');
    Route::put('/user/{id}/edit-profile',[LoginController::class,'editStoreProfile'])->name('dashboard.user.editStoreProfile');
    Route::get('/user/create-event', [DashboardController::class, 'createEvent'])->name('dashboard.user.createEvent');
    Route::post('/user', [DashboardController::class, 'storeEvent'])->name('dashboard.user.postCreateEvent');
    Route::post('/user/event/{id}', [DashboardController::class, 'destroy'])->name('dashboard.user.postDeletedestroy');
    Route::get('/user/{id}/edit',[DashboardController::class,'editEvent'])->name('dashboard.user.editEvent');
    Route::put('/user/{id}/edit-event',[DashboardController::class,'storeEditEvent'])->name('dashboard.user.postEditEvent');
    Route::get('/user/{id}/detail-event',[DashboardController::class,'detailEvent'])->name('dashboard.user.detailEvent');
});