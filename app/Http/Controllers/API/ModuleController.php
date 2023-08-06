<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use App\Models\LearningModule;
use App\Models\Practice;
use Illuminate\Http\Request;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;

class ModuleController extends Controller
{
    public function index(){
        try {

            $listModule = LearningModule::get();

            return ResponseBuilder::asSuccess()
            ->withData($listModule)
            ->withHttpCode(200)
            ->withMessage('Get Module List successfully')
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
            ->withData($th->getMessage())
            ->withHttpCode(500)
            ->withMessage('Something Error')
            ->build();
        }

    }

    public function listMaterialById($idModule){
        try {

        $listMaterial = LearningModule::with('material')->where('id_module',$idModule)->first();


            if(!$listMaterial){
                return ResponseBuilder::asSuccess()
                ->withData([])
                ->withHttpCode(404)
                ->withMessage('Material Not Found')
                ->build();
            }

            return ResponseBuilder::asSuccess()
            ->withData($listMaterial)
            ->withHttpCode(200)
            ->withMessage('Get Material '.$listMaterial?->title_module.' successfully')
            ->build();

        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
            ->withData($th->getMessage())
            ->withHttpCode(500)
            ->withMessage('Something Error')
            ->build();
        }
    }

    public function showMaterialById($idMaterial){
        try {

            $listMaterial = LearningMaterial::where('id_material',$idMaterial)->first();

                if(!$listMaterial){
                    return ResponseBuilder::asSuccess()
                    ->withData([])
                    ->withHttpCode(404)
                    ->withMessage('Material Not Found')
                    ->build();
                }

                return ResponseBuilder::asSuccess()
                ->withData($listMaterial)
                ->withHttpCode(200)
                ->withMessage('Get Material '.$listMaterial?->title_material.' successfully')
                ->build();

            } catch (\Throwable $th) {
                return ResponseBuilder::asError()
                ->withData($th->getMessage())
                ->withHttpCode(500)
                ->withMessage('Something Error')
                ->build();
            }
    }

    public function listQuizlById($idMaterial){
        try {

            $listQuiz = LearningMaterial::with('practice')->where('id_material',$idMaterial)->first();

            if(!$listQuiz){
                return ResponseBuilder::asSuccess()
                ->withData([])
                ->withHttpCode(404)
                ->withMessage('Quiz Not Found')
                ->build();
            }

            return ResponseBuilder::asSuccess()
            ->withData($listQuiz)
            ->withHttpCode(200)
            ->withMessage('Get Quiz successfully')
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
