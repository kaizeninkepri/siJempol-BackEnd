<?php

namespace App\Http\Controllers;

use App\Models\opd;
use Illuminate\Http\Request;

class opdControl extends Controller
{
    public static function index(Request $request)
    {
        $type = $request->get('type');
        if ($type == 'daftarOpd') {
            return self::daftarOpd($request);
        } else if ($type == 'OpdBySektor') {
            return self::OpdBySektor($request);
        }
    }

    public static function daftarOpd()
    {
        return opd::orderBy('opd', 'ASC')->get();
    }

    public static function OpdBySektor(Request $request)
    {
        $id = $request->get('opd_id');
        return opd::with(['izin' => function ($q) {
            $q->with(['persyaratan']);
        }])->where('opd_id', $id)->get();
    }
}
