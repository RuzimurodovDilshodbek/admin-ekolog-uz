@extends('layouts.admin')
@section('content')
@can('post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ isset($section) ? route('admin.posts.create',['id' => $section->id]) : route('admin.posts.create') }}">
                Post yaratish
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        Postlar ro'yxati
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.post.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.section') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.detail_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <th>
                           Tavsiya etiladi
                        </th>
                        <th>
                            Ko'rishlar soni
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.publish_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr data-entry-id="{{ $post->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $post->id ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                {{ $post->slug ?? '' }}--}}
{{--                            </td>--}}
                            <td>
                                {{ implode(', ', $post->sections->pluck('title')->toArray()) }}
                            </td>
                            <td>
                                {{ $post->title ?? '' }}
                            </td>
                            <td>
                                @if($post->detail_image)
                                    <a href="{{ $post->detail_image->preview }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $post->detail_image->preview }}" width="50">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span style="display:none">{{ $post->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $post->status == '1' ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $post->recommended ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $post->recommended == '1' ? 'checked' : '' }}>
                            </td>
                            <td>{{ $post->view_count }} </td>
                            <td>
                                {{ $post->publish_date ?? '' }}
                            </td>
                            <td>
                                @can('post_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.posts.show', $post->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('post_edit')
                                    <a class="btn btn-xs btn-info" href="{{ isset($section) ? route('admin.postGetSectionIdEdit',['id' => $post->id, 'section_id' => $section->id]) : route('admin.postGetSectionIdEdit', ['id' => $post->id]) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('post_delete')
                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
{{--<div class="d-flex justify-content-end text-center">--}}
{{--    {{ $posts->onEachSide(2)->links('pagination::bootstrap-4') }}--}}
{{--</div>--}}


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('post_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.archived') }}'
  let unarchivedButtonTrans = '{{ trans('global.datatables.unarchived') }}'
  let unarchivedButton = {
    text: unarchivedButtonTrans,
    url: "{{ route('admin.posts.massUnArchiving') }}",
    className: 'btn-info',
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
          data: { ids: ids, _method: 'PUT' }})
          .done(function () { location.reload() })
      }
    }
  }
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.posts.massArchiving') }}",
    className: 'btn-info',
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
          data: { ids: ids, _method: 'PUT' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
  dtButtons.push(unarchivedButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-Post:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
