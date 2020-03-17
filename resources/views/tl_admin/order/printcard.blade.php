@extends('tl_admin.layouts.frontlayouts')

@section('content')
 <a id="basic" href="#nada" class="button button-primary">Print container</a>

<div class="container demo" id="printableArea" style="display: -webkit-box;display: -ms-flexbox;display: flex;">
<style type="text/css" media="print">
@page {
    size: auto;  
</style>
	<style>
.page-break {
    page-break-after: always;
}

.page-relative{
	position: relative;
	height:100vh;
}

.page-relative .template{
	position: absolute;
	top:10px;
	left:50%;
	transform:translate(-50%);
}

.template .slogtitle{
	line-height: 24px;
}
.template{
	height:auto;
	background: transparent;
}
.template.template_3.vh_template_2{
	height: auto;
}
.page-relative img {
	border:2px solid #0a0044;
	height: 100%;
}

</style>
<div class="page1 page-relative" id="page1">
<img src="{{url('/')}}/public/print_temp/temp2.png">
<div class="template template_3" id="one">
<div class="row">
<div class="template-header">	
<div class="title"></div>
<div class="subtitle" id="card2_reciepnt_name" style="font-size: 14px;">Ritu Raj</div>

<div class="slogtitle" id="card2_occasion">Happy Birthday</div>
</div>
<div class="template-container">
<div class="article" id="card2_message" style="font-size: 12px;">
	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type 
</div>

<div class="from">
	<div class="from-title"></div>
	<div class="from-name" id="card2_sender_name" style="font-size: 14px;">Tanya</div>
</div>

</div>
</div> 
</div>
</div>

<div class="page-break"></div>

<div class="page2 page-relative" style="margin: 0 2px;" id="page2">
<img src="{{url('/')}}/public/print_temp/temp2.png">

<div class="template template_3 vh_template_2" id="two">
<div class="row" >
<div class="template-header">	
<div class="title"></div>
<div class="slogtitle" id="card1_occasion">Tanya <br> is treating you to The Holly Case from <br> Amps wine merchant</div>
</div>
<div class="template-container">
<div class="article" id="card1_message" style="font-size: 12px;">
	<h3>ABOUT THE MERCHANT</h3>
	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of typea. 
</div>

<div class="treat-code-area">
	<div class="treat-code-number">#246697</div>
	<div class="treat-code-validity">Valid till  1970-01-01</div>	
</div>
<div class="article" id="card1_message" style="font-size: 12px;">
	<h3>How to redeem your treat?</h3>
	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type 
	<!-- "Simply call  on  and make a reservation using this voucher number !" -->

</div>
</div>

</div> 
</div>

</div><!-- end of page two div -->



  










<style type="text/css">
  @media print {
  #print-one{
    page-break-after: always;
  }
   #print-two{
    page-break-after: always;
  }
   #print-three{
    page-break-after: always;
  }
}
</style>

		@endsection