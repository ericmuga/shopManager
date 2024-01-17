<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoSeries extends Model
{
    use HasFactory;
   protected $guarded=['id'];
   protected $table='no_series';

   public function item_posting_groups()
   {
    return $this->hasMany(ItemPostingGroup::class)->where('type','item');
   }

   public function customer_posting_groups()
   {
     return $this->hasMany(BusPostingGroup::class)->where('type','customer');
   }
   public function vendor_posting_groups()
   {
     return $this->hasMany(BusPostingGroup::class)->where('type','vendor');
   }


}
