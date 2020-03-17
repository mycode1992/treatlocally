@extends('tl_admin.layouts.frontlayouts')

@section('content')
<?php
$segment = Request::segment(3);

?>

<section class="content-header">
      <h1>
          Merchant Support Enquiry
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active"> Merchant Support Enquiry</li>
      </ol>
    </section>
 
<section class="content">
  <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
   

   <table id="example" class="table support_enquiry_merchant">
                <thead>
                <tr>
                  <th class="text-center">S.No.</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Phone</th>
                  <th class="text-center">Message</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
              $sn++; 
              $id = $data_val->tl_support_id;
              $email = $data_val->tl_support_email;
              $phone = $data_val->tl_support_phone;
              $message = $data_val->tl_support_message;
              ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $email }}</td>
                  <td>{{ $phone }}</td>
                  <td>
                     <?php $string = $message;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                   
                       //if the string doesn't contain any space then it will cut without word basis.
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                       $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$id.')">Read More</a>';
                   }
                   echo $string;

            ?>
                  </td>
               
                </tr>
          @endforeach
          <input type="hidden" name="_token"  value="{{ csrf_token()}}">
               
                </tbody>
             
              </table>
            
 <a type="button" href="{{url('/support-enquiry')}}" class="tl-btn-defult hvr-sweep-to-right">Go Back</a>
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
 

function readmore(id)
{
   
		 var tblname='tl_support';
         var colnamewhere = 'tl_support_id';
         var colmsg = 'tl_support_message';
		 
       // console.log(_token); return false;
		  $.ajax({
        headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
		  method: "POST",
		  url:"{{url('/readmore')}}",
		  data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg}

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