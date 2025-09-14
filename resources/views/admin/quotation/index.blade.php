@extends('layouts.admin')
@section('content')
@can('post_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.quotations.create') }}">Цитата қўшиш</a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.post.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Post">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.post.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.content') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.detail_image') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $key => $quotation)
                        <tr data-entry-id="{{ $quotation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $quotation->id ?? '' }}
                            </td>
                            <td>
                                <div class="post--content">
                                    {!! $quotation->title !!}
                                </div>
                            </td>
                            <td>
                                @if($quotation->detail_image)
                                    <a href="{{ $quotation->detail_image->url }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $quotation->detail_image->url }}" width="50">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span style="display:none">{{ $quotation->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $quotation->status == '1' ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('post_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.quotations.show', $quotation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('post_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.quotations.edit', $quotation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('post_delete')
                                    <form action="{{ route('admin.quotations.destroy', $quotation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
