<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminPanel\printingPressController;
use App\Http\Controllers\adminPanel\storeBookController;

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



Route::prefix('admin')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'admin'])->group(function () {

    //dashbaord
    Route::get('/dashboard', function () {
        return view('adminPanel/dashboard');
    })->name('admin.dashboard');



    Route::controller(printingPressController::class)->group(function () {

        Route::get('printing/press', 'index')->name('admin.printing.press');
        Route::post('add/printing/press', 'store')->name('admin.printing.store');
        Route::get('get/printing/press/data', 'showTableData')->name('admin.get.printing.press.data');
        Route::get('get/printing/press/edit/data/{id}', 'edit')->name('admin.get.printing.press.edit');
        Route::put('printing/press/update/data/{id}', 'update')->name('admin.get.printing.press.update');
        Route::delete('printing/press/delete/{id}',  'destroy')->name('admin.printing.press.delete');
    });



    Route::controller(storeBookController::class)->group(function () {

        Route::get('store/book', 'index')->name('admin.store.book');
        Route::post('store/book/store', 'store')->name('admin.store.book.store');
        Route::get('get/book/storage/data', 'showTableData')->name('admin.get.book.storage.data');
        Route::get('get/book/storage/edit/data/{id}', 'edit')->name('admin.get.book.storage.edit');
        Route::put('store/book/update/data/{id} ', 'update')->name('admin.get.book.storage.update');
        Route::delete('store/book/delete/{id}',  'destroy')->name('admin.printing.press.delete');


    });

});





Route::get('/', function () {
    return view('userPanel/dashboard');
});

Route::post('user/msg/store', 'App\Http\Controllers\userPanel\homeController@store')->name('user.msg');

