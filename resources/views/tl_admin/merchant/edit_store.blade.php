@extends('tl_admin.layouts.frontlayouts')

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
              
<?php
  $segment = Request::segment(3);
?>

  <div class="content-wrapper tl-admin-about tl_editstore">
   
    <section class="content-header">
      <h1 class="info-box-text">
      Add Store
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">  Add Store</li>
      </ol>
    </section>

     
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#" onsubmit="return addstore();" id="addstoreform" name="addstoreform">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 

              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="inputPassword3" class="tl-about-smallheading">Store name</label>
                     <input type="text" id="store_name" name="store_name"  value="{{$data[0]['tl_addstore_name']}}" class="form-control">
                    {{-- <input type="hidden" name="user_id" class="form-control" id="user_id" value="{{$userid}}"> --}}
                  </div>
                </div>
               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-8">
                    <label for="inputPassword3" class="tl-about-smallheading">Store Address</label>
                     {{-- <input type="text" id="store_addr" name="store_addr" > --}}
                     <input type="text" id="searchInput" name="address"   class="form-control" value="{{$data[0]['tl_addstore_address']}}" placeholder="Enter a location" >
                     <div class="map" id="map" style="width: 100%; height: 300px; display: none"></div>
                        <div class="form_area">
                            <input type="hidden" name="location" value="{{$data[0]['tl_addstore_address']}}" id="location" class="form-control">
                            <input type="hidden" name="lat" id="lat" value="{{$data[0]['tl_addstore_lat']}}" class="form-control">
                            <input type="hidden" name="lng" id="lng" value="{{$data[0]['tl_addstore_lng']}}" class="form-control">
                        </div>
                     <input type="hidden" class="form-control" name="id" id="id" value={{$segment}}>
                  </div>
                </div>
               
              </div>
              <div class="col-sm-4">
                <label for="inputPassword3" class="tl-about-smallheading">Store logo</label>
                <label for="" class="tl-choose">
                  <input type="file" id="store_logo" name="store_logo" class="form-control">
                  <span>Choose Image</span>
                </label>
                <div class="tl-admin-upimg">
                  <img src="{{url('/public')}}/tl_admin/upload/storelogo/{{ $data[0]['tl_addstore_logo'] }}">
                </div>                  
              </div>
                       
             <!--  <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-8">
                    <label for="inputPassword3" class="tl-about-smallheading">About the merchant</label>
                     <textarea name="about_merchant" class="form-control" id="about_merchant" cols="30" rows="5"><?php // echo $data[0]['tl_addstore_aboutmerchant'];?></textarea>
                    
                  </div>
                </div>
               
              </div> -->

                <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">About the merchant</label>

                  <div class="col-sm-10">
                    <textarea id="editor" name="editor" class="ckeditor"><?php echo $data[0]['tl_addstore_aboutmerchant'] ?></textarea>
                     <input type="hidden" id="about_merchant" name="about_merchant" value="">
                   
                  </div>
                </div>
               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Terms & conditions</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"><?php  echo $data[0]['tl_addstore_termscondt']; ?></textarea>
                     <input type="hidden" id="termsconditiondesp" name="termsconditiondesp" value="">
                   
                  </div>
                </div>
               
              </div>
       
          

             

      
              
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" onclick="goBack()" class="tl-btn-defult hvr-sweep-to-right">Go Back</a>
                <input type="submit" class="tl-btn-defult hvr-sweep-to-right pull-right" value="update">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->

          <div class="col-md-1"></div>

        
        
        
      </div><!-- end of row -->
    </section>
  
    <!-- /.content -->
  </div>
 



<script type="text/javascript">

function addstore()
{

  
   
    var store_name = document.getElementById("store_name").value.trim();
    var id =document.getElementById("id").value.trim();
    var store_logo =document.getElementById("store_logo").value.trim();
    var store_logo = $('#store_logo')[0].files[0];
    var location =document.getElementById("location").value.trim(); 
    var lat =document.getElementById("lat").value.trim(); 
    var lng =document.getElementById("lng").value.trim(); 
  //  var about_merchant =document.getElementById("about_merchant").value.trim();
    var termsdescription =CKEDITOR.instances.editor1.getData();
     var about_merchant =CKEDITOR.instances.editor.getData();  
    var _token = $('input[name=_token]').val(); 

  //  alert(user_id);
	
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

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

         // validation for email 
	 if(about_merchant=="")
  {

       document.getElementById('about_merchant').style.border='1px solid #ff0000';
       document.getElementById("about_merchant").focus();
       $('#about_merchant').attr("placeholder", "Please enter about merchant");
       $("#about_merchant").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("about_merchant").style.borderColor = "";     
       
  }  
   
  if(termsdescription=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter Terms & Condition" ; 
      return false;
    }
    else
    {
       $('#termsconditiondesp').val(termsdescription);
        document.getElementById("errormsg").innerHTML="" ; 
        var termsconditiondesp = document.getElementById('termsconditiondesp').value.trim();
    }
  
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('store_name', store_name);
       form.append('location', location);
       form.append('lat', lat); 
       form.append('lng', lng);
       form.append('about_merchant', about_merchant); 
       form.append('termsconditiondesp', termsconditiondesp); 
       form.append('store_logo', store_logo);   
       form.append('id', id);  
       form.append('_token', _token);   


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/updatestore')}}",
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



     

    function goBack() {
        window.history.back();
    }
    </script>

<script type="text/javascript">

    $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    // $('.textarea').wysihtml5()
    })
    </script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD83Rvhlxn-kCjEW9pR0Q-rza2DYb_BuUY&libraries=places"></script>

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
</script> 


@endsection