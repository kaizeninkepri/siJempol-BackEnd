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

    protected $appends = ['uploading', 'verifikasi', 'BackOffice', 'Opd', 'InternVerifikasi', 'frontOffice'];


    function getBackOfficeAttribute()
    {
        $track = $this->track->where('role', 'Back Office');
        if (count($track) > 0) {
            return array(
                "items" => $track,
                "code" => "200",
                "class" => "simple-icon-check font-weight-bold",
                "text" => "Berkas Sudah Di Verifikasi Back Office",
                "variant" => "success"
            );
        } else {
            return array(
                "items" => $track,
                "code" => "500",
                "class" => "iconsminds-folder-close font-weight-bold",
                "text" => "Berkas Belum Di Verifikasi Back Office",
                "variant" => "danger"
            );
        }
    }
    function getOpdAttribute()
    {
        $track = $this->track->where('role', 'Opd');
        if (count($track) > 0) {
            return array(
                "items" => $track,
                "code" => "200",
                "class" => "simple-icon-check font-weight-bold",
                "text" => "Berkas Sudah Di Verifikasi OPD",
                "variant" => "success"
            );
        } else {
            return array(
                "items" => $track,
                "code" => "500",
                "class" => "iconsminds-folder-close font-weight-bold",
                "text" => "Berkas Belum Di Verifikasi Opd",
                "variant" => "danger"
            );
        }
    }

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

    function getInternVerifikasiAttribute()
    {
        if ($this->status == 'tolak') {
            $variant = 'warning';
        } else if ($this->status == 'terima-catatan') {
            $variant = 'info';
        } else {
            $variant = 'success';
        }

        if ($this->status == 'waiting-upload') {
            return array(
                "value" => "pending",
                "variant" => 'warning',
                "text" => 'Pemohon Belum Upload Berkas',
                "show" => false,
                "verifikasi" => false,
            );
        } else if ($this->status === 'uploaded') {
            return array(
                "value" => "uploaded",
                "variant" => 'danger',
                "text" => 'Berkas Belum Di Verifikasi',
                "show" => false,
                "verifikasi" => false
            );
        } else {
            return array(
                "value" => $this->status,
                "variant" => $variant,
                "text" => $this->catatan,
                "show" => false,
                "verifikasi" => true
            );
        }
    }
    function permohonan()
    {
        return $this->belongsTo(permohonan::class, 'permohonan_id');
    }
    function getfrontOfficeAttribute()
    {
        $track = $this->track->where('role', 'Front Office');
        if (count($track) > 0) {
            return array(
                "items" => $track,
                "code" => "200",
                "class" => "simple-icon-check font-weight-bold",
                "text" => "Berkas Sudah Di Verifikasi ",
                "variant" => "success"
            );
        } else {
            return array(
                "items" => $track,
                "code" => "500",
                "class" => "iconsminds-folder-close font-weight-bold",
                "text" => "Berkas Belum Di Verifikasi Back Office",
                "variant" => "danger"
            );
        }
    }
    function track()
    {
        return $this->hasMany(permohonanPersyaratanTrack::class, 'permohonan_persyaratanId');
    }
}
