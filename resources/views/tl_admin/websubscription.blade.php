@extends('tl_admin.layouts.frontlayouts')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<section class="content-header">
      <h1>
        NEWSLETTER SIGNUP
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Newsletter Signup</li>
      </ol>
    </section>

    <a type="button" href="{{url('/')}}/export/exportweb_subscription" class="btn exportfileBtn">Export XLS File</a>

       <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
           
            <!-- /.box-header -->
            <div class="box-body">
             
              <table id="example" class="table table-bordered table-striped table-hover">
              <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <thead>
                
                <tr>
                  <th>S.No.</th>
                  <th>Email</th>
                  <th>Date</th>
               
                  <th>Status</th>
            
                </tr>
                </thead>
                <tbody>
                 <?php
                   $sn = 0;
                 ?>
                 @foreach($data AS $data_val)
                           <?php $sn++; ?>
                  <tr>
                    <td>{{ $sn }}</td>
                    <td>{{ $data_val->tl_subscribe_email }}</td>
                    <td>{{ $data_val->tl_subscribe_date }}</td>
                 
                    <td> 
                    <?php if($data_val->tl_subscribe_admin_status =='1')
                    {
                      $success='btn-success';
                      $admintext='Subscribed';
                    }
                    else
                    {
                      $success='btn-danger';
                      $admintext='Unsubscribed';
                    }
                    ?>
                    
                    <button type="button" class="btn btn-block <?php echo $success; ?> btn-flat" onclick="return changestatus(<?php echo $data_val->tl_subscribe_id.','.$data_val->tl_subscribe_admin_status;?>);">                    
                    <?php echo $admintext; ?> 
                    </button>
                  </td>
                  </tr>

                     @endforeach
               
              
            
                 
              
               
                </tbody>
             
              </table>
                
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example').DataTable({
    	"language": {
    "lengthMenu": '<div> <select class="troopets_selectbox">'+
      '<option value="10">10</option>'+
      '<option value="20">20</option>'+
      '<option value="30">30</option>'+
      '<option value="40">40</option>'+
      '<option value="50">50</option>'+
      '<option value="60">60</option>'+

      '<option value="-1">All</option>'+
      '</select> <span class="record">Records Per Page </span></div>'
  }
    });
    soTable = $('#example').DataTable();
	$('#srch-term').keyup(function(){
         soTable.search($(this).val()).draw() ;
   });

$('.something').click( function () {
var ddval = $('.something option:selected').val();
console.log(ddval);
var oSettings = oTable.fnSettings();
oSettings._iDisplayLength = ddval;
oTable.fnDraw();
});
oTable = $('#example').dataTable();

} );

</script>
    <script type="text/javascript">
        function changestatus(id,status){
        
        var status_val;
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
          url: "{{url('/cms/websubsstatus/')}}",
        data: { id: id, status: status_val, _token: _token}

        })
        .done(function( msg ) {
        console.log(msg);

        var tempst=0;
        var tempstr="";
        var colorclass;
        if(status==0)
        {
          // alert('status');
          tempst=1;
          tempstr="Inactive";
          colorclass="btn-danger";
          color="#3c763d";
        }

        if(status==1)
        {
          // alert(status);
          tempst=0;
          tempstr="Active";
          colorclass="btn-success";
          color="#ec1b52";
        }

          setTimeout(function() { location.reload(true) }, 1000);
        // $("#statusbutton").html(" <a href='#' class='btn btn-block "+colorclass+" btn-flat'  onclick='changestatus("+id+","+tempst+")'>"+tempstr+"</a>");
        // $("#statusbutton").html("<h1>dsfrgrthtrh<h1>");
        // document.getElementById("statusbutton").innerHTML = "Hello JavaScript!"

        });


        }
</script>

@endsection