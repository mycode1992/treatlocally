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
					<div class="tl-account-right">
						<div class="tl-profile-headingflex">
							<div class="tl-account-right-title">My Profile</div>
							<div class="tl-profile-editbtn">
								<a href="javascript:void(0)" onclick="return editable()">Edit</a>
							</div>
						</div>

						<div class="tl-account-right-form">
							<form action="#" onsubmit="return edit_profile();">
									<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
									<input type="hidden" name="user_id" id="user_id" value="{{$data[0]['userid']}}">
									<div class="form-flex-box">
									<div class="form-group">
										<label for="">First Name</label>
										<label for="">
											<input type="text" readonly  value="{{$data[0]['tl_userdetail_firstname']}}" id="first_name" name="first_name" onkeypress="return isChar(event)" class="form-control removeread">
										</label>
										</div>
										<div class="form-group">
										<label for="">Last Name</label>
										<label for="">
											<input type="text" readonly value="{{$data[0]['tl_userdetail_lastname']}}" id="last_name" name="last_name" onkeypress="return isChar(event)" class="form-control removeread">
										     
										</label>
										</div>
									</div>

									<div class="form-flex-box">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-md-6 col-xs-12">
													<label for="">Email Address</label>
													<label for="">
														<input type="text" value="{{$data[0]['email']}}" readonly id="email" name="email" class="form-control removeread">
													</label>
												</div>
											</div>
										</div>
									</div>

									<div class="form-flex-box">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-md-6 col-xs-12">
													<label for=""><a data-toggle="modal" data-target="#changepass" href="#">Change Password </a></span></label>
												</div>
											</div>
										</div>
									</div>
									
									<div class="form-flex-box">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-md-6 col-xs-12">
													<label for="">Phone Number</label>
													<label for="">
														<input type="text" value="{{$data[0]['tl_userdetail_phoneno']}}" readonly id="phoneno"  maxlength="15" onkeypress="return isNumberKey(event)" name="phoneno" class="form-control removeread">
													</label>
												</div>
											</div>
										</div>	
									</div>

									<div class="form-flex-box">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-md-6 col-xs-12">
													<label for="">Post Code</label>
													<label for="">
														<input type="text" value="{{$data[0]['tl_userdetail_postcode']}}" readonly id="post_code" maxlength="10" onkeypress="return isNumberKey(event)" name="post_code" class="form-control removeread">
													</label>
												</div>
											</div>
										</div>	
									</div>

									<div class="form-flex-box">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12 col-md-12 col-xs-12">
													<label for="">Address</label>
													<label for="">
															<textarea name="address" id="address" readonly class="removeread form-control" rows="5">{{$data[0]['tl_userdetail_address']}}</textarea>
													
													</label>
												</div>
											</div>
										</div>	
									</div>

									<div id="errormsg" style="font-size: 15px;"></div>
									<div class="overlay" style="position: relative !important;display:none;">
									  <i class="fa fa-refresh fa-spin"></i>
									</div>

									<div class="form-group" id="save_button" style="display:none">
										<button  type="submit" class="hvr-sweep-to-right tl-savebtn">Save</button>
									</div>			
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



<!-- Modal -->
<div class="modal fade changepass" id="changepass" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <div class="tl-changepass-heading">
      	<img src="{{url('/public')}}/frontend/img/forgot_password_icon.png" alt="" class="img-responsive">
      	<p>Change Passowrd</p>
      </div>

      <form action="#" onsubmit="return change_password();">
      	<div class="form-group">
      		<label for="">Old Password</label>
      		<label for="">
      			<input type="password" class="form-control" id="old_password" name="old_password" placeholder="******">
      		</label>
      	</div>

      	<div class="form-group">
      		<label for="">New Password</label>
      		<label for="">
      			<input type="password" class="form-control" id="password" name="password" placeholder="******">
      		</label>
      	</div>

      	<div class="form-group">
      		<label for="">Confirm New password</label>
      		<label for="">
      			<input type="password" class="form-control" id="con_password" name="con_password" placeholder="******">
      		</label>
		  </div>
		  <div id="errormsg1" style="font-size: 15px;text-align: center;"></div>
			<div class="overlay1" style="position: relative !important;display:none;">
				<i class="fa fa-refresh fa-spin"></i>
			</div>
      	<div class="form-group">
      		<label for="">
      			<button type="submit" class="hvr-sweep-to-right">Change Password</button>
      		</label>
      	</div>

      </form>
    </div>
  </div>
  
</div>
</div>

<!-- about-end -->


</section>

