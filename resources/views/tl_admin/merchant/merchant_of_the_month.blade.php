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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk91uYra2cpd-phW1kVp2urGmbzBYWvcI&libraries=places"></script>

<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
              
<?php
  $segment = Request::segment(3);

	   if(isset($data) && count($data)>0)
	{
	   $tl_addstore_name = $data[0]->tl_addstore_name;  
	   $tl_addstore_logo = $data[0]->tl_addstore_logo; 
	   $tl_addstore_address = $data[0]->tl_addstore_address; 
	   $tl_addstore_aboutmerchant = $data[0]->tl_addstore_aboutmerchant; 
	   $tl_addstore_services = $data[0]->tl_addstore_services;
     $merchant_userid = $merchant_userid[0]->merchant_userid;
	}
	else
    {
	    $tl_addstore_name = '';  
     $tl_addstore_logo = ''; 
     $tl_addstore_address = ''; 
     $tl_addstore_aboutmerchant = ''; 
     $tl_addstore_services = '';
	}
?>

  <div class="content-wrapper tl-admin-about">
   
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

               <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Merchant of the month</label>

                  <div class="col-sm-10">
                     <select id="merc_month" name="merc_month" onchange="return storelist();" >
                        <option value="-1">Please Select</option>
                        <?php $store =    DB::table('tbl_tl_addstore')->join('users','users.userid','tbl_tl_addstore.userid')
                                          ->select('tbl_tl_addstore.userid','tl_addstore_name')->where('tl_addstore_status','1')->where('users.status','1')->get();
                        ?>
                        @foreach($store AS $store_val)
                        <option value="{{$store_val->userid}}" <?php if($merchant_userid==$store_val->userid){echo 'selected';} ?> >{{$store_val->tl_addstore_name}}</option>
                        @endforeach
                     </select>
                  
                  </div>
                </div>

           
             
            
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Store name</label>

                  <div class="col-sm-10">
                     <input type="text" id="store_name" readonly class="form-control" name="store_name"  value="{{$tl_addstore_name}}">
                  
                  </div>
                </div>
               
              </div>  
                       
              <div class="box-body tl-adminaddstoreedit">
                <div class="form-group logoerrormsg">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Store logo</label>
                </div>

                 <div class="form-group">
                    <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Image</label>  
                    <div class="col-sm-5">
                        <div class="tl-admin-chhoseimg" id="edit_image">
                         
                             <img id="img" src="{{url('/public')}}/tl_admin/upload/storelogo/{{ $tl_addstore_logo }}">    
                              
                        </div>
                      
                      </div>                   
                  </div>               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Store Address</label>

                  <div class="col-sm-10">
                     <input type="text" value="{{$tl_addstore_address}}" id="searchInput" name="address" readonly class="form-control">
                  </div>
                </div>
               
              </div>

             
                <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Service</label>

                  <div class="col-sm-10">
                     <input type="text" id="service" class="form-control" readonly name="service"  value="{{$tl_addstore_services}}">
                  
                  </div>
                </div>
               
              </div>  

               <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">About the merchant</label>

                  <div class="col-sm-10">
                    <div id="editor"><?php echo $tl_addstore_aboutmerchant; ?></div>
                     <input type="hidden" id="about_merchant" name="about_merchant" value="">
                   
                  </div>
                </div>
               
              </div>
              
            

          <div class="col-md-1"></div>

        
        
        
      </div><!-- end of row -->
    </section>
  
    <!-- /.content -->
  </div>

  <script type="text/javascript">
      function storelist()
                {
                  var merc_month = document.getElementById("merc_month").value;
                      if(merc_month=='-1')
                      {
                        document.getElementById('merc_month').style.border='1px solid #ff0000';
                        document.getElementById("merc_month").focus();
                        return false;
                      }
                      else
                      {
                         document.getElementById('merc_month').style.border=' ';
                      }

                    $.ajax({    
                        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                        type: 'POST',
                        url: "{{url('/merchantmodule/save_merc_month')}}",
                        data:{merc_month:merc_month},
                       
                        success:function(response) 
                        {
                           console.log(response); 
                            var tl_addstore_name = response.msg[0].tl_addstore_name; 
                            var tl_addstore_logo = response.msg[0].tl_addstore_logo; 
                            var tl_addstore_address = response.msg[0].tl_addstore_address; 
                            var tl_addstore_aboutmerchant = response.msg[0].tl_addstore_aboutmerchant; 
                            var tl_addstore_services = response.msg[0].tl_addstore_services; 
                            var status = response.status; 
                            var base_url = '{{url('/public')}}';      
                              
                            
                            if(status=='200')
                            {
                                document.getElementById("img").src = base_url+"/tl_admin/upload/storelogo/"+tl_addstore_logo;
                               document.getElementById("store_name").value = tl_addstore_name;
                               document.getElementById("searchInput").value = tl_addstore_address;
                               document.getElementById("service").value = tl_addstore_services;
                               document.getElementById("editor").innerHTML = tl_addstore_aboutmerchant;
                             
                            }
                           
                      
                        }
                  
                       });
                  return false;
                }
  </script>
 

@endsection