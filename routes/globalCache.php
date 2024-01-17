<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalCacheController;

Route::get('cachedItems',[GlobalCacheController::class,'fetchItems'])->name('cached.items');
Route::get('cachedLocations',[GlobalCacheController::class,'fetchLocations'])->name('cached.locations');


?>
