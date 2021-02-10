<?php

namespace App\Http\Controllers;

use App\Models\perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pendaftaranControl extends Controller
{
    public function index(Request $request){

        $type = $request->get('type');
        if($type == 'InsertPendaftaran'){
            return self::InsertPendaftaran($request);
        } else if ($type == 'checkinEmail') {
            return self::checkinEmail($request);
        }
    
    }

    public static function InsertPendaftaran(Request $request){
        $data = $request->get('perusahaan');
        $user = $request->get('user');
        $perusahaanData =  array(
            "npwp"      => $data['npwp'],
            "kategori"  => $data['kategori'],
            "nama"      => $data['nama'],
            "alamat"    => $data['alamat'],
            "email"     => $data['email'],
            "contact"   => $data['contact'],
            "provinsi"  => $data['provinsi'],
            "kota"      => $data['kota'],
            "jenis"     => $data['jenis'],
            "kode_pos"  => $data['kode_pos'],
        );

        perusahaan::insert($perusahaanData);
        $perusahaan_id = DB::getPdo()->lastInsertId();

       $userData = array(
        "name" => $user['name'],
        "email" => $data['email'],
        "password" => bcrypt($user['password']),
            "role_id" => '8',
            "perusahaan_id" => $perusahaan_id
       ); 
       User::insert($userData);
        //tologin 
        $userLogin = new Request();
        $userLogin->replace(['email' => $data['email'], 'password' => $user['password']]);
        return AuthController::login($userLogin);
    }

    public static function checkinEmail(Request $request)
    {
        $npwp = $request->get("email");
        $perusahaan = User::where("email", $npwp)->first();

        if ($perusahaan) {
            $code = "200";
        } else {
            $code = "404";
        }
        return array(
            "code" => $code,
            "data" => $perusahaan
        );

    }
}
