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
            {{ trans('global.create') }} {{ trans('cruds.post.title_singular') }}
        </div>

        <div class="card-body">
            <form id="quotationCreateForm" method="POST" action="{{ route("admin.quotations.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="d-flex">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status" value="1" name="status" checked>
                            <label class="form-check-label" for="status">актив</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="status" value="2" name="status">
                            <label class="form-check-label" for="status">архив</label>
                        </div>
                    </div>
                </div>

{{--                <ul class="nav nav-tabs row">--}}
{{--                    @foreach (config('app.locales') as $key_content => $value_content)--}}
{{--                        <li class=" nav-item">--}}
{{--                            <a href="#tab_{{ $value_content }}" class="nav-link  {{ $catTab == $key_content ? 'active' : '' }} text-uppercase">{{ $value_content === 'kr' ? 'ўз' : $value_content}}</a>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--                <div class="tab-content row">--}}
{{--                    @foreach (config('app.locales') as $key_content => $item_content)--}}
{{--                        <div class="tab-pane {{ $catTab == $key_content ? 'active' : '' }}" id="tab_{{ $item_content }}" style="width: 100%">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="content">{{ trans('cruds.post.fields.content') }}({{ $item_content === 'kr' ? 'ўз' : $item_content }})</label>--}}
{{--                                <textarea id="content_{{ $item_content }}" class="textarea form-control summernote"--}}
{{--                                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"--}}
{{--                                          name="content_{{ $item_content }}"--}}
{{--                                >--}}
{{--                            </textarea>--}}
{{--                                @if($errors->has('content'))--}}
{{--                                    <span class="text-danger">{{ $errors->first('content') }}</span>--}}
{{--                                @endif--}}
{{--                                <span class="help-block">{{ trans('cruds.post.fields.content_helper') }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                <ul class="nav nav-tabs row">
                    @foreach (config('app.locales') as $key_title => $value_title)
                        <li class=" nav-item">
                            <a href="#tabtitle{{ $key_title }}" class="nav-link  {{ $catTab == $key_title ? 'active' : '' }} text-uppercase">{{ $value_title === 'kr' ? 'ўз' : $value_title }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content row">
                    @foreach (config('app.locales') as $key_title => $item_title)
                        <div class="tab-pane {{ $catTab == $key_title ? 'active' : '' }}" id="tabtitle{{ $key_title }}" style="width: 100%">
                            <div class="form-group">
                                <label for="title_{{ $item_title }}">{{ trans('cruds.post.fields.title') }}({{ $item_title === 'kr' ? 'ўз' : $item_title }})</label>
                                <input
                                    class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                    type="text"
                                    name="title_{{ $item_title }}"
                                    id="title_{{ $item_title }}"
                                    value="{{ old('title', '') }}"
                                >
                                @if($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <ul class="nav nav-tabs row">
                    @foreach (config('app.locales') as $key_title => $value_title)
                        <li class=" nav-item">
                            <a href="#authorName{{ $key_title }}" class="nav-link  {{ $catTab == $key_title ? 'active' : '' }} text-uppercase">{{ $value_title === 'kr' ? 'ўз' : $value_title }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content row">
                    @foreach (config('app.locales') as $key_title => $item_title)
                        <div class="tab-pane {{ $catTab == $key_title ? 'active' : '' }}" id="authorName{{ $key_title }}" style="width: 100%">
                            <div class="form-group">
                                <label for="author_name">Муаллиф исми({{$item_title === 'kr' ? 'ўз' : $item_title }})</label>
                                <input
                                    class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                    type="text"
                                    name="author_name_{{ $item_title }}"
                                    id="author_name_{{ $item_title }}"
                                    value="{{ old('author_name', '') }}"
                                >
                                @if($errors->has('author_name'))
                                    <span class="text-danger">{{ $errors->first('author_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.post.fields.title_helper') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
{{--                <div class="tab-content row">--}}
{{--                    <div style="width: 100%">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="author_name">{{ 'Муаллиф исми' }}</label>--}}
{{--                            <input--}}
{{--                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"--}}
{{--                                type="text"--}}
{{--                                name="author_name"--}}
{{--                                id="author_name"--}}
{{--                                value="{{ old('author_name', '') }}"--}}
{{--                            >--}}
{{--                            @if($errors->has('author_name'))--}}
{{--                                <span class="text-danger">{{ $errors->first('author_name') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="form-group">
                    <label for="detail_image">{{ trans('cruds.post.fields.detail_image') }}</label>

                    <input type="file" name="image" class="image" required>
                    <input type="hidden" name="image_base64">
                    <img src="" style="width: 200px;display: none;" class="show-image">
                </div>

                <div class="form-group " type="submit">
                    <button id="sendPost" class="btn btn-danger" value="save and translate">
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
    <script src="{{ asset('/administrator/summernote/summernote-bs4.min.js')  }}"></script>
    <script>
        $('.select2').select2();
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
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['mybutton', ['custom']]
                ],
                buttons: {
                    custom: CustomButton
                }
            });

            function CustomButton(context) {
                var ui = $.summernote.ui;
                var button = ui.button({
                    contents: '<i class="fa fa-quote-left"/>',
                    tooltip: 'Blockquote',
                    click: function () {
                        context.invoke('editor.formatBlock', 'blockquote');
                    }
                });

                return button.render();
            }
        });
        $(document).ready(function() {
            $('.summernote').summernote('justifyFull');
        });
        $(document).ready(function(){
            $(".nav-tabs a").click(function(){
                $(this).tab('show');
            });

            $('.select2').select2({
                tags: true,
                createTag: function (tag) {
                    return {
                        id: tag.term,
                        text: tag.term,
                        // add indicator:
                        isNew : true
                    };
                }
            }).on("select2:select", function(e) {
                if(e.params.data.isNew){
                    console.log(e.params.data)
                    // append the new option element prenamently:

                    // store the new tag:
                    $.ajax({
                        url: '{{ route('tags.trsTagCreate') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            data: e.params.data.text
                        },
                        success: function (response) {
                            if (response && response.data && response.data.id) {
                                $(this).find('[value="'+e.params.data.id+'"]').replaceWith('<option selected value="'+response.data.id+'">'+response.data.title_en+'</option>');
                            }
                            console.log(response.data.id)
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('/administrator/summernote/summernote-bs4.min.js')  }}"></script>

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
                aspectRatio: 1.5,
                viewMode: 3,
                preview: '.preview',
                crop: function(e) {
                    console.log(e.detail.x);
                    console.log(e.detail.y);
                },
                center: true,
                data:{ //define cropbox size
                    x: 160,
                    y: 0,
                    height:  1050,
                    width: 1940,
                }
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

            var checkboxes = $('.section-checkboxes');
            checkboxes.change(function(){
                if($('.section-checkboxes:checked').length>0) {
                    checkboxes.removeAttr('required');
                } else {
                    checkboxes.attr('required', 'required');
                }
            });
            async function translateTitle(element, inputValue) {
                const locales = @json($locales);
                await $.ajax({
                    url: '{{ route('translateTitle') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: inputValue
                    },
                    success: function (response) {
                        locales.forEach((locale, index) => {
                            if(locale !== 'kr') {
                                if(!$('#' + element + '_' + locale)[0].value) {
                                    $('#' + element + '_' + locale).val(response.data[index-1]);
                                }
                            }
                        })
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            async function translateContent(element) {
                const imageSrc = [...element.getElementsByTagName('img')].map(img =>
                    img.getAttribute('src'),
                );
                if([...element.getElementsByTagName('img')].length) {
                    [...element.getElementsByTagName('img')].map((f) => {
                        f.setAttribute('src', null)
                    });
                }
                let toLatinData = cyrToLat(element.innerHTML.toString());
                if(toLatinData) {
                    const locales = @json($locales);
                    await $.ajax({
                        url: '{{ route('translate') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            data: toLatinData
                        },
                        success: function (response) {
                            locales.forEach((locale, index) => {
                                let demoElement = document.createElement("div");
                                demoElement.innerHTML = response.data[index-1];
                                [...demoElement.getElementsByTagName('img')].map((f, index) => {
                                    f.setAttribute('src', imageSrc[index]);
                                    return f
                                });

                                if(locale !== 'kr') {
                                    if (!$('#tab_' + locale).find('.note-editable.card-block')[0].innerText || $('#tab_' + locale).find('.note-editable.card-block')[0].innerText.trim() === '' ) {
                                        $('#tab_' + locale).find('.summernote').summernote('code', demoElement.innerHTML);
                                    }
                                }
                            })
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }
            $('#title_kr').on('blur', function () {
                var inputValue = $(this).val();
                const translatedValue = cyrToLat(inputValue);
                if(translatedValue) {
                    translateTitle('title', translatedValue)
                }
            });
            $('#author_name_kr').on('blur', function () {
                var inputValue = $(this).val();
                const translatedValue = cyrToLat(inputValue);
                if(translatedValue) {
                    translateTitle('author_name', translatedValue)
                }
            });
            $('#tab_kr').find('.note-editable.card-block').on('blur', function () {
                let e = $(this).clone();
                const element = e[0];
                if(element.innerText.trim()) {
                    translateContent(element);
                }
            });
            $('#quotationCreateForm')[0].addEventListener('submit', async (e) => {
                e.preventDefault();
                if($('#title_kr')[0].value && (!$('#title_uz')[0].value || !$('#title_ru')[0].value || !$('#title_en')[0].value || !$('#title_ru')[0].value)) {
                    let inputValue = $('#title_kr')[0].value;
                    const translatedValue = cyrToLat(inputValue);
                    if(translatedValue) {
                        await translateTitle('title', translatedValue)
                    }
                }
                if($('#author_name_kr')[0].value && (!$('#author_name_uz')[0].value || !$('#author_name_ru')[0].value || !$('#author_name_en')[0].value || !$('#author_name_ru')[0].value)) {
                    let inputValue = $('#author_name_kr')[0].value;
                    const translatedValue = cyrToLat(inputValue);
                    if(translatedValue) {
                        await translateTitle('author_name', translatedValue)
                    }
                }
                // if (
                //     $('#tab_kr').find('.note-editable.card-block')[0].innerText &&
                //     (!$('#tab_uz').find('.note-editable.card-block')[0].innerText || !$('#tab_ru').find('.note-editable.card-block')[0].innerText || !$('#tab_en').find('.note-editable.card-block')[0].innerText || !$('#tab_tr').find('.note-editable.card-block')[0].innerText)
                // ) {
                //     // let el = $(this).clone();
                //     let el = $('#tab_kr').find('.note-editable.card-block').clone();
                //     // console.log($('#tab_kr').find('.summernote'));
                //     const element = el[0];
                //     await translateContent(element);
                // }

                $('#quotationCreateForm')[0].submit();
            })

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
