@extends('frontend.layouts.frontlayout')

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

<link rel="stylesheet" href="{{url('/public/frontend/stripe_assets/stripe_css.css')}}">
<?php 

		$postageprice = DB::table('tbl_postage_packaging')->select('postage_packaging_cost')->where('id','1')->get();
 	$seg_cart_id = Request::segment(2); 
		$session_alluser  =Session::get('sessionuser');
		if(isset($session_alluser) && count($session_alluser) > 0){
		    	$session_all = 'sessionuser';
			    $userid = $session_alluser['userid'];
		        $userdata =  DB::table('users')
						   ->join('tbl_tl_user_detail','tbl_tl_user_detail.tl_userdetail_userid','users.userid')
						   ->select('users.name','users.email','tbl_tl_user_detail.tl_userdetail_address','tbl_tl_user_detail.tl_userdetail_phoneno')->where('userid',$userid)->get();
				$userdata_name = $userdata[0]->name;
				$userdata_email = $userdata[0]->email;
				$userdata_phone = $userdata[0]->tl_userdetail_phoneno;
				$userdata_address = $userdata[0]->tl_userdetail_address;
			} 
			else{
				$session_all = '';
				$userdata_name = '';
				$userdata_email ='';
				$userdata_phone = '';
				$userdata_address = '';

			}
 
	
