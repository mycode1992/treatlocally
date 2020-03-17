@extends('frontend.layouts.frontlayout')

@section('content')

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD83Rvhlxn-kCjEW9pR0Q-rza2DYb_BuUY&libraries=places"></script>

<?php
    // print_r($store); exit;
   if(isset($_GET['filter_by']) && $_GET['filter_by']!=''){
			$cat_value =  $_GET['filter_by']; 
	 }else{
		
		$cat_value = '';
	 }

if(isset($data)){   

	if(count($data)>0)
	{
	 $relationfor_treat = $data['relation']; 
	 $location = $data['location'];
	 $lat = $data['lat'];
	 $lng = $data['lng'];   
    }

	if(isset($store) && count($store)>0){ 	 
		if(count($store)>0){
			
			$data=array();
				$center_lat="";
				$center_lng="";
				foreach ($store as $value) 
				{  
					$tl_addstore_userid  = $value->userid;   
					$tl_addstore_name    = $value->tl_addstore_name;
					$tl_addstore_address = $value->tl_addstore_address;	
					$tl_addstore_logo    = $value->tl_addstore_logo;
					$tl_addstore_lat     = $value->tl_addstore_lat;
					$tl_addstore_lng     = $value->tl_addstore_lng;	
					if($tl_addstore_lat != "")
					{
						$center_lat=$tl_addstore_lat;
						$center_lng=$tl_addstore_lng;
						$data[]=array(
						"StoreName" => $tl_addstore_name,
						"Storeaddress" => $tl_addstore_address,
						"Storelogo" => $tl_addstore_logo,
						"lat" => $tl_addstore_lat,
						"longt" => $tl_addstore_lng
							);
						$data1[]=array(
						 "storeuserid" => $tl_addstore_userid ,
						 "storerelation" => $relationfor_treat
						);
					}
					else 
					{
						continue;	
					}
					
				}
				$jsondata=json_encode($data);
				$jsondata1=json_encode($data1);

		}
	}else{      
		$center_lat=$lat; 
		$center_lng= $lng; 
		$data = array();  
			$data[]=array(
						"StoreName" => '',
						"Storeaddress" => $location ,
						"Storelogo" => '',
						"lat" => $lat,
						"longt" => $lng
							);   
			$data1[]=array(
						 "storeuserid" => '' ,
						 "storerelation" => $relationfor_treat
						);

			$jsondata=json_encode($data);
			$jsondata1=json_encode($data1);
	}

		


	}else{
		$relationfor_treat = ''; 
		$location = ''; 
		$lat = ''; 
		$lng =''; 
		$center_lat= ''; 
		$center_lng= ''; 
		$jsondata='';
		$jsondata1='';

	}    

?>
<input type="hidden" id="center_lat" value="{{$center_lat}}">
<input type="hidden" id="center_lng" value="{{$center_lng}}">
<span id="location_id" style="display:none;"><?php echo $jsondata;?></span>
<span id="location_id1" style="display:none;"><?php echo $jsondata1;?></span>
 <section class="tl-filter-main tl-contact tl-about">
	 <div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/frontend/img/aboutus_header.jpg);"></div>
		
		<div class="tl-caption-title">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="tl-title">Make your treat Personal</div>
					</div>
					<div class="col-xs-12">
						<div class="row">
							<div class="tl-steptostep">
								<div class="tl-step-flexbox">
									<div class="tl-step-cols active"><a href="{{url('/')}}">Choose Your Treat</a></div>
									<div class="tl-step-mobile"><a href="{{url('/')}}">1</a></div>
									<div id="review_treat1" class="tl-step-cols <?php if(!empty($_SESSION["shopping_cart"])){echo 'active';}?>"><a href="{{url('/review_treat')}}">Review Your Treat</a></div>
									<div class="tl-step-mobile"> <a href="{{url('/review_treat')}}"> 2 </a></div>
									<div class="tl-step-cols"><a href="javascript:void(0)">Review And Payment</a></div>
									<div class="tl-step-mobile"><a href="javascript:void(0)">4</a></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tl-filter-form caption-form">
		<form action="{{ url('search') }}" method="GET" id="searchForm">
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
								<li class="afternone" id="<?=$rel_val1->id?>" onclick="return setreletion(this.id)">
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
				<input type="text" value="{{$location}}"  id="searchInput" name="address" placeholder="Where do they live?">
				<div class="map1" id="map1" style="width: 100%; height: 300px; display: none"></div>
				<div class="form_area">
					<input type="hidden" name="location"  value="{{$location}}" id="location">
					<input type="hidden" name="lat" value="{{$lat}}" id="lat">
					<input type="hidden" name="lng" value="{{$lng}}" id="lng">
					<input type="hidden" name="userid" id="userid" value="">
				</div>
			</div>

			<div class="tl-formsearch-btn">
				<button type="button" onclick="search()" class="hvr-sweep-to-right">Search</button>
			</div>
			<div class="tl-formsearch-btn">
				<!-- <a href="#" class="hvr-sweep-to-right" onclick="javascript:history.go(-1)">Go back</a> -->
				<button type="button" onclick="javascript:history.go(-1)" class="hvr-sweep-to-right">Go back</button>
			</div>
		</form>

		

	</div>
