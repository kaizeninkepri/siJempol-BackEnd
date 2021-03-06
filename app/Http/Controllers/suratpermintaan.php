<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\perusahaan;
use App\Models\permohonan;
use App\Models\suratPermintaan as ModelsSuratPermintaan;
use App\Models\surattrack;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\track;


class suratpermintaan extends Controller
{
    function index(Request $request)
    {
        $type = $request->get('type');
        if ($type == 'permintaan') {
            return self::permintaan($request);
        } elseif ($type == 'permintaanDataByStatus') {
            return self::permintaanDataByStatus($request);
        } elseif ($type == 'permintaandataBypermohonanId') {
            return self::permintaandataBypermohonanId($request);
        }
    }

    public static function permintaan(Request $request)
    {
        $surat = $request->get('surat');
        $user_id = $request->get('user_id');
        $permohonan = permohonan::where('permohonan_id', $request->get('permohonan_id'))->first();

        $keterangan = 'pengiriman';
        $status = 'balas';


        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $perusahaan = perusahaan::where('perusahaan_id', $permohonan->perusahaan_id)->first();
        $permohonanData = permohonan::where('permohonan_id', $permohonan->permohonan_id)->first();
        $opdId = 1;
        $pathFolder = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonanData->permohonan_code . '/surat');
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, $mode = 0777, true, true);
        }

        $pos = strpos($surat["file"], ';');
        $filetype = explode('/', substr($surat["file"], 0, $pos))[1];
        $expoloded = explode(",", $surat["file"]);
        $decoded = base64_decode($expoloded[1]);
        $extension =  $filetype;
        $name = Str::slug($surat["perihal"], '_');
        $filename = $name . '.' . $extension;

        $path = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonanData->permohonan_code . '/surat' . '/' . $filename);
        file_put_contents($path, $decoded);

        $toArraySurat = array(
            "nomor" => $surat['nomor'],
            "perihal" => $surat['perihal'],
            "file" => $filename,
            "user_id" => $user_id,
            "status" => $status,
            "permohonan_id" => $permohonan['permohonan_id'],
            "kategori" => 1,
            "keterangan" => $keterangan,
            "opd_id" => $opdId,
        );
        ModelsSuratPermintaan::insert($toArraySurat);
        $surat_permintaan_id = DB::getPdo()->lastInsertId();

        $toarraySuratTrack = array(
            "permohonan_id" => $permohonan['permohonan_id'],
            "surat_permintaan_id" => $surat_permintaan_id,
            "user_id" => $user_id,
            "status" => 1,
        );
        surattrack::insert($toarraySuratTrack);

        $toTrack = array(
            "permohonan_id" => $permohonan['permohonan_id'],
            "perusahaan_id" => $permohonanData->perusahaan_id,
            "pesan" => 'Pengiriman Permohonan Telaah Teknis',
            "step" => "4",
            "ShowOnuser" => "true",
            "readShow" => "false",
            "user_id" => $user_id,
            "kategori" => "BACK OFFICE",
        );
        track::insert($toTrack);
    }

    public static function permintaanDataByStatus(Request $request)
    {
        $kategori = $request->get('kategori');
        $opd_id = $request->get('opd_id');

        return ModelsSuratPermintaan::with(['permohonan' => function ($p) {
            $p->with(['perusahaan', 'izin', 'pengurus']);
        }])->where('kategori', $kategori['id'])
        ->where('opd_id', $opd_id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function permintaandataBypermohonanId(Request $request)
    {
        $permohonan_id = $request->get('permohonan_id');
        $surat = ModelsSuratPermintaan::where('permohonan_id', $permohonan_id)->get();

        return $surat;
    }
}
