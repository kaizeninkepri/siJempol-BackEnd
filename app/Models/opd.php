<?php

namespace App\Models;

use App\Http\Controllers\izinControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opd extends Model
{
    use HasFactory;
    protected $table = "opd";
    protected $primaryKey = "opd_id";
    // public $appends = ['januari', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'des'];

    function getjanuariAttribute()
    {
        return null;
    }
    function getfebAttribute()
    {
        return null;
    }
    function getmarAttribute()
    {
        return null;
    }
    function getaprAttribute()
    {
        return null;
    }
    function getmeiAttribute()
    {
        return null;
    }
    function getjunAttribute()
    {
        return null;
    }
    function getjulAttribute()
    {
        return null;
    }
    function getaugAttribute()
    {
        return null;
    }
    function getsepAttribute()
    {
        return null;
    }
    function getoktAttribute()
    {
        return null;
    }
    function getnovAttribute()
    {
        return null;
    }
    function getdesAttribute()
    {
        return null;
    }


    function izin()
    {
        return $this->hasMany(izin::class, 'opd_id');
    }

    function permohonan()
    {
        return $this->hasMany(permohonan::class, 'permohonan_id');
    }

    function laporan()
    {
        $this->hasMany(permohonan::class, 'permohonan_id');
        return  $data = array(
            "januari" => array("bulan" => permohonan::whereMonth('created_at', '01')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "feb" => array("bulan" => permohonan::whereMonth('created_at', '02')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "mar" => array("bulan" => permohonan::whereMonth('created_at', '03')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "apr" => array("bulan" => permohonan::whereMonth('created_at', '04')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "mei" => array("bulan" => permohonan::whereMonth('created_at', '05')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "jun" => array("bulan" => permohonan::whereMonth('created_at', '06')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "jul" => array("bulan" => permohonan::whereMonth('created_at', '07')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "aug" => array("bulan" => permohonan::whereMonth('created_at', '08')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "sep" => array("bulan" => permohonan::whereMonth('created_at', '09')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "okt" => array("bulan" => permohonan::whereMonth('created_at', '10')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "nov" => array("bulan" => permohonan::whereMonth('created_at', '11')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
            "des" => array("bulan" => permohonan::whereMonth('created_at', '12')->whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $this->opd_id)->get()),
        );
    }
}
