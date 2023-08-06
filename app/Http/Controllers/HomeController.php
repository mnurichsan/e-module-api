<?php

namespace App\Http\Controllers;

use App\Models\LearningModule;
use App\Models\User;
use Illuminate\Http\Request;

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
        return view('home');
    }

    public function siswa(){
        $listSiswa = User::whereRoleIs('siswa')->get();
        return view('siswa',compact('listSiswa'));
    }

    public function modul(){
        $modul = LearningModule::get();
        return view('modul',compact('modul'));
    }
}
