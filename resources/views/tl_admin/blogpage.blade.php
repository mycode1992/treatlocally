@extends('tl_admin.layouts.frontlayouts')

@section('content')

<section class="content-header">
      <h1>
        Blog
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Blog</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/blogmodule/addblog')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" style="background: #222d32;font-weight: 700;border-color: #222d32;">Add Blog</button>
    </a>

 </div>
   

<section class="content">
  <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
   

   <table id="example" class="table">
                <thead>
                <tr>
                  <th class="text-center">S.No.</th>
                  <th class="text-center">Title</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Description</th>
                  <th class="text-center">Posted On</th>
                  <th class="text-center">Edit</th>
                  <th class="text-center">Status</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
                 $sn++; 
                 if($data_val->tl_blog_status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }
              ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $data_val->tl_blog_title }}</td>
                  <td><img src="{{url('/public')}}/tl_admin/upload/blog/{{ $data_val->tl_blog_image }}" style="width:80%" style="cursor:pointer;" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/blog/$data_val->tl_blog_image";?>');"></td>
                  <td>
                        <?php
                            $string = $data_val->tl_blog_description;
                          //  $string_word_count =  str_word_count($string); 
                            if(strlen($string) > 100){
                                $stringCut = substr($string, 0, 100);
                                $endPoint = strrpos($stringCut, ' ');
                                $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$data_val->tl_blog_id.')">Read More</a>';
                                echo $string;
                            }
                            else{
                                echo  $string;
                            }

                             ?>
                  
                </td>
                  <td>{{ $data_val->tl_blog_created_at }}</td>

                  <td>
                      <a href="{{url('/blogmodule/editblog/'.$data_val->tl_blog_id)}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </td>

                  <td id="{{$data_val->tl_blog_id}}"> 
                    
                    <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $data_val->tl_blog_id.','.$data_val->tl_blog_status;?>)">                    
                        {{$buttontext}}
                     </a> </td>
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  
                </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

           <!-- Modal -->

           <div class="modal" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    
                    <div class="modal-body">
                      <p id="readmoremsg"></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>

              
            
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

<script language="javascript">
function openImgModal(path)
{
  // alert('edfgr'+path);
  // return false;
  // document.getElementbyId('responseMsg').innerHTML="asdsadsad";
  $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
  $('#myModal').modal('show');
}
    function changestatus(id,status)
{
   
		 var tblname='tbl_tl_blog';
         var status_val;
         var colname = 'tl_blog_id';
         var colstatus = 'tl_blog_status';
         var _token = $('input[name=_token]').val();
		  if(status==0)
		  {
		  status_val="1";
		  }
		  else
		  {
		     status_val="0";
		  }

		  $.ajax({
		  method: "POST",
		  url:"{{url('/changestatus')}}",
		  data: { id:id, status:status_val,tblname:tblname,colname:colname,colstatus:colstatus,_token:_token }

		})
		  .done(function( msg ) {
           console.log(msg); //return false;
		var tempst=0;
		var tempstr="";
		if(status==0)
		{
		  tempst=1;
		  tempstr="ACTIVE";
		  color="btn-success";
		}

		if(status==1)
		{
		  tempst=0;
		  tempstr="DEACTIVE";
		  color="btn-danger";
		}
      
		$("#"+id).html("<a href='javascript:void(0);' class='btn btn-block "+color+"' onclick='changestatus("+id+","+tempst+")'>"+tempstr+"</a>");


		   });
  
}

function readmore(id){
  
    var _token = $('input[name=_token]').val();
    $.ajax({
    method: "POST",
    url: "{{url('/blog/getblogdesc')}}",
    data: { id: id, _token: _token}

  })
  .done(function( response ) {
  // console.log(response); return false;
    console.log(response[0]);
   // $('#readmoremsg').text(response[0].tl_blog_description);
    document.getElementById("readmoremsg").innerHTML = response[0].tl_blog_description;
    $('#myModal').modal('show');
  

  });
    
    
}


 </script>

@endsection