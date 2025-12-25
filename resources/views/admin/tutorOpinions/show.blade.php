@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tutorOpinion.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutor-opinions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.id') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->id }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.post') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->post->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.image') }}
                        </th>
                        <td>
                            @if($tutorOpinion->image)
                                <a href="{{ $tutorOpinion->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $tutorOpinion->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.short_title_uz') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->short_title_uz }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.short_title_kr') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->short_title_kr }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.short_title_ru') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->short_title_ru }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.short_title_en') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->short_title_en }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.sort') }}
                        </th>
                        <td>
                            {{ $tutorOpinion->sort }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tutor-opinions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
