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
  $segment = Request::segment(3);
  if( $segment!=''){
    $pagename = 'Edit User';
    $firstname = $data[0]['tl_userdetail_firstname'];
    $lastname = $data[0]['tl_userdetail_lastname'];
    $email = $data[0]['email'];
     $address = $data[0]['tl_userdetail_address'];
    $phn = $data[0]['tl_userdetail_phoneno'];
    $userid = $data[0]['userid'];
    $buttontext = 'Update';

  }else{
  $pagename = 'Add Merchant';
  $firstname='';
  $lastname = '';
  $email = '';
  $phn = '';
  $userid = '';
    $address = '';
   $buttontext = 'Submit';
  }
?>

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
       {{$pagename}}
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">  {{$pagename}}</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal tl_admin_add_merchant" method="post" action="#" onsubmit="return addmerchant();" id="addmerchantform" name="addmerchantform">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 

              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="inputPassword3" class="tl-about-smallheading">First name</label>
                     <input type="text" class="form-control" id="first_name" name="first_name" onkeypress="return isChar(event)" value="<?=$firstname?>">
                    <input type="hidden" name="user_id" id="user_id" value="{{$userid}}">
                  </div>
                  <div class="col-sm-4">
                    <label for="inputPassword3" class="tl-about-smallheading">Last name</label>
                     <input type="text" class="form-control" id="last_name" name="last_name" onkeypress="return isChar(event)" value="{{ $lastname }}">
                    
                  </div>
                  <div class="col-sm-4">
                     <label for="inputPassword3" class="tl-about-smallheading">Email</label>
                     <input type="text" class="form-control" id="email" name="email" value="{{$email}}">
                    
                  </div>

                  <div class="col-sm-4">
                    <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Password</label>
                     <input type="password" class="form-control" id="password" name="password" value="">                    
                  </div>

                  <div class="col-sm-4">
                     <label for="inputPassword3" class="tl-about-smallheading">Confirm Password</label>
                     <input type="password" class="form-control" id="con_password" name="con_password" value="">               
                  </div>

                  <div class="col-sm-4">
                     <label for="inputPassword3" class="tl-about-smallheading">Phone no.</label>
                     <input type="text" class="form-control" id="phoneno"  maxlength="10" onkeypress="return isNumberKey(event)" name="phoneno" value="{{$phn}}">                    
                  </div>

                  <div class="col-sm-4">
                    <label for="inputPassword3" class="tl-about-smallheading">Address</label>
                    <textarea name="address" id="address" cols="40" rows="5"><?php echo $address; ?></textarea>
                 </div>

                </div>
               
              </div>

              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" onclick="goBack()" class="btn btn-flat btn-danger">Go Back</a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="{{$buttontext}}">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->

          <div class="col-md-1"></div>

        
        
        
      </div><!-- end of row -->
    </section>
  
    <!-- /.content -->
  </div>
 



<script type="text/javascript">

