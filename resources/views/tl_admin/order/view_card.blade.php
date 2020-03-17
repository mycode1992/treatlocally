@extends('tl_admin.layouts.frontlayouts')

@section('content')
<?php
    $segment = Request::segment(2); // echo $data[0]->template_id; exit;
    $arr_voucher = explode("_",$storeid[0]->tl_cart_voucher); 
    if($data[0]->template_id==1)
     {
        $temp_image = "temp1.png";
        $temp_image1 = "temp1.png";
     }
     else if($data[0]->template_id==2)
     {
        $temp_image = "temp2.png";
         $temp_image1 = "temp2_1.png";
     }   
     elseif ($data[0]->template_id==3) {
        $temp_image = "temp3.png";
         $temp_image1 = "temp3.png";
     }     
    ?>
<section class="test">
 <a type="button" href="javascript:void(0)" id="basic" class="go-backbtn hvr-sweep-to-right">print</a>

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
<img src="{{url('/')}}/public/print_temp/{{$temp_image}}">
<div class="template template_3" id="one">
<div class="row">
<div class="template-header">   
<div class="title"></div>
<div class="subtitle" id="card2_reciepnt_name" style="font-size: 14px;"><?php echo ucfirst($data[0]->card_recipient_name); ?></div>

<div class="slogtitle" id="card2_occasion"><?php echo ucfirst($data[0]->card_occasion); ?></div>
</div>
<div class="template-container">
<div class="article" id="card2_message" style="font-size: 12px;">
      <?php echo $data[0]->card_message; ?>
</div>

<div class="from">
    <div class="from-title"></div>
    <div class="from-name" id="card2_sender_name" style="font-size: 14px;"><?php echo ucfirst($data[0]->card_sender_name); ?></div>
</div>

<div class="from">
    <div class="from-title"></div>
    <div class="from-name" id="card2_sender_name1" style="font-size: 14px;"><?php echo ucfirst($data[0]->card_sender_name1); ?></div>
</div>

</div>
</div> 
</div>
</div>

<div class="page-break"></div>

<div class="page2 page-relative" style="margin: 0 2px;" id="page2">
<img src="{{url('/')}}/public/print_temp/{{$temp_image1}}">

<div class="template template_3 vh_template_2" id="two">
<div class="row" >
<div class="template-header">   
<div class="title"></div>
<div class="slogtitle" id="card1_occasion"><?php echo ucfirst($data[0]->card_sender_name); ?> <br> is treating you to  <?php echo ucfirst($storeid[0]->tl_product_name); ?> from <br> <?php echo ucfirst($storeid[0]->store_name); ?></div>
</div>
<div class="template-container">
<div class="article" id="card1_message" style="font-size: 12px;">
    <h3>ABOUT THE MERCHANT</h3>
   <?php echo $string = $abt_merchant[0]->tl_addstore_treat_cardmsg; ?>
</div>

<div class="treat-code-area">
    <div class="treat-code-number">{{$arr_voucher[1]}}</div>
   <?php if($pro_validity[0]->tl_product_validity!==null){ ?>
                        <div class="treat-code-validity">Valid till  <?php echo date("Y-m-d", strtotime($pro_validity[0]->tl_product_validity)); ?></div>  
                          <?php } ?>    
</div>
<div class="article" id="card1_message" style="font-size: 12px;">
    <h3>How to redeem your treat?</h3>
    <?php echo $pro_validity[0]->tl_product_redeem; ?>
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


</section>


@endsection