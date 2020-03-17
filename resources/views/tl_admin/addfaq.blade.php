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
       Add Faq's 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Add Faq's</li>
      </ol>
    </section>

  
    <!-- Main content -->
     <section class="content">
      <div class="row">
            <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">          
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="#" onsubmit="return addfaq();" id="addfaqform">
              <?php
                 if(count($data['result'])>"0"){
                  $buttontext = "update";
                 }else{
                  $buttontext = "submit";
                 }
                
              ?>
              <input type="hidden" name="tl_faq_cat_detail_id" id="tl_faq_cat_detail_id" value="<?php if(count($data['result'])>"0"){ echo $data['result'][0]['tl_faq_category_detail_id']; }else { echo 0; } ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="newstitle" class="col-sm-2 control-label">Faq Category</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="tl_faq_q_catid" id="tl_faq_q_catid">
                      <option value="-1">Select Category</option>
                       @foreach($data['catogories'] AS $data_val)
                        <option value="{{ $data_val->tl_faq_category_id }}"<?php  if(count($data['result'])>"0") {  if( $data['result'][0]['tl_faq_category_id'] == $data_val->tl_faq_category_id ){ echo 'selected'; }  }?> > {{ $data_val->tl_faq_category_name }} </option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="newstitle" class="col-sm-2 control-label">Faq's Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="tl_faq_title" name="tl_faq_title" placeholder="Please enter faq's title*" maxlength="100" value="<?php if(count($data['result'])>"0"){ echo $data['result'][0]['tl_faq_category_detail_title']; } ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Faq's Description</label>

                  <div class="col-sm-10">
                    <textarea id="editor1" name="editor1" class="ckeditor"><?php if(count($data['result'])>"0"){ echo$data['result'][0]['tl_faq_category_detail_description']; } ?></textarea>
                     <input type="hidden" id="tl_faq_desp" name="tl_faq_desp" value="">
                     <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a href="{{ url('/cms/faqs') }}"><button type="button" class="btn btn-flat btn-danger">Go Back</button></a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="{{ $buttontext }}">
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
   $(function () {
    CKEDITOR.replace('editor1')
  })
</script>
<script type="text/javascript">
function addfaq()
{
  var tl_faq_q_catid = $('#tl_faq_q_catid').val();  
  var tl_faq_title = document.getElementById('tl_faq_title').value.trim();      
  var tl_faq_desp =CKEDITOR.instances.editor1.getData();
  var tl_faq_cat_detail_id = $('#tl_faq_cat_detail_id').val();
  var _token = $('input[name=_token]').val();
  
  if(tl_faq_q_catid == "-1"){
    document.getElementById('tl_faq_q_catid').style.border='1px solid #ff0000';
    document.getElementById("tl_faq_q_catid").focus();
    return false;
  }else{
    document.getElementById('tl_faq_q_catid').style.border=' ';
  }
  if(tl_faq_title == "")
  {
    document.getElementById('tl_faq_title').style.border='1px solid #ff0000';
    document.getElementById("tl_faq_title").focus();
    $('#tl_faq_title').val('');
    $('#tl_faq_title').attr("placeholder", "Please enter faq's title");
    $("#tl_faq_title").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('tl_faq_title').style.border=' ';
  }
  if(tl_faq_desp == "")
  {   
    document.getElementById("errormsg").style.color='#ff0000';
    document.getElementById("errormsg").innerHTML="Please enter faq's description" ; 
    return false;
  }else{
    $('#tl_faq_desp').val(tl_faq_desp);
    document.getElementById("errormsg").innerHTML="" ; 
    var tl_faq_desp = document.getElementById('tl_faq_desp').value.trim();
  }
  var form = new FormData(); 
      form.append('tl_faq_q_catid', tl_faq_q_catid);
      form.append('tl_faq_title', tl_faq_title);
      form.append('tl_faq_desp', tl_faq_desp);
      form.append('_token', _token);    
      form.append('tl_faq_cat_detail_id', tl_faq_cat_detail_id);

  $(".overlay").css("display",'block');
    $.ajax({
    type:"POST",
    url:"{{url('/cms/addfaq')}}",
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
        $("#dos_faq_q_catid, #dos_faq_q_question").removeClass( "errors" );
        CKEDITOR.instances.editor1.setData('');
        document.getElementById("errormsg").innerHTML=msg;
        document.getElementById("errormsg").style.color = "#278428";
        setTimeout(function() { 
          window.location = "{{ url('/') }}/cms/faqs";
        }, 3000);
      }
      else if(status=='401')
      {
         document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg ;
      }             
    }
  }).responseText;  
  return false;
}
</script>

@endsection
