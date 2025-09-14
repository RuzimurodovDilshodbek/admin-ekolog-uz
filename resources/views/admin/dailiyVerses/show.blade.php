@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dailiyVerse.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dailiy-verses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.id') }}
                        </th>
                        <td>
                            {{ $dailiyVerse->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.text') }}
                        </th>
                        <td>
                            {{ $dailiyVerse->text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $dailiyVerse->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.sort') }}
                        </th>
                        <td>
                            {{ $dailiyVerse->sort }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dailiy-verses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection