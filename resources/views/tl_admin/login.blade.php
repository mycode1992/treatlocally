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

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

</style>    
<link rel="stylesheet" href="{{url('/')}}/public/tl_admin/bower_components/font-awesome/css/font-awesome.min.css">
<div class="container">
    <div class="row">
        <div class="tl-form">
            <div class="panel panel-default">

                <div class="tl-form-logo">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/public/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
                </div>
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal"  onsubmit="return validatelogin();">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <label for="">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}"  autofocus>

                            </label>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <label for="">
                                <input id="password" type="password" class="form-control" name="password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </label>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                               @if ($errors->has('email'))
                                    <span class="help-block" style="color:#ff0000">
                                        {{-- <strong>{{ $errors->first('email') }}</strong> --}}
                                        <strong>Invalid! Username and Password</strong>
                                    </span>
                                @endif
                        </div>
                        
                        {{-- <div class="form-group tl-errordiv">
                          <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                        </div> --}}

                        <div class="col-sm-12 col-md-12 col-xs-12 tl-errordiv">
                                <div id="errormsg" style="font-size: 15px;text-align: center; top:-6px;"></div>
                                <div id="errormsg" style="font-size: 15px;text-align: center; top:-6px;"></div>
                                <div class="overlay" style="display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>

                      

                        <div class="form-group">
                            <label for="">
                                <button type="submit" class="tl-form-submit hvr-sweep-to-right">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/tl_admin/forgot-password') }}">
                                    Forgot Password?
                                </a>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function validatelogin()
    {
        document.getElementById("errormsg").innerHTML='';
        var email = document.getElementById("email").value.trim();   
        var strUserEml=email.toLowerCase();
        var password = document.getElementById("password").value.trim();
        var _token = $('input[name=_token]').val();

        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
       
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
//   console.log("test");
// return false;
  if(password=="")
  {

       document.getElementById('password').style.border='1px solid #ff0000';
       document.getElementById("password").focus();
       $('#password').attr("placeholder", "Please enter your password");
       $("#password").addClass( "errors" );

        return false;
  }
  else
  {
     document.getElementById("password").style.borderColor = "";     
       
  }

$(".overlay").css("display",'block');

        var form = new FormData();
         form.append('email', strUserEml); 
         form.append('password', password);
         form.append('_token', _token);
        
     $.ajax({    
     type: 'POST',
     url: "{{url('tl_admin/login')}}",
     data: form,
     cache: false,
     contentType: false,
     processData: false,
     success:function(response) 
     {   	 
       $(".overlay").css("display",'none');
        
        console.log(response);  //return false;
        var status=response.status;
       var msg=response.msg;
       var path="{{url('/dashboard')}}";
       if(status=='200')
       {
         
         $("#email,#password").removeClass( "errors" );
          $("#email,#password").val('');
          document.getElementById("errormsg").innerHTML=msg;
          document.getElementById("errormsg").style.color = "#278428";
 
          setTimeout(function() { window.location.href=path; }, 1000);
       }
       else if(status=='401')
       {
          document.getElementById("errormsg").style.color = "#ff0000";
          document.getElementById("errormsg").innerHTML=msg;
       }
     
     }
 
      });
      return false;





   //return false;
    }
</script>
@endsection
