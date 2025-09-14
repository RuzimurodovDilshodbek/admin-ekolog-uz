@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.video.title_singular') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.videoUpdateSort") }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">1 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_1" id="sort_1" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',1)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">2 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_2" id="sort_2" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',2)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">3 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_3" id="sort_3" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',3)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">4 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_4" id="sort_4" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',4)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">5 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_5" id="sort_5" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',5)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">6 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_6" id="sort_6" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }} >{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',6)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required">7 - videoni tanlang</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="sort_7" id="sort_7" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($videos as $key => $item)
                        <option value="{{ $item->id }}" {{ $item->id === \App\Models\Video::query()->where('sort',7)->first()?->id ? 'selected' : '' }}>{{ $item->title_kr }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bannerPost.fields.type_helper') }}</span>
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
        })
    </script>
@endsection
