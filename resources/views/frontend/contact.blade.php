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

<!-- contact-start -->

<section class="tl-contact">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url({{url('/public')}}/frontend/img/contact_header_img.jpg);"></div>
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Contact Us</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-contact-main">
			<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12 wow fadeIn" data-wow-delay="0.3s">
					<div class="tl-contact-cols">
						<div class="tl-contact-cols-icon">
							<div class="tl-contact-cols-icon-img">
								<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data[0]->icon_1_image}}" alt="" class="img-responsive">
							</div>
							<div class="tl-contact-cols-icon-text">
								{{$data[0]->icon_1_title}}
							</div>
						</div>
						<div class="tl-contact-cols-text">
							<?php
								echo $data[0]->icon_1_desp;
							?>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 col-xs-12 wow fadeIn" data-wow-delay="0.6s">
					<div class="tl-contact-cols">
						<div class="tl-contact-cols-icon">
							<div class="tl-contact-cols-icon-img">
								<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data[0]->icon_2_image}}" alt="" class="img-responsive">
							</div>
							<div class="tl-contact-cols-icon-text">
								{{$data[0]->icon_2_title}}
							</div>
						</div>
						<div class="tl-contact-cols-text">
							{{$data[0]->icon_2_desp}}
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 col-xs-12 wow fadeIn" data-wow-delay="0.9s">
					<div class="tl-contact-cols">
						<div class="tl-contact-cols-icon">
							<div class="tl-contact-cols-icon-img">
								<img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data[0]->icon_3_image}}" alt="" class="img-responsive">
							</div>
							<div class="tl-contact-cols-icon-text">
								{{$data[0]->icon_3_title}}
							</div>
						</div>
						<div class="tl-contact-cols-text">
							<a href="mailto:dave@giftlocal.uk">{{$data[0]->icon_3_desp}}</a>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="tl-contact-form">
					<h1 class="text-center wow fadeIn" data-wow-delay="1s">Get In Touch</h1>
					<p class="text-center wow fadeIn" data-wow-delay="1.2s">Get in touch with us by filling in the form below</p>

					<form action="#" method="POST" class="wow fadeIn" data-wow-delay="1.5s" onsubmit="return AddContact();">
					    {{ csrf_field() }}
						<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								<label for="" class="form-title-text">Name <span>*</span></label>
								<label for="">
									<input type="text" name="name" id="name" maxlength="50" onkeypress="return isChar(event)" class="form-control">
								</label>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								<label for="" class="form-title-text">Email <span>*</span></label>
								<label for="">
									<input type="text" id="email" name="email" maxlength="80" class="form-control">
								</label>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								<label for="" class="form-title-text">Phone Number <span>*</span></label>
								<label for="">
									<input type="text" id="phoneno" name="phoneno" maxlength="15"  onkeypress="return isNumberKey(event)" class="form-control">
								</label>
							</div>
						</div>

						<div class="col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								<label for="" class="form-title-text">Company <span>*</span></label>
								<label for="">
									<input type="text" id="company_name" name="company_name" onkeypress="return isChar(event)" class="form-control">
								</label>
							</div>
						</div>

						<div class="col-sm-12 col-md-12 col-xs-12">
							<div class="form-group">
								<label for="" class="form-title-text">Write Message <span>*</span></label>
								<label for="">
									<textarea name="message" id="message" maxlength="200" class="form-control"></textarea>
								</label>
							</div>
						</div>

						 <div id="errormsg" style="font-size: 15px;text-align: center;"></div>

						<div class="col-sm-12 col-md-12 col-xs-12">
							<label for="" class="tl-contactbtn">
								<input type="submit" value="Submit">
							</label>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

</section>

<!-- contact-end -->

