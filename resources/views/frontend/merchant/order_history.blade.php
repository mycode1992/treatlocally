@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

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
					<div class="tl-account-right ">
						<div class="order-history-container">
							<div class="tl-account-right-title">Order History</div>
								
							</div>
						
						
						<!-- product-voucher-list-table-start -->
						<div class="product-voucher-list-area">
							<div class="tl_treathistory">
								<ul class="nav nav-pills">
								    <li class="active"><a data-toggle="pill" href="#recent">Recent Order</a></li>
								    <li><a data-toggle="pill" href="#past">Past Order</a></li>
								</ul>

								<div class="tab-content">
									<div id="recent" class="tab-pane fade in active">
										<div class="product-voucher-table">
											<div class="table-responsive">          
											  <table id="example" class="table">
											    <thead>
											      <tr>
														<th>S.No</th>
														<th>Order Ref No.</th>
														<th>Treat</th>
														<th>Subtotal</th>
														<th>Payment Mode</th>
														<th>Payment Status</th>
														<th>Status</th>   
														<th>Placed On</th>
														<!-- <th>Action</th> -->
											      </tr>
											    </thead>
											    <tbody>

														<?php
														$sn = 0;
													?>
															 @foreach($current_order AS $current_order_val)
																	 <?php 
																	 $sn++;   
																	 $cart_uniqueid = $current_order_val->cart_uniqueid;
																	 $userid = $current_order_val->userid; 
																	 $store_id = $current_order_val->store_id;
																	 $tl_order_ref = $current_order_val->tl_order_ref;
																				$arr_ord = explode("_",$tl_order_ref);
																				$ref_ordernum = $arr_ord[1];
										 
																	 $tl_cart_subtotal = $current_order_val->tl_cart_subtotal;
																	 $tl_order_paymode = $current_order_val->tl_order_paymode;
																	 $tl_order_paystatus = $current_order_val->tl_order_paystatus;
																	 $tl_order_status = $current_order_val->tl_order_status; 
																	 $tl_order_created_at = $current_order_val->tl_order_created_at;
																	 $createDate = new DateTime($tl_order_created_at);
																	 $placedon = $createDate->format('Y-m-d');
																	  							 
																	 ?>

								 <tr>
											         <td><?php echo $sn; ?></td>
								        <td>{{ $ref_ordernum }}</td>
										<td>
											<a href="{{url('/merchant/current-order/view-treat')}}/{{$cart_uniqueid}}">  View Treat</a>
											</td> 
										<td>{{ $tl_cart_subtotal }}</td>
										
								        <td>
														{{ $tl_order_paymode }}
								        </td>
								        <td>
														{{ $tl_order_paystatus }}
										</td>
										
										<td>{{ $tl_order_status }}</td>
										<td>{{ $placedon }}</td>
										
											        
								 </tr>	     
								 @endforeach  
										</tbody>
										</table>
										</div>
								</div>
							</div>
									<div id="past" class="tab-pane fade">
										<div class="product-voucher-table">
											<div class="table-responsive">          
											  <table id="example1" class="table">
											    <thead>
											      <tr>
														<th>S.No</th>
														<th>Order Ref No.</th>
														<th>Treat</th>
														<th>Subtotal</th>
														<th>Payment Mode</th>
														<th>Payment Status</th>
														<th>Status</th>   
														<th>Placed On</th>
											      </tr>
											    </thead>
											    <tbody>
														<?php
														$sn = 0;
													  ?>
														   @foreach($completet_order AS $data_val)
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

															   if ($tl_order_status=='DELIVERED') {
															     $tl_order_status = 'SENT';
															   }
															   
															   ?>
											      <tr>
											        <td><?php echo $sn; ?></td>
											        <td>{{ $ref_ordernum }}</td>
											        <td><a href="{{url('/merchant/complete-order/view-treat')}}/{{$cart_uniqueid}}">View Treat</a></td>
											        <td>{{ $tl_cart_subtotal }}</td>
											        <td>{{ $tl_order_paymode }}</td>
											        <td>{{ $tl_order_paystatus }} </td>
													<td>{{ $tl_order_status}} </td>
													<td> <?php echo $placedon; ?>  </td>
												  </tr>
											@endforeach
											    </tbody>
											  </table>
											  </div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- product-voucher-list-table-end -->
					
					</div>
				</div>
			</div>
		</div>
	</div>

	 <!-- Modal -->

	 <div class="modal tl-redeem" id="myModal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				  <form action="#" onsubmit="return partialreedeem();">
				<div class="modal-body">
				 
				  <p id="readmoremsg">
				  <div> Rest Voucher Amount : <span id="restprice">100</span></div>
					<div>
					  <input type="hidden" name="rest_amt" id="rest_amt" value="">
					  <input type="hidden" name="userid" id="userid" value="">
					  <input type="hidden" name="order_ref" id="order_ref" value="">
					  <input type="hidden" name="store_id" id="store_id" value="">
					  <input type="text" name="reedeem_amt" onkeypress="return isNumberKey(event)" id="reedeem_amt">
					</div>
				  </p>
				</div>
				<div class="modal-footer">
					<div id="erroramt"></div>
					<button type="submit" class="btn btn-default tl-redeembtn">Reedeem</button>
				
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </form>
			  </div>
			  
			</div>
		  </div>

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

</section>

<!-- about-end -->
   <script  language="javascript">
		function comp_order(rowid)
	   {
		   $("#rowidd").val(rowid);
		   $("#completeorder").modal("show");
	   }

	    function partialreedeem(){
           var reedeem_amt = document.getElementById("reedeem_amt").value.trim();
           var rest_amt = document.getElementById("rest_amt").value.trim();
           var userid = document.getElementById("userid").value.trim();
           var order_ref = document.getElementById("order_ref").value.trim();
           var store_id = document.getElementById("store_id").value.trim();
           

            if(reedeem_amt == "")
              {
                
                document.getElementById('reedeem_amt').style.border='1px solid #ff0000';
                document.getElementById("reedeem_amt").focus();
                $('#reedeem_amt').val('');
                $('#reedeem_amt').attr("placeholder", "Please enter amount");
                $("#reedeem_amt").addClass( "errors" );
                return false;
              }
              else
                {
                  
                  $('#reedeem_amt').attr("placeholder", "");
                  document.getElementById('reedeem_amt').style.border='';
                }

             $('#erroramt').text('Please wait...');

            if(rest_amt>=reedeem_amt)
              {
               // console.log(reedeem_amt);  return false;
                $.ajax({
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                method: "POST",
                url: "{{url('/merchant/partial_reedeem')}}",
                data: { reedeem_amt:reedeem_amt,rest_amt:rest_amt,userid:userid,order_ref:order_ref,store_id:store_id}

                })
                .done(function(response) {
                console.log(response); //return false;
               
                  if(response.status=='200'){
                        setTimeout(function() { location. reload(true); }, 2000);
                    }
                
                 else if(response.status=='402'){
                  $('#erroramt').text('Amount should be less or equal to voucher amount.');
                 }
                 else if(response.status=='401'){
                  $('#erroramt').text(response.msg);
                 }
                   
                });
                }
            else
            {
              $('#erroramt').text('');
              $('#erroramt').text('Amount should be less or equal to voucher amount.');
            }


         
            return false;
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

	 function openReedeem(restprice,userid,order_ref,store_id)
        {   
          $('#restprice').text(restprice);
          $('#rest_amt').val(restprice);
          $('#userid').val(userid);
          $('#order_ref').val(order_ref);
          $('#store_id').val(store_id);
         
            $('#myModal').modal('show');
        }
	
   </script>

 @endsection