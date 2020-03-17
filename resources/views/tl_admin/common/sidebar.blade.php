  <?php  
  $url = $_SERVER['REQUEST_URI']; 
  $lastsegment = last(request()->segments()); 
  ?>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/')}}/public/tl_admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Sweta Shree</p>
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

       
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header <?php if($url == '/dashboard'){ echo 'active'; }?>" ><a href="{{url('/dashboard')}}">Dashboard</a></li>

    

        <li class="treeview <?php if($url == '/dashboard/cms/about-us' || $url == '/cms/privacy-policy' || $url == '/cms/terms&condition' || $url == '/cms/faqs' || $url == '/cms/managehomepage' || $url == '/cms/managehomepage' || $url == '/cms/Personalise-info' || $url == '/cms/manage-social-link' || $url == '/cms/thankyou' || $url == '/cms/treat-for' || $url == '/cms/category' || $url == '/cms/postage-packaging' || $url == '/cms/add-treat-for' || $url == '/cms/add-treat-for/'.$lastsegment || $url == '/cms/add_category' || $url == '/cms/add_category/'.$lastsegment || $url == '/cms/addfaqcat' || $url == '/cms/addfaq' || $url == '/cms/faqdetail/'.$lastsegment || $url == '/cms/addfaqcat/'.$lastsegment || $url == '/cms/addfaq/'.$lastsegment){ echo 'active'; }?> ">         
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>CMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($url == '/dashboard/cms/about-us'){ echo "class='active'"; }?> ><a href="{{ url('/dashboard/cms/about-us') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>About Us</a></li>
            <li <?php if($url == '/cms/privacy-policy'){ echo "class='active'"; }?>><a href="{{ url('/cms/privacy-policy') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Privacy Policy</a></li>
            <li <?php if($url == '/cms/terms&condition'){ echo "class='active'"; }?> ><a href="{{ url('/cms/terms&condition') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Terms & Condition</a></li>

            <li <?php if($url == '/cms/faqs' || $url == '/cms/addfaqcat' || $url == '/cms/addfaq' || $url == '/cms/faqdetail/'.$lastsegment || $url == '/cms/addfaqcat/'.$lastsegment){ echo "class='active'"; }?> >
            <a href="{{ url('/cms/faqs') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>FAQ's</a>
            </li>

              <li <?php if($url == '/cms/managehomepage'){ echo "class='active'"; }?> ><a href="{{ url('/cms/managehomepage') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Manage Homepage</a></li>
              <li <?php if($url == '/cms/category' || $url == '/cms/add_category' || $url == '/cms/add_category/'.$lastsegment){ echo "class='active'"; }?> ><a href="{{ url('/cms/category') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Manage Category</a></li>  
              
              <li <?php if($url == '/cms/treat-for' || $url == '/cms/add-treat-for' || $url == '/cms/add-treat-for/'.$lastsegment){ echo "class='active'"; }?>><a href="{{url('/cms/treat-for')}}"><i class="fa fa-hand-o-right"></i> <span>Who are you treating tags</span></a></li>

              <li <?php if($url == '/cms/Personalise-info'){ echo "class='active'"; }?>><a href="{{url('/cms/Personalise-info')}}"><i class="fa fa-hand-o-right"></i> <span>Personalise Page Info</span></a></li>

               <li <?php if($url == '/cms/manage-social-link'){ echo "class='active'"; }?>><a href="{{url('/cms/manage-social-link')}}"><i class="fa fa-hand-o-right"></i> <span>Manage Social Link</span></a></li>

                <li <?php if($url == '/cms/postage-packaging'){ echo "class='active'"; }?>><a href="{{url('/cms/postage-packaging')}}"><i class="fa fa-hand-o-right"></i> <span>Postage & Packaging</span></a></li>

                   <li <?php if($url == '/cms/thankyou'){ echo "class='active'"; }?>><a href="{{url('/cms/thankyou')}}"><i class="fa fa-hand-o-right"></i> <span>Thankyou page</span></a></li>

                     <li <?php if($url == '/cms/contact-us'){ echo "class='active'"; }?>><a href="{{url('/cms/contact-us')}}"><i class="fa fa-hand-o-right"></i> <span>Contact Us</span></a></li>
           
            </ul>
        </li>

        <li class="treeview <?php if($url == '/blogmodule/banner' || $url == '/blogmodule/blogpage' || $url == '/blogmodule/addblog' || $url == '/blogmodule/editblog/'.$lastsegment){ echo 'active'; }?> ">
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Blog Module</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li <?php if($url == '/blogmodule/banner'){ echo "class='active'"; }?> >
                <a href="{{ url('/blogmodule/banner') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Banner</a>
             </li>
             
              <li <?php if($url == '/blogmodule/blogpage' || $url == '/blogmodule/addblog' || $url == '/blogmodule/editblog/'.$lastsegment){ echo "class='active'"; }?> >
                <a href="{{ url('/blogmodule/blogpage') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Blog</a>
             </li>       
            </ul>      
        </li>
     <li class="treeview <?php if($url == '/merchantmodule/merchant' || $url == '/merchantmodule/viewstore' || $url == '/merchantmodule/merchant-of-the-month' || $url == '/merchantmodule/addmerchant' || $url == '/merchantmodule/viewstore/'.$lastsegment || $url == '/merchantmodule/addstore/'.$lastsegment || $url == '/merchantmodule/viewproduct/'.$lastsegment || $url == '/merchantmodule/addproduct/'.$lastsegment || $url == '/merchantmodule/editproduct/'.$lastsegment || $url == '/merchantmodule/addmerchant/'.$lastsegment){ echo 'active'; }?> ">
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Merchant Module</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li <?php if($url == '/merchantmodule/merchant' || $url == '/merchantmodule/addmerchant' || $url == '/merchantmodule/viewstore/'.$lastsegment || $url == '/merchantmodule/addstore/'.$lastsegment || $url == '/merchantmodule/viewproduct/'.$lastsegment || $url == '/merchantmodule/addproduct/'.$lastsegment || $url == '/merchantmodule/editproduct/'.$lastsegment || $url == '/merchantmodule/addmerchant/'.$lastsegment){ echo "class='active'"; }?> >
                <a href="{{ url('/merchantmodule/merchant') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Merchant</a>
             </li>
               <li <?php if($url == '/merchantmodule/merchant-of-the-month'){ echo "class='active'"; }?> >
                <a href="{{ url('/merchantmodule/merchant-of-the-month') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Merchant Of The Month</a>
             </li>
          </ul>
        </li>      

        <li class="treeview <?php if($url == '/ordermodule/current-order' || $url == '/ordermodule/completed-order' || $url == '/ordermodule/current-order/view-treat/'.$lastsegment || $url == '/ordermodule/complete-order/view-treat/'.$lastsegment ){ echo 'active'; }?> ">
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>Order Module</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li <?php if($url == '/ordermodule/current-order' || $url == '/ordermodule/current-order/view-treat/'.$lastsegment){ echo "class='active'"; }?> >
                <a href="{{ url('/ordermodule/current-order') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Current Order</a>
             </li>
             <li <?php if($url == '/ordermodule/completed-order'  || $url == '/ordermodule/complete-order/view-treat/'.$lastsegment){ echo "class='active'"; }?> >
              <a href="{{ url('/ordermodule/completed-order') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Completed Order</a>
           </li>
          </ul>
        </li>
      
       
  
        <li class="treeview <?php if($url == '/usermodule/user'){ echo 'active'; }?> ">
          <a href="#">
            <i class="fa fa-newspaper-o"></i>
            <span>User Module</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li <?php if($url == '/usermodule/user'){ echo "class='active'"; }?> >
                <a href="{{ url('/usermodule/user') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>User</a>
             </li>
          </ul>
        </li>
        
        <li <?php if($url == '/product'){ echo "class='active'"; }?>><a href="{{url('/product')}}">    <i class="fa fa-newspaper-o"></i></i><span>Product</span></a></li>     
       
        <li class="treeview <?php if($url == '/dasboard/support/contact'){ echo 'active'; }?>">
          <a href="#">
            <i class="fa fa-envelope-o"></i> <span>Support Module</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="{{ url('/dasboard/support/contact') }}"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Contact Queries</a></li>
            <li <?php if($url == '/support-enquiry'){ echo "class='active'"; }?>><a href="{{url('/support-enquiry')}}"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Support Enquiry</a></li>
          </ul>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>