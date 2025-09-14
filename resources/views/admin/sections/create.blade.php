@extends('layouts.admin')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.section.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="parent_id">{{ trans('cruds.section.fields.parent') }}</label>
                <select class="form-control select2 {{ $errors->has('parent') ? 'is-invalid' : '' }}" name="parent_id" id="parent_id">
                    @foreach($parents as $id => $entry)
                        <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('parent'))
                    <span class="text-danger">{{ $errors->first('parent') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.parent_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="slug">{{ trans('cruds.section.fields.slug') }}</label>--}}
{{--                <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', '') }}">--}}
{{--                @if($errors->has('slug'))--}}
{{--                    <span class="text-danger">{{ $errors->first('slug') }}</span>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.section.fields.slug_helper') }}</span>--}}
{{--            </div>--}}
            <ul class="nav nav-tabs row">
                @foreach (config('app.locales') as $key_title => $value_title)
                    <li class=" nav-item">
                        <a href="#title{{ $key_title }}" class="nav-link  {{ $catTab == $key_title ? 'active' : '' }} text-uppercase">{{ $value_title === 'kr' ? 'ўз' : $value_title }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content row">
                @foreach (config('app.locales') as $key_title => $item_title)
                    <div class="tab-pane {{ $catTab == $key_title ? 'active' : '' }}" id="title{{ $key_title }}" style="width: 100%">
                        <div class="form-group">
{{--                            <label for="title">{{ trans('cruds.section.fields.title') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">--}}

                            <label for="title_{{ $item_title }}">{{ trans('cruds.post.fields.title') }}({{ $item_title === 'kr' ? 'ўз' : $item_title }})</label>
                            <input
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                type="text"
                                name="title_{{ $item_title }}"
                                id="title_{{ $item_title }}"
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.section.fields.title_helper') }}</span>
                        </div>
                    </div>
                 @endforeach
            </div>


            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.section.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.section.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="text" name="sort" id="sort" value="{{ old('sort', '1') }}">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="url">{{ trans('cruds.section.fields.url') }}</label>
                <input class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" type="text" name="url" id="url" value="{{ old('url', '') }}">
                @if($errors->has('url'))
                    <span class="text-danger">{{ $errors->first('url') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.url_helper') }}</span>
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

@section('js')
<script>
    $(document).ready(function () {
        $(".nav-tabs a").click(function(e){
            e.preventDefault();
            console.log('sds');
            $(this).tab('show');
        });
    });
</script>
@stop

@section('scripts')
    <script src="{{ asset('/js/global.js') }}"></script>
    <script src="{{ asset('/js/translator.js')  }}"></script>
    <script>
        $(document).ready(function(){
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
        });
    </script>
@endsection
