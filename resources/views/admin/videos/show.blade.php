@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tag.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.videos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.id') }}
                        </th>
                        <td>
                            {{ $video->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.youtube_link') }}
                        </th>
                        <td>
                            {{ $video->youtube_link }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.title_uz') }}
                        </th>
                        <td>
                            {{ $video->title_uz }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.title_kr') }}
                        </th>
                        <td>
                            {{ $video->title_kr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.title_ru') }}
                        </th>
                        <td>
                            {{ $video->title_ru }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.video.fields.title_en') }}
                        </th>
                        <td>
                            {{ $video->title_en }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.videos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
