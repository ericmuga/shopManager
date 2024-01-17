<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustmentLine extends Model
{
    use HasFactory;

    public function ItemEntry()
    {
        return $this->morphTo(ItemEntry::class,'documentable');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function inventory_adjustment_header()
    {
        return $this->belongsTo(InventoryAdjustmentHeader::class);
    }

}
