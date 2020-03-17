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
 
  $segment = Request::segment(3);
  $user = DB::table('users')->where('userid',$segment)->select('name')->get();
  $user = json_decode(json_encode($user), True);
?>
<section class="content-header">
      <h1>
          Current Orders
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Current Orders</li>
      </ol>
    </section>

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
                  <th class="text-center">Voucher Ref No.</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Description</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Rest Amount</th>
                  <th class="text-center">Partial Redeem</th>
                  <th class="text-center">Card Info</th>
                   <th class="text-center">Delivery Address</th> 
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($treat AS $treat_val)     
              <?php    
              $sn++;
              $cart_id = $treat_val->cart_id;   
              $cart_uniqueid = $treat_val->cart_uniqueid;   
              $tl_product_id = $treat_val->tl_product_id;   
              $store_id = $treat_val->store_id;
              $userid = $treat_val->userid; 
              $tl_product_name = $treat_val->tl_product_name;   
              $tl_product_image1 = $treat_val->tl_product_image1;    
              $tl_product_description = $treat_val->tl_product_description;
              $tl_product_price = $treat_val->tl_product_price;
              $tl_cart_voucher = $treat_val->tl_cart_voucher;
              $tl_cart_partial_reedeem = $treat_val->tl_cart_partial_reedeem;
              $arr_voucher = explode("_",$tl_cart_voucher);
                   $ref_voucher = $arr_voucher[1];

              $isexists_voucher = DB::table('tbl_tl_product')->where('tl_product_id',$tl_product_id)->where('tl_product_type','Voucher')->select('tl_product_id','tl_product_type')->get();
      
              if($tl_cart_partial_reedeem===null){
                      $restamt = $tl_product_price;
                  }else if($tl_cart_partial_reedeem!=null){
                     $restamt = $tl_cart_partial_reedeem;
                  }else if($tl_cart_partial_reedeem===0.00){
                   
                     $restamt = $tl_cart_partial_reedeem;
                  }
              ?>
                 <tr>
                    <td><?php echo $sn; ?></td>
                    <td>{{ $ref_voucher }}</td>   
                   
                    <td>{{ $tl_product_name }}</td>
                    
                    <td class="tl-merchantimg view-treat-img"> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $tl_product_image1 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$tl_product_image1";?>');" style="width:100px"></td>
                    <td>
                      <?php 
                       
                        $string = $tl_product_description;
                          if (strlen($string) > 100) {
                          $stringCut = substr($string, 0, 100);
                          $endPoint = strrpos($stringCut, ' ');
                      
                          //if the string doesn't contain any space then it will cut without word basis.
                          $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                          $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$cart_id.')">Read More</a>';
                         }
                         echo $string;
                      ?>
                    </td>
                    <td>{{ $tl_product_price }}</td>
                    <td> <?php if(count($isexists_voucher)<=0){ echo 'N/A';}else{ echo $restamt; } 
                    ?></td>
                     <td>
                      <?php 
                          if( count($isexists_voucher) && $tl_cart_partial_reedeem!==0.00){
                       ?> 
                         <a href="javascript:void(0)" onclick="openReedeem({{$tl_product_id}},{{$cart_id}},{{$store_id}},{{$restamt}},{{$userid}});">Redeem </a> </td>
                      <?php }
                          else{ echo 'N/A'; } 
                      ?>
                     
                      <td>
                        <a href="{{url('/ordermodule/edit-card')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">Edit Card</a>
                        <a href="{{url('/ordermodule/view-card')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">View Card</a>
                      </td>
                      <td><a href="{{url('/ordermodule/delivery-address')}}/{{$tl_product_id}}/{{$cart_uniqueid}}">Delivery Address</a></td>
                  
                 </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

           <!-- Modal -->

          

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

                  <div class="modal" id="Reedeemmodal" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                          <form action="#" onsubmit="return partialreedeem();">
                        <div class="modal-body">
                         
                          <p id="readmoremsg">
                          <div> Rest Voucher Amount : <span id="restprice">100</span></div>
                            <div>
                              <input type="hidden" name="tl_product_id" id="tl_product_id" value="">
                              <input type="hidden" name="rest_amt" id="rest_amt" value="">
                              <input type="hidden" name="userid" id="userid" value="">
                              <input type="hidden" name="cart_id" id="cart_id" value="">
                              <input type="hidden" name="store_id" id="store_id" value="">
                              <input type="text" name="reedeem_amt" onkeypress="return isNumberKey(event)" id="reedeem_amt">
                            </div>
                          </p>
                        </div>
                        <div class="modal-footer">
                            <div id="erroramt"></div>
                            <button type="submit" class="btn btn-default">Reedeem</button>
                        
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                      </div>
                      
                    </div>
                  </div>
    
                    <!-- Modal -->
    
             
              
    
                  
                
                <!-- /.box-body -->
              </div>
    

           <input type="hidden" id="rowidd" value="" name="rowidd" />
           <div id="completeorder" class="modal merchantlist-modal" role="dialog" >
             <div class="modal-dialog" style="width:340px !important">
             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to complete this order ?</h4>
              </div>            
               <div class="modal-body" style="text-align: center;">
               <button type="button" class="btn btn-danger btn-sx" onclick=" return complete()" >Complete</button>&nbsp;&nbsp;&nbsp;&nbsp;
               <button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
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
   
    $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
    $('#myModal').modal('show');
  }

  function readmore(id)
    {
      
        var tblname='tbl_tl_user_cart';
            var colnamewhere = 'cart_id';
            var colmsg = 'tl_product_description';
            var _token = $('input[name=_token]').val();
        

          $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url:"{{url('/readmore')}}",
            data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}
           })
          .done(function( response ) {
             // console.log(response);
             //  console.log(response); 
          
          document.getElementById("readmoremsg").innerHTML = response;
            $('#myModal').modal('show');

        });
      
    }

    function partialreedeem(){  

var tl_product_id = parseInt(document.getElementById("tl_product_id").value.trim());
var reedeem_amt = parseInt(document.getElementById("reedeem_amt").value.trim());
var rest_amt = parseInt(document.getElementById("rest_amt").value.trim());
var userid = document.getElementById("userid").value.trim();
var cart_id = document.getElementById("cart_id").value.trim();
var store_id = document.getElementById("store_id").value.trim();


 if(reedeem_amt == "")
   {
     
     document.getElementById('reedeem_amt').style.border='1px solid #ff0000';
     document.getElementById("reedeem_amt").focus();
     $('#reedeem_amt').val('');
     $('#reedeem_amt').attr("placeholder", "Please enter amount");
     $("#reedeem_amt").addClass( "errors" );
     return false;
   }
   else
     {
       
       $('#reedeem_amt').attr("placeholder", "");
       document.getElementById('reedeem_amt').style.border='';
     }


  $('#erroramt').text('Please wait...');

   //  console.log(rest_amt); console.log('vbdfg'+reedeem_amt);//  return false;

      if(rest_amt>=reedeem_amt)
        {
          // console.log(reedeem_amt);  return false;
          $.ajax({
          headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
          method: "POST",
          url: "{{url('/ordermodule/partial_reedeem')}}",
          data: { reedeem_amt:reedeem_amt,rest_amt:rest_amt,userid:userid,cart_id:cart_id,store_id:store_id,tl_product_id:tl_product_id}

          })
          .done(function(response) {
          console.log(response); //return false;
          $('#erroramt').text('');
            if(response.status=='200'){
                  setTimeout(function() { location. reload(true); }, 2000);
              }
          
            else if(response.status=='402'){
            $('#erroramt').text('Amount should be less or equal to voucher amount.');
            }
            else if(response.status=='401'){
            $('#erroramt').text(response.msg);
            }
              
          });
          }
          else
          {
            $('#erroramt').text('');
            $('#erroramt').text('Amount should be less or equal to voucher amount.');
          }



      return false;
      }

      function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
      }

     function openReedeem(productid,cart_id,store_id,restprice,userid)
        {     
              if(userid==null){
                userid = 'GUEST';
              }

          $('#restprice').text(restprice);
          $('#rest_amt').val(restprice);
          $('#tl_product_id').val(productid);
          $('#userid').val(userid);
          $('#cart_id').val(cart_id);
          $('#store_id').val(store_id);
         
            $('#Reedeemmodal').modal('show');
        }

    function comp_order(rowid)
    {
        $("#rowidd").val(rowid);
        $("#completeorder").modal("show");
    }

     function complete(){
        var rowidd =$("#rowidd").val();
        $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url: "{{url('/completeorder')}}",
            data: { cartid: rowidd}

        })
        .done(function( response ) {
        console.log(response); //return false;
        $("#rowidd").val("");
        if(response.status=='200'){
            setTimeout(function() { location. reload(true); }, 2000);
        }
        });
        return false;
    }


      function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
      }

 </script>

@endsection