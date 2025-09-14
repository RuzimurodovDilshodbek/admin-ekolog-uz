@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.tutorOpinion.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tutor-opinions.update", [$tutorOpinion->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.tutorOpinion.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('post_id') ? old('post_id') : $tutorOpinion->post->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.tutorOpinion.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.image_helper') }}</span>
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
                                value="{{ old('short_title_'.$item_title, $tutorOpinion['short_title_'.$item_title]) }}"
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
{{--                <input class="form-control {{ $errors->has('short_title') ? 'is-invalid' : '' }}" type="text" name="short_title" id="short_title" value="{{ old('short_title', $tutorOpinion->short_title) }}" required>--}}
{{--                @if($errors->has('short_title'))--}}
{{--                    <span class="text-danger">{{ $errors->first('short_title') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.tutorOpinion.fields.short_title_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="sort">{{ trans('cruds.tutorOpinion.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', $tutorOpinion->sort) }}" step="1">
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
