<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permohonanPersyaratan extends Model
{
    use HasFactory;
    protected $table = "permohonan_persyaratan";
    protected $primaryKey = "permohonan_persyaratanId";

    protected $appends = ['uploading'];

    function getuploadingAttribute()
    {
        return array(
            "text" => "Menunggu File di Upload",
            "upload" => "waiting",
            "icon" => "iconsminds-time-backup text-warning",
            "status" => false,
            "button" => true,
            "pratinjau" => true,
            "file" => null,
            "objectUrl" => null,
        );
    }
}
