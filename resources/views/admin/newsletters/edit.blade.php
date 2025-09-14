@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.newsletter.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.newsletters.update", [$newsletter->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.newsletter.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $newsletter->email) }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="client_ip">{{ trans('cruds.newsletter.fields.client_ip') }}</label>
                <input class="form-control {{ $errors->has('client_ip') ? 'is-invalid' : '' }}" type="text" name="client_ip" id="client_ip" value="{{ old('client_ip', $newsletter->client_ip) }}" required>
                @if($errors->has('client_ip'))
                    <span class="text-danger">{{ $errors->first('client_ip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.newsletter.fields.client_ip_helper') }}</span>
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