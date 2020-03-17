@extends('frontend.layouts.frontlayout')

@section('content')
  
  @foreach($data as $data_val)
<section class="tl-contact tl-terms">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/tl_admin/upload/privacy-policy/{{ $data_val->tl_privacypolicies_imagename }});"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Privacy Policy</div>
		</div>
	</div>

	<div class="container">

		<div class="tl-article">
		    <?php echo $data_val->tl_privacypolicies_content;?>
		
		</div>
	</div>
</section>
@endforeach

 @endsection