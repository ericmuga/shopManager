<?php

namespace App\Http\Resources;
use App\Models\InventoryAdjustmentHeader;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryAdjustmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
               'status'=>$this->status,
               'user'=>$this->user->name,
               'entry_type'=>$this->entry_type,
               'posting_date'=>$this->posting_date,
               'document_no'=>$this->document_no,
               'ext_doc_no'=>$this->ext_doc_no,
               'cost_amount'=>$this->lines()->sum('cost_amount'),
               'sales_amount'=>$this->lines()->sum('sales_amount'),
        ];
    }
}
