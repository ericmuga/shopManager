<?php

use App\Http\Controllers\{BusPostingGroupController, CustomerController,
                            CustomerEntryController,
                            DetailedItemEntryController,
                            InvoiceController,
                            InvoiceLineController,
                            ItemEntryController,
                            ItemPostingGroupController,
                            // OrderController,
                            // OrderLineController,
                            ProfileController, PurchaseOrderController, SalesOrderController, TaxPostingGroupController};

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/',fn()=>Auth::check()?redirect('dashboard'):redirect('login'));

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class);
    Route::resource('customerEntries',CustomerEntryController::class);
    Route::resource('detailedCustomerEntries',DetailedItemEntryController::class);

    Route::get('administration',function(){return inertia('Administration/Index');})->name('administration.index');
    Route::get('administration/posting-group',function(){return inertia('Administration/PostingGroups');})->name('administration.posting-groups');

    Route::resource('items', ItemController::class);
    Route::resource('itemEntries',ItemEntryController::class);
    Route::resource('itemPostingGroups',ItemPostingGroupController::class);
    Route::resource('detailedItemEntries',DetailedItemEntryController::class);


    Route::resource('taxPostingGroups',TaxPostingGroupController::class);
    Route::resource('busPostingGroups',BusPostingGroupController::class);


    // Route::resource('orders',OrderController::class);
    // Route::resource('orderLines',OrderLineController::class);


    ///////////////////////////Sales Routes//////////////////////////////////
    Route::get('sales',fn()=>inertia('Sales/Dashboard'))->name('sales.dashboard')->breadcrumb('sales');

    Route::resource('salesOrder', SalesOrderController::class);
    Route::get('get-logo',[SalesOrderController::class, 'convertImageToDataURL'])->name('convertLogo');
    Route::resource('purchaseOrder',PurchaseOrderController::class);






    Route::resource('invoices',InvoiceController::class);
    Route::resource('invoiceLines',InvoiceLineController::class);

require('auth.php');

    Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


});


