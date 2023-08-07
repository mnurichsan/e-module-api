@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{route('siswa.index')}}" class="btn btn-success">Kembali</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Detail Siswa '.$detailSiswa?->fullname) }}
                    </div>
                    <div class="card-body">
                        <h6>Nama : {{$detailSiswa->fullname}} </h6>
                        <h6>Email : {{$detailSiswa->email}} </h6>

                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-text">
                            Progress List
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table" id="progressTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Modul</th>
                                    <th scope="col">Nama Material</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailSiswa->progress as $progress)
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{$progress->material->module->title_module}}
                                        </td>
                                        <td>
                                            {{$progress->material->title_material}}
                                        </td>
                                        <td>
                                            {{$progress->score}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#progressTable').DataTable();
            });
        </script>
    @endpush
@endsection
