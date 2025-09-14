@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">Видео категорияси қўшиш</div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.video-category.store") }}" enctype="multipart/form-data">
            @csrf

            <ul class="nav nav-tabs row">
                @foreach (config('app.locales') as $key_title => $value_title)
                    <li class=" nav-item">
                        <a href="#tabtitle{{ $key_title }}" class="nav-link  {{ $catTab == $key_title ? 'active' : '' }} text-uppercase">{{ $value_title }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content row">
                @foreach (config('app.locales') as $key_title => $item_title)
                    <div class="tab-pane {{ $catTab == $key_title ? 'active' : '' }}" id="tabtitle{{ $key_title }}" style="width: 100%">
                        <div class="form-group">
                            <label for="title_{{ $item_title }}">{{ trans('cruds.video.fields.title') }}({{ $item_title }})</label>
                            <input
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                type="text"
                                name="title_{{ $item_title }}"
                                id="title_{{ $item_title }}"
                            >
                            @if($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.video.fields.title_helper') }}</span>
                        </div>
                    </div>
                @endforeach
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
