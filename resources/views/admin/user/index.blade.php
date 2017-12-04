@extends('admin.layouts.min')

@section('title', 'User')

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
                <h1 class="page-header">Users</h1>
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
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-user">
                    <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th>name</th>
                        <th>platform</th>
                        <th>Last time online </th>
                        <th>Register At</th>
                        <th class="col-lg-2 no-sort">Actions</th>
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
            $('#dataTables-user').DataTable({
                "order": [[ 3, "desc" ]],
                responsive: true,
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' }
                ],
                "serverSide": true,
                ajax:'{{ route('admin.user.list') }}',
                "columns": [
                    { "name":"id", "data": "id" },
                    { "name":"name", "data": "name" },
                    { "name":"platforms", "data": "platforms" },
                    { "name":"updated_at", "data": "updated_at" },
                    { "name":"created_at", "data": "created_at" },
                    { "name":"actions", "data": "actions" },
                ]
            });
        });
    </script>
@endpush
