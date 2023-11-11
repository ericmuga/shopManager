<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
   protected $guarded=['id'];
   public function posting_group()
   {
    return $this->belongsTo(ItemPostingGroup::class);
   }

}
