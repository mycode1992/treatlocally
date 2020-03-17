@extends('tl_admin.layouts.frontlayouts')

@section('content')

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
       Personalise Information
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Personalise Information</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#"  onsubmit="return updatepersonaliseinfo();" >
             
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Personalise Information</label>

                  <div class="col-sm-10">
                    <textarea id="editor" name="editor" class="form-control"><?php    echo $data[0]->tl_personalise_info; ?></textarea>
                     <input type="hidden" id="personalise_info" name="personalise_info" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
               
                <input type="submit" class="btn btn-flat btn-success pull-right" value="Update">
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

function updatepersonaliseinfo()
{
 
    var editor =document.getElementById("editor").value.trim();
    var _token = $('input[name=_token]').val();

    if(editor=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter personalise information" ; 
      return false;
    }
    else
    {
       $('#personalise_info').val(editor);
        document.getElementById("errormsg").innerHTML="" ; 
        var personalise_info=document.getElementById('personalise_info').value.trim();
    }

   $(".overlay").css("display",'block');
    var form = new FormData();
       form.append('personalise_info', personalise_info);
       form.append('_token', _token);
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/save_personaliseinfo')}}",
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