<?php

namespace App\Http\Controllers;

use App\Models\LearningMaterial;
use App\Models\LearningModule;
use App\Models\LearningProgress;
use App\Models\Practice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_siswa = User::whereRoleIs('siswa')->count();
        $total_modul = LearningModule::count();
        $total_material = LearningMaterial::count();
        $total_practice = Practice::count();

        return view('home', compact('total_siswa', 'total_modul', 'total_material', 'total_practice'));
    }

    public function siswa()
    {
        $listSiswa = User::whereRoleIs('siswa')->get();
        return view('siswa', compact('listSiswa'));
    }

    public function modul()
    {
        $modul = LearningModule::get();
        return view('modul', compact('modul'));
    }

    public function detail_siswa($id)
    {
        $detailSiswa = User::whereRoleIs('siswa')->with('progress', 'progress.material', 'progress.material.module')->where('id_user', $id)->firstOrFail();
        return view('detail_siswa', compact('detailSiswa'));
    }

    public function detail_module($id)
    {

        $detailModule = LearningModule::where('id_module', $id)->with('material', 'material.practice')->first();
        return view('detail_modul', compact('detailModule'));
    }

    public function tambah_module()
    {
        return view('tambah_modul');
    }

    public function store_module(Request $request)
    {

        $this->validate($request, [
            'module_title' => 'required',
            'module_author' => 'required',
            'des_module' => 'required',
            'content_module' => 'required'
        ]);

        $data = [
            'title_module' => $request->module_title,
            'des_module' => $request->des_module,
            'content' => $request->content_module,
            'author' => $request->module_author
        ];

        LearningModule::create($data);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Data');
    }

    public function delete_module($id)
    {
        $modul = LearningModule::find($id);
        $modul->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
    }

    public function edit_module($id)
    {
        $modulDetail = LearningModule::findOrFail($id);
        return view('edit_modul', compact('modulDetail'));
    }

    public function update_module(Request $request, $id)
    {
        $this->validate($request, [
            'module_title' => 'required',
            'module_author' => 'required',
            'des_module' => 'required',
            'content_module' => 'required'
        ]);

        $data = [
            'title_module' => $request->module_title,
            'des_module' => $request->des_module,
            'content' => $request->content_module,
            'author' => $request->module_author
        ];

        $modulDetail = LearningModule::findOrFail($id);

        $modulDetail->update($data);
        return redirect()->back()->with('success', 'Berhasil Mengupdate Data');
    }

    public function tambah_material($id)
    {
        $detailModule = LearningModule::where('id_module', $id)->firstOrFail();

        return view('tambah_material', compact('detailModule'));
    }

    public function store_material(Request $request, $id)
    {
        $this->validate($request, [
            'material_title' => 'required',
            'content_material' => 'required',
            'tipe_material' => 'required',
        ]);

        $detailModule = LearningModule::where('id_module', $id)->firstOrFail();


        $data = [
            'id_module' => $detailModule->id_module,
            'title_material' => $request->material_title,
            'content' => $request->content_material,
            'tipe_material' => $request->tipe_material
        ];
        if ($request->tipe_material == "gambar") {
            $this->validate($request, [
                'material_file_gambar' => 'mimes:png,jpg,jpeg|max:2046',
            ]);

            $extArray = [
                'jpg','png','jpeg'
            ];

            $ext = $request->material_file_gambar->getClientOriginalExtension();
            if(in_array($ext,$extArray)){
                $pathImage =  $this->uploadFile($request->material_file_gambar,'material','image');
                $baseUrl =  url('/');

                if($baseUrl == "https://emodule-api.tempatkoding.com"){
                    $urlImage = url("/storage/".$pathImage);
                }else{
                    $urlImage = url('/'.$pathImage);
                }

                $data['file_material'] = $urlImage;

            }else{
                return redirect()->back()->with('success', 'Gagal Menginput Data');
            }
        }

        if ($request->tipe_material == "video") {
            $this->validate($request, [
                'material_file_video' => 'url'
            ]);

            $data['file_material'] = $request->material_file_video;
        }


        LearningMaterial::create($data);

        return redirect()->back()->with('success', 'Berhasil Menginput Data');

    }

    public function edit_material($id,$id_material){
        $detailModule = LearningModule::where('id_module', $id)->firstOrFail();
        $material = LearningMaterial::findOrFail($id_material);
        return view('edit_material', compact('detailModule','material'));
    }

    public function update_material(Request $request,$id,$id_material){

        $this->validate($request, [
            'material_title' => 'required',
            'content_material' => 'required',
            'tipe_material' => 'required',
        ]);

        $detailModule = LearningModule::where('id_module', $id)->firstOrFail();
        $material = LearningMaterial::findOrFail($id_material);

        $data = [
            'id_module' => $detailModule->id_module,
            'title_material' => $request->material_title,
            'content' => $request->content_material,
            'tipe_material' => $request->tipe_material
        ];

        if ($request->tipe_material == "gambar") {
            $this->validate($request, [
                'material_file_gambar' => 'mimes:png,jpg,jpeg|max:2046',
            ]);

            if($request->has('material_file_gambar')){
                $extArray = [
                    'jpg','png','jpeg'
                ];

                $ext = $request->material_file_gambar->getClientOriginalExtension();
                if(in_array($ext,$extArray)){
                    $pathImage =  $this->uploadFile($request->material_file_gambar,'material','image');
                    $baseUrl =  url('/');

                    if($baseUrl == "https://emodule-api.tempatkoding.com"){
                        $urlImage = url("/storage/".$pathImage);
                    }else{
                        $urlImage = url('/'.$pathImage);
                    }

                    $data['file_material'] = $urlImage;

                }else{
                    return redirect()->back()->with('success', 'Gagal Menginput Data');
                }
            }

        }

        if ($request->tipe_material == "video") {
            $this->validate($request, [
                'material_file_video' => 'url'
            ]);

            $data['file_material'] = $request->material_file_video;
        }

       $material->update($data);

        return redirect()->back()->with('success', 'Berhasil Update Data');


    }

    public function delete_material($id,$id_material){
        $material = LearningMaterial::find($id_material);
        $material->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Data');


    }

    public function tambah_practice($id,$id_material){
        $detailModule = LearningModule::where('id_module', $id)->firstOrFail();
        $material = LearningMaterial::with('practice')->findOrFail($id_material);

        return view('tambah_practice',compact('detailModule','material'));
    }

    public function store_practice(Request $request,$id,$id_material){
       $validate =  $this->validate($request, [
            'practice_title' => 'required',
            'practice_quiz' => 'required',
            'answer_choices' => 'required|array',
            'correct_answer' => 'required'
        ]);

       $data['title'] = $validate['practice_title'];
       $data['quiz'] = $validate['practice_quiz'];
       $data['id_material'] = $id_material;
       $data['answer_choices'] = json_encode($request->answer_choices);
       $data['correct_answer'] = $validate['correct_answer'];

       Practice::create($data);

       return redirect()->back()->with('success', 'Berhasil Menambahkan Data');

    }

    public function delete_practice($id,$id_material,$id_practice){
        $practice = Practice::findOrFail($id_practice);
        $practice->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
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
