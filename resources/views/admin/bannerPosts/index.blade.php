@extends('layouts.admin')
@section('content')
@can('banner_post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.banner-posts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bannerPost.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.bannerPost.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BannerPost">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.bannerPost.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.bannerPost.fields.main_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.bannerPost.fields.post') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.bannerPost.fields.sort') }}
                        </th>
                        <th>
                            {{ trans('cruds.bannerPost.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bannerPosts as $key => $bannerPost)
                        <tr data-entry-id="{{ $bannerPost->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $bannerPost->id ?? '' }}
                            </td>
                            <td>
                                @if($bannerPost->main_image)
                                    <a href="{{ $bannerPost->main_image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $bannerPost->main_image->getUrl() }}" width="50">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $bannerPost->post->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $bannerPost->post->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $bannerPost->post->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $bannerPost->sort ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $bannerPost->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $bannerPost->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('banner_post_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.banner-posts.show', $bannerPost->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('banner_post_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.banner-posts.edit', $bannerPost->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('banner_post_delete')
                                    <form action="{{ route('admin.banner-posts.destroy', $bannerPost->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('banner_post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.banner-posts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-BannerPost:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
