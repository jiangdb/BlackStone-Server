@extends('admin.layouts.min')

@section('title', '挑战赛排名')

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
                <h1 class="page-header">挑战赛排名
                    <form class="pull-right" method="post" action="{{ route('admin.challenge.clear') }}">
                        {{csrf_field()}}
                        <button class="btn btn-small btn-primary" href="{{ route('admin.challenge.clear') }}">清除</button>
                    </form>
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
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-challenges">
                    <thead>
                    <tr>
                        <th class="col-md-1 no-sort">名次</th>
                        <th class="col-md-1 no-sort">头像</th>
                        <th class="text-center no-sort">名字</th>
                        <th class="text-center no-sort">分数</th>
                        <th class="text-center no-sort">参加时间</th>
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
            $('#dataTables-challenges').DataTable({
                stateSave: true,
                responsive: true,
                "serverSide": true,
                "columnDefs": [
                    { "orderable": false, "targets": 'no-sort' },
                    { className: "text-right", "targets": 'text-center' }
                ],
                ajax:'{{ route('admin.challenge.ajax.leaderboard') }}',
                "columns": [
                    { "name":"rank", "data": "rank" },
                    { "name":"avatar", "data": "avatar" },
                    { "name":"name", "data": "name" },
                    { "name":"score", "data": "score" },
                    { "name":"created_at", "data": "created_at" }
                ]
            });
        });
    </script>
@endpush
