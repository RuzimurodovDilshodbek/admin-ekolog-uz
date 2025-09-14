@extends('layouts.admin')
@section('content')
@can('poll_vote_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.poll-votes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pollVote.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pollVote.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PollVote">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pollVote.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVote.fields.poll') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVote.fields.poll_variant') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVote.fields.client_ip') }}
                        </th>
                        <th>
                            {{ trans('cruds.pollVote.fields.user') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pollVotes as $key => $pollVote)
                        <tr data-entry-id="{{ $pollVote->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $pollVote->id ?? '' }}
                            </td>
                            <td>
                                {{ $pollVote->poll->title ?? '' }}
                            </td>
                            <td>
                                {{ $pollVote->poll_variant->title ?? '' }}
                            </td>
                            <td>
                                {{ $pollVote->client_ip ?? '' }}
                            </td>
                            <td>
                                {{ $pollVote->user->name ?? '' }}
                            </td>
                            <td>
                                @can('poll_vote_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.poll-votes.show', $pollVote->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('poll_vote_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.poll-votes.edit', $pollVote->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('poll_vote_delete')
                                    <form action="{{ route('admin.poll-votes.destroy', $pollVote->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('poll_vote_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.poll-votes.massDestroy') }}",
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
  let table = $('.datatable-PollVote:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
