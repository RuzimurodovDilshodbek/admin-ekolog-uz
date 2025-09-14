@extends('layouts.admin')
@section('content')
@can('poll_variant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.poll-variants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pollVariant.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pollVariant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PollVariant">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pollVariant.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVariant.fields.poll') }}
                        </th>
                        <th>
                            {{ trans('cruds.poll.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVariant.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVariant.fields.sort') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVariant.fields.is_coccect') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pollVariants as $key => $pollVariant)
                        <tr data-entry-id="{{ $pollVariant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $pollVariant->id ?? '' }}
                            </td>
                            <td>
                                {{ $pollVariant->poll->title ?? '' }}
                            </td>
                            <td>
                                @if($pollVariant->poll)
                                    {{ $pollVariant->poll::TYPE_SELECT[$pollVariant->poll->type] ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $pollVariant->title ?? '' }}
                            </td>
                            <td>
                                {{ $pollVariant->sort ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $pollVariant->is_coccect ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $pollVariant->is_coccect ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('poll_variant_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.poll-variants.show', $pollVariant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('poll_variant_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.poll-variants.edit', $pollVariant->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('poll_variant_delete')
                                    <form action="{{ route('admin.poll-variants.destroy', $pollVariant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('poll_variant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.poll-variants.massDestroy') }}",
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
  let table = $('.datatable-PollVariant:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
