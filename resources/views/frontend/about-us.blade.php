@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

@foreach($data as $data_val)
<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/tl_admin/upload/aboutus/{{ $data_val->tl_aboutus_imagename }});"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">About Us</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-about-main">
			<div class="tl-about-logo">
				<img src="{{url('/public')}}/frontend/img/logo.png" alt="" class="img-responsive">
			</div>

			<span class="text-center tl-about-title">
				<?php echo $data_val->tl_aboutus_content;?>

				</span>
		</div>
	</div>


</section>
@endforeach
<!-- about-end -->

 @endsection