<?php

namespace App\Http\Controllers;

use App\Models\izin;
use App\Models\permohonan;
use App\Models\persyaratan;
use App\Models\track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class pdfControl extends Controller
{
    function index(Request $r){
        $type = $r->get('type');
        if($type == 'routingSlip'){
            return self::routingSlip($r);
        } else if ($type == 'persyaratan') {
            return self::persyaratan($r);
        } else if ($type == 'serahTerima') {
            return self::serahTerima($r);
        }
    }

    public static function routingSlip(Request $r)
    {
        $id =  Crypt::decryptString($r->get('idCrypt'));
        $p = permohonan::with(['izin', 'persyaratan', 'opd', 'track', 'perusahaan', 'pengurus'])->where("permohonan_id", $id)->first();
        $qrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(100)->errorCorrection('H')->generate('https://dpmptsp.kepriprov.go.id/Validation/' . $p->permohonan_id));

        $fo = track::with('petugas')->where('permohonan_id', $p->permohonan_id)->where('kategori', 'FRONT OFFICE')->orderBy('created_at', 'DESC')->first();
        $foqrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(60)->errorCorrection('H')->generate($fo->user_id));

        $bo = track::with('petugas')->where('permohonan_id', $p->permohonan_id)->where('kategori', 'BACK OFFICE')->orderBy('created_at', 'ASC')->first();
        $boqrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(60)->errorCorrection('H')->generate($fo->user_id));

        $opd = track::with('petugas')->where('permohonan_id', $p->permohonan_id)->where('kategori', 'opd')->orderBy('created_at', 'DESC')->first();
        $opdqrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(60)->errorCorrection('H')->generate($fo->user_id));

        $opd1 = track::with('petugas')->where('permohonan_id', $p->permohonan_id)->where('kategori', 'BACK OFFICE')->orderBy('created_at', 'DESC')->first();
        $opdqrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(60)->errorCorrection('H')->generate($fo->user_id));

        $kabid = track::with('petugas')->where('permohonan_id', $p->permohonan_id)->where('kategori', 'kabid')->orderBy('created_at', 'DESC')->first();
        $opdqrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(60)->errorCorrection('H')->generate($fo->user_id));



        $pdf = PDF::loadView('PDF/routing', compact('p', 'qrCode', 'fo', 'foqrCode', 'bo', 'boqrCode', 'opd', 'opdqrCode', 'opd1', 'kabid'));
        return $pdf->stream($p->izin->nama_izin . '.pdf');
    }

    public static function persyaratan(Request $r)
    {
        $id =  Crypt::decryptString($r->get('idCrypt'));
        $p = izin::with(['persyaratan'])->where("opdi_id", $id)->first();
        $pdf = PDF::loadView('PDF/persyaratan', compact('p'));
        return $pdf->stream($p->nama_izin . '.pdf');
    }
    public static function serahTerima(Request $r)
    {
        $id =  Crypt::decryptString($r->get('idCrypt'));
        $p = permohonan::with(['izin', 'persyaratan', 'opd'])->where("permohonan_id", $id)->first();
        $qrCode = base64_encode(QrCode::eyeColor(0, 20, 83, 136, 0, 0, 0)->format('png')->size(100)->errorCorrection('H')->generate('https://dpmptsp.kepriprov.go.id/Validation/' . $p->permohonan_id));


        $pdf = PDF::loadView('PDF/serah_terima', compact('p', 'qrCode'));
        return $pdf->stream($p->izin->nama_izin . '.pdf');
    }
}
