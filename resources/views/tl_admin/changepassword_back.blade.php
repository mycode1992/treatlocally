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
   

   <?php
   $segment =Request::segment(3); 
 if($segment==''){
   $segment='';
 }


  $sql_validtoken = DB::table('users')->select('remember_token')
                           ->where('remember_token',$segment)->get(); 
       $sql_validtoken = json_decode(json_encode($sql_validtoken), True);

$sql_expiretoken = DB::table('users')->select('token_status')
                                ->where([
                                    ['remember_token',$segment],
                                    ['token_status','1'],
                                    ['token_verify_status','0']
                                    ])->get();
   $sql_expiretoken = json_decode(json_encode($sql_expiretoken), True);
     //  print_r($sql_checktoken); exit;
 
?>

<div class="container">
    <div class="row">
        <div class="tl-form">
               
            <div class="panel panel-default" id="errorfortoken">
                   
                <div class="tl-form-logo">
                    <a href="{{url('/')}}"><img src="{{url('/')}}/public/tl_admin/dist/img/logo.png" alt="" class="img-responsive"></a>
                </div>
                 <?php 
                        if(count($sql_validtoken)>0){ 
                     
                          if(count($sql_expiretoken)>0){ 
                     ?>
                <div class="panel-heading">Change Password</div>
               
                <form class="form-horizontal" method="POST" action="" onsubmit="return changepassword();">
                <div class="panel-body">
                    
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="email" class="control-label">Password</label>

                                <label for="">
                                    <input id="password" type="password"  class="form-control" name="password" value="">
                
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label">Confirm Password</label>
    
                                    <label for="">
                                        <input id="con_password" type="password"  class="form-control" name="con_password" value="">
                    
                                    </label>
                                </div>
                        </div>
                        <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                        <div class="form-group">
                            <label for="" class="tl-sendemail">
                                <button type="submit" class="tl-form-submit hvr-sweep-to-right">
                                    Submit
                                </button>
                            </label>
                        </div>
                    </form>
                    <?php }
                    else{ ?>
                          <h3>Your token has been expired</h3>   
                   <?php }  }
                    else{ ?>
                      <div class="panel-body">
                          <h3>Your token is invalid</h3>
                     </div>
                   <?php }
              ?>
    
                </div>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function changepassword()
    {
        
       
        var password =document.getElementById("password").value.trim();
        var con_password =document.getElementById("con_password").value.trim();
        var _token = $('input[name=_token]').val();
       
        var segment = '<?php echo $segment; ?>';
       
    
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
     document.getElementById("password").style.border="";     
       
  }

   if(con_password=="")
  {

       document.getElementById('con_password').style.border='1px solid #ff0000';
       document.getElementById("con_password").focus();
       $('#con_password').attr("placeholder", "Please enter your confirm password");
       $("#con_password").addClass( "errors" );

        return false;
  }
    
  else
  {
     document.getElementById("con_password").style.border="";     
       
  }
 

if(password!=con_password){
    
    document.getElementById("errormsg").style.color = "#ff0000";
    document.getElementById("errormsg").innerHTML='Password did not match' ;
     return false;
}
else{
    document.getElementById("errormsg").style.color = "";
    document.getElementById("errormsg").innerHTML='' ;
}

    
    $.ajax({    
    type: 'POST',
    url: "{{url('/tl_admin/change_password')}}",
    data: {password:password,con_password:con_password,_token:_token,segment:segment},  
    success:function(response) 
    {
       

      console.log(response); //return false;
      
      var status=response.status;
      var msg=response.msg;
      if(status=='200')
      {
        var path="{{url('/')}}/dashboard";
        $("#email").removeClass( "errors" );
         $("#email").val('');
         document.getElementById("errorfortoken").innerHTML="<h3>"+msg+"</h3>";
         document.getElementById("errorfortoken").style.color = "#278428";
         setTimeout(function() { 
          window.location=path; 

        }, 3000);
      }
      else if(status=='401')
      {
         document.getElementById("errorfortoken").style.color = "#ff0000";
         document.getElementById("errorfortoken").innerHTML="<h3>"+msg+"</h3>";
      }
    
    }

     });
     return false;
        
     
     }// end of function
    </script>
@endsection
