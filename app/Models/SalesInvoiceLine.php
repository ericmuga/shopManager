<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceLine extends Model
{
    use HasFactory;

   public function documentable()
   {
    return $this->morphTo(ItemEntry::class,'documentable');
   }
}
