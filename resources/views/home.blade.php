@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            Админлар учун панел
                        </div>
                        <div>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" {{ $site_status == 0 ? 'checked' : null }}  id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">Сайтни активсиз ҳолатга ўтказиш</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        Ассалому алайкум. Админ панелга хуш келибсиз
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $('#customSwitch1').on('change', async function() {
            if($(this).is(':checked')) {
                console.log('truga kelli')
                await $.ajax({
                    url: '{{ route('disabledSite') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: true
                    },
                    success: function (response) {
                        console.log('success')
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                console.log('falsega kelli')
                await $.ajax({
                    url: '{{ route('disabledSite') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        data: false
                    },
                    success: function (response) {
                        console.log('success')
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
{{--@parent--}}

@endsection
