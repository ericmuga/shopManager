<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Http\Resources\LocationResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\{Location,Item};

class GlobalCacheController extends Controller
{


public function fetchLocations()
{
    // Cache::forget('locations');
    return Cache::remember('locations', now()->addDay(1), function () {
        return LocationResource::collection(Location::whereNot('blocked')->get()); // Replace with your actual query
    });
}

public function fetchItems()
{
    return Cache::remember('items', now()->addDay(1), function () {
        return ItemResource::collection(Item::whereNot('blocked')->get());
    });
}

}

