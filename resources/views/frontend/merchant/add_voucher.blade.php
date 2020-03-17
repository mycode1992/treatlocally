@extends('frontend.layouts.frontlayout')

@section('content')

<!-- about-start -->

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
   if(isset($data) && count($data)>0)
   {   
     $product_type = $data[0]->tl_product_type;
     $treatname = $data[0]->tl_product_name; 
     $product_for = $data[0]->tl_product_for;
     $product_treat_type = $data[0]->tl_product_treat_type; 
     $product_price = $data[0]->tl_product_price;
     $product_validity = $data[0]->tl_product_validity;
     $product_maxlimit = $data[0]->tl_product_maxlimit;
     $product_image1 = $data[0]->tl_product_image1;
     $product_image2 = $data[0]->tl_product_image2;
     $product_image3 = $data[0]->tl_product_image3;
     $product_image4 = $data[0]->tl_product_storeimage; 
     $product_desp = $data[0]->tl_product_description;   
     $product_cardmsg = $data[0]->tl_product_cardmsg;
     $product_id = $data[0]->tl_product_id;
     $product_category = $data[0]->tl_product_categoryid;
     $buttontext = 'Update';

   }
   else
   {
    $product_type = '';
     $treatname = '';
     $product_for = '';
     $product_treat_type = '';
     $product_price = '';
     $product_validity = '';
     $product_maxlimit = '';
     $product_image1 = '';
     $product_image2 = '';
     $product_image3 = '';
     $product_image4 = '';
     $product_desp = '';
     $product_cardmsg = '';
     $product_id = '';
     $product_category = '';
     $buttontext = 'Submit';
   }

?>

