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
 <!-- Main page work here -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper tl-admin-about">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="info-box-text">
       Add Faq's Category 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Add Faq's Category</li>
      </ol>
    </section>

    <!-- Main content -->
     <section class="content tl-addfaqcat">
      <div class="row">
            <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="#" onsubmit="return addfaqcat();" id="addfaqcatform">
           
            <?php 
                if(empty($data)){
                  $id = '0';
                  $catName = '';
                  $buttonText = "Submit";
                }else{
                  $buttonText = "Update";
                  $id = $data[0]['tl_faq_category_id'];
                  $catName = $data[0]['tl_faq_category_name'];
                }
              ?>
             
              <div class="box-body">
                <div class="form-group">
                  <label for="newstitle" class="col-sm-12 text-left form-fieldtitle">Faq Category</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="tl_faq_cat_name" name="tl_faq_cat_name" placeholder="Please enter faq's category*" maxlength="100" value="{{$catName}}">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="hidden" name="update_cat_id" id="update_cat_id" value="{{$id}}">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" href="{{ url('/cms/faqs') }}" class="btn btn-flat btn-danger">Go Back</a>
                
                <input type="submit" class="btn btn-flat btn-success pull-right" value="{{ $buttonText }}">
              </div>
              <!-- /.box-footer -->
            </form>
          <!-- /.box -->
          <div class="col-md-1"></div>     
      </div><!-- end of row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Main page work here End-->

<script type="text/javascript">
function addfaqcat()
{
    
  var tl_faq_cat_name = document.getElementById('tl_faq_cat_name').value.trim();    
  var update_cat_id = document.getElementById('update_cat_id').value.trim();
  var _token = $('input[name=_token]').val();
  
  if(tl_faq_cat_name == "")
  {
    
    document.getElementById('tl_faq_cat_name').style.border='1px solid #ff0000';
    document.getElementById("tl_faq_cat_name").focus();
    $('#tl_faq_cat_name').val('');
    $('#tl_faq_cat_name').attr("placeholder", "Please enter faq's Category");
    $("#tl_faq_cat_name").addClass( "errors" );
    return false;
  }
  else
    {
      
       $('#tl_faq_cat_name').attr("placeholder", "");
       document.getElementById('tl_faq_cat_name').style.border='';
    }
   
  var form = new FormData();
       form.append('tl_faq_cat_name', tl_faq_cat_name);
       form.append('_token', _token);    
       form.append('update_cat_id', update_cat_id);
  $(".overlay").css("display",'block');
  $.ajax({
    type:"POST",
    url:"{{url('/cms/addfaqcat')}}",
    data:form,
    cache: false,
    contentType: false,
    processData: false,
    success:function(response)
    {
      console.log(response);
      $(".overlay").css("display",'none');        
      var status=response.status;
      var msg=response.msg;
      if(status=='200')
      {
        $("#tl_faq_cat_name").removeClass( "errors" );
        $("#tl_faq_cat_name").val('');
        document.getElementById("errormsg").innerHTML=msg;
        document.getElementById("errormsg").style.color = "#278428";
        setTimeout(function() { 
         // history.go(-1);
       // window.location.replace("{{url('/')}}/cms/faqs");	
        window.location = "{{ url('/') }}/cms/faqs";
        }, 3000);
      }
      else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
      }             
    }
  });
  return false;
} // end of function
</script>

@endsection
