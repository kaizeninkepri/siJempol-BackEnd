<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persyaratan extends Model
{
    use HasFactory;
    protected $table = "opd_persyaratan";
    protected $primaryKey = "opdp_id";
    protected $appends = ['uploading'];

    function getuploadingAttribute()
    {
        return array(
            "text" => "Menunggu File di Upload",
            "upload" => "waiting",
            "icon" => "iconsminds-time-backup",
        );
    }
}
