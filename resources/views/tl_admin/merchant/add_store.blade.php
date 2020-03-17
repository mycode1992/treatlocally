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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD83Rvhlxn-kCjEW9pR0Q-rza2DYb_BuUY&libraries=places"></script>

<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
              
<?php
  $segment = Request::segment(3);

	   if(isset($data) && count($data)>0)
	{
	   $updateid = $data[0]->userid;  
	   $name = $data[0]->tl_addstore_name; 
	   $lng = $data[0]->tl_addstore_lng; 
	   $lat = $data[0]->tl_addstore_lat; 
	   $logo = $data[0]->tl_addstore_logo;
	   $address = $data[0]->tl_addstore_address;
	   $postcode = $data[0]->tl_addstore_postcode;
     $aboutmerchant = $data[0]->tl_addstore_aboutmerchant;
	   $tl_addstore_treat_cardmsg = $data[0]->tl_addstore_treat_cardmsg;
     $termscondt = $data[0]->tl_addstore_termscondt;
     $service = $data[0]->tl_addstore_services; 
	   $button_text = 'Update';
     $pagename = 'EDIT STORE';
	 
	}
	else
    {
	    $updateid = '';
		$name = '';
		$lng = ''; 
	   $lat = '';
	   $logo = '';
     $address = '';
     $postcode = '';
	   $aboutmerchant = '';
     $termscondt = '';
     $service = '';
     $tl_addstore_treat_cardmsg = '';
	   $button_text = 'Submit';
     $pagename = 'ADD STORE';
	}
?>

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
      {{$pagename}}
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
              <input type="hidden" name="updateid" id="updateid" value="{{$updateid}}"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Store name</label>

                  <div class="col-sm-10">
                     <input type="text" id="store_name" class="form-control" name="store_name"  value="{{$name}}">
                  
                  </div>
                </div>
               
              </div>  
                       
              <div class="box-body tl-adminaddstoreedit">
                <div class="form-group logoerrormsg">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Store logo</label>
                  (Logo should be 500px min and 800px max in width)
                  <div class="col-sm-12 tl-adminchoosefile">
                     <input type="file" id="store_logo" onchange="uploadimg()" name="store_logo"> 
                     <span class="error-msg" id="errorMsg"></span>
                      <span class="error-msg" id="errorMessage"></span>                   
                     <span class="choose-file">Choose File</span>
                     <input type="hidden" id="image_name" name="image_name" value="">     
                      <input type="hidden" name="imagePath" id="imagePath" value="" >
                      <span id="error17" style="color:red"></span>
                  </div>
                </div>

                 <div class="form-group">
                    <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Image</label>  
                    <div class="col-sm-5">
                        <div class="tl-admin-chhoseimg" id="edit_image">
                          <?php if($logo!=''){ ?>
                             <img src="{{url('/public')}}/tl_admin/upload/storelogo/{{ $logo }}">    
                          <?php }else{ ?>
                            <img src="{{url('/public')}}/frontend/img/dummy_company_logo.png">  
                         <?php } ?>                   
                        </div>
                        <p class="package uploadedImage captonpic" id="imgTest"> </p>
                      </div>                   
                  </div>               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Store Address</label>

                  <div class="col-sm-10">
                     
                     <input type="text" id="searchInput" name="address"  class="form-control" value="{{$address}}" placeholder="Enter a location" >

             

                     <div class="map" id="map" style="width: 100%; height: 300px; display: none"></div>
                        <div class="form_area">
                            <input type="hidden" name="location"  value="{{$address}}" id="location">
                            <input type="hidden" name="lat" value="{{$lat}}" id="lat">
                            <input type="hidden" name="lng" value="{{$lng}}" id="lng">
                        </div>
                     <input type="hidden" name="userid" id="userid" value={{$segment}}>
                  </div>
                </div>
               
              </div>

              <div class="box-body">
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Post Code</label>
  
                    <div class="col-sm-10">
                    <input type="text" id="post_code" class="form-control" name="post_code" maxlength="10" onkeypress="return isNumberKey(event)" value="{{$postcode}}">
                    
                    </div>
                  </div>
                 
                </div>

                <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Service</label>

                  <div class="col-sm-10">
                     <input type="text" id="service" class="form-control" name="service"  value="{{$service}}">
                  
                  </div>
                </div>
               
              </div>  

                <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Message you want to show in your treat card</label>

                  <div class="col-sm-10">
                  <textarea name="treatcard_msg" id="treatcard_msg"  class="form-control" onkeyup="countChar(this);" placeholder="Write a message"><?php echo $tl_addstore_treat_cardmsg; ?></textarea>
                      <span class="tl-msg-text">
                        <p>Maximum character 200</p>
                        <p>Character left - <span id="countCharacter">200</span></p>
                   
                  </div>
                </div>
               
              </div>

               <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">About the merchant</label>

                  <div class="col-sm-10">
                    <textarea id="editor" name="editor" class="ckeditor"><?php echo $aboutmerchant; ?></textarea>
                     <input type="hidden" id="about_merchant" name="about_merchant" value="">
                   
                  </div>
                </div>
               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Terms & conditions</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $termscondt; ?></textarea>
                     <input type="hidden" id="termsconditiondesp" name="termsconditiondesp" value="">
                   
                  </div>
                </div>
               
              </div>
       
          

             

      
              
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" onclick="goBack()" class="btn btn-flat btn-danger">Go Back</a>
                <input type="submit" id="button_store" class="btn btn-flat btn-success pull-right" value="{{$button_text}}">
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

