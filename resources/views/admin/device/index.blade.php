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
                <h1 class="page-header">Devices</h1>
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
                        <th class="col-md-1">ID</th>
                        <th>Model</th>
                        <th>Serial</th>
                        <th>Version</th>
                        <th>IP</th>
                        <th>City</th>
                        <th>Upload At</th>
                    </tr>
                    </thead>
                    <tbody>
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
                stateSave: true,
                responsive: true,
                "serverSide": true,
                "order": [[ 5, "desc" ]],
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' }
                ],
                ajax:'{{ route('admin.devices.list') }}',
                "columns": [
                    { "name":"id", "data": "id" },
                    { "name":"model", "data": "model_number" },
                    { "name":"serial", "data": "serial_number" },
                    { "name":"version", "data": "fw_version" },
                    { "name":"ip", "data": "ip_address" },
                    { "name":"city", "data": "city" },
                    { "name":"updated_at", "data": "updated_at" },
                ]
            });
        });
    </script>
@endpush
