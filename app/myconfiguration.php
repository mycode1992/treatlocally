<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use DB;
use Session;

class myconfiguration extends Model
{
    public function addmerchant($first_name,$last_name,$phoneno,$password,
    $email,$_token,$status,$role_id,$address){

        date_default_timezone_set('Asia/Kolkata');
           $curDate = date("Y-m-d H:i:s"); 
           $ip_address =  \Request::ip();
           $name = $first_name.' '.$last_name;
           $user_id = date('Ymdhis');
          
           $email_exist = $this->isemail_exist($email); 
         
           if(count($email_exist) > 0){
            return response()->json(
              [
              'status' =>'401',
              'msg' => 'E-mail already registered'
              ]);
           }
     else{
          $verify_token=$this->getRandomString(20);
          $sql =    DB::table('users')->insert([
                  'userid'=>  $user_id,
                  'name'=> $name ,
                  'email'=> $email ,
                  'password'=> md5($password) ,
                  'role_id'=>$role_id, 
                  'remember_token'=> $_token ,     
                  'email_verify_token'=>$verify_token,   
                  'email_verify_status'=> '0', 
                  'termscondtion'=> '1', 
                  'status'=> $status,  
                  'created_at'=> $curDate, 
                  'updated_at'=> $curDate 
              ]);

              $sql =    DB::table('tbl_tl_user_detail')->insert([
                'tl_userdetail_userid'=>  $user_id,
                'tl_userdetail_firstname'=> $first_name ,
                'tl_userdetail_lastname'=> $last_name ,
                'tl_userdetail_phoneno'=> $phoneno ,
                'tl_userdetail_address'=> $address ,
                'tl_userdetail_ip'=>  $ip_address, 
                'tl_userdetail_created_at'=> $curDate ,
                'tl_userdetail_updated_at'=> $curDate
            ]);

            if($sql==true){
              $sendemail=$this->WelcomeEmail($name,$email,$verify_token);
              return response()->json(
                [
                'status' =>'200',
                'msg' => 'Successfully registered,Please check your inbox and verify your E-mail address'
                ]);
            }
            else{
              return response()->json(
                [
                'status' =>'401',
                'msg' => 'Something went wrong'
                ]); 
            }

      }   
         }
       // return view('tl_admin.merchant.add_merchant');

