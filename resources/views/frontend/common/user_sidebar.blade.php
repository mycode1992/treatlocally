<?php  $url = $_SERVER['REQUEST_URI'];  ?>
<div class="col-sm-3 col-md-3 col-xs-12">
					<div class="tl-myaccount-left">
						<div class="tl-myaccount-profile">
							<div class="tl-myaccount-profile-img">
								<img src="{{url('/public')}}/frontend/img/place_holder.png" alt="" class="img-responsive">
							</div>
							<div class="tl-myaccount-profile-title">
								<?php $session_all=Session::get('sessionuser');
								$userid = $session_all['userid'];
							     $userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
								 echo ucfirst($userdata[0]->name);
								?>
							</div>
						</div>
						<div class="tl-myaccount-left-nav">
							<ul>
								<li><a href="{{url('user/myprofile')}}" <?php if($url == '/user/myprofile'){ echo "class='active'"; } ?>>My Profile</a></li>
								<li><a href="{{url('user/treathistory')}}" <?php if($url == '/user/treathistory'){ echo "class='active'"; } ?>>Treat history</a></li>
								<li><a href="{{url('user/support')}}" <?php if($url == '/user/support'){ echo "class='active'"; } ?>>Support</a></li>
								<li><a href="{{url('/user/Logout')}}" <?php if($url == '/user/Logout'){ echo "class='active'"; } ?>>Logout</a></li>
							</ul>
						</div>
					</div>
				</div>