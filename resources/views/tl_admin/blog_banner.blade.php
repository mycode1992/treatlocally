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

  <div class="content-wrapper tl-admin-about
  ">
   
    <section class="content-header">
      <h1 class="info-box-text">
       Blog Banner
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Blog Banner</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data" onsubmit="return updateblogbanner();" id="blogbanner" name="blogbanner">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
            
              <div class="form-group">
                <label for="newstitle" class="col-sm-2 control-label">Blog Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="tl_blog_title" name="tl_blog_title" placeholder="Please enter blog title*" maxlength="100" value="{{$data[0]->tl_blogbanner_title}}">
                </div>
              </div>

                 <div class="tl-fileupload">
                    <label for="inputPassword3" class="tl-about-smallheading">Image</label> 
                    <input type="file" name="blogbannerimg" id="blogbannerimg"/> 
                     <span class="hvr-sweep-to-right">Choose File</span>
                 </div>
   
                 <div class="tl-upload-img">     
                 
                    <img src="{{url('/public')}}/tl_admin/upload/blog_banner/{{$data[0]->tl_blogbanner_image}}" alt="" class="img-responsive">
                 </div>

              </div>

               <div class="col-md-4">
                  <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;margin: 10px 0 0;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                {{-- <a type="button" href="{{ url('/dashboard') }}" class="btn btn-flat btn-danger">Go Back</a> --}}
                <input type="submit" class="btn btn-flat btn-success pull-left" value="update" style="margin: 30px 0;">
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

function updateblogbanner()
{
    var _token = $('input[name=_token]').val();   
    var blogbannerimg =document.getElementById("blogbannerimg").value.trim();
    var tl_blog_title =document.getElementById("tl_blog_title").value.trim();
    var blogbannerimg = $('#blogbannerimg')[0].files[0];

    if(tl_blog_title == "")
      {
        document.getElementById('tl_blog_title').style.border='1px solid #ff0000';
        document.getElementById("tl_blog_title").focus();
        $('#tl_blog_title').val('');
        $('#tl_blog_title').attr("placeholder", "Please enter blog title");
        $("#tl_blog_title").addClass( "errors" );
        return false;
      }
      else{
        document.getElementById('tl_blog_title').style.border=' ';
      }

   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('blogbannerimg',blogbannerimg);
       form.append('tl_blog_title',tl_blog_title);
       form.append('_token', _token);
  //console.log('sdsgfvdb'); return false;
    $.ajax({    
    type: 'POST',
    url: "{{url('/updateblogbanner')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {

      
        console.log(response); //return false;
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