</section>

<!-- tl-filter-end -->

  <section class="tl-featured tl-featured-other">
	<div class="col-md-7 col-sm-7 col-xs-12">
		<div class="row">
			<div class="col-xs-12">
				<div class="tl-filter-btn">
				<?php
					if(isset($store) && count($store)>0) { 
				?>
					<div class="dropdown keep-inside-clicks-open">
					    <button class="btn btn-primary dropdown-toggle hvr-sweep-to-right" type="button" data-toggle="dropdown">Filter
					    <i class="fa fa-angle-down" aria-hidden="true"></i></button>
					    <div class="Nearest_Treats_heading">Nearest Treats</div>
					    <div class="dropdown-menu">
					      <div class="tl-filter-dropdown">
					      	<div class="tl-filter-dropdown-cols">
					      		<div class="gigs-fltr-add">
						            <input type="checkbox" name="price" id="price" value="desc" <?php if($cat_value=='desc'){ echo "checked"; } ?> class="chk">
						            <label for="price"><span class="checkbox">Price - high to low</span></label>
						        </div>
						        <div class="gigs-fltr-add">
						            <input type="checkbox" name="price2" id="price2" value="asc" <?php if($cat_value=='asc'){ echo "checked"; } ?> class="chk">
						            <label for="price2"><span class="checkbox">Price - low to high</span></label>
										</div>
										<?php 
												$data_cat = DB::table('tbl_tl_category')->where('tl_category_status','1')
																		->select('tl_category_id','tl_category_name')->get();
										?>
										@foreach($data_cat as $data_cat_val)
						        <div class="gigs-fltr-add">
						            <input type="checkbox" name="{{$data_cat_val->tl_category_name}}" <?php if($cat_value==$data_cat_val->tl_category_id){ echo "checked"; } ?> value="{{$data_cat_val->tl_category_id}}" class="chk" id="{{$data_cat_val->tl_category_name}}">
						            <label for="{{$data_cat_val->tl_category_name}}"><span class="checkbox">{{$data_cat_val->tl_category_name}}</span></label>
						        </div>
						       @endforeach
					      	</div>
					      	
					      </div>
					    </div>
					  </div>  
				<?php } ?>
				</div>
				<?php if(isset($store) && count($store)>0) {  ?>
					<div class="tl-mobileview">
						<a href="javascript:void(0)" class="hvr-sweep-to-right active" onclick="listviewtoggle()">List View</a>
				    	<a href="javascript:void(0)" class="hvr-sweep-to-right" onclick="mapviewtoggle()">Map View</a>
				    </div>
			    <?php } ?>
			</div>

			
			<?php 
			// print_r($store);
					if(isset($store) && count($store)>0) { 
						$index = 0;
			?>
			   <div class="tl-autoscrollbar" id="listview">
				@foreach($store AS $store_val)
				<div class="col-sm-4 col-md-4 col-xs-6">
					<a href="javascript:void(0);" data-toggle="modal" onclick="openmodalprdinfo({{$store_val->userid}},{{$relationfor_treat}})">
						<div class="tl-featured-cols">
							<div class="tl-featured-img" onmouseover="hovermap(this.id)" onmouseout="mouseoutmap(this.id)" id="{{ $store_val->tl_addstore_name}}|{{ $store_val->tl_addstore_logo}}|{{$store_val->tl_addstore_lat}}|{{$store_val->tl_addstore_lng}}|{{$store_val->userid}}|{{$relationfor_treat}}">
								<img src="{{url('/')}}/public/tl_admin/upload/storelogo/{{$store_val->tl_addstore_logo}}" alt="" class="img-responsive">
								
							</div>
							<div class="tl-featured-text">
								<div class="tl-featured-detail">
									<div class="tl-featured-detail-title">{{ $store_val->tl_addstore_name}} </div>
									<?php  echo $store_val->tl_addstore_services; ?>
								</div>
								<div class="tl-featured-doller">£{{$store_val->price}}</div>
									
								<div class="treat-buynonw-btn">Buy Now</div>
							</div>
						</div>
					</a>
				</div>
				  <?php $index++; ?>
               @endforeach
              </div>
			<?php }
				   else { ?>
				   	                             
				   	<div class="ti-emptyproduct">OOPS! Service not available in the selected area.</div>
				  
				  <?php }
			 ?>
				 
			
		</div>
	</div>

	<div class="col-md-5 col-sm-5 col-xs-12">
		<div class="tl-searching-map" id="mapview">
			<div class="locatorMap">
				<div class="map" id="map" style="width:100%;height:450px;">map</div>
			  </div>
		</div>
	</div>
