<?php

namespace App\Http\Controllers;

use App\Models\permohonan;
use App\Models\permohonanPersyaratan;
use App\Models\permohonanPersyaratanTrack;
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
        } else if ($type == 'UpdateStatus') {
            return self::UpdateStatus($request);
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

    public static function UpdateStatus(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");
        $permohonan_id = $request->get('permohonan_id');
        $permohonan_persyaratanId = $request->get('permohonan_persyaratanId');
        $role = $request->get('role');
        $data = $request->get('data');

        permohonanPersyaratan::where('permohonan_persyaratanId', $permohonan_persyaratanId)->update(array(
            "status" => $data['value'],
            "catatan" => $data['text'],
            "updated_at" => $timestamp,
        ));

        $trackPersyaratan = permohonanPersyaratanTrack::where('permohonan_persyaratanId', $permohonan_persyaratanId)->where('role', $role)->get();

        if ($trackPersyaratan) {

            foreach ($trackPersyaratan as $i) {
                permohonanPersyaratanTrack::where('permohonan_peryaratan_track_id', $i->permohonan_peryaratan_track_id)->update(array(
                    'role' => $role,
                    'status' => "false",
                ));
            }



            permohonanPersyaratanTrack::insert(array(
                'permohonan_id' => $permohonan_id,
                'permohonan_persyaratanId' => $permohonan_persyaratanId,
                'role' => $role,
                'status' => "true",
                'note' => $data['text'],
            ));
        } else {
            permohonanPersyaratanTrack::insert(array(
                'permohonan_id' => $permohonan_id,
                'permohonan_persyaratanId' => $permohonan_persyaratanId,
                'role' => $role,
                'status' => "true",
                'note' => $data['text'],
            ));
        }
    }
}
