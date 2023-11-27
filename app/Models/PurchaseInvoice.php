<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    public function purchaseInvoiceLines()
    {
        return $this->hasMany(PurchaseInvoiceLine::class)->orderBy('id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
