<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Item, ItemPostingGroup, TaxPostingGroup};
use App\Http\Resources\{ItemPostingGroupResource, ItemResource, TaxPostingGroupResource};
use App\Services\SearchQueryService;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryBuilder = Item::query();
            $rows=$request->rows?:10;


            $searchParameter = $request->has('search')?$request->search:'';
            $searchColumns = ['code', 'description'];
            $strictColumns = [];
            $relatedModels = [
                                'relatedModel1' => ['related_column1', 'related_column2'],
                                'relatedModel2' => ['related_column3'],
                            ];



            $searchService = new SearchQueryService($queryBuilder, $searchParameter, $searchColumns, [], []);

            $items = ItemResource::collection($searchService
                                            ->with(['posting_group.code']) // Example of eager loading related models
                                            ->search()->paginate($rows));


            $posting_groups=ItemPostingGroupResource::collection(ItemPostingGroup::orderBy('code')->get());

            $tax_groups=TaxPostingGroupResource::collection(TaxPostingGroup::where('type','item')->select('id','code')->get());

            // dd($posting_groups);
             return inertia('Item/List',compact('items','posting_groups','tax_groups'));
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

    private function validateRequest(Request $request)
    {
         $request->validate([
            'type'=>'required',
            'code'=>['required','unique:items,code'],
            'description'=>['required','unique:items,description'],
            'sales_uom'=>'required',
            'base_uom'=>'required',
            'unit_price'=>'required',
            'unit_cost'=>'required',
            'item_posting_group_id'=>'required',
            'tax_group_id'=>'required',

         ]);
    }


    public function list()
    {
                $items=ItemResource::collection(Item::whereNot('blocked')->get());
            return response()->json(compact('items'));
    }


    public function store(Request $request)
    {
        $this->validateRequest($request);
        Item::create($request->all());
            return redirect(route('items.index'));
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
    public function update(Request $request, string $id)
    {
           $this->validateRequest($request);
       Item::firstWhere('id',$request->id)?->update($request->all());
        return redirect (route('items.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::firstWhere('id',$id)?->delete();
        return redirect(route('items.index'));
    }
}
