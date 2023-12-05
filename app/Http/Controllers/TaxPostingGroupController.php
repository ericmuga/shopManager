<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaxPostingSetupResource;
use App\Models\TaxPostingGroup;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
// use App\Traits\Searchable;

class TaxPostingGroupController extends Controller
{
//    use Searchable;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

           $searchParameter = $request->has('search')?$request->search:'';
            $rows=$request->rows?:10;
        $queryBuilder = TaxPostingGroup::query();

        $searchColumns = ['code', 'description','type'];
        $strictColumns = [];
        $relatedModels = [
            // 'customer' => ['customer_name', 'phone_no'],
        ];

        $withSum = [
            // 'salesOrderLines' => 'amount',
            // Additional related models and columns to be summed as needed
        ];

    $searchService = new SearchQueryService(
            $queryBuilder,
            $searchParameter,
            $searchColumns,

    );
        $posting_groups = TaxPostingSetupResource::collection($searchService->search()->paginate($rows));
      return inertia('TaxPostingGroup/List',compact('posting_groups'));

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
        TaxPostingGroup::create($request->all());
        return redirect(route('taxPostingGroups.index'));
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
        $group=TaxPostingGroup::find($id);
        $group->update($request->all());
        return redirect(route('taxPostingGroups.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       TaxPostingGroup::find($id)->delete();
       return redirect(route('taxPostingGroups.index'));
    }
}
