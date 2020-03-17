@extends('tl_admin.layouts.frontlayouts')

@section('content')

@php
    if(isset($data) && count($data)>0)     
    {
        $icon_1_image = $data[0]->icon_1_image;
        $icon_1_title = $data[0]->icon_1_title;
        $icon_1_desp = $data[0]->icon_1_desp;
        $icon_2_image = $data[0]->icon_2_image;
        $icon_2_title = $data[0]->icon_2_title;
        $icon_2_desp = $data[0]->icon_2_desp;
        $icon_3_image = $data[0]->icon_3_image;
        $icon_3_title = $data[0]->icon_3_title;
        $icon_3_desp = $data[0]->icon_3_desp;
    }
    else
    {
        $icon_1_image = '';
        $icon_1_title = '';
        $icon_1_desp = '';
        $icon_2_image = '';
         $icon_2_title = '';
        $icon_2_desp = '';
        $icon_3_image = '';
         $icon_3_title = '';
        $icon_3_desp = '';
    }
    
@endphp

<section class="adminManageHomeTitle">
    <h3>Manage Banner</h3>
</section>
<section class="tl-adminManageHome"> 
    <div class="row">
        <div class="col-md-12">
            <div class="adminManageHomeInner">
                {{-- Icon1 --}}
                <div class="tlManageWorks">
                    <form enctype="multipart/form-data" onsubmit="return icon1();" id="update_icon1_form" method="post" action="" name="update_icon1_form">
                        <input type="hidden" name="_token_icon1" value="{{ csrf_token()}}">   
                        <h3>Contact Us</h3>

                            <label for="" class="form-title-text">Icon 1</label>
                            <div class="tl-fileupload">
                                <label for="">
                                    <input type="file" id="icon1_img" name="icon1_img"  class="form-control">
                                    <span class="hvr-sweep-to-right">Choose Icon</span>
                                </label>  
                            </div>
                            
                            <div class="tlManageIcon">
                                <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$icon_1_image}}" alt="" width="10%" height="10%" class="img-responsive">  
                            </div>

                             <div class="txtEditor">
                                <label for="" class="form-title-text txt1">Title 1<span class="required">*</span></label>
                                 <input type="text" id="icon1_title" name="icon1_title" value="{{$icon_1_title}}">
                            
                                <div id="errormsg_icon1" style="font-size: 15px;text-align: center;"></div>
                                <div class="overlay_icon1" style="position: relative !important;display:none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>

                            <div class="txtEditor">
                                <label for="" class="form-title-text txt1">Text 1<span class="required">*</span></label>
                                <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $icon_1_desp; ?></textarea>
                                 <input type="hidden" id="text1desc" name="text1desc" value="">
                            
                                <div id="errormsg_icon1" style="font-size: 15px;text-align: center;"></div>
                                <div class="overlay_icon1" style="position: relative !important;display:none;">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                            <div class="updateBTn">
                                <input type="submit" id="update_icon1" name="update_icon1"  value="update">
                            </div>
               
                     
                    </form>          
                        
                    <form enctype="multipart/form-data" onsubmit="return icon2();" id="update_icon2_form" method="post" action="" name="update_icon2_form">
                        <input type="hidden" name="_token_icon2" value="{{ csrf_token()}}">   
                        <!-- <h3>Manage How It Works</h3> -->

                        <label for="" class="form-title-text">Icon 2</label>
                        <div class="tl-fileupload">
                            <label for="">
                                <input type="file" id="icon2_img" name="icon2_img"  class="form-control">
                                <span class="hvr-sweep-to-right">Choose Icon</span>
                            </label>
                        </div>    
                        
                        <div class="tlManageIcon">
                            <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$icon_2_image}}" alt="" width="10%" height="10%" class="img-responsive">
                        </div>

                         <div class="txtEditor">
                            <label for="" class="form-title-text txt2">Title 2<span class="required">*</span></label>
                            <input type="text" id="icon2_title" name="icon2_title" value="{{$icon_2_title}}">
                             
                        
                            <div id="errormsg_icon2" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon2" style="position: relative !important;display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                         </div> 

                        <div class="txtEditor">
                            <label for="" class="form-title-text txt2">Text 2<span class="required">*</span></label>
                            <input type="text" name="phone" id="phone" value="{{$icon_2_desp}}" >
                             
                        
                            <div id="errormsg_icon2" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon2" style="position: relative !important;display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                         </div>   


                        <div class="updateBTn">
                            <input type="submit" id="update_icon2" name="update_icon2"  value="update">
                        </div>
                    </form>
                      
                    <form enctype="multipart/form-data" onsubmit="return icon3();" id="update_icon3_form" method="post" action="" name="update_icon3_form">
                        <input type="hidden" name="_token_icon3" value="{{ csrf_token()}}">   
                        <!-- <h3>Manage How It Works</h3> -->

                        <label for="" class="form-title-text">Icon 3</label>
                        <div class="tl-fileupload">
                            <label for="">
                                <input type="file" id="icon3_img" name="icon3_img"  class="form-control">
                                <span class="hvr-sweep-to-right">Choose Icon</span>
                            </label>
                        </div>    
                        <div class="tlManageIcon">          
                            <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$icon_3_image}}" alt="" width="10%" height="10%" class="img-responsive">
                        </div>

                         <div class="txtEditor">
                            <label for="" class="form-title-text txt3">Title 3<span class="required">*</span></label>
                               <input type="text" id="icon3_title" name="icon3_title" value="{{$icon_3_title}}">
                        
                            <div id="errormsg_icon3" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon3" style="position: relative !important;display:none;">
                            <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>

                        <div class="txtEditor">
                            <label for="" class="form-title-text txt3">Text 3<span class="required">*</span></label>
                              <input type="text" name="email" id="email" value="{{$icon_3_desp}}" >
                        
                            <div id="errormsg_icon3" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon3" style="position: relative !important;display:none;">
                            <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <div class="updateBTn">
                            <input type="submit" id="update_icon3" name="update_icon3"  value="update">
                        </div>
                    </form>          

                    
                </div>
                
                  
            </div>
        </div>
    </div>
