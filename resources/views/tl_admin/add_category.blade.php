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

<?php

	   if(isset($data) && count($data)>0)
	{
	   $updateid = $data[0]->tl_category_id;  
	   $category_name = $data[0]->tl_category_name; 
	   $button_text = 'Update';
	 
	}
	else
    {
	    $updateid = '';
		$category_name = '';
	   $button_text = 'Submit';
	}
?>

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
      Add Category
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">  Add Category</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="">
            <form class="form-horizontal" method="post" action="#" onsubmit="return addcategory();">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
              <input type="hidden" name="updateid" id="updateid" value="{{$updateid}}"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Category name</label>

                  <div class="col-sm-10">
                     <input type="text" id="categoty_name" class="form-control" name="categoty_name"  value="{{$category_name}}">
                  
                  </div>
                </div>
               
              </div>  
                       
              
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" href="{{url('/cms/category')}}" class="btn btn-flat btn-danger">Go Back</a>
                <input type="submit" class="btn btn-flat btn-success pull-right" value="{{$button_text}}">
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

function addcategory()
{


   
    var categoty_name = document.getElementById("categoty_name").value.trim();
  	var updateid =document.getElementById("updateid").value.trim();
    var _token = $('input[name=_token]').val(); 

      if(categoty_name=="")
        {
          document.getElementById('categoty_name').style.border='1px solid #ff0000';
          document.getElementById("categoty_name").focus();
          $('#categoty_name').val('');
        $('#categoty_name').attr("placeholder", "Please category name");
          $("#categoty_name").addClass( "errors" );
          return false;
        }
        else
        {
          document.getElementById("categoty_name").style.border = "";   
        }

  
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData();
       form.append('categoty_name', categoty_name);
       form.append('updateid', updateid); 
       form.append('_token', _token);   


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/store_category')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {
      var status=response.status;
      var msg=response.msg;
      
        console.log(response); //return false;
      $(".overlay").css("display",'none');        
      
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