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
				@include('frontend.common.sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right ">
						<div class="order-history-container">
							<div class="delivery-history-row">	
							<div class="tl-account-right-title">Delivery History</div>
                            <div class="giftcrd-add">{{$delivery_addr[0]->tl_recipient_name}}, {{$delivery_addr[0]->tl_recipient_address}}, {{$delivery_addr[0]->tl_recipient_city}}-{{$delivery_addr[0]->tl_recipient_country}}. ({{$delivery_addr[0]->tl_recipient_postcode}})</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>


 @endsection