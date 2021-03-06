@extends('frontend.layouts.frontlayout')

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

<section class="tl-contact tl-terms">
  <div class="tl-contact-banner">
    <div class="tl-parallax" style="background-image: url({{url('/public')}}/frontend/img/aboutus_header.jpg);"></div>
    
    <?php 
         $postageprice = DB::table('tbl_postage_packaging')->select('postage_packaging_cost')->where('id','1')->get();
    ?>
    <div class="tl-caption-title">

      <div class="tl-title wow fadeIn" data-wow-delay="0.3s"> Review Your Order</div>
       <div class="col-xs-12">
            <div class="row ">
              <div class="tl-steptostep container">
                <div class="tl-step-flexbox">
                  <div class="tl-step-cols active"><a href="{{url('/')}}">Choose Your Treat</a></div>
                  <div class="tl-step-mobile"><a href="{{url('/')}}">1</a></div>
                  <div id="review_treat1" class="tl-step-cols <?php if(!empty($_SESSION["shopping_cart"])){echo 'active';}?>"><a href="{{url('/review_treat')}}">Review Your Treat</a></div>
                  <div class="tl-step-mobile"> <a href="{{url('/review_treat')}}"> 2 </a></div>
                  <div class="tl-step-cols"><a href="javascript:void(0)">Review And Payment</a></div>
                  <div class="tl-step-mobile"><a href="javascript:void(0)">4</a></div>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
</section>
<div class="container">

 
   <div class="tl-formsearch-btn">
        <a href="#" class="hvr-sweep-to-right goback_navi" onclick="javascript:history.go(-1)">Go back</a>
      </div>
     <div class="clearfix"></div>
</div>



  
<!-- table-start -->
<div class="container" id="main_container">


