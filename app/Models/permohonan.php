<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class permohonan extends Model
{
    use HasFactory;
    protected $table = "permohonan";
    protected $primaryKey = "permohonan_id";
    protected $appends = ['waktu', 'waktuClass', '_showDetails', 'rowClass', 'OnStep', 'statusBerkas', 'idCrypt', 'TrackStatus'];
    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    function getTrackStatusAttribute()
    {
        $jumlah = count($this->persyaratanTrack);
        $jumlah > 0 && $this->status == 'pending' ? $variant = 'warning' : $variant = 'light';
        return array(
            "items" => $this->persyaratanTrack,
            "variant" => $variant,
            "count" => $jumlah,
        );
    }

    function getOnStepAttribute()
    {
        if ($this->status == 'pending') {
            return "Pemohon";
        } else if ($this->status == 'proses') {
            return "Front Office";
        } else if ($this->status == 'keabsahan') {
            return "Back Office";
        } else if ($this->status == 'tekniskirim') {
            return "OPD Teknis";
        } else if ($this->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->status == 'teknis') {
            return "OPD Teknis";
        } else if ($this->status == 'selesai') {
            return "selesai";
        } else if ($this->status == 'selesaiNoScan') {
            return "Back Office";
        } else if ($this->status == 'selesaaiScan') {
            return "Selesai Belum di Ambil";
        } else if ($this->status == 'tolak') {
            return "permohonan - berkas di tolak";
        }
    }
    function getstatusBerkasAttribute()
    {
        if ($this->status == 'pending') {
            return "Berkas Belum Dikirim";
        } else if (Str::lower($this->status) == 'proses') {
            return "Front Office";
        } else if ($this->status == 'keabsahan') {
            return "Back Office";
        } else if ($this->status == 'tekniskirim') {
            return "OPD Teknis";
        } else if ($this->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->status == 'teknisbalas') {
            return "Back Office";
        } else if ($this->status == 'teknis') {
            return "OPD Teknis";
        } else if ($this->status == 'selesai') {
            return "selesai";
        } else if ($this->status == 'selesaiNoScan') {
            return "Back Office";
        } else if ($this->status == 'selesaaiScan') {
            return "Selesai Belum di Ambil";
        } else if ($this->status == 'tolak') {
            return "permohonan - berkas di tolak";
        }
    }

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

    function getidCryptAttribute()
    {
        return Crypt::encryptString($this->permohonan_id);
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

    function persyaratan()
    {
        return $this->hasMany(permohonanPersyaratan::class, 'permohonan_id');
    }

    function persyaratanTrack()
    {
        return $this->hasMany(permohonanPersyaratanTrack::class, 'permohonan_id');
    }

    function track()
    {
        return $this->hasMany(track::class, 'permohonan_id');
    }

    function suratpermintaan()
    {
        return $this->hasMany(suratPermintaan::class, 'permohonan_id');
    }

    function sk()
    {
        return $this->hasMany(sk::class, 'permohonan_id');
    }
}
