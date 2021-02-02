<?php

namespace App\Http\Controllers;

use App\Models\permohonan;
use Illuminate\Http\Request;

class permohonanControl extends Controller
{
    public static function permohonanTable(Request $r){
    return permohonan::with(['perusahaan','izin','opd','pengurus'])
                        ->orderBy('created_at','DESC')
                        ->where('status','proses')
                        ->limit(100)
                        ->get();
    }
}
