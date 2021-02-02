<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class permohonan extends Model
{
    use HasFactory;
    protected $table = "permohonan";
    protected $primaryKey = "permohonan_id";
    protected $appends =['waktu','waktuClass','_showDetails','rowClass'];

    function getwaktuAttribute(){
       $days = Carbon::parse($this->updated_at)->diffInDays();
        if ($days < 7) {
            return Carbon::parse($this->updated_at)->diffForHumans();
        } else {
            // return "andi";
            return Carbon::parse($this->updated_at)->format('d/m/Y H:i');
        }
    }
    function getshowDetailsAttribute(){
        return false;
    }
    function getwaktuClassAttribute(){
       $days = Carbon::parse($this->updated_at)->diffInDays();
        if ($days < 7) {
            return false;
        } else {
            // return "andi";
            return true;
        }
    }
    function getrowClassAttribute(){
       $days = Carbon::parse($this->updated_at)->diffInDays();
        if ($days < 7) {
            return false;
        } else {
            // return "andi";
            return true;
        } 
    }
   

    function izin(){
        return $this->belongsTo(izin::class,'opdi_id');
    }

    function opd(){
        return $this->belongsTo(opd::class,'opd_id');
    }

    function pengurus(){
        return $this->belongsTo(perusahaanPengurus::class,'perusahaanp_id');
    }

    function perusahaan(){
        return $this->belongsTo(perusahaan::class,'perusahaan_id');
    }
}
