@extends('layouts.admin')
@section('content')
@can('favourite_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.favourites.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.favourite.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.favourite.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Favourite">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.favourite.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.favourite.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.favourite.fields.post') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($favourites as $key => $favourite)
                        <tr data-entry-id="{{ $favourite->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $favourite->id ?? '' }}
                            </td>
                            <td>
                                {{ $favourite->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $favourite->post->title ?? '' }}
                            </td>
                            <td>
                                @can('favourite_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.favourites.show', $favourite->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('favourite_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.favourites.edit', $favourite->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('favourite_delete')
                                    <form action="{{ route('admin.favourites.destroy', $favourite->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('favourite_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.favourites.massDestroy') }}",
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
  let table = $('.datatable-Favourite:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
