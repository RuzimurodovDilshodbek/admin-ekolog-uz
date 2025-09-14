@extends('layouts.admin')
@section('content')
@can('tutor_opinion_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tutor-opinions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.tutorOpinion.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.tutorOpinion.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TutorOpinion">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.post') }}
                        </th>
                        <th>
                            {{ trans('cruds.post.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.image') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.short_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.tutorOpinion.fields.sort') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutorOpinions as $key => $tutorOpinion)
                        <tr data-entry-id="{{ $tutorOpinion->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $tutorOpinion->id ?? '' }}
                            </td>
                            <td>
                                {{ $tutorOpinion->post->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $tutorOpinion->post->status ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $tutorOpinion->post->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                @if($tutorOpinion->image)
                                    <a href="{{ $tutorOpinion->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $tutorOpinion->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $tutorOpinion->short_title ?? '' }}
                            </td>
                            <td>
                                {{ $tutorOpinion->sort ?? '' }}
                            </td>
                            <td>
                                @can('tutor_opinion_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.tutor-opinions.show', $tutorOpinion->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('tutor_opinion_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.tutor-opinions.edit', $tutorOpinion->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('tutor_opinion_delete')
                                    <form action="{{ route('admin.tutor-opinions.destroy', $tutorOpinion->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('tutor_opinion_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tutor-opinions.massDestroy') }}",
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
  let table = $('.datatable-TutorOpinion:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
