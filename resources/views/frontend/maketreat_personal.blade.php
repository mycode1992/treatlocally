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

		<?php    
              
			if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"]))
			{      
                 
				 $unique_cart_id1 = $_SESSION["cartuniqueid"];
				 $card_details = DB::table('tbl_tl_card')->where('cart_uniqueid',$unique_cart_id1)->where('tl_product_id',$productid)->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name','card_sender_name1')->get();

				 if(count($card_details)>0)
				 {
					$template_id = $card_details[0]->template_id;
					$card_recipient_name = $card_details[0]->card_recipient_name;
					$card_occasion = $card_details[0]->card_occasion;
					$card_message = $card_details[0]->card_message;
					$card_sender_name = $card_details[0]->card_sender_name;
					$card_sender_name1 = $card_details[0]->card_sender_name1; 
					$buttontext = 'Update';
				 }
				 else
				 {       
					$template_id = '';
					$card_recipient_name = '';
					$card_occasion = '';
					$card_message = '';
					$card_sender_name = '';
					$card_sender_name1 = '';
					$unique_cart_id1 = '';
					$buttontext = 'Personalise'; 
				}
				
			 }
			else  
			{  
				$template_id = '';
				$card_recipient_name = '';
				$card_occasion = '';
				$card_message = '';
				$card_sender_name = '';
				$card_sender_name1 = '';
				$unique_cart_id1 = '';
				$buttontext = 'Personalise';
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
					</div>
					<div class="col-xs-12">
						<div class="row">
							<div class="tl-steptostep">
								<div class="tl-step-flexbox">
									<div class="tl-step-cols active"><a href="{{url('/')}}">Choose Your Treat</a></div>
									<div class="tl-step-mobile"><a href="{{url('/')}}">1</a></div>
									
									<div id="review_treat1" class="tl-step-cols <?php if(!empty($_SESSION["shopping_cart"])){echo 'active';}?>"><a href="{{url('/review_treat')}}">Review Your Treat</a></div>
									<div class="tl-step-mobile"> <a href="{{url('/review_treat')}}"> 2 </a></div>

									<div class="tl-step-cols"> <a href="javascript:void(0)"> Review And Payment</a></div>
									<div class="tl-step-mobile"><a href="javascript:void(0)">4</a></div>
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
			<div class="row">
				
				<div class="col-sm-6 col-md-6 col-xs-12  col-md-push-6 ">
					<div class="tl-template-detail">
						 <div class="tl-formsearch-btn">
					        <a href="#" class="hvr-sweep-to-right goback_navi" onclick="javascript:history.go(-1)">Go back</a>
					      </div>
											<div class="tl-template-giftcard">
							{{-- <div class="tl-giftcard-title">1. Select template for your gift card</div> --}}

							<label for="" class="togglehover">
								<span class="tl-giftcard-title">1. Select template for your gift card</span>
								<span><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" title="<?php echo $personalise_info[0]->tl_personalise_info; ?>"></i></span>
							</label>

							<div class="tl-giftcard">
									<?php $q=0;?>
									@foreach($data AS $data_val)
									<?php $q++; 
									 
									?>
									<div class="giftcard-box" >  
										<div class="tl-temp-tab tl-temp{{$q}}" id="activetem{{$q}}" onclick="return selecttemplate({{$q}},{{$data_val->id}})">
											<img src="{{url('/public')}}/frontend/template/{{$data_val->template}}" alt="" class="img-responsive">
										</div>
										<button class="tl-preview" onclick="return mybtn({{$q}})" >Preview</button>
									</div>
									@endforeach

								
							
							</div>
							<div class="tl-giftcard-form">
								<div class="tl-giftcard-title">2. Enter your gift card details</div>	
								<form action="#" method="#" id="make_treat_per_form" onsubmit="return maketreat_personal();">
										<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
										<input type="hidden" name="productid" id="productid" value="{{$productid}}"> 
										<input type="hidden" name="unique_cart_id1" id="unique_cart_id1" value="{{$unique_cart_id1}}"> 
									<div class="form-group">
										<label for="">Your Greeting</label>
										<label for="">
											<input type="text" class="form-control" name="recipient_name" value="{{$card_recipient_name}}"  onkeyup="sync_recipient_name()" maxlength="23"  id="recipient_name" placeholder="eg:- dear receiver name">
										</label>
									</div>
									<div class="form-group">
										<label for="">The Occasion</label>
										<label for="">

												<input type="text" class="form-control" name="recipient_occasion" value="{{$card_occasion}}" maxlength="50" onkeyup="sync_occasion()"  id="recipient_occasion" placeholder="eg:- happy birthday">
										</label>
									</div>
									<div class="form-group">
										<label for="">Your Special Message</label>
										<label for="">
											<textarea name="message" id="message"  class="form-control" onkeyup="sync_message(); countChar(this);" placeholder="Write a message"><?php echo $card_message; ?></textarea>
											<span class="tl-msg-text">
												<p>Maximum character 200</p>
												<p>Character left - <span id="countCharacter">200</span></p>
											</span>
										</label>
									</div>
									<div class="form-group">
										<label for="">Your Sign Off</label>
										<label for="">
											<input type="text" value="{{$card_sender_name}}" name="sender_name" maxlength="20" id="sender_name" onkeyup="sync_sender_name()" class="form-control" placeholder="eg:- love from">
										</label>
									</div>
					<div class="form-group">
					<label for="">From</label>
					<label for="">
					<input type="text" value="{{$card_sender_name1}}" name="sender_name1" maxlength="20" id="sender_name1" onkeyup="sync_sender_name1()" class="form-control" placeholder="eg:- Your name">
					</label>
					</div>
									
									{{-- <div class="form-fgfhh">
										<label for="" class="togglehover">
											<span>Want to let them know something is on it's way?</span>
											<span><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" title="To make sure your loved one knows you haven't forgotten them, simply enter in their email address and we'll let them know that something is on it's way from you and to watch-out for the Postman!"></i></span>
										</label>
										<label for="">
											<input type="text" name="email" id="email" class="form-control" placeholder="Enter Recipient Email ID">
										</label>
									</div> --}}
									<div class="form-group">
									<div id="errormsg" style="font-size:14px;text-align: center;"></div>
									<div class="overlay" style="display:none;">
										<div class="overlay" style="display:none;">
										<i class="fa fa-refresh fa-spin"></i>
										</div>
						     	    </div>
						     	    </div>
								
									<div class="form-group">
										<label for="">
										{{-- <a href="{{ url('payment_mode') }}" class="addcart-btn hvr-sweep-to-right">Add to Cart</a> --}}
										<button type="submit"  class="addcart-btn hvr-sweep-to-right">{{$buttontext}}</button>
											
										</label>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


				<div class="col-sm-6 col-md-6 col-xs-12 col-md-pull-6 ">
					<div class="tl-template">

						<!-- defult-temp -->
						<div class="defult-temp" id="template-0">
							<div class="defult-temp-logo">
								<img src="{{url('/public')}}/frontend/img/logo.png" alt="" class="img-responsive">
							</div>
						</div>
						<!-- end -->

						<div class="tl-template-1" id="template-1" style="display:none;">
							<div class="tl-template-content">
								<div class="tl-template-form">
									<form action="">
										<div class="form-group">
											<div class="tl-dear">
												<label for=""></label>
												<label for=""><input type="text" id="ref_recipient_name" value="{{$card_recipient_name}}" class="form-control"></label>
											</div>
										</div>

										<div class="form-group">
											<label for="">
												<input type="text" id="ref_select_occasion" value="{{$card_occasion}}"class="form-control">
											</label>
										</div>
										<div class="form-group">
											<label for="">
													<textarea name="" id="ref_message" class="form-control"><?php echo $card_message; ?></textarea>
												</label>
										</div>
										

										<div class="form-group tl-from">
											<label for=""></label>  
											<label for="">
												<input type="text" value="{{$card_sender_name}}" id="ref_sender_name"   class="form-control">
											</label>
										</div>

										<div class="form-group tl-from">
											<label for=""></label>  
											<label for="">
												<input type="text" value="{{$card_sender_name1}}" id="ref_sender_name_new"   class="form-control">
											</label>
										</div>

										<div class="tl-template-form-logo">
											<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="tl-template-1 tl-template-2" id="template-2" style="display:none;">
							<div class="tl-template-content">
								<div class="tl-template-form">
									<form action="">
										<div class="form-group">
											<div class="tl-dear">
												<label for=""></label>
												<label for=""><input type="text" id="ref_recipient_name2" value="{{$card_recipient_name}}" class="form-control"></label>
											</div>
										</div>

										<div class="form-group">
											<label for="">
												<input type="text" id="ref_select_occasion2" value="{{$card_occasion}}" class="form-control">
											</label>
										</div>
										<div class="form-group">
											<label for="">
												<textarea name="" id="ref_message2" class="form-control"><?php echo $card_message; ?></textarea>
											</label>
										</div>
										
										
										<div class="form-group tl-from">
											<label for=""></label>
											<label for="">
												<input type="text" id="ref_sender_name2" value="{{$card_sender_name}}" class="form-control">
											</label>
										</div>

										<div class="form-group tl-from">
											<label for=""></label>
											<label for="">
												<input type="text" id="ref_sender_name_new2" value="{{$card_sender_name1}}" class="form-control">
											</label>
										</div>

										<div class="tl-template-form-logo">
											<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="tl-template-1 tl-template-3" id="template-3" style="display:none;">
							<div class="tl-template-content">
								<div class="tl-template-form">
									<form action="">
										<div class="form-group">
											<div class="tl-dear">
												<label for=""></label>
												<label for=""><input type="text" id="ref_recipient_name3" value="{{$card_recipient_name}}" class="form-control"></label>
											</div>
										</div>

										<div class="form-group">
											<label for="">
												<input type="text" id="ref_select_occasion3" value="{{$card_occasion}}" class="form-control">
											</label>
										</div>
										<div class="form-group">
											<label for="">
												<textarea name="" id="ref_message3" class="form-control"><?php echo $card_message; ?></textarea>
											</label>
										</div>
										
										
										<div class="form-group tl-from">
											<label for=""></label>
											<label for="">
												<input type="text" id="ref_sender_name3" value="{{$card_sender_name}}" class="form-control">
											</label>
										</div>

										<div class="form-group tl-from">
											<label for=""></label>
											<label for="">
												<input type="text" id="ref_sender_name_new3" value="{{$card_sender_name1}}" class="form-control">
											</label>
										</div>

										<div class="tl-template-form-logo">
											<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="tl-view-template">
						<button data-toggle="modal" id="change_template" class="addcart-btn hvr-sweep-to-right" data-target="#template1" style="display:none">View your personalised card</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- template-start -->


<div class="modal fade templatemodal" id="template1" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <div class="modal-body">
	      <div class="template">
			<div class="title"></div>
			<div class="subtitle" id="card1_reciepnt_name">{{$card_recipient_name}}</div>

			<div class="slogtitle" id="card1_occasion">{{$card_occasion}}</div>

			<div class="article" id="card1_message">
				<?php echo $card_message; ?>
			</div>

			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card1_sender_name">{{$card_sender_name}}</div>
			</div>
			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card1_sender_name1">{{$card_sender_name1}}</div>
			</div>
			<div class="foot-logo">
				<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
			</div>
		</div>
	    </div>
	  </div>
	  
	</div>
</div>


<div class="modal fade templatemodal" id="template3" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <div class="modal-body">
	      <div class="template template_2">
			<div class="title"></div>
			<div class="subtitle" id="card3_reciepnt_name">{{$card_recipient_name}}</div>

			<div class="slogtitle" id="card3_occasion">{{$card_occasion}}</div>

			<div class="article" id="card3_message">
				<?php echo $card_message; ?>
			</div>

			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card3_sender_name">{{$card_sender_name}}</div>
			</div>
			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card3_sender_name3">{{$card_sender_name1}}</div>
			</div>
			<div class="foot-logo">
				<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
			</div>
		</div>
	    </div>
	   </div>
	      
	</div>
</div>


<div class="modal fade templatemodal" id="template2" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	   <!--    <h4 class="modal-title">Modal Header</h4> -->
	    </div>
	    <div class="modal-body">
	      <div class="template template_3">
			<div class="title"></div>
			<div class="subtitle" id="card2_reciepnt_name">{{$card_recipient_name}}</div>

			<div class="slogtitle" id="card2_occasion">{{$card_occasion}}</div>

			<div class="article" id="card2_message">
				<?php echo $card_message; ?>
			</div>

			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card2_sender_name">{{$card_sender_name}}</div>
			</div>
			<div class="from">
				<div class="from-title"></div>
				<div class="from-name" id="card2_sender_name2">{{$card_sender_name1}}</div>
			</div>
			<div class="foot-logo">
				<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive">
			</div>
		</div>
	    </div>
	  </div>
	  
	</div>
</div>


<!-- template-end -->



@include('frontend.common.footer')

   <?php
 		if($template_id!=''){
   ?>
		<script type="text/javascript">
        	
        	var template_id = '{{$template_id}}';
			var change_template = document.getElementById('change_template');
			change_template.dataset.target = "#template"+template_id;

            if(template_id==1){
            	$("#template-1").css("display","block");   
            	$("#template-2").css("display","none");
            	$("#template-3").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");   
            	var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.add("active");  

			     var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.remove("active");

			    var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.remove("active");
            }
           else if(template_id==2){
            	$("#template-2").css("display","block");
            	$("#template-1").css("display","none");
            	$("#template-3").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");
            	var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.add("active"); 

			    var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.remove("active");

			    var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.remove("active");
            }else if(template_id==3){
            	$("#template-3").css("display","block");
            	$("#template-2").css("display","none");
            	$("#template-1").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");
            	var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.add("active"); 

 				var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.remove("active");

			    var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.remove("active");
            }
        </script>
   <?php
      }
   ?>

<script type="text/javascript">

  var button_value = '{{$template_id}}';

	  function mybtn(id){
	  	
			
			var viewer = new ViewBigimg();
			var imgTag = $('.tl-temp'+id+' img').attr('src');
            viewer.show(imgTag);
		}


 function selecttemplate(id,btn_val){
			button_value = btn_val;
			var change_template = document.getElementById('change_template');
			change_template.dataset.target = "#template"+id;

            if(id==1){
            	$("#template-1").css("display","block");   
            	$("#template-2").css("display","none");
            	$("#template-3").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");   
            	var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.add("active");  

			     var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.remove("active");

			    var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.remove("active");
            }
           else if(id==2){
            	$("#template-2").css("display","block");
            	$("#template-1").css("display","none");
            	$("#template-3").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");
            	var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.add("active"); 

			    var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.remove("active");

			    var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.remove("active");
            }else if(id==3){
            	$("#template-3").css("display","block");
            	$("#template-2").css("display","none");
            	$("#template-1").css("display","none");
            	$("#template-0").css("display","none");
            	$("#change_template").css("display","block");
            	var activetem3 = document.getElementById('activetem3');
			    activetem3.classList.add("active"); 

 				var activetem1 = document.getElementById('activetem1');
			    activetem1.classList.remove("active");

			    var activetem2 = document.getElementById('activetem2');
			    activetem2.classList.remove("active");
            }

		}



   function maketreat_personal(){  
	  

	var productid = document.getElementById("productid").value.trim();
	var unique_cart_id1 = document.getElementById("unique_cart_id1").value.trim();
	var recipient_name = document.getElementById("recipient_name").value.trim();
	var _token = $('input[name=_token]').val();
	var recipient_occasion = document.getElementById("recipient_occasion").value.trim();
	var message = document.getElementById("message").value.trim();
	var sender_name = document.getElementById("sender_name").value.trim();
	var sender_name1 = document.getElementById("sender_name1").value.trim();
	
	 if(button_value=="")
			{
		
				document.getElementById("errormsg").style.color = "#ff0000";
        document.getElementById("errormsg").innerHTML="Please select a template." ; 
			  return false;
			}
			else
			{
			  document.getElementById("errormsg").innerHTML="" ; 
      
			}

		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

		  if(recipient_name=="")
			{
			  document.getElementById('recipient_name').style.border='1px solid #ff0000';
			  document.getElementById("recipient_name").focus();
			  $('#recipient_name').val('');
			$('#recipient_name').attr("placeholder", "Please enter recipient name");
			  $("#recipient_name").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("recipient_name").style.border = "";   
			}

			 if(recipient_occasion=="")
			{
			  document.getElementById('recipient_occasion').style.border='1px solid #ff0000';
			  document.getElementById("recipient_occasion").focus();
			  $('#recipient_occasion').val('');
			$('#recipient_occasion').attr("placeholder", "Please enter occasion");
			  $("#recipient_occasion").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("recipient_occasion").style.border = "";   
			}

		  if(message=="")
			{
			  document.getElementById('message').style.border='1px solid #ff0000';
			  document.getElementById("message").focus();
			  $('#message').val('');
			$('#message').attr("placeholder", "Please enter your message");
			  $("#message").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("message").style.border = "";   
			}


		  if(sender_name=="")
			{
			  document.getElementById('sender_name').style.border='1px solid #ff0000';
			  document.getElementById("sender_name").focus();
			  $('#sender_name').val('');
			$('#sender_name').attr("placeholder", "Please enter sender name");
			  $("#sender_name").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("sender_name").style.border = "";   
			}

			if(sender_name1=="")
			{
			  document.getElementById('sender_name1').style.border='1px solid #ff0000';
			  document.getElementById("sender_name1").focus();
			  $('#sender_name1').val('');
			$('#sender_name1').attr("placeholder", "Please enter sender name");
			  $("#sender_name1").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("sender_name1").style.border = "";   
			}
		

		
 
	   $(".overlay").css("display",'block');      
   	var form = new FormData();
		   form.append('button_value', button_value);
		   form.append('productid', productid);
		   form.append('unique_cart_id1', unique_cart_id1);
		   form.append('recipient_name', recipient_name);
		   form.append('_token', _token);
		   form.append('recipient_occasion', recipient_occasion);
		   form.append('message', message);
		   form.append('sender_name', sender_name);
		   form.append('sender_name1', sender_name1);
		   
		  
			 $.ajax({    
		type: 'POST',
		url: "{{url('/store_make_treat_personal1')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
	
		  
			console.log(response); // return false;
		  $(".overlay").css("display",'none');  
		    var status=response.status;
            var msg=response.msg;      
		  var cart_uniqueid = response.cart_uniqueid;
		  if(status=='200')
		  {
				var path = '<?php echo url('/review_treat'); ?>';
			//	alert(path); return false;
				window.location = path;
		  }
		  else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
      }
		
		}
	
		 });
		 return false;

}

	function sync_recipient_name(){
		
		var sync_rec = document.getElementById("recipient_name");
		var sync_ref = document.getElementById("ref_recipient_name");
		var sync_ref2 = document.getElementById("ref_recipient_name2");
		var sync_ref3 = document.getElementById("ref_recipient_name3");
		sync_ref.value = sync_rec.value;   
		sync_ref2.value = sync_rec.value;   
		sync_ref3.value = sync_rec.value;   
		document.getElementById("card1_reciepnt_name").innerHTML=sync_rec.value;
		document.getElementById("card2_reciepnt_name").innerHTML=sync_rec.value;
		document.getElementById("card3_reciepnt_name").innerHTML=sync_rec.value;

	}

	function sync_occasion(){
		
		var sync_rec = document.getElementById("recipient_occasion");
		var sync_ref = document.getElementById("ref_select_occasion");
		var sync_ref2 = document.getElementById("ref_select_occasion2");
		var sync_ref3 = document.getElementById("ref_select_occasion3");
		sync_ref.value = sync_rec.value;   
		sync_ref2.value = sync_rec.value;   
		sync_ref3.value = sync_rec.value;   
		
		document.getElementById("card1_occasion").innerHTML=sync_rec.value;
		document.getElementById("card2_occasion").innerHTML=sync_rec.value;
		document.getElementById("card3_occasion").innerHTML=sync_rec.value;

	}
		
	function sync_sender_name(){     
		
		var sync_rec = document.getElementById("sender_name");
		var sync_ref = document.getElementById("ref_sender_name");
		var sync_ref2 = document.getElementById("ref_sender_name2");
		var sync_ref3 = document.getElementById("ref_sender_name3");
		sync_ref.value = sync_rec.value;
		sync_ref2.value = sync_rec.value;
		sync_ref3.value = sync_rec.value;
		document.getElementById("card1_sender_name").innerHTML=sync_rec.value;
		document.getElementById("card2_sender_name").innerHTML=sync_rec.value;
		document.getElementById("card3_sender_name").innerHTML=sync_rec.value;
	
	}

	function sync_sender_name1(){     
		
		var sync_rec = document.getElementById("sender_name1");
		var sync_ref = document.getElementById("ref_sender_name_new");
		var sync_ref2 = document.getElementById("ref_sender_name_new2");
		var sync_ref3 = document.getElementById("ref_sender_name_new3");
		sync_ref.value = sync_rec.value;
		sync_ref2.value = sync_rec.value;
		sync_ref3.value = sync_rec.value;
		document.getElementById("card1_sender_name1").innerHTML=sync_rec.value;
		document.getElementById("card2_sender_name2").innerHTML=sync_rec.value;
		document.getElementById("card3_sender_name3").innerHTML=sync_rec.value;
	
	}    
	
	// function myNewFunction(sel) {
	// 	var sync_rec = sel.options[sel.selectedIndex].text;
	// 	var sync_ref = document.getElementById("ref_select_occasion");
	// 	var sync_ref2 = document.getElementById("ref_select_occasion2");
	// 	var sync_ref3 = document.getElementById("ref_select_occasion3");
	// 	sync_ref.value = sync_rec;
	// 	sync_ref2.value = sync_rec;
	// 	sync_ref3.value = sync_rec;
	// 	document.getElementById("card1_occasion").innerHTML=sync_rec;
	// 	document.getElementById("card2_occasion").innerHTML=sync_rec;
	// 	document.getElementById("card3_occasion").innerHTML=sync_rec;
    //  } 
	 
	 function sync_message() {
		var sync_rec = document.getElementById("message");
		var sync_ref = document.getElementById("ref_message");
		var sync_ref2 = document.getElementById("ref_message2");
		var sync_ref3 = document.getElementById("ref_message3");
		//sync_ref.value = sync_rec.value;
		document.getElementById("ref_message").innerHTML=sync_rec.value;
		sync_ref2.value = sync_rec.value;
		sync_ref3.value = sync_rec.value;
		document.getElementById("card1_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");

		document.getElementById("card2_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");
		document.getElementById("card3_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");



     } 
	 
	function countChar(val){
		var len = val.value.length;
		  if(len>200){
				val.value = val.value.substring(0, 200);
				var sync_rec = document.getElementById("message");
				var sync_ref = document.getElementById("ref_message");
				var sync_ref2 = document.getElementById("ref_message2");
				var sync_ref3 = document.getElementById("ref_message3");
				//sync_ref.value = sync_rec.value;
				document.getElementById("ref_message").innerHTML=sync_rec.value;
				sync_ref2.value = sync_rec.value;
				sync_ref3.value = sync_rec.value;
				document.getElementById("card1_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");

				document.getElementById("card2_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");
				document.getElementById("card3_message").innerHTML=sync_rec.value.replace(/\n/g, "<br />");
					}else{
						$('#countCharacter').text(200 - len);
					}
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

</script>

 @endsection

