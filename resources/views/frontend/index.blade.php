@extends('frontend.layouts.frontlayout')

@section('content')
<!-- banner-content-start -->
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


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD83Rvhlxn-kCjEW9pR0Q-rza2DYb_BuUY&libraries=places"></script>

<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">

<section class="tl-banner">
<div class="tl-parallax jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url({{url('/public')}}/tl_admin/upload/banner/{{$data['banner'][0]['tl_banner_image']}});"></div>

<!-- caption-form-start -->

<div class="caption-form">
	<div class="caption-form-title wow fadeIn" data-wow-delay="0.3s">{{$data['banner'][0]['tl_banner_title']}}</div>
	<form action="{{ url('search') }}" method="GET" class="wow fadeIn"  id="searchForm" data-wow-delay="0.6s">
	    <input type="hidden" value="" name="select_relation" id="select_relation" >
		<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
		<div class="tl-selectdropdown" id="whour">
			<div class="search-dropdwon">
					<ul>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" id="ref_rel_name" data-toggle="dropdown">Who are you treating? <b class="caret"></b></a>
							<ul class="dropdown-menu nav-stacked" id="accordion1">
				<?php 
				$relation = DB::table('_relation')->where('parent_cat_id','=','0')->where('status','1')->select('id','name','parent_cat_id')->get();
				?>
				 @foreach($relation AS $rel_val)

				<?php $has_subcat = DB::table('_relation')->where('parent_cat_id','=',$rel_val->id)->where('status','1')->select('id')->get();
					if(count($has_subcat)>0){
				?>
				  
					<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$rel_val->name?></a>
					<ul class="dropdown-menu">
						<?php 
						$relation1 = DB::table('_relation')->where('parent_cat_id','=',$rel_val->id)->where('status','1')->select('id','name','parent_cat_id')->get();
						?>
						 @foreach($relation1 AS $rel_val1)
							<li id="<?=$rel_val1->id?>" onclick="return setreletion(this.id)">
								<a href="#" id="rel_name<?=$rel_val1->id?>"><?=$rel_val1->name?></a></li>
							
					    @endforeach	
					</ul>
					</li>
				<?php } ?>			
					@endforeach	
							</ul>
							
						</div>	

		</div>

		<div class="tl-location">
			<input type="text" id="searchInput" name="address"  placeholder="Where do they live?">
			<div class="map" id="map" style="width: 100%; height: 300px; display: none"></div>
				<div class="form_area">
					<input type="hidden" name="location"  value="" id="location">
					<input type="hidden" name="lat" value="" id="lat">
					<input type="hidden" name="lng" value="" id="lng">
					<input type="hidden" name="userid" id="userid" value="">
				</div>
		</div>
		<div class="tl-formsearch-btn">
		<button type="button" onclick="return search();"  class="hvr-sweep-to-right">Search
		</button>
		
		</div>


	</form>
	<div class="home-bannertitle">Find the ideal gift from local independently owned businesses, from boutiques to eateries to experiences.</div>
</div>

<!-- caption-form-end -->

<!-- arrow-animate-start -->
<div class="tl-arrow">
	<a href="#works" class="downArrow">
		<img src="{{url('/public')}}/frontend/img/down-arrow.png" alt="" class="img-responsive bouncee">
	</a>
</div>	
<!-- arrow-animate-end -->

</section>

<!-- banner-content-end -->


<!-- how-it-works-start -->

<section class="tl-works" id="works">
	<div class="container">	
		<div class="tl-works-cols">
			<h1 class="wow fadeIn text-center" data-wow-delay="0.2s">How it works</h1>
			<div class="row">
				<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="0.8s">
					<div class="tl-works-box">
						<div class="tl-works-box-img">
							<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon1']}}" alt="" class="img-responsive">

							<span>1</span>
						</div>
						<div class="tl-works-box-text text-center">
								<?php echo $data['howitworks'][0]['tl_howitworks_text1']; ?>
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="1.2s">
					<div class="tl-works-box">
						<div class="tl-works-box-img">
							<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon2']}}" alt="" class="img-responsive">

							<span>2</span>
						</div>
						<div class="tl-works-box-text text-center">
								<?php echo $data['howitworks'][0]['tl_howitworks_text2']; ?>
						</div>
					</div>
				</div>

				<div class="col-sm-4 col-md-4 col-xs-12 wow fadeIn" data-wow-delay="1.5s">
					<div class="tl-works-box">
						<div class="tl-works-box-img">
							<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon3']}}" alt="" class="img-responsive">

							<span>3</span>
						</div>
						<div class="tl-works-box-text text-center">
							<?php echo $data['howitworks'][0]['tl_howitworks_text3']; ?>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
</section>

<!-- how-it-works-end -->

<!-- featured-start -->
<?php 
	 $data['featuretreat'] = DB::table('tbl_tl_product')->join('users','users.userid','tbl_tl_product.userid')->select('tbl_tl_product.userid','tl_product_id','tl_product_name','tl_product_price','tl_product_description','tl_product_image1','tl_product_feature')
					   ->where([
						   ['tl_product_feature','1'],
						   ['users.status','1'],
						   ['tl_product_status','1']
						   ])
					   ->limit(8)->inRandomOrder()->get();
		
       if(count($data['featuretreat'])>0){ 
		$data['storename'] =	DB::table('tbl_tl_addstore')->where('userid',$data['featuretreat'][0]->userid)->select('tl_addstore_name')->get();
 ?>
<section class="tl-featured">
	<div class="container">
		<div class="row">
			<h1 class="wow fadeIn text-center">Featured Treats</h1>
		</div>

		<div class="row">
	  
		 @foreach($data['featuretreat'] AS $featurelist)
		
			<div class="col-sm-3 col-md-3 col-xs-6 wow fadeIn" data-wow-delay="0.2s">
				<a href="javascript:void(0);" data-toggle="modal" onclick="openproductinfo({{$featurelist->tl_product_id}})"
				>
					<div class="tl-featured-cols">
						<div class="tl-featured-img">
							<img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{$featurelist->tl_product_image1}}" alt="" class="img-responsive image">

							<div class="middle">
								<div class="text">Click For More Info</div>
							</div>
						</div>
						<div class="tl-featured-text">
							<div class="tl-featured-detail">
							{{-- <div class="tl-featured-detail-title">{{$data['storename'][0]->tl_addstore_name}}</div> --}}
							    <div class="tl-featured-detail-title">{{$featurelist->tl_product_name}}</div>
							</div>
							<div class="tl-featured-doller">£{{$featurelist->tl_product_price}}</div>
							<div class="mobile-see-treat"><a href="javascript:void(0)" onclick="openproductinfo({{$featurelist->tl_product_id}})" class="treat-mobile">See Treat</a></div>
						</div>
					</div>
				</a>
			</div>
		 @endforeach

		</div>
	</div>
</section>
<?php } ?>

		<div class="modal tl-flipmodal" id="flipmodal" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<a href="#flipmodal" data-toggle="modal" id="flipmodal_link" data-dismiss="modal" class="hvr-sweep-to-right active" onclick="activeclass(this.id)" id="active_tl_treat">The Treat</a>
			 
						<a href="#tl_terms" onclick="activeclass(this.id)" id="active_needtoknow" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">Need to knows</a>
						<a href="#tl_merchant" onclick="activeclass(this.id)" id="active_tl_merchant" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">About the Merchant</a>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="flipmodal-modal" id="productmodalinfo">

						</div>
				</div>
			</div>
			
			</div>
		</div>

		<div class="modal tl-flipmodal" id="tl_terms" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<a href="#flipmodal" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right" onclick="activeclass(this.id)" id="active_tl_treat1">The Treat</a>
	
					<a href="#tl_terms" onclick="activeclass(this.id)" id="active_needtoknow1" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">Need to knows</a>
	
				<a href="#tl_merchant" onclick="activeclass(this.id)" id="active_tl_merchant1" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">About the Merchant</a>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="flipmodal-modal">
						<div class="flipmodal-box-article" id="tl_term_data">
							
						</div>
	
					</div>
				</div>
			</div>
			
			</div>
		</div>

		<div class="modal tl-flipmodal" id="tl_merchant" role="dialog">
			<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<a href="#flipmodal" onclick="activeclass(this.id)" id="active_tl_treat2" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">The Treat</a>
	
					<a href="#tl_terms" onclick="activeclass(this.id)" id="active_needtoknow2" data-toggle="modal" data-dismiss="modal" class="hvr-sweep-to-right">Need to knows</a>
	
				<a href="#tl_merchant" data-toggle="modal" onclick="activeclass(this.id)" id="active_tl_merchant2" data-dismiss="modal" class="hvr-sweep-to-right">About the Merchant</a>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="flipmodal-modal">
						<div class="flipmodal-box-article" id="tl_merchant_data">
							
						</div>
	
					</div>
				</div>
			</div>
			
			</div>
		</div>


<!-- featured-end -->

<!-- tl-ofthemonth-start -->

<?php
     if(isset($data['merchant']) && count($data['merchant'])>0){
	$merchant_month = DB::table('tbl_tl_addstore')->where('userid',$data['merchant'][0]['merchant_userid'])->select('tl_addstore_name','tl_addstore_logo','tl_addstore_address','tl_addstore_aboutmerchant','tl_addstore_services')->get();
	if(count($merchant_month)>0){
?>

<section class="tl-ofthemonth">
<div class="tl-parallax jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url({{url('/public')}}/tl_admin/upload/merchant-of-month/{{$data['merchant'][0]['tl_merchant_of_monthbgimg']}});"></div>
              
	<div class="tl-ofthemonth-header">
		<div class="container">
			<!-- <div class="tl-ofthemonth-header-img wow fadeIn">
				<img src="{{url('/public')}}/tl_admin/upload/merchant-of-month/{{$data['merchant'][0]['tl_merchant_of_month_logo']}}" alt="" class="img-responsive">
			</div> -->
			<h1 class="text-center wow fadeIn" data-wow-delay="0.5s">{{$data['merchant'][0]['tl_merchant_of_month_title']}}</h1>
			<div class="tl-ofthemonth-flexbox wow fadeIn" data-wow-delay="0.8s"> 
				<div class="tl-blackcols">
					<img src="{{url('/public')}}/tl_admin/upload/storelogo/{{$merchant_month[0]->tl_addstore_logo}}" alt="" class="img-responsive">   
				</div>
				<div class="tl-whitecols wow fadeIn" data-wow-delay="1.2s">
					
					<p><?php  echo $data['merchant'][0]['tl_merchant_of_month_desp']; ?></p>
			
					
					<div class="tl-whitecols-btn">
						<a href="javascript:void(0);" class="hvr-sweep-to-right" data-toggle="modal" onclick="openmodalstorepro({{$data['merchant'][0]['merchant_userid']}})" >View Treats</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } } ?>
<!-- tl-ofthe-end -->







<script>
/* script */
function initialize() {
	var latlng = new google.maps.LatLng(51.5074,0.1277);
  // var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
   var map = new google.maps.Map(document.getElementById('map'), {
	 center: latlng,
	 zoom: 13
   });
   var marker = new google.maps.Marker({
	 map: map,
	 position: latlng,
	 draggable: true,
	 anchorPoint: new google.maps.Point(0, -29)
  });
   var input = document.getElementById('searchInput');
   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   var geocoder = new google.maps.Geocoder();
   var autocomplete = new google.maps.places.Autocomplete(input);
   autocomplete.bindTo('bounds', map);
   var infowindow = new google.maps.InfoWindow();   
   autocomplete.addListener('place_changed', function() {
	   infowindow.close();
	   marker.setVisible(false);
	   var place = autocomplete.getPlace();
	   if (!place.geometry) {
		   window.alert("Autocomplete's returned place contains no geometry");
		   return;
	   }
 
	   // If the place has a geometry, then present it on a map.
	   if (place.geometry.viewport) {
		   map.fitBounds(place.geometry.viewport);
	   } else {
		   map.setCenter(place.geometry.location);
		   map.setZoom(17);
	   }
	  
	   marker.setPosition(place.geometry.location);
	   marker.setVisible(true);          
   
	   bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
	   infowindow.setContent(place.formatted_address);
	   infowindow.open(map, marker);
	  
   });
   // this function will work on marker move event into map 
   google.maps.event.addListener(marker, 'dragend', function() {
	   geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
	   if (status == google.maps.GeocoderStatus.OK) {
		 if (results[0]) {        
			 bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
			 infowindow.setContent(results[0].formatted_address);
			 infowindow.open(map, marker);
		 }
	   }
	   });
   });
}
function bindDataToForm(address,lat,lng){
  document.getElementById('location').value = address;
  document.getElementById('lat').value = lat;
  document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);


</script> 

