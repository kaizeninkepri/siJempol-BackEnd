<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class pdfControl extends Controller
{
    function index(Request $r){
        $type = $r->get('type');
        if($type == 'routingSlip'){
            return self::routingSlip($r);
        }
    }

    public static function routingSlip(){
                $data = "afriandi";

        $qrCode = base64_encode(QrCode::format('png')->size(100)->errorCorrection('H')->generate('string'));     

        $pdf = PDF::loadView('PDF/routingSlip', compact('data','qrCode'));

    

        return $pdf->stream('itsolutionstuff.pdf');
    }
}
