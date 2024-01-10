<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaxPostingSetupResource extends JsonResource
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
             'itemTaxGroup'=>$this->whenLoaded('itemTaxGroup'),
             'busTaxGroup'=>$this->whenLoaded('busTaxGroup'),
             'tax_identifier'=>$this->tax_identifier,
             'tax_rate'=>$this->tax_rate,
        ];
    }

}
