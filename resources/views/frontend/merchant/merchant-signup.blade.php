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
</head>
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
				
				<div class="tl-form-title">Create your Merchant account!</div>
				<form action="#" onsubmit="return addmerchant();">
						<input type="hidden" name="_token" value="{{ csrf_token()}}"> 

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">First Name <span>*</span></label>
							<label for="">
								<input type="text" id="mer_first_name" name="mer_first_name" onkeypress="return isChar(event)" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Last Name <span>*</span></label>
							<label for="">
								<input type="text" id="mer_last_name" name="mer_last_name" onkeypress="return isChar(event)" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Email <span>*</span></label>
							<label for="">
								<input type="text" id="mer_email" name="mer_email" maxlength="60" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Phone no <span>*</span></label>
							<label for="">
								<input type="text" id="merphoneno" maxlength="15" onkeypress="return isNumberKey(event)" name="merphoneno" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Password <span>*</span></label>
							<label for="">
								<input type="password" id="merpassword" name="merpassword" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Confirm Password <span>*</span></label>
							<label for="">
								<input type="password" id="mercon_password" name="mercon_password" class="form-control">
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

					{{-- <div id="errorforpassword"></div> --}}

					<div class="col-sm-12 col-md-12 col-xs-12 tl-errordiv">
						<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
						<div class="overlay" style="display:none;">
						<i class="fa fa-refresh fa-spin"></i>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="gigs-fltr-add">
								<input type="checkbox" name="iagree" id="iagree" value="1">
						<label for="iagree"><span class="checkbox">By signing up, I agree with TreatLocally <a href="{{url('/terms&condition')}}" target="_blank" class="tl-termslink">Terms of Services</a></span></label>
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
						<p class="text-center tl-havean-account">Already have an account? <a href="{{ url('/merchant-signin') }}">Sign in here</a></p>
				        <p class="text-center tl-havean-account">Not a registered merchant? <a href="{{ url('/contact') }}">Contact us</a> Now!</p>
					</div>

					
				</form>
			</div>
		</div>
	</div>
</section>

<!-- signup-end -->

<script type="text/javascript">

	function addmerchant()
	{
		
		var mer_first_name = document.getElementById("mer_first_name").value.trim();
		var mer_last_name =document.getElementById("mer_last_name").value.trim();
		var mer_email =document.getElementById("mer_email").value.trim(); 
		var merpassword =document.getElementById("merpassword").value.trim();
		var mercon_password =document.getElementById("mercon_password").value.trim();
		var merphoneno =document.getElementById("merphoneno").value.trim();
		var address =document.getElementById("address").value.trim();
		var _token = $('input[name=_token]').val();
	    var iagree = document.getElementById("iagree");
		 var strUserEml=mer_email.toLowerCase();

	
	  //  alert(user_id);
		
		var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
	
		

		  if(mer_first_name=="")
			{
			  document.getElementById('mer_first_name').style.border='1px solid #ff0000';
			  document.getElementById("mer_first_name").focus();
			  $('#mer_first_name').val('');
			$('#mer_first_name').attr("placeholder", "Please enter your first name");
			  $("#mer_first_name").addClass( "errors" );
			  return false;
			}
		  else if (mer_first_name.length<=2 || mer_first_name.length>=51) 
			{   
				document.getElementById('mer_first_name').style.border='1px solid #ff0000';
				document.getElementById("mer_first_name").focus();
				$('#mer_first_name').val('');
				$('#mer_first_name').attr("placeholder", "Name must be 2-50 characters");
				$("#mer_first_name").addClass( "errors" );
				return false;
			}
			else
			{
			  document.getElementById("mer_first_name").style.border = "";   
			}
	
			if(mer_last_name=="")
			{
			  document.getElementById('mer_last_name').style.border='1px solid #ff0000';
			  document.getElementById("mer_last_name").focus();
			  $('#mer_last_name').val('');
			$('#mer_last_name').attr("placeholder", "Please enter your last name");
			  $("#mer_last_name").addClass( "errors" );
			  return false;
			}
		  else if (mer_last_name.length<=2 || mer_last_name.length>=51) 
			{   
				document.getElementById('mer_last_name').style.border='1px solid #ff0000';
				document.getElementById("mer_last_name").focus();
				$('#mer_last_name').val('');
				$('#mer_last_name').attr("placeholder", "Last name must be 2-50 characters");
				$("#mer_last_name").addClass( "errors" );
				return false;
			}
			else
			{
			  document.getElementById("mer_last_name").style.border = "";   
			}
	
			 // validation for email 
		 if(mer_email=="")
	  {
	
		   document.getElementById('mer_email').style.border='1px solid #ff0000';
		   document.getElementById("mer_email").focus();
		   $('#mer_email').attr("placeholder", "Please enter your email");
		   $("#mer_email").addClass( "errors" );
	
			return false;
	  }
	  else if(!filter.test(strUserEml)) 
	  {
	
		document.getElementById('mer_email').style.border='1px solid #ff0000';
		   document.getElementById("mer_email").focus();
		   $('#mer_email').val('');
		   $('#mer_email').attr("placeholder", "Invalid email");
		   $("#mer_email").addClass( "errors" );
	
			return false;
	  }
	  else
	  {
		 document.getElementById("mer_email").style.borderColor = "";     
		   
	  }  

	  // validation for phone no
	  if(merphoneno=="")
	  {
	
		   document.getElementById('merphoneno').style.border='1px solid #ff0000';
		   document.getElementById("merphoneno").focus();
		   $('#merphoneno').attr("placeholder", "Please enter your phone number");
		   $("#merphoneno").addClass( "errors" );
	
			return false;
	  }
	  else if(merphoneno.length <=9 || merphoneno.length >=16)
	 {
			document.getElementById('merphoneno').style.border='1px solid #ff0000';
		   document.getElementById("merphoneno").focus();
		  $("#merphoneno").val('');
		   $('#merphoneno').attr("placeholder", "Phone no should be 10 digits");
		   $("#merphoneno").addClass( "errors" );
	
			return false;
	 }
	  else
	  {
		 document.getElementById("merphoneno").style.borderColor = "";     
		   
	  }
	 
	  
		  if(merpassword=="")
				{
				  document.getElementById('merpassword').style.border='1px solid #ff0000';
				  document.getElementById("merpassword").focus();
				  $('#merpassword').val('');
				$('#merpassword').attr("placeholder", "Please enter  password");
				  $("#merpassword").addClass( "errors" );
				  return false;
				}
				else if (merpassword.length<=5 || merpassword.length>=51) 
    {   
        document.getElementById('merpassword').style.borderColor='#ff0000';
        document.getElementById("merpassword").focus();
        $('#merpassword').val('');
        $('#merpassword').attr("placeholder", "Password Must Be Between 6-50 Char");
        $("#merpassword").addClass( "errors" );
        return false;
    }
				else
				{
				  document.getElementById("merpassword").style.border = "";   
				}
	
				if(mercon_password=="")
				{
				  document.getElementById('mercon_password').style.border='1px solid #ff0000';
				  document.getElementById("mercon_password").focus();
				  $('#mercon_password').val('');
				$('#mercon_password').attr("placeholder", "Please confirm password");
				  $("#mercon_password").addClass( "errors" );
				  return false;
				}
			
				else
				{
				  document.getElementById("mercon_password").style.border = "";   
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
	
				if(merpassword != mercon_password){
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
		   form.append('mer_email', mer_email);
		   form.append('_token', _token);
		   form.append('merpassword', merpassword);
		   form.append('merphoneno', merphoneno);
		   form.append('mer_first_name', mer_first_name);
		   form.append('mer_last_name', mer_last_name);  
		   form.append('address', address);  
		   form.append('iagree', iagree);
	  
		$.ajax({    
		type: 'POST',
		url: "{{url('/add_merchant')}}",
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