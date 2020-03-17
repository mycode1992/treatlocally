@extends('tl_admin.layouts.frontlayouts')

@section('content')

<section class="content-header">
      <h1>
        CONTACT
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Contact</li>
      </ol>
    </section>

    <a type="button" href="{{url('/')}}/export/exportcon_queries" class="btn exportfileBtn">Export XLS File</a>

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
                  <th class="text-center">Email</th>
                  <th class="text-center">Phone</th>
                  <th class="text-center">Company Name</th>
                  <th class="text-center">Message</th>
                 
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($users AS $users_val)
              <?php $sn++; ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $users_val->tl_contactus_name }}</td>
                  <td>{{ $users_val->tl_contactus_email }}</td>
                  <td>{{ $users_val->tl_contactus_phone }}</td>
                  <td>{{ $users_val->tl_contactus_company }}</td>
                  <td><?php $string = $users_val->tl_contactus_message ;
                               if (strlen($string) > 100) {
                                $stringCut = substr($string, 0, 100);
                                $endPoint = strrpos($stringCut, ' ');
                            
                                //if the string doesn't contain any space then it will cut without word basis.
                                $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                $string .= '... <a href="javascript:void(0)" onclick="return readmore('.$users_val->tl_contactus_id.')">Read More</a>';
                            }
                            echo $string;

                     ?></td>
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  
                </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

              <p data-toggle="modal" data-target="#myModal" id="readmoremod" style="display:none">test</p>

              
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

              <!-- modal end -->


              </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

<script>
  $(document).ready(function() {
    $('#table').DataTable();
} );

function readmore(id){
  var _token = $('input[name=_token]').val();
  $.ajax({
  method: "POST",
   url: "{{url('/support/getcontactmsg/')}}",
  data: { id: id, _token: _token}

})
 .done(function( response ) {
 // console.log(response);
  console.log(response[0]);
  
  $('#readmoremod').click();
 $('#readmoremsg').text(response[0].tl_contactus_message);

});
}
 </script>

@endsection