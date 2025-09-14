@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.dailiyVerse.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dailiy-verses.update", [$dailiyVerse->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="text">{{ trans('cruds.dailiyVerse.fields.text') }}</label>
                <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text" id="text">{{ old('text', $dailiyVerse->text) }}</textarea>
                @if($errors->has('text'))
                    <span class="text-danger">{{ $errors->first('text') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dailiyVerse.fields.text_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ $dailiyVerse->status || old('status', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">{{ trans('cruds.dailiyVerse.fields.status') }}</label>
                </div>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dailiyVerse.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.dailiyVerse.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="number" name="sort" id="sort" value="{{ old('sort', $dailiyVerse->sort) }}" step="1">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dailiyVerse.fields.sort_helper') }}</span>
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