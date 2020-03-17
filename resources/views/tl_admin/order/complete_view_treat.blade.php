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
  $user = DB::table('users')->where('userid',$segment)->select('name')->get();
  $user = json_decode(json_encode($user), True);
?>
<section class="content-header">
      <h1>
          Complete Orders
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Complete Orders</li>
      </ol>
    </section>

<section class="content">
  <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
   

   <table id="example" class="table">
                <thead>
                <tr>
                  <th class="text-center">S.No.</th>
                  <th class="text-center">Voucher Ref No.</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Description</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Card Info</th>
                   <th class="text-center">Delivery Address</th> 
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($treat AS $treat_val)     
              <?php    
              $sn++;
              $cart_id = $treat_val->cart_id;   
              $cart_uniqueid = $treat_val->cart_uniqueid;   
              $tl_product_id = $treat_val->tl_product_id;   
              $store_id = $treat_val->store_id;
              $userid = $treat_val->userid; 
              $tl_product_name = $treat_val->tl_product_name;   
              $tl_product_image1 = $treat_val->tl_product_image1;    
              $tl_product_description = $treat_val->tl_product_description;
              $tl_product_price = $treat_val->tl_product_price;
              $tl_cart_voucher = $treat_val->tl_cart_voucher;
              $tl_cart_partial_reedeem = $treat_val->tl_cart_partial_reedeem;
              $arr_voucher = explode("_",$tl_cart_voucher);
                   $ref_voucher = $arr_voucher[1];

             
              ?>
                 <tr>
                    <td><?php echo $sn; ?></td>
                    <td>{{ $ref_voucher }}</td>   
                   
                    <td>{{ $tl_product_name }}</td>
                    
                    <td class="tl-merchantimg view-treat-img"> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $tl_product_image1 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$tl_product_image1";?>');" style="width:100px"></td>
                    <td>
                      <?php 
                       
                        $string = $tl_product_description;
                          if (strlen($string) > 100) {
                          $stringCut = substr($string, 0, 100);
                          $endPoint = strrpos($stringCut, ' ');
                      
                          //if the string doesn't contain any space then it will cut without word basis.
                          $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                          $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$cart_id.')">Read More</a>';
                         }
                         echo $string;
                      ?>
                    </td>
                    <td>{{ $tl_product_price }}</td>
                      <td>
                       
                        <a href="{{url('/ordermodule/view-card')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">View Card</a>
                      </td>
                      <td><a href="{{url('/ordermodule/delivery-address')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">Delivery Address</a></td>
                  
                 </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

           <!-- Modal -->

          

                <!-- Modal -->

                <div class="modal" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        
                        <div class="modal-body">
                          <p id="readmoremsg"></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      
                    </div>
                  </div>

                
    
                    <!-- Modal -->
    
             
              
    
                  
                
                <!-- /.box-body -->
              </div>
    

     
              
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

<script language="javascript"> 

  function openImgModal(path)
  {
   
    $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
    $('#myModal').modal('show');
  }

  function readmore(id)
    {
      
        var tblname='tbl_tl_user_cart';
            var colnamewhere = 'cart_id';
            var colmsg = 'tl_product_description';
            var _token = $('input[name=_token]').val();
        

          $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url:"{{url('/readmore')}}",
            data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}
           })
          .done(function( response ) {
             // console.log(response);
             //  console.log(response); 
          
          document.getElementById("readmoremsg").innerHTML = response;
            $('#myModal').modal('show');

        });
      
    }

 </script>

@endsection