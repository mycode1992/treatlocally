<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/   

Route::get('/welcome', function () {
    return view('welcome');
});



Route::get('/tladminpanel', function () {
    return view('tl_admin.login');
});



Route::get('/', 'frontUser_Controller@get_index'); 
Route::get('/about-us', 'frontUser_Controller@getaboutus'); 
Route::get('/privacy-policy', 'frontUser_Controller@getprivacypolicy');
Route::get('/terms&condition', 'frontUser_Controller@get_terms_condition');
Route::get('/FAQ', 'frontUser_Controller@get_faq'); 
Route::get('/blog/{id?}', 'frontUser_Controller@get_blog'); 
Route::get('/blog-detail/{id?}', 'frontUser_Controller@blog_detail'); 
Route::post('/blogviewcount', 'frontUser_Controller@blogviewcount');

Route::post('/tl_admin/forgot_email', 'frontUser_Controller@forgot_email'); 
Route::get('/tl_admin/changepassword/{id?}', 'frontUser_Controller@changepassword');  
Route::post('/tl_admin/change_password  ', 'frontUser_Controller@change_password'); 

Route::post('/subscribesubmit', 'frontUser_Controller@subscribesubmit');
Route::get('/unsubscribe/{id?}', 'frontUser_Controller@unsubscribe');    
Route::get('/subscribe/{id?}', 'frontUser_Controller@subscribe');

Route::any('/search', 'frontUser_Controller@get_search');

// Route::get('/make_treat_personal/{id?}', 'frontUser_Controller@get_make_treat_personal'); 
Route::get('/make_treat_personal/{id}', 'frontUser_Controller@get_make_treat_personal'); 
Route::post('/store_make_treat_personal', 'frontUser_Controller@store_make_treat_personal'); 
Route::post('/store_make_treat_personal1', 'frontUser_Controller@store_make_treat_personal1'); 
Route::any('/payment_mode/{id}', 'frontUser_Controller@payment_mode'); 
Route::post('/store_payment', 'frontUser_Controller@store_payment'); 
Route::post('/addtocart', 'frontUser_Controller@addtocart'); 
Route::post('/remove_cart_item', 'frontUser_Controller@remove_cart_item'); 
Route::post('/deletecart_card_item', 'frontUser_Controller@deletecart_card_item'); 
Route::any('/thankyou/{id?}', 'frontUser_Controller@thankyou');
Route::post('/showmodal/addaddress', 'frontUser_Controller@addaddress'); 
Route::post('/addrecipient_address', 'frontUser_Controller@addrecipient_address');
Route::post('/addrecipient_useaddress', 'frontUser_Controller@addrecipient_useaddress');
Route::post('/chkcartitem_ispersonalise', 'frontUser_Controller@chkcartitem_ispersonalise');
Route::post('/useaddress', 'frontUser_Controller@useaddress'); 
Route::post('/useanotheraddress', 'frontUser_Controller@useanotheraddress'); 



Route::get('/user/addcart', function () {     
    return view('frontend.user.addcart');
}); 

Route::get('/user/savecart', function () {     
    return view('frontend.user.savecart');
}); 



Route::get('/merchant-signup', 'merchantController@index');     
Route::POST('/add_merchant', 'merchantController@add_merchant'); 

Route::get('/merchant-signin', 'merchantController@merchant_signin');  
Route::POST('/merchant/login', 'merchantController@login'); 
Route::get('/merchant/Logout', 'merchantController@logout'); 

Route::get('forgot-password', 'merchantController@forgot_password');    
Route::POST('/merchant/forgot_email', 'merchantController@forgot_email'); 
Route::get('/merchant/change-password/{id?}', 'merchantController@change_password');    
Route::post('/merchant/change_password', 'merchantController@changepassword'); 
Route::get('/merchant/verify-email/{id?}', 'merchantController@verify_email'); 


Route::get('/merchant/myprofile', 'merchantController@myprofile');
Route::POST('/edit_profile', 'merchantController@edit_profile');
Route::POST('/user/edit_profile', 'userController@edit_profile');  
Route::POST('/changepassword', 'merchantController@merchant_changepassword'); 
Route::get('/merchant/mybusiness', 'merchantController@get_mybusiness'); 
Route::post('/mybuissness', 'merchantController@mybusiness'); 


