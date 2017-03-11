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
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
