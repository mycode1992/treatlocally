@extends('tl_admin.layouts.frontlayouts')

@section('content')
<?php
$segment = Request::segment(3);

?>
 <?php
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
                  <th class="text-center">Order Ref No.</th>
                  <th class="text-center">Treat</th>
                  <th class="text-center">Subtotal</th>
                  <th class="text-center">Payment Mode</th>
                  <th class="text-center">Payment Status</th>
                  <th class="text-center">Status</th>   
                  <th class="text-center">Placed On</th>
                
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

                 if($tl_order_status=='DELIVERED'){
                    $tl_order_status='SENT';
                 }
              
              ?>
                 <tr>
                    <td><?php echo $sn; ?></td>
                    <td>{{ $ref_ordernum }}</td>   
                    <td>
                        
                    <a href="{{url('/ordermodule/complete-order/view-treat')}}/{{$cart_uniqueid}}">  View Detail</a>
                    </td> 
                    <td>{{ $tl_cart_subtotal }}</td>
                    <td>{{ $tl_order_paymode }}</td>
                    <td>{{ $tl_order_paystatus }}</td>
                    <td>{{ $tl_order_status }}</td>
                    <td> <?php echo $placedon; ?> </td>
                   
                 </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

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

               
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

@endsection