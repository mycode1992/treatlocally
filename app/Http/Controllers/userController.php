<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\myconfiguration;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use DateTime;
session_start();

class userController extends Controller
{
    public function index($id=null){
        return view('frontend.user.signup');
    }

    public function add_user(Request $request){

        if($request->isMethod('POST')){
            $first_name = $request->first_name; 
            $last_name = $request->last_name;
            $phoneno = $request->phoneno;
            $password = $request->password;
            $email = $request->email;
            $iagree = $request->iagree;
            $_token = $request->_token;
            $address = $request->address;
            $status = '1';
            $role_id = '3';
             if($iagree==1){
               
                $objuser = new myconfiguration();
                $result_user  =  $objuser->addmerchant($first_name,$last_name,$phoneno,$password,
                                $email,$_token,$status,$role_id,$address);
               return $result_user;

            }else{
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Agree to the terms and condition'
                    ]);
             }

            
        }

         
    }

    public function account(){
          return view('frontend.user.account');
    }

    function login(Request $request){
        if($request->isMethod('POST'))//start of post
        {
            $email=trim($request->email);
            $password=trim($request->password);
            $cartunique_id=trim($request->cartunique_id);
            $session = 'sessionuser';
            $role_id = '3';
            if($email!=""&&$password!="")
            {
            $objuserlogin = new myconfiguration();
              $user =  $objuserlogin->login($email,$password,$role_id,$session,$cartunique_id);

              return $user;
             
            }
            else
            {
                 return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All fileds required'
                    ]);// all fileds required;
            }


        }
        else
        {
             return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Invalid request, please try again'
                    ]);
        }
    }

    public function myprofile(){
      $session_all=Session::get('sessionuser');

        if($session_all==false)
        {
            return Redirect::to('/user/account');
            exit();
        } 

         $user_id = $session_all['userid']; 
         // check for user is active by madmin
            $check_user_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_user_isactive)>0){
                $session = 'sessionuser';
                $objuserlogout = new myconfiguration();
                $user = $objuserlogout->logout($session);
                if($user == true){
                    
                    return redirect('/user/account');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
          } // end if for check_user_isactive



          $data = DB::table('users AS t1')
        ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
        ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_address','t2.tl_userdetail_ip')
        ->where('t1.userid',$user_id)->get();
        $data = json_decode(json_encode($data), True);
        return view('frontend.user.myprofile',compact('data'));
    }

     public function edit_profile(Request $request){
        if($request->isMethod('POST'))
        {
            $session_all=Session::get('sessionuser');
            $sessionuserid = $session_all['userid'];
            
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 
            $first_name = $request->first_name; 
            $last_name = $request->last_name;
            $name = $first_name.' '.$last_name;
            $phoneno = $request->phoneno;
            $email = $request->email;
            $address = $request->address;
            $post_code = $request->post_code;
            $userid = $request->user_id; 

            if($email!=''){
                 $mail_exist = DB::table('users')
                ->where('email', '=',$email)
                ->where('userid', '!=',$sessionuserid)
                ->select('email')->get();

                if(count($mail_exist)>0){
                     return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'E-mail id already exists.'
                    ]);
                }
            }

            $values=array(
                'name'=>$name,
                'email'=>$email,
                'updated_at' => $curDate   
            ); 

            $values1 = array(
                'tl_userdetail_firstname'=> $first_name ,
                'tl_userdetail_lastname'=> $last_name ,
                'tl_userdetail_phoneno'=> $phoneno ,
                'tl_userdetail_address'=> $address ,
                'tl_userdetail_postcode'=> $post_code ,
                'tl_userdetail_ip'=>  $ip_address, 
                'tl_userdetail_updated_at'=> $curDate
            );

            if($values !='' && $values1 !='')
            {
                $sql=DB::table('users')
                ->where('userid', '=',$userid)
                ->update($values);

                $sql1=DB::table('tbl_tl_user_detail')
                ->where('tl_userdetail_userid', '=',$userid)
                ->update($values1);
                if($sql==true && $sql1==true){
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Your profile has been updated successfully.'
                        ]);
                }
                else
                {
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Something went wrong, please try again later.'
                        ]); 
                }

            }
            else{

                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All field are required'
                    ]);

            }


        }
        else
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid request'
                ]); 
        }
    }

    public function logout()
    {
       
        $session = 'sessionuser';
        $objuserlogout = new myconfiguration();
        $user = $objuserlogout->logout($session);
        if($user == true){
            
            return redirect('/user/account');
            exit();
     
         }else if($user == false){
               echo 'something went wrong';
         }
       
    }

    public function forgot_password(){
        return view('frontend.user.forgot-password');
    }

    public function forgot_email(Request $request){
        if($request->isMethod('POST')){
          //  echo 'sweta'; exit;
           $email = trim($request->email); 
           $role_id = '3'; 
           if($email!="")
           {
            $objforgot_email = new myconfiguration();
            $data = $objforgot_email->forgot_email($email,$role_id);
            return $data;
           }else
           {
             return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fileds required'
                ]);// all fileds required;
            }
            }
       
       
      
      
    }


    public function  change_password($id=null){
        return view('frontend.user.change-password');
    }

    function changepassword(Request $request){
        if($request->isMethod('POST')){
             $password = $request->password;
             $con_password = $request->con_password;
             $token = $request->segment;
             $role_id='3';
             $objchange_password = new myconfiguration();
             $data = $objchange_password->changepassword($password,$con_password,$token,$role_id);
               return $data;
        } // check for method post
        else
        {

            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid Request'
                ]); 
        }
     } 
    
     public function submit_support(Request $request){

        if($request->isMethod('POST')){
            $email = $request->email; 
            $phoneno = $request->phoneno;
            $support_message = $request->support_message;
            $role_id = '3';
            
               
                $objsupport = new myconfiguration();
                $result  =  $objsupport->submit_support($email,$phoneno,$support_message,$role_id);
               return $result;

           
        }
        else
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid request'
                ]); 
        }

         
    }
     

    public function treathistory(){
        $session_all=Session::get('sessionuser');

        if($session_all==false)
        {
            return Redirect::to('/user/account');
            exit();
        } 

        $user_id = $session_all['userid']; 

        // check for user is active by madmin
            $check_user_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_user_isactive)>0){
                $session = 'sessionuser';
                $objuserlogout = new myconfiguration();
                $user = $objuserlogout->logout($session);
                if($user == true){
                    
                    return redirect('/user/account');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
          } // end if for check_user_isactive

        $current_order = DB::table('tbl_tl_order')->where('userid',$user_id)->where('tl_order_status','PLACED')->select('cart_uniqueid','tl_order_ref','tl_cart_subtotal','tl_order_paymode','tl_order_paystatus','tl_order_status','tl_order_created_at')->get();

        $completet_order = DB::table('tbl_tl_order')->where('userid',$user_id)->where('tl_order_status','DELIVERED')->select('userid','cart_uniqueid','tl_order_ref','tl_cart_subtotal','tl_order_paymode','tl_order_paystatus','tl_order_status','tl_order_created_at')->get();

        return view('frontend.user.treathistory',compact('current_order','completet_order'));
    }

    public function currentorder_viewdetail($cardid){
     
        $session_all=Session::get('sessionuser');

        if($session_all==false)
        {
            return Redirect::to('/user/account');
            exit();
        } 
           $user_id = $session_all['userid']; 

         // check for user is active by madmin
            $check_user_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_user_isactive)>0){
                $session = 'sessionuser';
                $objuserlogout = new myconfiguration();
                $user = $objuserlogout->logout($session);
                if($user == true){
                    
                    return redirect('/user/account');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
          } // end if for check_user_isactive
       
        if($cardid!=''){
           
          $userdetail = DB::table('tbl_tl_treatuser')->where('cart_uniqueid',$cardid)                   ->select('tl_tuser_fullname')->get();

          $recieptdetail =  DB::table('tbl_tl_order')->where('cart_uniqueid',$cardid)                   ->select('tl_recipient_name','tl_recipient_address')->get();

          $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cardid)->where('tl_cart_status','PLACED')->select('tl_product_name','tl_product_image1','tl_product_description','tl_product_price')->get();
         
            return view('frontend.user.order_view_detail',compact('userdetail','recieptdetail','treat'));
        }
    }

    public function support(){
         $session_all=Session::get('sessionuser');

        if($session_all==false)
        {
            return Redirect::to('/user/account');
            exit();
        }   

         $user_id = $session_all['userid']; 

         // check for user is active by madmin
            $check_user_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_user_isactive)>0){
                $session = 'sessionuser';
                $objuserlogout = new myconfiguration();
                $user = $objuserlogout->logout($session);
                if($user == true){
                    
                    return redirect('/user/account');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
          } // end if for check_user_isactive

    return view('frontend.user.support');
    }


}
