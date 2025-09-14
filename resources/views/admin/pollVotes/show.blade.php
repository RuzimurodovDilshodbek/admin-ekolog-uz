@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pollVote.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.poll-votes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVote.fields.id') }}
                        </th>
                        <td>
                            {{ $pollVote->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVote.fields.poll') }}
                        </th>
                        <td>
                            {{ $pollVote->poll->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVote.fields.poll_variant') }}
                        </th>
                        <td>
                            {{ $pollVote->poll_variant->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVote.fields.client_ip') }}
                        </th>
                        <td>
                            {{ $pollVote->client_ip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVote.fields.user') }}
                        </th>
                        <td>
                            {{ $pollVote->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.poll-votes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection