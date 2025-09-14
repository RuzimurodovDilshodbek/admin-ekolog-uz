@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.pollVariant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.poll-variants.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="poll_id">{{ trans('cruds.pollVariant.fields.poll') }}</label>
                <select class="form-control select2 {{ $errors->has('poll') ? 'is-invalid' : '' }}" name="poll_id" id="poll_id" required>
                    @foreach($polls as $id => $entry)
                        <option value="{{ $id }}" {{ old('poll_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('poll'))
                    <span class="text-danger">{{ $errors->first('poll') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVariant.fields.poll_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="title">{{ trans('cruds.pollVariant.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVariant.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort">{{ trans('cruds.pollVariant.fields.sort') }}</label>
                <input class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" type="text" name="sort" id="sort" value="{{ old('sort', '') }}">
                @if($errors->has('sort'))
                    <span class="text-danger">{{ $errors->first('sort') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVariant.fields.sort_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_coccect') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_coccect" value="0">
                    <input class="form-check-input" type="checkbox" name="is_coccect" id="is_coccect" value="1" {{ old('is_coccect', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_coccect">{{ trans('cruds.pollVariant.fields.is_coccect') }}</label>
                </div>
                @if($errors->has('is_coccect'))
                    <span class="text-danger">{{ $errors->first('is_coccect') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVariant.fields.is_coccect_helper') }}</span>
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