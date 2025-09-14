@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pollVote.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.poll-votes.update", [$pollVote->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="poll_id">{{ trans('cruds.pollVote.fields.poll') }}</label>
                <select class="form-control select2 {{ $errors->has('poll') ? 'is-invalid' : '' }}" name="poll_id" id="poll_id">
                    @foreach($polls as $id => $entry)
                        <option value="{{ $id }}" {{ (old('poll_id') ? old('poll_id') : $pollVote->poll->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('poll'))
                    <span class="text-danger">{{ $errors->first('poll') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVote.fields.poll_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="poll_variant_id">{{ trans('cruds.pollVote.fields.poll_variant') }}</label>
                <select class="form-control select2 {{ $errors->has('poll_variant') ? 'is-invalid' : '' }}" name="poll_variant_id" id="poll_variant_id">
                    @foreach($poll_variants as $id => $entry)
                        <option value="{{ $id }}" {{ (old('poll_variant_id') ? old('poll_variant_id') : $pollVote->poll_variant->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('poll_variant'))
                    <span class="text-danger">{{ $errors->first('poll_variant') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVote.fields.poll_variant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="client_ip">{{ trans('cruds.pollVote.fields.client_ip') }}</label>
                <input class="form-control {{ $errors->has('client_ip') ? 'is-invalid' : '' }}" type="text" name="client_ip" id="client_ip" value="{{ old('client_ip', $pollVote->client_ip) }}" required>
                @if($errors->has('client_ip'))
                    <span class="text-danger">{{ $errors->first('client_ip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVote.fields.client_ip_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.pollVote.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $pollVote->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pollVote.fields.user_helper') }}</span>
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