Route::get('/merchant/addstore', 'merchantController@get_addstore'); 
Route::post('/merchantaddstore', 'merchantController@addstore');  

Route::get('/merchant/product', 'merchantController@product');    

Route::get('/merchant/order_history', 'merchantController@order_history'); 
Route::get('/merchant/edit-card/{id}', 'merchantController@edit_card'); 
Route::post('/merchant/update_card', 'merchantController@update_card'); 

Route::get('/merchant/order_historydetail', 'merchantController@order_historydetail'); 
Route::get('/merchant/support', 'merchantController@support'); 
Route::post('/merchant/submit_support', 'merchantController@submit_support'); 
Route::get('/merchant/add_voucher/{id?}', 'merchantController@get_product'); 
Route::post('/viewproductdetail', 'merchantController@viewproductdetail');  
 
Route::post('/merchant/addproduct', 'merchantController@addproduct'); 
Route::post('/deleteproduct', 'merchantController@deleteproduct');  

Route::get('merchant/connect_account', 'merchantController@connect_account');
Route::post('/merchant/connect_stripe', 'merchantController@connect_stripe');  

Route::get('/merchant/current-order', 'merchantController@current_order');
Route::get('/merchant/current-order/view-detail/{id}', 'merchantController@currentorder_viewdetail'); 
Route::get('/merchant/current-order/view-treat/{cart_uniqueid}', 'merchantController@currentorder_viewtreat');
Route::get('/merchant/complete-order/view-treat/{cart_uniqueid}', 'merchantController@completeorder_viewtreat');  
Route::get('/merchant/completed-order', 'merchantController@completed_order'); 
Route::post('/merchant/completeorder', 'merchantController@completeorder');
Route::post('/merchant/partial_reedeem', 'merchantController@partial_reedeem'); 
Route::get('/merchant/view-voucher/{cartid}', 'merchantController@view_voucher'); 
Route::get('/merchant/delivery-address/{proid}/{cartuniqueid}', 'merchantController@delivery_address');





//////////////////////////     

Route::get('/user/signup/{id?}', 'userController@index'); 
Route::POST('/add_user', 'userController@add_user'); 
Route::get('/user/account', 'userController@account'); 
Route::POST('/user/login', 'userController@login'); 
Route::get('/user/myprofile', 'userController@myprofile'); 
Route::get('/user/Logout', 'userController@logout'); 
Route::get('/user/forgot-password', 'userController@forgot_password');    
Route::POST('/user/forgot_email', 'userController@forgot_email'); 
Route::post('/user/submit_support', 'userController@submit_support'); 
Route::get('/user/support', 'userController@support'); 



Route::get('/user/change-password/{id?}', 'userController@change_password');  
Route::post('/user/change_password', 'userController@changepassword'); 

Route::get('/user/treathistory', 'userController@treathistory');  
Route::get('/user/current-order/view-detail/{id}', 'userController@currentorder_viewdetail'); 


//////////////////////////

Route::get('/contact', 'frontUser_Controller@index')->name('storecontact');     
Route::POST('/contact', 'frontUser_Controller@store');

Route::get('/tl_admin/forgot-password', function () {     
    return view('tl_admin.forgot_password');

});           

Route::POST('/openmodalprdinfo', 'frontUser_Controller@openmodalprdinfo'); 
Route::POST('/openmodalstorepro', 'frontUser_Controller@openmodalstorepro');
Route::POST('/openproductinfo', 'frontUser_Controller@openproductinfo');
Route::POST('/prdinfo', 'frontUser_Controller@prdinfo'); 
Route::get('/review_treat/{id?}', 'frontUser_Controller@review_treat');   
               


 


Route::get('/user-account/treathistory_detail', function () {     
    return view('frontend.user.treathistory_detail');
});






