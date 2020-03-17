@extends('tl_admin.layouts.frontlayouts')

@section('content')

<?php   
    if(isset($data['merchant']) && count($data['merchant']) > 0)
    {
      $merchantofmnth  = $data['merchant'][0]['tl_merchant_of_monthbgimg'];
      $merchantofmnth_logo = $data['merchant'][0]['tl_merchant_of_month_logo'];
     $merchantofmnth_title = $data['merchant'][0]['tl_merchant_of_month_title'];
     $merchantofmnth_desp = $data['merchant'][0]['tl_merchant_of_month_desp'];
    }
    else
    {
        $merchantofmnth  = '';
        $merchantofmnth_logo = '';
         $merchantofmnth_title = '';
         $merchantofmnth_desp = '';
    }
   
    
?>

<section class="adminManageHomeTitle">
    <h3>Manage Banner</h3>
</section>
<section class="tl-adminManageHome"> 
    <div class="row">
        <div class="col-md-12">
            <div class="adminManageHomeInner">
                <form enctype="multipart/form-data" onsubmit="return updatebanner();" id="updatebannerform" name="updatebannerform">
                    <input type="hidden" name="_token_banner" value="{{ csrf_token()}}">  
                    <div class="tl-fileupload">
                        <label for="" class="form-title-text">Background Image<span class="required">*</span></label>
                        (Image size should be in width 1600px and in height 800px)
                        <input type="file" id="banner_back_img" name="banner_back_img"  class="form-control" onchange="backgroundimg()">
                        <div class="choosebackimg">
                            <span class="hvr-sweep-to-right">Choose File</span>
                            <p class="choosenFileName" id="choosenFileName">No file choosen</p>
                        </div>
                    </div>
                    <div class="tl-upload-img">
                         <img src="{{url('/public')}}/tl_admin/upload/banner/{{ $data[0]['tl_banner_image'] }}" alt="" width="50%" height="20%" class="img-responsive">
                    </div>    
                    <div class="clearfix"></div>

                    <div class="titleFlex">
                        <div>
                            <label for="" class="form-title-text">Title<span class="required">*</span></label>
                        </div>
                        <div class="inputField">
                            <label for="">
                                <input type="text" id="banner_title" name="banner_title" value=" {{ $data[0]['tl_banner_title']  }}" class="form-control">
                            </label>
                            <div id="errormsg_banner" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_banner" style="position: relative !important;display:none;">
                               <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <div>
                            <input type="submit" id="update_banner" class="updateBtn" name="update_banner"  value="Update">
                        </div>
                    </div> 
                 
                    </form>        
                {{-- end manage banner section --}}

                {{-- HOW IT WORKS --}}
                <div class="tlManageWorks">
                    <form enctype="multipart/form-data" onsubmit="return icon1();" id="update_icon1_form" method="post" action="" name="update_icon1_form">
                        <input type="hidden" name="_token_icon1" value="{{ csrf_token()}}">   
                        <h3>Manage How It Works</h3>

                            <label for="" class="form-title-text">Icon 1</label>
                            <div class="tl-fileupload">
                                <label for="">
                                    <input type="file" id="icon1_img" name="icon1_img"  class="form-control">
                                    <span class="hvr-sweep-to-right">Choose Icon</span>
                                </label>  
                            </div>
                            
                            <div class="tlManageIcon">
                                <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon1']}}" alt="" width="10%" height="10%" class="img-responsive">  
                            </div>
                            <div class="txtEditor">
                                <label for="" class="form-title-text txt1">Text 1<span class="required">*</span></label>
                                <textarea id="editor1" name="editor1" class="ckeditor"><?php echo $data['howitworks'][0]['tl_howitworks_text1']; ?></textarea>
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
                        {{-- END HOW IT WORKS --}}

                        {{-- HOW IT WORKS --}}
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
                            <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon2']}}" alt="" width="10%" height="10%" class="img-responsive">
                        </div>
                        <div class="txtEditor">
                            <label for="" class="form-title-text txt2">Text 2<span class="required">*</span></label>
                            <textarea id="editor2" name="editor2" class="ckeditor"><?php echo $data['howitworks'][0]['tl_howitworks_text2']; ?></textarea>
                             <input type="hidden" id="text2desc" name="text2desc" value="">
                        
                            <div id="errormsg_icon2" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon2" style="position: relative !important;display:none;">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                         </div>   

                        <div class="updateBTn">
                            <input type="submit" id="update_icon2" name="update_icon2"  value="update">
                        </div>
                    </form>
                        {{-- END HOW IT WORKS --}}

                         {{-- HOW IT WORKS --}}
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
                            <img src="{{url('/public')}}/tl_admin/upload/howitworks/{{$data['howitworks'][0]['tl_howitworks_icon3']}}" alt="" width="10%" height="10%" class="img-responsive">
                        </div>
                        <div class="txtEditor">
                            <label for="" class="form-title-text txt3">Text 3<span class="required">*</span></label>
                            <textarea id="editor3" name="editor3" class="ckeditor"><?php echo $data['howitworks'][0]['tl_howitworks_text3']; ?></textarea>
                             <input type="hidden" id="text3desc" name="text3desc" value="">
                        
                            <div id="errormsg_icon3" style="font-size: 15px;text-align: center;"></div>
                            <div class="overlay_icon3" style="position: relative !important;display:none;">
                            <i class="fa fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <div class="updateBTn">
                            <input type="submit" id="update_icon3" name="update_icon3"  value="update">
                        </div>
                    </form>          

                     {{-- MERCHAnt of the month --}}
                    <form enctype="multipart/form-data" onsubmit="return merchant();" id="update_merchant_form" method="post" action="" name="update_merchant_form">
                        <input type="hidden" name="_token_merchant" value="{{ csrf_token()}}">   
                        <h3>Merchant of the month</h3>
                                <div class="tl-fileupload mrchnt">
                                    <label for="" class="form-title-text">Background Image</label>
                                        <input type="file" id="merchant_bgimage" name="merchant_bgimage" onchange="uploadimg()"  class="form-control">
                                        <span class="error-msg" id="errorMsg"></span>
                                        <span class="error-msg" id="errorMessage"></span>
                                        <span class="hvr-sweep-to-right bgtransparent">Choose File</span>
                                        <input type="hidden" id="image_name" name="image_name" value="">     
                                        <input type="hidden" name="imagePath" id="imagePath" value="" >
                                        <span id="error17" style="color:red"></span>
                                </div>        
                                    
                                <div class="tl-upload-img" id="edit_image">
                                    <img src="{{url('/public')}}/tl_admin/upload/merchant-of-month/{{$merchantofmnth}}"  width="40%" height="20%" class="img-responsive">
                                </div>
                                <p class="package uploadedImage captonpic" id="imgTest"> </p>
                                <div class="clearfix"></div>
                               <!--  <div class="merchantlogo">
                                    <div class="tl-fileuploadLogo">
                                        <label for="" class="form-title-text">Logo</label>
                                        <label for="">
                                            <input type="file" onchange="uploadimg1()" id="merchant_logo" name="merchant_logo"  class="form-control">
                                            <span class="error-msg" id="errorMsg1"></span>
                                            <span class="error-msg" id="errorMessage1"></span>
                                            <span class="hvr-sweep-to-right bgtransparent">Choose File</span>
                                            <input type="hidden" id="image_name1" name="image_name1" value="">     
                                            <input type="hidden" name="imagePath1" id="imagePath1" value="" >
                                            <span id="error171" style="color:red"></span>
                                        </label>
                                    </div> 
                                    <div class="tl-upload-img-merchantlogo" id="edit_image1">
                                        <img src="{{url('/public')}}/tl_admin/upload/merchant-of-month/{{$merchantofmnth_logo}}"   class="img-responsive">
                                    </div>
                                    <p class="package uploadedImage captonpic" id="imgTest1"> </p>
                                </div> -->
                                <div class="margin-row">
            
                                        <label for="" class="form-title-text txt4">Title<span class="required">*</span></label>
                                   
                                         <input type="text" id="merchant_title" name="merchant_title" class="inputtField" value="{{$merchantofmnth_title}}">

                                </div>
                                         <label for="" class="form-title-text txt5">Description<span class="required">*</span></label>
                                         <div class="tlCkeditor">
                                            <textarea id="editor_merchant" name="editor_merchant" class="ckeditor"><?php echo $merchantofmnth_desp; ?></textarea>
                                         <input type="hidden" id="merchant_desc" name="merchant_desc" value="">
                                    
                                        <div id="errormsg_merchant" style="font-size: 15px;text-align: center;"></div>
                                        <div class="overlay_merchant" style="position: relative !important;display:none;">
                                        <i class="fa fa-refresh fa-spin"></i>
                                        </div>
 
                                         </div>
                                        
                                    <div class="updateBTn">
                                     <input type="submit" id="update_merchant" name="update_merchant"  value="Update">   
                                    </div>
                                
                     
                        </form>         
    {{-- END MERCHANT OF THE MONTH --}}
                </div>
                
                    {{-- END HOW IT WORKS --}}
            </div>
        </div>
    </div>
