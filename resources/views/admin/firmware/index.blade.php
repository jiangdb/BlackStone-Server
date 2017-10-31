@extends('admin.layouts.min')

@section('title', 'Firmware')

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
                        <th>Version</th>
                        <th>Upload At</th>
                        <th class="col-lg-2 no-sort">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $firmwares as $firmware)
                    <tr class="odd gradeX">
                        <td>{{ $firmware->id }}</td>
                        <td>{{ $firmware->model_number }}</td>
                        <td>{{ $firmware->version }}</td>
                        <td>{{ $firmware->created_at }}</td>
                        <td>
                            <a class="btn btn-small btn-success hoffset1" href="{{ route('admin.firmware.edit', $firmware->id) }}">
                                <i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                            </a>
                            <a class="btn btn-small btn-info hoffset1" href="{{ route('admin.firmware.download', $firmware->id) }}">
                                <i class="fa fa-download fa-fw" aria-hidden="true"></i>
                            </a>
                            <button type="submit" class="btn btn-small btn-danger delete hoffset1"
                                onclick="event.preventDefault(); document.getElementById('firmware-delete-form-{{ $firmware->id }}').submit();">
                                <i class="fa fa-trash fa-fw" aria-hidden="true"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.firmware.destroy', $firmware->id) }}" accept-charset="UTF-8" class="pull-left" id="firmware-delete-form-{{ $firmware->id }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </td>
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
