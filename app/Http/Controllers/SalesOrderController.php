<?php

namespace App\Http\Controllers;

use App\Models\{Customer,SalesOrder,Item};
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
use App\Http\Resources\SalesOrderResource;
class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $queryBuilder = SalesOrder::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['document_no', 'ext_doc_no'];
            $strictColumns = [];
            $relatedModels = [
                                'customer' => ['customer_name', 'phone_no'],

                              ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], $relatedModels);

            $orders = SalesOrderResource::collection($searchService
                              ->withSum(['salesOrderLines'=>'amount'])
                            ->search()->paginate($rows));

        $customers=Customer::select('customer_name','id','bus_posting_group','tax_posting_group')->whereNot('blocked')->get();
        $items=Item::select('id','code','description','tax_group_id','item_posting_group')->whereNot('blocked')->get();

        return inertia('Sales/OrderList',compact('orders','customers'));
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
