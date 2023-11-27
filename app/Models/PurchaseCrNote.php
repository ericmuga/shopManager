<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseCrNote extends Model
{
    use HasFactory;
    public function purchaseCrLines()
    {
        return $this->hasMany(PurchaseCrLine::class)->orderBy('id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
