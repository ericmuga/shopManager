<?php

use App\Http\Controllers\{BusPostingGroupController, CustomerController,
                            CustomerEntryController,
                            DetailedItemEntryController,
                            InvoiceController,
                            InvoiceLineController,
                            ItemEntryController,
                            ItemPostingGroupController,
    NoSeriesController,
    // OrderController,
                            // OrderLineController,
                            ProfileController, PurchaseOrderController, SalesOrderController, TaxPostingGroupController};

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;
use App\Models\Customer;
use Glhd\Gretel\View\Breadcrumbs;
use App\Http\Controllers\SalesController;
use App\Models\Item;

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

Route::get('/',fn()=>Auth::check()?redirect('dashboard'):redirect('login'));

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('customers', CustomerController::class)->breadcrumbs([
                                                                            'index' => 'Customers',
                                                                            'create' => 'New Customer',
                                                                            'show' => fn(Customer $customer) => $customer->name,
                                                                            'edit' => 'Edit',
                                                                        ]);



    Route::resource('customerEntries',CustomerEntryController::class);
    Route::resource('detailedCustomerEntries',DetailedItemEntryController::class);

    Route::get('administration',function(){return inertia('Administration/Index');})->name('administration.index');
    Route::get('administration/posting-group',function(){return inertia('Administration/PostingGroups');})->name('administration.posting-groups');

    Route::resource('items', ItemController::class)->breadcrumbs([
                                                                            'index' => 'Items',
                                                                            'create' => 'New Item',
                                                                            'show' => fn(Item $item) => $item->name,
                                                                            'edit' => 'Edit',
                                                                        ]);
    Route::resource('itemEntries',ItemEntryController::class);
    Route::resource('itemPostingGroups',ItemPostingGroupController::class)->breadcrumbs(['Item Posting Groups','items.index']);
;
    Route::resource('detailedItemEntries',DetailedItemEntryController::class);


    Route::resource('taxPostingGroups',TaxPostingGroupController::class);
    Route::resource('busPostingGroups',BusPostingGroupController::class);

    // routes/web.php



Route::get('/sales-summary', [SalesController::class, 'index'])->name('sales.summary')->breadcrumb('Sales Summary');


    // Route::resource('orders',OrderController::class);
    // Route::resource('orderLines',OrderLineController::class);


    ///////////////////////////Sales Routes//////////////////////////////////
    Route::get('sales',fn()=>inertia('Sales/Dashboard'))->name('sales.dashboard')->breadcrumb('sales');

    Route::resource('salesOrder', SalesOrderController::class);
    Route::get('get-logo',[SalesOrderController::class, 'convertImageToDataURL'])->name('convertLogo');
    Route::resource('purchaseOrder',PurchaseOrderController::class);






    Route::resource('invoices',InvoiceController::class);
    Route::resource('invoiceLines',InvoiceLineController::class);

    Route::resource('series',NoSeriesController::class);

    Route::get('/fonts/{filename}', function ($filename) {
            $path = public_path('fonts/' . $filename);

            if (file_exists($path)) {
                return response(null,200,['Content-Type'=>'application/octet-stream'])->file($path);
            }

            return response('Font not found', 404);
        })->where('filename', '.*');



});


require('auth.php');