?>
<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/frontend/img/aboutus_header.jpg);"></div>
		
		
		<div class="tl-caption-title tl-caption-title-maketreat">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="tl-title">Make your treat Personal</div>
						<div class="tl-link-caption">
							<a href="{{url('/')}}">	<span>Go to the treats</span></a>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="row">
							<div class="tl-steptostep">
								<div class="tl-step-flexbox">
									<div class="tl-step-cols active"><a href="{{url('/')}}">Choose Your Treat</a></div>
									<div class="tl-step-mobile"><a href="{{url('/')}}">1</a></div>
									
									<div id="review_treat1" class="tl-step-cols <?php if(!empty($_SESSION["shopping_cart"])){echo 'active';}?>"><a href="{{url('/review_treat')}}">Review Your Treat</a></div>
									<div class="tl-step-mobile"> <a href="{{url('/review_treat')}}"> 2 </a></div>
									<div class="tl-step-cols active"><a href="{{url('/payment_mode')}}/{{$seg_cart_id}}">Review And Payment</a></div>
									<div class="tl-step-mobile"><a href="{{url('/payment_mode')}}/{{$seg_cart_id}}">4</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-template-main">
		 <div class="tl-formsearch-btn">
        <a href="#" class="hvr-sweep-to-right goback_navi" onclick="javascript:history.go(-1)">
        		Go back
        </a>
      </div>
			<div class="tl-template-tabs">
				<div class="panel-group" id="accordion">
				   <div class="panel panel-default" id="addactivecoll">
				      <div class="panel-heading">
				         <h4 class="panel-title comp_tab" id="comp_tab1">
				            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="open-collapse">
								Billing and Card Details
				            </a>
				         </h4>
				      </div>
				 
				      <div id="collapseOne" class="panel-collapse collapse in">
				         <div class="panel-body">
				            <div class="tl-payment-form">
									  <div class="col-sm-12 col-md-12 col-xs-12">
										<div class="form-group">
											<label for="" class="tl-tabform-checkbox">
												<div class="gigs-fltr-add">
													<input type="radio" name="user_type" id="guest"  onClick="return guest_section_func('show');" value="GUEST" <?php if($session_all==false){ echo "checked='checked'"; }else{ echo "disabled"; } ?>>
													<label for="guest"><span class="checkbox">Guest Checkout</span></label>
												</div>
												
												<div class="gigs-fltr-add">
													<input type="radio" name="user_type" id="register" onClick="return guest_section_func('hide');" value="REGISTER" <?php if($session_all=='sessionuser'){ echo "checked='checked'"; } ?> >
													<label for="register"><span class="checkbox">Checkout With TreatLocally Account</span></label>
												</div>
										
											</label>											        
										</div>
									</div>
								
									<div class="row">
										<div id="guest_user_section">
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">Full Name*</label>
													<label for="">
														<input type="text" id="guest_name" name="guest_name" onkeypress="return isChar(event)" class="form-control" placeholder="Full Name">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">Mobile Number*</label>
													<label for="">
														<input type="text" class="form-control" onkeypress="return isNumberKey(event)" maxlength="15" id="guest_mobile" name="guest_mobile" placeholder="Enter Number">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">Email*</label>
													<label for="">
														<input type="text" class="form-control" id="guest_email" name="guest_email" placeholder="Enter E-mail">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">Address*</label>
													<label for="">
														<input type="text" id="guest_address" onkeypress="return isChar1(event)" name="guest_address" class="form-control" placeholder="Address">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">City</label>
													<label for="">
														<input type="text" onkeypress="return isChar1(event)" id="guest_city" name="guest_city" class="form-control" placeholder="City">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">County</label>
													<label for="">
														<input type="text" onkeypress="return isChar1(event)" class="form-control" id="guest_country" name="guest_country" placeholder="County">
													</label>
												</div>
											</div>
											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="">Postcode*</label>
													<label for="">
														<input type="text" onkeypress="return isChar1(event)" maxlength="10" class="form-control" id="guest_postcode" name="guest_postcode" placeholder="Postcode">
													</label>
												</div>
											</div>
											<div class="col-sm-12 col-md-12 col-xs-12">
													<div class="form-group">
														<label for="">
															<button onclick="return guest_checkout();" class="tl-tabform-btn hvr-sweep-to-right">Continue</button>
				            							</label>
														
													</div>	
												</div>
										</div>
										
										<div id="login_user_section" style="display: none;">
										  <form action="#" onsubmit="return user_login();">
												<input type="hidden" name="cartunique_id" id="cartunique_id" value="{{$seg_cart_id}}">

											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
													<label for="" class="form-text">Email <span>*</span></label>
													<label for="">
														<input type="text" id="login_email" name="login_email"  maxlength="60" class="form-control">
													</label>
												</div>
											</div>

											<div class="col-sm-4 col-md-4 col-xs-12">
												<div class="form-group">
														<label for="" class="form-text">Password <span>*</span></label>
														<label for="">
															<input type="password" id="login_password" class="form-control">
														</label>
												</div>
											</div>

											<div class="col-sm-12 col-md-12 col-xs-12">
													<div id="errormsg" style="font-size:14px;margin:0 0 5px;text-align: left;"></div>
													<div class="overlay" style="display:none;">
													<i class="fa fa-refresh fa-spin"></i>
													</div>
												</div>	
												<div class="col-sm-12 col-md-12 col-xs-12">
														<div class="form-group">
															<div class="tl-form-sb-btn">
																<button type="submit" class="hvr-sweep-to-right">Sign in</button>
															</div>
														</div>
													</div>
												
										   </form>
										</div>
				            		</div>  
				            
				            </div>
				         </div>
				      </div>
				      
				   </div>
				   
				   <div class="panel panel-default">
				      <div class="panel-heading activecollapse" id="removeactivecoll2">
				         <h4 class="panel-title" id="comp_tab3">
				            <a data-toggle="collapse" data-parent="#accordion"  href="#collapseThree" class="open-collapse">
				               Review your treat order
				            </a>
				         </h4>
				      </div>
				     
				      <div id="collapseThree" class="panel-collapse collapse">
				         <div class="panel-body tl-reviewform">
				         	
