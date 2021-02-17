<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class permohonanPersyaratan extends Model
{
    use HasFactory;
    protected $table = "permohonan_persyaratan";
    protected $primaryKey = "permohonan_persyaratanId";

    protected $appends = ['uploading'];

    function getuploadingAttribute()
    {

        $permohonan = permohonan::with(['perusahaan'])->where("permohonan_id", $this->permohonan->permohonan_id)->first();

        return array(
            "text" => $this->file != null ? "Berkas " . $this->persyaratan . " Telah Di Unggah" : "Menunggu File di Upload",
            "upload" => $this->status,
            "icon" => $this->file != null ? "iconsminds-check text-success" : "iconsminds-time-backup text-warning",
            "status" => false,
            "button" => true,
            "pratinjau" => $this->file != null ? false : true,
            "file" => null,
            "objectUrl" => $this->file != null ? Storage::disk('ResourcesExternal')->url($permohonan->perusahaan->npwp . '/' .  $permohonan->permohonan_code . '/persyaratan' . '/' . $this->file) : null,
            "progressBar" => 0
        );
    }

    function permohonan()
    {
        return $this->belongsTo(permohonan::class, 'permohonan_id');
    }
}
