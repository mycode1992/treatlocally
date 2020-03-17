@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">My Account</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				@include('frontend.common.user_sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
						<div class="tl-account-treaths">
							<div class="tl-treat-order">
								<div class="tl-treat-order-cols">
									<p class="order-cols-title">Treat#</p>
									<p class="order-cols-detail black">0D8469874646489</p>
								</div>
								<div class="tl-treat-order-cols">
									<p class="order-cols-title">Order on</p>
									<p class="order-cols-detail grey">Aug 9th 2018</p>
								</div>
								<div class="tl-treat-order-cols">
									<p class="order-cols-title">Status</p>
									<p class="order-cols-detail grey text-color">Delivered</p>
								</div>
							</div>
						</div>

						<div class="tl-ordertreat">
				             <div class="tl-payment-form">
				             	<div class="tl-payment-flexbox">
				             		<div class="cols">Order Treat</div>
				             	</div>
				             </div>
							<div class="tl-payment-flexcols">
				             	<div class="tl-flexcols">
				             		<div class="tl-flexcols-left">
				             			<div class="tl-flexcols-img">
				             				<img src="{{url('/public')}}/frontend/img/featured.jpg" alt="" class="img-responsive">
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
				             				<img src="{{url('/public')}}/frontend/img/template_sample.jpg" alt="" class="img-responsive">
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
					             <div class="tl-payment-form">
					             	<div class="tl-payment-flexbox">
					             		<div class="tl-ordered">Order On <b>Thu, Aug 4th 2018</b></div>
					             		<div class="tl-total">Ordered Total <b>£15</b></div>
					             	</div>
					             </div>

					             <div class="tl-tabform-treatdetail">
					             	<div class="col-sm-4 col-md-4 col-xs-12">
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
					             			</div>
					             		</div>
					             	</div>

					             	<div class="col-sm-4 col-md-4 col-xs-12">
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
					             			</div>
					             		</div>
					             	</div>

					             </div>
				             </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>

<!-- about-end -->

 @endsection