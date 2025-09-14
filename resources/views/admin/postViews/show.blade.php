@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.postView.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-views.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.postView.fields.id') }}
                        </th>
                        <td>
                            {{ $postView->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postView.fields.ip') }}
                        </th>
                        <td>
                            {{ $postView->ip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.postView.fields.post') }}
                        </th>
                        <td>
                            {{ $postView->post->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.post-views.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection