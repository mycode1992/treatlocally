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
	<!--[if lt IE 9]>
	<script src="js/html5.js"></script>
	<![endif]-->
	<!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->
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
</head>
<body>
		<?php
		$session_allmerchant  =Session::get('sessionmerchant');
		$session_alluser  =Session::get('sessionuser');
	
		if(  (isset($session_allmerchant) && count($session_allmerchant) > 0) ||  (isset($session_alluser) && count($session_alluser) > 0 )){ ?>
		<script>
				var loc = "<?php echo url('/'); ?>";
				window.location = loc;
		</script>
	<?php } ?>

<!-- signup-start -->

<section class="tl-form">
	<div class="container">
		<div class="tl-form-main-flexbox">
			<div class="tl-form-main">
				<div class="tl-form-close">
					<a href="{{ url('/') }}"><i class="fa fa-times" aria-hidden="true"></i></a>
				</div>
				<div class="tl-form-logoimg">
					<a href="{{ url('/') }}"><img src="{{url('/public')}}/frontend/img/logo.png" alt="" class="img-responsive"></a>
				</div>
				<div class="tl-form-title">Create your treatlocally account!</div>
				<form action="#" onsubmit="return adduser();">
						<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">First Name <span>*</span></label>
							<label for="">
								<input type="text" id="first_name" name="first_name" onkeypress="return isChar(event)" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Last Name <span>*</span></label>
							<label for="">
								<input type="text" id="last_name" name="last_name" onkeypress="return isChar(event)" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Email <span>*</span></label>
							<label for="">
								<input type="text" id="email" name="email" maxlength="60" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Phone no <span>*</span></label>
							<label for="">
								<input type="text" id="phoneno" maxlength="15" onkeypress="return isNumberKey(event)" name="phoneno" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Password <span>*</span></label>
							<label for="">
								<input type="password" id="password" name="password" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Confirm Password <span>*</span></label>
							<label for="">
								<input type="password" type="password" id="con_password" name="con_password" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 col-xs-12">
							<div class="form-group">
								<label for="" class="form-text">Address <span>*</span></label>
								<label for="">
									<textarea name="address" id="address" class="form-control"></textarea>
								</label>
							</div>
						</div>

					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="gigs-fltr-add">
								<input type="checkbox" name="iagree" id="iagree" value="1">
				            <label for="iagree"><span class="checkbox">By signing up, I agree with TreatLocally <a href="{{url('/terms&condition')}}" target="_blank" class="tl-termslink">Terms of Services</a></span></label>
				        </div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12 tl-errordiv">
							<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
							<div class="overlay" style="display:none;">
							<i class="fa fa-refresh fa-spin"></i>
							</div>
						</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<div class="tl-form-sb-btn">
								<button type="submit" class="hvr-sweep-to-right">Submit</button>
								<a href="{{ url('/') }}" class="hvr-sweep-to-right">Go To Home</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<p class="text-center tl-havean-account">Already have an account? <a href="{{ url('/user/account') }}">Sign in here</a></p>
					</div>

				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

	function adduser()
	{
		
		var first_name = document.getElementById("first_name").value.trim();
		var last_name =document.getElementById("last_name").value.trim();
		var email =document.getElementById("email").value.trim(); 
		var phoneno =document.getElementById("phoneno").value.trim();
		var password =document.getElementById("password").value.trim();
		var con_password =document.getElementById("con_password").value.trim();
		var address =document.getElementById("address").value.trim();
		var _token = $('input[name=_token]').val();
	    var iagree = document.getElementById("iagree");
		 var strUserEml=email.toLowerCase();

	
	  //  alert(user_id);
		
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
		   $('#email').attr("placeholder", "Please enter your email");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else if(!filter.test(strUserEml)) 
	  {
	
		document.getElementById('email').style.border='1px solid #ff0000';
		   document.getElementById("email").focus();
		   $('#email').val('');
		   $('#email').attr("placeholder", "Invalid email");
		   $("#email").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("email").style.borderColor = "";     
		   
	  }  

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
	  else
	  {
		 document.getElementById("phoneno").style.borderColor = "";     
		   
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
	
				if(password != con_password){
				  document.getElementById("errormsg").style.color = "#ff0000";
				  document.getElementById("errormsg").innerHTML="Password does not match" ; 
				  return false;
				}
				else
				{
				  document.getElementById("errormsg").style.color = "";
				  document.getElementById("errormsg").innerHTML="" ; 
				}

					if(iagree.checked==true)
					{
						iagree = 1;
						document.getElementById("errormsg").style.color = "";
				  document.getElementById("errormsg").innerHTML="" ; 
					}
					else
					{
						iagree = 0;
						document.getElementById("errormsg").style.color = "#ff0000";
				    document.getElementById("errormsg").innerHTML="Please accept our terms & conditions" ; 
				    return false;
					}
			

	   $(".overlay").css("display",'block');
	   //return false;
		var form = new FormData();
		   form.append('email', email);
		   form.append('_token', _token);
		   form.append('password', password);
		   form.append('first_name', first_name);
		   form.append('last_name', last_name); 
		   form.append('phoneno', phoneno);
		   form.append('address', address); 
		   form.append('iagree', iagree);
	  
		$.ajax({    
		type: 'POST',
		url: "{{url('/add_user')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
	
		  
			console.log(response); // return false;
		  $(".overlay").css("display",'none');  
		    var status=response.status;
            var msg=response.msg;      
		  
		  if(status=='200')
		  {
			 document.getElementById("errormsg").innerHTML=msg;
			 document.getElementById("errormsg").style.color = "#278428";
			  setTimeout(function() { location.reload(true) }, 3000);
		  }
		  else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
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

<!-- signup-end -->

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

</body>
</html>