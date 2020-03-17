@extends('frontend.layouts.frontlayout')

@section('content')
<?php 
// print_r($data);

$stripe_account_id = $data; ?>
<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('{{url('/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg')}}');"></div>
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Dashboard</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				@include('frontend.common.sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
                            <div class="tl-account-right-title">Connect Account</div>

                        <?php
                        
						 if($stripe_account_id!=''){   
                        ?>
						<div class="tl-account-right-form">
						
							 
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<p class="tl-srtipe">
												<span>Your Connectd id :</span> {{$stripe_account_id}}
                                            </p>
										</div>
									</div>	
								</div>
						
                        </div>
                    <?php
                	}
                	else
                	{
                    ?>
                    <p> Please provide as much information as possible for us to help you to transfer your payment otherwise your treat/product will not be visible to user</p>

						<div class="tl-account-right-form">
							<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
												<div class="overlay" style="position: relative !important;display:none;">
														<i class="fa fa-refresh fa-spin"></i>
													  </div>
											<label for="">
												<button type="button" onclick="return connect_stripe()"  class="hvr-sweep-to-right">CONNECT</button>
											</label>
										</div>
									</div>	
								</div>
						
                        </div>
                       
						
                    <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<script>
function connect_stripe()
{
	// $(".overlay").css("display",'block'); 
	// return false;
    $.ajax({
      headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
      type: 'POST',
      url: "{{ url('/merchant/connect_stripe') }}",
      cache: false,
      contentType: false,
      processData: false,  
      success:function(response) 
      {
         // console.log(response);					
		 if(response.status==200)
		 {
			// $(".overlay").css("display",'none');
			window.location = response.link;
		 }		 
      }
    });
  return false;
}
</script>

 @endsection