<script type="text/javascript">
	function editable(){
		$('.removeread').removeAttr("readonly"); 
		 $('#save_button').css('display','block');
	}
	function edit_profile()
	{
		var first_name = document.getElementById("first_name").value.trim();
		var last_name =document.getElementById("last_name").value.trim();
		var email =document.getElementById("email").value.trim(); 
		var address =document.getElementById("address").value.trim();
		
		var user_id =document.getElementById("user_id").value.trim();
		var phoneno =document.getElementById("phoneno").value.trim();
		var post_code =document.getElementById("post_code").value.trim();
		var _token = $('input[name=_token]').val();
	    var strUserEml=email.toLowerCase();
		
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	
		  if(first_name=="")
			{
			  document.getElementById('first_name').style.border='1px solid #ff0000';
			  document.getElementById("first_name").focus();
			  $('#first_name').val('');
			$('#first_name').attr("placeholder", "Please enter your first name");
			  $("#first_name").addClass( "errors" );
			  return false;
			}
		  else if (first_name.length<=2 || first_name.length>=51) 
			{   
				document.getElementById('first_name').style.border='1px solid #ff0000';
				document.getElementById("first_name").focus();
				$('#first_name').val('');
				$('#first_name').attr("placeholder", "Name must be 2-50 characters");
				$("#first_name").addClass( "errors" );
				return false;
			}
			else
			{
			  document.getElementById("first_name").style.border = "";   
			}
	
			if(last_name=="")
			{
			  document.getElementById('last_name').style.border='1px solid #ff0000';
			  document.getElementById("last_name").focus();
			  $('#last_name').val('');
			$('#last_name').attr("placeholder", "Please enter your last name");
			  $("#last_name").addClass( "errors" );
			  return false;
			}
		  else if (last_name.length<=2 || last_name.length>=51) 
			{   
				document.getElementById('last_name').style.border='1px solid #ff0000';
				document.getElementById("last_name").focus();
				$('#last_name').val('');
				$('#last_name').attr("placeholder", "Last name must be 2-50 characters");
				$("#last_name").addClass( "errors" );
				return false;
			}
			else
			{
			  document.getElementById("last_name").style.border = "";   
			}
	
			 // validation for email 
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

	   if(post_code=="")
	  {
	
		   document.getElementById('post_code').style.border='1px solid #ff0000';
		   document.getElementById("post_code").focus();
		   $('#post_code').attr("placeholder", "Please enter your post code");
		   $("#post_code").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("post_code").style.borderColor = "";     
		   
	  }

	   if(address=="")
	  {
	
		   document.getElementById('address').style.border='1px solid #ff0000';
		   document.getElementById("address").focus();
		   $('#address').attr("placeholder", "Please enter your address");
		   $("#address").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("address").style.borderColor = "";     
		   
	  }
	

	 
	   $(".overlay").css("display",'block');
	   //return false;
		var form = new FormData();
		   form.append('email', email);  
		   form.append('_token', _token);
		   form.append('phoneno', phoneno);
		   form.append('first_name', first_name);
		   form.append('last_name', last_name); 
		   form.append('address', address); 
		   form.append('post_code', post_code); 
		   form.append('user_id', user_id);

		$.ajax({    
		type: 'POST',
		url: "{{url('/edit_profile')}}",
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

	  function change_password()
{

    var old_password =document.getElementById("old_password").value.trim();
    var password =document.getElementById("password").value.trim();
    var con_password =document.getElementById("con_password").value.trim();
    var user_id =document.getElementById("user_id").value.trim();
	var _token = $('input[name=_token]').val();
  

  if(old_password=="")
	{
		document.getElementById('old_password').style.border='1px solid #ff0000';
		document.getElementById("old_password").focus();
		$('#old_password').val('');
     	$('#old_password').attr("placeholder", "Please enter old password");
		$("#old_password").addClass( "errors" );
		return false;
	}

	else
	{
		document.getElementById("old_password").style.border = "";   
	}


      if(password=="")
            {
              document.getElementById('password').style.border='1px solid #ff0000';
              document.getElementById("password").focus();
              $('#password').val('');
            $('#password').attr("placeholder", "Please enter  password");
              $("#password").addClass( "errors" );
              return false;
            }
          else if (password.length<=5 || password.length>=51) 
    {   
        document.getElementById('password').style.borderColor='#ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Password Must Be Between 6-50 Char");
        $("#password").addClass( "errors" );
        return false;
    }
	else
	{
		document.getElementById("password").style.border = "";   
	}

	if(con_password=="")
	{
		document.getElementById('con_password').style.border='1px solid #ff0000';
		document.getElementById("con_password").focus();
		$('#con_password').val('');
	$('#con_password').attr("placeholder", "Please confirm password");
		$("#con_password").addClass( "errors" );
		return false;
	}

	else
	{
		document.getElementById("con_password").style.border = "";   
	}

	if(password != con_password){
		document.getElementById("errormsg1").style.color = "#ff0000";
		document.getElementById("errormsg1").innerHTML="Password does not match" ; 
		return false;
	}
	else
	{
		document.getElementById("errormsg1").style.color = "";
		document.getElementById("errormsg1").innerHTML="" ; 
	}
        

   $(".overlay1").css("display",'block');
  
    var form = new FormData();
       form.append('_token', _token);
       form.append('password', password);
       form.append('user_id', user_id);
       form.append('old_password', old_password);


 
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/changepassword')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {
        console.log(response);  //return false;
      $(".overlay1").css("display",'none');        
      
	  var status = response.status;       
		  var msg = response.msg;       
		  
		  if(status=='200')
		  {
			 document.getElementById("errormsg1").innerHTML=msg;
			 document.getElementById("errormsg1").style.color = "#278428";
			  setTimeout(function() { location.reload(true) }, 3000);
		  }
		  else if(status=='401')
		  {
			 document.getElementById("errormsg1").style.color = "#ff0000";
			 document.getElementById("errormsg1").innerHTML=msg;
		  }
    
    }

     });
     return false;
 
  }// end of function
	
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
	
		  function isNumberKey(evt)
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
	
			 return true;
		  }
	</script>

 @endsection