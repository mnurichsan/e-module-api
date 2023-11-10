@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('siswa.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Detail Siswa ' . $detailSiswa?->fullname) }}
                    </div>
                    <div class="card-body">

                        <div class="d-flex bd-highlight">
                            <div class="p-2 w-100 bd-highlight">
                                <h6>Nama : {{ $detailSiswa->fullname }} </h6>
                                <h6>Email : {{ $detailSiswa->email }} </h6>
                            </div>

                            <div class="p-2 flex-shrink-1 bd-highlight">
                                @if ($detailSiswa->image != null)
                                    <img src="{{ $detailSiswa->image }}" class="img-thumbnail" width="100" height="80"
                                        alt="...">
                                @else
                                    <img src="https://static.vecteezy.com/system/resources/previews/008/442/086/original/illustration-of-human-icon-user-symbol-icon-modern-design-on-blank-background-free-vector.jpg"
                                        class="img-thumbnail" width="100" height="80" alt="...">
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Progress Bar
                    </div>
                    <div class="card-body">
                        @foreach ($moduls as $key => $modul)
                            @php
                                $totalMaterial = $modul->material->count();
                                foreach ($modul->material as $mId => $material) {
                                    if ($material->progress != null) {
                                        array_push($varTotalProgress, [
                                            'id_module' => $modul->id_module,
                                            'material_id' => $material->id_material,
                                        ]);
                                    }
                                }
                                $dataProgress = collect($varTotalProgress);
                                $data = $dataProgress->where('id_module', $modul->id_module);

                                $percentage = 100 / $totalMaterial;
                                $totalPecentage = round($percentage * $data->count());
                            @endphp
                            <ul>
                                <li>
                                    <h3>{{ $modul->title_module }}</h3>

                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $totalPecentage }}%"
                                            aria-valuenow="{{ $totalPecentage }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ $totalPecentage ?? 0 }}% </div>
                                    </div>
                                </li>
                            </ul>
                        @endforeach

                    </div>

                </div>

                <div class="card mt-2">
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
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $progress->material->module->title_module }}
                                        </td>
                                        <td>
                                            {{ $progress->material->title_material }}
                                        </td>
                                        <td>
                                            {{ $progress->score }}
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
