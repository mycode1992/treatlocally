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
    $segment = Request::segment(2);
?>

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1 class="info-box-text">
            Treat Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">Treat Detail</li>
      
      </ol>
    </section>
  
     <section class="content">
      
      <div class="row">
       <div class="col-md-12">          
          <div class="tl_treat_detail"  id="tl_content">
            <div class="tl_treat_cols">
            <div class="tl_teat_title"> </b>To  :-</b> {{ucfirst($recieptdetail[0]->tl_recipient_name)}}</div>
            <div class="tl_teat_address"><b>Address :-</b> {{$recieptdetail[0]->tl_recipient_address}}</div>
              @foreach($treat AS $value)
            <div class="tl_teat_proname"><b>Product Name :-</b> {{$value->tl_product_name}}</div> 
            <div class="tl_teat_img"><h3>Product image </h3> <img src="{{url('/public/tl_admin/upload/merchantmod/product/')}}/{{$value->tl_product_image1}}"><div><b>Description</b> <?php echo $value->tl_product_description; ?></div></div> 
            @endforeach
            <div class="tl_treat_from"><b>From :-</b> {{ ucfirst($userdetail[0]->tl_tuser_fullname) }}</div>
            </div>
          </div>
          <a type="button" href="javascript:history.go(-1)" class="go-backbtn hvr-sweep-to-right" >Go Back</a>

            <a type="button" href="javascript:void(0)" onclick="printDiv('tl_content')" class="go-backbtn hvr-sweep-to-right">print</a>
      </div><!-- end of row -->
      </div>
    </section>
  
    <!-- /.content -->
  

<script type="text/javascript">
  function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        w=window.open();
        w.document.write(printContents);
        w.print();
        w.close();
    }
</script>

@endsection