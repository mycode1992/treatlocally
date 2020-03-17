	<!-- nav-start -->
	<?php 
	$session_allmerchant  =Session::get('sessionmerchant');
	$session_alluser  =Session::get('sessionuser');

	if(isset($session_allmerchant) && count($session_allmerchant) > 0)
	{
	$userid = $session_allmerchant['userid'];
	$userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
	} 
	else
	if(isset($session_alluser) && count($session_alluser) > 0)
	{
	$userid = $session_alluser['userid'];
	$userdata =  DB::table('users')->select('name')->where('userid',$userid)->get();
	}
	?>
	<section class="tl-nav">

	<?php
	$url = $_SERVER['REQUEST_URI'];
	if($url == '/')
	{
	?>
	<nav class="navbar navbar-fixed-top activebg">
	<?php
	}
	else
	{
	echo '<nav class="navbar navbar-fixed-top tl-navshadow">';
	}
	?>
	<div class="container">
	<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="{{url('/')}}">
	<img src="{{url('/public')}}/frontend/img/logo.png" alt="" class="img-responsive black_logo">
	<img src="{{url('/public')}}/frontend/img/logo_white.png" alt="" class="img-responsive white_logo">
	</a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">
	<ul class="nav navbar-nav navbar-right">   

	<li class="tl-cart dropdown keep-inside-clicks-open">
	<a href="javaScript:Void(0)" class="dropdown-toggle" data-toggle="dropdown">
	<img src="{{url('/public')}}/frontend/img/cart_icon_white.png" alt="" class="cartwhite_icon">
	<img src="{{url('/public')}}/frontend/img/cart.png" alt="" class="cartblack_icon">
	<?php 

	if(!empty($_SESSION["shopping_cart"]))
	{	

	$count_cart_item = count($_SESSION["shopping_cart"]);
	}
	else
	{
	$count_cart_item = '0';
	}

	?>
	<span id="cart_item"><?=$count_cart_item?></span>
	</a>
	<ul class="dropdown-menu">
	<li class="tl-treatnav-scroll">

	<div id="tom"> 
	<?php
	if(!empty($_SESSION["shopping_cart"]))
	{
	
	$num = 0;
	foreach($_SESSION["shopping_cart"] as $keys => $values)
	{  
	$num++;
	?>
	<div class="tl-navtreat" id="deleterow<?php echo $values["item_id"];?>">	
	<div class="tl-treatbox">
	<div class="tl-treat-modal">
	<div class="tl-treatbox-img">
	<img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{$values["item_image"]}}" alt="" class="img-responsive">
	</div>
	<div class="tl-treatbox-text">
	<div class="tl-treatbox-text-title"><?php echo $values["item_storename"]; ?></div>
	<div class="tl-treatbox-text-title"><?php echo $values["item_name"]; ?></div>
	<!-- <div class="tl-treatbox-text-sbtitle">
	<?php 
	//	$string = $values["item_description"];
	//	if (strlen($string) > 30) {
	//	 $stringCut = substr($string, 0, 30);
	//	 $endPoint = strrpos($stringCut, ' ');

	//	 $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
	//	 $string .= '...';
	//	 }
	// echo $string;
	// echo $values["item_description"]; ?>
	</div> -->
	<div class="tl-treatbox-text-price">£<?php echo $values["item_price"]; ?></div>
	</div>
	</div>
	<div class="tl-treatbox-text-close">
	<?php 
	if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){
	// echo 'sweta'; exit;
	$is_treat_personalise = DB::table('tbl_tl_card')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->select('card_id')->get();

	$is_add_edit_addr =  DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->get();

	if(count($is_treat_personalise)>0 || count($is_add_edit_addr)>0){  
	?>
	<a href="javascript:void(0)" onclick="remove_cart_item(<?php echo $values["item_id"].','.$num; ?>); deletecart_card_item1(<?php echo $values["item_id"]; ?>,'<?php echo  $_SESSION["cartuniqueid"]; ?>');" class="hvr-sweep-to-right"><i class="fa fa-times" aria-hidden="true"></i></a>
	<?php }else{ ?>
	<a href="javascript:void(0)" onclick="remove_cart_item(<?php echo $values["item_id"].','.$num; ?>)" class="hvr-sweep-to-right"><i class="fa fa-times" aria-hidden="true"></i></a>
	<?php }}else{ //echo 'sweta1'; exit; ?>
	<a href="javascript:void(0)" onclick="remove_cart_item(<?php echo $values["item_id"].','.$num; ?>)" class="hvr-sweep-to-right"><i class="fa fa-times" aria-hidden="true"></i></a>
	<?php } ?>
	</div>
	</div>

	</div>
	<?php 
		} 

		} // end cart not empty
	else
	{  ?>

	<div class="tl-treatbox-text-close tl-noitem text-center">
	Your cart is empty
	</div>
	<?php	}
	?>	 </div>
	<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
	<div class="tl-navtreat-amount">
	<div class="tl-treatnav-shopping text-center">
	<a href="{{url('/')}}">Continue Shopping</a>
	</div>
	</div>
	</li>
	<div id="addcart_maketreat_personal">
	<?php	if(!empty($_SESSION["shopping_cart"]))
	{	?>
	<li class="tl-treatnav-makethetreat">
	<a href="{{url('review_treat')}}" class="hvr-sweep-to-right">Go to Cart</a>
	</li>
	<?php } ?>

	</div>
	</ul>
	</li>

	<li>
	<a href="{{ url('/') }}" <?php if($url == '/about-us'){ echo "class='active'"; } ?> >Home</a>
	</li> 


	<?php if(isset($session_allmerchant) && count($session_allmerchant) > 0){ ?>
	<li class="dropdown dropdownlogout">
	<a href="javascript:void(0)">
	<span class="log-outimg">
	<img src="{{url('/public')}}/frontend/img/place_holder.png" alt="" class="img-responsive img-circle black-profile">
	<img src="{{url('/public')}}/frontend/img/user_light.png" alt="" class="img-responsive img-circle white-profile">
	<i class="fa fa-angle-down" aria-hidden="true"></i>
	</span>
	</a>
	<ul class="dropdown-menu dropdown-logout">
	<li class="tl-profilename"><?php echo ucfirst($userdata[0]->name); ?></li>
	<li><a href="{{url('/merchant/myprofile')}}">Dashboard</a></li>
	<li><a href="{{url('merchant/order_history')}}">View Order</a></li>
	<li class="tl-logout"><a href="{{url('/merchant/Logout')}}">Logout</a></li>
	</ul>
	<?php	} else 	

	if(isset($session_alluser) && count($session_alluser) > 0){ ?>
	<li class="dropdown dropdownlogout">
	<a href="javascript:void(0)">
	<span class="log-outimg">
	<img src="{{url('/public')}}/frontend/img/place_holder.png" alt="" class="img-responsive img-circle black-profile">
	<img src="{{url('/public')}}/frontend/img/user_light.png" alt="" class="img-responsive img-circle white-profile">
	<i class="fa fa-angle-down" aria-hidden="true"></i>
	</span>
	</a>
	<ul class="dropdown-menu dropdown-logout">
	<li class="tl-profilename"><?php echo ucfirst($userdata[0]->name); ?></li>
	<li><a href="{{url('/user/myprofile')}}">Dashboard</a></li>
	<li><a href="{{url('user/treathistory')}}">View Order</a></li>
	<li class="tl-logout"><a href="{{url('/user/Logout')}}">Logout</a></li>
	</ul>

	<?php } else {	?>
	<li><a href="{{ url('/user/account') }}" <?php if($url == '/user/account'){ echo "class='active'"; } ?> >My Account</a></li>
	<li><a href="{{ url('merchant-signin') }}" <?php if($url == '/merchant-signin'){ echo "class='active'"; } ?> >Merchant log in</a></li>
	<?php } ?>
	</li>

	<li>
	<a href="{{ url('blog') }}" <?php $segment1 =  Request::segment(1);  if($segment1 == 'blog' || $segment1 == 'blog-detail'){ echo "class='active'"; } ?> >Blog</a>
	</li>	

	<li class="end"><a href="{{ url('/contact') }}" <?php if($url == '/contact'){ echo "class='active'"; } ?> >Contact</a></li>





	</ul>
	</div><!--/.nav-collapse -->
	</div>
	</nav>
	</section>




	<script>

	function deletecart_card_item1(productid,cartuniqueid)
	{

	$.ajax({
	headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
	method: "POST",
	url:"{{url('/deletecart_card_item')}}",
	data: { productid:productid,cartuniqueid:cartuniqueid }

	})
	.done(function( msg ) {

	console.log(msg); return false;
	document.getElementById("cart_item").innerText=count_cart_item;
	$("#deleterow"+id).css("display","none");
	$(".deleterow1"+id).css("display","none");
	if(count_cart_item=='0'){
	$('#tom').html('	<div class="tl-treatbox-text-close tl-noitem text-center">	Your cart is empty	</div>');
	$('#tom1').html('<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');
	$('#addcart_maketreat_personal').html('');
	}
	});
	}

	function remove_cart_item(id,num)
	{
	var _token = $('input[name=_token]').val(); 
	$.ajax({
	method: "POST",
	url:"{{url('/remove_cart_item')}}",
	data: { itemid:id,_token:_token }

	})
	.done(function( msg ) {
	var count_cart_item = msg.count_cart_item;
	console.log(msg); //return false;


	document.getElementById("cart_item").innerText=count_cart_item;
	$("#deleterow"+id).css("display","none");
	$(".deleterow1"+id).css("display","none");

	if(num > '0'){
	var num2 = num+1;
	var divsToHide = document.getElementsByClassName("title"+num2); //divsToHide is an array
	for(var i = 0; i < divsToHide.length; i++){
	divsToHide[i].style.visibility = "show"; // or
	divsToHide[i].style.display = "block"; // depending on what you're doing
	}


	}


	if(count_cart_item=='0'){
	var review_treat1 = document.getElementById('review_treat1');
	review_treat1.classList.remove("active");

	var divsToHide = document.getElementsByClassName("deliver-treat-msg"); //divsToHide is an array
	for(var i = 0; i < divsToHide.length; i++){
	divsToHide[i].style.visibility = "hidden"; // or
	divsToHide[i].style.display = "none"; // depending on what you're doing
	}

	$('#main_container').html('	<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');

	$('#tom').html('<div class="tl-treatbox-text-close tl-noitem text-center">	Your cart is empty	</div>');
	$('#tom1').html('<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');
	$('#addcart_maketreat_personal').html('');
	}

	if(count_cart_item == '1'){

	var divsToHide = document.getElementsByClassName("title"); //divsToHide is an array
	for(var i = 0; i < divsToHide.length; i++){
	divsToHide[i].style.visibility = "show"; // or
	divsToHide[i].style.display = "block"; // depending on what you're doing
	}


	}


	});
	}
	</script>

	<!-- nav-end -->