<!-- review-cart-main-start -->
<?php
if(!empty($_SESSION["shopping_cart"]))
{
   if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){ 
      $is_any_addr =  DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->count();
             }
              $totalorder = 0;
              $num = 0;
              foreach($_SESSION["shopping_cart"] as $keys => $values)
              {
                $num++;
                $totalorder = $totalorder + $values["item_price"] + $postageprice[0]->postage_packaging_cost;

                if($num > 1)
                {
                  $class_inactive = "style=display:none";
                }
                else
                {
                  $class_inactive = "";
                }
  ?>
    <div class="tl-review-cart-main" >
    <div class="tl-review-cart-cols deleterow1<?php echo $values["item_id"];?>">
        <div class="col-sm-12 col-md-2 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Treat in Cart</div>

          <div class="tl-cart-colsdiv">
            <div class="tl-cart-img">
              <img src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{$values["item_image"]}}" alt="" class="img-responsive" alt="" class="img-responsive">
            </div>

            <!-- remove-cart-start -->

            <div class="tl-deletetreat tl-deletetreatx tl-deletetreatx-mob">

                <?php 
                  if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){
                  
                    $is_treat_personalise = DB::table('tbl_tl_card')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->select('card_id')->get();

                     $is_add_edit_addr =  DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->get();
                  
                    if(count($is_treat_personalise)>0 || count($is_add_edit_addr)>0){  
                ?>
                <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>); deletecart_card_item(<?php echo $values["item_id"]; ?>,'<?php echo  $_SESSION["cartuniqueid"]; ?>');"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
                <?php }else{ ?>
                    <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
               <?php }}else{?>
                  <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
                <?php } ?>



                <!-- <a href="javascript:void(0)" onclick="remove_cart_item1(12)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a> -->
            </div>
            
            <!-- remove-cart-end -->
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Treat Description</div>

          <div class="tl-cart-colsdiv">
            <p class="tl-subtitle"><?php echo $values["item_storename"]; ?></p>
            <p class="tl-subtitle"><?php echo $values["item_name"]; ?></p>
            <p> <?php $string = $values["item_description"];
                   if (strlen($string) > 150) {
                    $stringCut = substr($string, 0, 150);
                    $endPoint = strrpos($stringCut, ' ');
                    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                    $string .= '...';
                }
                echo $string;  ?></p>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Personalise the Treat/Gift Card</div>

          <div class="tl-cart-colsdiv">
            <div class="tl-maketreat-btn">                                  
               <?php 
                    if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){ 
                     $is_treat_personalise = DB::table('tbl_tl_card')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->select('card_id')->get();
                  
                     if(count($is_treat_personalise)>0){ 
                 ?>
                  <a href="{{url('/make_treat_personal')}}/{{$values["item_id"]}}" class="hvr-sweep-to-right">Edit</a> 
                <?php   } else{  ?>
                  <a href="{{url('/make_treat_personal')}}/{{$values["item_id"]}}" class="hvr-sweep-to-right">Make the treat personal</a>
                <?php  } } else{  ?>
                 
                    <a href="{{url('/make_treat_personal')}}/{{$values["item_id"]}}" class="hvr-sweep-to-right">Make the treat personal</a>
                  <?php } ?>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Add Address of the Treat Recipient</div>

          <div class="tl-cart-colsdiv">
            <div class="tl-maketreat-btn"> 

              <?php 
                
                if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){ 
                  $is_add_edit_addr =  DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->count();
              
              if($is_any_addr > 0)
              {
                if($is_add_edit_addr>0){   
              ?>
                <a href="javascript:void(0)"  onclick="showmodal(<?php  echo $values['item_id']; ?>)" class="hvr-sweep-to-right">Edit Address</a>
               
                <?php   } else{  ?>
                  <a href="javascript:void(0)"  onclick="showmodal(<?php  echo $values['item_id']; ?>)" class="hvr-sweep-to-right">Add Address</a>
                  <a href="javascript:void(0)"  onclick="useaddress(<?php  echo $values['item_id']; ?>,'<?php  echo $_SESSION["cartuniqueid"]; ?>')" class="hvr-sweep-to-right">Use same address</a>
               
                <?php  }
              }
              else { ?>
                <a href="javascript:void(0)"  onclick="showmodal(<?php  echo $values['item_id']; ?>)" class="hvr-sweep-to-right">Add Address</a>
             <?php }
                  } else{  ?>
                 
                  <a href="javascript:void(0)"  onclick='showmodal(<?php  echo $values["item_id"]; ?>)' class="hvr-sweep-to-right">Add Address</a>
                  <?php } ?>



                <!-- <a href="#" class="hvr-sweep-to-right" class="hvr-sweep-to-right">Add Address</a> -->
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-1 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Price</div>

          <div class="tl-cart-colsdiv">
            <p>£<?php echo $values["item_price"]; ?></p>
          </div>
        </div>

        <div class="col-sm-12 col-md-1 col-xs-12 pd0">
          <div class="title title{{$num}}" {{$class_inactive}} >Postage and Packaging</div>

          <div class="tl-cart-colsdiv">
            <p>£{{$postageprice[0]->postage_packaging_cost}}</p>
          </div>
        </div>

        <div class="col-sm-12 col-md-1 col-xs-12 pd0">
          <div class="title remove-title title{{$num}}" {{$class_inactive}} >Remove</div>

          <div class="tl-cart-colsdiv">
            <div class="tl-deletetreat tl-deletetreatx">

                <?php 
                  if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){
                  
                    $is_treat_personalise = DB::table('tbl_tl_card')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->select('card_id')->get();

                     $is_add_edit_addr =  DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$_SESSION["cartuniqueid"])->where('tl_product_id',$values["item_id"])->get();
                  
                    if(count($is_treat_personalise)>0 || count($is_add_edit_addr)>0){  
                ?>
                <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>); deletecart_card_item(<?php echo $values["item_id"]; ?>,'<?php echo  $_SESSION["cartuniqueid"]; ?>');"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
                <?php }else{ ?>
                    <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
               <?php }}else{?>
                  <a href="javascript:void(0)" onclick="remove_cart_item1(<?php echo $values["item_id"].','.$num; ?>)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a>
                <?php } ?>



                <!-- <a href="javascript:void(0)" onclick="remove_cart_item1(12)"><i class="fa fa-times cross-icon" aria-hidden="true"></i></a> -->
            </div>
          </div>
        </div>

    </div>
 <?php
              }// end of foreach
