<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function scopeNotBlocked()
    {
        return $this->whereNot('blocked');
    }

    public function posting_group()
    {
        return $this->belongsTo(BusPostingGroup::class);
    }


}
