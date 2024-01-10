<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaxPostingSetupResource;
use App\Models\TaxPostingGroup;
use App\Models\TaxPostingSetup;
use Illuminate\Http\Request;
use App\Services\SearchQueryService;
class TaxPostingSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


         $queryBuilder = TaxPostingSetup::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['identifier', 'tax_rate'];
            $strictColumns = [];
            $relatedModels = [];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], $relatedModels);

            $setups = TaxPostingSetupResource::collection($searchService
                            //   ->withSum(['salesOrderLines'=>'amount'])
                              ->with(['itemTaxGroup','busTaxGroup'])
                            ->search()->latest()->paginate($rows));

            $item_tax_groups=TaxPostingGroup::where('type','item')->select('id','code')->get();
            $bus_tax_groups=TaxPostingGroup::where('type','business')->select('id','code')->get();

            return inertia('TaxPostingSetup/List',compact('setups','item_tax_groups','bus_tax_groups'));
    }


    private function validateRequest(Request $request)
    {
        $request->validate(['bus_tax_group_id'=>'required',
                            'item_tax_group_id'=>'required',
                            'tax_rate'=>'required',
                            'tax_identifier'=>'required|unique:tax_posting_setups,tax_identifier,except,id'
                            ]);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        TaxPostingSetup::create($request->all());
        return redirect(route('taxPostingSetups.index'));

    }

    public function update(Request $request, string $id)
    {
        $setup=TaxPostingSetup::find($id);
        $this->validateRequest($request);
        $setup->update($request->all());
        return redirect(route('taxPostingSetups.index'));

    }

    public function destroy(string $id)
    {
        $setup=TaxPostingSetup::find($id);
        //check if it has any posted data
        $setup->delete();
        return redirect(route('taxPostingSetups.index'));
    }
}
