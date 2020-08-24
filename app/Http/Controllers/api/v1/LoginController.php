<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login( Request $request)
    {
        $login = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if(!Auth::attempt($login))
        {
            return response([
                    'message' => 'login crendentials. Failed'
            ]);
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response([
            'user'  => Auth::user(),
            'access_token' => $accessToken,
        ]);
    }
}
