<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class izin extends Model
{
    use HasFactory;
    protected $table = "opd_izin";
    protected $primaryKey = "opdi_id";
}