<!-- table-start -->
<div class="containeffr">
	<div class="paymentmode-container-table">
		<div class="table-responsive">          
			<table class="table">
				<thead>
					<tr>
						<th style="width:20%">Treat in Cart</th>
						<th style="width:300px;"></th>
						<th style="width:30%"><p class="text-center">Your Personalised Treat</p></th>
						<th style="width:10%">Price</th>
						<th style="width:10%">Postage and Packaging</th>
						
					</tr>
				</thead>
				<tbody>
					<?php	
					$total_pro_price = 0;
					$total_card_price = 0;
					$card_index = 0;
					if(!empty($data))
					{
						foreach($data as $values)
						{ 
							$total_pro_price = $total_pro_price + $values->tl_product_price;
							$total_card_price = $total_card_price + $postageprice[0]->postage_packaging_cost;
							?>
							<div class="tl-flexcols">
								<tr>
									<td>
										<div class="tl-flexcols-img">
											<img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{$values->tl_product_image1}}" alt="" class="img-responsive">
										</div>
									</td>
									<td class="table-description">
										<div class="tl-flexcols-text">
											<p class="tl-title"><?php echo $values->store_name; ?></p>
											<p class="tl-title"><?php echo $values->tl_product_name; ?></p>
											<p><?php echo $values->tl_product_description; ?></p>
										</div>
									</td>
									<td>
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
														<div class="from-name" id="card2_sender_name">{{$card_details[$card_index]->card_sender_name}} </div>
													</div>
													<div class="from">
														<div class="from-title"></div>
														<div class="from-name" id="card2_sender_name">{{$card_details[$card_index]->card_sender_name1}} </div>
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
									</td>
									<td>
										<div class="tl-flexcols-right">
											£<?php echo $values->tl_product_price; ?>
										</div>
									</td>
									<td>
										<div class="tl-flexcols-right">
											£{{$postageprice[0]->postage_packaging_cost}}
										</div>
									</td>
								</tr>
							</div>
							<?php 	$total_price = $total_pro_price + $total_card_price; $card_index++;   } 
						} ?>

					</tbody>
				</table>
			</div>
			<div class="table-responsive">
				<table class="table">
					<tbody>
						<tr>
							<td >
								<div class="tl-ordered">Order On 
									<b>
										<?php
										$date=date_create($curdate);
										$orderdate = date_format($date,"D, M d, Y");
										?>
										<?php echo $orderdate; ?>
									</b></div>
								</td>
								<td></td>
								<td></td>
								<td >
									<div class="tl-total">Ordered Total <b>£<?php echo number_format((float)$total_price, 2, '.', ''); ?></b></div>
									<input type="hidden" name="total_price" id="total_price" value="{{ $total_price }}">
								</div>
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>
	</div>	
<!--  table-end-->
<div class="deliver-treat-msg">
  Your treat will be delivered to your loved one within 3 working days of your order
