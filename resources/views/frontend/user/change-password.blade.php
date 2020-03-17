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
   <?php
   $segment =Request::segment(3);  
 if($segment==''){
   $segment='';
 }


  $sql_validtoken = DB::table('users')->select('remember_token')
                           ->where('remember_token',$segment)->get(); 
       $sql_validtoken = json_decode(json_encode($sql_validtoken), True);
             //  print_r($sql_validtoken);  exit;
$sql_expiretoken = DB::table('users')->select('token_status')
                                ->where([
                                    ['remember_token',$segment],
                                    ['token_status','1'],
                                    ['token_verify_status','0']
                                    ])->get();
   $sql_expiretoken = json_decode(json_encode($sql_expiretoken), True);
     //  print_r($sql_checktoken); exit;
 
?>

<body>

       <section class="tl-form">
	<div class="container">
		<div class="tl-form-main-flexbox">
			<div class="tl-form-main">
					

				<div class="tl-form-logoimg">
					<a href="{{url('/')}}"><img src="{{url('/public')}}/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
				</div>
				<div id="errorfortoken">
          <?php 
				      if(count($sql_validtoken)>0){ 
			 
				      if(count($sql_expiretoken)>0){ 
			       ?>
				<div class="tl-form-title">change password</div>
				<form method="POST" action="" onsubmit="return changepassword();">
					{{ csrf_field() }}
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Password <span>*</span></label>
							<label for="">
								<input type="password" id="password" name="password" class="form-control">
							</label>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<label for="" class="form-text">Confirm Password <span>*</span></label>
							<label for="">
								<input type="password" id="con_password" name="con_password" class="form-control">
							</label>
						</div>
					</div>
					<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
					<div class="col-sm-12 col-md-12 col-xs-12">
						<div class="form-group">
							<div class="tl-form-sb-btn">
								<button type="submit" class="hvr-sweep-to-right">Submit</button>
								<a href="{{ url('/') }}" class="hvr-sweep-to-right">Cancel</a>
							</div>
						</div>
					</div>

				</form>

				<?php }
				else{ ?>
					<div class="tl-form-title">
					   <h3>Sorry! Expired token.</h3>   
					</div>
			   <?php }  }
				else{ ?>
				  <div class="tl-form-title">
					  <h3>Sorry! Invalid token.</h3>
				 </div>
         <?php }
           ?>

					</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    function changepassword()
    {
        
       
        var password =document.getElementById("password").value.trim();
        var con_password =document.getElementById("con_password").value.trim();
        var _token = $('input[name=_token]').val();
		var segment = '<?php echo $segment; ?>';
      
       
    
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
     document.getElementById("password").style.border="";     
       
  }

   if(con_password=="")
  {

       document.getElementById('con_password').style.border='1px solid #ff0000';
       document.getElementById("con_password").focus();
       $('#con_password').attr("placeholder", "Please enter your confirm password");
       $("#con_password").addClass( "errors" );

        return false;
  }
    
  else
  {
     document.getElementById("con_password").style.border="";     
       
  }


if(password!=con_password){
    
    document.getElementById("errormsg").style.color = "#ff0000";
    document.getElementById("errormsg").innerHTML='Confirm password does not match' ;
     return false;
	
}
else{
    document.getElementById("errormsg").style.color = "";
    document.getElementById("errormsg").innerHTML='' ;
}

    
    $.ajax({    
    type: 'POST',
    url: "{{url('/user/change_password')}}",
	data: {password:password,con_password:con_password,_token:_token,segment:segment},
    success:function(response) 
    {
       

      console.log(response); //return false;
      
      var status=response.status;
      var msg=response.msg;
      if(status=='200')
      {
        var path="{{url('/')}}/user/account";
        $("#email").removeClass( "errors" );
         $("#email").val('');
         document.getElementById("errorfortoken").innerHTML=" <div class='tl-form-title'><h3>"+msg+"</h3></div>";
         document.getElementById("errorfortoken").style.color = "#278428";
         setTimeout(function() { 
          window.location=path; 

        }, 3000);
      }
      else if(status=='401')
      {
         document.getElementById("errorfortoken").style.color = "#ff0000";
         document.getElementById("errorfortoken").innerHTML="<div class='tl-form-title'><h3>"+msg+"</h3></div>";
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