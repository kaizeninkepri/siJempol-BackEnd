<?php

namespace App\Http\Controllers;

use App\Models\pengurus;
use App\Models\permohonan;
use App\Models\permohonanPersyaratan;
use App\Models\persyaratan;
use App\Models\track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class permohonanControl extends Controller
{

    public static function index(Request $request)
    {
        $type = $request->get("type");
        if ($type == 'withStep') {
            return self::permohonanWithStep($request);
        } else if ($type == 'pemohonStep1') {
            return self::pemohonStep1($request);
        } else if ($type == 'tesCode') {
            return self::tesCode($request);
        } else if ($type == 'permohonanByperusahaan') {
            return self::permohonanByperusahaan($request);
        } else if ($type == 'permohonanByid') {
            return self::permohonanByid($request);
        }
    }

    public static function permohonanTable(Request $r){
    return permohonan::with(['perusahaan','izin','opd','pengurus'])
                        ->orderBy('created_at','DESC')
                        ->where('status','proses')
                        ->limit(100)
                        ->get();
    }

    public static function permohonanWithStep(Request $request)
    {
        return permohonan::with(['perusahaan', 'izin', 'opd', 'pengurus'])
        ->orderBy('created_at', 'DESC')
        ->where('status', 'proses')
        ->limit(100)
            ->get();
    }

    public static function pemohonStep1(Request $request)
    {
        $perusahaan_id = $request->get('perusahaan_id');
        $user_id = $request->get('user_id');
        $pengurus   = $request->get('pengurus');
        $izin       = $request->get('izin');


        $code = 'PRMN';
        $pegawaiCode = permohonan::max('permohonan_code');
        $idmax1 = $pegawaiCode;
        $nourut1 = (int) substr($idmax1, 4, 5);
        $nourut1++;
        $permohonan_code = $code . sprintf("%05s", $nourut1);

        $toPengurusDB = array(
            "identitas_no" => $pengurus['nik'],
            "identitas_kategori" => "Kartu Tanda Penduduk",
            "nama" => $pengurus['nama'],
            "contact" => $pengurus['contact'],
            "perusahaan_id" => $perusahaan_id,
        );
        pengurus::insert($toPengurusDB);
        $pengurus_id =  DB::getPdo()->lastInsertId();


        $toDBpermohonan = array(
            "permohonan_code"   => $permohonan_code,
            "perusahaan_id"     => $perusahaan_id,
            "perusahaanp_id"    => $pengurus_id,
            "opd_id"            => $izin["opd_id"],
            "opdi_id"           => $izin["opdi_id"],
            "status"            => "pending",
            "create_on"         => "online"
        );
        permohonan::insert($toDBpermohonan);
        $permohonan_id = DB::getPdo()->lastInsertId();

        foreach ($izin["persyaratan"] as $index => $p) {
            $toDbPersyaratan = array(
                "permohonan_id" => $permohonan_id,
                "persyaratan" => $p["persyaratan"],
                "status" => "waiting-upload"
            );
            permohonanPersyaratan::insert($toDbPersyaratan);
        }

        $toTrack = array(
            "permohonan_id" => $permohonan_id,
            "perusahaan_id" => $perusahaan_id,
            "pesan" => "Pengisian Formulir Permohonan -  Identitas Pengurus",
            "step" => "1",
            "ShowOnuser" => "true",
            "user_id" => $user_id,
        );
        track::insert($toTrack);

        $idCrypt = Crypt::encryptString($permohonan_id);
        return $idCrypt;
    }

    public static function tesCode()
    {
        $code = 'PRMN';
        // $pegawaiCode = DB::table('permohonan')->where('permohonan_code', 'like', '%' . $code . '%')->max('permohonan_code');
        $pegawaiCode = permohonan::max('permohonan_code');
        $idmax1 = $pegawaiCode;
        $nourut1 = (int) substr($idmax1, 4, 5);
        $nourut1++;
        $permohonan_code = $code . sprintf("%05s", $nourut1);

        return $permohonan_code;
    }

    public static function permohonanByperusahaan(Request $request)
    {
        $perusahaan_id = $request->get('perusahaan_id');
        return permohonan::with(['perusahaan', 'izin', 'opd'])
        ->where('perusahaan_id', $perusahaan_id)->get();
    }

    public static function permohonanByid(Request $request)
    {
        $permohonan_id = Crypt::decryptString($request->get('id'));
        return permohonan::with(['perusahaan', 'izin', 'persyaratan', 'pengurus', 'opd'])
        ->where('permohonan_id', $permohonan_id)->first();
    }
}
