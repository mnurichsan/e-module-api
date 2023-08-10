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
                        {{ __($detailModule?->title_module) }}
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

        <div class="row justify-content-center mt-2">
            <div class="col-md-12">
                <form method="POST" action="{{ route('material.post',$detailModule->id_module) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">{{ __('Create Material') }}</div>
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

                            <div class="mb-3">
                                <label for="material-title" class="form-label">Materia Title</label>
                                <input type="text" name="material_title" class="form-control" id="material-title"
                                    required placeholder="Masukkan Material Title">
                            </div>

                            <div class="mb-3">
                                <label for="content-material" class="form-label">Content Material</label>
                                <textarea class="form-control" name="content_material" id="content-material" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tipe_material" class="form-label">Tipe Material</label>
                                <select class="form-control" name="tipe_material" id="tipematerial" required>
                                    <option value="text">Text</option>
                                    <option value="gambar">Gambar</option>
                                    <option value="video">Video</option>
                                </select>
                            </div>

                            <div class="mb-3" id="materialfile" style="display:none">
                                <label for="material-file-gambar" class="form-label">Materia File Gambar</label>
                                <input type="file" name="material_file_gambar" class="form-control" id="material-file-gambar"
                                    placeholder="Masukkan Material File Gambar">
                            </div>

                            <div class="mb-3" id="materialfilevideo" style="display:none">
                                <label for="material-file-video" class="form-label">Materia Link Video</label>
                                <input type="text" name="material_file_video" class="form-control"
                                    id="material-file-video" placeholder="Masukkan Material Link Video">
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
    @push('js')
        <script>
            var editor = CKEDITOR.replace('content_material', {
                extraPlugins: 'notification'
            });

            editor.on('required', function(evt) {
                editor.showNotification('This field is required.', 'warning');
                evt.cancel();
            });

            $('#tipematerial').on('change', function() {
                if(this.value == 'video'){
                    $('#materialfilevideo').show();
                    $('#materialfile').hide();
                }else if(this.value == 'gambar'){
                    $('#materialfilevideo').hide();
                    $('#materialfile').show();
                }else{
                    $('#materialfilevideo').hide();
                    $('#materialfile').hide();
                }
            });
        </script>
    @endpush
@endsection
