<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email|string|unique:users,email',
                'password' => 'required|string|confirmed|min:8',
                'password_confirmation' => 'required'
            ]);

            if( $validator->fails() ) {
                return ResponseBuilder::asError()
                ->withData($validator->errors())
                ->withHttpCode(401)
                ->withMessage('Validation Error')
                ->build();
            }

            $username = preg_replace('/\s+/', '', $request->fullname);

            $dataRegister = [
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'username' => Str::lower($username)
            ];

            $user = User::create($dataRegister);
            $user->attachRole('siswa');

            $dataUser['name'] = $user->fullname;
            $dataUser['username'] = $user->username;
            $dataUser['email'] = $user->email;
            $dataUser['token'] = $user->createToken('authToken')->plainTextToken;
            $dataUser['role'] = $user->roles->first()->makeHidden([
                'id','created_at','updated_at','pivot'
            ]);

            return ResponseBuilder::asSuccess()
                ->withData($dataUser)
                ->withHttpCode(200)
                ->withMessage('Register successfully')
                ->build();

        }catch (\Exception $e) {
            return ResponseBuilder::asError()
            ->withData($e->getMessage())
            ->withHttpCode(500)
            ->withMessage('Something Error')
            ->build();
        }
    }

    public function login(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|string',
                'password' => 'required|string',
            ]);

            if( $validator->fails() ) {
                return ResponseBuilder::asError()
                ->withData($validator->errors())
                ->withHttpCode(401)
                ->withMessage('Validation Error')
                ->build();
            }

            $dataLogin = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $auth = auth()->attempt($dataLogin);
            if (!$auth) {
                return ResponseBuilder::asError()
                    ->withData('Invalid credentials')
                    ->withHttpCode(401)
                    ->withMessage('Email/Password Salah')
                    ->build();
            }

            $user =  Auth::user();
            if(!$user->hasRole('siswa')){
                return ResponseBuilder::asError()
                ->withHttpCode(403)
                ->withMessage('Tidak Ada Akses Untuk Ini')
                ->build();
            }

            $dataUser['name'] = $user->fullname;
            $dataUser['username'] = $user->username;
            $dataUser['email'] = $user->email;
            $dataUser['token'] = $user->createToken('authToken')->plainTextToken;
            $dataUser['role'] = $user->roles->first()->makeHidden([
                'id','created_at','updated_at','pivot'
            ]);

            return ResponseBuilder::asSuccess()
                ->withData($dataUser)
                ->withHttpCode(200)
                ->withMessage('Login successfully')
                ->build();

        }catch (\Exception $e) {
            return ResponseBuilder::asError()
            ->withData($e->getMessage())
            ->withHttpCode(500)
            ->withMessage('Something Error')
            ->build();
        }
    }
}
