@extends('tl_admin.layouts.frontlayouts')

@section('content')
<?php
$segment = Request::segment(3);

?>
 <?php
 $user = DB::table('users')->where('userid',$segment)->select('name')->get();
 $user = json_decode(json_encode($user), True);
 ?>
<section class="content-header">
      <h1>
        <?php echo ucfirst($user[0]['name'])."'s";?> Stores List
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active"> <?php echo ucfirst($user[0]['name'])."'s";?> Stores List</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/merchantmodule/addstore')}}/{{ $segment }}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" style="background: #222d32;font-weight: 700;border-color: #222d32;">Add/Edit Store</button>
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
                  <th class="text-center">Logo</th>
                  <th class="text-center">Address</th>
                  <th class="text-center">Post Code</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Message On Treat Card</th>
                  <th class="text-center">About Merchant</th>
                  <th class="text-center">Terms & Condition</th>
                <!--   <th class="text-center">Action</th> -->

                  <th class="text-center">Status</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
              $name = $data_val->tl_addstore_name;
              $logo = $data_val->tl_addstore_logo;
              $addr = $data_val->tl_addstore_address;
              $postcode = $data_val->tl_addstore_postcode;
              $tl_addstore_services = $data_val->tl_addstore_services;
              $tl_addstore_treat_cardmsg = $data_val->tl_addstore_treat_cardmsg;

              $abtmerchant = $data_val->tl_addstore_aboutmerchant;
              $termscondn = $data_val->tl_addstore_termscondt;
             $status= $data_val->tl_addstore_status;
             $userid= $data_val->userid;  
             $id= $data_val->tl_addstore_id;

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
                  <td>{{ $name }}</td>
                
                  <td class="viewstoreimg"> <img src="{{url('/public')}}/tl_admin/upload/storelogo/{{ $logo }}" style="cursor:pointer;" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/storelogo/$logo";?>');" style="width:100%"></td>
                  <td>{{ $addr }}</td>   
                  <td>{{ $postcode }}</td> 
                  <td>{{ $tl_addstore_services }}</td> 
                 <td>
                 
                  <?php $string = $tl_addstore_treat_cardmsg;
                   if (strlen($string) > 100) {
                    $stringCut = substr($string, 0, 100);
                    $endPoint = strrpos($stringCut, ' ');
                
                    //if the string doesn't contain any space then it will cut without word basis.
                    $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                    $string .= '... <a href="JavaScript:void(0)" onclick="return readmore2('.$id.')">Read More</a>';
                }
                echo $string;  ?>
               </td> 
                  <td>
                   
                     <?php $string = $abtmerchant;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                   
                       //if the string doesn't contain any space then it will cut without word basis.
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                       $string .= '... <a href="JavaScript:void(0)" onclick="return readmore1('.$id.')">Read More</a>';
                   }
                   echo $string;  ?>
                  </td> 
                  <td>
                      <?php $string = $termscondn;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                   
                       //if the string doesn't contain any space then it will cut without word basis.
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                       $string .= '... <a href="#" onclick="return readmore('.$id.')">Read More</a>';
                   }
                   echo $string;

            ?>

             
                  
                  </td>
                 <!--  <td>
                      <a href="{{url('/merchantmodule/editstore/'.$id)}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                </td> -->

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
   
		 var tblname='tbl_tl_addstore';
         var status_val;
         var colname = 'tl_addstore_id';
         var colstatus = 'tl_addstore_status';
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

function readmore(id)
{
   
		 var tblname='tbl_tl_addstore';
         var colnamewhere = 'tl_addstore_id';
         var colmsg = 'tl_addstore_termscondt';
         var _token = $('input[name=_token]').val();
		 

		  $.ajax({
		  method: "POST",
		  url:"{{url('/readmore')}}",
		  data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}

		})
    .done(function( response ) {
 // console.log(response);
  console.log(response); 
  
  document.getElementById("readmoremsg").innerHTML = response;
    $('#myModal').modal('show');

});
  
}

function readmore1(id)
{
   
     var tblname='tbl_tl_addstore';
         var colnamewhere = 'tl_addstore_id';
         var colmsg = 'tl_addstore_aboutmerchant';
         var _token = $('input[name=_token]').val();
     

      $.ajax({
      method: "POST",
      url:"{{url('/readmore')}}",
      data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}

    })
    .done(function( response ) {
 // console.log(response);
  console.log(response); 
  
  document.getElementById("readmoremsg").innerHTML = response;
    $('#myModal').modal('show');

});
  
}

function readmore2(id)
{
   
     var tblname='tbl_tl_addstore';
         var colnamewhere = 'tl_addstore_id';
         var colmsg = 'tl_addstore_treat_cardmsg';
         var _token = $('input[name=_token]').val();
     

      $.ajax({
      method: "POST",
      url:"{{url('/readmore')}}",
      data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}

    })
    .done(function( response ) {
 // console.log(response);
  console.log(response); 
  
  document.getElementById("readmoremsg").innerHTML = response;
    $('#myModal').modal('show');

});
  
}





 </script>

@endsection