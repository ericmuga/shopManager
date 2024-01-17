<?php

namespace App\Http\Resources;

use App\Models\ItemEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'blocked'=>$this->blocked?'Yes':'No',
            'ledgerLines'=>$this->whenLoaded(ItemEntry::class),

        ];
    }
}
