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

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
       Thankyou
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Thankyou</li>
      </ol>
    </section>

    
<section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="">
            <form class="form-horizontal" method="post" action="#"  onsubmit="return thankyou_update();" id="imagesform" name="imagesform">
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="form-group">
            <label for="newstitle" class="col-sm-2 control-label">cost*</label>
            <div class="col-sm-10">
                <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $data[0]->tl_thankyou_content;?></textarea>
                <input type="hidden" id="thankyou_content" name="thankyou_content" value="">
            </div>
            </div>

            <div class="form-group">
                    <label for="newstitle" class="col-sm-2 control-label">Email*</label>
                    <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="Enter your email" id="email" name="email"   value="<?php echo $data[0]->email;?>"> 
                    </div>
                    </div>

           
            
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="Update">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->      
        
        
      </div><!-- end of row -->
    </section>
    
    <!-- /.content -->
  </div>
  

<script type="text/javascript">

function thankyou_update()
{
    var _token = $('input[name=_token]').val();
    var thankyou_content1 =CKEDITOR.instances.editor1.getData();
    var email =document.getElementById("email").value.trim();
    var strUserEml=email.toLowerCase();
    var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

   if(thankyou_content1=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter content" ; 
      return false;
    }
    else
    {
       $('#thankyou_content').val(thankyou_content1);
        document.getElementById("errormsg").innerHTML="" ; 
        var thankyou_content=document.getElementById('thankyou_content').value.trim();
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


   $(".overlay").css("display",'block');
    var form = new FormData();   
       form.append('thankyou_content', thankyou_content);
       form.append('email', email);
       form.append('_token', _token);
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/cms/thankyou_update')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {

      
       // console.log(response);
      $(".overlay").css("display",'none');        
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



</script>


@endsection