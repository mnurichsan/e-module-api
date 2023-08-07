@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col ">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h2>Total Siswa </h2>
                        <h2>{{$total_siswa}}</h2>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h2>Total Modul </h2>
                        <h2>{{$total_modul}}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h2>Total Material </h2>
                        <h2>{{$total_material}}</h2>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h2>Total Practice </h2>
                        <h2>{{$total_practice}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h3>{{ __('Selamat Datang, '.Auth::user()->fullname) }}</h3>
                        <div class="text-center">
                            <img src="{{asset('home.svg')}}" class="img" />

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
