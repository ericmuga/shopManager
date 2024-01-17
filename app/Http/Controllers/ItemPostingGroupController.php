<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemPostingGroupResource;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
use App\Models\ItemPostingGroup;
use App\Models\NoSeries;

class ItemPostingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

            $queryBuilder = ItemPostingGroup::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['code', 'description'];
            $strictColumns = [];
            $relatedModels = [
                                'relatedModel1' => ['related_column1', 'related_column2'],
                                'relatedModel2' => ['related_column3'],
                            ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], []);

            $no_series= NoSeries::select('series_code','id')->where('type','item')->get();

            $posting_groups = ItemPostingGroupResource::collection($searchService
                            //   ->with(['confirmations']) // Example of eager loading related models
                            ->search()->paginate($rows));



             return inertia('ItemPostingGroup/List',compact('posting_groups','no_series'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ItemPostingGroup::create($request->all());
        return redirect(route('itemPostingGroups.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        ItemPostingGroup::firstWhere('id',$request->id)?->update($request->all());
        return redirect (route('itemPostingGroups.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         ItemPostingGroup::firstWhere('id',$id)?->delete();
        return redirect(route('itemPostingGroups.index'));
    }
}