<section class="tl-contact tl-about">
	<div class="tl-contact-banner">
		<div class="tl-parallax" style="background-image: url('http://treatlocally.karmatechprojects.com/public/tl_admin/upload/aboutus/5b6d77a66e7fd_1533900710_20180810.jpg');"></div>
		
		
		<div class="tl-caption-title">
			<div class="tl-title wow fadeIn" data-wow-delay="0.3s">Dashboard</div>
		</div>
	</div>

	<div class="container">
		<div class="tl-myaccount-main">
			<div class="row">
					@include('frontend.common.sidebar')
				<div class="col-sm-9 col-md-9 col-xs-12">
					<div class="tl-account-right">
						<div class="tl-account-right-title">Add Product/ Vaucher</div>

						<div class="tl-account-right-form">
							<form class="form-horizontal form-horizontal-tladdproduct" method="post" action="#" onsubmit="return addproduct();" id="addproductform" name="addproductform">
								<input type="hidden" name="_token" value="{{ csrf_token()}}"> 
								<input type="hidden" name="update_id" id="update_id" value="{{$product_id}}"> 
								<div class="box-body">
								  <div class="form-group">
									  <div class="col-sm-12 col-md-4 col-xs-12">
										<label for="inputPassword3" class="tl-about-smallheading">Product Type</label>
										<label for="" class="tl-about-smallheading tl-smallheading-flexbox">
										<div class="gigs-fltr-add">
								             <input type="radio" id="producttype" onClick="return validfunc('hide')" name="producttype" value="Product" <?php if($product_type=='Product'){echo "checked='checked'";}else{ echo "checked='checked'"; }?>>
								            <label for="producttype"><span class="checkbox">Product</span></label>
								        </div>

								        <div class="gigs-fltr-add">
								              <input type="radio" id="producttype1" onClick="return validfunc('show')" name="producttype" value="Voucher"  <?php if($product_type=='Voucher'){echo "checked='checked'";}?>>
								            <label for="producttype1"><span class="checkbox">Voucher</span></label>
								        </div>
										</label>
									  </div>
									  <div class="col-sm-12 col-md-4 col-xs-12">
										<label for="inputPassword3" class="tl-about-smallheading">Treat name *</label>
										<label for="" class="tl-about-smallheading">
											<input type="text" id="treat_name" name="treat_name" value="{{$treatname}}" class="form-control">
										</label>
									  </div>
								  </div>
								</div>
				  
								<div class="box-body">
									<div class="form-group">
									  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Treat for </label>
					
									  <div class="col-sm-12 col-md-10">                         
											<select class="form-control select2" id="treatfor" name="treatfor" multiple="multiple" data-placeholder="Select Relation"
													style="width: 100%;">
													<?php 
													  $relation = DB::table('_relation')->where('status','1')->select('id','name')->get();
                            $dataproductfor=explode(',',$product_for);
                        ?>
													
													@foreach($relation AS $rel_val)
													  <option value="<?=$rel_val->id?>" <?php if(in_array($rel_val->id, $dataproductfor)){echo "selected='selected'";}?>><?=$rel_val->name?></option>
													@endforeach
											</select>
									   
										{{-- <input type="hidden" name="user_id" id="user_id" value="{{$userid}}"> --}}
									  </div>
									</div>
								   
								  </div>
				  
								  <div class="box-body">
									<div class="form-group">
									  <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Treat Type </label>
					
									  <div class="col-sm-12 col-md-10">                         
											<select id="treattype" name="treattype" class="form-control" style="width: 100%;">
													<?php 
													  $treattype = DB::table('_treat_type')->select('id','name')->get();
													?>
													<option value="-1">Please select</option>
													@foreach($treattype AS $type_val)
													  <option value="<?=$type_val->id?>" <?php if($product_treat_type== $type_val->id){echo "selected='selected'";}?>><?=$type_val->name?></option>
													@endforeach
											</select>
									   
										{{-- <input type="hidden" name="user_id" id="user_id" value="{{$userid}}"> --}}
									  </div>
									</div>
								   
                  </div>
                  
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-6 tl-about-smallheading">Product Category </label>
    
                      <div class="col-sm-8">                         
                            <select id="pro_category" name="pro_category" class="form-control" style="width: 100%;">
                                    <?php 
                                      $category = DB::table('tbl_tl_category')->where('tl_category_status','1')->select('tl_category_id','tl_category_name')->get();
                                    ?>
                                    <option value="-1">Please select</option>
                                    @foreach($category AS $category_val)
                                      <option value="<?=$category_val->tl_category_id?>" <?php if($product_category== $category_val->tl_category_id){echo "selected='selected'";}?>><?=$category_val->tl_category_name?></option>
                                    @endforeach
                            </select>
                       
                        {{-- <input type="hidden" name="user_id" id="user_id" value="{{$userid}}"> --}}
                      </div>
                    </div>
                   
                  </div>
				  
								  <div class="box-body">
									<div class="form-group">
									  <div class="col-sm-12 col-md-5 col-xs-12">
										<label for="inputPassword3" class="tl-about-smallheading">Price(£)</label>
										<label for="" class="tl-about-smallheading">
                    <input type="text" class="form-control" id="treat_price" name="treat_price" placeholder="£" onkeypress="return isNumberKey(event)" value="{{$product_price}}"> 
										</label>
									  </div>
									  <div class="col-sm-12 col-md-5 col-xs-12">
									   <label for="inputPassword3" class="tl-about-smallheading">Maximum no. of person/products</label>
									   <label for="" class="tl-about-smallheading">
										  <input type="text" id="max_no" name="max_no"  value="{{$product_maxlimit}}" onkeypress="return isNumberKey(event)" class="form-control">
									   </label>
									  </div>
									</div>
								   
								  </div>
				  
								  <div class="box-body" id="validsection" style="display:none">
									<div class="form-group">
									  <div class="col-md-6 col-sm-6 col-xs-12">
										<label for="inputPassword3" class="tl-about-smallheading">Valid Until</label>
										<label for="" class="tl-about-smallheading">
										   <input type="text" id="treat_valid" name="treat_valid"  value="{{$product_validity}}" class="form-control" placeholder="DD/MM/YYYY"> 
										</label>
									  </div>
									</div>
								   
								  </div>

								  <div class="tl-chooseflexbox">
								  <div class="form-group chooseGroup WeditCat">
								    <div class="col-md-12 col-sm-12 col-xs-12">
											<label for="" class="tl-chooseimg">
											  <span class="tl-textchoose">Choose Image</span>
											  <span class="error-msg" id="errorMsg"></span>
											  <span class="error-msg" id="errorMessage"></span>
											  <input type="file" id="product_imageidd" onchange="uploadprdimg()" class="chooseBtn">
											</label>
											<input type="hidden" value="" id="image_prdname" name="image_prdname">     
											<input type="hidden" name="imageprdPath" id="imageprdPath" value="" >
											<span id="error17"></span>

											<p class="package uploadedImage captonpic" id="imgTest">
					                      <?php 
					                          
					                      if($product_image1!= '')
					                      {
					                       
					                        echo "<img src='".url('/public')."/tl_admin/upload/merchantmod/product/".$product_image1."' style='width:140px'>";
					                      
					                      }
					                  ?>

					                    </p>
										  </div>

									</label>
									</div>
				  
									<div class="form-group chooseGroup WeditCat">
									  <div class="col-sm-12 col-md-12 col-xs-12">
										<label for="" class="tl-chooseimg">
										  <span class="tl-textchoose">Choose Image</span>
										  <span class="error-msg" id="errorMsg1"></span>
										  <span class="error-msg" id=""></span>
										  <input type="file" id="product_imageidd1" onchange="uploadprdimg1()" class="chooseBtn">
										
										  <input type="hidden" value="" id="image_prdname1" name="image_prdname1">     
										  <input type="hidden" name="imageprdPath1" id="imageprdPath1" value="" >
										  <span id=""></span>
										</label>
										<p class="package uploadedImage captonpic" id="imgTest1">
                        <?php 
                          
                        if($product_image2!= '')
                        {
                         
                          echo "<img src='".url('/public')."/tl_admin/upload/merchantmod/product/".$product_image2."' style='width:140px'>";
                        
                        }
                    ?>
  
                      </p>
									  </div>
									</div>

										<div class="form-group chooseGroup WeditCat">
										<div class="col-sm-12 col-md-12 col-xs-12">
										  <label for="" class="tl-chooseimg">
											<span class="tl-textchoose">Choose Image</span>
											<span class="error-msg" id="errorMsg2"></span>
											<span class="error-msg" id=""></span>
											<input type="file" id="product_imageidd2" onchange="uploadprdimg2()" class="chooseBtn">
										   
											<input type="hidden" value="" id="image_prdname2" name="image_prdname2">     
											<input type="hidden" name="imageprdPath2" id="imageprdPath2" value="" >
											<span id=""></span>
										  </label>
										  <p class="package uploadedImage captonpic" id="imgTest2">
	                        <?php 
	                          
	                        if($product_image3!= '')
	                        {
	                         
	                          echo "<img src='".url('/public')."/tl_admin/upload/merchantmod/product/".$product_image3."' style='width:140px'>";
	                        
	                        }
	                    ?>
	  
	                      </p>
										  </div>
                      </div>
                      
                      <div class="form-group chooseGroup WeditCat">
                        <div class="col-sm-12 col-md-12 col-xs-12">
                          <label for="" class="tl-chooseimg">
                          <span class="tl-textchoose">Choose Image</span>
                          <span class="error-msg" id="errorMsg2"></span>
                          <span class="error-msg" id=""></span>
                          <input type="file" id="frontstoreimg" onchange="uploadfrntimg()" class="chooseBtn">
                           
                            <input type="hidden" value="" id="frontstoreimg_name2" name="frontstoreimg_name2">     
                            <input type="hidden" name="frontstoreimg_Path2" id="frontstoreimg_Path2" value="" > 
                          <span id=""></span>
                          </label>
                          <p class="package uploadedImage captonpic" id="imgTest3">
                              <?php 
                                
                              if($product_image4!= '')
                              {
                               
                                echo "<img src='".url('/public')."/tl_admin/upload/storelogo/".$product_image4."' style='width:140px'>";
                              
                              }
                          ?>
        
                            </p>
                          </div>
                          </div>


									  </div>
				  					
				  					<div class="tl-merchanteditor">
									<div class="form-group chooseGroup WeditCat">				  
									  <div class="box-body">
										<div class="form-group">
										  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">Please Enter Description Of The Treat</label>
						
										  <div class="col-sm-10">
											<textarea id="editor1" name="editor1" class="ckeditor"><?php echo $product_desp; ?></textarea>
											 <input type="hidden" id="description" name="description" value="">
										   
										  </div>
										</div>
									   
									  </div>
				  
									  <div class="box-body">
										<div class="form-group">
										  <label for="inputPassword3" class="col-sm-12 tl-about-smallheading">About The Treat</label>
						
										  <div class="col-sm-10">
											<textarea id="editor2" name="editor2" class="ckeditor"><?php echo $product_cardmsg; ?></textarea>
											 <input type="hidden" id="cardmessage" name="cardmessage" value="">
										   
										  </div>
										</div>
									   
									  </div>
										 
							   
								
								<!-- /.box-body -->
								<div id="errormsg" style="font-size: 15px;text-align: center;"></div>
									 <div class="overlay" style="position: relative !important;display:none;">
								<i class="fa fa-refresh fa-spin"></i>
							  </div>
								  <a type="button" onclick="return goBack()" class="tl-btn-defult hvr-sweep-to-right">Go Back</a>
								  <input type="submit" class="tl-btn-defult hvr-sweep-to-right pull-right" value="{{$buttontext}}">
								</div>
								</div>
								<!-- /.box-footer -->
							  </form>
						</div>
					
					</div>
				</div>
			</div>
		</div>
	</div>


