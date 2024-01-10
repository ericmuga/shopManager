<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxPostingSetup extends Model
{
    use HasFactory;
    protected $guarded=['id'];


    public function itemTaxGroup()
    {
        return $this->belongsTo(TaxPostingGroup::class)->where('type','item');
    }

    public function busTaxGroup()
    {
        return $this->belongsTo(TaxPostingGroup::class)->where('type','business');
    }
}
