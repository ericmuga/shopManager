<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $table='sales_orders';

    protected $guarded=['id'];
    public function salesOrderLines()
    {
        return $this->hasMany(SalesOrderLine::class)->orderBy('id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
