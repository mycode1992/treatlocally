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
 
  if( $segment!=''){
    $pagename = 'Edit Treat For';
   $relation = $data['name']; 
   $update_id = $data['id']; 
   }else{
   $pagename = 'Add Treat For';
   $relation ='';
   $update_id = ''; 

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
        <li class="active">{{$pagename}}</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal tl_admin_add_merchant" method="post" action="#" onsubmit="return addtreatfor();">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 

              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-4">
                    <label for="inputPassword3" class="tl-about-smallheading">Treat For</label>
                     <input type="text" class="form-control" id="treat_for" name="treat_for" onkeypress="return isChar(event)" value="{{$relation}}">
                    <input type="hidden" name="updateid" id="updateid" value="{{$update_id}}">
                  </div>
                  
                </div>
               
              </div>

              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" href="{{url('/cms/treat-for')}}" class="tl-btn-defult hvr-sweep-to-right">Go Back</a>
                <input type="submit" class="tl-btn-defult hvr-sweep-to-right pull-right" value="submit">
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

function addtreatfor()
{
   

    var treat_for = document.getElementById("treat_for").value.trim();
     var updateid = document.getElementById("updateid").value.trim();
     var _token = $('input[name=_token]').val();
    
      if(treat_for=="")
        {
           
          document.getElementById('treat_for').style.border='1px solid #ff0000';
          document.getElementById("treat_for").focus();
          $('#treat_for').val('');
        $('#treat_for').attr("placeholder", "Field can not be blank");
          $("#treat_for").addClass( "errors" );
          return false;
        }     
      else if (treat_for.length<=2 || treat_for.length>=51) 
        {   
           
            document.getElementById('treat_for').style.border='1px solid #ff0000';
            document.getElementById("treat_for").focus();
            $('#treat_for').val('');
            $('#treat_for').attr("placeholder", "Must be 2-50 characters");
            $("#treat_for").addClass( "errors" );
            return false;
         }

       
        else
        {
          document.getElementById("treat_for").style.border = "";   
        }
       
  
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('treat_for', treat_for);
       form.append('updateid', updateid);
       form.append('_token', _token);

    $.ajax({    
    type: 'POST',
    url: "{{url('/addtreatfor')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {
        console.log(response); // return false;
      $(".overlay").css("display",'none');        
      var status = response.status;
      var msg = response.msg;
      if(status=='200')
      {
         document.getElementById("errormsg").innerHTML=msg;
         document.getElementById("errormsg").style.color = "#278428";
          setTimeout(function() { location.reload(true) }, 3000);
      }
      else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=msg;
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



@endsection