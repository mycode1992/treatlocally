@extends('tl_admin.layouts.frontlayouts')

@section('content')

 
<section class="content-header">
      <h1>
         Support Enquiry
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Support Enquiry</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/merchant/support-enquiry-merchant')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" style="background: #222d32;font-weight: 700;border-color: #222d32;">Merchant</button>
    </a>

 </div>

 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/user/support-enquiry-user')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right" style="background: #222d32;font-weight: 700;border-color: #222d32;">User</button>
    </a>

 </div>


 @endsection