@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('List Siswa') }}</div>
                    <div class="card-body">
                        <table class="table" id="siswaTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fullname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listSiswa as $siswa)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$siswa->fullname}}</td>
                                    <td>{{$siswa->email}}</td>
                                    <td><a href="{{route('siswa.show',$siswa->id_user)}}" class="btn btn-success">Detail</td>
                                </tr>
                                @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function() {
                $('#siswaTable').DataTable();
            });
        </script>
    @endpush
@endsection
