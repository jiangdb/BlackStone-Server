@extends('admin.layouts.min')

@section('title', 'User')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ $user->name }}</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        @if($user->wx_user)
        <div class="row">
            <div class="col-lg-6 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">微信</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="{{ $user->wx_user->avatar_url }}" class="img-circle img-responsive"> </div>
                            <div class=" col-md-9 col-lg-9 ">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>昵称:</td>
                                        <td>{{ $user->wx_user->nickname }}</td>
                                    </tr>
                                    <tr>
                                        <td>性别:</td>
                                        <td>{{ $user->wx_user->gender==1?'男':($user->wx_user->gener==2?'女':'未知') }}</td>
                                    </tr>
                                    <tr>
                                        <td>地点:</td>
                                        <td>{{ $user->wx_user->country.' > '.$user->wx_user->province.' > '.$user->wx_user->city }}</td>
                                    </tr>
                                    <tr>
                                        <td>最后上线:</td>
                                        <td>{{ $user->updated_at }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
        @endif
    </div>
    <!-- /#page-wrapper -->
@stop
