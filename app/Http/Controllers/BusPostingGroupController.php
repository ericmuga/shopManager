<?php

namespace App\Http\Controllers;

use App\Http\Resources\BusPostingGroupResource;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
use App\Models\BusPostingGroup;
// BusPostingGroupResource
class BusPostingGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryBuilder = BusPostingGroup::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['code', 'description'];
            $strictColumns = [];
            $relatedModels = [
                                'relatedModel1' => ['related_column1', 'related_column2'],
                                'relatedModel2' => ['related_column3'],
                            ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], []);

            $posting_groups = BusPostingGroupResource::collection($searchService
                            //   ->with(['confirmations']) // Example of eager loading related models
                            ->search()->paginate($rows));



             return inertia('BusPostingGroup/List',compact('posting_groups'));
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
        //
           BusPostingGroup::create($request->all());
        return redirect(route('busPostingGroups.index'));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         BusPostingGroup::firstWhere('id',$request->id)?->update($request->all());
        return redirect (route('busPostingGroups.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        BusPostingGroup::firstWhere('id',$id)?->delete();
        return redirect(route('busPostingGroups.index'));
    }
}
