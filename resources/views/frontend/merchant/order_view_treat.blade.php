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
								<div class="tab-content">
									<div id="recent" class="tab-pane fade in active">
										<div class="product-voucher-table">
											<div class="table-responsive">          
											  <table id="example" class="table">
											    <thead>
											      <tr>
														<th>S.No.</th>
														<th>Voucher Ref No.</th>
														<th>Name</th>
														<th>Image</th>
														<th>Description</th>
														<th>Price</th>
														<th>Rest Amount</th>
														<th>Partial Redeem</th>
														 <th>Delivery Address</th> 
														<!-- <th>Action</th> -->
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
			
						$isexists_voucher = DB::table('tbl_tl_product')->where('tl_product_id',$tl_product_id)->where('tl_product_type','Voucher')->select('tl_product_id','tl_product_type')->get();
				
						if($tl_cart_partial_reedeem===null){
								$restamt = $tl_product_price;
							}else if($tl_cart_partial_reedeem!=null){
								$restamt = $tl_cart_partial_reedeem;
							}else if($tl_cart_partial_reedeem===0.00){
							
								$restamt = $tl_cart_partial_reedeem;
							}
						?>

								 <tr>
										<td><?php echo $sn; ?></td>
										<td>{{ $ref_voucher }}</td>   
									   
										<td>{{ $tl_product_name }}</td>
										
										<td class="tl-merchantimg"> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $tl_product_image1 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$tl_product_image1";?>');" style="width:100px"></td>
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
										<td> <?php if(count($isexists_voucher)<=0){ echo 'N/A';}else{ echo $restamt; } 
										?></td>
										 <td>
										  <?php 
											  if( count($isexists_voucher) && $tl_cart_partial_reedeem!==0.00){
										   ?> 
											 <a href="javascript:void(0)" onclick="openReedeem({{$tl_product_id}},{{$cart_id}},{{$store_id}},{{$restamt}},{{$userid}});">Redeem </a> </td>
										  <?php }
											  else{ echo 'N/A'; } 
										  ?>
										 
										 
										  <td><a href="{{url('/merchant/delivery-address')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">Delivery Address</a></td>
										   
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

	 <div class="modal modalindex" id="Reedeemmodal" role="dialog">
			<div class="modal-dialog">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				  <form action="#" onsubmit="return partialreedeem();">
				<div class="modal-body">
				 
				  <p id="readmoremsg">
				  <div> Rest Voucher Amount : <span id="restprice">100</span></div>
					<div>
					  <input type="hidden" name="tl_product_id" id="tl_product_id" value="">
					  <input type="hidden" name="rest_amt" id="rest_amt" value="">
					  <input type="hidden" name="userid" id="userid" value="">
					  <input type="hidden" name="cart_id" id="cart_id" value="">
					  <input type="hidden" name="store_id" id="store_id" value="">
					  <input type="text" name="reedeem_amt" onkeypress="return isNumberKey(event)" id="reedeem_amt">
					</div>
				  </p>
				</div>
				<div class="modal-footer">
					<div id="erroramt"></div>
					<button type="submit" class="btn btn-default">Reedeem</button>
				
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </form>
			  </div>
			  
			</div>
		  </div>

		  <div class="modal modalindex" id="myModal1" role="dialog">
				<div class="modal-dialog">
				
				  <!-- Modal content-->
				  <div class="modal-content">
					
					<div class="modal-body">
					  <p id="readmoremsg1"></p>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
				  
				</div>
			  </div>

			<!-- Modal -->
</section>

<!-- about-end -->
   <script  language="javascript">

	    function openImgModal(path)
  { 
    $("#readmoremsg1").html("<img src='"+path+"' style='width: 100%;'>");
    $('#myModal1').modal('show');
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
          
          document.getElementById("readmoremsg1").innerHTML = response;
            $('#myModal1').modal('show');

        });
      
    }
		
	function partialreedeem(){  

var tl_product_id = parseInt(document.getElementById("tl_product_id").value.trim());
var reedeem_amt = parseInt(document.getElementById("reedeem_amt").value.trim());
var rest_amt = parseInt(document.getElementById("rest_amt").value.trim());
var userid = document.getElementById("userid").value.trim();
var cart_id = document.getElementById("cart_id").value.trim();
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

   //  console.log(rest_amt); console.log('vbdfg'+reedeem_amt);//  return false;

      if(rest_amt>=reedeem_amt)
        {
          // console.log(reedeem_amt);  return false;
          $.ajax({
          headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
          method: "POST",
          url: "{{url('/merchant/partial_reedeem')}}",
          data: { reedeem_amt:reedeem_amt,rest_amt:rest_amt,userid:userid,cart_id:cart_id,store_id:store_id,tl_product_id:tl_product_id}

          })
          .done(function(response) {
          console.log(response); //return false;
          $('#erroramt').text('');
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

	   
	   function openReedeem(productid,cart_id,store_id,restprice,userid)
        {     
              if(userid==null){
                userid = 'GUEST';
              }

          $('#restprice').text(restprice);
          $('#rest_amt').val(restprice);
          $('#tl_product_id').val(productid);
          $('#userid').val(userid);
          $('#cart_id').val(cart_id);
          $('#store_id').val(store_id);
         
            $('#Reedeemmodal').modal('show');
        }
	
   </script>
<style type="text/css">
	.modalindex {
		z-index: 9999;
	}
</style>
 @endsection