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
				
				<div class="tl-form-title">Sign in to your merchant account!</div>
				<form onsubmit="return merchant_login();">
						<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Email <span>*</span></label>
							<label for="">
								<input type="text" id="email" name="email"  maxlength="60" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Password <span>*</span></label>
							<label for="">
								<input type="password" id="password" class="form-control">
							</label>
							<label for="" class="tl-forgot"><a href="{{ url('forgot-password') }}">Forgot Password?</a></label>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12 tl-errordiv">
						<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
						<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
						<div class="overlay" style="display:none;">
						<i class="fa fa-refresh fa-spin"></i>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<div class="tl-form-sb-btn">
								<button class="hvr-sweep-to-right">Sign in</button>
								<a href="{{ url('/') }}" class="hvr-sweep-to-right">Go To Home</a>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<p class="text-center tl-havean-account">Don't have an account? <a href="{{ url('merchant-signup') }}">Create Now</a></p>
				        <p class="text-center tl-havean-account">Not a registered merchant? <a href="{{ url('/contact') }}">Contact us</a> Now!</p>
					</div>

				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    function merchant_login()
    {
        document.getElementById("errormsg").innerHTML='';
		var _token = $('input[name=_token]').val();
        var email = document.getElementById("email").value.trim();   
        var strUserEml=email.toLowerCase();
        var password = document.getElementById("password").value.trim();
     

        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
       
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
//   console.log("test");
// return false;
  if(password=="")
  {

       document.getElementById('password').style.border='1px solid #ff0000';
       document.getElementById("password").focus();
       $('#password').attr("placeholder", "Please enter your password");
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
     document.getElementById("password").style.borderColor = "";     
       
  }

 $(".overlay").css("display",'block');
  
 var form = new FormData();
        form.append('email', strUserEml); 
        form.append('password', password);
        form.append('_token', _token);

    $.ajax({    
    type: 'POST',
    url: "{{url('/merchant/login')}}",
    data: form,
    cache: false,
    contentType: false,
    processData: false,
    success:function(response) 
    {   	 
      $(".overlay").css("display",'none');
       
       console.log(response);  //return false;
       var status=response.status;
      var msg=response.msg;
	  var path="{{url('/merchant/myprofile')}}";
      if(status=='200')
      {
		
        $("#email,#password").removeClass( "errors" );
         $("#email,#password").val('');
         document.getElementById("errormsg").innerHTML=msg;
         document.getElementById("errormsg").style.color = "#278428";

         setTimeout(function() { window.location.href=path; }, 1000);
      }
      else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=msg;
      }
    
    }

     });
     return false;






   //return false;
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