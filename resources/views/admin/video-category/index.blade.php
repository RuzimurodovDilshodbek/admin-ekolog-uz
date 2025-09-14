@extends('layouts.admin')
@section('content')
@can('tag_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.video-category.create') }}">
                Видео категорияси қўшиш
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.video.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Tag">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.video.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.video.fields.title') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $key => $video)
                        <tr data-entry-id="{{ $video->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $video->id ?? '' }}
                            </td>
                            <td>
                                {{ $video->title ?? '' }}
                            </td>
                            <td>
                                @can('video_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.video-category.show', $video->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('video_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.video-category.edit', $video->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('video_delete')
                                    <form action="{{ route('admin.video-category.destroy', $video->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-Tag:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
