<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use Illuminate\Http\Request;
use App\Models\{Item, ItemPostingGroup, TaxPostingGroup};
use App\Http\Resources\{ItemPostingGroupResource, ItemResource, TaxPostingGroupResource};
use App\Services\SearchQueryService;
  use Illuminate\Support\Facades\Cache;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     *
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
                                            // ->with(['tax_posting_group.code','item_posting_group.code']) // Example of eager loading related models
                                            ->search()->paginate($rows));


            $posting_groups=ItemPostingGroupResource::collection(ItemPostingGroup::orderBy('code')->get());

            $tax_groups=TaxPostingGroupResource::collection(TaxPostingGroup::where('type','item')->select('id','code')->get());

            // dd($posting_groups);
             return inertia('Item/List',compact('items','posting_groups','tax_groups'));
    }





    public function list()
    {
        $items=ItemResource::collection(Item::whereNot('blocked')->get());
         return response()->json(compact('items'));
    }


    public function store(StoreItemRequest $request)
    {
        // $this->validateRequest($request);PItem
        Item::create($request->all());
        Cache::forget('items');
       return redirect(route('items.index'));
    }

    public function update(UpdateItemRequest $request, string $id)
    {

       Item::firstWhere('id',$request->id)?->update($request->all());
       Cache::forget('items');
        return redirect (route('items.index'));
    }
    public function destroy(string $id)
    {
        Item::firstWhere('id',$id)?->delete();
        Cache::forget('items');
        return redirect(route('items.index'));
    }

}