</section>

<!-- featured-end -->

<!-- modal-start -->

<div class="modal tl-flipmodal" id="flipmodal" role="dialog">
	<div class="modal-dialog">
	  <div class="modal-content">
		    <div class="modal-header">
	          <a href="#flipmodal" data-toggle="modal" id="flipmodal_link" data-dismiss="modal" class="hvr-sweep-to-right active" onclick="activeclass(this.id)" id="active_tl_treat">The Treat</a>
			  {{-- <a href="#tl_terms" onclick="activeclass()" id="active_needtoknow" class="hvr-sweep-to-right">Need to knows</a> --}}
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

<!-- modal-end -->



<script type="text/javascript">
  var markers = {};
// MOUSE OVER CODE LIVE
	function hovermap(id)
        {
			
           var latlngs = id.split("|");
           var lat = Number(latlngs[2]);
           var lng = Number(latlngs[3]);
					 var bounds = "";
	var marker = markers[lat]; // find the marker by given id
    marker.setMap(null);
          // console.log(lat);
					var icon = "{{url('/public/frontend/img/25.png')}}";
           var marker_location = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            zoom: 11,
            map: map,
			icon:icon
            // icon : iconBase
        });

		markers[lat]= marker_location;
		marker_location.setMap(map);

		// bounds.extend(new google.maps.LatLng(lat,lng));
		// map.fitBounds(bounds);
		return true;
		//    addMarker(lat,lng);

				}
