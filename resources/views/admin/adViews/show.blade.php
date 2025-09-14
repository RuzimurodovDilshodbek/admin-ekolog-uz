@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.adView.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ad-views.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.adView.fields.id') }}
                        </th>
                        <td>
                            {{ $adView->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adView.fields.client_ip') }}
                        </th>
                        <td>
                            {{ $adView->client_ip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adView.fields.ad') }}
                        </th>
                        <td>
                            {{ $adView->ad->url ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.adView.fields.user') }}
                        </th>
                        <td>
                            {{ $adView->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ad-views.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection