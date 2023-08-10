@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('modul.show', $detailModule->id_module) }}" class="btn btn-success">Kembali</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __($material?->title_material) }}
                    </div>
                    <div class="card-body">
                        <h6>Title Material : {{ $material->title_material }} </h6>
                        <p>Tipe Material : {{ $material->content }} </p>
                        @if ($material->tipe_material != 'text')
                            <p> File Material : <a href="{{ $material->file_material }}" target="_blank"
                                    class="btn btn-sm btn-success"> Lihat </a>
                        @endif
                        <hr>
                        <h6>Content</h6>
                        <p>{!! $material->content !!}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-text">
                            List Practice Material {{ $material->title_material }}
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPractice">
                                Tambah Practice
                              </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <table class="table" id="praticeTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Quiz</th>
                                    <th scope="col">Answer Choices</th>
                                    <th scope="col">Correct Answer</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($material->practice as $practice)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $practice->title }}
                                        </td>
                                        <td>
                                            {!! $practice->quiz !!}
                                        </td>
                                        <td>
                                            {{ json_encode($practice->answer_choices) }}
                                        </td>
                                        <td>
                                            {{ $practice->correct_answer }}

                                        </td>
                                        <td>
                                            <a href="{{route('practice.delete',[$detailModule->id_module, $material->id_material,$practice->id_quiz])}}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalPractice" tabindex="-1" aria-labelledby="modalPracticeLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPracticeLabel">Tambah Practice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{route('practice.store',[$detailModule->id_module, $material->id_material] )}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">{{ __('Create Practice') }}</div>
                                <div class="card-body">


                                    <div class="mb-3">
                                        <label for="practice-title" class="form-label">Practice Title</label>
                                        <input type="text" name="practice_title" class="form-control" id="practice-title"
                                            required placeholder="Masukkan Practice Title">
                                    </div>

                                    <div class="mb-3">
                                        <label for="practice-quiz" class="form-label">Quiz</label>
                                        <textarea class="form-control" name="practice_quiz" id="practice-quiz" required></textarea>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <div class="card-text">
                                                Answer Choices
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="a" class="form-label">Soal A</label>
                                                <input type="text" name="answer_choices[]" class="form-control"
                                                    id="a" required placeholder="Masukkan Soal A">
                                            </div>
                                            <div class="mb-3">
                                                <label for="b" class="form-label">Soal B</label>
                                                <input type="text" name="answer_choices[]" class="form-control"
                                                    id="b" required placeholder="Masukkan Soal B">
                                            </div>
                                            <div class="mb-3">
                                                <label for="c" class="form-label">Soal C</label>
                                                <input type="text" name="answer_choices[]" class="form-control"
                                                    id="c" required placeholder="Masukkan Soal C">
                                            </div>
                                            <div class="mb-3">
                                                <label for="d" class="form-label">Soal D</label>
                                                <input type="text" name="answer_choices[]" class="form-control"
                                                    id="d" required placeholder="Masukkan Soal D">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="correct-answer" class="form-label">Correct Answer</label>
                                        <input type="text" name="correct_answer" class="form-control" id="correct-answer"
                                            required placeholder="Masukkan Correct Answer">
                                    </div>


                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary">Submit</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            var editor = CKEDITOR.replace('practice_quiz', {
                extraPlugins: 'notification'
            });

            editor.on('required', function(evt) {
                editor.showNotification('This field is required.', 'warning');
                evt.cancel();
            });

            $(document).ready(function() {
                $('#praticeTable').DataTable();
            });
        </script>
    @endpush
@endsection
