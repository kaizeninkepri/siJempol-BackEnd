<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengurus extends Model
{
    use HasFactory;

    protected $table = "perusahaan_pemohon";
    protected $primaryKey = "perusahaanp_id";
}