       public function login($email,$password,$role_id,$session,$cartunique_id){

                if($cartunique_id!=''){
                    $session_all=Session::get('sessionmerchant');
                    if($session_all==TRUE)
                    {
                        Session::forget('sessionmerchant','userid','role_id','email','name');
                    } 
                }

               $password=md5($password);
                $sql1=DB::table('users')->select('name')
                        ->where('email','=',$email)                        
                        ->where('password','=',$password)
                        ->where('role_id','=',$role_id)
                        ->get();

                if(count($sql1)>0)
                { 
                    $sql=DB::table('users')->select('name','email','userid','role_id')
                        ->where('email','=',$email)                        
                        ->where('password','=',$password)
                        ->where('email_verify_status','=','1')
                        ->where('status','=','1')
                        ->get();
                   if(count($sql)==1)
                    {
                    $userid=$sql[0]->userid;
                    $name=$sql[0]->name;
                    $email=$sql[0]->email;
                    $role_id=$sql[0]->role_id;

                    $data=[
                    'userid'=>$userid,
                    'role_id'=>$role_id,
                    'name'=>$name,
                    'email'=>$email
                    ];
                  Session::put($session, $data); 
                 return response()->json(
                            [
                            'status' =>'200',
                            'cartunique_id' =>$cartunique_id,
                            'msg' => 'Successfully Login'
                            ]); 
                    }
                    else{

                   return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Your email id is not verified,Please check your inbox and verify your account.'
                    ]);

                    }
                   
                }
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'E-Mail or password is incorrect.'
                    ]);
                    
                }


            
        }

        public function logout($session)
        {

          //  Session::flush();
            Session::forget($session,'userid','role_id','email','name');
           // Session::forget('admin_email');
           if(Session()->has($session)){
              return false; 
           }else{
            return true;
           } 
             
          }

          public function forgot_email($email,$role_id){
           
                    $sql=DB::table('users')
                    ->where([
                            ['email','=',$email],
                            ['role_id','=',$role_id]
                        ])
                    ->select('userid')
                    ->get();
                   // print_r($sql); exit;
                        if(count($sql)>0)
                         {
                           
                              $verify_token=$this->getRandomString(20);
                             
                              $sql1= DB::table('users')
                                          ->where('email', $email)
                                          ->update(['remember_token' =>$verify_token,'token_status' => '1','token_verify_status'=>'0']);
                            
                                if($sql1==true)
                              { 
                                 $user = DB::table('users')->where('email', $email)->first();
                                 $name=$user->name;
                                 $sendemail=$this->ForgotPasswordEmail($name,$email,$verify_token,$role_id);
                                  
                                return response()->json(
                                  [
                                  'status' =>'200',
                                  'msg' => 'Please check your inbox and get a new password'
                                  ]);  
                              }
         
         
         
                         }
                      else
                        {
                          
                             return response()->json(
                              [
                              'status' =>'401',
                              'msg' => 'E- mail id does not exist'
                              ]);
                        }
         
         
                  
             }

             function changepassword($password,$con_password,$token,$role_id){
                  
                   if($token!=''){
                       $sql_validtoken = DB::table('users')->select('remember_token')
                                       ->where('remember_token', $token)
                                       ->where('role_id',$role_id)->get();
                   if(count($sql_validtoken)>0)
                   {
                       $sql_expiretoken = DB::table('users')->select('token_status')
                                       ->where([
                                           ['remember_token',$token],
                                           ['token_status','0'],
                                           ['token_verify_status','1']
                                           ])->get();
                       if(count($sql_expiretoken)>0)
                       {
                           return response()->json(
                               [
                               'status' =>'401',
                               'msg' => 'your token has been expire'   
                               ]);
                       }
       
                      if($password!=$con_password)
                      {
                       return response()->json(
                           [
                           'status' =>'401',
                           'msg' => 'Confirm password does not match'
                           ]);
                      }
       
       
       
                      $sql_chgpass = DB::table('users')
                                     ->where([
                                           ['remember_token',$token],
                                           ['role_id',$role_id]
                                         ])
                                     ->update([
                                       'password'=> md5($password),
                                       'token_status'=>'0',
                                       'token_verify_status'=>'1'
                                       ]); 
                                       
                                       
                         // return $sql_chgpass;
                       if($sql_chgpass==true)
                       {
                           return response()->json(
                               [
                               'status' =>'200',
                               'msg' => 'your password has been successfully changed'
                               ]);
                       }
                       else
                       {
                           return response()->json(
                               [
                               'status' =>'401',
                               'msg' => 'Something went wrong'
                               ]);
                       }
                   }
                   else  
                   {
                       return response()->json(
                       [
                       'status' =>'401',
                       'msg' => 'Sorry! invalid token'
                       ]); 
                   }// check for invalid token
                   }
            
           }
           
           private function isemail_exist($email)
           {
             $sql=DB::table('users')->select('email')->where('email',$email)->get();
             
               return $sql;
           }   //  end  getRandomString function


             private function getRandomString($length)
             {
                 $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
                 $validCharNumber = strlen($validCharacters);
                 $result = "";
                 for ($i = 0; $i < $length; $i++)
                 {
             
                     $index = mt_rand(0, $validCharNumber - 1);
                     $result .= $validCharacters[$index];
                 }
                 $finalresult = date('Ymdhis').$result;
                 return $finalresult;
             }   //  end  getRandomString function

             private function ForgotPasswordEmail($name,$email,$token,$role_id)
             {
               if($role_id=='1'){
                $varification_code=url('/').'/tl_admin/changepassword/'.$token;
               }
               else if($role_id=='2'){
                $varification_code=url('/').'/merchant/change-password/'.$token;
               }
               else if($role_id=='3'){
                $varification_code=url('/').'/user/change-password/'.$token;
               }

               $to = $email;
                 
                 $username=$name;
                 $subject ='Treatlocally Forgot Password';
               $baseurl=url('/');
                 $logo_path=url('/').'/public/frontend/img/logo.png';
                 $admin_mail="";
                 $admin_mail3="rituraj.kumar@karmatech.in";
                 $admin_mail2="sweta.gupta@karmatech.in";
                 $message = "<!DOCTYPE html>
                     <html lang='en'>
                     <head>
                     <meta charset='UTF-8'>
                     <title>Treatlocally</title>
                     <style type='text/css'>
                       * {
                          margin: 0;
                          padding: 0;
                       }
                       body {
                          margin: 0;
                          padding: 0;
                          font: normal 12px arial;
                       }
                       .table_center {
                          margin: auto;
                          border: 1px solid #ccc;
                       }
                       .table_center_top {
                          margin: auto;
                          padding-bottom: 3px;
                       }
             
                       a {
                          text-decoration: none;
                       }
                       </style>
                       </head>
                       <body>
                       <table cellpadding='0' cellspacing='0' style='border:1px solid #b22329; padding:10px;margin:auto;width:100%'>
                       <tbody><tr><td><div><header>
                                                   <div style='text-align:center;padding:30px 0'>
                                                    <img src='$logo_path' style='margin: auto; display: block;' />
                                                   </div>
                                                 </header>
                        
                               <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
                            
                                                 <section>
                                                   <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear $username,</p>
                                                   <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Ohh seems that you forgot your password. Click the button below to retrieve new password.
                                                   <br>
                                                   
                                                   </p>
             
                                                   <div>
                               <p style='margin:35px 0; text-align: center;'><a href='$varification_code' style='border: solid;
                                 padding: 10px 20px;
                                 background: #db4437;
                                 text-decoration: none;
                                 color: #fff;
                                 margin: auto;'>Change password</a></p>
                               </div></section></div><span class='m_1398701988460775340im'>
                                      
                                             <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
                                               <img src='$logo_path' alt='Logo' style='width:110px;margin:40px;' class=''>
                                             </div>
                                             <div style='padding:50px 2px;margin:0 2px;float:left'>
                                               <p style='font-size:12px;line-height:25px'><b>Treatlocally Support Team</b></p>
                                             
                                               <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
                                             </div>
                                           </span></td></tr></tbody></table>
             
                               </body>
                               </html>
                                 ";
             
             
             
             
             
                                   $headers  = 'MIME-Version: 1.0' . "\r\n";
                                   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                   $headers .= 'From: Treatlocally <info@Treatlocally.com>' . "\r\n";
                                   $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
                                   if(mail($to, $subject, $message, $headers))
                                   {
                                     $status="success";
                                     return($status);
                                   }
                                   else
                                   {
                                     $status="Error";
                                     return($status);
                                   }
             
             
             }// end of ForgotPasswordEmail
        

             private    function WelcomeEmail($name,$email,$token)
{
	$to = $email;
    $varification_code=url('/').'/merchant/verify-email/'.$token;
    $username=$name;
    $subject ='Welcome To Treatlocally';
	$baseurl=url('/');
    $logo_path=url('/').'/public/frontend/img/logo.png';
    $admin_mail="";
    $admin_mail3="rituraj.kumar@karmatech.in";
    $admin_mail2="sweta.gupta@karmatech.in";
    $message = "<!DOCTYPE html>
				<html lang='en'>
				<head>
				<meta charset='UTF-8'>
				<title>Treatlocally</title>
				<style type='text/css'>
					* {
					   margin: 0;
					   padding: 0;
					}
					body {
					   margin: 0;
					   padding: 0;
					   font: normal 12px arial;
					}
					.table_center {
					   margin: auto;
					   border: 1px solid #ccc;
					}
					.table_center_top {
					   margin: auto;
					   padding-bottom: 3px;
					}

					a {
					   text-decoration: none;
					}
					</style>
					</head>
					<body>
					<table cellpadding='0' cellspacing='0' style='border:1px solid #b22329; padding:10px;margin:auto;width:100%'>
					<tbody><tr><td><div><header>
					                            <div style='text-align:center;padding:30px 0'>
					                             <img src='$logo_path' style='margin: auto; display: block;' />
					                            </div>
					                          </header>
					 
					        <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
					     
					                          <section>
					                            <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear $username,</p>
					                            <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Thanks for registering with us. Click the button below to verify your email.
					                            <br>
					                            
					                            </p>

					                            <div>
									<p style='margin:35px 0; text-align: center;'><a href='$varification_code' style='border: solid;
										padding: 10px 20px;
										background: #db4437;
										text-decoration: none;
										color: #fff;
										margin: auto;'>Verify Email-ID</a></p>
									</div></section></div><span class='m_1398701988460775340im'>
					               
					                      <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
					                        <img src='$logo_path' alt='Logo' style='width:110px;margin:40px;' class=''>
					                      </div>
					                      <div style='padding:50px 2px;margin:0 2px;float:left'>
					                        <p style='font-size:12px;line-height:25px'><b>Treatlocally Support Team</b></p>
					                      
					                        <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
					                      </div>
					                    </span></td></tr></tbody></table>

					        </body>
					        </html>
					          ";





                      $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                      $headers .= 'From: Treatlocally <info@Treatlocally.com>' . "\r\n";
                      $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
                      if(mail($to, $subject, $message, $headers))
                      {
                        $status="success";
                        // return($status);
                      }
                      else
                      {
                        $status="Error";
                        // return($status);
                      }


}// end of WelcomeEmail

