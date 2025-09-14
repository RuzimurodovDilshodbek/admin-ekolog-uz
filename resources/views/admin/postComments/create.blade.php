@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.postComment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.post-comments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.postComment.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postComment.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="comment">{{ trans('cruds.postComment.fields.comment') }}</label>
                <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" id="comment" required>{{ old('comment') }}</textarea>
                @if($errors->has('comment'))
                    <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postComment.fields.comment_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="client_ip">{{ trans('cruds.postComment.fields.client_ip') }}</label>
                <input class="form-control {{ $errors->has('client_ip') ? 'is-invalid' : '' }}" type="text" name="client_ip" id="client_ip" value="{{ old('client_ip', '') }}" required>
                @if($errors->has('client_ip'))
                    <span class="text-danger">{{ $errors->first('client_ip') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postComment.fields.client_ip_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="post_id">{{ trans('cruds.postComment.fields.post') }}</label>
                <select class="form-control select2 {{ $errors->has('post') ? 'is-invalid' : '' }}" name="post_id" id="post_id" required>
                    @foreach($posts as $id => $entry)
                        <option value="{{ $id }}" {{ old('post_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postComment.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reply_to_id">{{ trans('cruds.postComment.fields.reply_to') }}</label>
                <select class="form-control select2 {{ $errors->has('reply_to') ? 'is-invalid' : '' }}" name="reply_to_id" id="reply_to_id">
                    @foreach($reply_tos as $id => $entry)
                        <option value="{{ $id }}" {{ old('reply_to_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('reply_to'))
                    <span class="text-danger">{{ $errors->first('reply_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.postComment.fields.reply_to_helper') }}</span>
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