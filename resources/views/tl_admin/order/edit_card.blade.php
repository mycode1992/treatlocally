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
    $segment = Request::segment(2);
?>


<section class="tl-contact tl-about">
	<div class="container">
		<div class="tl-template-main">
			<div class="row">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="tl-template-detail tl-editcart-template">
						<div class="tl-template-giftcard">
							<div class="tl-giftcard-form">
								
								<form action="#" method="#" id="make_treat_per_form" onsubmit="return maketreat_personal();">
										<input type="hidden" name="updateid" id="updateid" value="{{$data[0]->cart_uniqueid}}"> 
										<input type="hidden" name="updateid1" id="updateid1" value="{{$data[0]->tl_product_id}}"> 

									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
											<label for="">Your Greeting</label>
											<label for="">
												<input type="text" class="form-control" name="recipient_name"  value="{{$data[0]->card_recipient_name}}"   id="recipient_name" placeholder="eg:- dear receiver name">
											</label>
										</div>
									</div>
									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
											<label for="">The Occasion</label>
											<label for="">

													<input type="text" class="form-control" name="recipient_occasion" value="{{$data[0]->card_occasion}}" id="recipient_occasion" placeholder="eg:- happy birthday">
											</label>
										</div>
									</div>
									<div class="col-sm-10 col-md-10 col-xs-12">
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
									</div>
									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
											<label for="">Your Sign Off</label>
											<label for="">
												<input type="text" name="sender_name" id="sender_name"  value="{{$data[0]->card_sender_name}}" class="form-control" placeholder="eg:- love from">
											</label>
										</div>
									</div>

									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
											<label for="">From</label>
											<label for="">
												<input type="text" name="sender_name1" id="sender_name1"  value="{{$data[0]->card_sender_name1}}" class="form-control" placeholder="eg:- love from">
											</label>
										</div>
									</div>

									<!-- <div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
											<label for="">Delivery Date</label>
											<label for="" class="tl-tempdate">
												
												<input type="text" class="form-control" value="<?php //echo $card_delievery_date = date("Y-m-d", strtotime($data[0]->card_delievery_date)); ?>" id="datepicker">
											</label>
										</div>
									</div> -->

									<div class="col-sm-4 col-md-4 col-xs-12">
										<div class="form-group">
										<div id="errormsg" style="font-size:14px;text-align: center;"></div>
										<div class="overlay" style="display:none;">
											<div class="overlay" style="display:none;">
											<i class="fa fa-refresh fa-spin"></i>
											</div>
							     	    </div>
							     	    </div>
						     	    </div>
								
									<div class="col-sm-12 col-md-12 col-xs-12">
										<div class="form-group">
											<label for="">
											{{-- <a href="{{ url('payment_mode') }}" class="addcart-btn hvr-sweep-to-right">Add to Cart</a> --}}
											<button type="submit"  class="addcart-btn hvr-sweep-to-right">Save</button>
												
											</label>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="{{url('/public')}}/frontend/js/jquery.min.js"></script>
<script type="text/javascript">
   function maketreat_personal(){
    var updateid = document.getElementById("updateid").value.trim();
    var updateid1 = document.getElementById("updateid1").value.trim();
	var recipient_name = document.getElementById("recipient_name").value.trim();
	var recipient_occasion = document.getElementById("recipient_occasion").value.trim();
	var message = document.getElementById("message").value.trim();
	var sender_name = document.getElementById("sender_name").value.trim();
	var sender_name1 = document.getElementById("sender_name1").value.trim();

	
	
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

			if(sender_name1=="")
			{
			  document.getElementById('sender_name1').style.border='1px solid #ff0000';
			  document.getElementById("sender_name1").focus();
			  $('#sender_name1').val('');
			$('#sender_name1').attr("placeholder", "Please enter sender name");
			  $("#sender_name1").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("sender_name1").style.border = "";   
			}
		

		// if(datepicker=="")  
		// 	{
		// 		document.getElementById('datepicker').style.border='1px solid #ff0000';
		// 		document.getElementById("datepicker").focus();
		// 		$("#datepicker").addClass( "errors" );
		// 		return false;
		// 	}
		// 	else
		// 	{
				
		// 		document.getElementById("datepicker").style.border = ""; 
		// 	}

	   $(".overlay").css("display",'block');
   	var form = new FormData();
		   form.append('recipient_name', recipient_name);
		   form.append('recipient_occasion', recipient_occasion);
		   form.append('message', message);    
		   form.append('sender_name', sender_name);
		   form.append('sender_name1', sender_name1);
           form.append('updateid', updateid);
           form.append('updateid1', updateid1);
		   
		  
             $.ajax({  
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},  
                type: 'POST',
                url: "{{url('/ordermodule/update_card')}}",
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

        $(function(){
                var date = new Date();
                date.setDate(date.getDate());
                $('#datepicker').datepicker({
                format: 'yyyy/mm/dd',
                autoclose: true,
                startDate: date
                })

            });


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