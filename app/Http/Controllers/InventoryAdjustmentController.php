<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoryAdjustmentResource;
use App\Models\InventoryAdjustmentHeader;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
class InventoryAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            $queryBuilder=InventoryAdjustmentHeader::latest();
            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['document_no','ext_document_no'];
            $strictColumns = [];
            $relatedModels = [];
            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, $strictColumns, $relatedModels);
            $inventoryAdjustments=InventoryAdjustmentResource::collection($searchService->search()->paginate(5));
            return inertia('InventoryAdjustments/List',compact('inventoryAdjustments'));
    }

    public function store(Request $request)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
