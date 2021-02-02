<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\menuControl;
use App\Models\roles;

class AuthController extends Controller
{
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

    public function login(Request $request)
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
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $userData = array("user" => auth()->user());
        $userData["user"]["access_token"] =  $accessToken;
        $userData["user"]["menu"] =  $menu;
        $userData["user"]["role"] =  $role;

        return response(['code' => "200", "user" => $userData["user"]]);
    }

}
