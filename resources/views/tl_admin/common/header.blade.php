  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/dashboard')}}" class="logo">
      <span class="logo-lg">
        <img src="{{url('/')}}/public/tl_admin/dist/img/white-logo.png" alt="" class="img-responsive tl-admin-larglogo">

        <img src="{{url('/')}}/public/tl_admin/dist/img/small-logo.png" alt="" class="img-responsive tl-admin-smalllogo">
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('/')}}/public/tl_admin/dist/img/user_light.png" class="user-image" alt="User Image">
              <span class="hidden-xs">Hi Admin</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('/')}}/public/tl_admin/dist/img/user_light.png" class="img-circle" alt="User Image">

                 <p>
                  Hi Admin
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
               <!--  <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a href="{{url('/tl_admin/Logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
               
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>