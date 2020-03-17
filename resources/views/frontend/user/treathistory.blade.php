@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->



<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">My Account</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
				@include('frontend.common.user_sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
						<div class="tl-account-right-title text-uppercase">Treat History</div>						
						<div class="tl-treat-boxes">
							{{-- <div class="tl-recent-filter">
								<form action="">
									<button><i class="fa fa-filter" aria-hidden="true"></i></button>
									<label for="">
										<input type="text" placeholder="Search" class="form-control">
										<button><i class="fa fa-search" aria-hidden="true"></i></button>
									</label>
								</form>
							</div> --}}
							<div class="tl_treathistory">
								<ul class="nav nav-pills">
								    <li class="active"><a data-toggle="pill" href="#recent">Recent Treat</a></li>
								    <li><a data-toggle="pill" href="#past">Past Treat</a></li>
								</ul>

								<div class="tab-content">
								    <div id="recent" class="tab-pane fade in active">
								      <div class="tl-recent-treat">
										<div class="tl-recent-title">
											Recent Treat
										</div>
									  </div>
									<div class="tl-treat-table">
										<table id="example"  class="table table-responsive">
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
															 @foreach($current_order AS $current_order_val)
																	 <?php 
																	 $sn++;   
																	 $cart_uniqueid = $current_order_val->cart_uniqueid;
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
																	  if ($tl_order_status=='DELIVERED') {
																		     $tl_order_status = 'SENT';
																		    }
																	 
																	 ?>
										      <tr>
															<td><?php echo $sn; ?></td>
										        <td><div class="tl-orderno">{{ $ref_ordernum }}</div></td>
										        <td>
																<a href="{{url('/user/current-order/view-detail')}}/{{$cart_uniqueid}}">  View Detail</a>
														</td>
														<td>{{ $tl_cart_subtotal }}</td>
														<td>
																{{ $tl_order_paymode }}
														</td>
														<td>
																{{ $tl_order_paystatus }}
														</td>
														<td> {{$tl_order_status}} </td>
														<td>{{ $placedon }}</td>
													</tr>
													@endforeach  
										    </tbody>
										  </table>
										</div>
								    </div>
								    <div id="past" class="tab-pane fade">
								      <div class="tl-treat-table">
										<div class="tl-table-title">Past Treat</div>
										<table id="example1" class="table table-responsive">
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
															   
																 ?>
																 <tr>
																 <td><?php echo $sn; ?></td>
																 <td><div class="tl-orderno">{{ $ref_ordernum }}</div></td>
																 <td>
																		 <a href="{{url('/user/current-order/view-detail')}}/{{$cart_uniqueid}}">  View Detail</a>
																 </td>
																 <td>{{ $tl_cart_subtotal }}</td>
																 <td>
																		 {{ $tl_order_paymode }}
																 </td>
																 <td>
																		 {{ $tl_order_paystatus }}
																 </td>
																 <td> {{$tl_order_status}} </td>
																 <td>{{ $placedon }}</td>
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
				</div>
			</div>
		</div>
	</div>


</section>

<!-- about-end -->

 @endsection