
	<?php
		$url = $_SERVER['REQUEST_URI'];
		$segment = Request::segment(2);
		
	?>
<div class="col-sm-3 col-md-3 col-xs-12">
					<div class="tl-myaccount-left">
						<div class="tl-myaccount-profile">
							<div class="tl-myaccount-profile-img">
								<img src="{{url('/public')}}/frontend/img/place_holder.png" alt="" class="img-responsive">
								<span class="tl-account-edit">
									<i class="fa fa-pencil" aria-hidden="true"></i>
									<input type="file">
								</span>
							</div>
							<div class="tl-myaccount-profile-title">
							<?php $session_all=Session::get('sessionmerchant');
							      $userid = $session_all['userid'];
							   $userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
								 echo ucfirst($userdata[0]->name);
								?>
							</div>
						</div>
						<div class="tl-myaccount-left-nav merchant-user">
							<ul>
								<li>
								<a href="{{url('merchant/myprofile')}}" <?php if($url == '/merchant/myprofile'){ echo "class='active'"; } ?> >My Profile</a></li>

								<li>
								<a href="{{url('merchant/mybusiness')}}" <?php if($url == '/merchant/mybusiness'){ echo "class='active'"; } ?>>My Business</a>
								</li>

								<li><a href="{{url('merchant/order_history')}}" <?php if($url == '/merchant/order_history'){ echo "class='active'"; } ?>>Order History</a>
								</li>

								<li><a href="{{url('merchant/support')}}" <?php if($url == '/merchant/support'){ echo "class='active'"; } ?>>Support</a></li>

								<li><a href="{{url('/merchant/Logout')}}">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>