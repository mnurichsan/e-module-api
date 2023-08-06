<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ProfileController extends Controller
{
    public function me()
    {
        try {
            $user = Auth::user();

            return ResponseBuilder::asSuccess()
                ->withData($user)
                ->withHttpCode(200)
                ->withMessage('Get User Profile successfully')
                ->build();
        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
                ->withData($th->getMessage())
                ->withHttpCode(500)
                ->withMessage('Something Error')
                ->build();
        }
    }

    public function updateProfile(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|string',
                'fullname' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::asError()
                    ->withData($validator->errors())
                    ->withHttpCode(401)
                    ->withMessage('Validation Error')
                    ->build();
            }

            //
            $dataUserProfile = [
                'email' => $request->email,
                'fullname' => $request->fullname
            ];

            $user = User::find(Auth::user()->id_user);

            $user->update($dataUserProfile);

            return ResponseBuilder::asSuccess()
                ->withData($user)
                ->withHttpCode(200)
                ->withMessage('Update User Profile successfully')
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
                ->withData($th->getMessage())
                ->withHttpCode(500)
                ->withMessage('Something Error')
                ->build();
        }
    }

    public function resetPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|confirmed|min:8',
                'password_confirmation' => 'required'
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::asError()
                    ->withData($validator->errors())
                    ->withHttpCode(401)
                    ->withMessage('Validation Error')
                    ->build();
            }


            $user = User::find(Auth::user()->id_user);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return ResponseBuilder::asSuccess()
                ->withData($user)
                ->withHttpCode(200)
                ->withMessage('Update User Password Profile successfully')
                ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
                ->withData($th->getMessage())
                ->withHttpCode(500)
                ->withMessage('Something Error')
                ->build();
        }
    }

}
