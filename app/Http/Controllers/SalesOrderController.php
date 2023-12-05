<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\{Customer,SalesOrder,Item,NoSeries,CompanySetup};
use Illuminate\Http\Request;
use App\Services\{SearchQueryService,MyServices};
use App\Http\Resources\SalesOrderResource;
use Illuminate\Support\Facades\File;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function convertImageToDataURL()
    {
        $imagePath = public_path('img/logo.jpg');
        $imageData = base64_encode(File::get($imagePath));
        $dataUrl = 'data:image/jpeg;base64,' . $imageData;

        return response()->json(['dataUrl' => $dataUrl]);
    }

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

        $customers=Customer::select('customer_name','id','bus_posting_group_id','tax_posting_group_id')->whereNot('blocked')->get();
        $items=ItemResource::collection(Item::whereNot('blocked')->get());
        $companyInfo=CompanySetup::first();

        $lastSerialNo=MyServices::incrementSerialNumber(NoSeries::first()->last_no_used);


        return inertia('Sales/OrderList',compact('orders','customers','items','lastSerialNo','companyInfo'));
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
        dd($request->all());
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
