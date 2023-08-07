<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use App\Models\LearningModule;
use App\Models\LearningProgress;
use App\Models\Practice;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;
use MilanTarami\ApiResponseBuilder\Facades\ResponseBuilder;
use Illuminate\Support\Facades\Auth;
use Validator;
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


    public function storeAnswer(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'id_material' => 'required',
                'answer' => 'required|array',
                'answer.*.id_material' => 'required|exists:learning_materials,id_material',
                'answer.*.id_quiz' => 'required|exists:practices,id_quiz',
                'answer.*.student_answer' => 'required'
            ]);

            if ($validator->fails()) {
                return ResponseBuilder::asError()
                    ->withData($validator->errors())
                    ->withHttpCode(401)
                    ->withMessage('Validation Error')
                    ->build();
            }
            $studentAnswer = [];
            $insertAnswerArray = [];
            foreach($request->answer as $a){
                $pratice = Practice::where('id_quiz',$a['id_quiz'])->where('id_material',$a['id_material'])->first();
                if(!$pratice){
                    return ResponseBuilder::asError()
                    ->withData($validator->errors())
                    ->withHttpCode(401)
                    ->withMessage('Id Quiz atau Id Material Salah')
                    ->build();
                }
                $studentAnswer['id_quiz'] = $pratice->id_quiz;
                $studentAnswer['id_user'] = Auth::user()->id_user;
                $studentAnswer['answer'] = $a['student_answer'];
                if($pratice->correct_answer == $a['student_answer']){
                    $studentAnswer['is_correct'] = true;
                }else{
                    $studentAnswer['is_correct'] = false;
                }
                $studentAnswer['created_at'] = now();
                $studentAnswer['updated_at'] = now();
               array_push($insertAnswerArray,$studentAnswer);
            }


            $total_soal =  Practice::where('id_material',$request->id_material)->count();
            $jumlah_benar = 0;
            $jumlah_salah = 0;
            foreach($insertAnswerArray as $student){
                if($student['is_correct'] == true){
                    $jumlah_benar++;
                }else{
                    $jumlah_salah++;
                }
            }
            $score =  $jumlah_benar / $total_soal * 100;


            StudentAnswer::insert($insertAnswerArray);

            $learningProgress = LearningProgress::create([
                'id_material' => $request->id_material,
                'id_user' => Auth::user()->id_user,
                'score' => $score
            ]);

            $responses = [
                'learning_progress' => $learningProgress,
                'student_answer' => $insertAnswerArray
            ];

            return ResponseBuilder::asSuccess()
            ->withData($responses)
            ->withHttpCode(200)
            ->withMessage('Store Quiz successfully')
            ->build();


        } catch (\Throwable $th) {
            return ResponseBuilder::asError()
            ->withData($th->getMessage())
            ->withHttpCode(500)
            ->withMessage('Something Error')
            ->build();
        }
    }

    public function progressStudent(){
        try {

            $progress = LearningProgress::with('user:id_user,fullname','material:id_material,id_module,title_material','material.module:id_module,title_module','material.practice.studentAnswer')->where('id_user',Auth::user()->id_user)->get();

            return ResponseBuilder::asSuccess()
            ->withData($progress)
            ->withHttpCode(200)
            ->withMessage('Get Learning successfully')
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
