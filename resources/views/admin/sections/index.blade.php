@extends('layouts.admin')
@section('content')
@can('section_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sections.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.section.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.section.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Section">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.section.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.parent') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.slug') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.sort') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.url') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $key => $section)
                        <tr data-entry-id="{{ $section->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $section->id ?? '' }}
                            </td>
                            <td>
                                {{ $section->parent->title ?? '' }}
                            </td>
                            <td>
                                {{ $section->slug ?? '' }}
                            </td>
                            <td>
                                {{ $section->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $section->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $section->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $section->sort ?? '' }}
                            </td>
                            <td>
                                {{ $section->url ?? '' }}
                            </td>
                            <td>
                                @can('section_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sections.show', $section->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('section_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sections.edit', $section->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('section_delete')
                                    <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('section_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sections.massDestroy') }}",
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
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-Section:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection