@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pollVariant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.poll-variants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVariant.fields.id') }}
                        </th>
                        <td>
                            {{ $pollVariant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVariant.fields.poll') }}
                        </th>
                        <td>
                            {{ $pollVariant->poll->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVariant.fields.title') }}
                        </th>
                        <td>
                            {{ $pollVariant->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVariant.fields.sort') }}
                        </th>
                        <td>
                            {{ $pollVariant->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pollVariant.fields.is_coccect') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $pollVariant->is_coccect ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.poll-variants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection