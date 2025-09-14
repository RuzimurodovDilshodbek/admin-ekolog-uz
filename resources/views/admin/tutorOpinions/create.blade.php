@extends('layouts.admin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.tutorOpinion.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tutor-opinions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.tutorOpinion.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ old('post_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.tutorOpinion.fields.image') }}</label>

                <input type="file" name="image" class="image" required>
                <input type="hidden" name="image_base64">
                <img src="" style="width: 200px;display: none;" class="show-image">
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
            </div>
            <ul class="nav nav-tabs row">
                @foreach (config('app.locales') as $key_title => $value_title)
                    <li class=" nav-item">
                        <a href="#tab_short_title{{ $key_title }}" class="nav-link  {{ $catTab == $key_title ? 'active' : '' }} text-uppercase">{{ $value_title }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content row">
                @foreach (config('app.locales') as $key_title => $item_title)
                    <div class="tab-pane {{ $catTab == $key_title ? 'active' : '' }}" id="tab_short_title{{ $key_title }}" style="width: 100%">
                        <div class="form-group">
                            <label for="short_title_{{ $item_title }}">{{ trans('cruds.tutorOpinion.fields.short_title') }}({{ $item_title }})</label>
                            <input
                                class="form-control {{ $errors->has('short_title') ? 'is-invalid' : '' }}"
                                type="text"
                                name="short_title_{{ $item_title }}"
                                id="short_title_{{ $item_title }}"
                            >
                            @if($errors->has('short_title'))
                                <span class="text-danger">{{ $errors->first('short_title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.tutorOpinion.fields.short_title_helper') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
{{--            <div class="form-group">--}}
{{--                <label class="required" for="short_title">{{ trans('cruds.tutorOpinion.fields.short_title') }}</label>--}}
{{--                <input class="form-control {{ $errors->has('short_title') ? 'is-invalid' : '' }}" type="text" name="short_title" id="short_title" value="{{ old('short_title', '') }}" required>--}}
{{--                @if($errors->has('short_title'))--}}
{{--                    <span class="text-danger">{{ $errors->first('short_title') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.short_title_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="sort">{{ trans('cruds.tutorOpinion.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', '1') }}" step="1">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.sort_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.tutor-opinions.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 70,
      height: 70
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($tutorOpinion) && $tutorOpinion->image)
      var file = {!! json_encode($tutorOpinion->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
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
<script src="{{ asset('/js/translator.js')  }}"></script>
<script>
    $(document).ready(function () {
        $(".nav-tabs a").click(function(e){
            e.preventDefault();
            $(this).tab('show');
        });

        function translate(element, inputValue) {
            const locales = @json($locales);
            $.ajax({
                url: '{{ route('translateTitle') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: inputValue
                },
                success: function (response) {
                    console.log(response);
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
        $('#short_title_kr').on('blur', function () {
            let inputValue = cyrToLat($(this).val());
            if(inputValue) {
                translate('short_title', inputValue)
            }
        });
    })
</script>
@endsection
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
