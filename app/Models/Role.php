<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

   protected $guarded=['id'];

//    public function permissions()
//    {
//      return $this->hasMany(Permission::class);
//    }

//    public function users()
//    {
//     return $this->belongsToMany(User::class);
//    }
}
