@extends('layouts.admin')
@section('content')
@can('dailiy_verse_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.dailiy-verses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.dailiyVerse.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.dailiyVerse.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-DailiyVerse">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.text') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.dailiyVerse.fields.sort') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailiyVerses as $key => $dailiyVerse)
                        <tr data-entry-id="{{ $dailiyVerse->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $dailiyVerse->id ?? '' }}
                            </td>
                            <td>
                                {{ $dailiyVerse->text ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $dailiyVerse->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $dailiyVerse->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $dailiyVerse->sort ?? '' }}
                            </td>
                            <td>
                                @can('dailiy_verse_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.dailiy-verses.show', $dailiyVerse->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('dailiy_verse_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.dailiy-verses.edit', $dailiyVerse->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('dailiy_verse_delete')
                                    <form action="{{ route('admin.dailiy-verses.destroy', $dailiyVerse->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('dailiy_verse_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dailiy-verses.massDestroy') }}",
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
  let table = $('.datatable-DailiyVerse:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
