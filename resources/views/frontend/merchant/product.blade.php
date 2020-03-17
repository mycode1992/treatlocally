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
					<div class="tl-account-right">
						<div class="tl-account-right-title">Add Product/ Voucher</div>
						<!--<div class="supportLine">
							"If you'd like to get in touch about anything, please send us a message and we'll get back to you soon"
						</div> -->

						<div class="tl-account-right-form tlsupportForm">
							<form action="">
								<div class="">
									<div class="col-md-12 padL0">
										<label for="">
											<a href="{{url('/merchant/add_voucher')}}" class="hvr-sweep-to-right tl_addvaucher_btn">+ Add</a>
										</label>
									</div>
									<?php
  										if(count($data)<=0){ ?>
									<div class="noPrdctinfo">
										You Don't Have Added Any Product Yet.
									</div>
								    <?php } else { ?>
  									   
<!-- product-voucher-list-table-start -->
<div class="product-voucher-list-area">
	<div class="tl-account-right-title">Product/ Vaucher list</div>
	<div class="product-voucher-table">
		<div class="table-responsive">          
		  <table class="table">
			<thead>
			  <tr>
				<th>S.No</th>
				<th>Image</th>
				<th>Product Name</th>
				<th>Treat Type</th>
				<th>Action</th>
			  </tr>
			</thead>
			<tbody>
				<?php $sn = 0 ;?>
				@foreach($data AS $data_val)
				 <?php 
						 $sn++; 
						 $treat_type = DB::table('_treat_type')->where('id',$data_val->tl_product_treat_type)->select('name')->get();
				
				?>
						<tr id="deleterow<?php echo $data_val->tl_product_id;?>">
						<td>{{$sn}}</td>
						<td><div class="voucher-table-img"><img src="{{url('/')}}/public/tl_admin/upload/merchantmod/product/{{$data_val->tl_product_image1}}"
							 alt="" class="img-responsive" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$data_val->tl_product_image1";?>');"></div></td>
						<td>{{$data_val->tl_product_name}}</td>
						<td>{{$treat_type[0]->name}}</td>
						<td>
							<div class="table-action-icon">
									<input type="hidden" name="_token" value="{{ csrf_token()}}">
								<span><a href="javascript:void(0);" onclick="return viewproductdetail(<?php echo $data_val->tl_product_id; ?>)"><img src="{{url('/public')}}/frontend/img/view.png" alt="" class="img-responsive"></a></span>
								<span><a href="javascript:void(0);" onclick=" return deletebtnrow(<?php echo $data_val->tl_product_id; ?>)"><img src="{{url('/public')}}/frontend/img/delete.png" alt="" class="img-responsive"></a></span>
								<span><a href="{{url('/merchant/add_voucher')}}/{{$data_val->tl_product_id}}"><img src="{{url('/public')}}/frontend/img/edit.png" alt="" class="img-responsive"></a></span>
							</div>
						</td>
			
						</tr>
						@endforeach	
			</tbody>
		  </table>
		  </div>
	</div>
</div>
<!-- product-voucher-list-table-end -->
<?php  } ?>
<!-- Modal -->

<div class="modal merchantlist-modal" id="myModal" role="dialog">
		<div class="modal-dialog">
		
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
				
				<div class="modal-body">
					<p id="readmoremsg"></p>
				</div>
			</div>
			
		</div>
	</div>

{{-- product detail --}}
	<div class="modal merchantlist-modal" id="pro_detail_modal" role="dialog">
		<div class="modal-dialog">
		
			<!-- Modal content-->
			<div class="modal-content">
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		    </div>
				
				<div class="modal-body">
					<p id="pro_detail_para">
						  <h1 class="tl-adheading">Product Info</h1>
						  <div id="pro_detail_paragraph">

						  </div>
					</p>
				</div>
			</div>
			
		</div>
	</div>

	 <!-- Modal -->
	 <input type="hidden" id="rowidd" value="" name="rowidd" />
	 <div id="deletebtn" class="modal merchantlist-modal" role="dialog" >
	   <div class="modal-dialog" style="width:340px !important">
		 <!-- Modal content-->
		 <div class="modal-content">
		   <div class="modal-header">
			  <h4 class="modal-title">Are you sure you want to delete ?</h4>
			</div>            
		   <div class="modal-body" style="text-align: center;">
			 <button type="button" class="btn btn-danger btn-sx" onclick=" return deleterow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
			 <button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
		   </div>      
		 </div>
	   </div>
	 </div>
	 <!-- Modal -->    

									<div class="clearfix"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</section>

<!-- about-end -->
<script language="javascript"> 

  function viewproductdetail(productid)
  {
    var _token = $('input[name=_token]').val();
    $.ajax({
		  method: "POST",
		  url:"{{url('/viewproductdetail')}}",
		  data: { productid:productid,_token:_token }

		})
    .done(function( msg ) {
           console.log(msg); //return false;
           $("#pro_detail_paragraph").html(msg);
           $('#pro_detail_modal').modal('show');
      
	


		   });
  }

  function deletebtnrow(rowid)
{
  
 $("#rowidd").val(rowid);
$("#deletebtn").modal("show");
}

  function deleterow(){
  
  // var snum =$("#snum").val();
  var _token = $('input[name=_token]').val();
  var rowidd =$("#rowidd").val();
   $.ajax({
  method: "POST",
  url: "{{url('/deleteproduct')}}",
  data: { id: rowidd,_token:_token}
 
  })
 .done(function( response ) {
   console.log(response); //return false;
   $("#rowidd").val("");
  //console.log(response.msg);
  $("#deleterow"+rowidd).css("display","none");
  //$('.modal-backdrop.in').css('opacity', '0');
  //$("#deletebtn").css("display","none");
  $("#cancelbutton").click();
  });
 return false;
 }

		function openImgModal(path)
		{
			// alert('edfgr'+path);
			// return false;
			// document.getElementbyId('responseMsg').innerHTML="asdsadsad";
			$("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
			$('#myModal').modal('show');
		}
</script>		
 @endsection