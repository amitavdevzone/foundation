<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <!-- <img src="{{Auth::user()->present()->profilePic}}" alt="{{Auth::user()->name}}" class="img-circle"> -->
        <user-image
          img-class="img-circle"
          src="{{Auth::user()->present()->profilePic}}"
          alt="{{Auth::user()->name}}">
        </user-image>
      </div>
      <div class="pull-left info">
        <p>{{Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li class="{{ Request::is('home') ? 'active' : ''  }} treeview">
        <a href="{{route('home')}}"><i class="fa fa-dashboard"></i><span>Home</span></a>
      </li>
      @stack('sidebar-links')

      @role('admin')
      <li class="{{ Request::is('admin/*') ? 'active' : ''  }} treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>Administration</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::is('admin/user/manage') ? 'active' : ''  }}">
            <a href="{{route('manage-users')}}"><i class="fa fa-circle-o"></i> Manage Users</a>
          </li>
          <li class="{{ Request::is('admin/user/roles') ? 'active' : ''  }}">
            <a href="{{route('manage-roles')}}"><i class="fa fa-circle-o"></i> Manage Roles</a>
          </li>
          <li class="{{ Request::is('admin/user/permissions') ? 'active' : ''  }}">
            <a href="{{route('manage-permissions')}}"><i class="fa fa-circle-o"></i> Manage Permissions</a>
          </li>
          <li class="{{ Request::is('admin/settings/manage') ? 'active' : ''  }}">
            <a href="{{route('manage-settings')}}"><i class="fa fa-circle-o"></i> Manage Settings</a>
          </li>
        </ul>
      </li>
      @endrole

      <li class="{{ Request::is('activities') ? 'active' : ''  }} treeview">
        <a href="{{route('user-activities')}}"><i class="fa fa-line-chart"></i><span>My activities</span></a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