function countChar(val){
    var len = val.value.length;
      if(len>200){
        val.value = val.value.substring(0, 200);
          }else{
            $('#countCharacter').text(200 - len);
          }
  }

  function isNumberKey(evt)
        {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode > 31 && (charCode < 48 || charCode > 57))
              return false;

          return true;
        }
        
function addstore()
{

    var store_name = document.getElementById("store_name").value.trim();
    var service = document.getElementById("service").value.trim();
    var userid =document.getElementById("userid").value.trim();
    var store_logo =document.getElementById("store_logo").value.trim();
    var store_logo = $('#store_logo')[0].files[0];
    var location =document.getElementById("location").value.trim(); 
    var lat =document.getElementById("lat").value.trim(); 
    var lng =document.getElementById("lng").value.trim(); 	
    var post_code =document.getElementById("post_code").value.trim(); 	
  	var updateid =document.getElementById("updateid").value.trim();


  //  var about_merchant =document.getElementById("about_merchant").value.trim();   
    var termsdescription =CKEDITOR.instances.editor1.getData();  
    var about_merchant =CKEDITOR.instances.editor.getData();    
  var treatcard_msg = document.getElementById("treatcard_msg").value.trim();
         
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

       
      if(post_code=="")
        {
          document.getElementById('post_code').style.border='1px solid #ff0000';
          document.getElementById("post_code").focus();
          $('#post_code').val('');
        $('#post_code').attr("placeholder", "Please enter your post code");
          $("#post_code").addClass( "errors" );
          return false;
        }
        else
        {
          document.getElementById("post_code").style.border = "";   
        }  

         if(service=="")
        {
          document.getElementById('service').style.border='1px solid #ff0000';
          document.getElementById("service").focus();
          $('#service').val('');
        $('#service').attr("placeholder", "Please enter your service");
          $("#service").addClass( "errors" );
          return false;
        }
        else
        {
          document.getElementById("service").style.border = "";   
        }
        
         if(treatcard_msg=="")
      {
        document.getElementById('treatcard_msg').style.border='1px solid #ff0000';
        document.getElementById("treatcard_msg").focus();
        $('#treatcard_msg').val('');
      $('#treatcard_msg').attr("placeholder", "Please enter card message");
        $("#treatcard_msg").addClass( "errors" );
        return false;
      }
      else
      {
        document.getElementById("treatcard_msg").style.border = "";   
      }



  if(about_merchant=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter About Merchant" ; 
      return false;
    }
    else
    {
       $('#about_merchant').val(about_merchant);
        document.getElementById("errormsg").innerHTML="" ; 
        var about_merchant = document.getElementById('about_merchant').value.trim();
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

    document.getElementById("button_store").disabled = true;
  
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();   
       form.append('store_name', store_name);
       form.append('treatcard_msg', treatcard_msg);
       form.append('location', location);  
       form.append('lat', lat); 
       form.append('lng', lng); 
       form.append('post_code', post_code);
       form.append('about_merchant', about_merchant); 
       form.append('termsconditiondesp', termsconditiondesp); 
       form.append('store_logo', store_logo);   
       form.append('service', service);
       form.append('userid', userid); 
       form.append('updateid', updateid); 
       form.append('_token', _token);   


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/addstore')}}",
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
           document.getElementById("button_store").disabled = false;
         if(response.req_for=='add'){
          var path="{{url('/merchantmodule/addproduct/')}}";
          setTimeout(function() { window.location.href=path+'/'+{{$segment}}; }, 3000);
         }else if(response.req_for=='update'){
          setTimeout(function() { location.reload(true) }, 3000);
         }
      }
      else if(status=='401')
      {
        document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
           document.getElementById("button_store").disabled = false;
      }else{
          document.getElementById("button_store").disabled = false;
      }
      
    }

     });
     return false;
 
  }// end of function


var Image_64byte="";
  var filesSelected ="";
  function uploadimg() 
  {
     document.getElementById('error17').innerHTML="";
     var image_name =document.getElementById("image_name").value;
		
     if(image_name!="")
     {
		
       document.getElementById('edit_image').style.display='none';
     }
     
    //$("#hidetxt").css("display", "none");
      var e = document.getElementById("store_logo"),
          t = e.value,
          n = $("#store_logo")[0].files[0].size / 1024;
          if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("store_logo").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
         var m = document.getElementById("store_logo").value,
          m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
          m = m.replace(/[^a-zA-Z0-9]/g, "_");
         var l = m.split("_"),
        d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
        r = l[3] + "." + d;
    if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
    if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("store_logo").files, filesSelected.length > 0) {
        var g = filesSelected[0],
            a = new FileReader;
        a.onload = function(e) {
            var t = e.target.result,
                n = t.split(",");
            document.getElementById("imagePath").value = n[1];
            var m = document.createElement("img");

            m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
						document.getElementById('edit_image').style.display='none';
              
            }, a.readAsDataURL(g)
        }

        
        
      
    }
     

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

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyBz-LGvlIHTQoeJ1E7GMplSXzbFy1d6Qso&libraries=places"></script>

 

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