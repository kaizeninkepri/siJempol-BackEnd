<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\perusahaan;

class perusahaanControl extends Controller
{
    public static function index(Request $request)
    {
        $type = $request->get("type");
        if ($type == 'GetPerusahaanByNpwp') {
            return self::GetPerusahaanByNpwp($request);
        } else if ($type == 'GetPerusahaanById') {
            return self::GetPerusahaanById($request);
        }
    }

    public static function GetPerusahaanByNpwp(Request $request)
    {
        $npwp = $request->get("npwp");
        $perusahaan = perusahaan::where("npwp", $npwp)->first();

        if ($perusahaan) {
            $code = "200";
        } else {
            $code = "404";
        }

        return array(
            "code" => $code,
            "data" => $perusahaan
        );
    }

    public static function GetPerusahaanById(Request $request)
    {
        $id = $request->get("id");
        $perusahaan = perusahaan::where("perusahaan_id", $id)->first();

        if ($perusahaan) {
            return $perusahaan;
        } else {
            return "Non Found";
        }
    }
}
