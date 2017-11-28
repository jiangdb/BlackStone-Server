@extends('admin.layouts.min')

@section('title', 'Edit Firmware')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Edit Firmware</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-4 col-lg-offset-1">
                @include('admin.includes.message')
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-4 col-lg-offset-1">
                <form method="POST" action="{{ route('admin.firmware.update', $firmware->id) }}" enctype="multipart/form-data" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="model_number">Model</label>
                        <input class="form-control" name="model_number" type="text" id="model_number" value="{{ $firmware->model_number }}" required>
                    </div>
                    <div class="form-group">
                        <label for="version">Version</label>
                        <input class="form-control" name="version" type="text" id="version" value="{{ $firmware->version }}" required>
                    </div>
                    <div class="form-group">
                        <label for="version_code">Version Code</label>
                        <input class="form-control" name="version_code" type="text" id="version_code" value="{{ $firmware->version_code }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="5" required>{{ $firmware->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="firmware">Select Firmware</label>
                        <input class="form-control" name="firmware" type="file">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </form>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->

    </div>
@stop
