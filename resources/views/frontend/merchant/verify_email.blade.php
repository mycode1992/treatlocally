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

       <section class="tl-form">
	<div class="container">
		<div class="tl-form-main-flexbox">
			<div class="tl-form-main">
					

				<div class="tl-form-logoimg">
					<a href="{{url('/')}}"><img src="{{url('/public')}}/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
				</div>
				
				  
                @if($token_status=='1')
                <div class="form-title form-title-extra green">Thanks!</div>
                  <p class="text-center">You have successfully verified your Email-ID!</p>
              @endif
              @if($token_status=='2')
              <div class="form-title form-title-extra red">Sorry!</div>
             <p class="text-center">Your Email-ID already verified!</p>
              @endif
              @if($token_status=='3')
              <div class="form-title form-title-extra red">Sorry!</div>
             <p class="text-center">Invalid url!</p>
              @endif
			
				
				
					
			</div>
		</div>
	</div>
</section>

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