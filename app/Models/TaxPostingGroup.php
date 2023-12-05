<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
// use Awobaz\Compoships\Database\Eloquent\Model;
class TaxPostingGroup extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    // public function items()
    // {
    //     return $this->hasMany(Item::class,'tax_group','type')
    // }

    public function ScopeType(Builder $query,$type)
    {
        $query->where('type',$type);
    }

}