</section>     



    <script type="text/javascript">
       


        function icon1(){    
          //  alert('sweta'); return false;
            var _token = $('input[name=_token_icon1]').val();
            var text1desc =CKEDITOR.instances.editor1.getData();
            var icon1_title =document.getElementById("icon1_title").value.trim();
            var icon1_img =document.getElementById("icon1_img").value.trim();
            var icon1_img = $('#icon1_img')[0].files[0];

            $('#text1desc').val(text1desc); 
            var text1desc=document.getElementById('text1desc').value.trim();
            $(".overlay_icon1").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('icon1_img', icon1_img);  
                form.append('text1desc', text1desc);
                form.append('icon1_title', icon1_title);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/contactus/update_icon1')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                    $(".overlay_icon1").css("display",'none');  
                    console.log(response);      
             var status=response.status;
            var msg=response.msg;
            if(status=='200')
            {
                 document.getElementById("errormsg_icon1").innerHTML=msg;
                 document.getElementById("errormsg_icon1").style.color = "#278428";
                 setTimeout(function() { location.reload(true) }, 3000);
             }
            else if(status=='401')
             {
                 document.getElementById("errormsg_icon1").style.color = "#ff0000";
                document.getElementById("errormsg_icon1").innerHTML=response.msg ;
            }
        
          }

        });
        return false;
} // end update how it works

 function icon2(){
          //  alert('sweta'); return false;
            var _token = $('input[name=_token_icon2]').val();
            var icon2_img =document.getElementById("icon2_img").value.trim();
            var phone =document.getElementById("phone").value.trim();
             var icon2_title =document.getElementById("icon2_title").value.trim();
            var icon2_img = $('#icon2_img')[0].files[0];
           
            $(".overlay_icon2").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('icon2_img', icon2_img);
                form.append('phone', phone);         
                form.append('icon2_title', icon2_title);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/contactus/update_icon2')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                    $(".overlay_icon2").css("display",'none');  
                    console.log(response);      
             var status=response.status;
            var msg=response.msg;
            if(status=='200')
            {
                 document.getElementById("errormsg_icon2").innerHTML=msg;
                 document.getElementById("errormsg_icon2").style.color = "#278428";
                 setTimeout(function() { location.reload(true) }, 3000);
             }
            else if(status=='401')
             {
                 document.getElementById("errormsg_icon2").style.color = "#ff0000";
                document.getElementById("errormsg_icon2").innerHTML=response.msg ;
            }
        
          }

        });
        return false;
} // end update how it works

 function icon3(){
          //  alert('sweta'); return false;
            var _token = $('input[name=_token_icon3]').val();
            var email =document.getElementById("email").value.trim();
            var icon3_img =document.getElementById("icon3_img").value.trim();
            var icon3_img = $('#icon3_img')[0].files[0];
             var icon3_title =document.getElementById("icon3_title").value.trim();
           
            $(".overlay_icon3").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
            form.append('icon3_img', icon3_img);
            form.append('email', email);
            form.append('icon3_title', icon3_title);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/contactus/update_icon3')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                    $(".overlay_icon3").css("display",'none');  
                    console.log(response);      
             var status=response.status;
            var msg=response.msg;
            if(status=='200')
            {
                 document.getElementById("errormsg_icon3").innerHTML=msg;
                 document.getElementById("errormsg_icon3").style.color = "#278428";
                 setTimeout(function() { location.reload(true) }, 3000);
             }
            else if(status=='401')
             {
                 document.getElementById("errormsg_icon3").style.color = "#ff0000";
                document.getElementById("errormsg_icon3").innerHTML=response.msg ;
            }
        
          }

        });
        return false;
} // end update how it works


    </script>


@endsection