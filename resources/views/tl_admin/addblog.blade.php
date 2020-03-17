@extends('tl_admin.layouts.frontlayouts')

@section('content')

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
      Add Blog
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Add Blog</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#" enctype="multipart/form-data" onsubmit="return addblog();" id="addblogdc" name="addblogdc">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
              <div class="tl-fileupload">
                 <label for="inputPassword3" class="tl-about-smallheading">Image</label> 
                <div class="chooseblogimg">
                 <input type="file" name="blogimage" id="blogimage"/ onchange="blogimgname()"> 
                  <span class="hvr-sweep-to-right">Choose File</span>
                  <p class="choosenFileName" id="choosenFileName">No file choosen</p>
                </div>
              </div>

              

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Title</label>

                  <div class="col-sm-10">
                     <input type="text" id="blogtitle" name="blogtitle" value="">
                    
                  </div>
                </div>
               
              </div>

              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Description</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"></textarea>
                     <input type="hidden" id="blogdetail" name="blogdetail" value="">
                    
                  </div>
                </div>
               
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" onclick="goBack()" class="btn btn-flat btn-danger">Go Back</a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="submit">
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

function addblog()
{
 
    var blogdetail =CKEDITOR.instances.editor1.getData();
    var _token = $('input[name=_token]').val();
    var blogtitle = document.getElementById("blogtitle").value.trim();

    var blogimage =document.getElementById("blogimage").value.trim();
    var blogimage = $('#blogimage')[0].files[0];

    if(blogtitle=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter blog title" ; 
      return false;
    }
    else
    {
      document.getElementById("errormsg").style.color = "";
      document.getElementById("errormsg").innerHTML="" ; 
    }

    
    

    if(blogdetail=="")
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter blog description" ; 
      return false;
    }
    else
    {
       $('#blogdetail').val(blogdetail);
       document.getElementById("errormsg").style.color = "";
        document.getElementById("errormsg").innerHTML="" ; 
        var blogdetail = document.getElementById('blogdetail').value.trim();
    }
  //   console.log('eati');
  // return false;
    

   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('blogdetail', blogdetail);
       form.append('_token', _token);
       form.append('blogimage', blogimage);
       form.append('blogtitle', blogtitle);

  
    $.ajax({    
    type: 'POST',
    url: "{{url('/addblog')}}",
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

<script>
    function goBack() {
        window.history.back();
    }

    function blogimgname() 
      {
        // alert('sdgvfdg'); return false;
      var fullPath = document.getElementById('blogimage').value;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
    //	alert(fullPath); return false;
      document.getElementById("choosenFileName").innerHTML = filename;
    }
    }

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