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
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">My Account</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				
					@include('frontend.common.user_sidebar')
				
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
						<div class="tl-account-right-title">Support</div>
						<div class="tl-account-right-subtitle">If you'd like to get in touch about anything, please send us a message and we'll get back to you soon.</div>

						<div class="tl-account-right-form tl-support-form">
							<form action="#" onsubmit="return support();">
									<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
								<div class="form-flex-box">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label for="">Email<span class="required">*</span></label>
												<label for="">
													<input type="text" id="email" name="email" class="form-control" placeholder="Email">
												</label>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
											<label for="">Phone Number<span class="required">*</span></label>
											<label for="">
												<input type="text" id="phoneno"  maxlength="15" onkeypress="return isNumberKey(event)" name="phoneno" class="form-control" placeholder="Phone Number">
											</label>
											</div>
										</div>	

										<div class="col-sm-12 col-md-12 col-xs-12">
											<div class="form-group">
												<label for="">Message<span class="required">*</span></label>
												<label for="">
													<textarea name="support_message" id="support_message" placeholder="" class="form-control"></textarea>
												</label>
											</div>

											<div class="form-group">
													<div id="errormsg" style="font-size: 15px;"></div>
													<div class="overlay" style="position: relative !important;display:none;">
													  <i class="fa fa-refresh fa-spin"></i>
													</div>
												<label for="">
													<button type="submit" class="hvr-sweep-to-right">Send Message</button>
												</label>
											</div>
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


</section>

<!-- about-end -->

<script type="text/javascript">
	
	function support()
	{
		//alert('sdfsdg'); return false;
		var email =document.getElementById("email").value.trim();
		var support_message =document.getElementById("support_message").value.trim();
		var phoneno =document.getElementById("phoneno").value.trim();
		var _token = $('input[name=_token]').val();
	    var strUserEml=email.toLowerCase();
		
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	
		if(email=="")
	  {
	
		   document.getElementById('email').style.border='1px solid #ff0000';
		   document.getElementById("email").focus();
		   $('#email').attr("placeholder", "Please enter your E-mail Id");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else if(!filter.test(strUserEml)) 
	  {
	
		document.getElementById('email').style.border='1px solid #ff0000';
		   document.getElementById("email").focus();
		   $('#email').val('');
		   $('#email').attr("placeholder", "Invalid E-mail Id");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("email").style.borderColor = "";     
		   
	  }  

	   // validation for phone no
	   if(phoneno=="")
	  {
	
		   document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		   $('#phoneno').attr("placeholder", "Please enter your phone number");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	  }
	  else if(phoneno.length <=9 || phoneno.length >=16)
	 {
			document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		  $("#phoneno").val('');
		   $('#phoneno').attr("placeholder", "Phone no should be 10 digits");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	 }
	 else if(phoneno =='0000000000')
	 {
			document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		  $("#phoneno").val('');
		   $('#phoneno').attr("placeholder", "Please enter valid phone no");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	 }
	  else
	  {
		 document.getElementById("phoneno").style.borderColor = "";     
		   
	  }
	 
		  if(support_message=="")
			{
			  document.getElementById('support_message').style.border='1px solid #ff0000';
			  document.getElementById("support_message").focus();
			  $('#support_message').val('');
			$('#support_message').attr("placeholder", "Please enter message");
			  $("#support_message").addClass( "errors" );
			  return false;
			}
		
			else
			{
			  document.getElementById("support_message").style.border = "";   
			}
	
			
	
	   $(".overlay").css("display",'block');
	   //return false;
		var form = new FormData();
		   form.append('email', email);
		   form.append('_token', _token);
		   form.append('phoneno', phoneno);
		   form.append('support_message', support_message);
		  
		$.ajax({    
		type: 'POST',
		url: "{{url('/user/submit_support')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
			console.log(response); // return false;
		  $(".overlay").css("display",'none'); 
		  var status = response.status;       
		  var msg = response.msg;       
		  
		  if(status=='200')
		  {
			 document.getElementById("errormsg").innerHTML=msg;
			 document.getElementById("errormsg").style.color = "#278428";
			  setTimeout(function() { location.reload(true) }, 3000);
		  }
		  else if(status=='401')
		  {
			 document.getElementById("errormsg").style.color = "#ff0000";
			 document.getElementById("errormsg").innerHTML=msg;
		  }
		 
		 
		}
	
		 });
		 return false;
	 
	  }// end of function

	
		  function isNumberKey(evt)
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
	
			 return true;
		  }
	</script>

 @endsection