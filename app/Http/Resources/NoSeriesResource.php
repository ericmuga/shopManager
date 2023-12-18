<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoSeriesResource extends JsonResource
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
            'series_code'=>$this->series_code,
            'last_no_used'=>$this->last_no_used,
            'last_date_used'=>Carbon::parse($this->last_date_used)->toDateString(),
            'last_no_used'=>$this->last_no_used,
            'document_type'=>$this->document_type,
            'characters'=>$this->characters,
        ];
    }
}
