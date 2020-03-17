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

 <section class="content-header">
      <h1>
          View Voucher
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">View Voucher</li>
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
                  <th class="text-center">Name</th>
                  <th class="text-center">Image</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Rest Amount</th>
                  <th class="text-center">Partial Redeem</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)   
              <?php    
              $sn++;            
               $cart_id = $data_val->cart_id;       
              $cart_uniqueid = $data_val->cart_uniqueid;           
              $tl_product_name = $data_val->tl_product_name; 
              $userid = $data_val->userid; 
              $store_id = $data_val->store_id; 
              $tl_product_image1 = $data_val->tl_product_image1; 
              $tl_product_description = $data_val->tl_product_description; 
              $tl_product_price = $data_val->tl_product_price; 
              $tl_cart_partial_reedeem = $data_val->tl_cart_partial_reedeem;   

                  if($tl_cart_partial_reedeem==''){
                      $restamt = $tl_product_price;
                  }else{
                     $restamt = $tl_cart_partial_reedeem;
                  }
              
             
              ?>
                 <tr>
                    <td><?php echo $sn; ?></td>
                    <td>{{$tl_product_name}}</td>   
                   <td class="tl-merchantimg"> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $tl_product_image1 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$tl_product_image1";?>');" style="width:100px"></td>
                   
                   <td>{{$tl_product_price}}</td> 
                     <td>{{$restamt}}</td>

                   <td>
                     <a href="javascript:void(0)" onclick="openReedeem({{$cart_id}},{{$store_id}},{{$restamt}},{{$userid}});">Redeem </a>
                  </td>
                     

                 </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

           <!-- Modal -->

           <div class="modal" id="myModal1" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    
                    <div class="modal-body">
                      <p id="readmoremsg1"></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>


           <div class="modal" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="#" onsubmit="return partialreedeem();">
                    <div class="modal-body">
                     
                      <p id="readmoremsg">
                      <div> Rest Voucher Amount : <span id="restprice">100</span></div>
                        <div>
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
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
     
  </section>

  <script language="javascript"> 

  function openImgModal(path)
  {
   
    $("#readmoremsg1").html("<img src='"+path+"' style='width: 100%;'>");
    $('#myModal1').modal('show');
  }

   function openReedeem(cart_id,store_id,restprice,userid)
        {     
              if(userid==null){
                userid = 'GUEST';
              }

          $('#restprice').text(restprice);
          $('#rest_amt').val(restprice);
          $('#userid').val(userid);
          $('#cart_id').val(cart_id);
          $('#store_id').val(store_id);
         
            $('#myModal').modal('show');
        }

  function partialreedeem(){

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

            if(rest_amt>reedeem_amt)
              {
               // console.log(reedeem_amt);  return false;
                $.ajax({
                headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
                method: "POST",
                url: "{{url('/ordermodule/partial_reedeem')}}",
                data: { reedeem_amt:reedeem_amt,rest_amt:rest_amt,userid:userid,cart_id:cart_id,store_id:store_id}

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

  </script>


@endsection