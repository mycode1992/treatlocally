@extends('tl_admin.layouts.frontlayouts')

@section('content')

<?php
    
    if(isset($_GET['today'])){
      $date = $_GET['today'];
    }
    else
    {
       $date = '';

    }
 
?>

<section class="content-header">
      <h1>
        User
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">User</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    {{-- <a href="{{url('/merchantmodule/addmerchant')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right hvr-sweep-to-right" style="background: #222d32;font-weight: 700;border-color: #222d32;padding:10px 0;">Add Merchant</button>
    </a> --}}

    <button type="button" class="btn exportfileBtn" style="margin-right: 12px;" onclick="downloaddata()">Export XLS File</button>

 </div>

  <script type="text/javascript">
function downloaddata() 
{
      
      
      var  export_today_dat;
       export_today_dat = '<?php echo $date; ?>';
       

      if(export_today_dat==''){
        //console.log('sweta'); return false;
          window.location.href="{{url('/')}}/usermodule/exportuserdata";
      }
      else{
        window.location.href="{{url('/')}}/usermodule/exportuserdata?today=<?php echo $date; ?>";
      }

}
</script>
   

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
                  <th class="text-center">First name</th>
                  <th class="text-center">Last name</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Phone no</th>
                  <th class="text-center">Action</th>
                  <th class="text-center">Status</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
              $firstname = $data_val->tl_userdetail_firstname;
              $lastname = $data_val->tl_userdetail_lastname;
              $email = $data_val->email;
              $phone = $data_val->tl_userdetail_phoneno;
             $status= $data_val->status;
             $userid= $data_val->userid;

                 $sn++; 
                 if($status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }
              ?>
                 <tr id="deleterow<?php echo $userid;?>">
                  <td><?php echo $sn; ?></td>
                  <td>{{ $firstname }}</td>
                
                  <td>{{ $lastname }}</td>
                  <td>{{ $email }}</td> 
                  <td>{{ $phone }}</td>

                  <td class="delete-user">
                      <a href="{{url('/usermodule/edituser/'.$userid)}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                     <a href="javascript:void(0);" onclick=" return deletebtnrow(<?php echo $userid; ?>)"><img src="{{url('/public')}}/frontend/img/delete.png" alt="" class="img-responsive"></a>
                </td>

                  <td id="{{$userid}}"> 
                    
                    <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $userid.','.$status;?>)">                    
                        {{$buttontext}}
                     </a>
                     
                 </td>
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

  <input type="hidden" id="rowidd" value="" name="rowidd" />
   <div id="deletebtn" class="modal merchantlist-modal" role="dialog" >
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


<script language="javascript">

function deletebtnrow(rowid)
{
  
 $("#rowidd").val(rowid);
$("#deletebtn").modal("show");
}

 function deleterow(){
  
  // var snum =$("#snum").val();
  var _token = $('input[name=_token]').val();
  var rowidd =$("#rowidd").val();
   $.ajax({
  method: "POST",
  url: "{{url('/deleteuser')}}",
  data: { id: rowidd,_token:_token}
 
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

  function viewbusiness(userid)
  {
    var _token = $('input[name=_token]').val();
    $.ajax({
		  method: "POST",
		  url:"{{url('/viewbusiness')}}",
		  data: { userid:userid,_token:_token }

		})
    .done(function( msg ) {
           console.log(msg); //return false;
           $("#readmoremsg").html(msg);
           $('#myModal').modal('show');
      
	


		   });
  }
    function changestatus(id,status)
{
   
		 var tblname='users';
         var status_val;
         var colname = 'userid';
         var colstatus = 'status';
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