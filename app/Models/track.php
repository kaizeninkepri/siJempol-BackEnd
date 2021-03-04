<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class track extends Model
{
    use HasFactory;

    protected $table = "track";
    protected $primaryKey = "track_id";

    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    function petugas()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
