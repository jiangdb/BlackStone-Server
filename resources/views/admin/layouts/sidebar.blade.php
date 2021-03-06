<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('admin.firmware.index') }}"><i class="fa fa-file-archive-o fa-fw"></i> Firmware</a>
            </li>
            <li>
                <a href="{{ route('admin.devices.index') }}"><i class="fa fa-mobile fa-fw"></i> Devices</a>
            </li>
            <li>
                <a href="{{ route('admin.challenge.index') }}"><i class="fa fa-train fa-fw"></i> 挑战赛</a>
            </li>
            <li>
                <a href="{{ route('admin.user.index') }}"><i class="fa fa-users fa-fw"></i> Users</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
