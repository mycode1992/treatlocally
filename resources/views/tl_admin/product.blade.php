@extends('tl_admin.layouts.frontlayouts')

@section('content')


<section class="content-header">
      <h1>
        Product List
        <small> &nbsp;&nbsp;&nbsp;CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active"> Product List</li>
      </ol>
    </section>

   

<section class="content">
  <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
          
            <!-- /.box-header -->
            <div class="box-body">
   
  
  <div class="tl-table-merchant">
   <table id="example" class="table">
                <thead>
                <tr>
                  <th class="text-center">S.No.</th>
                  <th class="text-center">Store name</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Treat for</th>
                  <th class="text-center">Treat type</th>
                  <th class="text-center">Price</th>
                  <th class="text-center">Max limit</th>
                  <th class="text-center">Validity</th>

                  <th class="text-center">Image1</th>
                  <th class="text-center">Image2</th>
                  <th class="text-center">Image3</th>
                  <th class="text-center">Description</th>
                  <th class="text-center">Card message</th>
                  <th class="text-center">product type</th>
                  <th class="text-center">Featured</th>
                  <th class="text-center">Status</th>


                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
               $sn++; 
              $id = $data_val->tl_product_id;
              $storename = $data_val->tl_addstore_name;
              $name = $data_val->tl_product_name;
              $productfor = $data_val->tl_product_for;
              $treattype = $data_val->tl_product_treat_type;
              $price = $data_val->tl_product_price;
              $maxlimit = $data_val->tl_product_maxlimit;
             $pro_val= $data_val->tl_product_validity;
             if($pro_val!=''){
              $pro_val = date("Y-m-d", strtotime($pro_val)); 
            }else{
               $pro_val = '';
            }
             $userid= $data_val->userid;  
             $image1= $data_val->tl_product_image1;
             $image2= $data_val->tl_product_image2;
             $image3= $data_val->tl_product_image3;

             $description= $data_val->tl_product_description;
             $cardmsg= $data_val->tl_product_cardmsg;
             $type= $data_val->tl_product_type;
             $status= $data_val->tl_product_status;
             $feature_status= $data_val->tl_product_feature;


              if($status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }

                 if($feature_status == '1'){
                    $buttontext_feature = 'ACTIVE';
                    $success_feature='btn-success';
                 }else{
                    $buttontext_feature = 'DEACTIVE';
                    $success_feature='btn-danger';
                 }
        
           $treattype= DB::table('_treat_type')->select('id','name')->where('id',$treattype)->get();
           $treattype = json_decode(json_encode($treattype), True);

            $productfor = DB::table('_relation')
               ->whereRaw("find_in_set(id,'$productfor')")->get();
         

            //print_r($productfor);
            
                 
              ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $storename }}</td>
                  <td>{{ $name }}</td>
                  <td><?php $pp=0; foreach($productfor as $productlist){
                    $pp++;
                    if($pp!=1){
                      echo ', ';
                    }
                    echo $productlist->name;
                  } ?></td>
                  <td>{{ $treattype[0]['name'] }}</td>
                  <td>{{ $price }}</td>
                  <td>{{ $maxlimit }}</td>
                  <td>{{ $pro_val }}</td>


                  <td class="tl-merchantimg"> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $image1 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$image1";?>');" style="width:100px"></td>

                  <td class="tl-merchantimg"> <?php if($image2!=''){ ?><img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $image2 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$image2";?>');" style="width:100px"> <?php } else{ echo 'N/A'; }?></td>
                  <td class="tl-merchantimg"> <?php if($image3!=''){ ?> <img style="cursor:pointer;" src="{{url('/public')}}/tl_admin/upload/merchantmod/product/{{ $image3 }}" onClick="return openImgModal('<?php echo url('/public')."/tl_admin/upload/merchantmod/product/$image3";?>');" style="width:100px">  <?php } else{ echo 'N/A'; }?> </td>
               
                  <td>
                     <!-- {{ $description }} -->
                     <?php $string = $description;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                   
                       //if the string doesn't contain any space then it will cut without word basis.
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                       $string .= '... <a href="JavaScript:void(0)" onclick="return readmore('.$id.')">Read More</a>';
                   }
                   echo $string;

            ?>
                  </td>
                  <td>
                     <!-- {{ $cardmsg }} -->
                     <?php $string = $cardmsg;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                   
                       //if the string doesn't contain any space then it will cut without word basis.
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                       $string .= '... <a href="javascript:void(0);" onclick="return readmore1('.$id.')">Read More</a>';
                   }
                   echo $string; 
                   ?>
                  </td> 
                  <td>{{ $type }}</td> 
               
                <td id="feature{{$id}}"> 
                    
                  <a href="javascript:void(0);"  class="btn btn-block {{$success_feature}} btn-flat" onclick="return featuretreat(<?php echo $id.','.$status;?>)">                    
                      {{$buttontext_feature}}
                   </a> </td>

                <td id="{{$id}}"> 
                    
                  <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $id.','.$status;?>)">                    
                      {{$buttontext}}
                   </a> </td>
                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  
                </tr>
          @endforeach
               
                </tbody>
             
              </table>
              </div>
            

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
  // alert('edfgr'+path);
  // return false;
  // document.getElementbyId('responseMsg').innerHTML="asdsadsad";
  $("#readmoremsg").html("<img src='"+path+"' style='width: 100%;'>");
  $('#myModal').modal('show');
}

 function featuretreat(id,status)
{
   
    
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
      url:"{{url('/featuretreat')}}",
      data: { id:id, status:status_val,_token:_token }

    })
      .done(function( msg ) {
           console.log(msg); //return false;
    var tempst=0;
    var tempstr="";
    if(status==0)
    {
      tempst=1;
      tempstr="ACTIVE";
      color="btn-success";
    }

    if(status==1)
    {
      tempst=0;
      tempstr="DEACTIVE";
      color="btn-danger";
    }
      
    $("#feature"+id).html("<a href='javascript:void(0);' class='btn btn-block "+color+"' onclick='featuretreat("+id+","+tempst+")'>"+tempstr+"</a>");


       });
  
}

    function changestatus(id,status)
{
   
		 var tblname='tbl_tl_product';
         var status_val;
         var colname = 'tl_product_id';
         var colstatus = 'tl_product_status';
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
		  url:"{{url('/changestatus')}}",
		  data: { id:id, status:status_val,tblname:tblname,colname:colname,colstatus:colstatus,_token:_token }

		})
		  .done(function( msg ) {
           console.log(msg); //return false;
		var tempst=0;
		var tempstr="";
		if(status==0)
		{
		  tempst=1;
		  tempstr="ACTIVE";
		  color="btn-success";
		}

		if(status==1)
		{
		  tempst=0;
		  tempstr="DEACTIVE";
		  color="btn-danger";
		}
      
		$("#"+id).html("<a href='javascript:void(0);' class='btn btn-block "+color+"' onclick='changestatus("+id+","+tempst+")'>"+tempstr+"</a>");


		   });
  
}

function readmore(id)
{
   
		 var tblname='tbl_tl_product';
         var colnamewhere = 'tl_product_id';
         var colmsg = 'tl_product_description';
         var _token = $('input[name=_token]').val();
		 

		  $.ajax({
		  method: "POST",
		  url:"{{url('/readmore')}}",
		  data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}

		})
    .done(function( response ) {
 // console.log(response);
  console.log(response); 
  
  document.getElementById("readmoremsg").innerHTML = response;
    $('#myModal').modal('show');

});
  
}

function readmore1(id)
{
   
     var tblname='tbl_tl_product';
         var colnamewhere = 'tl_product_id';
         var colmsg = 'tl_product_cardmsg';
         var _token = $('input[name=_token]').val();
     

      $.ajax({
      method: "POST",
      url:"{{url('/readmore')}}",
      data: { id:id, colnamewhere:colnamewhere,tblname:tblname,colmsg:colmsg,_token:_token}

    })
    .done(function( response ) {
 // console.log(response);
  console.log(response); 
  
  document.getElementById("readmoremsg").innerHTML = response;
    $('#myModal').modal('show');

});
  
}





 </script>

@endsection