@extends('admin.layouts.min')

@section('title', 'Device')

@push('head-style')
<!-- DataTables CSS -->
<link href="/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
@endpush

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Firmwares
                    <a class="btn btn-small btn-primary pull-right" href="{{ route('admin.firmware.create') }}">New</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                @include('admin.includes.message')
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-firmware">
                    <thead>
                    <tr>
                        <th class="col-md-1">#</th>
                        <th>Model</th>
                        <th>Serial</th>
                        <th>Version</th>
                        <th>IP</th>
                        <th class="no-sort">Upload At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $devices as $device)
                    <tr class="odd gradeX">
                        <td>{{ $device->id }}</td>
                        <td>{{ $device->model_number }}</td>
                        <td>{{ $device->serial_number }}</td>
                        <td>{{ $device->fw_version }}</td>
                        <td>{{ $device->ip_address }}</td>
                        <td>{{ $device->created_at }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
@endsection

@push('foot-scripts')

    <!-- DataTables JavaScript -->
    <script src="/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-firmware').DataTable({
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' }
                ]
            });
        });
    </script>
@endpush