<script type="text/javascript">

	function setreletion(id)   
	{
		var select_relation = document.getElementById("select_relation");
		select_relation.value=id;
		var rel_name = document.getElementById("rel_name"+id);
		document.getElementById("ref_rel_name").innerHTML=rel_name.innerHTML;
	}

		function search()
	{
		//alert('sweta'); return false;
		var select_relation = document.getElementById("select_relation").value.trim();
		var location =document.getElementById("location").value.trim(); 
		var lat =document.getElementById("lat").value.trim(); 
		var lng =document.getElementById("lng").value.trim(); 
		   
		var _token = $('input[name=_token]').val(); 
		
		  if(select_relation=="")
			{
				
			  document.getElementById('whour').style.border='1px solid #ff0000';
			  document.getElementById("whour").focus();
			  $("#whour").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("whour").style.border = "";   
			}
			
			
		
			if(location=="")
			{
			  document.getElementById('searchInput').style.border='1px solid #ff0000';
			  document.getElementById("searchInput").focus();
			  $('#searchInput').val('');
			$('#searchInput').attr("placeholder", "Please enter where do they live ?");
			  $("#searchInput").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("searchInput").style.border = "";   
			}
		
			document.getElementById("searchForm").submit();
	 
	  }// end of function

	  	function openproductinfo(id){
		var _token = $('input[name=_token]').val();
		$.ajax({
			method: "POST",
			url:"{{url('/openproductinfo')}}",
			data: { productid:id,_token:_token }

			})
			.done(function( response ) {
				console.log(response); 	// return false;
				var msg = response.msg;
				var abt_term = response.abt_term;
				var abt_merchant = response.abt_merchant;
				console.log(abt_merchant);
			     //	return false;
				if(response.status==200){
					$("#productmodalinfo").html(msg);
					$("#tl_term_data").html(abt_term);
					$("#tl_merchant_data").html(abt_merchant);
					$('#flipmodal_link').click();
					//$('#flipmodal').modal('show');
				}
				$('.tlflip-slideh').slick({
			centerMode: false,
			infinite: true,
			slidesToShow:1,
			dots:true,
			arrows:false,
			});


			});
		}

			 function addtocart(productid,userid){
		var _token = $('input[name=_token]').val();
		$.ajax({
			method: "POST",
			url:"{{url('/addtocart')}}",
			data: { productid:productid,userid:userid,_token:_token }

			})
			.done(function( response ) {
			console.log(response);// return false;
			var count_cart_item = response.count_cart_item;
				var image_name = response.image_name;
				var item_name = response.item_name;
				var item_description = response.item_description;
				var item_price = response.item_price;
				var item_id = response.item_id;
				var cart_index = response.cart_index;
				var item_storename = response.item_storename;
				var addtocarid = 'cartId'+item_id
			if(response.status==200){
				document.getElementById(addtocarid).innerText="Added to cart";
				document.getElementById("cart_item").innerText=count_cart_item;
				if(cart_index==0){
					$('#tom').html('<div class="tl-navtreat" id="deleterow'+item_id+'"><div class="tl-treatbox"><div class="tl-treat-modal"><div class="tl-treatbox-img"><img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/'+image_name+'" alt="" class="img-responsive"></div><div class="tl-treatbox-text"><div class="tl-treatbox-text-title">'+item_storename+'</div>  <div class="tl-treatbox-text-title">'+item_name+'</div>  <div class="tl-treatbox-text-sbtitle">'+item_description+'</div><div class="tl-treatbox-text-price">£'+item_price+'</div></div></div><div class="tl-treatbox-text-close"><a href="javascript:void(0)" onclick="remove_cart_item('+item_id+')" class="hvr-sweep-to-right"><i class="fa fa-times" aria-hidden="true"></i></a></div></div></div>');

						$('#addcart_maketreat_personal').html('<li class="tl-treatnav-makethetreat"><a href="{{url('review_treat')}}" class="hvr-sweep-to-right">Go to Cart</a></li>');
				}
				
				else if(cart_index>0){
					$('#tom').append('<div class="tl-navtreat" id="deleterow'+item_id+'"><div class="tl-treatbox"><div class="tl-treat-modal"><div class="tl-treatbox-img"><img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/'+image_name+'" alt="" class="img-responsive"></div><div class="tl-treatbox-text"><div class="tl-treatbox-text-title">'+item_name+'</div><div class="tl-treatbox-text-sbtitle">'+item_description+'</div><div class="tl-treatbox-text-price">£'+item_price+'</div></div></div><div class="tl-treatbox-text-close"><a href="javascript:void(0)" onclick="remove_cart_item('+item_id+')" class="hvr-sweep-to-right"><i class="fa fa-times" aria-hidden="true"></i></a></div></div></div>');

				
				}
				
			} else if(response.status==401){
				document.getElementById(addtocarid).innerText="Already added";
			}
			
			});
	 }

	 // merchant of the month /////
	 	function openmodalstorepro(userid){
		$.ajax({
			 headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
			method: "POST",
			url:"{{url('/openmodalstorepro')}}",
			data: { storeid:userid}

			})
		.done(function( response ) {
			console.log(response); //return false;
			var msg = response.msg;
			var abt_term = response.abt_term;
			var abt_merchant = response.abt_merchant;
			console.log(msg);
			//return false;
			if(response.status==200){
				$("#productmodalinfo").html(msg);   
				$("#tl_term_data").html(abt_term);
				$("#tl_merchant_data").html(abt_merchant);
				$('#flipmodal_link').click();
				//$('#flipmodal').modal('show');
			}
			$('.tlflip-slideh').slick({
			  centerMode: false,
			  infinite: true,
			  slidesToShow:1,
			  dots:true,
			  arrows:false,
			});


			});
	    }

	 ///////////////

	  function activeclass(id){
		 var href = document.getElementById(id).getAttribute("href");

		 	var list = document.querySelectorAll("a[href='"+href+"']");
			list.item(0).classList.remove("active");
			list.item(0).classList.add("active");

			list.item(1).classList.remove("active");
			list.item(1).classList.add("active");
			
			list.item(2).classList.remove("active");
			list.item(2).classList.add("active");
		 
		 if(href=='#tl_terms'){
			var flipmodal = document.querySelectorAll("a[href='#flipmodal']");
			var tl_merchant = document.querySelectorAll("a[href='#tl_merchant']");
			flipmodal.item(0).classList.remove("active");
			flipmodal.item(1).classList.remove("active");
			flipmodal.item(2).classList.remove("active");

			tl_merchant.item(0).classList.remove("active");
			tl_merchant.item(1).classList.remove("active");
			tl_merchant.item(2).classList.remove("active");
		 }else if(href=='#flipmodal'){
			var tl_terms = document.querySelectorAll("a[href='#tl_terms']");
			var tl_merchant = document.querySelectorAll("a[href='#tl_merchant']");
			tl_terms.item(0).classList.remove("active");
			tl_terms.item(1).classList.remove("active");
			tl_terms.item(2).classList.remove("active");

			tl_merchant.item(0).classList.remove("active");
			tl_merchant.item(1).classList.remove("active");
			tl_merchant.item(2).classList.remove("active");
		 }else if(href=='#tl_merchant'){
			var tl_terms = document.querySelectorAll("a[href='#tl_terms']");
			var flipmodal = document.querySelectorAll("a[href='#flipmodal']");
			tl_terms.item(0).classList.remove("active");
			tl_terms.item(1).classList.remove("active");
			tl_terms.item(2).classList.remove("active");

			flipmodal.item(0).classList.remove("active");
			flipmodal.item(1).classList.remove("active");
			flipmodal.item(2).classList.remove("active");
		 }


	
	 }
			
	  </script>

	    


 @endsection

