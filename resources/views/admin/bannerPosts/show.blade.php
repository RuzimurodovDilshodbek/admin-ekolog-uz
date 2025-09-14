@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bannerPost.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.banner-posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bannerPost.fields.id') }}
                        </th>
                        <td>
                            {{ $bannerPost->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bannerPost.fields.main_image') }}
                        </th>
                        <td>
                            @if($bannerPost->main_image)
                                <a href="{{ $bannerPost->main_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $bannerPost->main_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bannerPost.fields.post') }}
                        </th>
                        <td>
                            {{ $bannerPost->post->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bannerPost.fields.sort') }}
                        </th>
                        <td>
                            {{ $bannerPost->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bannerPost.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $bannerPost->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.banner-posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
