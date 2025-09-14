@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.adView.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ad-views.update", [$adView->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="client_ip">{{ trans('cruds.adView.fields.client_ip') }}</label>
                <input class="form-control {{ $errors->has('client_ip') ? 'is-invalid' : '' }}" type="text" name="client_ip" id="client_ip" value="{{ old('client_ip', $adView->client_ip) }}" required>
                @if($errors->has('client_ip'))
                    <span class="text-danger">{{ $errors->first('client_ip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.adView.fields.client_ip_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ad_id">{{ trans('cruds.adView.fields.ad') }}</label>
                <select class="form-control select2 {{ $errors->has('ad') ? 'is-invalid' : '' }}" name="ad_id" id="ad_id" required>
                    @foreach($ads as $id => $entry)
                        <option value="{{ $id }}" {{ (old('ad_id') ? old('ad_id') : $adView->ad->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ad'))
                    <span class="text-danger">{{ $errors->first('ad') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.adView.fields.ad_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.adView.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $adView->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.adView.fields.user_helper') }}</span>
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