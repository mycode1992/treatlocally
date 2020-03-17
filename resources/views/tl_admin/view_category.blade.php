@extends('tl_admin.layouts.frontlayouts')

@section('content')

<section class="content-header">
      <h1>
        Category
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Category</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/cms/add_category')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right hvr-sweep-to-right" style="background: #222d32;font-weight: 700;border-color: #222d32;padding:10px 0;">Add Category</button>
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
                  <th class="text-center">Name</th>
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
              $id = $data_val->tl_category_id;
              $categoty_name = $data_val->tl_category_name;
              $status = $data_val->tl_category_status;
                 $sn++; 
                 if($status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }
              ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $categoty_name }}</td>
                  </td>
                  <td>
                      <a href="{{url('/cms/add_category'.'/'.$id)}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </td>

                  <td id="{{$id}}"> 
                    
                    <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $id.','.$status;?>)">                    
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
 
    function changestatus(id,status)
{
   
     var tblname='tbl_tl_category';
         var status_val;
         var colname = 'tl_category_id';
         var colstatus = 'tl_category_status';
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
 </script>


@endsection