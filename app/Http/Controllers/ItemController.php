<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Item, ItemPostingGroup};
use App\Http\Resources\{ItemPostingGroupResource, ItemResource};
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
                            //   ->with(['confirmations']) // Example of eager loading related models
                            ->search()->paginate($rows));
            $posting_groups=ItemPostingGroupResource::collection(ItemPostingGroup::orderBy('code')->get());


            // dd($posting_groups);
             return inertia('Item/List',compact('items','posting_groups'));
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
