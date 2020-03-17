@extends('tl_admin.layouts.frontlayouts')

@section('content')

<section class="content-header">
      <h1>
        Merchant
        <small>CONTROL PANEL</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Merchant</li>
      </ol>
    </section>
 <div class="col-xs-2" style="margin: 20px 0 10px;">
   
    <a href="{{url('/merchantmodule/addmerchant')}}">
        
        <button type="button" class="btn btn-block btn-warning btn-flat pull-right hvr-sweep-to-right" style="background: #222d32;font-weight: 700;border-color: #222d32;padding:10px 0;">Add Merchant</button>
    </a>

 </div>
   

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
                  <th class="text-center">First Name</th>
                  <th class="text-center">Last Name</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Phone No</th>
                  <th class="text-center">Address</th>
                  <th class="text-center">Post Code</th>
                  <th class="text-center">Store</th>
                  <th class="text-center">Product</th>
                  <th class="text-center">Business</th>
                  <th class="text-center">Edit</th>
                  <th class="text-center">Status</th>
                </tr>
                </thead>

     <tbody>
     <?php
       $sn = 0;
     ?>
          @foreach($data AS $data_val)
              <?php 
              $firstname = $data_val->tl_userdetail_firstname;
              $lastname = $data_val->tl_userdetail_lastname;
              $email = $data_val->email;
              $phone = $data_val->tl_userdetail_phoneno;
              $address = $data_val->tl_userdetail_address; 
              $postcode = $data_val->tl_userdetail_postcode; 
             $status= $data_val->status;
             $userid= $data_val->userid;

             $store =   DB::table('tbl_tl_addstore')->select('tl_addstore_name')
                              ->where('userid',$userid)->get(); 
                            
                if(count($store)>0){
                 $storename =  $store[0]->tl_addstore_name;
                }else{
                   $storename =  '';
                }
                 $sn++; 
                 if($status == '1'){
                    $buttontext = 'ACTIVE';
                    $success='btn-success';
                 }else{
                    $buttontext = 'DEACTIVE';
                    $success='btn-danger';
                 }
              ?>
                 <tr>
                  <td><?php echo $sn; ?></td>
                  <td>{{ $firstname }}</td>
                
                  <td>{{ $lastname }}</td>
                  <td>{{ $email }}</td> 
                  <td>{{ $phone }}</td>
                  <td>{{ $address }}</td>   
                  <td>{{ $postcode }}</td> 
                  <td>
                     {{$storename}}
                      <a href="{{url('/merchantmodule/viewstore/'.$userid)}}">
                        View Detail
                    </a>
                  </td>
                   <td>
                      <a href="{{url('/merchantmodule/viewproduct/'.$userid)}}">
                        View Detail
                    </a>
                  </td>
                  <td>
                      <a href="javascript:void(0);" onclick="return viewbusiness(<?php echo $userid; ?>)">
                        View Detail
                    </a>
                  </td>
                  <td>
                      <a href="{{url('/merchantmodule/addmerchant/'.$userid)}}">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>

                    <a href="javascript:void(0);" onclick=" return deletebtnrow('{{$userid}}')">
                    <img src="{{url('/')}}/public/frontend/img/delete.png" alt="" class="img-responsive">
                    </a>

                </td>
                </td>

                  <td id="{{$userid}}"> 
                    
                    <a href="javascript:void(0);"  class="btn btn-block {{$success}} btn-flat" onclick="return changestatus(<?php echo $userid.','.$status;?>)">                    
                        {{$buttontext}}
                     </a> </td>
                      <input type="hidden" name="_token" value="{{ csrf_token()}}">
                  
                </tr>
          @endforeach
               
                </tbody>
             
              </table>
            

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


           <!-- Modal -->

           <input type="hidden" id="rowidd" value="" name="rowidd" />
           <div id="deletebtn" class="modal merchantlist-modal" role="dialog" >
             <div class="modal-dialog" style="width:340px !important">
             <!-- Modal content-->
             <div class="modal-content">
               <div class="modal-header">
                <h4 class="modal-title">Are you sure you want to delete ?</h4>
              </div>            
               <div class="modal-body" style="text-align: center;">
               <button type="button" class="btn btn-danger btn-sx" onclick=" return deleterow()" >Delete</button>&nbsp;&nbsp;&nbsp;&nbsp;
               <button type="button" id="cancelbutton" class="btn btn-success btn-sx" data-dismiss="modal">Cancel</button>
               </div>      
             </div>
             </div>
           </div>
     
  </section>
<script language="javascript">
  function viewbusiness(userid)
  {
    var _token = $('input[name=_token]').val();
    $.ajax({
      method: "POST",
      url:"{{url('/viewbusiness')}}",
      data: { userid:userid,_token:_token }

    })
    .done(function( msg ) {
           console.log(msg); //return false;
           $("#readmoremsg").html(msg);
           $('#myModal').modal('show');
      
  


       });
  }
    function changestatus(id,status)
{
   
     var tblname='users';
         var status_val;
         var colname = 'userid';
         var colstatus = 'status';
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
      
      function deletebtnrow(rowid)
      {
        
      $("#rowidd").val(rowid);
      $("#deletebtn").modal("show");
      }

      function deleterow()
        {
            var rowidd =$("#rowidd").val();
            var tblname = 'users';
            var colwhere = 'userid';
            var statuscol = 'status';
            $.ajax({
            headers: {'X-CSRF-Token':'{{ csrf_token() }}'},
            method: "POST",
            url: "{{url('/deleterowstatus')}}",
            data: { id: rowidd,tblname: tblname,colwhere: colwhere,statuscol:statuscol}
            
            })
            .done(function( response ) {
              // console.log(response); return false;
              setTimeout(function() { location. reload(true); }, 1000);
                // console.log(response); //return false;
                // $("#rowidd").val("");
                // console.log(response.msg);
                // $("#table_"+rowidd).css("display","none");
                
                // $("#cancelbutton").click();
            });
            return false;
        }

 </script>


@endsection