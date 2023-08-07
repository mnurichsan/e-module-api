@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('List Modul') }}</div>
                    <div class="card-body">
                        <table class="table" id="modulTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Deskirpsi Modul</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modul as $m)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$m->title_module}}</td>
                                    <td>{{$m->des_module}}</td>
                                    <td>{{$m->author}}</td>
                                    <td><a href="{{route('modul.show',$m->id_module)}}" class="btn btn-success">Detail</td>
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
                $('#modulTable').DataTable();
            });
        </script>
    @endpush
@endsection