</div>
<!--  -->
				          

				          <div class="tl-tabform-treatdetail">
					             	<div class="col-sm-4 col-md-4 col-xs-12">
					             		<div class="tl-treatdetail-cols">
					             			<h2 class="title">Treat From</h2>
					             			<div class="tl-treatdetail-text" id="sender_value">
					             				{{$userdata_name}} <br>
												{{$userdata_address}}

												<div class="tl-treatdetail-cont">
													<p><b>Mobile Number -</b> {{$userdata_phone}}</p>
													<p><b>E-mail - </b>{{$userdata_email}}</p>
												</div>
												<!-- <div class="tl-editaddress">
													<a href="#">Edit Address</a>
												</div> -->
					             			</div>
					             		</div>
					             	</div>

					             	{{-- <div class="col-sm-4 col-md-4 col-xs-12">
					             		<div class="tl-treatdetail-cols">
					             			<h2 class="title">Treat To</h2>
					             			<div class="tl-treatdetail-text" id="recipient_value">
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
									 </div> --}}
									 
									 <div class="col-sm-12 col-md-12 col-xs-12">
				            				<div class="form-group">
				            					<label for="">
				            					<button onclick="return review();" class="tl-tabform-btn hvr-sweep-to-right">Continue</button>
				            					</label>
				            				</div>	
				            			</div>

					             </div>
				      </div>
				     
				   </div>
			
				   <div class="panel panel-default">
				      <div class="panel-heading activecollapse" id="removeactivecoll3">
				         <h4 class="panel-title" id="comp_tab4">
				            <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour" class="open-collapse">
				               Payment
				            </a>
				         </h4>
				      </div>
				     
				      <div id="collapsefour" class="panel-collapse collapse">
				         <div class="panel-body tl-reviewform">
				         	<div class="tl-payment-main">
				         		<h3 class="tl-payment">Add a payment method</h3>
				         		<div class="tl-payment-flexbox">
				         			<p><span>Credit Card</span> (we accept all major credit cards)</p>
				         			<p><img src="{{url('/public')}}/frontend/img/cards.jpg" alt="" class="img-responsive"></p>
								 </div>
								 
					<form action="{{url('/store_payment')}}" method="POST" id="payment-form" onsubmit="return payment();">
					{{csrf_field()}}
					<input type="hidden" name="cart_id" id="cart_id" value="{{$seg_cart_id}}">
					<input type="hidden" name="formdata_guest_name" id="formdata_guest_name">
					<input type="hidden" name="formdata_guest_mobile" id="formdata_guest_mobile">
					<input type="hidden" name="formdata_guest_email" id="formdata_guest_email">
					<input type="hidden" name="formdata_guest_address" id="formdata_guest_address">
					<input type="hidden" name="formdata_guest_city" id="formdata_guest_city">
					<input type="hidden" name="formdata_guest_country" id="formdata_guest_country">
					<input type="hidden" name="formdata_guest_postcode" id="formdata_guest_postcode">
					<input type="hidden" name="formdata_total_price" id="formdata_total_price">
					<input type="hidden" name="formdata_user_type" id="formdata_user_type">
					

					<div class="form-row">
						<label for="card-element">
						Credit or debit card
						</label>
						<div id="card-element">
						<!-- A Stripe Element will be inserted here. -->
						</div>
					
						<!-- Used to display form errors. -->
						<div id="card-errors" role="alert"></div>
					</div>
					
					<button id="payment_button" type="submit" class="tl_paybtn hvr-sweep-to-right">Pay now and complete order</button>
					</form>
								 <script src="https://js.stripe.com/v3/"></script>
				         	</div>
				         </div>
				      </div>
				     
				   </div>


				</div>
			</div>
		</div>
	</div>
</section>





