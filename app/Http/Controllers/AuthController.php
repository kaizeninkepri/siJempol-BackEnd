<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\menuControl;
use App\Models\perusahaan;
use App\Models\roles;
use PDO;

class AuthController extends Controller
{

    function index(Request $request)
    {
        $type = $request->get("type");
        if ($type == 'GetUserAll') {
            return self::GetUserAll($request);
        } else if ($type == 'GetUserByName') {
            return self::GetUserByName($request);
        } else if ($type == 'GetUserById') {
            return self::GetUserById($request);
        } else if ($type == 'GetUserByEmail') {
            return self::GetUserByEmail($request);
        }
    }

    public function register(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public static function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['code' => "500", 'message' => 'Invalid Credentials']);
        }
        $roleId = new Request();
        $roleId->request->add(['id' => auth()->user()->role_id]);
        $menu = menuControl::menu($roleId);
        $role = roles::where('role_id', auth()->user()->role_id)->first();
        $perusahaan = perusahaan::where('perusahaan_id', auth()->user()->perusahaan_id)->first();
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $userData = array("user" => auth()->user());
        $userData["user"]["access_token"] =  $accessToken;
        $userData["user"]["menu"] =  $menu;
        $userData["user"]["role"] =  $role;
        $userData["user"]["perusahaan"] =  $perusahaan;

        return response(['code' => "200", "user" => $userData["user"]]);
    }

    public static function GetUserAll()
    {
        return user::with(['perusahaan'])->get();
    }

    public static function GetUserByName(Request $request)
    {
        $name = $request->get("name");
        $user = user::with(['perusahaan'])
            ->where("name", "like", "%" . $name . "%")
            ->get();
        if (count($user) > 0) {
            return $user;
        } else {
            return "404 - NOT FOUND";
        }
    }

    public static function GetUserById(Request $request)
    {
        $id = $request->get("id");
        $user = user::with(['perusahaan'])
            ->where("id", $id)
            ->get();

        if (count($user) > 0) {
            return $user;
        } else {
            return "404 - NOT FOUND";
        }
    }

    public static function GetUserByEmail(Request $request)
    {
        $email = $request->get("email");
        $user =  user::with(['perusahaan'])
            ->where("email", $email)
            ->get();

        if (count($user) > 0) {
            return $user;
        } else {
            return "404 - NOT FOUND";
        }
    }

}
