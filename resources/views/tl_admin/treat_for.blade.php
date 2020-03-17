@extends('tl_admin.layouts.frontlayouts')

@section('content')

<section class="content-header">
      <h1>
        Who are you treating tags
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Who are you treating tags</li>
      </ol>
    </section>
 <div class="col-xs-3" style="margin: 20px 0 10px;">
   
    <a href="{{url('/cms/add-treat-for')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" style="background: #222d32;font-weight: 700;border-color: #222d32;">Who are you treating tags</button>
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
                  <th class="text-center">Treat for</th>
                  <th class="text-center">Sub Category</th>
                  <th class="text-center">Edit</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Delete</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($relation AS $rel_val)
             <?php
                $sn++;
                if($rel_val->status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }
             ?>
                 <tr id="deleterow<?php echo $rel_val->id;?>">
                  <td><?php echo $sn; ?></td>
                  <td>{{ $rel_val->name }}</td>
                  <td> 
                    
                      <a href="{{url('/cms/view-subcategory'.'/'.$rel_val->id)}}"  class="btn btn-block primary btn-flat">                    
                          View Sub-Category
                       </a> </td>
                  <td>
                    <a href="{{url('/cms/add-treat-for'.'/'.$rel_val->id)}}">
                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                  </a>
              </td>

              <td id="{{$rel_val->id}}"> 
                    
                <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $rel_val->id.','.$rel_val->status;?>)">                    
                    {{$buttontext}}
                 </a> </td>
                 <td>
                  <button type="button" class="btn btn-block btn-danger btn-flat" onclick="return deletebtnrow(<?php echo $rel_val->id;?>);">Delete </button></td>
                  
                </tr>
          @endforeach
        
                </tbody>
             
              </table>
        <!-- Modal -->
        <input type="hidden" id="rowidd" value="" name="rowidd" />
      <div id="deletebtn" class="modal" role="dialog" >
        <div class="modal-dialog" style="width:340px !important">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Are you sure you want to delete ?</h4>
             </div>            
            <div class="modal-body" style="text-align: center;">
              <button type="button" class="btn btn-danger btn-sx" onclick=" return deleterow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
            </div>      
          </div>
        </div>
      </div>
      <!-- Modal -->     

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

<script language="javascript">

  function deletebtnrow(rowid)
{
  // alert(rowid); 
 //$("#deletebtn").css("display","block");
 $("#rowidd").val(rowid);
$("#deletebtn").modal("show");
}

function deleterow(){

 var rowidd =$("#rowidd").val();
 
  $.ajax({
    headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
 method: "POST",
 url: "{{url('/deletetreatfor')}}",
 data: { id: rowidd}

 })
.done(function( response ) {
  console.log(response); //return false;
  $("#rowidd").val("");
 //console.log(response.msg);
 $("#deleterow"+rowidd).css("display","none");
 //$('.modal-backdrop.in').css('opacity', '0');
 //$("#deletebtn").css("display","none");
 $("#cancelbutton").click();
 });
return false;
}

    function changestatus(id,status)
{
   
		 var tblname='_relation';
         var status_val;
         var colname = 'id';
         var colstatus = 'status';
		  if(status==0)
		  {
		  status_val="1";
		  }
		  else
		  {
		     status_val="0";
		  }

		  $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		  method: "POST",
		  url:"{{url('/changestatus')}}",
		  data: { id:id, status:status_val,tblname:tblname,colname:colname,colstatus:colstatus}

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