<script src="{{url('/public/frontend/stripe_assets/stripe_js.js')}}"></script>
<script>

	(function() {
		<?php if($session_all=='sessionuser'){ ?>   
			var element = document.getElementById('removeactivecoll2');
      element.classList.remove("activecollapse");

	 var collapseOne = document.getElementById('collapseOne');
  collapseOne.classList.remove("in");

	var collapseThree = document.getElementById('collapseThree');
	collapseThree.classList.add("in");

	 var comp_tab2 = document.getElementById('comp_tab2');
	 comp_tab2.classList.remove("comp_tab"); 
	 
	 var comp_tab3 = document.getElementById('comp_tab3');
  comp_tab3.classList.add("comp_tab");  
			
      <?php } ?>

		if (document.getElementById('guest').checked) {
			user_type = document.getElementById('guest').value;
			}

		if (document.getElementById('register').checked) {
			user_type = document.getElementById('register').value;
			}
	
	   if(user_type=='GUEST'){
		document.getElementById('guest_user_section').style.display = 'block';
		}
		else if(user_type=='REGISTER'){
		
			document.getElementById('guest_user_section').style.display = 'none';
		}

	})();

	function guest_section_func(value){
	
	if(value=='show'){
		$('#guest_user_section').css('display','block');
		$('#login_user_section').css('display','none');
	}else if(value=='hide'){
	  $('#guest_user_section').css('display','none');
	  $('#login_user_section').css('display','block');
	}
  }



   function guest_checkout(){
	var guest_name = document.getElementById('guest_name').value.trim();   
	var guest_mobile = document.getElementById('guest_mobile').value.trim();   
	var guest_email = document.getElementById('guest_email').value.trim();   
	var guest_address = document.getElementById('guest_address').value.trim();   
	var guest_city = document.getElementById('guest_city').value.trim();   
	var guest_country = document.getElementById('guest_country').value.trim();   
	var guest_postcode = document.getElementById('guest_postcode').value.trim(); 
	var user_type = $('input[name=user_type]:checked').val(); 

	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	 var strUserEml=guest_email.toLowerCase();

	 if(guest_name == "")
		{
			document.getElementById('guest_name').style.border='1px solid #ff0000';
			document.getElementById("guest_name").focus();
			$('#guest_name').val('');
			$('#guest_name').attr("placeholder", "Please enter your full name");
			$("#guest_name").addClass( "errors" );
			return false;
		}
		else{
			document.getElementById('guest_name').style.border=' ';
			$("#guest_name").removeClass( "errors" );
		}
  
   if(guest_mobile == "")
  {
    document.getElementById('guest_mobile').style.border='1px solid #ff0000';
    document.getElementById("guest_mobile").focus();
    $('#guest_mobile').val('');
    $('#guest_mobile').attr("placeholder", "Please enter your mobile");
    $("#guest_mobile").addClass( "errors" );
    return false;
  }
  else if(guest_mobile.length <=9 || guest_mobile.length >=16)
 {
		document.getElementById('guest_mobile').style.border='1px solid #ff0000';
	   document.getElementById("guest_mobile").focus();
	  $("#guest_mobile").val('');
       $('#guest_mobile').attr("placeholder", "Phone no should be 10-15 digits");
       $("#guest_mobile").addClass( "errors" );

        return false;
 }
  else{
    document.getElementById('guest_mobile').style.border=' ';
  } 
  
  if(guest_email == "")
  {
    document.getElementById('guest_email').style.border='1px solid #ff0000';
    document.getElementById("guest_email").focus();
    $('#guest_email').val('');
    $('#guest_email').attr("placeholder", "Please enter your email");
    $("#guest_email").addClass( "errors" );
    return false;
  } else if(!filter.test(strUserEml)) 
  {

    document.getElementById('guest_email').style.border='1px solid #ff0000';
       document.getElementById("guest_email").focus();
       $('#guest_email').val('');
       $('#guest_email').attr("placeholder", "Invalid E-mail Id");
       $("#guest_email").addClass( "errors" );

        return false;
  }
  else{
    document.getElementById('guest_email').style.border=' ';
  } 
  
  if(guest_address == "")
  {
    document.getElementById('guest_address').style.border='1px solid #ff0000';
    document.getElementById("guest_address").focus();
    $('#guest_address').val('');
    $('#guest_address').attr("placeholder", "Please enter your address");
    $("#guest_address").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('guest_address').style.border=' ';
  }
  
   if(guest_city == "")
  {
    document.getElementById('guest_city').style.border='1px solid #ff0000';
    document.getElementById("guest_city").focus();
    $('#guest_city').val('');
    $('#guest_city').attr("placeholder", "Please enter your city");
    $("#guest_city").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('guest_city').style.border=' ';
  } 
  
  if(guest_country == "")
  {
    document.getElementById('guest_country').style.border='1px solid #ff0000';
    document.getElementById("guest_country").focus();
    $('#guest_country').val('');
    $('#guest_country').attr("placeholder", "Please enter your country");
    $("#guest_country").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('guest_country').style.border=' ';
  } 
  
  if(guest_postcode == "")
  {
    document.getElementById('guest_postcode').style.border='1px solid #ff0000';
    document.getElementById("guest_postcode").focus();
    $('#guest_postcode').val('');
    $('#guest_postcode').attr("placeholder", "Please enter your postcode");
    $("#guest_postcode").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('guest_postcode').style.border=' ';
  }  
    
  $('#sender_value').html(guest_name+'</br>'+guest_address+'<div class="tl-treatdetail-cont">	<p><b>Mobile Number -</b>'+guest_mobile+'</p>	<p><b>E-mail - </b>'+strUserEml+'</p></div>');

 var element = document.getElementById('removeactivecoll2');
      element.classList.remove("activecollapse");

	 var collapseOne = document.getElementById('collapseOne');
  collapseOne.classList.remove("in");

	var collapseThree = document.getElementById('collapseThree');
	collapseThree.classList.add("in");

	 var comp_tab2 = document.getElementById('comp_tab2');
	 comp_tab2.classList.remove("comp_tab"); 
	 
	 var comp_tab3 = document.getElementById('comp_tab3');
  comp_tab3.classList.add("comp_tab");

  

   }

   function user_login()
    {
		
        document.getElementById("errormsg").innerHTML='';
        var login_email = document.getElementById("login_email").value.trim();   
        var strUserEml=login_email.toLowerCase();
        var login_password = document.getElementById("login_password").value.trim();   
        var cartunique_id = document.getElementById("cartunique_id").value.trim(); 
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
        
         // validation for email 
			if(login_email=="")
		{

			document.getElementById('login_email').style.border='1px solid #ff0000';
			document.getElementById("login_email").focus();
			$('#login_email').attr("placeholder", "Please enter your E-mail Id");
			$("#login_email").addClass( "errors" );

				return false;
		}
  else if(!filter.test(strUserEml)) 
  {

    document.getElementById('login_email').style.border='1px solid #ff0000';
       document.getElementById("login_email").focus();
       $('#login_email').val('');
       $('#login_email').attr("placeholder", "Invalid E-mail Id");
       $("#login_email").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("login_email").style.borderColor = "";     
       
  }

  if(login_password=="")
  {

       document.getElementById('login_password').style.border='1px solid #ff0000';
       document.getElementById("login_password").focus();
       $('#login_password').attr("placeholder", "Please enter your password");
       $("#login_password").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("login_password").style.borderColor = "";     
       
  }

 $(".overlay").css("display",'block');
  
 var form = new FormData();
        form.append('email', strUserEml); 
        form.append('password', login_password); 
        form.append('cartunique_id', cartunique_id); 

    $.ajax({  
			headers: {'X-CSRF-Token':'{{ csrf_token() }}'},   
			type: 'POST',
			url: "{{url('/user/login')}}",
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success:function(response) 
			{   	 
			$(".overlay").css("display",'none');
			
			console.log(response);  //return false;
			var status=response.status;
			var cartunique_id=response.cartunique_id;
			var msg=response.msg;
			
			if(status=='200' && cartunique_id!='')
			{
				
				$("#login_email,#login_password").removeClass( "errors" );
				$("#login_email,#login_password").val('');
				document.getElementById("errormsg").innerHTML=msg;
				document.getElementById("errormsg").style.color = "#278428";
				setTimeout(function() { location.reload(true) }, 1000);
			}
			else if(status=='401')
			{
				document.getElementById("errormsg").style.color = "#ff0000";
				document.getElementById("errormsg").innerHTML=msg;
			}
			
			}

			});
			return false;
    }

   function review(){

	var element = document.getElementById('removeactivecoll3');
      element.classList.remove("activecollapse");

	  var collapseThree = document.getElementById('collapseThree');
	  collapseThree.classList.remove("in");

	var collapsefour = document.getElementById('collapsefour');
	collapsefour.classList.add("in");

	 var comp_tab3 = document.getElementById('comp_tab3');
		 comp_tab3.classList.remove("comp_tab");
		 
		 var comp_tab4 = document.getElementById('comp_tab4');
         comp_tab4.classList.add("comp_tab");
	
   }

      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
	  }
	  
	  function isChar(evt)
		{

			var iKeyCode = (evt.which) ? evt.which : evt.keyCode
					
			if (iKeyCode != 46 && iKeyCode > 31 && iKeyCode > 32 && (iKeyCode < 65 || iKeyCode > 90)&& (iKeyCode < 97 || iKeyCode > 122))
			{
			return false;
			}
			else if(iKeyCode == 46)
			{
			return false;
			}
			else
			{
			return true;
			
			}

		}

		 function isChar1(evt)
			 {

			     var regex = new RegExp("^[a-zA-Z0-9]+$");
			    var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
			    if (!regex.test(key)) {
			       evt.preventDefault();
			       return false;
			    }

			 }

</script>

 @endsection