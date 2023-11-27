<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SearchQueryService;
use App\Models\{Customer, TaxPostingGroup};
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
            $tax_pgs=TaxPostingGroup::select('id','code')->get();



             return inertia('Customer/List',compact('customers','tax_pgs'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        // $customer= Customer::fistWhere('id',$request->id);
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