private    function SupportEmail($email,$phone,$message)
{
  	$to = 'sweta.gupta@karmatech.in';
  //  $varification_code=url('/').'/merchant/verify-email/'.$token;
    $username=$email;
    $subject ='New Support Ticket';
	$baseurl=url('/');
    $logo_path=url('/').'/public/frontend/img/logo.png';
    $admin_mail="";
    $admin_mail3="rituraj.kumar@karmatech.in";
    $admin_mail2="swetagupta0022@gmail.com";
    $message = "<!DOCTYPE html>
				<html lang='en'>
				<head>
				<meta charset='UTF-8'>
				<title>Treatlocally</title>
				<style type='text/css'>
					* {
					   margin: 0;
					   padding: 0;
					}
					body {
					   margin: 0;
					   padding: 0;
					   font: normal 12px arial;
					}
					.table_center {
					   margin: auto;
					   border: 1px solid #ccc;
					}
					.table_center_top {
					   margin: auto;
					   padding-bottom: 3px;
					}

					a {
					   text-decoration: none;
					}
					</style>
					</head>
					<body>
					<table cellpadding='0' cellspacing='0' style='border:1px solid #b22329; padding:10px;margin:auto;width:100%'>
					<tbody><tr><td><div><header>
					                            <div style='text-align:center;padding:30px 0'>
					                             <img src='$logo_path' style='margin: auto; display: block;' />
					                            </div>
					                          </header>
					 
					        <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
					     
					                          <section>
					                            <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear Admin,</p>
					                            <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'> New support request has been generated by : <br/> <br/> <b>Email : </b >$email <br/> <b>Phone : </b> $phone <br/> <b> Message : </b> $message 
					                            <br>
					                            
					                            </p>

					       
									</div></section><span class='m_1398701988460775340im'>
                         
                                <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
                                  <img src='$logo_path' alt='Logo' style='width:110px;margin:40px;' class=''>
                                </div>
                                <div style='padding:50px 2px;margin:0 2px;float:left'>
                                  <p style='font-size:12px;line-height:25px'><b>Treatlocally Support Team</b></p>
                                
                                  <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
                                </div>
                              </span></div></td></tr></tbody></table>

					        </body>
					        </html>
					          ";





                      $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                      $headers .= 'From: Treatlocally <info@Treatlocally.com>' . "\r\n";
                      $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
                      if(mail($to, $subject, $message, $headers))
                      {
                        $status="success";
                        // return($status);
                      }
                      else
                      {
                        $status="Error";
                        // return($status);
                      }


}// end of WelcomeEmail

