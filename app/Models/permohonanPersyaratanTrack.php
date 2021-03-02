<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permohonanPersyaratanTrack extends Model
{
    use HasFactory;
    protected $table = "permohonan_peryaratan_track";
    protected $primaryKey = "permohonan_peryaratan_track_id";
    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];
    protected $appends = ['variant'];

    function getvariantAttribute()
    {
        if ($this->status == 'true') {
            $variant = "success";
        } else {
            $variant = 'warning';
        }

        return $variant;
    }
}
