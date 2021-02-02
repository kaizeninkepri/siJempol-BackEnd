<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class perusahaan extends Model
{
    use HasFactory;
    protected $table = "perusahaan";
    protected $primaryKey = "perusahaan_id";

    protected $appends = ['fullname'];

  

    function getfullnameAttribute(){
        if(strtolower($this->kategori) == 'perorangan'){
        return Str::title($this->nama);
        }
        else{
        return strtoupper($this->kategori) .'. '. Str::title($this->nama);
        }
    }

    function pengurus(){
        return $this->hasMany(perusahaanPengurus::class,'perusahaan_id');
    }
}
