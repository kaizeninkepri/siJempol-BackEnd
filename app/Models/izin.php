<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class izin extends Model
{
    use HasFactory;
    protected $table = "opd_izin";
    protected $primaryKey = "opdi_id";
    protected $appends = ['idCrypt'];

    function getidCryptAttribute()
    {
        return Crypt::encryptString($this->opdi_id);
    }

    function persyaratan()
    {
        return $this->hasMany(persyaratan::class, 'opdi_id');
    }

    function opd()
    {
        return $this->belongsTo(opd::class, 'opd_id');
    }
}
