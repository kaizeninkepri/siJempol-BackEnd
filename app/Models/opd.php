<?php

namespace App\Models;

use App\Http\Controllers\izinControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opd extends Model
{
    use HasFactory;
    protected $table = "opd";
    protected $primaryKey = "opd_id";

    function izin()
    {
        return $this->hasMany(izinControl::class, 'opd_id');
    }
}
