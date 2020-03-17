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

  <div class="content-wrapper tl-admin-about">
   
    <section class="content-header">
      <h1>
        <?php echo ucfirst($user[0]['name'])."'s";?> Add Product/Voucher
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i>Admin</a></li>
        <li class="active">  Add Product/Voucher</li>
      </ol>
    </section>

       
     <section class="content">

      <div class="row">
       <div class="col-md-12">          
          <div class="tl-addvh-item">
            <form class="form-horizontal form-horizontal-tladdproduct" method="post" action="#" onsubmit="return addproduct();" id="addproductform" name="addproductform">
              <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
              <input type="hidden" name="user_id" id="user_id" value="{{$segment}}">

              <div class="box-body">
                <div class="form-group">
                    <div class="col-sm-4 col-md-4 col-xs-12">
                      <label for="inputPassword3" class="tl-about-smallheading">Product Type</label>
                      <label for="" class="tl-about-smallheading">
                        <div class="gigs-fltr-add">
                             <input type="radio" id="producttype" onClick="return validfunc('hide')" name="producttype" value="Product" checked="checked">
                            <label for="producttype"><span class="checkbox">Product</span></label>
                        </div>
                        <div class="gigs-fltr-add">
                             <input type="radio" id="voucher" onClick="return validfunc('show')" name="producttype" value="Voucher">
                            <label for="voucher"><span class="checkbox">Voucher</span></label>
                        </div>
                      </label>
                    </div>
                    <div class="col-sm-4 col-md-4 col-xs-12">
                      <label for="inputPassword3" class="tl-about-smallheading">Treat name *</label>
                      <label for="" class="tl-about-smallheading">
                          <input type="text" id="treat_name" name="treat_name" value="" class="form-control">
                      </label>
                    </div>
                </div>
              </div>

              <div class="box-body">
                  <div class="form-group">
                   
  
                    <div class="col-sm-8"> 
                       <label for="inputPassword3" class="col-sm-6 tl-about-smallheading" style="width:80%; padding:0;">Treat for </label>
                     <div class="gigs-fltr-add">
                            <input type="checkbox" name="iagree" onclick="return selectallfunc()" id="selectall" value="1">
                            <label for="selectall"><span class="checkbox">Select All</span></label>
                          </div>                        
                          <select class="form-control select2" id="treatfor" name="treatfor" multiple="multiple" data-placeholder="Select Relation"
                                  style="width: 100%;">
                                  <?php 
                                    $relation = DB::table('_relation')->where('status','1')->select('id','name')->get();
                                  ?>
                                  
                                  @foreach($relation AS $rel_val)
                                    <option value="<?=$rel_val->id?>"><?=$rel_val->name?></option>
                                  @endforeach
                          </select>
                         
                          <!-- <input type="checkbox" onclick="return selectallfunc()" id="selectall" >Select All -->
                    </div>
                  </div>
                 
                </div>

                <div class="box-body">
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Treat Type </label>
  
                    <div class="col-sm-8">                         
                          <select id="treattype" name="treattype" class="form-control" style="width: 100%;">
                                  <?php 
                                    $treattype = DB::table('_treat_type')->select('id','name')->get();
                                  ?>
                                  <option value="-1">Please select</option>
                                  @foreach($treattype AS $type_val)
                                    <option value="<?=$type_val->id?>"><?=$type_val->name?></option>
                                  @endforeach
                          </select>
                    </div>
                  </div>
                 
                </div>

                <div class="box-body">
                  <div class="form-group">
                   
  
                    <div class="col-sm-8">      
                        <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Product Category </label>                   
                          <select id="pro_category" onchange="getval(this);" name="pro_category" class="form-control" style="width: 100%;">
                                  <?php 
                                    $category = DB::table('tbl_tl_category')->where('tl_category_status','1')->select('tl_category_id','tl_category_name')->get();
                                  ?>
                                  <option value="-1">Please select</option>
                                  @foreach($category AS $category_val)
                                    <option value="<?=$category_val->tl_category_id?>"><?=$category_val->tl_category_name?></option>
                                  @endforeach
                                  <option value="other">other</option>
                          </select>
                     
                    
                    </div>
                   
                    <div class="col-sm-8" id="addcattab" style="display:none">  
                        <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Add Category </label>                       
                        <label for="" class="tl-about-smallheading">
                            <input type="text" class="form-control" placeholder="Add Category" id="addcategory" name="addcategory"  value=""> 
                       </label>
                    </div>

                    {{-- <div class="col-sm-2"> 
                        <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">&nbsp</label>  
                        <button onclick="return add_category()" id="add_categorybutton" class="tl-btn-defult hvr-sweep-to-right pull-right">Submit</button>
                    </div> --}}

                  </div>
                 
                </div>

                <div class="box-body">
                  <div class="form-group">
                    <div class="col-sm-4 col-md-4 col-xs-12">
                      <label for="inputPassword3" class="tl-about-smallheading">Price(£)</label>
                      <label for="" class="tl-about-smallheading">
                         <input type="text" class="form-control" placeholder="£" id="treat_price" onkeypress="return isNumberKey(event)" name="treat_price" maxlength="5" value=""> 
                      </label>
                    </div>
                    <div class="col-sm-4 col-md-4 col-xs-12">
                     <label for="inputPassword3" class="tl-about-smallheading">Maximum no. of persons/products</label>
                     <label for="" class="tl-about-smallheading">
                        <input type="text" id="max_no" name="max_no"  value="" onkeypress="return isNumberKey(event)" class="form-control">
                     </label>
                    </div>
                  </div>
                 
                </div>

                <div class="box-body" id="validsection" style="display:none">
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <label for="inputPassword3" class="tl-about-smallheading">Valid Until</label>
                      <label for="" class="tl-about-smallheading">
                         <input type="text" id="treat_valid" name="treat_valid" value=""> 
                      </label>
                    </div>
                  </div>
                 
                </div>
                  
                  <div class="tl-chooseflexbox">
                    <div class="form-group chooseGroup WeditCat">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label for="" class="tl-chooseimg">
                          <span class="tl-textchoose">Choose Image</span>
                          <input type="file" id="product_imageidd" onchange="uploadprdimg()" class="chooseBtn">
                          <span class="error-msg" id="errorMsg"></span>
                          <span class="error-msg" id="errorMessage"></span>
                        </label>
                        <input type="hidden" value="" id="image_prdname" name="image_prdname">     
                        <input type="hidden" name="imageprdPath" id="imageprdPath" value="" >
                        <span id="error17"></span>
                        <p class="package uploadedImage captonpic" id="imgTest">
                      </div>
                    </label>
                    </div>

                    <div class="form-group chooseGroup WeditCat">
                      <div class="col-sm-12 col-md-12 col-xs-12">
                        <label for="" class="tl-chooseimg">
                          <span class="tl-textchoose">Choose Image</span>
                          <input type="file" id="product_imageidd1" onchange="uploadprdimg1()" class="chooseBtn">
                          <span class="error-msg" id="errorMsg1"></span>
                          <span class="error-msg" id=""></span>
                        
                          <input type="hidden" value="" id="image_prdname1" name="image_prdname1">     
                          <input type="hidden" name="imageprdPath1" id="imageprdPath1" value="" >
                          <span id=""></span>
                        </label>
                        <p class="package uploadedImage captonpic" id="imgTest1">
                      </div>
                    </div>
                    <div class="form-group chooseGroup WeditCat">
                    <div class="col-sm-12 col-md-12 col-xs-12">
                      <label for="" class="tl-chooseimg">
                        <span class="tl-textchoose">Choose Image</span>
                        <input type="file" id="product_imageidd2" onchange="uploadprdimg2()" class="chooseBtn">
                        <span class="error-msg" id="errorMsg2"></span>
                        <span class="error-msg" id=""></span>                       
                        <input type="hidden" value="" id="image_prdname2" name="image_prdname2">     
                        <input type="hidden" name="imageprdPath2" id="imageprdPath2" value="" >
                        <span id=""></span>
                      </label>
                      <p class="package uploadedImage captonpic" id="imgTest2">
                      </p>
                      </div>
                      </div>

                      <div class="form-group chooseGroup WeditCat">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                          <label for="" class="tl-chooseimg">
                            <span class="tl-textchoose">Choose Image</span>
                            <input type="file" id="frontstoreimg" onchange="uploadfrntimg()" class="chooseBtn">
                            <span class="error-msg" id="errorMsg3"></span>
                            <span class="error-msg" id=""></span>                           
                            <input type="hidden" value="" id="frontstoreimg_name2" name="frontstoreimg_name2">     
                            <input type="hidden" name="frontstoreimg_Path2" id="frontstoreimg_Path2" value="" >
                            <span id=""></span>
                          </label>
                          <p class="package uploadedImage captonpic" id="imgTest3">
                          </p>
                          </div>
                          </div>

                    </div>
                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Please Enter Description Of The Treat</label>
      
                        <div class="col-sm-10">
                          <textarea id="editor1" name="editor1" class="ckeditor"><?php //echo $data_val->tl_terms_condition_content; ?></textarea>
                           <input type="hidden" id="description" name="description" value="">
                         
                        </div>
                      </div>
                     
                    </div>

                    <div class="box-body">
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">About The Treat</label>
      
                        <div class="col-sm-10">
                          <textarea id="editor2" name="editor2" class="ckeditor"><?php //echo $data_val->tl_terms_condition_content; ?></textarea>
                           <input type="hidden" id="cardmessage" name="cardmessage" value="">
                         
                        </div>
                      </div>
                     
                    </div>
                       
                  <div class="box-body">
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">How to redeem your treat?</label>

                  <div class="col-sm-10">
                  <textarea name="reedeem_msg" id="reedeem_msg"  class="form-control" onkeyup="countChar(this);" placeholder="Write a message"></textarea>
                      <span class="tl-msg-text">
                        <p>Maximum character 200</p>
                        <p>Character left - <span id="countCharacter">200</span></p>
                   
                  </div>
                </div>
               
              </div>
              
              <!-- /.box-body -->
              <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                   <div class="overlay" style="position: relative !important;display:none;">
              <i class="fa fa-refresh fa-spin"></i>
            </div>
                <a type="button" href="{{url('/merchantmodule/viewproduct')}}/{{$segment}}" class="tl-btn-defult hvr-sweep-to-right">Go Back</a>
                <input type="submit" id="button_pro" class="tl-btn-defult hvr-sweep-to-right pull-right" value="submit">
              </div>
              <!-- /.box-footer -->
            </form>

          <!-- /.box -->

          <div class="col-md-1"></div>

        
        
        
      </div><!-- end of row -->
    </section>
  
    <!-- /.content -->
  </div>
 



