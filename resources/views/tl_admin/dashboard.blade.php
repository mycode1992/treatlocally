@extends('tl_admin.layouts.frontlayouts')

@section('content')
<?php
   $count_subs = count($total_subscriber);  
   $count_contact = count($total_contact);
   $count_actice_merchant = count($total_merchant_active);  
   $count_deactive_merchant = count($total_merchant_deactive);
   $count_active_user = count($total_user_active);  
   $count_deactive_user = count($total_user_deactive);
   $count_active_product = count($total_product_active);  
   $count_deactive_product = count($total_product_deactive);
   $total_order = count($total_order);
?>
<section class="content">
    
    <div class="row">
      <div class="col-lg-4 col-xs-12">
     
        <div class="small-box bg-aqua">
              <div class="inner flex-inner-box">
                <div class="flex-inner">
                  <h3>{{$count_subs}}</h3>

                  <p>Total Subscribers</p>
                </div>
              </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{url('/Newsletter-signups')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-xs-12">
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">
            <div class="flex-inner">
               <h3>{{$count_contact}}</h3>

               <p>Total Contact Queries</p>
           </div>
           </div>
       <div class="icon">
         <i class="ion ion-bag"></i>  
       </div>
       <a href="{{url('/dasboard/support/contact')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div>
      <div class="col-lg-4 col-xs-12">
     
        <div class="small-box bg-aqua">
              <div class="inner flex-inner-box">
                 <div class="flex-inner"> 
                  <h3>{{$total_order}}</h3>

                  <p>Total Orders</p>
                 </div> 
              </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{url('/ordermodule/current-order')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

       <div class="col-lg-4 col-xs-12">
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">

            <?php
             $created_date=date('Y-m-d');
             $sqlorder_today= DB::table('tbl_tl_order')->where('tl_order_created_at', 'like', $created_date.'%')->get();
              
               if(count($sqlorder_today)> 0){ 
                  $count_todayorder = count($sqlorder_today);   
                }else{
                   $count_todayorder = '0'; 
                      }
           ?>

            <div class="flex-inner"> 
               <h3>{{$count_todayorder}}</h3>

               <p>Today's Orders</p>
           </div>
           </div>
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="{{url('/ordermodule/current-order')}}?today={{$created_date}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div>
   



    <div class="col-lg-4 col-xs-12">
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box"> 
           <?php
             $created_date=date('Y-m-d');
             $sqlData_today= DB::table('users')->where('created_at', 'like', $created_date.'%')->where('role_id','2')->get();
              
               if(count($sqlData_today)> 0){ 
                  $count_todayreg = count($sqlData_today);   
                }else{
                   $count_todayreg = '0'; 
                      }
           ?>
              <div class="flex-inner"> 
                  <h3>  <?php echo $count_todayreg; ?>  </h3> 
                <p>Today's Merchant Registration</p>
               </div> 
           </div> 
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="{{url('/merchantmodule/merchant')}}?today={{$created_date}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div> 

   <div class="col-lg-4 col-xs-12">
     
      <div class="small-box bg-aqua">
            <div class="inner flex-inner-box"> 
            <?php
              $created_date=date('Y-m-d');
              $sqlData_today= DB::table('users')
              ->where('created_at', 'like', $created_date.'%')->where('role_id','3')->get();
               
                if(count($sqlData_today)> 0){ 
                   $count_todayreg = count($sqlData_today);   
                 }else{
                    $count_todayreg = '0'; 
                       }
            ?>
               <div class="flex-inner"> 
                   <h3>  <?php echo $count_todayreg; ?>  </h3> 
                 <p>Today's User Registration</p>
            </div>
          </div>


        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{url('usermodule/user')}}?today={{$created_date}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> 



   

      <div class="col-lg-4 col-xs-12">   
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">
             <div class="flex-inner"> <h3> {{$count_actice_merchant}}</h3> <p>Active Merchants</p> </div>
              <div class="flex-inner"><h3> {{$count_deactive_merchant}}</h3><p>Deactive Merchants </p></div>
             <div class="flex-inner"> <h3><?php echo $total_merchant = $count_actice_merchant + $count_deactive_merchant; ?></h3><p>Total Merchants </p></div>
              
           </div>
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="{{url('/merchantmodule/merchant')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div>

   {{-- <div class="col-lg-4 col-xs-12">
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">
               <div class="flex-inner">
               <h3>0</h3>

               <p>Total Category</p>
           </div>
          </div> 
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div> --}}

  
     
     <div class="col-lg-4 col-xs-12">   
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">
              <div class="flex-inner"> <h3> {{$count_active_product}}</h3><p>Active Products</p> </div>
              <div class="flex-inner"><h3> {{$count_deactive_product}}</h3><p>Deactive Products</p> </div>
              <div class="flex-inner"><h3><?php echo $total_product = $count_active_product + $count_deactive_product; ?></h3><p>Total Products </p></div>
              
           </div>
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="{{'/product'}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div>
   <div class="col-lg-4 col-xs-12">   
     
     <div class="small-box bg-aqua">
           <div class="inner flex-inner-box">
            <div class="flex-inner"><h3> {{$count_active_user}}</h3> <p>Active Users </p> </div>
             <div class="flex-inner"> <h3> {{$count_deactive_user}}</h3><p>Deactive Users</p> </div>
            <div class="flex-inner"> <h3><?php echo $total_user = $count_active_user + $count_deactive_user; ?></h3><p>Total Users</p> </div>
              
           </div>
       <div class="icon">
         <i class="ion ion-bag"></i>
       </div>
       <a href="{{url('/usermodule/user')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
     </div>
   </div>
  
  
      

     

     


    </div>
  
  

  </section>


<style type="text/css">
  .inner.flex-inner-box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
        -ms-flex-pack: center;
            justify-content: center;
    text-align: center;
    min-height: 120px;
}
.flex-inner {
    padding: 0 15px;
}
</style>
@endsection