public function addstore($store_name,$location,$lat,$lng,$userid,$about_merchant,$termsconditiondesp,$store_logo,$service,$addstore_status,$updateid,$post_code){
   
     date_default_timezone_set('Asia/Kolkata');
     $curDate = date("Y-m-d H:i:s"); 
     $ip_address =  \Request::ip(); 
     
     if($updateid==''){
     if($store_logo!="")
     {

         $extension = $store_logo->getClientOriginalExtension();
         $filesize  =  $store_logo->getClientSize();
         $filename = $store_logo->getClientOriginalName();

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/storelogo/';
         $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
         $upload_image = $store_logo->move($dir, $filename);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload store logo, please try again'
                 ]);
         }
     }else{
       return response()->json(
           [
           'status' =>'401',
           'msg' => 'Please select logo'
           ]);
     }
     

 $sql =    DB::table('tbl_tl_addstore')->insert([
         'userid'=>  $userid,
         'tl_addstore_name'=> $store_name ,
         'tl_addstore_logo'=> $filename ,
         'tl_addstore_address'=>$location ,   
         'tl_addstore_lat'=>$lat ,
         'tl_addstore_lng'=>$lng ,
         'tl_addstore_postcode'=>$post_code ,
         'tl_addstore_aboutmerchant'=>  $about_merchant, 
         'tl_addstore_termscondt'=> $termsconditiondesp ,  
         'tl_addstore_services'=> $service ,  
         'tl_addstore_ip'=>  $ip_address,
         'tl_addstore_created_at'=> $curDate, 
         'tl_addstore_updatedat'=> $curDate,   
         'tl_addstore_status'=> $addstore_status
     ]);

     if($sql==true)
     {
       return response()->json(
         [
         'status' =>'200',
         'req_for'=>'add',
         'msg' => 'Store added successfully!'
         ]);  
     }
     else
     {
         return response()->json(
         [
         'status' =>'401',
         'msg' => 'Something went wrong,please try again'
         ]);
     }
    }
    else{
       
        if($store_logo!="")
     {
      
         $extension = $store_logo->getClientOriginalExtension();
         $filesize  =  $store_logo->getClientSize();
         $filename = $store_logo->getClientOriginalName();

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/storelogo/';
         $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
         $upload_image = $store_logo->move($dir, $filename);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload store logo, please try again'
                 ]);
         }
        
         $sql =    DB::table('tbl_tl_addstore')
                ->where('userid',$updateid)
                ->update([
                    'tl_addstore_name'=> $store_name ,
                    'tl_addstore_logo'=> $filename ,
                    'tl_addstore_address'=>$location ,
                    'tl_addstore_lat'=>$lat ,
                    'tl_addstore_lng'=>$lng ,
                    'tl_addstore_postcode'=>$post_code ,
                    'tl_addstore_aboutmerchant'=>  $about_merchant, 
                    'tl_addstore_termscondt'=> $termsconditiondesp ,  
                    'tl_addstore_services'=> $service , 
                    'tl_addstore_ip'=>  $ip_address,
                    'tl_addstore_updatedat'=> $curDate,
                
                ]);
   
        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
            'req_for'=>'update',
            'msg' => 'Store updated successfully!'
            ]);  
        }
        else
        {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Something went wrong,please try again'
            ]);
        }

     }else{
           

        $sql =   DB::table('tbl_tl_addstore')
        ->where('userid',$updateid)
        ->update([
            'tl_addstore_name'=> $store_name ,
            'tl_addstore_address'=>$location ,
            'tl_addstore_lat'=>$lat ,
            'tl_addstore_lng'=>$lng ,
            'tl_addstore_postcode'=>$post_code ,
            'tl_addstore_aboutmerchant'=>  $about_merchant, 
            'tl_addstore_termscondt'=> $termsconditiondesp , 
            'tl_addstore_services'=> $service ,  
            'tl_addstore_ip'=>  $ip_address,
            'tl_addstore_updatedat'=> $curDate,
        
        ]);
   
        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
            'req_for'=>'update',
            'msg' => 'Store updated successfully!'
            ]);  
        }
        else
        {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Something went wrong,please try again'
            ]);
        }
     }
     
    }
  // return view('tl_admin.merchant.add_merchant');
  } // end of addupdate store


  /// support function
  public function submit_support($email,$phoneno,$support_message,$role_id){

        if($email!=''){
          date_default_timezone_set('Asia/Kolkata');
          $curDate = date("Y-m-d H:i:s"); 
          $ip_address =  \Request::ip(); 

              $sql= DB::table('tl_support')
                     ->insert([
                       'tl_support_roleid' =>$role_id,
                       'tl_support_email' => $email,
                       'tl_support_phone'=>$phoneno,
                       'tl_support_message'=>$support_message,
                       'tl_support_ip' => $ip_address,
                       'tl_support_created_at'=>$curDate,
                       'tl_support_updated_at'=>$curDate,
                       ]);
            
                if($sql==true)
              { 
                 $this->SupportEmail($email,$phoneno,$support_message);
                return response()->json(
                  [
                  'status' =>'200',
                  'msg' => 'Your query has been successfully submitted. We will get back to you shortly.'
                  ]);  
              }
              else
              {
                return response()->json(
                  [
                  'status' =>'401',
                  'msg' => 'Something went wrong, please try again later.'
                  ]);
              }

     
    }
    else
    {
      return response()->json(
        [
        'status' =>'401',
        'msg' => 'Please enter your E-mail Id'
        ]);  
    }

   
   // print_r($sql); exit;
       


  
}

