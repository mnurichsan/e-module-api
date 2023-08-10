@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('modul.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Detail Module ' . $detailModule?->title_module) }}
                    </div>
                    <div class="card-body">
                        <h6>Title Module : {{ $detailModule->title_module }} </h6>
                        <h6>Author : {{ $detailModule->author }} </h6>
                        <p>Deskripsi Module : {{ $detailModule->des_module }} </p>
                        <hr>
                        <h6>Content</h6>
                        <p>{!! $detailModule->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-end">
                <a href="{{ route('material.create', $detailModule->id_module) }}" class="btn btn-primary">Tambah
                    material</a>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-text">
                            List Material Modul {{ $detailModule->title_module }}
                        </div>
                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <table class="table" id="progressTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Material</th>
                                    <th scope="col">Tipe Material</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailModule->material as $material)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $material->title_material }}
                                        </td>
                                        <td>
                                            {{ $material->tipe_material }}
                                        </td>
                                        <td>
                                            <a href="{{route('practice.create',[$detailModule->id_module, $material->id_material]) }}" class="btn btn-success">Detail</a>
                                            <a href="{{route('material.show',[$detailModule->id_module, $material->id_material]) }}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('material.delete', [$detailModule->id_module, $material->id_material]) }}"
                                                class="btn btn-danger">Hapus</a>
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