</section>

<!-- about-end -->

<script type="text/javascript">
	function validfunc(value){
	
	  if(value=='show'){
		  $('#validsection').css('display','block');
	  }else if(value=='hide'){
		$('#validsection').css('display','none');
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
            document.getElementById("errorMsg2").style.color = "#ff0000", document.getElementById("errorMsg2").innerHTML = "Image size should be less than 2mb", !1;
            
            var m = document.getElementById("frontstoreimg").value,
            m = m.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, "_");
            m = m.replace(/[^a-zA-Z0-9]/g, "_");
            var l = m.split("_"),
            d = t.substring(t.lastIndexOf(".") + 1).toLowerCase(),
            r = l[3] + "." + d;
        if ("png" != d && "jpeg" != d && "jpg" != d) return document.getElementById("frontstoreimg_name2").value = "", document.getElementById("errorMsg2").style.color = "#ff0000", document.getElementById("errorMsg2").innerHTML = "Image only allows file types of PNG,JPG,JPEG", !1;
        if (document.getElementById("errorMsg2").style.color = "", document.getElementById("errorMsg2").innerHTML = "", filesSelected = document.getElementById("frontstoreimg").files, filesSelected.length > 0) {
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

	function addproduct()
{

	
 
  var treatfor = [];
   
    //var producttype = document.getElementsByClassName("producttype").value.trim();
    var producttype = $('input[name=producttype]:checked').val(); 
 
    var treat_name =document.getElementById("treat_name").value.trim();
    var update_id =document.getElementById("update_id").value.trim();
 
    
    var treattype =document.getElementById("treattype").value.trim(); 
    var pro_category =document.getElementById("pro_category").value.trim(); 
    var treat_price =document.getElementById("treat_price").value.trim(); 
    var max_no =document.getElementById("max_no").value.trim(); 
    var treat_valid =document.getElementById("treat_valid").value.trim(); 


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
        document.getElementById("treat_price").focus();
			  $('#treat_price').val('');
			$('#treat_price').attr("placeholder", "Please enter price");
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
  }
   

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

    
  
   $(".overlay").css("display",'block');
   //return false;
    var form = new FormData(); 
       form.append('producttype', producttype);
       form.append('treat_name', treat_name);
       form.append('treatfor', treatfor);  
       form.append('treattype', treattype); 
       form.append('pro_category', pro_category); 
       form.append('treat_price', treat_price); 
       form.append('treat_valid', treat_valid); 
       form.append('max_no', max_no);
       form.append('product_imageidd', product_imageidd);
       form.append('product_imageidd1', product_imageidd1);
       form.append('product_imageidd2', product_imageidd2); 
       form.append('frontstoreimg', frontstoreimg);
       form.append('description', description);   
       form.append('cardmessage', cardmessage);  
       form.append('_token', _token);   
       form.append('update_id', update_id);   


  
    $.ajax({    
    type: 'POST',
    url: "{{url('/merchant/addproduct')}}",
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
         document.getElementById("errormsg").innerHTML=response.msg ;
      }
      
    }

     });
     return false;
 
  }// end of function

function goBack() {
        window.history.back();
    }

     function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
   </script>

<script type="text/javascript">

    $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1')
    //bootstrap WYSIHTML5 - text editor
    // $('.textarea').wysihtml5()
    }); 

</script>

 @endsection