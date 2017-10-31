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
                <a href="/superadmin"> {{ trans('admin.welcome') }}</a>
            </li>
            <li>
                <a href="/superadmin/organization"> {{ trans('admin.organizations') }}</a>
            </li>
            <li>
                <a href="/superadmin/property"> {{ trans('admin.properties') }}</a>
            </li>
            <li>
                <a href="/superadmin/playlist"> {{ trans('admin.playlists') }}</a>
            </li>
            <li>
                <a href="{{ route('superadmin.entry.index') }}"> {{ trans('admin.entries') }}</a>
            </li>
            <li>
                <a href="/superadmin/service_provider"> {{ trans('admin.service_providers') }}</a>
            </li>
            <li>
                <a href="/superadmin/content_provider"> {{ trans('admin.content_providers') }}</a>
            </li>
            <li>
                <a href="/superadmin/user"> {{ trans('admin.users') }}</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
