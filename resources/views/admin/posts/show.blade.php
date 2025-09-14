@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.post.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.id') }}
                        </th>
                        <td>
                            {{ $post->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.slug') }}
                        </th>
                        <td>
                            {{ $post->slug_kr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.section') }}
                        </th>
                        <td>
                            {{ implode(', ', $post->sections->pluck('title')->toArray()) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.tutor') }}
                        </th>
                        <td>
                            {{ $post->tutor->firstname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.title') }}
                        </th>
                        <td>
                            {{ $post->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.content') }}
                        </th>
                        <td>
                            {!! $post->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.detail_image') }}
                        </th>
                        <td>
                            @if($post->detail_image)
                                <a href="{{ $post->detail_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $post->detail_image->getUrl() }}" width="50">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.card_image') }}
                        </th>
                        <td>
                            @if($post->card_image)
                                <a href="{{ $post->card_image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $post->card_image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.audio_file') }}
                        </th>
                        <td>
                            @if($post->audio_file)
                                <audio controls>
                                    <source src="{{ asset('storage/audio/' . $post->audio_file) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            @endif
                        </td> 
                    </tr>   
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.tags') }}
                        </th>
                        <td>
                            @foreach($post->tags as $key => $tags)
                                <span class="label label-info p-1">{{ $tags->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $post->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.publish_date') }}
                        </th>
                        <td>
                            {{ $post->publish_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Post::TYPE_SELECT[$post->type] ?? '' }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.post.fields.youtube_link') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $post->youtube_link }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $post->meta_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.post.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $post->meta_keywords }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.posts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
