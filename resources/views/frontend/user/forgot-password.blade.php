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
    $data = session()->all();
  //   print_r($data); 
     $data_key = array_keys($data); 
     //print_r($data_key); 
    // echo count($data_key); 
    if(count($data_key)>'3'){
    //  echo $data_key[3]; exit;
    $session_all=Session::get($data_key[3]);
        $userid = $session_all['userid'];
         $userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
                 
    }
    else {

      $session_all = false;
    }

   if($session_all != false){ ?>
    <script>
       console.log('sweta');
       var loc = "<?php echo url('/'); ?>";
       window.location = loc;
     </script>
    <?php } ?>
       <section class="tl-form">
	<div class="container">
		<div class="tl-form-main-flexbox">
			<div class="tl-form-main">
				<div class="tl-form-logoimg">
					<a href="{{url('/')}}"><img src="{{url('/public')}}/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
				</div>
				<div class="tl-form-title">forgot password</div>
				<p class="text-center">Enter your email below to retrieve your account password</p>
				<form action="" onsubmit="return forgotpassword();">
						{{ csrf_field() }}
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">email Address<span>*</span></label>
							<label for="">
								<input type="text" id="email" name="email" maxlength="60" class="form-control">
							</label>
						</div>
					</div>
					
					<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
					<div class="overlay" style="position: relative !important;display:none;">
				<i class="fa fa-refresh fa-spin"></i>
				</div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<div class="tl-form-sb-btn">
								<button type="submit" class="hvr-sweep-to-right">Submit</button>
								<a href="{{ url('/') }}" class="hvr-sweep-to-right">Cancel</a>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
    function forgotpassword()
    {
        var email =document.getElementById("email").value.trim();
       var _token = $('input[name=_token]').val();

        var strUserEml=email.toLowerCase();
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    
    
    if(email=="")
  {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').attr("placeholder", "Enter email");
       $("#email").addClass( "errors" );

        return false;
  }
    else if(!filter.test(strUserEml)) 
   {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').val('');
       $('#email').attr("placeholder", "Invalid E-mail ID");
       $("#email").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("email").style.border="";     
       
  }

  $(".overlay").css("display",'block');
    
    $.ajax({    
    type: 'POST',
    url: "{{url('/user/forgot_email')}}",
    data: {email:strUserEml,_token:_token},  
    success:function(response) 
    {
       
		$(".overlay").css("display",'none');
      console.log(response); //return false;
      
      var status=response.status;
      var msg=response.msg;
      if(status=='200')
      {
        //var path="{{url('/')}}";
        $("#email").removeClass( "errors" );
         $("#email").val('');
         document.getElementById("errormsg").innerHTML=msg;
         document.getElementById("errormsg").style.color = "#278428";
       //  setTimeout(function() { window.location=path; }, 3000);
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