Route::get('/error', function () {     
    return view('frontend.error');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//////////////////////  ROUTES FOR ADMIN   //////////////////////////

Route::POST('tl_admin/login', 'frontUser_Controller@login'); 

//Route::group(['middleware' => 'auth'], function () {

Route::get('/tl_admin/Logout', 'adminController@logout'); 
Route::post('/tl_admin/remove_pro_image', 'adminController@remove_pro_image'); 
Route::get('/dashboard', 'adminController@get_dashboard');   
Route::get('/dasboard/support/contact', 'adminController@get_contact_detail');    
Route::post('/support/getcontactmsg/', 'adminController@getcontactmsg');

Route::get('/dashboard/cms/about-us', 'adminController@get_about_us');
Route::get('/Newsletter-signups', 'adminController@get_websubscriber');
Route::post('/cms/websubsstatus/', 'adminController@websubsstatus');

Route::post('/dashboard/addaboutus', 'adminController@addaboutus');

Route::get('/cms/privacy-policy', 'adminController@get_privacy_policy');
Route::post('/updateprivacy', 'adminController@updateprivacypolicy');          

Route::get('/cms/terms&condition', 'adminController@get_terms_condition');
Route::post('/updatetermscondition', 'adminController@updatetermscondition');

Route::get('/cms/faqs', 'adminController@get_faqs');
Route::post('/cms/faqsupdate/', 'adminController@faqsupdate');
Route::get('/cms/addfaqcat/{id?}', 'adminController@get_addfaqscat');
Route::post('/cms/addfaqcat', 'adminController@store_addfaqscat');
Route::get('/cms/addfaq/{id?}', 'adminController@get_addfaqs');     
Route::post('/cms/addfaq', 'adminController@store_addfaqs');
Route::get('/cms/faqdetail/{id?}', 'adminController@get_faqdetail');
Route::post('/cms/faqdetailupdate/', 'adminController@faqdetailupdate');
Route::get('/cms/manage-social-link', 'adminController@manage_social_link');
Route::post('/cms/save_sociallink', 'adminController@save_sociallink');
Route::get('/cms/postage-packaging', 'adminController@postage_packaging');
Route::post('/cms/postagecost', 'adminController@postagecost');
Route::get('/cms/thankyou', 'adminController@thankyou');
Route::post('/cms/thankyou_update', 'adminController@thankyou_update');
Route::get('/cms/contact-us', 'adminController@contact_us');
Route::post('/contactus/update_icon1', 'adminController@update_icon1');
Route::post('/contactus/update_icon2', 'adminController@update_icon2');
Route::post('/contactus/update_icon3', 'adminController@update_icon3');



Route::get('/cms/managehomepage', 'HomeController@managehomepage');
Route::post('/updatebanner', 'HomeController@updatebanner');
Route::post('/update_icon1', 'HomeController@update_icon1');
Route::post('/update_icon2', 'HomeController@update_icon2');
Route::post('/update_icon3', 'HomeController@update_icon3');
Route::post('/update_merchant', 'HomeController@update_merchant');


Route::get('/blogmodule/addblog', 'adminController@get_blog');
Route::post('/addblog', 'adminController@addblog');
Route::get('/blogmodule/banner', 'adminController@get_banner');
Route::post('/updateblogbanner', 'adminController@updateblogbanner'); 
Route::get('/blogmodule/blogpage', 'adminController@blogpage');
Route::post('/blog/getblogdesc', 'adminController@getblogdesc');   
Route::post('/changestatus', 'adminController@changestatus');    
Route::post('/featuretreat', 'adminController@featuretreat');    
Route::post('/readmore', 'adminController@readmore');   
Route::get('/blogmodule/editblog/{id}', 'adminController@editblog');  
Route::post('/updateblog', 'adminController@updateblog');    

///////////////////merchant/////////////////////////////
Route::get('/merchantmodule/merchant', 'adminController@merchant'); 
Route::get('/merchantmodule/addmerchant/{id?}', 'adminController@get_merchant');   
Route::post('/addmerchant', 'adminController@addmerchant');  
Route::get('/merchantmodule/viewstore/{id}', 'adminController@viewstore');  
Route::get('/merchantmodule/addstore/{id}', 'adminController@get_addstore');   
Route::post('/addstore', 'adminController@addstore');  
Route::get('/merchantmodule/editstore/{id}', 'adminController@get_editstore');   
Route::post('/updatestore', 'adminController@updatestore');  
Route::post('/viewbusiness', 'adminController@viewbusiness');     
 

Route::get('/ordermodule/current-order', 'adminController@current_order'); 
Route::get('/ordermodule/current-order/view-treat/{id}', 'adminController@currentorder_viewtreat'); 
Route::post('/completeorder', 'adminController@completeorder');
Route::get('/ordermodule/completed-order', 'adminController@completed_order'); 
Route::get('/ordermodule/edit-card/{proid}/{cartid}', 'adminController@edit_card'); 
Route::get('/ordermodule/view-card/{proid}/{cartid}', 'adminController@view_card'); 
Route::post('/ordermodule/partial_reedeem', 'adminController@partial_reedeem'); 
Route::post('/ordermodule/update_card', 'adminController@update_card'); 
Route::get('/ordermodule/view-voucher/{cartid}', 'adminController@view_voucher'); 
Route::get('/ordermodule/delivery-address/{proid}/{cartuniqueid}', 'adminController@delivery_address'); 
Route::get('/ordermodule/complete-order/view-treat/{id}', 'adminController@completeorder_viewtreat'); 



Route::get('/merchantmodule/viewproduct/{id}', 'adminController@viewproduct');  
Route::get('/merchantmodule/addproduct/{id}', 'adminController@get_addproduct'); 
Route::post('/addproduct', 'adminController@addproduct');     
Route::get('/merchantmodule/editproduct/{id}', 'adminController@get_editproduct');   
Route::post('/updateproduct', 'adminController@updateproduct'); 
Route::get('/merchantmodule/merchant-of-the-month', 'adminController@merchant_of_the_month');
Route::post('/merchantmodule/save_merc_month', 'adminController@save_merc_month'); 
 

Route::get('/cms/treat-for', 'adminController@treat_for');  
Route::get('/cms/add-treat-for/{id?}', 'adminController@add_treat_for');  
Route::post('/addtreatfor', 'adminController@addtreatfor');  
Route::post('/deletetreatfor', 'adminController@deletetreatfor');  
Route::get('/cms/view-subcategory/{id}', 'adminController@view_subcategory');  
Route::get('/cms/add-sub-category/{id?}', 'adminController@add_sub_category'); 
Route::post('/addsubcat', 'adminController@addsubcat');  


Route::get('/support-enquiry', 'adminController@support_enquiry');  
Route::get('/merchant/support-enquiry-merchant', 'adminController@support_enquiry_merchant');  
Route::get('/user/support-enquiry-user', 'adminController@support_enquiry_user'); 


///////////////////merchant/////////////////////////////
Route::get('/usermodule/user', 'adminController@user');
Route::any('/usermodule/exportuserdata', 'adminController@exportuserdata');
Route::any('/usermodule/edituser/{id?}', 'adminController@edit_user');
Route::post('/update_user', 'adminController@update_user');  
Route::post('/deleteuser', 'adminController@deleteuser'); 





/////////////////////////product/////////////////////
Route::get('/product', 'adminController@all_product'); 


////////////////////////manage category//////////////   
Route::get('/cms/category', 'adminController@get_category');   
Route::get('/cms/add_category/{id?}', 'adminController@add_category'); 
Route::post('/store_category', 'adminController@store_category');  



/////////////////////////////////export/////////////////////


Route::get('/export/exportcon_queries', 'adminController@exportcon_queries');  
Route::get('/export/exportweb_subscription', 'adminController@exportweb_subscription');  
Route::get('/cms/Personalise-info','adminController@Personalise_info');  
Route::post('/save_personaliseinfo','adminController@save_personaliseinfo');


Route::get('/testpay','frontUser_Controller@testpay');
Route::post('/makecharge','frontUser_Controller@makecharge');
Route::get('/rahul','frontUser_Controller@rahul');

Route::get('/printcard', function () {
    return view('tl_admin.order.printcard');
}); 

 Route::post('/deleterowstatus', 'adminController@deleterowstatus');



//});