///// MOUSE OVER CODE END LIVE
// MOUSE OUT CODE LIVE
function mouseoutmap(id)
        {
			var latlngs = id.split("|");
			
           var lat = Number(latlngs[2]);
           var lng = Number(latlngs[3]);
		   var storeuserid = Number(latlngs[4]);
		   var relation = Number(latlngs[5]);
					 var bounds = "";
	var marker = markers[lat]; // find the marker by given id
    marker.setMap(null);
          // console.log(lat);
			var icon = "{{url('/public/frontend/img/26.png')}}";
            var marker_location = new google.maps.Marker({
            position: new google.maps.LatLng(lat,lng),
            zoom: 11,
            map: map,
						icon:icon
           
            // icon : iconBase
        });

		
		markers[lat]= marker_location;
		marker_location.setMap(map);
		// bounds.extend(new google.maps.LatLng(lat,lng));
		// map.fitBounds(bounds);
		attachMessageOut(marker_location, latlngs , storeuserid, relation);
	
		return true;
		//    addMarker(lat,lng);

				}

	//  MOUSE OUT CODE END LIVE
				function attachMessageOut(marker, location , storeuserid, relation) 
			{
				var base_url = "{{url('/public/tl_admin/upload/storelogo/')}}";

							var contentString = "<div onclick='openmodalprdinfo(" + storeuserid +"," + relation +")' style='background: black;width: 250px;padding: 10px;text-align: center;color: #fff; cursor: pointer;'><b>" + location[0] +"</div>"+ "</b><div style='background: #fff; font-weight:bold;width: 250px;padding: 10px;text-align: center;color: #000;'><img src='"+base_url+"/"+location[1]+"' alt='' class='img-responsive'></div>";
						var infowindow = new google.maps.InfoWindow({
								content: contentString,
								zIndex: 10

							});
							marker.addListener('click', function() {
							infowindow.open(map, marker);
							});

			}
