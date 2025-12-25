@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tag.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tags.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.id') }}
                        </th>
                        <td>
                            {{ $tag->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.slug') }}
                        </th>
                        <td>
                            {{ $tag->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.title_uz') }}
                        </th>
                        <td>
                            {{ $tag->title_uz }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.title_kr') }}
                        </th>
                        <td>
                            {{ $tag->title_kr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.title_ru') }}
                        </th>
                        <td>
                            {{ $tag->title_ru }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.title_en') }}
                        </th>
                        <td>
                            {{ $tag->title_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tag.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $tag->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tags.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
