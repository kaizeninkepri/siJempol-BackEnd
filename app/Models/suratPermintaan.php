<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class suratPermintaan extends Model
{
    use HasFactory;
    protected $table = 'surat_permintaan';
    protected $primaryKey = 'surat_permintaan_id';
    protected $appends = ['objectUrl'];
    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    function getobjectUrlAttribute()
    {
        $permohonan = permohonan::with(['perusahaan'])->where("permohonan_id", $this->permohonan->permohonan_id)->first();
        return Storage::disk('ResourcesExternal')->url($permohonan->perusahaan->npwp . '/' .  $permohonan->permohonan_code . '/surat' . '/' . $this->file);
    }

    function permohonan()
    {

        return $this->belongsTo(permohonan::class, 'permohonan_id');
    }
}
