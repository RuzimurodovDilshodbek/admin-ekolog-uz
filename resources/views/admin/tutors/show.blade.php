@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tutor.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.id') }}
                        </th>
                        <td>
                            {{ $tutor->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.slug') }}
                        </th>
                        <td>
                            {{ $tutor->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.firstname') }}
                        </th>
                        <td>
                            {{ $tutor->firstname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.lastname') }}
                        </th>
                        <td>
                            {{ $tutor->lastname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.photo') }}
                        </th>
                        <td>
                            @if($tutor->photo)
                                <a href="{{ $tutor->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $tutor->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.about') }}
                        </th>
                        <td>
                            {!! $tutor->about !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.facebook') }}
                        </th>
                        <td>
                            {{ $tutor->facebook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.twitter') }}
                        </th>
                        <td>
                            {{ $tutor->twitter }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.gmail') }}
                        </th>
                        <td>
                            {{ $tutor->gmail }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.rss') }}
                        </th>
                        <td>
                            {{ $tutor->rss }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.youtube') }}
                        </th>
                        <td>
                            {{ $tutor->youtube }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.linkedin') }}
                        </th>
                        <td>
                            {{ $tutor->linkedin }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.telegram') }}
                        </th>
                        <td>
                            {{ $tutor->telegram }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.instagram') }}
                        </th>
                        <td>
                            {{ $tutor->instagram }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.sort') }}
                        </th>
                        <td>
                            {{ $tutor->sort }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.meta_description') }}
                        </th>
                        <td>
                            {{ $tutor->meta_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.meta_keywords') }}
                        </th>
                        <td>
                            {{ $tutor->meta_keywords }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutor.fields.status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $tutor->status ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