</section>     



    <script type="text/javascript">
        function updatebanner(){
       
            var _token = $('input[name=_token_banner]').val();
        
            var banner_title =document.getElementById("banner_title").value.trim();
            var banner_back_img =document.getElementById("banner_back_img").value.trim();
            var banner_back_img = $('#banner_back_img')[0].files[0];

             if(banner_title=="")
                {
                
                document.getElementById("errormsg_banner").style.color = "#ff0000";
                document.getElementById("errormsg_banner").innerHTML="Please enter banner title" ; 
                return false;
                }
                else
                {
                    document.getElementById("errormsg_banner").innerHTML="" ; 
                }

                 $(".overlay_banner").css("display",'block');
                 var form = new FormData();
                   form.append('_token', _token);
                    form.append('banner_title', banner_title);
                    form.append('banner_back_img', banner_back_img);
                 $.ajax({    
                    type: 'POST',
                    url: "{{url('/updatebanner')}}",
                    data:form,
                    contentType: false,
                    processData: false,
                    success:function(response) 
                    {
                        $(".overlay_banner").css("display",'none');        
                        var status=response.status;
                        var msg=response.msg;
                        if(status=='200')
                        {
                            document.getElementById("errormsg_banner").innerHTML=msg;
                            document.getElementById("errormsg_banner").style.color = "#278428";
                            setTimeout(function() { location.reload(true) }, 3000);
                        }
                        else if(status=='401')
                        {
                            document.getElementById("errormsg_banner").style.color = "#ff0000";
                            document.getElementById("errormsg_banner").innerHTML=response.msg ;
                        }
                    
                    }

                    });
                    return false;
        }  // end update banner function


        function icon1(){
          //  alert('sweta'); return false;
            var _token = $('input[name=_token_icon1]').val();
            var text1desc =CKEDITOR.instances.editor1.getData();
            var icon1_img =document.getElementById("icon1_img").value.trim();
            var icon1_img = $('#icon1_img')[0].files[0];

            $('#text1desc').val(text1desc); 
            var text1desc=document.getElementById('text1desc').value.trim();
            $(".overlay_icon1").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('icon1_img', icon1_img);
                form.append('text1desc', text1desc);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/update_icon1')}}",
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
            var text2desc =CKEDITOR.instances.editor2.getData();
            var icon2_img =document.getElementById("icon2_img").value.trim();
            var icon2_img = $('#icon2_img')[0].files[0];

            $('#text2desc').val(text2desc); 
            var text2desc=document.getElementById('text2desc').value.trim();
            $(".overlay_icon2").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('icon2_img', icon2_img);
                form.append('text2desc', text2desc);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/update_icon2')}}",
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
            var text3desc =CKEDITOR.instances.editor3.getData();
            var icon3_img =document.getElementById("icon3_img").value.trim();
            var icon3_img = $('#icon3_img')[0].files[0];

            $('#text3desc').val(text3desc); 
            var text3desc=document.getElementById('text3desc').value.trim();
            $(".overlay_icon3").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('icon3_img', icon3_img);
                form.append('text3desc', text3desc);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/update_icon3')}}",
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

function merchant(){
            var _token = $('input[name=_token_merchant]').val();   
            var merchant_title =document.getElementById("merchant_title").value.trim();
            var merchant_desc =CKEDITOR.instances.editor_merchant.getData();
            var merchant_bgimage =document.getElementById("merchant_bgimage").value.trim();
            var merchant_bgimage = $('#merchant_bgimage')[0].files[0];

            //  var merchant_logo =document.getElementById("merchant_logo").value.trim();
            // var merchant_logo = $('#merchant_logo')[0].files[0];

            $('#merchant_desc').val(merchant_desc); 
            var merchant_desc=document.getElementById('merchant_desc').value.trim();
            $(".overlay_merchant").css("display",'block');
            var form = new FormData();
            form.append('_token', _token);
                form.append('merchant_bgimage', merchant_bgimage);
               // form.append('merchant_logo', merchant_logo);
                form.append('merchant_desc', merchant_desc);
                form.append('merchant_title', merchant_title);
        
            $.ajax({    
                type: 'POST',
                url: "{{url('/update_merchant')}}",
                data:form,
                contentType: false,
                processData: false,
                success:function(response) 
                {
                    $(".overlay_merchant").css("display",'none');  
                    console.log(response);      
                    var status=response.status;
                    var msg=response.msg;
                    if(status=='200')
                    {
                        document.getElementById("errormsg_merchant").innerHTML=msg;
                        document.getElementById("errormsg_merchant").style.color = "#278428";
                        setTimeout(function() { location.reload(true) }, 3000);
                    }
                    else if(status=='401')
                    {
                        document.getElementById("errormsg_merchant").style.color = "#ff0000";
                        document.getElementById("errormsg_merchant").innerHTML=response.msg ;
                    }
        
          }

        });
        return false;
} // end update how it works

 var Image_64byte="";
  var filesSelected ="";
  function uploadimg() 
  {
     document.getElementById('error17').innerHTML="";
     var image_name =document.getElementById("image_name").value;
		
     if(image_name!="")
     {
		
       document.getElementById('edit_image').style.display='none';
     }
     
    //$("#hidetxt").css("display", "none");
      var e = document.getElementById("merchant_bgimage"),
          t = e.value,
          n = $("#merchant_bgimage")[0].files[0].size / 1024;
          if (n > 2048) return document.getElementById("image_name").value = " ", document.getElementById("merchant_bgimage").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
         var m = document.getElementById("merchant_bgimage").value,
          m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
          m = m.replace(/[^a-zA-Z0-9]/g, "_");
         var l = m.split("_"),
        d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
        r = l[3] + "." + d;
    if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
    if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("merchant_bgimage").files, filesSelected.length > 0) {
        var g = filesSelected[0],
            a = new FileReader;
        a.onload = function(e) {
            var t = e.target.result,
                n = t.split(",");
            document.getElementById("imagePath").value = n[1];
            var m = document.createElement("img");

            m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_name").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
						document.getElementById('edit_image').style.display='none';
          
        }, a.readAsDataURL(g)
    }

		
		
	
}

 function uploadimg1() 
  {
     document.getElementById('error171').innerHTML="";
     var image_name =document.getElementById("image_name1").value;
		
     if(image_name!="")
     {
		
       document.getElementById('edit_image1').style.display='none';
     }
     
    //$("#hidetxt").css("display", "none");
      var e = document.getElementById("merchant_logo"),
          t = e.value,
          n = $("#merchant_logo")[0].files[0].size / 1024;
          if (n > 2048) return document.getElementById("image_name1").value = " ", document.getElementById("merchant_logo").value = "", document.getElementById("errorMsg1").style.color = "#ff0000", document.getElementById("errorMsg1").innerHTML = "Image size should be less than 2mb", !1;
         var m = document.getElementById("merchant_logo").value,
          m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
          m = m.replace(/[^a-zA-Z0-9]/g, "_");
         var l = m.split("_"),
        d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
        r = l[3] + "." + d;
    if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_name1").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
    if (document.getElementById("errorMsg1").style.color = "", document.getElementById("errorMsg1").innerHTML = "", filesSelected = document.getElementById("merchant_logo").files, filesSelected.length > 0) {
        var g = filesSelected[0],
            a = new FileReader;
        a.onload = function(e) {
            var t = e.target.result,
                n = t.split(",");
            document.getElementById("imagePath1").value = n[1];
            var m = document.createElement("img");

            m.src = t, m.className = "img-responsive", document.getElementById("imgTest1").innerHTML = m.outerHTML, document.getElementById("image_name1").value = r, Image_64byte = document.getElementById("imgTest1").innerHTML
						document.getElementById('edit_image1').style.display='none';
          
        }, a.readAsDataURL(g)
    }

		
		
	
}

    function backgroundimg
    () 
        {
            // alert('sdgvfdg'); return false;
        var fullPath = document.getElementById('banner_back_img').value;
        if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
        //	alert(fullPath); return false;
        document.getElementById("choosenFileName").innerHTML = filename;
        }
        }

    </script>

<style type="text/css">
    .margin-row {
        margin: 25px 0 0 0;
    }
</style>
@endsection