<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemEntry extends Model
{
    use HasFactory;

    public function documentable()
    {

        //one item entry can belong to a sales invoice line, or inventory adjustment line, or purchase invoice line
        return $this->morphTo();
    }


}