<script type="text/javascript">


  function validfunc(value){
  
    if(value=='show'){
        $('#validsection').css('display','block');
    }else if(value=='hide'){
      $('#validsection').css('display','none');
    }
  }

  function selectallfunc()
  {
     if($("#selectall").is(':checked') )
      {
          $("#treatfor > option").prop("selected","selected");
          $("#treatfor").trigger("change");
      }
      else
      {
          $("#treatfor > option").prop("selected","");
           $("#treatfor").trigger("change");
      }
  }

  function uploadprdimg() 
    {
        //$("#hidetxt").css("display", "none");
        var e = document.getElementById("product_imageidd"),
            t = e.value,
            n = $("#product_imageidd")[0].files[0].size / 1024;
            if (n > 2048) 
            return document.getElementById("image_prdname").value = " ", 
            document.getElementById("product_imageidd").value = "",
            document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image size should be less than 2mb", !1;
            
            var m = document.getElementById("product_imageidd").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_prdname").value = "", document.getElementById("errorMsg").style.color = "#ff0000", document.getElementById("errorMsg").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
        if (document.getElementById("errorMsg").style.color = "", document.getElementById("errorMsg").innerHTML = "", filesSelected = document.getElementById("product_imageidd").files, filesSelected.length > 0) {
            var g = filesSelected[0],
                a = new FileReader;
            a.onload = function(e) {
                var t = e.target.result,
                    n = t.split(",");
                document.getElementById("imageprdPath").value = n[1];
                var m = document.createElement("img");
                m.src = t, m.className = "img-responsive", document.getElementById("imgTest").innerHTML = m.outerHTML, document.getElementById("image_prdname").value = r, Image_64byte = document.getElementById("imgTest").innerHTML
            
            }, a.readAsDataURL(g)
        }
    }

    function uploadprdimg1() 
    {
        //$("#hidetxt").css("display", "none");
        var e = document.getElementById("product_imageidd1"),
            t = e.value,
            n = $("#product_imageidd1")[0].files[0].size / 1024;
            if (n > 2048) 
            return document.getElementById("image_prdname1").value = " ", 
            document.getElementById("product_imageidd1").value = "",
            document.getElementById("errorMsg1").style.color = "#ff0000", document.getElementById("errorMsg1").innerHTML = "Image size should be less than 2mb", !1;
            
            var m = document.getElementById("product_imageidd1").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_prdname1").value = "", document.getElementById("errorMsg1").style.color = "#ff0000", document.getElementById("errorMsg1").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
        if (document.getElementById("errorMsg1").style.color = "", document.getElementById("errorMsg1").innerHTML = "", filesSelected = document.getElementById("product_imageidd1").files, filesSelected.length > 0) {
            var g = filesSelected[0],
                a = new FileReader;
            a.onload = function(e) {
                var t = e.target.result,
                    n = t.split(",");
                document.getElementById("imageprdPath1").value = n[1];
                var m = document.createElement("img");
                m.src = t, m.className = "img-responsive", document.getElementById("imgTest1").innerHTML = m.outerHTML, document.getElementById("image_prdname1").value = r, Image_64byte = document.getElementById("imgTest1").innerHTML
            
            }, a.readAsDataURL(g)
        }
    }

    function uploadprdimg2() 
    {
        //$("#hidetxt").css("display", "none");
        var e = document.getElementById("product_imageidd2"),
            t = e.value,
            n = $("#product_imageidd2")[0].files[0].size / 1024;
            if (n > 2048) 
            return document.getElementById("image_prdname2").value = " ", 
            document.getElementById("product_imageidd2").value = "",
            document.getElementById("errorMsg2").style.color = "#ff0000", document.getElementById("errorMsg2").innerHTML = "Image size should be less than 2mb", !1;
            
            var m = document.getElementById("product_imageidd2").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("image_prdname2").value = "", document.getElementById("errorMsg2").style.color = "#ff0000", document.getElementById("errorMsg2").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
        if (document.getElementById("errorMsg2").style.color = "", document.getElementById("errorMsg2").innerHTML = "", filesSelected = document.getElementById("product_imageidd2").files, filesSelected.length > 0) {
            var g = filesSelected[0],
                a = new FileReader;
            a.onload = function(e) {
                var t = e.target.result,
                    n = t.split(",");
                document.getElementById("imageprdPath2").value = n[1];
                var m = document.createElement("img");
                m.src = t, m.className = "img-responsive", document.getElementById("imgTest2").innerHTML = m.outerHTML, document.getElementById("image_prdname2").value = r, Image_64byte = document.getElementById("imgTest2").innerHTML
            
            }, a.readAsDataURL(g)
        }
    }

    function uploadfrntimg() 
    {
        //$("#hidetxt").css("display", "none");
        var e = document.getElementById("frontstoreimg"),
            t = e.value,
            n = $("#frontstoreimg")[0].files[0].size / 1024;
            if (n > 2048) 
            return document.getElementById("frontstoreimg_name2").value = " ",   
            document.getElementById("frontstoreimg").value = "",
            document.getElementById("errorMsg3").style.color = "#ff0000", document.getElementById("errorMsg3").innerHTML = "Image size should be less than 2mb", !1;
            
            var m = document.getElementById("frontstoreimg").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("frontstoreimg_name2").value = "", document.getElementById("errorMsg3").style.color = "#ff0000", document.getElementById("errorMsg3").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
        if (document.getElementById("errorMsg3").style.color = "", document.getElementById("errorMsg3").innerHTML = "", filesSelected = document.getElementById("frontstoreimg").files, filesSelected.length > 0) {
            var g = filesSelected[0],
                a = new FileReader;
            a.onload = function(e) {
                var t = e.target.result,
                    n = t.split(",");
                document.getElementById("frontstoreimg_Path2").value = n[1];
                var m = document.createElement("img");
                m.src = t, m.className = "img-responsive", document.getElementById("imgTest3").innerHTML = m.outerHTML, document.getElementById("frontstoreimg_name2").value = r, Image_64byte = document.getElementById("imgTest3").innerHTML
            
            }, a.readAsDataURL(g)
        }
    }

    function getval(val){
       if(val.value=='other'){
        document.getElementById('addcattab').style.display='block';
       }else{
        document.getElementById('addcattab').style.display='none';
       }
    }

