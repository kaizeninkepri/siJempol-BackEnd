<?php

namespace App\Http\Controllers;

use App\Models\izin;
use App\Models\persyaratan;
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
        }
    }

    public static function routingSlip(){
                $data = "afriandi";

        $qrCode = base64_encode(QrCode::format('png')->size(100)->errorCorrection('H')->generate('string'));     

        $pdf = PDF::loadView('PDF/routingSlip', compact('data','qrCode'));



        return $pdf->stream('itsolutionstuff.pdf');
    }

    public static function persyaratan(Request $r)
    {
        $id =  Crypt::decryptString($r->get('idCrypt'));
        $p = izin::with(['persyaratan'])->where("opdi_id", $id)->first();
        $pdf = PDF::loadView('PDF/persyaratan', compact('p'));
        // return $p;
        return $pdf->stream('itsolutionstuff.pdf');
    }
}
