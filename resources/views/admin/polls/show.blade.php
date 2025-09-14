@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.poll.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.polls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.poll.fields.id') }}
                        </th>
                        <td>
                            {{ $poll->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.poll.fields.title') }}
                        </th>
                        <td>
                            {{ $poll->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.poll.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Poll::TYPE_SELECT[$poll->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.poll.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $poll->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.poll.fields.sort') }}
                        </th>
                        <td>
                            {{ $poll->sort }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.polls.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection