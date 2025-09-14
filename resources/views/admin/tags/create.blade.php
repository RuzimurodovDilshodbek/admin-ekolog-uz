@extends('layouts.admin')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.tag.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tags.store") }}" enctype="multipart/form-data">
            @csrf
            <ul class="nav nav-tabs row">
                @foreach (config('app.locales') as $key_slug => $value_slug)
                    <li class=" nav-item">
                        <a href="#slug{{ $key_slug }}" class="nav-link  {{ $catTab == $key_slug ? 'active' : '' }} text-uppercase">{{ $value_slug === 'kr' ? 'ўз' : $value_slug }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content row">
                @foreach (config('app.locales') as $key_slug => $item_slug)
                    <div class="tab-pane {{ $catTab == $key_slug ? 'active' : '' }}" id="slug{{ $key_slug }}" style="width: 100%">
                        <div class="form-group">
                            {{--                            <label for="title">{{ trans('cruds.section.fields.title') }}</label>--}}
                            {{--                            <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">--}}

                            <label for="slug_{{ $item_slug }}">{{ trans('cruds.tag.fields.slug') }}({{ $item_slug === 'kr' ? 'ўз' : $item_slug }})</label>
                            <input
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                type="text"
                                name="slug_{{ $item_slug }}"
                                id="slug_{{ $item_slug }}"
                            @if($errors->has('slug'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.tag.fields.title_helper') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

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

                            <label for="title_{{ $item_title }}">{{ trans('cruds.tag.fields.title') }}({{ $item_title === 'kr' ? 'ўз' : $item_title }})</label>
                            <input
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                type="text"
                                name="title_{{ $item_title }}"
                                id="title_{{ $item_title }}"
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.tag.fields.title_helper') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', 0) == 1 || old('status') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.tag.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.status_helper') }}</span>
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
            $('#title_kr').on('blur', function () {
                let inputValue = cyrToLat($(this).val());
                if(inputValue) {
                    translate('title', inputValue)
                }
            });
        })
    </script>
@endsection
