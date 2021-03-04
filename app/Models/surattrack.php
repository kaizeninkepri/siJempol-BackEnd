<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surattrack extends Model
{
    use HasFactory;
    protected $table = "track_surat";
    protected $primaryKey = "track_surat_id";
}
