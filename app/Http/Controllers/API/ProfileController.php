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
                'image' => 'file|mimes:png,jpg,jpeg|max:2046'
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

            if($request->has('image')){
                $extArray = [
                    'jpg','png','jpeg'
                ];

                $ext = $request->image->getClientOriginalExtension();
                if(in_array($ext,$extArray)){
                    $pathImage =  $this->uploadFile($request->image,'user','image');
                    $urlImage = url('/'.$pathImage);
                    $dataUserProfile['image'] = $urlImage;

                }else{
                    return ResponseBuilder::asError()
                    ->withHttpCode(401)
                    ->withMessage('The image must be a file of type: png, jpg, jpeg')
                    ->build();
                }
            }

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

    private function uploadFile($file,$root_folder,$folderName)
    {
        try {
            $fileNameWithExt = $file->getClientOriginalName();
            $fileNameWithExt = str_replace(" ", "-", $fileNameWithExt);
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $filename = preg_replace("/[^a-zA-Z0-9\s]/", "", $filename);
            $filename = urlencode($filename);

            $extension = $file->getClientOriginalExtension();

            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $path = $file->storeAs('files/uploads/'.$root_folder.'/'.$folderName, $fileNameToStore, 'public');

            return $path;

        } catch (\Throwable $th) {
            return false;
        }
    }

}
