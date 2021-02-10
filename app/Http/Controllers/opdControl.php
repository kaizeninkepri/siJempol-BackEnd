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
        }
    }

    public static function daftarOpd()
    {
        return opd::orderBy('opd', 'ASC')->get();
    }
}
