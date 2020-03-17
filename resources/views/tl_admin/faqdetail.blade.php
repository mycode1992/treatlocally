@extends('tl_admin.layouts.frontlayouts')

@section('content')
<!-- Main page work here -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper tl-admin-about">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="info-box-text">
     FAQ's  
     <small>Control panel</small>
   </h1>
   <ol class="breadcrumb">
    <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
    <li class="active">Faqs</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><a href="{{url('/cms/addfaq/')}}"><button type="button" class="btn btn-block btn-warning btn-flat pull-right ">Add Faq</button></a></h3>
          <h3 class="box-title"><a href="#"><button type="button" class="btn btn-block btn-danger btn-flat pull-right" onclick="goBack()">Go Back</button></a></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped table-hover">
          <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <thead>
              <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Edit</th>
                <th>Admin Status</th>
              </tr>
            </thead>
            <tbody>
               <?php $sn=0; ?>
               @foreach($data as $data_val)
               <?php 
                   $sn++; 
                   if($data_val->tl_faq_category_detail_status == 1){
                    $success='btn-success';
                    $admintext='Active';
                  }else{
                    $success='btn-danger';
                    $admintext='Inactive';
                  }
               ?>
                <tr>
                  <td>{{ $sn }}</td>
                  <td>{{ $data_val->tl_faq_category_detail_title}}</td>
                  <td><a href="{{url('/cms/addfaq/')}}/{{$data_val->tl_faq_category_detail_id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                  <td> 
                   
                    <button type="button" class="btn btn-block {{$success}}  btn-flat" onclick="return changestatus(<?php echo $data_val->tl_faq_category_detail_id.','.$data_val->tl_faq_category_detail_status;?>);">                    
                      {{ $admintext}}
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
<!-- /.content -->
</div>
<script type="text/javascript">
function goBack() {<!--  w w  w  .ja va  2  s  .  c  o m-->
    window.history.back()
}

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
  url: "{{url('/cms/faqdetailupdate/')}}",
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
<!-- /.content-wrapper -->
<!-- Main page work here End-->
@endsection