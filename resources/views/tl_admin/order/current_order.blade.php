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
          Current Orders
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Current Orders</li>
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
                  <th class="text-center">Order Ref No.</th>
                  <th class="text-center">Treat</th>
                  <th class="text-center">Subtotal</th>
                  <th class="text-center">Payment Mode</th>
                  <th class="text-center">Payment Status</th>
                  <th class="text-center">Status</th>   
                  <th class="text-center">Placed On</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php    
              $sn++;
              $userid = $data_val->userid;   
              $cart_uniqueid = $data_val->cart_uniqueid;    
              $store_id = $data_val->store_id;
              $tl_order_ref = $data_val->tl_order_ref;
                   $arr_ord = explode("_",$tl_order_ref);
                   $ref_ordernum = $arr_ord[1];
                   
              $tl_cart_subtotal = $data_val->tl_cart_subtotal;
              $tl_order_paymode = $data_val->tl_order_paymode;
              $tl_order_paystatus = $data_val->tl_order_paystatus;
              $tl_order_status = $data_val->tl_order_status;
              $tl_order_created_at = $data_val->tl_order_created_at;
              $createDate = new DateTime($tl_order_created_at);
              $placedon = $createDate->format('Y-m-d');

               $isexists_voucher = DB::table('tbl_tl_user_cart AS t1')
                                ->join('tbl_tl_product AS t2','t1.tl_product_id','t2.tl_product_id')->where('t1.cart_uniqueid',$cart_uniqueid)->where('t2.tl_product_type','Voucher')->select('t1.tl_product_id')->get();

              ?>
                 <tr>
                    <td><?php echo $sn; ?></td>
                    <td>{{ $ref_ordernum }}</td>   
                    <td>
                      
                    <a href="{{url('/ordermodule/current-order/view-treat')}}/{{$cart_uniqueid}}">  View Treat</a>
                   
                    </td> 
                    <td>{{ $tl_cart_subtotal }}</td>
                    
                    <td>{{ $tl_order_paymode }}</td>
                    <td>{{ $tl_order_paystatus }}</td>
                     
                    <td>{{ $tl_order_status }}</td>
                    <td> <?php echo $placedon; ?> </td>
                    <td class="tl-delflex">
                          <a href="javascript:void(0);" class="btn btn-block btn-danger btn-flat" onclick="return comp_order('<?php echo $cart_uniqueid; ?>')" >Complete this order</a>
      
                      </td>
                 </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

           <!-- Modal -->

          

                <!-- Modal -->

           <input type="hidden" id="rowidd" value="" name="rowidd" />
           <div id="completeorder" class="modal merchantlist-modal" role="dialog" >
             <div class="modal-dialog" style="width:340px !important">
             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to complete this order ?</h4>
              </div>            
               <div class="modal-body" style="text-align: center;">
               <button type="button" class="btn btn-danger btn-sx" onclick=" return complete()" >Complete</button>&nbsp;&nbsp;&nbsp;&nbsp;
               <button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
               </div>      
             </div>
             </div>
           </div>

              
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

<script language="javascript"> 

    function comp_order(rowid)
    {
        $("#rowidd").val(rowid);
        $("#completeorder").modal("show");
    }

     function complete(){
        var rowidd =$("#rowidd").val();
        $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url: "{{url('/completeorder')}}",
            data: { cartid: rowidd}

        })
        .done(function( response ) {
        console.log(response); //return false;
        $("#rowidd").val("");
        if(response.status=='200'){
            setTimeout(function() { location. reload(true); }, 2000);
        }
        });
        return false;
    }


      function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
      }

 </script>

@endsection