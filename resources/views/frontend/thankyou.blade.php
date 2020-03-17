<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Treat Locally</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="icon" href="{{url('/public')}}/frontend/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/style.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/animate.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="{{url('/public')}}/frontend/css/bootstrap-select.min.css">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<meta name="google" content="notranslate">
	
</head>
<body>

<?php
	$postageprice = DB::table('tbl_postage_packaging')->select('postage_packaging_cost')->where('id','1')->get();	
?>
	<!-- thankyou-start -->

	<section class="tl-thanyou-container">

		<div class="container">
			<div class="tl-thankyou tl-reviewform" id="tl_content">
			<!-- style for print -->
				 <style>
					@media print {
						
						.tl-thankyou .tl-thankyou-title {
							background: #000;
							padding: 25px 25px 35px;
							color: #fff;
							text-align: center;
							width: 100%;
						}

					}
				</style>
			<!-- end style for print -->
				<div class="tl-thankyou-title">
					<div class="tl-thankyou-main">
						<div class="tl_thank-logo">
							<a href="{{url('/')}}"><img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive"> </a>
						</div>
						<?php echo $thankyou_con[0]->tl_thankyou_content;?>
						 <a href="mailto:{{$thankyou_con[0]->email}}" class="tl_thanklink">{{$thankyou_con[0]->email}}</a>
					</p>
				</div>
			</div>

			<div class="tl-payment-flexcols">
				<div class="tl-treat-info">
					<div class="tl-treat-vaucher">
						{{-- <div class="tl-treat-vaucher-cols">
						<div class="tl-treat-title">Voucher number</div>
						<div class="tl-treat-btn">TL01298409871</div>
					</div> --}}
					<div class="tl-treat-vaucher-cols">
						<div class="tl-treat-title">Treat Code</div>
						<?php
						$arr_ord = explode("_",$order_detail_data[0]->tl_order_ref);
						?>
						<div class="tl-treat-btn">{{$arr_ord[1]}}</div>
					</div>
				</div>
				<!-- <div class="tl-treat-heading">
					<div class="tl-treat-hd-title">Treat</div>
					<div class="tl-treat-hd-title">Price</div>
				</div> -->
			</div>


			<!-- table-start -->
			<div class="containeffr">
				<div class="paymentmode-container-table">
					<div class="table-responsive">          
						<table class="table">
							<thead>
								<tr>
									<th style="width:20%">Treat </th>
									<th style="width:40%"></th>
									<th style="width:30%"><p class="text-center">Your Personalised Treat</p></th>
									<th style="width:10%" class="text-centr">Price</th>
									<th style="width:10%" class="text-centr">Postage and Packaging</th>
								</tr>
							</thead>
							<tbody>
								<?php  $card_index = 0; ?>
								@foreach($product AS $product_val)

								<tr>
									<td>
										<div class="tl-flexcols-img">
											<img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{$product_val->tl_product_image1}}" alt="" class="img-responsive">
										</div>
									</td>
									<td  class="table-description">
										<div class="tl-flexcols-text">
											<p class="tl-title">{{$product_val->tl_product_name}}</p>
											<p><?php echo $product_val->tl_product_description ?> </p>
										</div>
									</td>
									<td>
										<div class="tl-flexcols-text">
											<div class="tl-flexcols-text trSampleTemplate">
												<?php if($card_details[$card_index]->template_id=='1'){ ?>
												<div class="trSampleTemplateWidth">
													<div class="template">
														<div class="title"></div>
														<div class="subtitle" id="card1_reciepnt_name">{{$card_details[$card_index]->card_recipient_name}}</div>

														<div class="slogtitle" id="card1_occasion">{{$card_details[$card_index]->card_occasion}}</div>

														<div class="article" id="card1_message">
															<?php echo $card_details[$card_index]->card_message; ?>
														</div>

														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card1_sender_name">{{$card_details[$card_index]->card_sender_name}}</div>
														</div>
														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card1_sender_name">{{$card_details[$card_index]->card_sender_name1}}</div>
														</div>
														<div class="foot-logo">
															<img src="{{url('/')}}/public/frontend/img/logo_white.png" alt="" class="img-responsive">
														</div>
													</div>
												</div>
												<?php } 
												else if($card_details[$card_index]->template_id=='2')
													{ ?>
												<div class="trSampleTemplateWidth">
													<div class="template template_3">
														<div class="title"></div>
														<div class="subtitle" id="card2_reciepnt_name">{{$card_details[$card_index]->card_recipient_name}}</div>

														<div class="slogtitle" id="card2_occasion">{{$card_details[$card_index]->card_occasion}}</div>

														<div class="article" id="card2_message">
															<?php echo $card_details[$card_index]->card_message; ?>
														</div>

														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card2_sender_name">{{$card_details[$card_index]->card_sender_name}}</div>
														</div>
														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card2_sender_name">{{$card_details[$card_index]->card_sender_name1}}</div>
														</div>
														<div class="foot-logo">
															<img src="{{url('/')}}/public/frontend/img/logo_white.png" alt="" class="img-responsive">
														</div>
													</div>
												</div>
												<?php	}
												else if($card_details[$card_index]->template_id=='3')
													{ ?>

												<div class="trSampleTemplateWidth">
													<div class="template template_2">
														<div class="title"></div>
														<div class="subtitle" id="card3_reciepnt_name">{{$card_details[$card_index]->card_recipient_name}}</div>

														<div class="slogtitle" id="card3_occasion">{{$card_details[$card_index]->card_occasion}}</div>

														<div class="article" id="card3_message">
															<?php echo $card_details[$card_index]->card_message; ?>
														</div>

														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card3_sender_name">{{$card_details[$card_index]->card_sender_name}} </div>
														</div>
														<div class="from">
															<div class="from-title"></div>
															<div class="from-name" id="card3_sender_name">{{$card_details[$card_index]->card_sender_name1}} </div>
														</div>
														<div class="foot-logo">
															<img src="{{url('/')}}/public/frontend/img/logo_white.png" alt="" class="img-responsive">
														</div>
													</div>
												</div>


												<?php	}
												?>
											</div>
										</div>
									</td>
									<td>
										<div class="tl-flexcols-right pading20">
											£{{$product_val->tl_product_price}}
										</div>
									</td>
									<td>
										<div class="tl-flexcols-right pading20">
											£{{$postageprice[0]->postage_packaging_cost}}
										</div>
									</td>
								</tr>

								<?php  $card_index++;?>
								@endforeach

							</tbody>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td >
										<div class="tl-ordered">ordered on <b> <?php echo date("Y-m-d", strtotime($order_detail_data[0]->tl_order_created_at));  ?> </b></div>
									</td>
									<td></td>
									<td></td>
									<td >
										<div class="tl-total">Grand Total <b>£<?php echo number_format((float)$order_detail_data[0]->tl_cart_subtotal, 2, '.', ''); ?> </b></div>
									</td>
								</tr>
							</tbody>
						</table>	
					</div>
				</div>
			</div>	
			<!--  table-end-->



			<div class="tl-tabform-treatdetail">
				<div class="col-sm-4 col-md-4 col-xs-12">
					<div class="tl-treatdetail-cols">
						<h2 class="title">Treat From</h2>
						<div class="tl-treatdetail-text">
							{{$user_data[0]->tl_tuser_fullname}} <br>
							{{$user_data[0]->tl_tuser_address}}

							<div class="tl-treatdetail-cont">
								<p><b>Mobile Number -</b> {{$user_data[0]->tl_tuser_mobile}}</p>
								<p><b>E-mail - </b>{{$user_data[0]->tl_tuser_email}}</p>
							</div>
							
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="text-center">
			<a href="javascript:;" onclick="printDiv('tl_content')" target="_blank" id="print">Print</a>
		</div>	
	</div>

</section>

<!-- thankyou-end -->




<script src="{{url('/public')}}/frontend/js/jquery.min.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap.min.js"></script>
<script src="{{url('/public')}}/frontend/js/wow.min.js"></script>
<script src="{{url('/public')}}/frontend/js/jarallax.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap-datepicker.js"></script>
<script src="{{url('/public')}}/frontend/js/bootstrap-select.min.js"></script>
<script>
new WOW().init();
</script> 


<script>

function printDiv(divName) {
	// var printContents = document.getElementById(divName).innerHTML;
	// w=window.open();
	// w.document.write(printContents);
	// w.print();
	// w.close();
	window.print();
}



</script>

<script>
$(document).on('click.bs.dropdown.data-api', '.dropdown.keep-inside-clicks-open', function (e) {
	e.stopPropagation();
});
</script>

<script>
function mapviewtoggle(){
	$('#mapview').show();
	$('#listview').hide();
}
function listviewtoggle(){
	$('#listview').show();
	$('#mapview').hide();
}
</script>
<style type="text/css">
.template.template_2
{
	height: auto;
}
</style>
</body>
</html>