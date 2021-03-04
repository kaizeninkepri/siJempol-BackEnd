<?php

namespace App\Http\Controllers;

use App\Models\opd;
use Illuminate\Http\Request;
use App\Models\permohonan;
class opdControl extends Controller
{
    public static function index(Request $request)
    {
        $type = $request->get('type');
        if ($type == 'daftarOpd') {
            return self::daftarOpd($request);
        } else if ($type == 'OpdBySektor') {
            return self::OpdBySektor($request);
        } else if ($type == 'opdLaporan') {
            return self::opdLaporan($request);
        }
    }

    public static function daftarOpd()
    {
        return opd::orderBy('opd', 'ASC')->get();
    }

    public static function OpdBySektor(Request $request)
    {
        $id = $request->get('opd_id');
        return opd::with(['izin' => function ($q) {
            $q->with(['persyaratan']);
        }])->where('opd_id', $id)->get();
    }

    public static function opdLaporan(Request $request)
    {

        $opd =  opd::orderBy('opd', 'ASC')->get();
        $data = array();
        foreach ($opd as $e) {
            $data[] = array(
                "opd" => $e,
                "januari" => array("bulan" => permohonan::whereMonth('created_at', '01')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "feb" => array("bulan" => permohonan::whereMonth('created_at', '02')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "mar" => array("bulan" => permohonan::whereMonth('created_at', '03')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "apr" => array("bulan" => permohonan::whereMonth('created_at', '04')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "mei" => array("bulan" => permohonan::whereMonth('created_at', '05')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "jun" => array("bulan" => permohonan::whereMonth('created_at', '06')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "jul" => array("bulan" => permohonan::whereMonth('created_at', '07')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "aug" => array("bulan" => permohonan::whereMonth('created_at', '08')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "sep" => array("bulan" => permohonan::whereMonth('created_at', '09')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "okt" => array("bulan" => permohonan::whereMonth('created_at', '10')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "nov" => array("bulan" => permohonan::whereMonth('created_at', '11')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
                "des" => array("bulan" => permohonan::whereMonth('created_at', '12')->whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get(), "tahun" => permohonan::whereYear('created_at', '2021')->where('opd_id', $e->opd_id)->get()),
            );
        }

        return $data;
    }
}
