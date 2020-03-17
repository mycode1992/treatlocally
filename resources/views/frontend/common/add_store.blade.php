@extends('frontend.layouts.frontlayout')

@section('content')

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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk91uYra2cpd-phW1kVp2urGmbzBYWvcI&libraries=places"></script>

<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">



<!-- about-start -->
<?php
	$session_all=Session::get('sessionmerchant');
       if($session_all==true){
		$userid = $session_all['userid'];
	   }

	   if(isset($data) && count($data)>0)
	{
	   $updateid = $data[0]->userid;  
	   $name = $data[0]->tl_addstore_name; 
	   $lng = $data[0]->tl_addstore_lng; 
	   $lat = $data[0]->tl_addstore_lat; 
	   $logo = $data[0]->tl_addstore_logo;
	   $address = $data[0]->tl_addstore_address;
	   $aboutmerchant = $data[0]->tl_addstore_aboutmerchant;
	   $termscondt = $data[0]->tl_addstore_termscondt;
	   $button_text = 'Update';
	 
	}
	else
    {
	    $updateid = '';
		$name = '';
		$lng = ''; 
	   $lat = '';
	   $logo = '';
	   $address = '';
	   $aboutmerchant = '';
	   $termscondt = '';
	   $button_text = 'Submit';
	}
	
?>
<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Dashboard</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				@include('frontend.common.sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
						<div class="tl-account-right-title">Add Store</div>

						<div class="tl-account-right-form">
							<form action="" class="tl_addstoreform" onsubmit="return merchantaddstore();">
							  <input type="hidden" name="updateid" id="updateid" value="{{$updateid}}"> 
								
								<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6 col-md-6 col-xs-12">
											<label for="">Store Name*</label>
											<label for="">
												<input type="text" id="store_name" name="store_name" value="{{$name}}" class="form-control">
											</label>
										</div>
										<div class="col-sm-6 col-md-6 col-xs-12">
											<label for="">Upload Logo</label>
											<label for="" class="tl_choosefile">
												<input type="file" class="form-control" id="store_logo" onchange="readURL(this);" name="store_logo">
												
												<span>Click to upload file</span>
											</label>
											<label for="" class="tl_subtitle">You can upload a JPEG,JPG or PNG file.</label>
										</div>
										<?php if($logo!=''){ ?>
											<div class="col-sm-6 col-md-6 col-xs-12" id="storelogo" style="display:block">
													<img id="blah" src="{{url('/')}}/public/tl_admin/upload/storelogo/{{$logo}}" alt="your image"  />
											</div>
										<?php	}else{ ?>
												<div class="col-sm-6 col-md-6 col-xs-12" id="storelogo" style="display:none">
														<img id="blah" src="#" alt="your image"  />
												</div>
											<?php }  ?>
										
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<label for="">Store Address*</label>
											<label for="">
													<input type="text" id="searchInput" name="address"  value="{{$address}}" class="form-control" value="" placeholder="Enter a location" >

												<div class="map" id="map" style="width: 100%; height: 300px; display: none"></div>
												<div class="form_area">
													<input type="hidden" name="location"  value="{{$address}}" id="location">
													<input type="hidden" name="lat" value="{{$lat}}" id="lat">
													<input type="hidden" name="lng" value="{{$lng}}" id="lng">
													<input type="hidden" name="userid" id="userid" value={{$userid}}>
												</div>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<label for="">About the Merchant*</label>
											<label for="">
												<textarea id="about_merchant" name="about_merchant" class="form-control">{{$aboutmerchant}}</textarea>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<label for="">Terms & Condition*</label>
											<label for="">
												<textarea id="termsconditiondesp" name="termsconditiondesp" class="form-control">{{$termscondt}}</textarea>
											</label>
										</div>
									</div>
								</div>
								<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
									<div class="overlay" style="position: relative !important;display:none;">
								<i class="fa fa-refresh fa-spin"></i>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-12">
											<label for="">
												<button type="submit" class="hvr-sweep-to-right">Submit</button>
											</label>
										</div>
									</div>	
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</section>

<script type="text/javascript">

	function merchantaddstore()
	{
		
		var store_name = document.getElementById("store_name").value.trim();
		var userid =document.getElementById("userid").value.trim();
		var updateid =document.getElementById("updateid").value.trim();

		var store_logo =document.getElementById("store_logo").value.trim();
		var store_logo = $('#store_logo')[0].files[0];
		var location =document.getElementById("location").value.trim(); 
		var lat =document.getElementById("lat").value.trim(); 
		var lng =document.getElementById("lng").value.trim(); 
		var about_merchant = document.getElementById('about_merchant').value.trim();
		var termsconditiondesp = document.getElementById('termsconditiondesp').value.trim();   
		var _token = $('input[name=_token]').val(); 
		
		  if(store_name=="")
			{
			  document.getElementById('store_name').style.border='1px solid #ff0000';
			  document.getElementById("store_name").focus();
			  $('#store_name').val('');
			$('#store_name').attr("placeholder", "Please enter your store name");
			  $("#store_name").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("store_name").style.border = "";   
			}
			
	
			if(location=="")
			{
			  document.getElementById('searchInput').style.border='1px solid #ff0000';
			  document.getElementById("searchInput").focus();
			  $('#searchInput').val('');
			$('#searchInput').attr("placeholder", "Please enter your store address");
			  $("#searchInput").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("searchInput").style.border = "";   
			}
	
			
	  if(about_merchant=="")
		{
		 
		  document.getElementById("errormsg").style.color = "#ff0000";
		  document.getElementById("errormsg").innerHTML="Please enter About Merchant" ; 
		  return false;
		}
		else
		{
		  
			document.getElementById("errormsg").innerHTML="" ; 
			
		}
	   
	  if(termsconditiondesp=="")
		{
		 
		  document.getElementById("errormsg").style.color = "#ff0000";
		  document.getElementById("errormsg").innerHTML="Please enter Terms & Condition" ; 
		  return false;
		}
		else
		{
			document.getElementById("errormsg").innerHTML="" ; 
		}

		
	   $(".overlay").css("display",'block');
	   //return false;
		var form = new FormData();
		   form.append('store_name', store_name);
		   form.append('location', location);  
		   form.append('lat', lat); 
		   form.append('lng', lng); 
		   form.append('userid', userid); 
		   form.append('updateid', updateid); 
		   form.append('about_merchant', about_merchant); 
		   form.append('termsconditiondesp', termsconditiondesp); 
		   form.append('store_logo', store_logo); 
		   form.append('_token', _token);   
	
	
	  
		$.ajax({    
		type: 'POST',
		url: "{{url('/merchantaddstore')}}", 
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
		  var status=response.status;
		  var msg=response.msg;
		  
			console.log(response); // return false;
		  $(".overlay").css("display",'none');        
		  
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
	  </script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBz-LGvlIHTQoeJ1E7GMplSXzbFy1d6Qso&libraries=places"></script>

<!--<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">-->

<script>
/* script */
function initialize() {
  var latlng = new google.maps.LatLng(28.5355161,77.39102649999995);
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

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
            $('#storelogo').css('display','block');
        }
    }

</script> 


 @endsection