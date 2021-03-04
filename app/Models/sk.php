<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class sk extends Model
{
    use HasFactory;
    protected $table = 'st_sk';
    protected $primaryKey = 'stSK_id';
    protected $appends = ['objectUrl'];
    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    function getobjectUrlAttribute()
    {
        $permohonan = permohonan::with(['perusahaan'])->where("permohonan_id", $this->permohonan->permohonan_id)->first();
        return Storage::disk('ResourcesExternal')->url($permohonan->perusahaan->npwp . '/' .  $permohonan->permohonan_code . '/sk' . '/' . $this->file_sk);
    }

    function permohonan()
    {

        return $this->belongsTo(permohonan::class, 'permohonan_id');
    }
}