<script type="text/javascript">
function AddContact()
{
	
	document.getElementById("errormsg").innerHTML='';
	var name =document.getElementById("name").value.trim();
    var email =document.getElementById("email").value.trim();
    var phoneno =document.getElementById("phoneno").value.trim();
	var company_name =document.getElementById("company_name").value.trim();
    var message =document.getElementById("message").value.trim();
    var strUserEml=email.toLowerCase();
	var _token = $('input[name=_token]').val();
	
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

   // validation for name 
    if(name=="")
    {
      document.getElementById('name').style.border='1px solid #ff0000';
      document.getElementById("name").focus();
      $('#name').val('');
	  $('#name').attr("placeholder", "Please enter your name");
      $("#name").addClass( "errors" );
      return false;
    }
	else if (name.length<=2 || name.length>=51) 
    {   
        document.getElementById('name').style.border='1px solid #ff0000';
        document.getElementById("name").focus();
        $('#name').val('');
        $('#name').attr("placeholder", "Name must be 2-50 characters");
        $("#name").addClass( "errors" );
        return false;
    }
    else
    {
      document.getElementById("name").style.border = "";   
    }

 // validation for email 
	 if(email=="")
  {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').attr("placeholder", "Please enter your email");
       $("#email").addClass( "errors" );

        return false;
  }
  else if(!filter.test(strUserEml)) 
  {

    document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').val('');
       $('#email').attr("placeholder", "Invalid E-mail Id");
       $("#email").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("email").style.borderColor = "";     
       
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
       $('#phoneno').attr("placeholder", "Phone no should be 10-15 digits");
       $("#phoneno").addClass( "errors" );

        return false;
 }
  else
  {
     document.getElementById("phoneno").style.borderColor = "";     
       
  }

   // validation for company name 
   if(company_name=="")
    {
      document.getElementById('company_name').style.border='1px solid #ff0000';
      document.getElementById("company_name").focus();
      $('#company_name').val('');
	  $('#company_name').attr("placeholder", "Please enter your company name");
      $("#company_name").addClass( "errors" );
      return false;
    }
	else if (company_name.length<=4 || company_name.length>=51) 
    {   
		
        document.getElementById('company_name').style.border='1px solid #ff0000';
        document.getElementById("company_name").focus();
        $('#company_name').val('');
        $('#company_name').attr("placeholder", "Company name must be 5-50 character");
        $("#company_name").addClass( "errors" );
        return false;
    }
    else
    {
      document.getElementById("company_name").style.border = "";   
    }

    // validation for message
	if(message=="")
    {
      document.getElementById('message').style.border='1px solid #ff0000';
      document.getElementById("message").focus();
      $('#message').val('');
      $('#message').attr("placeholder", "Please enter your message");
      $("#message").addClass( "errors" );
      return false;
    }
    else if (message.length<=4 || message.length>=201) 
    {   
        document.getElementById('message').style.border='1px solid #ff0000';
        document.getElementById("message").focus();
        $('#message').val('');
        $('#message').attr("placeholder", "Message must be between 5-201 char");
        $("#message").addClass( "errors" );
        return false;
    }
    else
    {
      document.getElementById("message").style.border = "";   
	}
	
	var form = new FormData();
        form.append('name', name);
        form.append('email', strUserEml);
        form.append('phoneno', phoneno);
        form.append('company_name', company_name);   
		form.append('message', message);    
		form.append('_token', _token);
			$.ajax({    
			type: 'POST',
			url: "{{ route('storecontact') }}",
			data: form,
			cache: false,
			contentType: false,
			processData: false,
			success:function(response) 
				{
				console.log(response);
				var status=response.status;
				var msg=response.msg;
				if(status=='200')
				{
					$("#name,#email,#phoneno,#company_name,#message").removeClass( "errors" );
					$("#name,#email,#phoneno,#company_name,#message").val('');
					$('#name,#email,#phoneno,#company_name,#message').attr("placeholder", "");
					document.getElementById("errormsg").innerHTML=msg;
					document.getElementById("errormsg").style.color = "#278428";
				//	setTimeout(function() { 
						//document.getElementById("errormsg").innerHTML='';
						// location.reload(true)
					// }, 3000);
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

   function isChar(evt)
 {

     var regex = new RegExp("^[a-zA-Z0-9. ]+$");
    var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
    if (!regex.test(key)) {
       evt.preventDefault();
       return false;
    }

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