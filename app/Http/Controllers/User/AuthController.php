<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        User::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password)
        ]);
        $token = bin2hex(openssl_random_pseudo_bytes(8));

        $request->session()->put('token', $token);

        return redirect('main') ;
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');


        $token = Auth::attempt($credentials);

        
        if (!$token) {
            return  Redirect::back()->withErrors("البريد الالكترونى او كلمه المرور خطأ !");
        }

        $user = Auth::user();

        $token = bin2hex(openssl_random_pseudo_bytes(8));

        $request->session()->put('token', $token);

        return redirect('main') ;
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
