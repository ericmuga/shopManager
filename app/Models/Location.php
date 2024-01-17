<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
     use HasFactory;

     protected $guarded=['id'];

     public function item_entries()
     {
        return $this->hasMany(ItemEntry::class);
     }

     public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
