<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\perusahaan;
use App\Models\permohonan;
use App\Models\sk;
use App\Models\surattrack;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\track;

class skControl extends Controller
{
    function index(Request $request)
    {
        $type = $request->get('type');
        if ($type == 'simpan') {
            return self::simpan($request);
        }
    }

    public static function simpan(Request $request)
    {
        $surat = $request->get('sk');
        $user_id = $request->get('user_id');
        $permohonan = $request->get('permohonan');


        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $perusahaan = perusahaan::where('perusahaan_id', $permohonan['perusahaan_id'])->first();
        $permohonanData = permohonan::where('permohonan_id', $permohonan['permohonan_id'])->first();
        $pathFolder = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonanData->permohonan_code . '/sk');
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, $mode = 0777, true, true);
        }

        $pos = strpos($surat["file"], ';');
        $filetype = explode('/', substr($surat["file"], 0, $pos))[1];
        $expoloded = explode(",", $surat["file"]);
        $decoded = base64_decode($expoloded[1]);
        $extension =  $filetype;
        $name = Str::slug($surat["nomor"], '_');
        $filename = $name . '.' . $extension;

        $path = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonanData->permohonan_code . '/sk' . '/' . $filename);
        file_put_contents($path, $decoded);

        $toArraySurat = array(
            "nomor_sk" => $surat['nomor'],
            "file_sk" => $filename,
            "user_id" => $user_id,
            "permohonan_id" => $permohonan['permohonan_id'],
        );
        sk::insert($toArraySurat);

        $toTrack = array(
            "permohonan_id" => $permohonanData->permohonan_id,
            "perusahaan_id" => $permohonanData->perusahaan_id,
            "pesan" => "Permohonan Perizinan Telah Selesai",
            "step" => "6",
            "ShowOnuser" => "true",
            "user_id" => $user_id,
            "kategori" => "Kepala Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu",
        );
        track::insert($toTrack);
    }
}
