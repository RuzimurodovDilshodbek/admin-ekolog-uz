@extends('layouts.admin')
{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css" />--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<link rel="stylesheet" href="{{ asset('/administrator/summernote/summernote-bs4.css')  }}">
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.tutor.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tutors.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="slug">{{ trans('cruds.tutor.fields.slug') }}</label>
                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                @if($errors->has('slug'))
                    <span class="text-danger">{{ $errors->first('slug') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="firstname">{{ trans('cruds.tutor.fields.firstname') }}</label>
                <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', '') }}">
                @if($errors->has('firstname'))
                    <span class="text-danger">{{ $errors->first('firstname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.firstname_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="lastname">{{ trans('cruds.tutor.fields.lastname') }}</label>
                <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', '') }}">
                @if($errors->has('lastname'))
                    <span class="text-danger">{{ $errors->first('lastname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.lastname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="detail_image">{{ trans('cruds.tutor.fields.photo') }}</label>
                <input type="file" name="image" class="image">
                <input type="hidden" name="image_base64">
                <img src="" style="width: 200px;display: none;" class="show-image">
{{--                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">--}}
{{--                </div>--}}
{{--                @if($errors->has('photo'))--}}
{{--                    <span class="text-danger">{{ $errors->first('photo') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.tutor.fields.photo_helper') }}</span>--}}
            </div>
            <ul class="nav nav-tabs row">
                @foreach (config('app.locales') as $key_about => $value_about)
                    <li class=" nav-item">
                        <a href="#tab_{{ $value_about }}" class="nav-link  {{ $catTab == $key_about ? 'active' : '' }} text-uppercase">{{ $value_about === 'kr' ? 'ўз' : $value_about}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content row">
                @foreach (config('app.locales') as $key_about => $item_about)
                    <div class="tab-pane {{ $catTab == $key_about ? 'active' : '' }}" id="tab_{{ $item_about }}" style="width: 100%">
                        <div class="form-group">
                            <label for="content">{{ trans('cruds.post.fields.content') }}({{ $item_about === 'kr' ? 'ўз' : $item_about }})</label>
                            <textarea id="content_{{ $item_about }}" class="textarea form-control summernote"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                                      name="content_{{ $item_about }}"
                            >
                            </textarea>

                            {{--                            <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content_{{ $item_content }}" id="content_{{ $item_content }}"></textarea>--}}
                            @if($errors->has('content'))
                                <span class="text-danger">{{ $errors->first('about') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.tutor.fields.about_helper') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

{{--            <div class="form-group">--}}
{{--                <label for="about">{{ trans('cruds.tutor.fields.about') }}</label>--}}
{{--                <textarea class="form-control ckeditor {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" id="about">{!! old('about') !!}</textarea>--}}
{{--                @if($errors->has('about'))--}}
{{--                    <span class="text-danger">{{ $errors->first('about') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.tutor.fields.about_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="facebook">{{ trans('cruds.tutor.fields.facebook') }}</label>
                <input class="form-control {{ $errors->has('facebook') ? 'is-invalid' : '' }}" type="text" name="facebook" id="facebook" value="{{ old('facebook', '') }}">
                @if($errors->has('facebook'))
                    <span class="text-danger">{{ $errors->first('facebook') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.facebook_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="twitter">{{ trans('cruds.tutor.fields.twitter') }}</label>
                <input class="form-control {{ $errors->has('twitter') ? 'is-invalid' : '' }}" type="text" name="twitter" id="twitter" value="{{ old('twitter', '') }}">
                @if($errors->has('twitter'))
                    <span class="text-danger">{{ $errors->first('twitter') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.twitter_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gmail">{{ trans('cruds.tutor.fields.gmail') }}</label>
                <input class="form-control {{ $errors->has('gmail') ? 'is-invalid' : '' }}" type="text" name="gmail" id="gmail" value="{{ old('gmail', '') }}">
                @if($errors->has('gmail'))
                    <span class="text-danger">{{ $errors->first('gmail') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.gmail_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rss">{{ trans('cruds.tutor.fields.rss') }}</label>
                <input class="form-control {{ $errors->has('rss') ? 'is-invalid' : '' }}" type="text" name="rss" id="rss" value="{{ old('rss', '') }}">
                @if($errors->has('rss'))
                    <span class="text-danger">{{ $errors->first('rss') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.rss_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="youtube">{{ trans('cruds.tutor.fields.youtube') }}</label>
                <input class="form-control {{ $errors->has('youtube') ? 'is-invalid' : '' }}" type="text" name="youtube" id="youtube" value="{{ old('youtube', '') }}">
                @if($errors->has('youtube'))
                    <span class="text-danger">{{ $errors->first('youtube') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.youtube_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="linkedin">{{ trans('cruds.tutor.fields.linkedin') }}</label>
                <input class="form-control {{ $errors->has('linkedin') ? 'is-invalid' : '' }}" type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', '') }}">
                @if($errors->has('linkedin'))
                    <span class="text-danger">{{ $errors->first('linkedin') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.linkedin_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="telegram">{{ trans('cruds.tutor.fields.telegram') }}</label>
                <input class="form-control {{ $errors->has('telegram') ? 'is-invalid' : '' }}" type="text" name="telegram" id="telegram" value="{{ old('telegram', '') }}">
                @if($errors->has('telegram'))
                    <span class="text-danger">{{ $errors->first('telegram') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.telegram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instagram">{{ trans('cruds.tutor.fields.instagram') }}</label>
                <input class="form-control {{ $errors->has('instagram') ? 'is-invalid' : '' }}" type="text" name="instagram" id="instagram" value="{{ old('instagram', '') }}">
                @if($errors->has('instagram'))
                    <span class="text-danger">{{ $errors->first('instagram') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.instagram_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.tutor.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', '1') }}" step="1">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.sort_helper') }}</span>
            </div>

            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.tutor.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutor.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Расмни қуйидагича қирқиб олинг</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Бекор қилиш</button>
                <button type="button" class="btn btn-primary" id="crop">Қирқиш</button>
            </div>
        </div>
    </div>
</div>




@endsection
@section('js')
    <script src="{{ asset('/administrator/select2-bootstrap4-theme/select2-bootstrap4.min.css')  }}"></script>
    <script>
        $('.select2').select2()
    </script>
    <script src="{{ asset('/administrator/summernote/summernote-bs4.min.js')  }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
            });
        });
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });
    </script>
@stop

@section('scripts')
    <script src="{{ asset('/js/global.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
            });
        });
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });
        });
    </script>
    <script src="{{ asset('/administrator/summernote/summernote-bs4.min.js')  }}"></script>

    <script>
        $('.select2').select2()
    </script>
    <script src="{{ asset('/administrator/select2-bootstrap4-theme/select2-bootstrap4.min.css')  }}"></script>

    <script src="{{ asset('/js/translator.js')  }}"></script>
    <script>
        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        /*------------------------------------------
        --------------------------------------------
        Image Change Event
        --------------------------------------------
        --------------------------------------------*/
        $("body").on("change", ".image", function(e){
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        /*------------------------------------------
        --------------------------------------------
        Show Model Event
        --------------------------------------------
        --------------------------------------------*/
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        /*------------------------------------------
        --------------------------------------------
        Crop Button Click Event
        --------------------------------------------
        --------------------------------------------*/
        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 1920,
                height: 1280,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $("input[name='image_base64']").val(base64data);
                    $(".show-image").show();
                    $(".show-image").attr("src",base64data);
                    $("#modal").modal('toggle');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function (file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '{{ route('admin.posts.storeCKEditorImages') }}', true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() { reject(genericErrorText) });
                                        xhr.addEventListener('abort', function() { reject() });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                                            }

                                            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                                            resolve({ default: response.url });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $post->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }
            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }

            $(".nav-tabs a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
    <script>
        Dropzone.options.detailImageDropzone = {
            url: '{{ route('admin.posts.storeMedia') }}',
            maxFilesize: 15, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 15,
                width: 160,
                height: 160
            },
            success: function (file, response) {
                $('form').find('input[name="detail_image"]').remove()
                $('form').append('<input type="hidden" name="detail_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="detail_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($post) && $post->detail_image)
                var file = {!! json_encode($post->detail_image) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="detail_image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        Dropzone.options.cardImageDropzone = {
            url: '{{ route('admin.posts.storeMedia') }}',
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 10,
                width: 160,
                height: 160
            },
            success: function (file, response) {
                $('form').find('input[name="card_image"]').remove()
                $('form').append('<input type="hidden" name="card_image" value="' + response.name + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('form').find('input[name="card_image"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                @if(isset($post) && $post->card_image)
                var file = {!! json_encode($post->card_image) !!}
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="card_image" value="' + file.file_name + '">')
                this.options.maxFiles = this.options.maxFiles - 1
                @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            // $('.summernote').summernote({
            //     // 'justifyFull',
            //     textAlign: 'justify',
            // });
            // $('.summernote').forEach((element) => {
            //     element.summernote('justifyFull');
            // });
            // $('#tab_kr').summernote('justifyFull');

            function translate(element, inputValue) {
                const locales = @json($locales);
                $.ajax({
                    url: '{{ route('translate') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: inputValue
                    },
                    success: function (response) {
                        locales.forEach((locale, index) => {
                            if(locale !== 'kr') {
                                $('#' + element + '_' + locale).val(response.data[index-1]);
                            }
                        })
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            $('#title_kr').on('blur', function () {
                var inputValue = $(this).val();
                const translatedValue = cyrToLat(inputValue);
                if(translatedValue) {
                    translate('title', translatedValue)
                }
            });
            $('#description_kr').on('blur', function () {
                var inputValue = $(this).val();
                const translatedValue = cyrToLat(inputValue);
                if(translatedValue) {
                    translate('description', translatedValue)
                }
            });
            {{--$('#tab_kr').find('.note-editable.card-block').on('blur', function () {--}}
            {{--    //     const element = document.getElementById('tab_kr').getElementsByClassName('note-editable')[0];--}}
            {{--    // const element = $('#tab_kr').find('.note-editable.card-block');--}}
            {{--    const element = $(this)[0];--}}

            {{--    console.log(element);--}}

            {{--    if(element) {--}}
            {{--        const locales = @json($locales);--}}
            {{--        $.ajax({--}}
            {{--            url: '{{ route('translate') }}',--}}
            {{--            method: 'POST',--}}
            {{--            data: {--}}
            {{--                _token: '{{ csrf_token() }}',--}}
            {{--                data: element.outerHTML--}}
            {{--            },--}}
            {{--            success: function (response) {--}}
            {{--                console.log(response);--}}
            {{--                locales.forEach((locale, index) => {--}}
            {{--                    if(locale !== 'kr') {--}}
            {{--                        // let changedElement = $('#tab_' + locale).find('.note-editable.card-block')[0];--}}
            {{--                        if(document.getElementById('tab_' + locale).getElementsByClassName('note-editable')[0]) {--}}
            {{--                            document.getElementById('tab_' + locale).getElementsByClassName('note-editable')[0].outerHTML = response.data[index-1];--}}
            {{--                        }--}}
            {{--                    }--}}
            {{--                })--}}
            {{--            },--}}
            {{--            error: function (xhr, status, error) {--}}
            {{--                console.error(xhr.responseText);--}}
            {{--            }--}}
            {{--        });--}}
            {{--    }--}}
            {{--});--}}
        })
    </script>
@endsection
<style>
    .label-for-checkbox{
        font-weight: 700;
        font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        font-size: 1rem;
        line-height: 1.5;
        color: #212529;
        text-align: lef
    }
</style>
<style type="text/css">
    body{
        background: #f7fbf8;
    }
    h1{
        font-weight: bold;
        font-size:23px;
    }
    img {
        display: block;
        max-width: 100%;
    }
    .preview {
        text-align: center;
        overflow: hidden;
        width: 240px!important;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
    input{
        margin-top:40px;
    }
    .section{
        margin-top:150px;
        background:#fff;
        padding:50px 30px;
    }
    .modal-lg{
        max-width: 1000px !important;
    }
    .hidden-button{
        display: none;
    }
</style>
