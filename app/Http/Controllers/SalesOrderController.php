<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\{Customer,SalesOrder,Item,NoSeries,CompanySetup, SalesOrderLine, TaxPostingGroup,ItemPostingGroup,BusPostingGroup};
use Illuminate\Http\Request;
use App\Services\{SearchQueryService,MyServices};
use App\Http\Resources\SalesOrderResource;
use Carbon\Carbon;
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
                                'customer' => ['customer_name', 'phone_number','email'],

                              ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], $relatedModels);

            $orders = SalesOrderResource::collection($searchService
                            //   ->withSum(['salesOrderLines'=>'amount'])
                              ->with(['customer'])
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



           $serial=NoSeries::firstWhere('document_type','Sales Invoice');
           $serial->last_no_used=$request->document_no;
           $serial->save();

          $order= SalesOrder::create([
            'customer_id'=>$request->customer_id,
            'document_no'=>$request->document_no,
            'posting_date'=>Carbon::parse($request->posting_date)->toDateString(),
            'user_id'=>$request->user()->id,
            'status'=>'posted',
            'ext_doc_no'=>'',
            'tax_uuid'=>'',

           ]);




        foreach($request->orderLines as $line)
        {
            $item=Item::firstWhere('code',$line['itemName']);
            $customer = Customer::find($request->customer_id);
            SalesOrderLine::create([
                'item_id'=>$item->id,
                'unit_price'=>$line['price'],
                'document_no'=>$order->document_no,
                'ext_doc_no'=>$order->ext_doc_no,
                'quantity'=>$line['quantity'],
                'uom'=>$item->sales_uom,
                'item_tax_group'=>TaxPostingGroup::find($item->tax_group_id)->code,
                'item_posting_group'=>ItemPostingGroup::find($item->item_posting_group_id)->code,
                'customer_posting_group'=>BusPostingGroup::find($customer->bus_posting_group_id)->code,
                'customer_tax_group'=>1,
                'vat_percent'=>0.16,
                'amount'=>$line['quantity']*$line['price'],
                'amount_inc_vat'=>$line['quantity']*$line['price']*1.16,
                'sales_order_id'=>$order->id,

            ]);
        }

        //create item lines


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
