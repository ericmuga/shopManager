<?php

namespace App\Http\Resources;

use App\Models\ItemPostingGroup;
use App\Models\TaxPostingGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @return array<string, mixed>
    */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'code'=>$this->code,
            'description'=>$this->description,
            'search_name'=>$this->code.'|'.$this->description,
            'unit_price'=>$this->unit_price,
            'unit_cost'=>$this->unit_cost,
            'base_uom'=>$this->base_uom,
            'sales_uom'=>$this->sales_uom,
            'tax_group'=>$this->tax_posting_group->code,
            'posting_group'=>$this->item_posting_group_id->code,
            'blocked'=>$this->blocked?'Yes':'No',

        ];
    }
}