///// MOUSE OUT CODE END LIVE

			var pn=document.getElementById('location_id').innerHTML;
			
			var points=JSON.parse(pn);
			
			for (i=0;i<points.length;i++){
							points[i][0] = points[i]['StoreName'];
							points[i][1] = points[i]['Storelogo'];
							points[i][2] = points[i]['lat'];
							points[i][3] = points[i]['longt'];
						
			}

			///// merchant popup ////////    "storeuserid" => '' ,
						 
                    
			var pn1=document.getElementById('location_id1').innerHTML;
			var points1=JSON.parse(pn1);
			for (i=0;i<points1.length;i++){
				points1[i][0] = points1[i]['storeuserid'];
				points1[i][1] = points1[i]['storerelation'];
						
			 }

						
					
			//////end mechant pop up////

			</script>
			<script type="text/javascript">
			var user_lat = 0;
			var user_lng = 0;
			var map;
			var nearLocation = [];
			var markersArray = [];
			var directionsDisplay;
			var directionsService;
			var infoW = [];
			var loc_lat;
			var loc_lng;
			var geocoder;
			var selectedCity;
			var list_array = [];
			var is_listView = true;
			var base_url = "{{url('/public/tl_admin/upload/storelogo/')}}";
			function initMap() {
			var center_lat=document.getElementById('center_lat').value.trim();
			var center_lng=document.getElementById('center_lng').value.trim();
			geocoder = new google.maps.Geocoder();
			map = new google.maps.Map(document.getElementById('map'), {
				center: {
					lat: center_lat,
					lng: center_lng
				},
				zoom: 11
			});
			directionsService = new google.maps.DirectionsService();
			directionsDisplay = new google.maps.DirectionsRenderer();
			directionsDisplay.setMap(map);
			}
					window.onload = function() {
						initMap();
						setLocation();
					};
				function clearOverlays() {
					list_array = [];
					list_array.length = 0;
					for (var i = 0; i < markersArray.length; i++ ) {
						markersArray[i].setMap(null);
					}
					markersArray = [];
					markersArray.length = 0;
				}
				//
				//setLocation();
			function setLocation() {
				clearOverlays();
				var icon = "{{url('/public/frontend/img/26.png')}}";
		
				for (var i = 0; i < points.length; ++i) {

						list_array.push(points1[i]);
						var marker_location = new google.maps.Marker({
							id : Number(points[i][2]),
							position: {
								lat: Number(points[i][2]),
								lng: Number(points[i][3])
							
							},
							icon:	icon,
						
					
						zIndex: 9999,
						//animation:google.maps.Animation.DROP,
						map: map
					});
					markers[Number(points[i][2])] = marker_location;
							markersArray.push(marker_location);
							marker_location.setZIndex(100);
							console.log('dfg'+points1[i]);
							attachMessage(marker_location, points[i],  points1[i]);
					
					}

					


					if(markersArray.length!=0)
					{
						map.setCenter(markersArray[0].getPosition());
						map.setZoom(11);
					}
					
				}
			function attachMessage(marker, location, storepopup) 
			{
                     

							if(location[1]=='')
							{
								var contentString = "<div style='background: black;width: 250px;padding: 10px;text-align: center;color: #fff;'><b>No Service Available</div>"+ "</b><div style='background: #fff; font-weight:bold;width: 250px;padding: 10px;text-align: center;color: #000;'>" + location[1] +"</div>";
							}
							else
							{
								var contentString = "<div onclick='openmodalprdinfo(" + storepopup[0] +"," + storepopup[1] +")' style='background: black;width: 250px;padding: 10px;text-align: center;color: #fff;     cursor: pointer;'><b>" +location[0] +"</div>"+ "</b><div style='background: #fff; font-weight:bold;width: 250px;padding: 10px;text-align: center;color: #000;'><img src='"+base_url+"/"+location[1]+"' alt='' class='img-responsive'></div>";
							}
							
						

							var infowindow = new google.maps.InfoWindow({
								content: contentString,
								zIndex: 10

							});
							marker.addListener('click', function() 
							{

								for (var a = 0; a < infoW.length; a++) {
									infoW[a].close();
								}
								infowindow.open(marker.get('map'), marker);
								infowindow.setZIndex(1001);
								infoW.push(infowindow);
							});
			}

				showList();
				function showList(){
					document.getElementById('map').style.display = 'block';
					}  
				</script>



				<script>
				/* script */
				function initialize() {
					
					var latlng = new google.maps.LatLng(51.5074,0.1277);
  // var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
					var map = new google.maps.Map(document.getElementById('map1'), {
					center: latlng,
					zoom: 11
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
		   map.setZoom(11);
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

	(function() {
		var url_relid = "{{$_GET['select_relation']}}";
		var rel_name = document.getElementById("rel_name"+url_relid);
		document.getElementById("ref_rel_name").innerHTML=rel_name.innerHTML;
		var select_relation = document.getElementById("select_relation");
		select_relation.value=url_relid;
		
	})();


	function setreletion(id)   
	{
		var select_relation = document.getElementById("select_relation");
		select_relation.value=id;
		var rel_name = document.getElementById("rel_name"+id);
		document.getElementById("ref_rel_name").innerHTML=rel_name.innerHTML;
	}
	function search()
	{
	
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
	  </script>

	  <script>
	function openmodalprdinfo(userid,relation){
		var _token = $('input[name=_token]').val();
		var categoryid = "{{$cat_value}}";
		$.ajax({
			method: "POST",
			url:"{{url('/openmodalprdinfo')}}",
			data: { storeid:userid,relation,relation,_token:_token,categoryid:categoryid }

			})
		.done(function( response ) {
			console.log(response);  //return false;
			var msg = response.msg;
			var abt_term = response.abt_term;
			var abt_merchant = response.abt_merchant;
			console.log(abt_merchant);
		///	return false;
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
				var review_treat1 = document.getElementById('review_treat1');
  				   review_treat1.classList.add("active"); 

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

		function mapviewtoggle(){
		$('#mapview').show();
		$('#listview').hide();
		}
		function listviewtoggle(){
		$('#listview').show();
		$('#mapview').hide();
		}


	  </script>

	 
<style>
	button.gm-ui-hover-effect {
    opacity: 1;
    padding: 0px !important;
}
button.gm-ui-hover-effect img{
	display: none;

}
button.gm-ui-hover-effect:after {
    content: "\f00d" !important;
    position: absolute !important;
    display: block !important;
    font-family: fontAwesome;
    
    right: 2px;
    background: #fff;
    top: 2px;
    height: 28px;
    width: 28px;
    color: #444343;
    line-height: 25px;
    font-size: 14px;
    cursor: pointer;
}

.tl-mobileview a.active{
	background: #01008b;
}
</style>

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
    padding: 10px;
    display: block;
        height: 50px;
        background: #e3e3e5;
}

.search-dropdwon .open>.dropdown-menu {
    display: block;
    width: 70%;
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

.tl-contact.tl-about .search-dropdwon ul li.afternone a:after{
	display: none;
}
</style> 