public function addproduct($user_id,$treat_name,$producttype,$treatfor,
$treattype,$treat_price,$treat_valid,$max_no,$description,$cardmessage,$product_imageidd,
$product_imageidd1,$product_imageidd2,$frontstoreimg,$product_status,$updateid,$pro_category){

     date_default_timezone_set('Asia/Kolkata');
     $curDate = date("Y-m-d H:i:s"); 
     $ip_address =  \Request::ip();

     if($updateid==''){
     if($product_imageidd!="")
     {
         $extension = $product_imageidd->getClientOriginalExtension();
         $filesize  =  $product_imageidd->getClientSize();
         $filename1 = $product_imageidd->getClientOriginalName();

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/merchantmod/product';
         $filename1 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename1;
         $upload_image = $product_imageidd->move($dir, $filename1);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload product image, please try again'
                 ]);
         }
     }else{
       return response()->json(
           [
           'status' =>'401',
           'msg' => 'Please select product image'
           ]);
     }///end product image 1

     if($product_imageidd1!="")   // start product image 2
     {
         $extension = $product_imageidd1->getClientOriginalExtension();
         $filesize  =  $product_imageidd1->getClientSize();
         $filename2 = $product_imageidd1->getClientOriginalName();

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/merchantmod/product';
         $filename2 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename2;
         $upload_image = $product_imageidd1->move($dir, $filename2);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload product image, please try again'
                 ]);
         }
     }else{
      $filename2 = '';
     }///end product image 2

     if($product_imageidd2!="")   // start product image 3
     {
         $extension = $product_imageidd2->getClientOriginalExtension();
         $filesize  =  $product_imageidd2->getClientSize();
         $filename3 = $product_imageidd2->getClientOriginalName();

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/merchantmod/product';
         $filename3 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename3;
         $upload_image = $product_imageidd2->move($dir, $filename3);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload product image, please try again'
                 ]);
         }
     }else{
      $filename3 = '';
     }///end product image 3

     if($frontstoreimg!="")   // start store image 3
     {
         $extension = $frontstoreimg->getClientOriginalExtension();
         $filesize  =  $frontstoreimg->getClientSize();
         $filename4 = $frontstoreimg->getClientOriginalName(); 

         if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Upload only jpeg,jpg or png file'
                 ]);
         }
         if($filesize>='2048000')
         {
             return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Image size should be less than 2mb'
                 ]);
         }
         $dir = public_path().'/tl_admin/upload/storelogo';
         $filename4 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename4;
         $upload_image = $frontstoreimg->move($dir, $filename4);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload store image, please try again'
                 ]);
         }
     }else{
       $store_logo =  DB::table('tbl_tl_addstore')->where('userid',$user_id)
                  ->select('tl_addstore_logo')->get();
      if(count($store_logo)>0)
      {
          $filename4 = $store_logo[0]->tl_addstore_logo;
      }else{
          $filename4 = '';
      }
      
     }///end product front 3
     
