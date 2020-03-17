@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->
<style type="text/css">
	.errors{
	  font-size: 14px;
	}
	.errors::-webkit-input-placeholder { /* Chrome/Opera/Safari */
	 color: red !important;
	}
	.errors::-moz-placeholder { /* Firefox 19+ */
	 color: red !important;
	}
	.errors:-ms-input-placeholder { /* IE 10+ */
	 color: red;
	}
	.errors:-moz-placeholder { /* Firefox 18- */
	 color: red !important;
	}
	
	</style>

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Merchant Dashboard</div>
		</div>
	</div>
		 

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
                    @include('frontend.common.sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
				
				<div class="tl_treat_detail">
		            <div class="tl_treat_cols">
		            <div id="tl_content">
                        <div class="tl_teat_title"> <b>To :- </b> {{ucfirst($recieptdetail[0]->tl_recipient_name)}}</div>
                        <div class="tl_teat_address"><b>Address :-</b> {{$recieptdetail[0]->tl_recipient_address}}</div>
                          @foreach($treat AS $value)
                     <div class="tl_teat_proname"><b>Product Name :-</b> {{$value->tl_product_name}}</div>
                     <div class="tl_teat_img"><b>Product image </b><img src="{{url('/public/tl_admin/upload/merchantmod/product/')}}/{{$value->tl_product_image1}}"><div><b>Description </b><?php echo $value->tl_product_description; ?></div></div>
                          @endforeach
                        <div class="tl_treat_from"><b>From :-</b> {{ ucfirst($userdetail[0]->tl_tuser_fullname) }}</div>
					</div>

	                        <a type="button" href="javascript:history.go(-1)" class="go-backbtn hvr-sweep-to-right">Go Back</a>

	                         <a type="button" href="javascript:void(0)" onclick="printDiv('tl_content')" class="go-backbtn hvr-sweep-to-right">print</a>


                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>








</section>

<script type="text/javascript">
  function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        w=window.open();
        w.document.write(printContents);
        w.print();
        w.close();
    }
</script>
	
 @endsection