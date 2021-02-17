<?php

namespace App\Http\Controllers;

use App\Models\permohonan;
use App\Models\permohonanPersyaratan;
use App\Models\perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class permohonanPersyaratanControl extends Controller
{
    public static function index(Request $request)
    {
        $type = $request->get("type");
        if ($type == 'hapusFile') {
            return self::hapusFile($request);
        }
    }

    public static function hapusFile(Request $request)
    {
        $perusahaan = perusahaan::where('perusahaan_id', $request->get('perusahaan_id'))->first();
        $permohonan = permohonan::where('permohonan_id', $request->get('permohonan_id'))->first();
        $persyaratan = $request->get("persyaratan");

        $pathFolder = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonan->permohonan_code . '/persyaratan' . '/' . $persyaratan['file']);

        unlink($pathFolder);
        $updateFile = array(
            "file" => null,
            "status" => "waiting-upload",
        );
        $hapusFile = permohonanPersyaratan::where('permohonan_persyaratanId', $persyaratan['permohonan_persyaratanId'])->update($updateFile);

        return "200";
    }
}