if($treat_valid!=''){
  $sql =    DB::table('tbl_tl_product')->insert([    
      'userid'=> $user_id ,
      'tl_product_name'=> $treat_name ,
      'tl_product_for'=> $treatfor ,
      'tl_product_categoryid'=>$pro_category ,
      'tl_product_treat_type'=>$treattype ,
      'tl_product_price'=>$treat_price ,
      'tl_product_maxlimit'=>$max_no ,
      'tl_product_validity'=>  $treat_valid, 
      'tl_product_image1'=> $filename1 ,  
      'tl_product_image2'=>  $filename2,
      'tl_product_image3'=> $filename3,
      'tl_product_storeimage'=> $filename4, 
      'tl_product_description'=> $description,
      'tl_product_cardmsg'=> $cardmessage,
      'tl_product_type'=> $producttype,
      'tl_product_ip'=> $ip_address, 
      'tl_product_created_at'=> $curDate,
      'tl_product_updated_at'=> $curDate,  
      'tl_product_status'=> $product_status,
      'tl_product_feature'=> '0'  
  ]);
}else{
  $sql =    DB::table('tbl_tl_product')->insert([
              'userid'=> $user_id ,
              'tl_product_name'=> $treat_name ,
              'tl_product_for'=> $treatfor ,
              'tl_product_categoryid'=>$pro_category ,
              'tl_product_treat_type'=>$treattype ,
              'tl_product_price'=>$treat_price ,
              'tl_product_maxlimit'=>$max_no ,
              'tl_product_image1'=> $filename1 ,  
              'tl_product_image2'=>  $filename2,
              'tl_product_image3'=> $filename3, 
              'tl_product_storeimage'=> $filename4, 
              'tl_product_description'=> $description,   
              'tl_product_cardmsg'=> $cardmessage,
              'tl_product_type'=> $producttype,
              'tl_product_ip'=> $ip_address, 
              'tl_product_created_at'=> $curDate,
              'tl_product_updated_at'=> $curDate,   
              'tl_product_status'=> $product_status,
              'tl_product_feature'=> '0'
              ]);
          }


     if($sql==true)
     {
       return response()->json(
         [
         'status' =>'200',
         'msg' => 'Product added successfully!'
         ]);  
     }
     else
     {
         return response()->json(
         [
         'status' =>'401',
         'msg' => 'Something went wrong,please try again'
         ]);
     }





 
 // return view('tl_admin.merchant.add_merchant');
  }
  else
  {
    if($product_imageidd!="")
    {
        $extension = $product_imageidd->getClientOriginalExtension();
        $filesize  =  $product_imageidd->getClientSize();
        $filename1 = $product_imageidd->getClientOriginalName();

        if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Upload only jpeg,jpg or png file'
                ]);
        }
        if($filesize>='2048000')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Image size should be less than 2mb'
                ]);
        }
        $dir = public_path().'/tl_admin/upload/merchantmod/product';
        $filename1 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename1;
        $upload_image = $product_imageidd->move($dir, $filename1);
        if($upload_image==false)
        {
             return response()->json(
                [
                'status' =>'401',
                'msg' => 'Unable to upload product image, please try again'
                ]);
        }
    }else{
       
     $filename1 = DB::table('tbl_tl_product')->select('tl_product_image1')->where('tl_product_id',$updateid)->get();
     $filename1 = json_decode(json_encode($filename1), True);
     $filename1 = $filename1[0]['tl_product_image1'];
    
 }///end product image 1

    if($product_imageidd1!="")   // start product image 2
    {
        $extension = $product_imageidd1->getClientOriginalExtension();
        $filesize  =  $product_imageidd1->getClientSize();
        $filename2 = $product_imageidd1->getClientOriginalName();

        if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Upload only jpeg,jpg or png file'
                ]);
        }
        if($filesize>='2048000')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Image size should be less than 2mb'
                ]);
        }
        $dir = public_path().'/tl_admin/upload/merchantmod/product';
        $filename2 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename2;
        $upload_image = $product_imageidd1->move($dir, $filename2);
        if($upload_image==false)
        {
             return response()->json(
                [
                'status' =>'401',
                'msg' => 'Unable to upload product image, please try again'
                ]);
        }
    }else{
    // $filename2 = '';
     $filename2 = DB::table('tbl_tl_product')->select('tl_product_image2')->where('tl_product_id',$updateid)->get();
     $filename2 = json_decode(json_encode($filename2), True);
     $filename2 = $filename2[0]['tl_product_image2']; 
    }///end product image 2

    if($product_imageidd2!="")   // start product image 3
    {
        $extension = $product_imageidd2->getClientOriginalExtension();
        $filesize  =  $product_imageidd2->getClientSize();
        $filename3 = $product_imageidd2->getClientOriginalName();

        if($extension!='jpg' && $extension!='jpeg' && $extension!='png')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Upload only jpeg,jpg or png file'
                ]);
        }
        if($filesize>='2048000')
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Image size should be less than 2mb'
                ]);
        }
        $dir = public_path().'/tl_admin/upload/merchantmod/product';
        $filename3 = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename3;
        $upload_image = $product_imageidd2->move($dir, $filename3);
        if($upload_image==false)
        {
             return response()->json(
                [
                'status' =>'401',
                'msg' => 'Unable to upload product image, please try again'
                ]);
        }
    }else{
     $filename3 = DB::table('tbl_tl_product')->select('tl_product_image3')->where('tl_product_id',$updateid)->get();
     $filename3 = json_decode(json_encode($filename3), True);
     $filename3 = $filename3[0]['tl_product_image3'];
    }///end product image 3
    
