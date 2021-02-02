<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rolesPermission extends Model
{
    use HasFactory;
    protected $table = "roles_permission";
    protected $primaryKey = "role_permission_id";

    function modul(){
        return $this->belongsTo(rolesModul::class,"role_modul_id");
    }
}
