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
                                    <div class="tl-account-right-title">Edit Card</div>
                                        
                                    </div>
                                
                                    <form action="#" method="#" id="make_treat_per_form" onsubmit="return maketreat_personal();">
                                            <input type="hidden" name="updateid" id="updateid" value="{{$data[0]->cart_uniqueid}}"> 
                                        <div class="form-group">
                                            <label for="">Your Greeting</label>
                                            <label for="">
                                                <input type="text" class="form-control" name="recipient_name"  value="{{$data[0]->card_recipient_name}}"   id="recipient_name" placeholder="eg:- dear receiver name">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="">The Occasion</label>
                                            <label for="">
    
                                                    <input type="text" class="form-control" name="recipient_occasion" value="{{$data[0]->card_occasion}}" id="recipient_occasion" placeholder="eg:- happy birthday">
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Your Special Message</label>
                                            <label for="">
                                                <textarea name="message" id="message"  class="form-control" onkeyup="countChar(this);" placeholder="Write a message"><?php echo $data[0]->card_message; ?></textarea>
                                                <span class="tl-msg-text">
                                                    <p>Maximum character 200</p>
                                                    <p>Character left - <span id="countCharacter">200</span></p>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Your Sign Off'</label>
                                            <label for="">
                                                <input type="text" name="sender_name" id="sender_name"  value="{{$data[0]->card_sender_name}}" class="form-control" placeholder="eg:- love from">
                                            </label>
                                        </div>
                                       <!--  <div class="form-group">
                                            <label for="">Delivery Date</label>
                                            <label for="" class="tl-tempdate">
                                                
                                                <input type="text" class="form-control" value="<?php //echo $card_delievery_date = date("Y-m-d", strtotime($data[0]->card_delievery_date)); ?>" id="datepicker1">
                                            </label>
                                        </div> -->
                                        
                                        <div class="form-group">
                                        <div id="errormsg" style="font-size:14px;text-align: center;"></div>
                                        <div class="overlay" style="display:none;">
                                            <div class="overlay" style="display:none;">
                                            <i class="fa fa-refresh fa-spin"></i>
                                            </div>
                                         </div>
                                         </div>
                                    
                                        <div class="form-group">
                                            <label for="">
                                            {{-- <a href="{{ url('payment_mode') }}" class="addcart-btn hvr-sweep-to-right">Add to Cart</a> --}}
                                            <button type="submit"  class="addcart-btn hvr-sweep-to-right">Save</button>
                                                
                                            </label>
                                        </div>
                                    </form>
                            
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

    
<script type="text/javascript">
   function maketreat_personal(){
    var updateid = document.getElementById("updateid").value.trim();
	var recipient_name = document.getElementById("recipient_name").value.trim();
	var recipient_occasion = document.getElementById("recipient_occasion").value.trim();
	var message = document.getElementById("message").value.trim();
	var sender_name = document.getElementById("sender_name").value.trim();
	///var datepicker1 = document.getElementById("datepicker1").value.trim();

	
	
		  if(recipient_name=="")
			{
			  document.getElementById('recipient_name').style.border='1px solid #ff0000';
			  document.getElementById("recipient_name").focus();
			  $('#recipient_name').val('');
			$('#recipient_name').attr("placeholder", "Please enter recipient name");
			  $("#recipient_name").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("recipient_name").style.border = "";   
			}

			 if(recipient_occasion=="")
			{
			  document.getElementById('recipient_occasion').style.border='1px solid #ff0000';
			  document.getElementById("recipient_occasion").focus();
			  $('#recipient_occasion').val('');
			$('#recipient_occasion').attr("placeholder", "Please enter occasion");
			  $("#recipient_occasion").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("recipient_occasion").style.border = "";   
			}

		  if(message=="")
			{
			  document.getElementById('message').style.border='1px solid #ff0000';
			  document.getElementById("message").focus();
			  $('#message').val('');
			$('#message').attr("placeholder", "Please enter your message");
			  $("#message").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("message").style.border = "";   
			}


		  if(sender_name=="")
			{
			  document.getElementById('sender_name').style.border='1px solid #ff0000';
			  document.getElementById("sender_name").focus();
			  $('#sender_name').val('');
			$('#sender_name').attr("placeholder", "Please enter sender name");
			  $("#sender_name").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("sender_name").style.border = "";   
			}
		

		// if(datepicker1=="")  
		// 	{
		// 		document.getElementById('datepicker1').style.border='1px solid #ff0000';
		// 		document.getElementById("datepicker1").focus();
		// 		$("#datepicker1").addClass( "errors" );
		// 		return false;
		// 	}
		// 	else
		// 	{
				
		// 		document.getElementById("datepicker1").style.border = ""; 
		// 	}

	   $(".overlay").css("display",'block');
   	var form = new FormData();
		   form.append('recipient_name', recipient_name);
		   form.append('recipient_occasion', recipient_occasion);
		   form.append('message', message);    
		   form.append('sender_name', sender_name);
		  // form.append('datepicker1', datepicker1);
           form.append('updateid', updateid);
		   
		  
             $.ajax({  
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},  
                type: 'POST',
                url: "{{url('/merchant/update_card')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
            
                
                    console.log(response); // return false;
                $(".overlay").css("display",'none');  
                    var status=response.status;
                    var msg=response.msg;      
               
                if(status=='200')
                {
                    document.getElementById("errormsg").style.color = "green";
                document.getElementById("errormsg").innerHTML=response.msg ;
                }
                else if(status=='401')
            {
                document.getElementById("errormsg").style.color = "#ff0000";
                document.getElementById("errormsg").innerHTML=response.msg ;
            }
                
                }
	
		 });
		 return false;

}

       

        (function() {
            var message = document.getElementById("message");
           
           var len = message.value.length;
            if(len>200){
				val.value = val.value.substring(0, 200);
			}else{
				
                document.getElementById("countCharacter").innerHTML=200 - len;
             
			}

            })();

	 
	function countChar(val){
		var len = val.value.length;
		  if(len>200){
				val.value = val.value.substring(0, 200);
			}else{
				$('#countCharacter').text(200 - len);
			}
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

</script>



  




 @endsection