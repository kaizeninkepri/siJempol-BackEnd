<?php

namespace App\Http\Controllers;

use App\Models\izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class izinControl extends Controller
{
    public static function index(Request $request)
    {
        $type = $request->get('type');
        if ($type == 'daftarIzin') {
            return self::daftarIzin($request);
        }
        if ($type == 'izinById') {
            return self::izinById($request);
        }
    }

    public static function daftarIzin(Request $request)
    {
        return izin::where('aktif', 'true')
            ->orderBy("nama_izin", 'ASC')->get();
    }

    public static function izinById(Request $request)
    {
        $id = Crypt::decryptString($request->get('id'));
        return izin::with(['persyaratan', 'opd'])
            ->where('opdi_id', $id)
            ->first();
    }
}
