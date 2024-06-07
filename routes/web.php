<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\distributorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Auth;

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




Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {


    Route::get('/dashboard', function () {
        if (Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }elseif (Auth::user()->role_id == 2) {
            return redirect()->route('distributor.dashboard');
        }
        return view('dashboard'); // Or any other user dashboard
    });



    Route::prefix('admin')->middleware('auth', 'admin')->controller(adminController::class)->group(function () {

        Route::get('dashboard', function () {
            return view('adminPanel/dashboard');
        })->name('admin.dashboard');


        //printing press
        Route::get('printing/press', 'printingPressIndex')->name('admin.printing.press');
        Route::post('add/printing/press', 'printingPressStore')->name('admin.printing.store');
        Route::get('get/printing/press/data', 'printingPressTableData')->name('admin.get.printing.press.data');
        Route::get('get/printing/press/edit/data/{id}', 'printingPressEdit')->name('admin.get.printing.press.edit');
        Route::put('printing/press/update/data/{id}', 'printingPressUpdate')->name('admin.get.printing.press.update');
        Route::delete('printing/press/delete/{id}', 'printingPressDestroy')->name('admin.printing.press.delete');




        //unpaid to printig press
        Route::get('printing/press/unpaid', 'printingPressIndex')->name('admin.printing.press.unpaid');

        //common route
        Route::get('get/subjects/{classId}', 'getSubjectsByClass');
        Route::get('get/seller/{sellerId}', 'getSellerUnpaidAmount');
        Route::get('get/unit/price/{unitPrice}', 'bookUnitPrice');

        //book storage
        Route::get('store/book', 'bookStorageIndex')->name('admin.store.book');
        Route::post('store/book/store', 'bookStorageStore')->name('admin.store.book.store');
        Route::get('get/book/storage/data', 'bookStorageTable')->name('admin.get.book.storage.data');
        Route::get('get/book/storage/edit/data/{id}', 'bookStorageEdit')->name('admin.get.book.storage.edit');
        Route::put('store/book/update/data/{id} ', 'bookStorageUpdate')->name('admin.get.book.storage.update');
        Route::delete('store/book/delete/{id}', 'bookStorageDestroy')->name('admin.printing.press.delete');
        Route::any('book/storage/invoice/{id}', 'bookStoreageInvoice')->name('admin.book.strorage.invoice');

        //storage alert
        Route::get('storage/alert', 'storageAlert')->name('admin.storage.alert');
        Route::get('get/storage/data', 'storageTableData')->name('admin.storage.data');


        //create users
        Route::get('create/user', 'userIndex')->name('admin.create.user');
        Route::post('user/store', 'userStore')->name('admin.user.store');
        Route::get('get/user/data', 'userTableData')->name('admin.get.user.data');
        Route::get('get/user/edit/data/{id}', 'userEdit')->name('admin.get.user.edit');
        Route::put('user/update/data/{id} ', 'userUpdate')->name('admin.user.update');
        Route::delete('user/delete/{id}', 'userDestroy')->name('admin.user.delete');

        //create class
        Route::get('create/class', 'classIndex')->name('admin.create.class');
        Route::post('class/store', 'classStore')->name('admin.class.store');
        Route::get('get/class/data', 'classTableData')->name('admin.get.class.data');
        Route::get('get/class/edit/data/{id}', 'classEdit')->name('admin.get.class.edit');
        Route::put('class/update/data/{id} ', 'classUpdate')->name('admin.class.update');
        Route::delete('class/delete/{id}', 'classDestroy')->name('admin.class.delete');


        //create subject
        Route::get('create/subject', 'subjectIndex')->name('admin.create.subject');
        Route::post('subject/store', 'subjectStore')->name('admin.subject.store');
        Route::get('get/subject/data', 'subjectTableData')->name('admin.get.subject.data');
        Route::get('get/subject/edit/data/{id}', 'subjectEdit')->name('admin.get.subject.edit');
        Route::put('subject/update/data/{id} ', 'subjectUpdate')->name('admin.subject.update');
        Route::delete('subject/delete/{id}', 'subjectDestroy')->name('admin.subject.delete');

        //create seller
        Route::get('create/selller', 'createSeller')->name('admin.create.seller');
        Route::post('seller/store', 'sellerStore')->name('admin.selller.store');
        Route::get('get/seller/', 'sellerTableData')->name('admin.get.seller.data');
        Route::get('get/seller/edit/data/{id}', 'sellerEdit')->name('admin.get.seller.edit');
        Route::put('seller/update/data/{id} ', 'sellerUpdate')->name('admin.seller.update');
        Route::delete('seller/delete/{id}', 'sellerDestroy')->name('admin.seller.delete');




        //expanse category
        Route::get('account/create', 'transferTableData')->name('admin.account.create');
        Route::get('account/deposit/create', 'transferTableData')->name('admin.account.deposit');
        Route::get('account/expense', 'transferTableData')->name('admin.account.expense');
        Route::get('account/expense/category', 'transferTableData')->name('admin.account.expense.category');



        //sell
        Route::get('sell/book', 'createSell')->name('admin.sell.book');
        Route::post('sell/book/store', 'sellStore')->name('admin.sell.store');
        Route::get('get/sell/book/data/list', 'sellTableData')->name('admin.get.sell.data');
        Route::get('get/sell/book/edit/data/{id}', 'sellEdit')->name('admin.get.sell.edit');
        Route::put('sell/book/update/data/{id} ', 'sellUpdate')->name('admin.sell.update');
        Route::delete('sell/book/delete/{id}', 'sellDestroy')->name('admin.sell.delete');
        Route::any('sell/invoice/{id}', 'sellInvoice')->name('admin.sell.invoice');





    });


    Route::prefix('distributor')->middleware('auth', 'distributor')->controller(distributorController::class)->group(function () {

        Route::get('dashboard', function () {
            return view('distributorPanel/dashboard');
        })->name('distributor.dashboard');

    });

});





Route::get('/', function () {
    return redirect('login');
});

// Route::get('/', function () {
//     return view('userPanel/dashboard');
// });

Route::post('user/msg/store', 'App\Http\Controllers\userPanel\homeController@store')->name('user.msg');

