@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Dashboard</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				<div class="col-sm-3 col-md-3 col-xs-12">
					<div class="tl-myaccount-left">
						<div class="tl-myaccount-profile">
							<div class="tl-myaccount-profile-img">
								<img src="{{url('/public')}}/frontend/img/featured.jpg" alt="" class="img-responsive">
								<span class="tl-account-edit">
									<i class="fa fa-pencil" aria-hidden="true"></i>
									<input type="file">
								</span>
							</div>
							<div class="tl-myaccount-profile-title">
								John Doe
							</div>
						</div>
						<div class="tl-myaccount-left-nav merchant-user">
							<ul>
								<li><a href="{{url('user-account/myprofile')}}">My Profile</a></li>
								<li><a href="{{url('user-account/treathistory')}}">Add Store</a></li>
								<li><a href="{{url('user-account/treathistory')}}" class="active">Store List</a></li>
								<li><a href="{{url('user-account/treathistory')}}">Order History</a></li>
								<li><a href="{{url('user-account/support')}}">Support</a></li>
								<li><a href="#">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right ">
						<div class="order-history-container">
							<div class="tl-account-right-title">Order History</div>
				
						</div>
						

						<!-- product-voucher-list-table-start -->
						<div class="tl-reviewform order-history-detail-container">
							



				         	<div class="row">
					            <div class="order-voucher-info-area">
									<div class="order-voucher-info-box">
										<div class="order-voucher-info-title">Voucher Number</div>
										<div class="order-voucher-info-btn">TL01298409871</div>
									</div>
									<div class="order-voucher-info-box">
										<div class="order-voucher-info-title">Treat Type</div>
										<div class="order-voucher-info-btn">STANDARD</div>
									</div>	
							</div>
					             <div class="tl-payment-form">
					             	<div class="tl-payment-flexbox">
					             		<div class="cols">Treat</div>
					             		<div class="cols">Price</div>
					             	</div>
					             </div>
				             </div>

				             <div class="tl-payment-flexcols">
				             	<div class="tl-flexcols">
				             		<div class="tl-flexcols-left">
				             			<div class="tl-flexcols-img">
				             				<img src="http://treatlocally.karmatechprojects.com/public/frontend/img/featured.jpg" alt="" class="img-responsive">
				             			</div>
				             			<div class="tl-flexcols-text">
				             				<p class="tl-title">Dapper Chaps</p>
				             				<p>Hot towel wet shave</p>
				             			</div>
				             		</div>
				             		<div class="tl-flexcols-right">
				             			£15
				             		</div>
				             	</div>

				             	<div class="tl-flexcols">
				             		<div class="tl-flexcols-left">
				             			<div class="tl-flexcols-img">
				             				<img src="http://treatlocally.karmatechprojects.com/public/frontend/img/template_sample.jpg" alt="" class="img-responsive">
				             			</div>
				             			<div class="tl-flexcols-text">
				             				<p>Personalised Treat</p>
				             			</div>
				             		</div>
				             		<div class="tl-flexcols-right">
				             			£3.99
				             		</div>
				             	</div>

				             </div>
							
							 <div class="tl-tabform-ordered">
					             <div class="row">
						             <div class="tl-payment-form">
						             	<div class="tl-payment-flexbox">
						             		<div class="tl-ordered">Order Date <b>Thu, Aug 4th 2018</b></div>
						             		<div class="tl-total">Ordered Total <b>£15</b></div>
						             	</div>
						             </div>
					             </div>

					             <div class="tl-tabform-treatdetail">
					             	<div class="col-sm-5 col-md-5 col-xs-12">
					             		<div class="tl-treatdetail-cols">
					             			<h2 class="title">Treat By</h2>
					             			<div class="tl-treatdetail-text">
					             				David Di Donato <br>
												46 main street, <br>
												E\evesham worcestershire, <br>
												wr119ur.

												<div class="tl-treatdetail-cont">
													<p><b>Mobile Number -</b> 07777996752</p>
													<p><b>E-mail - </b>david@treatlocally.com</p>
												</div>
												<div class="tl-editaddress">
													<a href="#">Edit Address</a>
												</div>
					             			</div>
					             		</div>
					             	</div>

					             	<div class="col-sm-5 col-md-5 col-xs-12">
					             		<div class="tl-treatdetail-cols">
					             			<h2 class="title">Treat To</h2>
					             			<div class="tl-treatdetail-text">
					             				Mark Goldin <br>
												1233 market street <br>
												E\evesham worcestershire, <br>
												94130.

												<div class="tl-treatdetail-cont">
													<p><b>Mobile Number -</b> 09839907990</p>
													<p><b>E-mail - </b>david@treatlocally.com</p>
												</div>
												<div class="tl-editaddress">
													<a href="#">Edit Address</a>
												</div>
					             			</div>
					             		</div>
					             	</div>

					             </div>
				             </div>
<div class="clearfix"></div>
				         </div>
						<!-- product-voucher-list-table-end -->
					
					</div>
				</div>
			</div>
		</div>
	</div>


</section>

<!-- about-end -->
<style type="text/css">
	.tl-reviewform.order-history-detail-container {
    border: solid 1px #ccc;
    padding: 0 15px;
    margin: 15px 0;
}
.tl-reviewform.order-history-detail-container .tl-payment-form .tl-payment-flexbox {
    padding: 10px 25px;
}
.tl-reviewform.order-history-detail-container .tl-payment-flexcols .tl-flexcols{
	-webkit-box-align: center;-ms-flex-align: center;align-items: center;
}
.order-voucher-info-area {
    border-bottom: solid 1px #ccc;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin: 10px 0;
    padding: 0 0 15px 0;
}
.order-voucher-info-box {
    margin: 0 0px 0 20px;
}
.order-voucher-info-btn {
    background: #b7b7b7;
    padding: 5px;
    color: #fff;
    width: 150px;
    text-align: center;
}
.order-voucher-info-title {
    text-align: center;
    font-weight: bold;
    padding: 0 0 7px 0;
}
</style>

 @endsection