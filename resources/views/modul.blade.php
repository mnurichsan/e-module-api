@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('modul.create') }}" class="btn btn-primary">Tambah Modul</a>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('List Modul') }}</div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
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
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $m->title_module }}</td>
                                        <td>{{ $m->des_module }}</td>
                                        <td>{{ $m->author }}</td>
                                        <td>
                                            <a href="{{ route('modul.show', $m->id_module) }}"
                                                class="btn btn-success">Detail</a>
                                                <a href="{{ route('modul.edit', $m->id_module) }}"
                                                    class="btn btn-warning">Edit</a>
                                            <a href="{{ route('modul.delete', $m->id_module) }}"
                                                class="btn btn-danger">Delete</a>
                                        </td>
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
