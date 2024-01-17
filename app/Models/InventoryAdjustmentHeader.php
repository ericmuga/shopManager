<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustmentHeader extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function lines()
    {
        return $this->hasMany(InventoryAdjustmentLine::class);
    }
}