if($treat_valid!=''){
 $sql =    DB::table('tbl_tl_product')
 ->where('tl_product_id',$updateid)
 ->update([  
     'tl_product_name'=> $treat_name ,
     'tl_product_for'=> $treatfor ,
     'tl_product_categoryid'=>$pro_category ,
     'tl_product_treat_type'=>$treattype ,
     'tl_product_price'=>$treat_price ,
     'tl_product_maxlimit'=>$max_no ,
     'tl_product_validity'=>  $treat_valid, 
     'tl_product_image1'=> $filename1 ,  
     'tl_product_image2'=>  $filename2,
     'tl_product_image3'=> $filename3, 
     'tl_product_description'=> $description,
     'tl_product_cardmsg'=> $cardmessage,
     'tl_product_type'=> $producttype,
     'tl_product_ip'=> $ip_address,
     'tl_product_updated_at'=> $curDate
 ]);
}else{
 $sql =    DB::table('tbl_tl_product')
 ->where('tl_product_id',$updateid)
 ->update([
             'tl_product_name'=> $treat_name ,
             'tl_product_for'=> $treatfor ,
             'tl_product_categoryid'=>$pro_category ,
             'tl_product_treat_type'=>$treattype ,
             'tl_product_price'=>$treat_price ,
             'tl_product_maxlimit'=>$max_no ,
             'tl_product_image1'=> $filename1 ,  
             'tl_product_image2'=>  $filename2,
             'tl_product_image3'=> $filename3, 
             'tl_product_description'=> $description,   
             'tl_product_cardmsg'=> $cardmessage,
             'tl_product_type'=> $producttype,
             'tl_product_ip'=> $ip_address, 
             'tl_product_updated_at'=> $curDate 
             ]);
         }


    if($sql==true)
    {
      return response()->json(
        [
        'status' =>'200',
        'msg' => 'Product updated successfully!'
        ]);  
    }
    else
    {
        return response()->json(
        [
        'status' =>'401',
        'msg' => 'Something went wrong,please try again'
        ]);
    }
  }

}

       public function completeorder($cartid){
        if($cartid){
                try {
                    $sql = DB::table('tbl_tl_order')->where('cart_uniqueid',$cartid)->update([
                        'tl_order_status'=>'DELIVERED'    
                    ]);

                return response()->json(
                [
                'status' =>'200',
                'msg' => 'Order completed'
                    ]);
                } catch (\Exception $e) {
                    return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Something went wrong, Please try again later'
                            ]);
                }

            }
            else
            {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong, Please try again later.'
                    ]);
            }
       }
   
}