<style type="text/css">
	.dropdown-submenu{ position: relative; }
.dropdown-submenu>.dropdown-menu{
  top:0;
  left:100%;
  margin-top:-6px;
  margin-left:-1px;
  -webkit-border-radius:0 6px 6px 6px;
  -moz-border-radius:0 6px 6px 6px;
  border-radius:0 6px 6px 6px;
}
.dropdown-submenu>a:after{
  display:block;
  content:" ";
  float:right;
  width:0;
  height:0;
  border-color:transparent;
  border-style:solid;
  border-width:5px 0 5px 5px;
  border-left-color:#cccccc;
  margin-top:5px;margin-right:-10px;
}
.dropdown-submenu:hover>a:after{
  border-left-color:#555;
}
.dropdown-submenu.pull-left{ float: none; }
.dropdown-submenu.pull-left>.dropdown-menu{
  left: -100%;
  margin-left: 10px;
  -webkit-border-radius: 6px 0 6px 6px;
  -moz-border-radius: 6px 0 6px 6px;
  border-radius: 6px 0 6px 6px;
}

.search-dropdwon ul {
    list-style: none;
    background: #fff;
    margin: 0;
    padding:0; 
}
.search-dropdwon ul li a {
    text-decoration: none;
    color: #000;
    text-align: left;
    padding: 14px 10px;
    display: block;
        height: 50px;
        background: #e3e3e5;
}

.search-dropdwon .open>.dropdown-menu {
    display: block;
    width: 60%;
    border-radius: 0;
    top: 100%;
    box-shadow: none;
    border: none;
    
}
.search-dropdwon ul.dropdown-menu li a {
    height: auto;
    padding: 5px 10px;
    background: #fff;
}
.search-dropdwon ul.dropdown-menu li a:hover {
	background: #e3e3e5;
}
li.dropdown.dropdown-submenu.open ul {
    top: 18px;
    width: 100%;
    max-width: 100%;
    padding: 10px 0;
    background: #e3e3e5;
}
li.dropdown.dropdown-submenu.open li a {
    background: #e3e3e5;
    padding: 5px 20px;
}
li.dropdown.dropdown-submenu.open li a:hover {
	background: #fff;
} 
.search-dropdwon .dropdown-submenu>a:after{
	    border-width: 5px 0 5px 5px;
    border-left-color: #000000;
    margin-top: 5px;
    margin-right: 0;
}
/*
@media (min-width: 768px) { 
}
@media (min-width: 992px) { 
}
@media (min-width: 1200px) { 
}
*/
</style>