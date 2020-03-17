@extends('tl_admin.layouts.frontlayouts')

@section('content')

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
       About Us
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">About Us</li>
      </ol>
    </section>

    @foreach($data AS $data_val)
<section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="">
            <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data" onsubmit="return Addaboutus();" id="imagesform" name="imagesform">
            <div class="tl-fileupload">
              <label for="inputPassword3" class="tl-about-smallheading">Image</label>
              <input type="file" name="aboutusimage" id="aboutusimage"/>
              <span class="hvr-sweep-to-right">Choose File</span>
            </div>
            <div class="tl-upload-img">   
              <!-- <img src="{{url('/public')}}/frontend/img/banner.jpg" alt="" class="img-responsive"> -->
               <img src="{{url('/public')}}/tl_admin/upload/aboutus/{{ $data_val->tl_aboutus_imagename }}" alt="" class="img-responsive">
            </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Description</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $data_val->tl_aboutus_content; ?></textarea>
                     <input type="hidden" id="aboutdesp" name="aboutdesp" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
              
                <a type="button" href="{{ url('/dashboard') }}" class="btn btn-flat btn-danger" onclick='goBack()'>Go Back</a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="Update">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->      
        
        
      </div><!-- end of row -->
    </section>
     @endforeach
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!-- Main page work here End-->



<script type="text/javascript">

function Addaboutus()
{
 
    var aboutusdescription =CKEDITOR.instances.editor1.getData();
    var _token = $('input[name=_token]').val();
    var aboutusimage =document.getElementById("aboutusimage").value.trim();
    var aboutusimage = $('#aboutusimage')[0].files[0];

    if(aboutusdescription=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Enter About Us Description*" ; 
      return false;
    }
    else
    {
       $('#aboutdesp').val(aboutusdescription);
        document.getElementById("errormsg").innerHTML="" ; 
        var aboutdesp=document.getElementById('aboutdesp').value.trim();
    }

   $(".overlay").css("display",'block');
    var form = new FormData();
       form.append('aboutdesp', aboutdesp);
       form.append('_token', _token);
       form.append('aboutusimage', aboutusimage);
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/dashboard/addaboutus')}}",
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