@extends('tl_admin.layouts.frontlayouts')

@section('content')

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
	<div class="container">
		<div class="tl-template-main">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="tl-template-detail tl-editcart-template">
						<div class="tl-template-giftcard">
							<div class="tl-giftcard-form">
								
						<span>Address :-</span>
							<div class="clearfix"></div>
							<span class="giftcrd-add">{{$delivery_addr[0]->tl_recipient_name}}, {{$delivery_addr[0]->tl_recipient_address}}, {{$delivery_addr[0]->tl_recipient_city}}-{{$delivery_addr[0]->tl_recipient_country}}. ({{$delivery_addr[0]->tl_recipient_postcode}})</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style type="text/css">

</style>
@endsection