<?php

namespace App\Http\Controllers;

use App\Models\pengurus;
use App\Models\permohonan;
use App\Models\permohonanPersyaratan;
use App\Models\persyaratan;
use App\Models\perusahaan;
use App\Models\track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        } else if ($type == 'folderPerusahaan') {
            return self::folderPerusahaan($request);
        } else if ($type == 'UploadedFile') {
            return self::UploadedFile($request);
        } else if ($type == 'kirimpermohonan') {
            return self::kirimpermohonan($request);
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
            "kategori" => "Pengguna Jasa",
        );
        track::insert($toTrack);

        $idCrypt = Crypt::encryptString($permohonan_id);
        return $idCrypt;
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

    public static function UploadedFile(Request $request)
    {

        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $perusahaan = perusahaan::where('perusahaan_id', $request->get('perusahaan_id'))->first();
        $permohonan = permohonan::where('permohonan_id', $request->get('permohonan_id'))->first();
        $persyaratan = $request->get("persyaratan");

        $pathFolder = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonan->permohonan_code . '/persyaratan');
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, $mode = 0777, true, true);
        }

        $pos = strpos($persyaratan["file"], ';');
        $filetype = explode('/', substr($persyaratan["file"], 0, $pos))[1];
        $expoloded = explode(",", $persyaratan["file"]);
        $decoded = base64_decode($expoloded[1]);
        $extension =  $filetype;
        $name = Str::slug($persyaratan["persyaratan"], '_');
        $filename = $name . '.' . $extension;

        $path = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonan->permohonan_code . '/persyaratan' . '/' . $filename);
        file_put_contents($path, $decoded);

        $arPers = array(
            "status" => "uploaded",
            "file" => $filename,
            "updated_at" => $timestamp,
            "user_uploaded_file" => $perusahaan->perusahaan_id,
        );


        permohonanPersyaratan::where("permohonan_persyaratanId", $persyaratan["permohonan_persyaratanId"])
        ->update($arPers);

        return array(
            "code" => "200",
            "filename" => $filename
        );
    }

    public static function folderPerusahaan(Request $request)
    {
        $perusahaan = perusahaan::where('perusahaan_id', $request->get('perusahaan_id'))->first();
        $permohonan = permohonan::where('permohonan_id', $request->get('permohonan_id'))->first();



        $pathFolder = Storage::disk("ResourcesExternal")->path($perusahaan->npwp . '/' . $permohonan->permohonan_code . '/persyaratan');
        if (!File::exists($pathFolder)) {
            File::makeDirectory($pathFolder, $mode = 0777, true, true);
        }

        return $pathFolder;
    }
    public static function kirimpermohonan(Request $request)
    {
        $pengurus = $request->get('pengurus');
        $permohonan = $request->get('permohonan');
        $user_id = $request->get('user_id');

        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $toPengurusDB = array(
            "identitas_no" => $pengurus['nik'],
            "identitas_kategori" => "Kartu Tanda Penduduk",
            "nama" => $pengurus['nama'],
            "contact" => $pengurus['contact'],
        );
        pengurus::where('perusahaanp_id', $pengurus['perusahaanp_id'])->update($toPengurusDB);

        $toDBpermohonan = array(
            "status" => "Proses",
            "updated_at" => $timestamp
        );
        permohonan::where('permohonan_id', $permohonan['permohonan_id'])->update($toDBpermohonan);

        $toTrack = array(
            "permohonan_id" => $permohonan['permohonan_id'],
            "perusahaan_id" => $permohonan['perusahaan_id'],
            "pesan" => "Pengiriman Berkas Permohonan Ke Dinas Penanaman Modal Dan Pelayanan Terpadu Satu Pintu Provinsi Kepulauan Riau",
            "step" => "2",
            "ShowOnuser" => "true",
            "user_id" => $user_id,
            "kategori" => "Pengguna Jasa",
        );
        track::insert($toTrack);

        return array(
            "code" => "200",
            "message" => "Success"
        );
    }
}
