@extends('layouts.admin')
@section('content')
@can('tag_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-8">
            <a class="btn btn-success" href="{{ route('admin.videos.create') }}">
                Videolar qo'shish
            </a>
        </div>
{{--        <div class="col-lg-2">--}}
{{--            <a class="btn btn-success" href="{{ route('admin.videoEditSort') }}">--}}
{{--                {{ 'Видео баннери тартиби' }}--}}
{{--            </a>--}}
{{--        </div>--}}
        <div class="col-lg-2">
            <a class="btn btn-success" href="{{ route('admin.video-category.index') }}">
                Video bo‘limlari
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Videolar ro'yxati
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Tag">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            Id
                        </th>
                        <th>Bo'lim</th>
                        <th>
                            Sarlavha
                        </th>
                        <th>
                            Youtube link
                        </th>
                        <th>
                            Amallar
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
                                {{ $video->category->title_uz ?? $video->category->title_ru }}
                            </td>
                            <td>
                                {{ $video->title ?? '' }}
                            </td>
                            <td>
                                {{ $video->youtube_link ?? '' }}
                            </td>
                            <td>
                                @can('video_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.videos.show', $video->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('video_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.videos.edit', $video->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('video_delete')
                                    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
