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

        return view('home',compact('total_siswa','total_modul','total_material','total_practice'));

    }

    public function siswa(){
        $listSiswa = User::whereRoleIs('siswa')->get();
        return view('siswa',compact('listSiswa'));
    }

    public function modul(){
        $modul = LearningModule::get();
        return view('modul',compact('modul'));
    }

    public function detail_siswa($id){
        $detailSiswa = User::whereRoleIs('siswa')->with('progress','progress.material','progress.material.module')->where('id_user',$id)->firstOrFail();
        return view('detail_siswa',compact('detailSiswa'));
    }

    public function detail_module($id){

        $detailModule = LearningModule::where('id_module',$id)->with('material','material.practice')->first();
        return view('detail_modul',compact('detailModule'));

    }

    public function tambah_module(){
        return view('tambah_modul');
    }

    public function store_module(Request $request){

        $this->validate($request,[
            'module_title'=>'required',
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

    public function delete_module($id){
        $modul = LearningModule::find($id);
        $modul->delete();

        return redirect()->back()->with('success', 'Berhasil Menghapus Data');
    }

    public function edit_module($id){
        $modulDetail = LearningModule::findOrFail($id);
        return view('edit_modul',compact('modulDetail'));
    }

    public function update_module(Request $request,$id){
        $this->validate($request,[
            'module_title'=>'required',
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
}
