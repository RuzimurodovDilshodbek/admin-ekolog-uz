@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.postComment.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-comments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.id') }}
                        </th>
                        <td>
                            {{ $postComment->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.user') }}
                        </th>
                        <td>
                            {{ $postComment->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.comment') }}
                        </th>
                        <td>
                            {{ $postComment->comment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.client_ip') }}
                        </th>
                        <td>
                            {{ $postComment->client_ip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.post') }}
                        </th>
                        <td>
                            {{ $postComment->post->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postComment.fields.reply_to') }}
                        </th>
                        <td>
                            {{ $postComment->reply_to->comment ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-comments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection