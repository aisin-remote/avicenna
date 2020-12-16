@extends('adminlte::layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.exporttracedata') }}
@endsection

@section('htmlheader')
  @parent
  <link rel="stylesheet" type="text/css" href="{{ url('/css/dataTables.bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap-datetimepicker.css') }}">
@endsection

@section('contentheader_title')
  Tracebility
@endsection

@section('contentheader_description')
  Export Trace Data
@endsection

@section('main-content')
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Filter Line</label>
                    <select class="form-control" id="line">
                        @foreach ($lines as $line)
                        <option value="{{ $line }}">{{ $line }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="start-date" type="input" class="form-control" name="start_date" placeholder="Start Date" value="{{ date('Y-m-d H:i') }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label>End Date</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input id="end-date" type="input" class="form-control" name="end_date" placeholder="End Date" value="{{ date('Y-m-d H:i') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p class="text-danger">
                    <i><b>* Tidak bisa mengexport data dalam rentang lebih dari 7 hari</b></i>
                </p>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <button class="btn btn-success btn-sm" id="btn-export">Export To Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script src="{{ asset('/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $(function() {
        $('#start-date').datetimepicker({
            format: "YYYY-MM-DD H:mm"
        });
        $('#end-date').datetimepicker({
            format: "YYYY-MM-DD H:mm"
        });

        $('#btn-export').on('click', function() {
            var urlExport = "{{ route('trace.export-collection.generate') }}";
            var url = new URL(urlExport);
            var startDate = $('#start-date').val();
            var endDate = $('#end-date').val();
            var line = $('#line').val();

            var format1 = new Date(startDate);
            var format2 = new Date(endDate);

            if (format1 > format2) {
                alert('End date tidak boleh lebih kecil dari start date');
                return;
            }

            var diffTime = format2.getTime() - format1.getTime();
            var diffDay = diffTime / (1000 * 3600 * 24);

            if (diffDay > 7) {
                alert('Penarikan data tidak bisa untuk rentang lebih dari 7 hari');
                return;
            }

            if (startDate == null || startDate == '' || startDate == undefined || endDate == null || endDate == '' || endDate == undefined) {
                alert ('Start date dan end date wajib diisi');
                return;
            }

            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            url.searchParams.set('line', line);

            window.location.href = url.toString();
        });
    });
</script>
@endsection
