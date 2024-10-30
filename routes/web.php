<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\AdminPanel\BookStorageController;
use App\Http\Controllers\AdminPanel\ClassManagementController;
use App\Http\Controllers\AdminPanel\CommonController;
use App\Http\Controllers\AdminPanel\PrintingPressController;
use App\Http\Controllers\AdminPanel\SellerAllInformationController;
use App\Http\Controllers\AdminPanel\StorageAlertController;
use App\Http\Controllers\AdminPanel\SubjectManagementController;
use App\Http\Controllers\AdminPanel\TransferToSellerController;
use App\Http\Controllers\AdminPanel\UserManagementController;
use App\Http\Controllers\DistributorController;
use Illuminate\Support\Facades\Route;
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
        } elseif (Auth::user()->role_id == 2) {
            return redirect()->route('distributor.dashboard');
        }
        return view('dashboard'); // Default user dashboard
    });




    // Admin Routes
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('dashboard', function () {
            return view('adminPanel/dashboard');
        })->name('admin.dashboard');

        Route::controller(AdminController::class)->group(function () {




            // Seller Management
            Route::get('create/seller', 'createSeller')->name('admin.create.seller');
            Route::post('seller/store', 'sellerStore')->name('admin.seller.store');
            Route::get('get/seller/data', 'sellerTableData')->name('admin.get.seller.data');
            Route::get('get/seller/edit/data/{id}', 'sellerEdit')->name('admin.get.seller.edit');
            Route::put('seller/update/data/{id}', 'sellerUpdate')->name('admin.seller.update');
            Route::delete('seller/delete/{id}', 'sellerDestroy')->name('admin.seller.delete');

            // Expense Category
            Route::get('account/create', 'transferTableData')->name('admin.account.create');
            Route::get('account/deposit/create', 'transferTableData')->name('admin.account.deposit');
            Route::get('account/expense', 'transferTableData')->name('admin.account.expense');
            Route::get('account/expense/category', 'transferTableData')->name('admin.account.expense.category');
        });


        // Sell Management
        Route::controller(TransferToSellerController::class)->group(function () {
            Route::get('sell/book', 'createSell')->name('admin.sell.book');
            Route::any('sell/book/store', 'sellStore')->name('admin.sell.store');
            Route::get('get/sell/book/data/list', 'sellTableData')->name('admin.get.sell.data');
            Route::get('get/sell/book/edit/data/{id}', 'sellEdit')->name('admin.get.sell.edit');
            Route::put('sell/book/update/data/{id}', 'sellUpdate')->name('admin.sell.update');
            Route::delete('sell/book/delete/{id}', 'sellDestroy')->name('admin.sell.delete');
            Route::any('sell/invoice/{id}', 'sellInvoice')->name('admin.sell.invoice');
        });



        // Common Routes
        Route::controller(CommonController::class)->group(function () {
            Route::get('get/subjects/{classId}', 'getSubjectsByClass');
            Route::get('get/seller/{sellerId}', 'getSellerUnpaidAmount');
            Route::get('get/unit/price/{unitPrice}', 'bookUnitPrice');
        });
        // Storage Alert
        Route::controller(StorageAlertController::class)->group(function () {
            Route::get('storage/alert', 'Index')->name('admin.storage.alert');
            Route::get('get/storage/data', 'Show')->name('admin.storage.data');
        });



        // Class Management
        Route::controller(ClassManagementController::class)->group(function () {
            Route::get('create/class', 'Index')->name('admin.create.class');
            Route::post('class/store', 'Store')->name('admin.class.store');
            Route::get('get/class/data', 'Show')->name('admin.get.class.data');
            Route::get('get/class/edit/data/{id}', 'Edit')->name('admin.get.class.edit');
            Route::put('class/update/data/{id}', 'Update')->name('admin.class.update');
            Route::delete('class/delete/{id}', 'Destroy')->name('admin.class.delete');
        });


        // Subject Management
        Route::controller(SubjectManagementController::class)->group(function () {
            Route::get('create/subject', 'Index')->name('admin.create.subject');
            Route::post('subject/store', 'Store')->name('admin.subject.store');
            Route::get('get/subject/data', 'Show')->name('admin.get.subject.data');
            Route::get('get/subject/edit/data/{id}', 'Edit')->name('admin.get.subject.edit');
            Route::put('subject/update/data/{id}', 'Update')->name('admin.subject.update');
            Route::delete('subject/delete/{id}', 'Destroy')->name('admin.subject.delete');
        });


        // User Management
        Route::controller(UserManagementController::class)->group(function () {
            Route::get('create/user', 'Index')->name('admin.create.user');
            Route::post('user/store', 'Store')->name('admin.user.store');
            Route::get('get/user/data', 'Show')->name('admin.get.user.data');
            Route::get('get/user/edit/data/{id}', 'Edit')->name('admin.get.user.edit');
            Route::put('user/update/data/{id}', 'Update')->name('admin.user.update');
            Route::delete('user/delete/{id}', 'Destroy')->name('admin.user.delete');
        });

        //book storage 
        Route::controller(BookStorageController::class)->group(function () {
            Route::get('store/book', 'Index')->name('admin.store.book');
            Route::post('store/book/store', 'Store')->name('admin.storage.book');
            Route::get('get/book/storage/data', 'Show')->name('admin.get.book.storage.data');
            Route::get('get/book/storage/edit/data/{id}', 'Edit')->name('admin.get.book.storage.edit');
            Route::put('store/book/update/data/{id}', 'Update')->name('admin.get.book.storage.update');
            Route::delete('store/book/delete/{id}', 'Destroy')->name('admin.book.storage.delete');
            Route::any('book/storage/invoice/{id}', 'Invoice')->name('admin.book.storage.invoice');
        });


        //priting press controller
        Route::controller(PrintingPressController::class)->group(function () {
            // Printing Press
            Route::get('printing/press', 'Index')->name('admin.printing.press');
            Route::post('add/printing/press', 'Store')->name('admin.printing.store');
            Route::get('get/printing/press/data', 'Show')->name('admin.get.printing.press.data');
            Route::get('get/printing/press/edit/data/{id}', 'Edit')->name('admin.get.printing.press.edit');
            Route::put('printing/press/update/data/{id}', 'Update')->name('admin.get.printing.press.update');
            Route::delete('printing/press/delete/{id}', 'Destroy')->name('admin.printing.press.delete');


            Route::get('printing/press/all/information', 'PrintingPressAllInformation')->name('admin.printing.press.all.information');
            Route::any('printing/press/filert/information', 'PrintingPressFilterInformation')->name('admin.printing.press.filter.information');
            Route::any('printing/press/infomation', 'getThisDetailsByMonth')->name('admin.get.print.press.infomation');
        });

        // Seller All Information Routes
        Route::controller(SellerAllInformationController::class)->group(function () {
            Route::get('seller/all/info', 'index')->name('admin.seller.all.info');
            Route::get('/users/{id}', 'show')->name('seller.show');
            Route::post('/users', 'store')->name('seller.store');
            Route::put('/users/{id}', 'update')->name('seller.update');
            Route::delete('/users/{id}', 'destroy')->name('seller.destroy');
        });
    });






    // Distributor Routes
    Route::prefix('distributor')->middleware('distributor')->controller(DistributorController::class)->group(function () {
        Route::get('dashboard', function () {
            return view('distributorPanel/dashboard');
        })->name('distributor.dashboard');
        // Add distributor-specific routes here...
    });
});





// Default route for redirecting to login
Route::get('/', function () {
    return redirect('login');
});

// User message store route
Route::post('user/msg/store', 'App\Http\Controllers\UserPanel\HomeController@store')->name('user.msg');
