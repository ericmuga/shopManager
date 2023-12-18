<?php

namespace App\Http\Controllers;

use App\Models\NoSeries;
use App\Http\Requests\StoreNoSeriesRequest;
use App\Http\Requests\UpdateNoSeriesRequest;
use App\Http\Resources\NoSeriesResource;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;

class NoSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //list
        $queryBuilder = NoSeries::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['code'];




            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], []);

            $series = NoSeriesResource::collection($searchService
                                            // ->with(['posting_group.code']) // Example of eager loading related models
                                            ->search()->paginate($rows));

        // dd($series);
        return inertia('Series/List',compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        NoSeries::create($request->all());
            return redirect(route('series.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(NoSeries $noSeries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NoSeries $noSeries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($id);
          NoSeries::firstWhere('id',$id)?->update($request->all());
        return redirect (route('series.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      NoSeries::firstWhere('id',$id)?->delete();
        return redirect(route('series.index'));
    }
}
