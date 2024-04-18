<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check() == true) {
            return redirect('/');
        } else {
            return view('auth.login');
        }

    }

    public function loginProses(Request $request)
    {

        $response_data = [
            'responCode' => 0,
            'respon' => ''
        ];

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            $role = Auth::user()->role;

            $response_data = [
                'responCode' => 1,
                'respon' => $role
            ];

        } else {

            $response_data['respon'] = 'Username atau password salah!';

        }

        return response()->json($response_data);

    }

    public function register()
    {

        return view('auth.register');
    }

    public function registerProses(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'email' => 'unique:users',
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if ($validator->fails()) {

            $data['respon'] = 'Ada kesalahan silahkan ulangi!'.$validator->errors();

        } else {
            $data = User::create([
                'name' => $request->name,
                'role' => 'User',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'photo' => 'avatar.png'
            ]);

            $data = [
                'responCode' => 1,
                'respon' => 'Data Berhasil Didaftarkan!'
            ];

            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ]);
        }

        return response()->json($data);
    }
}
