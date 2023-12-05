<?php

namespace App\Http\Resources;

use App\Models\SalesOrderLine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
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
            'document_no'=>$this->document_no,
            'value'=>SalesOrderLine::where('document_no',$this->document_no)->sum('amount'),
            'customer'=>$this->whenLoaded('customer'),
            'ext_doc_no'=>$this->ext_do_no,
            'tax_uuid'=>$this->tax_uuid,
            'status'=>$this->status,
            'posting_date'=>$this->posting_date,

        ];

    }
}
