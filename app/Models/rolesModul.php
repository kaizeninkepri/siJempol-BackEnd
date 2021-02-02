<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class rolesModul extends Model
{
    use HasFactory;
    protected $table = "roles_modul";
    protected $primaryKey = "role_modul_id";
    protected $appends = ['urlName'];


    public function geturlNameAttribute(){
        $slug = Str::slug($this->url);
        return Str::of($slug)->camel();
    }

    function permission(){
        return $this->hasOne(rolesPermission::class,'role_modul_id');
    }
}
