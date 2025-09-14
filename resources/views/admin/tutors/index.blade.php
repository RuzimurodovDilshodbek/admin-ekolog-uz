@extends('layouts.admin')
@section('content')
@can('tutor_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tutors.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.tutor.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.tutor.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Tutor">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.slug') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.firstname') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.lastname') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.facebook') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.twitter') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.gmail') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.rss') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.youtube') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.linkedin') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.telegram') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.instagram') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.sort') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.meta_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.meta_description') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.meta_keywords') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutor.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutors as $key => $tutor)
                        <tr data-entry-id="{{ $tutor->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $tutor->id ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->slug ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->firstname ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->lastname ?? '' }}
                            </td>
                            <td>
                                @if($tutor->photo)
                                    <a href="{{ $tutor->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $tutor->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $tutor->facebook ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->twitter ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->gmail ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->rss ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->youtube ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->linkedin ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->telegram ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->instagram ?? '' }}
                            </td>
                            <td>
                                {{ $tutor->sort ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $tutor->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $tutor->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('tutor_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tutors.show', $tutor->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('tutor_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tutors.edit', $tutor->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('tutor_delete')
                                    <form action="{{ route('admin.tutors.destroy', $tutor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('tutor_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tutors.massDestroy') }}",
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
  let table = $('.datatable-Tutor:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
