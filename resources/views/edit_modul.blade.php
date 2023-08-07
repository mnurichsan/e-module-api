@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <a href="{{ route('modul.index') }}" class="btn btn-success">Kembali</a>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-12">
                <form method="POST" action="{{route('modul.update',$modulDetail->id_module)}}">
                    @csrf
                    <div class="card">
                        <div class="card-header">{{ __('Edit Modul '. $modulDetail->title_module) }}</div>
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
                                <label for="module-title" class="form-label">Module Title</label>
                                <input type="text" name="module_title" class="form-control" id="module-title" required
                                    placeholder="Masukkan Module Title" value="{{ $modulDetail->title_module }}">
                            </div>
                            <div class="mb-3">
                                <label for="module-author" class="form-label">Module Author</label>
                                <input type="text" name="module_author" class="form-control" id="module-author" required
                                    placeholder="Masukkan Module Author" value="{{ $modulDetail->author }}">
                            </div>
                            <div class="mb-3">
                                <label for="des-module" class="form-label">Deskripsi Module</label>
                                <textarea class="form-control" name="des_module" id="des-module" required>
                                    {{ $modulDetail->des_module }}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label for="content-module" class="form-label">Content Module</label>
                                <textarea class="form-control" name="content_module" id="content-module" required>
                                    {{ $modulDetail->content }}
                                </textarea>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary">Update</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            var editor = CKEDITOR.replace('content_module', {
                extraPlugins: 'notification'
            });

            editor.on('required', function(evt) {
                editor.showNotification('This field is required.', 'warning');
                evt.cancel();
            });
        </script>
    @endpush
@endsection
