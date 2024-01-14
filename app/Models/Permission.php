<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

  protected $guarded=[];

//    public function role(){
//     $this->belongsToMany(Role::class);
//    }

//    public function users()
//    {
//     return $this->belongsToMany(User::class);

//    }
}
