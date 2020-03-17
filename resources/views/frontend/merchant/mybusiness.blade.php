@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->
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
	if(isset($data) && count($data)>0)
	{
	   $userid = $data[0]->userid;
	   $address = $data[0]->tl_mybusiness_address;
	   $buiss_type = $data[0]->tl_mybusiness_type;
	   $vatno = $data[0]->tl_mybusiness_vatno;
	   $phoneno = $data[0]->tl_mybusiness_phoneno;
	   $about = $data[0]->tl_mybusiness_about;
	   $button_text = 'Update';
	 
	}
	else
    {
	    $userid = '';
	   $address = '';
	   $buiss_type = '';
	   $vatno = '';
	   $phoneno = '';
	   $about = '';
	   $button_text = 'Submit';
	}
	
	
	?>

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
						<div class="tl-account-right-title">My Business</div>
<!-- 						<div class="supportLine">
							"If you'd like to get in touch about anything, please send us a message and we'll get back to you soon"
						</div> -->

						<div class="tl-account-right-form tlsupportForm">
							<form action="#" onsubmit="return mybuissness();">
									<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
									<input type="hidden" name="userid" id="userid" value="{{$userid}}"> 

								<div class="">
									<div class="col-md-6 padL0">
										<label for="">Address*</label>
										<label for="">
											<input type="text" id="address" name="address" value="{{$address}}" class="form-control">
										</label>
									</div>
									<div class="col-md-6">
										<label for="">Business Type</label>
										<label for="">
											<input type="text" id="buissness_type" name="buissness_type" value="{{$buiss_type}}" class="form-control">
										</label>
									</div>
									<div class="col-md-6 padL0">
										<label for="">VAT Number</label>
										<label for="">
											<input type="text" id="vat_num" name="vat_num" value="{{$vatno}}" class="form-control">
										</label>
									</div>
									<div class="col-md-6">
										<label for="">Phone Number</label>
										<label for="">
											<input type="text" id="phoneno" maxlength="15" value="{{$phoneno}}" onkeypress="return isNumberKey(event)" name="phoneno" class="form-control">
										</label>
									</div>

									<div class="col-md-12 padL0 marginTop">
										<label for="" >About The Business*</label>
										<textarea name="abt_buissness" id="abt_buissness" cols="30"  rows="10">{{$about}}</textarea>
									</div>
									<div class="col-sm-12 col-md-12 col-xs-12 tl-errordiv">
										<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
										<div class="overlay" style="display:none;">
										<i class="fa fa-refresh fa-spin"></i>
										</div>
									</div>
									<div class="col-md-12 padL0">
										<label for="">&nbsp;</label>
										<label for="">
											<button type="submit" id="submitBtn" class="hvr-sweep-to-right">{{$button_text}}</button>
										</label>
									</div>
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
<script type="text/javascript">

	function mybuissness()
	{
		
		var address = document.getElementById("address").value.trim();
		
		var buissness_type =document.getElementById("buissness_type").value.trim();
		var userid =document.getElementById("userid").value.trim();
		var vat_num =document.getElementById("vat_num").value.trim(); 
		var abt_buissness =document.getElementById("abt_buissness").value.trim();
		var phoneno =document.getElementById("phoneno").value.trim();
		var _token = $('input[name=_token]').val();
		
		if(address=="")
			{
			  document.getElementById('address').style.border='1px solid #ff0000';
			  document.getElementById("address").focus();
			  $('#address').val('');
			$('#address').attr("placeholder", "Please enter your address");
			  $("#address").addClass( "errors" );
			  return false;
			}
			else
			{
			  document.getElementById("address").style.border = "";   
			}
			
			if(buissness_type=="")
			{
			  document.getElementById('buissness_type').style.border='1px solid #ff0000';
			  document.getElementById("buissness_type").focus();
			  $('#buissness_type').val('');
			$('#buissness_type').attr("placeholder", "Please enter your bussness type");
			  $("#buissness_type").addClass( "errors" );
			  return false;
			}
		  else if (buissness_type.length<=2 || buissness_type.length>=51) 
			{   
				document.getElementById('buissness_type').style.border='1px solid #ff0000';
				document.getElementById("buissness_type").focus();
				$('#buissness_type').val('');
				$('#buissness_type').attr("placeholder", "Last name must be 2-50 characters");
				$("#buissness_type").addClass( "errors" );
				return false;
			}
			else
			{
			  document.getElementById("buissness_type").style.border = "";   
			}
			
			 // validation for email 
			 if(vat_num=="")
	  {
	
		   document.getElementById('vat_num').style.border='1px solid #ff0000';
		   document.getElementById("vat_num").focus();
		   $('#vat_num').attr("placeholder", "Please enter your vat number");
		   $("#vat_num").addClass( "errors" );
	
			return false;
	  }
	  
	  else
	  {
		 document.getElementById("vat_num").style.borderColor = "";     
		   
	  }  
	 
	  // validation for phone no
	  if(phoneno=="")
	  {
	
		   document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		   $('#phoneno').attr("placeholder", "Please enter your phone number");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	  }
	  else if(phoneno.length <=9 || phoneno.length >=16)
	 {
			document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		  $("#phoneno").val('');
		   $('#phoneno').attr("placeholder", "Phone no should be 10 digits");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	 }
	 else if(phoneno =='0000000000')
	 {
			document.getElementById('phoneno').style.border='1px solid #ff0000';
		   document.getElementById("phoneno").focus();
		  $("#phoneno").val('');
		   $('#phoneno').attr("placeholder", "Please enter valid phone no");
		   $("#phoneno").addClass( "errors" );
	
			return false;
	 }
	  else
	  {
		 document.getElementById("phoneno").style.borderColor = "";     
		   
	  } 

	  if(abt_buissness=="")
	  {
	
		document.getElementById('abt_buissness').style.border='1px solid #ff0000';
		document.getElementById("abt_buissness").focus();
		$('#abt_buissness').val('');
		$('#abt_buissness').attr("placeholder", "Please enter about your buissness");
			$("#abt_buissness").addClass( "errors" );
			return false;
		}

		else
		{
			document.getElementById("abt_buissness").style.border = "";   
		}

         $("#submitBtn").prop("disabled",true);
	   $(".overlay").css("display",'block');
	   //return false;
		var form = new FormData();
		   form.append('vat_num', vat_num);
		   form.append('_token', _token);
		   form.append('abt_buissness', abt_buissness);
		   form.append('phoneno', phoneno);
		   form.append('address', address);
		   form.append('buissness_type', buissness_type); 
		   form.append('userid', userid); 

		$.ajax({    
		type: 'POST',
		url: "{{url('/mybuissness')}}",
		data:form,
		contentType: false,
		processData: false,
		success:function(response) 
		{
	
		  
			console.log(response); // return false;
		  $(".overlay").css("display",'none');  
		   $("#submitBtn").prop("disabled",false);
		    var status=response.status;
            var msg=response.msg;      
		  
		  if(status=='200')
		  {
			 document.getElementById("errormsg").innerHTML=msg;
			 document.getElementById("errormsg").style.color = "#278428";
			  setTimeout(function() { location.reload(true) }, 3000);
		  }
		  else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
      }
		
		}
	
		 });
		 return false;
	 
	  }// end of function

	 
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>
 @endsection