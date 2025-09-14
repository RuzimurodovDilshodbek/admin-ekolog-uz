@extends('layouts.admin')
@section('content')
@can('poll_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.polls.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.poll.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.poll.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Poll">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.sort') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($polls as $key => $poll)
                        <tr data-entry-id="{{ $poll->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $poll->id ?? '' }}
                            </td>
                            <td>
                                {{ $poll->title ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Poll::TYPE_SELECT[$poll->type] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $poll->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $poll->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $poll->sort ?? '' }}
                            </td>
                            <td>
                                @can('poll_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.polls.show', $poll->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('poll_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.polls.edit', $poll->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('poll_delete')
                                    <form action="{{ route('admin.polls.destroy', $poll->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('poll_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.polls.massDestroy') }}",
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
  let table = $('.datatable-Poll:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
