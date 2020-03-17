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
       Postage & Packaging
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Postage & Packaging</li>
      </ol>
    </section>

    
<section class="content">
    <div class="row">
      <div class="col-md-12">
          <div class="">
            <form class="form-horizontal" method="post" action="#"  onsubmit="return postagecost();" id="imagesform" name="imagesform">
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="form-group">
            <label for="newstitle" class="col-sm-2 control-label">cost*</label>
            <div class="col-sm-10">
                
                <input type="text" class="form-control" placeholder="£" id="cost" name="cost"  maxlength="5" value="<?php echo $data[0]->postage_packaging_cost;?>"> 
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

function postagecost()
{
    var _token = $('input[name=_token]').val();
    var cost =document.getElementById("cost").value.trim();
    if(cost == "")
  {
    document.getElementById('cost').style.border='1px solid #ff0000';
    document.getElementById("cost").focus();
    $('#cost').val('');
    $('#cost').attr("placeholder", "Please enter cost");
    $("#cost").addClass( "errors" );
    return false;
  }
  else{
    document.getElementById('cost').style.border=' ';
  }
   $(".overlay").css("display",'block');
    var form = new FormData();
       form.append('cost', cost);
       form.append('_token', _token);
  
    $.ajax({    
    type: 'POST',
    url: "{{url('/cms/postagecost')}}",
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