?>
<div class="deliver-treat-msg">
     <div class="tl-maketreat-btn">
                 
                  <div id="errormsg" style="font-size:14px;text-align: center;"></div>

                  <?php
                  if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"])){ ?>
                  <a href="#" onclick="return chkcartitem_ispersonalise('<?php echo $_SESSION["cartuniqueid"]; ?>')" class="hvr-sweep-to-right">Proceed To Checkout</a>
                  <?php }else{ ?>
                    <a href="#" onclick="return chkcartitem_ispersonalise('')" class="hvr-sweep-to-right">Proceed To Checkout</a>
                  <?php } ?>
                </div>

                 <div class="tl-deletetreat">
               <div class="tl-total">
                <div class="tl-ordered">Ordered Total  
                </div>
                <b>£<?php echo number_format((float)$totalorder, 2, '.', ''); ?> </b>
              </div>
            </div> 
    </div>
    <div class="deliver-treat-msg">
     Your treat will be delivered to your loved one via First Class post
    </div>
  </div>


<?php
}
else
{ 
  echo '<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>';
}
?>
     


<!-- review-cart-main-end -->

</div>
<!-- table-end -->

<!-- address-modal-end -->
<!-- modal-start -->
<!-- Modal -->
<div id="myModal" class="modal fade tl-flipmodal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-add-heading">Enter Name and Address of the Treat Recipient<p>
        <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <div class="tl-template-tabs">
         <div class="tl-payment-form" id="form_field">
         
        </div>
      </div>
    </div>  
  </div>
</div>
</div>

<div id="myModal1" class="modal fade tl-flipmodal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <div class="tl-template-tabs">
         <div class="tl-payment-form" id="form_field1">
         
        </div>
      </div>
    </div>  
  </div>
</div>
</div>

<!-- modal-end -->
<!-- address-modal-end -->

