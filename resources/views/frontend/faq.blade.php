@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/frontend/img/aboutus_header.jpg);"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">FAQ's</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="tl-faq-main">
			  @foreach($data AS $data_val)
				 <?php 
				      $check_catid = $data_val->tl_faq_category_id;
				      $sql = DB::table('tbl_tl_faq_category_detail')->select('tl_faq_category_detail_catid')->where([
				      	           ['tl_faq_category_detail_catid',$check_catid],
				      	           ['tl_faq_category_detail_status',1]
				      	])->get();
						 if(count($sql) > 0) {
				 
				 ?>
				<div class="col-sm-4 col-md-4 col-xs-12">
					<div class="tl-faq-cols">
						<div class="tl-faq-cols-title">{{ $data_val->tl_faq_category_name }}</div>
						<ul>
								<?php 
								$cat_id =  $data_val->tl_faq_category_id;
								$row = DB::table('tbl_tl_faq_category_detail')->select('tl_faq_category_detail_description','tl_faq_category_detail_title','tl_faq_category_detail_id')->where('tl_faq_category_detail_catid', $cat_id )->where('tl_faq_category_detail_status','1')->get(); ?>
						     @foreach($row AS $row_val)
							<li><a href="javascript:avoid(0)" data-toggle="modal" data-target="#faqmodal{{ $row_val->tl_faq_category_detail_id }}">{{ $row_val->tl_faq_category_detail_title }}</a></li>
							    <!-- modal-start -->

									<div class="modal faq-modal fade" id="faqmodal{{ $row_val->tl_faq_category_detail_id }}" role="dialog">
									<div class="modal-dialog">

										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<p class="tl-faqmodal-title">{{ $row_val->tl_faq_category_detail_title }}</p>

										<p class="text-center">
										<?php echo $row_val->tl_faq_category_detail_description; ?>

										</p>
											</div>
										</div>
										
									</div>
									</div>

<!-- modal-end -->
								 @endforeach
						</ul>	
					</div>
				</div>
						 <?php } ?>
        @endforeach

			</div>
		</div>
	</div>




</section>

<!-- about-end -->

 @endsection

 