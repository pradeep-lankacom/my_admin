<!-- Left side column. contains the sidebar -->
 <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
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

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">HEADER</li>
        <!-- Optionally, you can add icons to the links -->

          @can('RoleMenu')
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Role</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/admin/roles/create">Create</a></li>
            <li><a href="/admin/roles">Manage</a></li>
          </ul>
        </li>
          @endcan
          @can('PermissionMenu')
          <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Permission</span>
                  <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
              <ul class="treeview-menu">
                  <li><a href="/admin/permissions/create">Create</a></li>
                  <li><a href="/admin/permission">Manage</a></li>
              </ul>
          </li>
          @endcan
          @can('UserMenu')
          <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>User</span>
                  <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
              </a>
              <ul class="treeview-menu">
                  <li><a href="/admin/user/create">Create</a></li>
                  <li><a href="/admin/users">Manage</a></li>
              </ul>
          </li>
          @endcan

          @can('CategoryMenu')
              <li class="treeview">
                  <a href="#"><i class="fa fa-link"></i> <span>Category</span>
                      <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                  </a>
                  <ul class="treeview-menu">
                      <li><a href="/admin/category/create">Create</a></li>
                      <li><a href="/admin/category">Manage</a></li>
                  </ul>
              </li>
          @endcan
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
