<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Treat Locally - Thoughtful Treats from Local Streets</title>
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="icon" href="{{url('/public')}}/frontend/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/style.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/animate.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/bootstrap-datepicker.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/slick.css">
	<link rel="stylesheet" type="text/css" href="{{url('/')}}/public/frontend/css/slick-theme.css">
	<link rel="stylesheet" href="{{url('/')}}/public/frontend/css/view-bigimg.css">
	<link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
	<meta name="google" content="notranslate">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144581137-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'UA-144581137-1');
	</script>

	<!--[if lt IE 9]>
		<script src="{{url('/')}}/public/frontend/js/html5.js"></script>
		<![endif]-->
		<!--[if lt IE 9]>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
	
</head>
<body>


<!--header code-->

 @include('frontend.common.header')


 @yield('sidebar')

 @yield('content')

 <!--Footer-->
 <?php  $segment_url = Request::segment(1); 
		if($segment_url != 'make_treat_personal'){
 ?>
 @include('frontend.common.footer')
 <?php }
 
 
 ?>
 <script src="{{url('/')}}/public/tl_admin/bower_components/ckeditor/ckeditor.js"></script>
 <script src="{{url('/')}}/public/tl_admin/bower_components/select2/dist/js/select2.full.min.js"></script>

 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
		  "language": {
		"lengthMenu": '<div> <select class="troopets_selectbox">'+
		  '<option value="10">10</option>'+
		  '<option value="20">20</option>'+
		  '<option value="30">30</option>'+
		  '<option value="40">40</option>'+
		  '<option value="50">50</option>'+
		  '<option value="60">60</option>'+
	
		  '<option value="-1">All</option>'+
		  '</select> <span class="record">Records Per Page </span></div>'
	  }
		});
		soTable = $('#example').DataTable();
	  $('#srch-term').keyup(function(){
			 soTable.search($(this).val()).draw() ;
	   });
	
	$('.something').click( function () {
	var ddval = $('.something option:selected').val();
	console.log(ddval);
	var oSettings = oTable.fnSettings();
	oSettings._iDisplayLength = ddval;
	oTable.fnDraw();
	});
	oTable = $('#example').dataTable();
	
	} );
	
	</script>

<script>
	$(document).ready(function() {
		$('#example1').DataTable({
		  "language": {
		"lengthMenu": '<div> <select class="troopets_selectbox">'+
		  '<option value="10">10</option>'+
		  '<option value="20">20</option>'+
		  '<option value="30">30</option>'+
		  '<option value="40">40</option>'+
		  '<option value="50">50</option>'+
		  '<option value="60">60</option>'+
	
		  '<option value="-1">All</option>'+
		  '</select> <span class="record">Records Per Page </span></div>'
	  }
		});
		soTable = $('#example1').DataTable();
	  $('#srch-term').keyup(function(){
			 soTable.search($(this).val()).draw() ;
	   });
	
	$('.something').click( function () {
	var ddval = $('.something option:selected').val();
	console.log(ddval);
	var oSettings = oTable.fnSettings();
	oSettings._iDisplayLength = ddval;
	oTable.fnDraw();
	});
	oTable = $('#example1').dataTable();
	
	} );
	
	</script>

 <script>
   $('.select2').select2();
   
   $(function(){
	    $('#treat_valid').datepicker();
	    minDate:new Date();
	});  

		$('input.chk').on('change', function() {
			$('input.chk').not(this).prop('checked', false);  
			var checkbox_val = $('.chk:checked').val(); 

			if(!checkbox_val){
				checkbox_val = '';
			}

			//console.log(checkbox_val); return false;
		
			var key = "filter_by";
			var url = window.location.href;
		//	$('input.chk').not(this).prop('checked', false);  
		   var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		   var separator = url.indexOf('?') !== -1 ? "&" : "?";
		   if (url.match(re)) {
				newurl = url.replace(re, '$1' + key + "=" + checkbox_val + '$2');
			}
			else {
				newurl = url + separator + key + "=" + checkbox_val;
			}
			window.location.href = newurl;

		
			
			
			
			
});



 </script>
  </body>
</html>