function addmerchant()
{
    var first_name = document.getElementById("first_name").value.trim();
    var last_name =document.getElementById("last_name").value.trim();
    var email =document.getElementById("email").value.trim(); 
    var password =document.getElementById("password").value.trim();
    var con_password =document.getElementById("con_password").value.trim();
    var user_id =document.getElementById("user_id").value.trim();
    var address =document.getElementById("address").value.trim();

    var phoneno =document.getElementById("phoneno").value.trim();
    var _token = $('input[name=_token]').val();

     var strUserEml=email.toLowerCase();
     var segment='{{$segment}}';
  //  alert(user_id);
	
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

      if(first_name=="")
        {
          document.getElementById('first_name').style.border='1px solid #ff0000';
          document.getElementById("first_name").focus();
          $('#first_name').val('');
        $('#first_name').attr("placeholder", "Please enter your first name");
          $("#first_name").addClass( "errors" );
          return false;
        }
      else if (first_name.length<=2 || first_name.length>=51) 
        {   
            document.getElementById('first_name').style.border='1px solid #ff0000';
            document.getElementById("first_name").focus();
            $('#first_name').val('');
            $('#first_name').attr("placeholder", "Name must be 2-50 characters");
            $("#first_name").addClass( "errors" );
            return false;
        }
        else
        {
          document.getElementById("first_name").style.border = "";   
        }

        if(last_name=="")
        {
          document.getElementById('last_name').style.border='1px solid #ff0000';
          document.getElementById("last_name").focus();
          $('#last_name').val('');
        $('#last_name').attr("placeholder", "Please enter your last name");
          $("#last_name").addClass( "errors" );
          return false;
        }
      else if (last_name.length<=2 || last_name.length>=51) 
        {   
            document.getElementById('last_name').style.border='1px solid #ff0000';
            document.getElementById("last_name").focus();
            $('#last_name').val('');
            $('#last_name').attr("placeholder", "Last name must be 2-50 characters");
            $("#last_name").addClass( "errors" );
            return false;
        }
        else
        {
          document.getElementById("last_name").style.border = "";   
        }

         // validation for email 
	 if(email=="")
  {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').attr("placeholder", "Please enter your E-mail Id");
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
  //console.log(segement); return false;
  //if
   

  if(segment==''){
    
  
      if(password=="")
            {
              document.getElementById('password').style.border='1px solid #ff0000';
              document.getElementById("password").focus();
              $('#password').val('');
            $('#password').attr("placeholder", "Please enter  password");
              $("#password").addClass( "errors" );
              return false;
            }
          else if (password.length<=5 || password.length>=51) 
    {   
        document.getElementById('password').style.borderColor='#ff0000';
        document.getElementById("password").focus();
        $('#password').val('');
        $('#password').attr("placeholder", "Password Must Be Between 6-50 Char");
        $("#password").addClass( "errors" );
        return false;
    }
            else
            {
              document.getElementById("password").style.border = "";   
            }

            if(con_password=="")
            {
              document.getElementById('con_password').style.border='1px solid #ff0000';
              document.getElementById("con_password").focus();
              $('#con_password').val('');
            $('#con_password').attr("placeholder", "Please confirm password");
              $("#con_password").addClass( "errors" );
              return false;
            }
        
            else
            {
              document.getElementById("con_password").style.border = "";   
            }

            if(password != con_password){
              document.getElementById("errormsg").style.color = "#ff0000";
              document.getElementById("errormsg").innerHTML="Password does not match" ; 
              return false;
            }
            else
            {
              document.getElementById("errormsg").style.color = "";
              document.getElementById("errormsg").innerHTML="" ; 
            }
            
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
  else if(phoneno.length <=9 || phoneno.length >=11)
 {
		document.getElementById('phoneno').style.border='1px solid #ff0000';
	   document.getElementById("phoneno").focus();
	  $("#phoneno").val('');
       $('#phoneno').attr("placeholder", "Phone no should be 10 digits");
       $("#phoneno").addClass( "errors" );

        return false;
 }
  else
  {
     document.getElementById("phoneno").style.borderColor = "";     
       
  }
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('email', email);
       form.append('_token', _token);
       form.append('password', password);
       form.append('phoneno', phoneno);
       form.append('first_name', first_name);
       form.append('last_name', last_name); 
        form.append('address', address); 
       form.append('user_id', user_id);


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/update_user')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {

      
        console.log(response); // return false;
      $(".overlay").css("display",'none');        
      
      if(response=='1')
      {
         document.getElementById("errormsg").innerHTML="User info updated successfully.";
         document.getElementById("errormsg").style.color = "#278428";
          setTimeout(function() { location.reload(true) }, 3000);
      }
      else if(response=='2')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML='Something went wrong, please try again later.' ;
      }
       else if(response=='3')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML='E-mail id already exists.' ;
      }
      

    }

     });
     return false;
 
  }// end of function

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

      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

<script>
    function goBack() {
        window.history.back();
    }
    </script>


@endsection