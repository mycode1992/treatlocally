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
       Manage Social Link
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">  Manage Social Link </li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal tl_admin_add_merchant" method="#" action="#" onsubmit="return save_sociallink();" id="addmerchantform" name="addmerchantform">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 

              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="social-link-flex">  
                      <label for="inputPassword3" class="tl-about-smallheading">Facebook Link</label>
                      <textarea name="fb_link" id="fb_link" cols="100" rows="3"><?php echo $data[0]->tl_social_link_facebook; ?></textarea>
                    </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="social-link-flex">
                    <label for="inputPassword3" class="tl-about-smallheading">Twitter Link</label>
                    <textarea name="tw_link" id="tw_link" cols="100" rows="3"><?php echo $data[0]->tl_social_link_twitter; ?></textarea>
                  </div>
                 </div>

                 <div class="col-sm-12">
                  <div class="social-link-flex">
                    <label for="inputPassword3" class="tl-about-smallheading">Youtube Link</label>
                    <textarea name="utube_link" id="utube_link" cols="100" rows="3"><?php echo $data[0]->tl_social_link_youtube; ?></textarea>
                 </div>
                 </div>

                 <div class="col-sm-12">
                    <div class="social-link-flex">
                    <label for="inputPassword3" class="tl-about-smallheading">Instagram Link</label>
                    <textarea name="insta_link" id="insta_link" cols="100" rows="3"><?php echo $data[0]->tl_social_link_insta; ?></textarea>
                  </div>
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

function save_sociallink()   
{
   
    var fb_link = document.getElementById("fb_link").value.trim();
    var tw_link = document.getElementById("tw_link").value.trim();
    var utube_link = document.getElementById("utube_link").value.trim();
    var insta_link = document.getElementById("insta_link").value.trim();
    var _token = $('input[name=_token]').val();

  
   $(".overlay").css("display",'block');
  
    var form = new FormData();
       form.append('fb_link', fb_link);
       form.append('_token', _token);
       form.append('tw_link', tw_link);
       form.append('utube_link', utube_link);
       form.append('insta_link', insta_link);

     

        $.ajax({    
          type: 'POST',
          url: "{{url('/cms/save_sociallink')}}",
          data:form,
          contentType: false,
          processData: false,
          success:function(response) 
          {
              console.log(response); // return false;
            $(".overlay").css("display",'none'); 
            if(response.status=='200')
            {
               document.getElementById("errormsg").innerHTML=response.msg;
               document.getElementById("errormsg").style.color = "#278428";
                 setTimeout(function() { location.reload(true) }, 3000);
            } else if(response.status=='401')
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