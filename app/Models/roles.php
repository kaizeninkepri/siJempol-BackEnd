<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class roles extends Model
{
    use HasFactory;
    protected $table = "roles";
    protected $primaryKey = "role_id";
    protected $appends = ['Camel'];
    function permission(){
        return $this->hasMany(rolesPermission::class,'role_id');
    }

    function getCamelAttribute()
    {
        return Str::camel($this->role);
    }
}
