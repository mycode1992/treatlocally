@extends('tl_admin.layouts.frontlayouts')

@section('content')

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
       Terms & Condition
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Terms & Condition</li>
      </ol>
    </section>

       @foreach($data AS $data_val) 
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data" onsubmit="return updatetermscondition();" id="termscondition" name="termscondition">
               
              <div class="tl-fileupload">
                 <label for="inputPassword3" class="tl-about-smallheading">Image</label> 
                 <input type="file" name="termsconditionimage" id="termsconditionimage"/> 
                  <span class="hvr-sweep-to-right">Choose File</span>
              </div>

              <div class="tl-upload-img">   
                <!-- <img src="{{url('/public')}}/frontend/img/banner.jpg" alt="" class="img-responsive"> -->
                 <img src="{{url('/public')}}/tl_admin/upload/terms-condition/{{ $data_val->tl_terms_condition_imagename }}" alt="" class="img-responsive">
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Description</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $data_val->tl_terms_condition_content; ?></textarea>
                     <input type="hidden" id="termsconditiondesp" name="termsconditiondesp" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" href="{{ url('/dashboard') }}" class="btn btn-flat btn-danger">Go Back</a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="Update">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->

          <div class="col-md-1"></div>

        
        
        
      </div><!-- end of row -->
    </section>
   @endforeach
    <!-- /.content -->
  </div>
 



<script type="text/javascript">

function updatetermscondition()
{
 
    var termsdescription =CKEDITOR.instances.editor1.getData();
    var _token = $('input[name=_token]').val();
    var termsconditionimage =document.getElementById("termsconditionimage").value.trim();
    var termsconditionimage = $('#termsconditionimage')[0].files[0];

    if(termsdescription=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter Terms & Condition description" ; 
      return false;
    }
    else
    {
       $('#termsconditiondesp').val(termsdescription);
        document.getElementById("errormsg").innerHTML="" ; 
        var termsconditiondesp = document.getElementById('termsconditiondesp').value.trim();
    }

   $(".overlay").css("display",'block');
    var form = new FormData();
       form.append('termsconditiondesp', termsconditiondesp);
       form.append('_token', _token);
       form.append('termsconditionimage', termsconditionimage);
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/updatetermscondition')}}",
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

<script type="text/javascript">

$(function () {
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace('editor1')
//bootstrap WYSIHTML5 - text editor
// $('.textarea').wysihtml5()
})
</script>
@endsection