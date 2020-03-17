@extends('layouts.app')

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

<div class="container">
    <div class="row">
        <div class="tl-form">
            <div class="panel panel-default">
                <div class="tl-form-logo">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/public/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
                </div>
                <div class="panel-heading">Reset Password</div>
                <form class="form-horizontal" method="POST" action="" onsubmit="return forgotpassword();">
                <div class="panel-body">
                    
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail Address</label>

                                <label for="">
                                    <input id="email" type="text"  class="form-control" name="email" value="">
                
                                </label>
                            </div>
                        </div>
                        <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                        <div class="form-group">
                            <label for="" class="tl-sendemail">
                                <button type="submit" class="tl-form-submit hvr-sweep-to-right">
                                    Send Password Reset Link
                                </button>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function forgotpassword()
    {
        var email =document.getElementById("email").value.trim();
       var _token = $('input[name=_token]').val();

        var strUserEml=email.toLowerCase();
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    
    
    if(email=="")
  {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').attr("placeholder", "Enter E-mail ID");
       $("#email").addClass( "errors" );

        return false;
  }
    else if(!filter.test(strUserEml)) 
   {

       document.getElementById('email').style.border='1px solid #ff0000';
       document.getElementById("email").focus();
       $('#email').val('');
       $('#email').attr("placeholder", "Invalid E-mail ID");
       $("#email").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("email").style.border="";     
       
  }
    
    $.ajax({    
    type: 'POST',
    url: "{{url('/tl_admin/forgot_email')}}",
    data: {email:strUserEml,_token:_token},  
    success:function(response) 
    {
       

      console.log(response); //return false;
      
      var status=response.status;
      var msg=response.msg;
      if(status=='200')
      {
        //var path="{{url('/')}}";
        $("#email").removeClass( "errors" );
         $("#email").val('');
         document.getElementById("errormsg").innerHTML=msg;
         document.getElementById("errormsg").style.color = "#278428";
       //  setTimeout(function() { window.location=path; }, 3000);
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
    </script>
@endsection
