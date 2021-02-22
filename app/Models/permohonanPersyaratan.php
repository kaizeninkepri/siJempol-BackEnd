<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class permohonanPersyaratan extends Model
{
    use HasFactory;
    protected $table = "permohonan_persyaratan";
    protected $primaryKey = "permohonan_persyaratanId";
    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    protected $appends = ['uploading', 'verifikasi'];


    function getverifikasiAttribute()
    {
        if ($this->permohonan->status == 'pending') {
            return "Berkas Belum Dikirim";
        } else if (Str::lower($this->permohonan->status) == 'proses') {
            return "Front Office";
        } else if ($this->permohonan->status == 'keabsahan') {
            return "Back Office";
        } else if ($this->permohonan->status == 'tekniskirim') {
            return "OPD Teknis";
        } else if ($this->permohonan->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->permohonan->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->status == 'teknis') {
            return "OPD Teknis";
        } else if ($this->permohonan->status == 'selesai') {
            return "selesai";
        } else if ($this->permohonan->status == 'selesaiNoScan') {
            return "Back Office";
        } else if ($this->permohonan->status == 'selesaaiScan') {
            return "Selesai Belum di Ambil";
        } else if ($this->permohonan->status == 'tolak') {
            return "permohonan - berkas di tolak";
        }
    }

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
