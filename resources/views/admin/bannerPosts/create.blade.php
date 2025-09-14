@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bannerPost.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.banner-posts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="main_image">{{ trans('cruds.bannerPost.fields.main_image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('main_image') ? 'is-invalid' : '' }}" id="main_image-dropzone">
                </div>
                @if($errors->has('main_image'))
                    <span class="text-danger">{{ $errors->first('main_image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.main_image_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.bannerPost.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ old('post_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.bannerPost.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', '1') }}" step="1">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.sort_helper') }}</span>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">{{ trans('cruds.bannerPost.fields.status') }}</label>
                        </div>
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.bannerPost.fields.status_helper') }}</span>
                    </div>
                </div>
                <div class="col-10">
                    <div class="form-group">
                        <div class="form-check {{ $errors->has('header_type') ? 'is-invalid' : '' }}">
                            <input type="hidden" name="header_type" value="0">
                            <input class="form-check-input" type="checkbox" name="header_type" id="header_type" value="1">
                            <label class="form-check-label" for="header_type">{{ 'Sarlavha qora fonga chiqsin' }}</label>
                        </div>
                        @if($errors->has('header_type'))
                            <span class="text-danger">{{ $errors->first('header_type') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.bannerPost.fields.status_helper') }}</span>
                    </div>
                </div>
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
    Dropzone.options.mainImageDropzone = {
    url: '{{ route('admin.banner-posts.storeMedia') }}',
    maxFilesize: 20, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="main_image"]').remove()
      $('form').append('<input type="hidden" name="main_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="main_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($bannerPost) && $bannerPost->main_image)
      var file = {!! json_encode($bannerPost->main_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="main_image" value="' + file.file_name + '">')
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
    Dropzone.options.smallImageDropzone = {
    url: '{{ route('admin.banner-posts.storeMedia') }}',
    maxFilesize: 15, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 15,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="small_image"]').remove()
      $('form').append('<input type="hidden" name="small_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="small_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($bannerPost) && $bannerPost->small_image)
      var file = {!! json_encode($bannerPost->small_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="small_image" value="' + file.file_name + '">')
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
@endsection