function addproduct()
{
 
  var treatfor = [];
  var addcategory = '';
    //var producttype = document.getElementsByClassName("producttype").value.trim();
    var producttype = $('input[name=producttype]:checked').val(); 
 
    var treat_name =document.getElementById("treat_name").value.trim();
   var user_id =document.getElementById("user_id").value.trim();
    
    var treattype =document.getElementById("treattype").value.trim(); 
    var pro_category =document.getElementById("pro_category").value.trim(); 
    var treat_price =document.getElementById("treat_price").value.trim(); 
    var max_no =document.getElementById("max_no").value.trim(); 
    var treat_valid =document.getElementById("treat_valid").value.trim(); 
    var reedeem_msg =document.getElementById("reedeem_msg").value.trim();      


    var description =CKEDITOR.instances.editor1.getData();
    var cardmessage =CKEDITOR.instances.editor2.getData();      

    var _token = $('input[name=_token]').val(); 
   
    var product_imageidd =document.getElementById("product_imageidd").value.trim();
    var product_imageidd = $('#product_imageidd')[0].files[0];
 
    var product_imageidd1 =document.getElementById("product_imageidd1").value.trim();
    var product_imageidd1 = $('#product_imageidd1')[0].files[0];

  var product_imageidd2 =document.getElementById("product_imageidd2").value.trim();
    var product_imageidd2 = $('#product_imageidd2')[0].files[0];
    var frontstoreimg =document.getElementById("frontstoreimg").value.trim();
    var frontstoreimg = $('#frontstoreimg')[0].files[0];
   // alert(product_imageidd); return false;        
   $('#treatfor :selected').each(function(i, selected) {
    treatfor[i] = $(selected).val();
            });  

             if(treat_name=="")  
    {
     
      document.getElementById('treat_name').style.border='1px solid #ff0000';
			  document.getElementById("treat_name").focus();
			  $('#treat_name').val('');
			$('#treat_name').attr("placeholder", "Please enter treat name");
			  $("#treat_name").addClass( "errors" );
			  return false;
    }
    else
    {
      document.getElementById("treat_name").style.border = ""; 
    }

   if(treatfor=="")  
    {
     
      document.getElementById("treatfor").style.border='1px solid #ff0000';
         document.getElementById("treatfor").focus();
         $("#treatfor").addClass( "errors" );
          return false;
    }
    else
    {
      document.getElementById('treatfor').style.border='';
    }

    if(treattype=="-1")  
    {
     
      document.getElementById("treattype").style.border='1px solid #ff0000';
         document.getElementById("treattype").focus();
         $("#treattype").addClass( "errors" );
          return false;
    }
    else
    {
      document.getElementById('treattype').style.border='';
    }

    if(pro_category=="-1")  
    {
     
      document.getElementById("pro_category").style.border='1px solid #ff0000';
         document.getElementById("pro_category").focus();
         $("#pro_category").addClass( "errors" );
          return false;
    }
    else
    {
      document.getElementById('pro_category').style.border='';
    }

    if(pro_category=="other")  
    {
        addcategory = document.getElementById("addcategory").value;
        if(addcategory=="")  
          {
            document.getElementById('addcategory').style.border='1px solid #ff0000';
              document.getElementById("addcategory").focus();
              $('#addcategory').val('');
            $('#addcategory').attr("placeholder", "Please enter category");
              $("#addcategory").addClass( "errors" );
              return false;
          }
          else
          {
            document.getElementById("addcategory").style.border = ""; 
          }
    }
    

    if(treat_price=="")  
    {
     
      document.getElementById('treat_price').style.border='1px solid #ff0000';
			  document.getElementById("treat_price").focus();
			  $('#treat_price').val('');
			$('#treat_price').attr("placeholder", "Please enter price");
			  $("#treat_price").addClass( "errors" );
			  return false;
    }
    else if(treat_price==0){
        document.getElementById('treat_price').style.border='1px solid #ff0000';
        document.getElementById("treat_price").focus();
        $('#treat_price').val('');
      $('#treat_price').attr("placeholder", "Please enter price");
        $("#treat_price").addClass( "errors" );
        return false;
    }else if(treat_price.length>5){
        document.getElementById('treat_price').style.border='1px solid #ff0000';
        document.getElementById("treat_price").focus();
        $('#treat_price').val('');
      $('#treat_price').attr("placeholder", "Price cannot be more than 5 digits.");
        $("#treat_price").addClass( "errors" );
        return false;
    }
    else
    {
      document.getElementById("treat_price").style.border = ""; 
    }

    if(max_no=="")  
    {
     
      document.getElementById('max_no').style.border='1px solid #ff0000';
			  document.getElementById("max_no").focus();
			  $('#max_no').val('');
			$('#max_no').attr("placeholder", "Please enter max number of person/product");
			  $("#max_no").addClass( "errors" );
			  return false;
    }
    else
    {
      document.getElementById("max_no").style.border = ""; 
    }

    if(producttype=="Voucher")  
    {
      if(treat_valid=="")  
       {
        document.getElementById('treat_valid').style.border='1px solid #ff0000';
          document.getElementById("treat_valid").focus();
          $("#treat_valid").addClass( "errors" );
          return false;
       }
      else
      {
        
        document.getElementById("treat_valid").style.border = ""; 
      }
  }else if(producttype=="Product"){
    treat_valid = '';
  }
   // console.log('dfrg'+treat_valid); return false;
  if(description=="")  
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter description" ; 
      return false;
    }
    else
    {
       $('#description').val(description);
        document.getElementById("errormsg").innerHTML="" ; 
        var description = document.getElementById('description').value.trim();
    }

    if(cardmessage=="")  
    {
     
      document.getElementById("errormsg").style.color = "#ff0000";
      document.getElementById("errormsg").innerHTML="Please enter message" ; 
      return false;
    }
    else
    {
       $('#cardmessage').val(cardmessage);
        document.getElementById("errormsg").innerHTML="" ; 
        var cardmessage = document.getElementById('cardmessage').value.trim();
    }

     if(reedeem_msg=="")  
    {
     
      document.getElementById("reedeem_msg").style.border='1px solid #ff0000';
         document.getElementById("reedeem_msg").focus();
         $("#reedeem_msg").addClass( "errors" );
          return false;
    }
    else
    {
      document.getElementById('reedeem_msg').style.border='';
    }

    
    document.getElementById("button_pro").disabled = true;
   $(".overlay").css("display",'block');
  // return false;          
    var form = new FormData();             
       form.append('user_id', user_id);
       form.append('producttype', producttype);
       form.append('treat_name', treat_name);
       form.append('treatfor', treatfor);    
       form.append('pro_category', pro_category); 
       form.append('treattype', treattype); 
       form.append('treat_price', treat_price); 
       form.append('treat_valid', treat_valid); 
       form.append('max_no', max_no);
       form.append('product_imageidd', product_imageidd);
       form.append('product_imageidd1', product_imageidd1);
       form.append('product_imageidd2', product_imageidd2); 
       form.append('frontstoreimg', frontstoreimg);
       form.append('description', description);   
       form.append('cardmessage', cardmessage);  
       form.append('addcategory', addcategory);  
       form.append('_token', _token);   
       form.append('reedeem_msg', reedeem_msg);   


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/addproduct')}}",
    data:form,
    contentType: false,
    processData: false,
    success:function(response) 
    {
      var status=response.status;
      var msg=response.msg;
      
        console.log(response); // return false;
      $(".overlay").css("display",'none');        
      
      if(status=='200')
      {

        document.getElementById("errormsg").innerHTML=msg;
         document.getElementById("errormsg").style.color = "#278428";
         
          setTimeout(function() { location.reload(true) }, 3000);
      }
      else if(status=='401')
      {
         
        document.getElementById("errormsg").style.color = "#ff0000";
         document.getElementById("errormsg").innerHTML=response.msg;
         
      }
      
    }

     });
     return false;
 
  }// end of function


    function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

      function countChar(val){
      var len = val.value.length;
        if(len>200){
          val.value = val.value.substring(0, 200);
            }else{
              $('#countCharacter').text(200 - len);
            }
      }
     
    </script>

<script type="text/javascript">

    $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    // $('.textarea').wysihtml5()
    })
    </script>



 <!--<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">-->
<style>
  .gigs-fltr-add {
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-end;
}

.gigs-fltr-add input {
    opacity: 0;
}

.gigs-fltr-add label {
    position: relative;
    margin: 0;
}

.gigs-fltr-add span.checkbox {
    font-size: 14px;
    font-weight: normal;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: block;
    text-transform: initial;
    color: #000 !important;
}

.gigs-fltr-add span.checkbox::before {
    content: '\f00c';
    font-family: 'FontAwesome';
    left: -10px;
    top: 1px;
    color: transparent;
    transition: color .2s;
    background: #fff;
    position: relative;
    width: 20px;
    height: 20px;
    float: left;
    line-height: 18px;
    text-align: center;
    border: solid 1px #000;
}

.gigs-fltr-add input[type="checkbox"]:checked+label span.checkbox::before {
    color: #000;
}
</style>
  
@endsection