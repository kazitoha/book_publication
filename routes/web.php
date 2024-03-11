<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/dashboard', function () {
        return redirect('admin/dashboard');
    });
    Route::prefix('admin')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
       //dashbaord

        Route::get('/dashboard', function () {
            return view('adminPanel/dashboard');
        })->name('dashboard');

        Route::get('user/msg', 'App\Http\Controllers\adminPanel\contactController@index')->name('admin.user.msg');
        Route::get('service', 'App\Http\Controllers\adminPanel\contactController@index')->name('admin.service');
        Route::get('why_choose_us', 'App\Http\Controllers\adminPanel\contactController@index')->name('admin.why.choose.us');
        Route::get('portfolio', 'App\Http\Controllers\adminPanel\contactController@index')->name('admin.portfolio');
        Route::get('testimonial', 'App\Http\Controllers\adminPanel\contactController@index')->name('admin.testimonials');


    });








    Route::get('/', function () {
        return view('userPanel/dashboard');
    });

    Route::post('user/msg/store', 'App\Http\Controllers\userPanel\homeController@store')->name('user.msg');