<script>

  function chkcartitem_ispersonalise(unique_cartid)
  {
    $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
        method: "POST",
        url: "{{url('/chkcartitem_ispersonalise')}}",
        data:{unique_cartid:unique_cartid}
        })
        .done(function( response ) {
        console.log(response); // return false;
         var status = response.status;
         var msg = response.msg;
         var cart_uniqueid = response.cart_uniqueid;

         if(status==200)
         {
            var path = '<?php echo url('/payment_mode'); ?>';
            window.location = path+'/'+cart_uniqueid;
         }
         else
         {
            document.getElementById("errormsg").style.color = "#ff0000";
          document.getElementById("errormsg").innerHTML=msg;
         }
        
        });
          return false;
  //  console.log(unique_cartid); return false;
  }

  function showmodal(productid){
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
        method: "POST",
        url: "{{url('/showmodal/addaddress')}}",
        data:{productid:productid}
        })
        .done(function( response ) {
        
     //   console.log(response); // return false;
       
        document.getElementById("form_field").innerHTML = response.msg;
          $('#myModal').modal('show');
        });
        }

  function useaddress(productid1,cartuniqueid){
      
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
        method: "POST",
        url: "{{url('/useaddress')}}",
        data:{cartuniqueid:cartuniqueid,productid1:productid1}
        })
        .done(function( response ) {
        //   console.log(response); // return false;
           
          
        document.getElementById("form_field1").innerHTML = response.msg;
          $('#myModal1').modal('show');
        });
        }


        function useanotheraddress(productid1,cartuniqueid,tl_recipient_name,tl_recipient_address,tl_recipient_city,tl_recipient_country,tl_recipient_postcode,tl_recipient_address2){
        $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
        method: "POST",
        url: "{{url('/useanotheraddress')}}",
        data:{cartuniqueid:cartuniqueid,productid1:productid1,tl_recipient_name:tl_recipient_name,tl_recipient_address:tl_recipient_address,tl_recipient_city:tl_recipient_city,tl_recipient_country:tl_recipient_country,tl_recipient_postcode:tl_recipient_postcode,tl_recipient_address2:tl_recipient_address2}
        })
        .done(function( response ) {
        
        //   console.log(response); // return false;
          
        document.getElementById("form_field1").innerHTML = response.msg;
          $('#myModal1').modal('show');
        });
        }       

  function recipient_form(){   
	
	var recipient_name = document.getElementById('recipient_name').value.trim(); 
	var productid = document.getElementById('productid').value.trim(); 
	var recipient_mobile = '';    
  var recipient_address = document.getElementById('recipient_address').value.trim();   
	var recipient_address2 = document.getElementById('recipient_address2').value.trim();   
	var recipient_city = document.getElementById('recipient_city').value.trim();   
	var recipient_country = document.getElementById('recipient_country').value.trim();   
	var recipient_postcode = document.getElementById('recipient_postcode').value.trim(); 
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	

	// var strUserEml=recipient_email.toLowerCase();
	 if(recipient_name == "")
  {
    document.getElementById('recipient_name').style.border='1px solid #ff0000';
    document.getElementById("recipient_name").focus();
    $('#recipient_name').val('');
    $('#recipient_name').attr("placeholder", "Please enter your full name");
    $("#recipient_name").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('recipient_name').style.border=' ';
  }
  if(recipient_address == "")
  {
    document.getElementById('recipient_address').style.border='1px solid #ff0000';
    document.getElementById("recipient_address").focus();
    $('#recipient_address').val('');
    $('#recipient_address').attr("placeholder", "Please enter your address");
    $("#recipient_address").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('recipient_address').style.border=' ';
  }

  if(recipient_city == "")
  {
    document.getElementById('recipient_city').style.border='1px solid #ff0000';
    document.getElementById("recipient_city").focus();
    $('#recipient_city').val('');
    $('#recipient_city').attr("placeholder", "Please enter your city");
    $("#recipient_city").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('recipient_city').style.border=' ';   
  }

    if(recipient_country == "")
  {
    document.getElementById('recipient_country').style.border='1px solid #ff0000';
    document.getElementById("recipient_country").focus();
    $('#recipient_country').val('');
    $('#recipient_country').attr("placeholder", "Please enter your county");
    $("#recipient_country").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('recipient_country').style.border=' ';
  }

   if(recipient_postcode == "")
  {
    document.getElementById('recipient_postcode').style.border='1px solid #ff0000';
    document.getElementById("recipient_postcode").focus();
    $('#recipient_postcode').val('');
    $('#recipient_postcode').attr("placeholder", "Please enter your postcode");
    $("#recipient_postcode").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('recipient_postcode').style.border=' ';
  }
  
 

    document.getElementById("button_addaddr").disabled = true; // return false;
        $(".overlay").css("display",'block'); 
    
    var form = new FormData();             
        form.append('productid', productid);
        form.append('recipient_name', recipient_name);
        form.append('recipient_address', recipient_address);
        form.append('recipient_address2', recipient_address2);
        form.append('recipient_city', recipient_city);
        form.append('recipient_country', recipient_country);
        form.append('recipient_postcode', recipient_postcode); 

            $.ajax({   
              headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
              type: 'POST',
              url: "{{url('/addrecipient_address')}}",
              data:form,
              contentType: false,
              processData: false,
              success:function(response) 
              {
                var status=response.status;
                var msg=response.msg;
                
                  console.log(response); // return false;
                     
                
                if(status=='200')
                {
                   $(".overlay").css("display",'none');  
                  setTimeout(function() { location.reload(true) }, 1000);
                }
              else if(status=='401')
              {
                document.getElementById("errormsg").style.color = "#ff0000";
                document.getElementById("errormsg").innerHTML=response.msg;
              }
            }

            });
            return false;
	 
       }

  function useaddr_form()
  {  
     if (!$("input[name=useaddr]:checked").val()) {
          alert('Please checked the address!'); 
          return false;
     }
     else
     {
      var addr_id = document.querySelector('input[name="useaddr"]:checked').value;
    	var productid1 = document.getElementById('productid1').value.trim(); 
      
       $(".overlay").css("display",'block');  // return false;
      $.ajax({   
              headers: {'X-CSRF-Token':'{{ csrf_token() }}'}, 
              type: 'POST',
              url: "{{url('/addrecipient_useaddress')}}",
              data:{addr_id:addr_id,productid1:productid1},
             
              success:function(response) 
              {
                var status=response.status;
                var msg=response.msg;
                
                  console.log(response); // return false;
                $(".overlay").css("display",'none');        
                
                if(status=='200')
                {
                   $(".overlay").css("display",'none');  
                  setTimeout(function() { location.reload(true) }, 1000);
                }
              else if(status=='401')
              {
                document.getElementById("errormsg").style.color = "#ff0000";
                document.getElementById("errormsg").innerHTML=response.msg;
              }
            }

            });
            return false;

      
     }
     //  return false;
  }

  function remove_cart_item1(id,num)
	{
    /*alert(num);
    return false;*/
		$.ajax({
      headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		  method: "POST",
		  url:"{{url('/remove_cart_item')}}",
		  data: { itemid:id }

		})
		.done(function( msg ) {
			var count_cart_item = msg.count_cart_item;
           console.log(msg); //return false;
					 document.getElementById("cart_item").innerText=count_cart_item;
					 $("#deleterow"+id).css("display","none");
           $(".deleterow1"+id).css("display","none");



          
           if(num > '0'){
            var num2 = num+1;
            var divsToHide = document.getElementsByClassName("title"+num2); //divsToHide is an array
                  for(var i = 0; i < divsToHide.length; i++){
                      divsToHide[i].style.visibility = "show"; // or
                      divsToHide[i].style.display = "block"; // depending on what you're doing
                  }


            }

					  if(count_cart_item=='0'){

              var divsToHide = document.getElementsByClassName("deliver-treat-msg"); //divsToHide is an array
                  for(var i = 0; i < divsToHide.length; i++){
                      divsToHide[i].style.visibility = "hidden"; // or
                      divsToHide[i].style.display = "none"; // depending on what you're doing
                  }


              
							$('#main_container').html('	<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');
              $('#tom1').html('<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');
							$('#addcart_maketreat_personal').html('');

              window.setTimeout(function(){

                    // Move to a new location or you can do something else
                    window.location.href = "{{url('/')}}";

                }, 5000);

						}
            else if(count_cart_item == '1'){

              var divsToHide = document.getElementsByClassName("title"); //divsToHide is an array
                  for(var i = 0; i < divsToHide.length; i++){
                      divsToHide[i].style.visibility = "show"; // or
                      divsToHide[i].style.display = "block"; // depending on what you're doing
                  }


            }
		   });
	}           

  function deletecart_card_item(productid,cartuniqueid)
  {

    $.ajax({
      headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		  method: "POST",
		  url:"{{url('/deletecart_card_item')}}",
		  data: { productid:productid,cartuniqueid:cartuniqueid }

		})
		.done(function( msg ) {
		
           console.log(msg); return false;
					 document.getElementById("cart_item").innerText=count_cart_item;
					 $("#deleterow"+id).css("display","none");
           $(".deleterow1"+id).css("display","none");
					  if(count_cart_item=='0'){





							$('#tom').html('	<div class="tl-treatbox-text-close tl-noitem text-center">	Your cart is empty	</div>');
              $('#tom1').html('<div class="tl-emptytreat-main"> <div class="tl-emptytreat">Your Cart Is Empty.</div></div>');
							$('#addcart_maketreat_personal').html('');
						}
		   });
  }

  function isChar(evt)
		{

			var iKeyCode = (evt.which) ? evt.which : evt.keyCode
					
			if (iKeyCode != 46 && iKeyCode > 31 && iKeyCode > 32 && (iKeyCode < 65 || iKeyCode > 90)&& (iKeyCode < 97 || iKeyCode > 122))
			{
			return false;
			}
			else if(iKeyCode == 46)
			{
			return false;
			}
			else
			{
			return true;
			
			}

		}
    function isChar1(evt)
			 {

			     var regex = new RegExp("^[a-zA-Z0-9 ]+$");
			    var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
			    if (!regex.test(key)) {
			       evt.preventDefault();
			       return false;
			    }

			 }

</script>
 @endsection

 <style type="text/css">
 
body.modal-open {
    overflow-y: scroll !important;
    padding-right: 0px !important;
}
.modal-add-heading {
  text-align: center;
    width: 100%;
    font-size: 20px;
    font-weight: 600;
}
</style>