<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\ItemEntry;
use App\Services\SearchQueryService;
use Illuminate\Http\Request;
use Locale;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $queryBuilder = Location::query();
            $rows=$request->rows?:10;
            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['code', 'description'];
            $strictColumns = [];
            $relatedModels = [];
            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, $strictColumns,$relatedModels);
            $locations = LocationResource::collection($searchService->search()->paginate($rows));
            return inertia('Location/List',compact('locations'));

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        Location::create($request->all());
        return redirect(route('locations.index'));
    }



    public function update(UpdateLocationRequest $request, Location $location)
    {
        $location->update($request->all());
       return redirect(route('locations.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //check if location has posted entries,
        if ($location->item_entries()->count()>0)
        {
            return response('The Location has posted item entires',500,[]);
        }
        else
         $location->delete();
         return redirect(route('locations.index'));

    }
}
