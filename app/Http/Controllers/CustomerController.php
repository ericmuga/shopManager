<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SearchQueryService;
use App\Models\{BusPostingGroup, Customer, TaxPostingGroup};
use App\Http\Resources\{CustomerResource};
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //seaarchable List of customers


            $queryBuilder = Customer::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['customer_name', 'phone_number','email'];
            $strictColumns = [];
            $relatedModels = [
                                'relatedModel1' => ['related_column1', 'related_column2'],
                                'relatedModel2' => ['related_column3'],
                            ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], []);

            $customers = CustomerResource::collection($searchService->search()->paginate($rows));
            $tax_pgs=TaxPostingGroup::select('id','code')->where('type','Business')->get();
            $bus_pgs=BusPostingGroup::select('id','code')->where('type','Customer')->get();



             return inertia('Customer/List',compact('customers','tax_pgs','bus_pgs'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    private function validateRequest(Request $request)
    {
        $request->validate(
            ['customer_name'=>'required',
             'phone_number'=>'required',
             'bus_posting_group_id'=>'required',
             'tax_posting_group_id'=>'required',
             'id_no'=>'required',
            ]
        );
    }
    public function store(Request $request)
    {  $this->validateRequest($request);

        Customer::create($request->all());
        return redirect(route('customers.index'));
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
        $this->validateRequest($request);

         Customer::firstWhere('id_no',$request->id_no)?->update($request->all());
        return redirect (route('customers.index'));
        //$customer->update([$request->all()->except('id')]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Customer::firstWhere('id',$id)?->delete();
        return redirect(route('customers.index'));
    }
}
