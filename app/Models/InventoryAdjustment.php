<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    use HasFactory;

    public function ItemEntry()
    {
        return $this->morphTo(ItemEntry::class,'documentable');
    }

}
