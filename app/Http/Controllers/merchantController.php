<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\myconfiguration;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use DateTime;
require (getcwd().'/app/helpers.php');
session_start();

class merchantController extends Controller
{
    public function index(){
        return view('frontend.merchant.merchant-signup');
    }

    public function myprofile(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 

        $user_id = $session_all['userid']; 

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

        $data = DB::table('users AS t1')
        ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
        ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_postcode','t2.tl_userdetail_firstname','t2.tl_userdetail_address','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')
        ->where('t1.userid',$user_id)->get();
        $data = json_decode(json_encode($data), True);
        return view('frontend.merchant.myprofile',compact('data'));

    }
    
    public function get_mybusiness(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 
        $user_id = $session_all['userid'];

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

         $data = DB::table('tbl_tl_mybusiness')->where('userid',$user_id)
                    ->select('userid','tl_mybusiness_address','tl_mybusiness_type'
                    ,'tl_mybusiness_vatno','tl_mybusiness_phoneno','tl_mybusiness_about'
                   )->get();

        if(count($data)>0){
          
           return view('frontend.merchant.mybusiness',compact('data'));
        }else{
            return view('frontend.merchant.mybusiness');
        }
    }

    public function get_addstore(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 

        $user_id = $session_all['userid'];

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

        $data = DB::table('tbl_tl_addstore')
                   ->where('userid',$user_id)
                   ->select('userid','tl_addstore_name','tl_addstore_services','tl_addstore_logo','tl_addstore_lat','tl_addstore_lng'
                   ,'tl_addstore_address','tl_addstore_postcode','tl_addstore_aboutmerchant','tl_addstore_termscondt'
                  )->get();

       if(count($data)>0){
          // echo 'fdgdfh';exit;
          return view('frontend.merchant.add_store',compact('data'));
       }else{
        return view('frontend.merchant.add_store');
       }
       
    }

    public function product(){
        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 
        $user_id = $session_all['userid']; 

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$user_id)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

       $data = DB::table('tbl_tl_product')
             ->select('tl_product_id','tl_product_name','tl_product_treat_type','tl_product_image1')
             ->where('userid',$user_id)->orderBy('tl_product_id','desc')->get();
        return view('frontend.merchant.product',compact('data'));
    }
    public function order_history(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 
              
        $sessionuserid = $session_all['userid']; 

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$sessionuserid)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

        $current_order = DB::table('tbl_tl_order')
        ->whereRaw("find_in_set($sessionuserid,store_merchant_id)")
        ->where('tl_order_status','PLACED')->select('userid','store_id','cart_uniqueid','tl_order_ref','tl_cart_subtotal','tl_order_paymode','tl_order_paystatus','tl_order_status','tl_order_created_at')->orderby('tl_order_id','desc')->get();

        $completet_order = DB::table('tbl_tl_order')
        ->whereRaw("find_in_set($sessionuserid,store_merchant_id)")
        ->where('tl_order_status','DELIVERED')->select('userid','cart_uniqueid','tl_order_ref','tl_cart_subtotal','tl_order_paymode','tl_order_paystatus','tl_order_status','tl_order_created_at')->orderby('tl_order_id','desc')->get();

        return view('frontend.merchant.order_history',compact('current_order','completet_order'));
    }

    public function edit_card($id){

        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 

        $sessionuserid = $session_all['userid']; 

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$sessionuserid)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive



        if($id!=''){  
            $data = DB::table('tbl_tl_card')->select('cart_uniqueid','card_recipient_name', 'card_occasion', 'card_message','card_sender_name')->where('cart_uniqueid',$id)->get();
          //  print_r($data); exit;
           return view('frontend.merchant.edit_card',compact('data'));
        }
    }

    public function update_card(Request $request){
        if($request->isMethod('POST')){
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 

            $recipient_name = trim($request->recipient_name);
            $recipient_occasion = trim($request->recipient_occasion);
            $message = trim($request->message);
            $sender_name = trim($request->sender_name);
          //  $datepicker1 = trim($request->datepicker1);  
            $updateid = trim($request->updateid);

                if($updateid!=''){
                   // echo $datepicker; exit;
                    $sql =  DB::table('tbl_tl_card')->where('cart_uniqueid',$updateid)->update([
                        'card_recipient_name' =>  $recipient_name,
                        'card_occasion' =>  $recipient_occasion,
                        'card_message' =>  $message,
                        'card_sender_name' =>  $sender_name,
                       // 'card_delievery_date' =>  $datepicker1,
                        'template_updated_at' =>  $curDate,
                        'ip_address' =>  $ip_address
                    ]);   
                
                    if($sql==true){
                        return response()->json([
                            'status' =>'200',
                            'msg' => 'Card updated successfully'
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'status' =>'401',
                            'msg' => 'Something went wrong, please try again later'
                        ]);
                    }
                }
                else
                {
                    return response()->json([
                        'status' =>'401',
                        'msg' => 'All field are required'
                    ]);
                }
          
        }
        else
        {
            return response()->json([
                'status' =>'401',
                'msg' => 'Invalid Request'
            ]);
        }
    }

    public function order_historydetail(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 
        return view('frontend.merchant.order_historydetail');
    }

    public function support(){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 

         $sessionuserid = $session_all['userid']; 

         // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$sessionuserid)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive

        return view('frontend.merchant/support');
    }

    public function partial_reedeem(Request $request){
        if($request->isMethod('POST'))
        {
            
            $curDate = new \DateTime();
            $tl_product_id = $request->tl_product_id;
            $reedeem_amt = $request->reedeem_amt;
            $rest_amt = $request->rest_amt;
            $userid = $request->userid;
            $cart_id = $request->cart_id;
            $store_id = $request->store_id;

            if($rest_amt>=$reedeem_amt)
            {
                $restamt = $rest_amt - $reedeem_amt;
                
                DB::beginTransaction();
                try {
                   
                    DB::table('tbl_tl_user_cart')->where('cart_id',$cart_id)->update(['tl_cart_partial_reedeem' => $restamt]);
                
                    DB::table('tbl_tl_partial_reedeem')->insert([
                        'userid'=> $userid,
                        'cart_id'=> $cart_id,
                        'tl_product_id'=> $tl_product_id,
                        'store_id'=> $store_id,
                        'partial_reedeem_price'=> $rest_amt,
                        'partial_reedeem_reedeem_amt'=> $reedeem_amt,
                        'partial_reedeem_rest_amt'=> $restamt,
                        'partial_reedeem_updated_at'=> $curDate
                    ]);
    
 
                   DB::commit();
                
                 return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated Successfull.'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong,please try again later.'
                        ]);
                }
                
              // } 
               }
            else
            {
                return response()->json(
                    [
                    'status' =>'402',
                    'msg' => 'Amount should be less or equal to voucher amount.'
                    ]); 
            }
        }
        else
        {
           return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request.'
            ]); 
        }

    }

    public function add_merchant(Request $request){

        if($request->isMethod('POST')){
            $mer_first_name = $request->mer_first_name; 
            $mer_last_name = $request->mer_last_name;
            $merphoneno = $request->merphoneno;
            $merpassword = $request->merpassword;
            $mer_email = $request->mer_email;
            $address = $request->address;
            $iagree = $request->iagree;
            $_token = $request->_token;
            $status = '1';
            $role_id = '2';
             if($iagree==1){
               
                $objmerchant = new myconfiguration();
                $result_mer  =  $objmerchant->addmerchant($mer_first_name,$mer_last_name,$merphoneno,$merpassword,
                                $mer_email,$_token,$status,$role_id,$address);
               return $result_mer;

            }else{
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Agree to the terms and condition'
                    ]);
             }
        }

         
    }

    public function merchant_signin(){
        return view('frontend.merchant.merchant-signin');
    }

    function login(Request $request){
        if($request->isMethod('POST'))//start of post
        {
            $email=trim($request->email);
            $password=trim($request->password);
            $cartunique_id='';
            $session = 'sessionmerchant';
            $role_id = '2';
            if($email!=""&&$password!="")
            {
            $objmerchantlogin = new myconfiguration();
              $user =  $objmerchantlogin->login($email,$password,$role_id,$session,$cartunique_id);

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

    public function logout()
    {
        $session = 'sessionmerchant';
        $objmerchantlogout = new myconfiguration();
       
        $user = $objmerchantlogout->logout($session);
        if($user == true){
           // return Redirect::to('/');
            return redirect('/merchant-signin');
            exit();
     
         }else if($user == false){
               echo 'something went wrong';
         }
       
    }

    public function forgot_password(){
        return view('frontend.merchant.forgot-password');
    }

    public function forgot_email(Request $request){
        if($request->isMethod('POST')){
        
           $email = trim($request->email); 
           $role_id = '2'; 
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
        return view('frontend.merchant.change-password');
    }


    function changepassword(Request $request){
        if($request->isMethod('POST')){
             $password = $request->password;
             $con_password = $request->con_password;
             $token = $request->segment;
             $role_id='2';
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

    public function verify_email($id=null){
         
        if(!$id)
        {
            return view("frontend.merchant.verify_email")->with('token_status','3');
        }
        else
        {
            // echo $id; exit;
          
            $verifydata = DB::table('users')->where('email_verify_token', '=',$id)->get(['email_verify_status','userid']); 

            if(count($verifydata)>0)
            {
                $email_verify_status=$verifydata[0]->email_verify_status;
                $userid=$verifydata[0]->userid;

                if($email_verify_status=='0')
                {
                    // To do verified

                    $sql=DB::table('users')
                            ->where('userid','=',$userid)
                            ->update(array(
                                'email_verify_status' => '1',
                                'status' => '1'
                            ));
                     $token_status='1';// verifed token
                }
                else
                {
                    $token_status='2';// already verified
                    
                }


            }
            else
            {
                $token_status='3';// Invalid Token
            }

           
            return view("frontend.merchant.verify_email")->with('token_status',$token_status);
        }

       
    }

    public function addstore(Request $request){

        if($request->isMethod('POST')){
            
            $store_name = $request->store_name; 
            $service = $request->service;
            $location = $request->location;
            $lat = $request->lat;
            $lng = $request->lng;
            $post_code = $request->post_code;
            $userid = $request->userid;
            $updateid = trim($request->updateid); 
            $about_merchant = $request->about_merchant;  
            $termsconditiondesp = $request->termsconditiondesp;
            $store_logo = $request->file('store_logo');  
            $addstore_status = '1';

          

            $objmerchantaddstore = new myconfiguration();
            $data = $objmerchantaddstore->addstore($store_name,$location,$lat,$lng,$userid,$about_merchant,$termsconditiondesp,$store_logo,$service,$addstore_status,$updateid,$post_code);
            return $data;
        }
        else
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid Request'
                ]);
        }
       // return view('tl_admin.merchant.add_merchant');
    } // end of addupdate store
  
    public function edit_profile(Request $request){
        if($request->isMethod('POST'))
        {
            $session_all=Session::get('sessionmerchant');
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

    public function merchant_changepassword(Request $request){
            if($request->isMethod('post')){
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 
            $password = $request->password;   
            $old_password = $request->old_password;
            $user_id = $request->user_id;

            if($old_password!='')
            {
                $old_password = md5($old_password);
               $sql1 = DB::table('users')
                      ->select('password')
                      ->where('userid',$user_id)
                      ->where('password',$old_password)->get();

               if(count($sql1)>0){
                $password = md5($password);
                  $sql2 = DB::table('users')
                  ->where('userid',$user_id)
                  ->update([
                      'password'=>$password,
                      'updated_at'=> $curDate
                      ]);
                  if($sql2==true)
                  {
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Password change successfully'
                        ]);
                  }
                  else
                  {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong, please try again later'
                        ]);
                  }
               }
               else
               {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Old password does not match'
                    ]); 
               }
            }
            else
            {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Please enter old password'
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

    public function submit_support(Request $request){

        if($request->isMethod('POST')){
            $email = $request->email; 
            $phoneno = $request->phoneno;
            $support_message = $request->support_message;
            $role_id = '2';
            
               
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
    
    public function mybusiness(Request $request){

        if($request->isMethod('POST')){
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 
            $session_all=Session::get('sessionmerchant');
            $sessionuserid = $session_all['userid'];

            $address = $request->address; 
            $buissness_type = $request->buissness_type;
            $phoneno = $request->phoneno;
            $abt_buissness = $request->abt_buissness;
            $vat_num = $request->vat_num;
            $userid = $request->userid;
        
            if($userid=='')
            {
                    $sql =  DB::table('tbl_tl_mybusiness')->insert([
                        'userid'=> $sessionuserid ,
                        'tl_mybusiness_address'=>$address,
                        'tl_mybusiness_type'=>$buissness_type ,
                        'tl_mybusiness_vatno'=> $vat_num,
                        'tl_mybusiness_phoneno'=>$phoneno ,
                        'tl_mybusiness_about'=> $abt_buissness,
                        'tl_mybusiness_ip'=> $ip_address,
                        'tl_mybusiness_created_at'=> $curDate,
                        'tl_mybusiness_updated_at'=> $curDate,
                    ]);
                    if($sql == true){
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Added successfully'
                            ]); 
                    }
                    else
                    {
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Something went wrong, please try again later'
                            ]); 
                    }
            }
            else
            {
                $sql =  DB::table('tbl_tl_mybusiness')
                ->where('userid',$userid)
                ->update([
                    'tl_mybusiness_address'=>$address,
                    'tl_mybusiness_type'=>$buissness_type ,
                    'tl_mybusiness_vatno'=> $vat_num,
                    'tl_mybusiness_phoneno'=>$phoneno ,
                    'tl_mybusiness_about'=> $abt_buissness,
                    'tl_mybusiness_ip'=> $ip_address,
                    'tl_mybusiness_updated_at'=> $curDate,
                ]);
                if($sql == true){
                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Updated successfully'
                        ]); 
                }
                else
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong, please try again later'
                        ]); 
                }
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

    public function get_product($id=null){
        $session_all=Session::get('sessionmerchant');

        if($session_all==false)
        {
            return Redirect::to('/merchant-signin');
            exit();
        } 

         $sessionuserid = $session_all['userid']; 

        // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$sessionuserid)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive


       if($id=='')
       {
        return view('frontend.merchant.add_voucher');
       }
       else
       {
        $data = DB::table('tbl_tl_product')->where('tl_product_id',$id)
        ->select('tl_product_categoryid','tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
        'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
        ->get();
       // print_r($data); exit;
        return view('frontend.merchant.add_voucher',compact('data'));
       }
    }

    public function addproduct(Request $request){

        if($request->isMethod('POST')){
            $treatfor = array();
            $session_all=Session::get('sessionmerchant');
            $user_id = $session_all['userid'];
            $treat_name = $request->treat_name;
            $producttype = $request->producttype; 
            $treatfor = $request->treatfor;
            $treattype = $request->treattype;
            $pro_category = $request->pro_category;
            $treat_price = $request->treat_price;  
            $treat_valid = $request->treat_valid; 
            $treat_valid = date("Y-m-d H:i:00", strtotime($treat_valid)); 
            $update_id = $request->update_id;  

            $max_no = $request->max_no;
            $description = addslashes($request->description);  
            $cardmessage = addslashes($request->cardmessage);
            $product_status = '0';
            $product_imageidd = $request->file('product_imageidd'); 
                                
            $product_imageidd1 = $request->file('product_imageidd1');
            $product_imageidd2 = $request->file('product_imageidd2');
            $frontstoreimg = $request->file('frontstoreimg');

             if($treat_price==0){
            return response()->json(
                   [
                   'status' =>'401',
                   'msg' => 'Please enter price'
                   ]);
       }

                $objaddproduct = new myconfiguration();
                $result  =  $objaddproduct->addproduct($user_id,$treat_name,$producttype,$treatfor,
                                $treattype,$treat_price,$treat_valid,$max_no,$description,$cardmessage,$product_imageidd,
                            $product_imageidd1,$product_imageidd2,$frontstoreimg,$product_status,$update_id,$pro_category);
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

    public function viewproductdetail(Request $request){
        if($request->isMethod('post'))
        {
         $productid = $request->productid;
         if($productid!='')
         {
         
            $data = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
            ->select('tl_product_categoryid','tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
            'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
             ->get();
             $productfor = $data[0]->tl_product_for;

            $treattype= DB::table('_treat_type')->select('id','name')->where('id',$data[0]->tl_product_treat_type)->get();
            $treattype = json_decode(json_encode($treattype), True);
 
             $productfor = DB::table('_relation')
                ->whereRaw("find_in_set(id,'$productfor')")->get();

                $productcat = DB::table('tbl_tl_category')->where('tl_category_id',$data[0]->tl_product_categoryid)->select('tl_category_name')->get();
                
               $tl_product_validity = $data[0]->tl_product_validity;
               if($tl_product_validity!=''){
                $tl_product_validity = date("Y-m-d", strtotime($tl_product_validity)); 
              }else{
                 $tl_product_validity = '';
              }

                $html ='
                    
                    <div class="tl-flexboxmain">
                    <div class="tl-adcolsflex"><span>Treat for:</span><span>';
                    
                    $pp=0; 
                    foreach($productfor as $productlist){
                        $pp++;
                        if($pp!=1){
                            $html .=', ';
                          }
                          $html .= $productlist->name;
                        } 
                   
                    $html .='</span></div>
                    <div class="tl-adcolsflex"><span> Treat type :</span><span>'.$treattype[0]['name'].'</span></div>
                    <div class="tl-adcolsflex"><span> Category:</span><span>'.$productcat[0]->tl_category_name.'</span></div>

                    <div class="tl-adcolsflex"><span> Price:</span><span>'.$data[0]->tl_product_price.'</span></div>
                    <div class="tl-adcolsflex"><span>Max limit:</span><span>'.$data[0]->tl_product_maxlimit.'</span></div>';
                      if($data[0]->tl_product_type!=='Product'){
                        $html .='<div class="tl-adcolsflex"><span>Validity :</span><span>'.$tl_product_validity.'</span></div>';
                      }
                    $html .='
                    <div class="tl-adcolsflex"><span>product type :</span><span>'.$data[0]->tl_product_type.'</span></div></div>
                    </div>
                    <div class="tl-flexboximg">
                    <div class="tl-adcolsflex"><span>'; 
                    if($data[0]->tl_product_image1!=""){
                        $html .=' <img src="'.url('').'/public/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image1.'" class="img-responsive">';
                    }
                    else{  $html .='N/A'; }
                    $html .='</span></div>
                    <div class="tl-adcolsflex"><span>';
                    if($data[0]->tl_product_image2!=""){ 
                        $html .=' <img src="'.url('').'/public/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image2.'" class="img-responsive">';
                    }
                    else{ $html .='N/A'; }
                        
                    $html .=' </span></div>
                    <div class="tl-adcolsflex"><span>';
                    if($data[0]->tl_product_image3!=""){  
                        $html .='<img src="'.url('').'/public/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image3.'" class="img-responsive">';
                    }else{ $html .='N/A'; }
                        $html .='</span></div>
                    <div class="tl-adcolsflex"><span>'; 
                    if($data[0]->tl_product_storeimage!=""){  
                    $html .='<img src="'.url('').'/public/tl_admin/upload/storelogo/'.$data[0]->tl_product_storeimage.'" class="img-responsive">';
                    }else{ $html .='N/A'; }
                    $html .='</span></div>
                    </div>
                    <div class="tl-flexboxtext">
                    <p class="tl-desp"> <span class="para-heading">Description</span>'.$data[0]->tl_product_description.'</p>
                    <p class="tl-desp"> <span class="para-heading">Card message</span>'.$data[0]->tl_product_cardmsg.'</p></div>
                
                    ';
                   
                    echo $html; exit;
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
  
      $data =  DB ::table('tl_support')
         ->select('tl_support_email','tl_support_phone','tl_support_message','tl_support_id')
         ->where('tl_support_roleid','3')
         ->get();
      
    return view('tl_admin.support_enquiry_user',compact('data'));
  }


  public function deleteproduct(Request $request){
    if($request->isMethod('POST')){
        $id = trim($request->id); 
        if($id!=''){
          $sql =  DB::table('tbl_tl_product')->where('tl_product_id', $id)->delete();   
          if($sql==true){
             return response()->json([
                'status' =>'200',
                'msg' => 'Deleted successfully'
             ]);
          }
          else
          {
            return response()->json([
                'status' =>'401',
                'msg' => 'Something wernt wrong, please try again later'
             ]);
          }
        }
    }


  }

    public function connect_account(Request $request,$id=null){

        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        }
        $sessionuserid = $session_all['userid'];
        $merchant_id = $request->input('state'); 
        $data = DB::table('tbl_tl_user_detail')->select('tl_userdetail_stripeacc_id')->where('tl_userdetail_userid',$sessionuserid)->get();
        $merchant_stripe_id_exist =  $data[0]->tl_userdetail_stripeacc_id;
        if($merchant_stripe_id_exist == "")
        {
            if($merchant_id !="")
            {
              $merchant_stripe_verify_code = $request->input('code');
              $MerchantConnectVerify = MerchantConnectVerify($merchant_stripe_verify_code);
              $stripe_response = json_decode($MerchantConnectVerify,true);
             /* print_r($stripe_response);
              exit;*/
              if(count($stripe_response) > 4)
              {
                $stripe_user_account_id=$stripe_response['stripe_user_id'];
                $sql=DB::table('tbl_tl_user_detail')
                        ->where('tl_userdetail_userid',$merchant_id)
                        ->update([
                              'tl_userdetail_stripeacc_id'=>$stripe_user_account_id
                              ]);
              }
              else
              {
                $stripe_user_account_id="";
              }
            }
            else
            {
                 $stripe_user_account_id="";
            }
        }// end of if merchant account stripe id is blank
        else
        {
            $stripe_user_account_id = $merchant_stripe_id_exist;
        }
        // echo $stripe_user_account_id;
        return view('frontend.merchant.connect_account')->with('data',$stripe_user_account_id);
    }

    public function completeorder(Request $request){
        if($request->isMethod('POST'))
        {
           $cartid = $request->cartid;
           $objmerchant = new myconfiguration();
           $result_mer  =  $objmerchant->completeorder($cartid);
            return $result_mer;
        }
        else
        {
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid Request.'
                ]); 
        }
    }

    public function connect_stripe(){

        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        } 
        $sessionuserid = $session_all['userid'];
        $url = "https://dashboard.stripe.com/oauth/authorize?response_type=code&client_id=ca_EBMeoBhiUJka2y1EsoxlZOcWdh6ENHVK&scope=read_write&state=".$sessionuserid;

        return response()->json(
            [
            'status' =>'200',
            'link' => $url
            ]);
    }

    public function currentorder_viewtreat($cart_uniqueid){ 
     
        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        }
        $userid = $session_all['userid'];

         // check for merchant is active by madmin
         $check_merchant_isactive = DB::table('users')->where('userid',$userid)->where('status','0')->select('userid')->get();
         if(count($check_merchant_isactive)>0){
             $session = 'sessionmerchant';
               $objmerchantlogout = new myconfiguration();
              
               $user = $objmerchantlogout->logout($session);
               if($user == true){
                  // return Redirect::to('/');
                   return redirect('/merchant-signin');
                   exit();
            
                }else if($user == false){
                      echo 'something went wrong';
                }
             } // end if for check_merchant_isactive

        if($cart_uniqueid!=''){
       
          $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_uniqueid)->where('store_merchant_id',$userid)->where('tl_cart_status','PLACED')->select('cart_id','userid','store_id','cart_uniqueid','tl_product_id','tl_product_name','tl_product_image1','tl_product_description','tl_product_price','tl_cart_voucher','tl_cart_partial_reedeem')->get();

            return view('frontend.merchant.order_view_treat',compact('treat'));
        }
    }

     public function completeorder_viewtreat($cart_uniqueid){

        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        }
        $userid = $session_all['userid'];

         // check for merchant is active by madmin
         $check_merchant_isactive = DB::table('users')->where('userid',$userid)->where('status','0')->select('userid')->get();
         if(count($check_merchant_isactive)>0){
             $session = 'sessionmerchant';
               $objmerchantlogout = new myconfiguration();
              
               $user = $objmerchantlogout->logout($session);
               if($user == true){
                  // return Redirect::to('/');
                   return redirect('/merchant-signin');
                   exit();
            
                }else if($user == false){
                      echo 'something went wrong';
                }
             } // end if for check_merchant_isactive

        if($cart_uniqueid!=''){
       
          $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_uniqueid)->where('store_merchant_id',$userid)->where('tl_cart_status','PLACED')->select('cart_id','userid','store_id','cart_uniqueid','tl_product_id','tl_product_name','tl_product_image1','tl_product_description','tl_product_price','tl_cart_voucher','tl_cart_partial_reedeem')->get();
                              
            return view('frontend.merchant.completeorder_viewtreat',compact('treat'));
        }
    }

    public function delivery_address($proid,$cartuniqueid)
    {
        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        }
        $userid = $session_all['userid'];

         // check for merchant is active by madmin
         $check_merchant_isactive = DB::table('users')->where('userid',$userid)->where('status','0')->select('userid')->get();
         if(count($check_merchant_isactive)>0){
             $session = 'sessionmerchant';
               $objmerchantlogout = new myconfiguration();
              
               $user = $objmerchantlogout->logout($session);
               if($user == true){
                  // return Redirect::to('/');
                   return redirect('/merchant-signin');
                   exit();
            
                }else if($user == false){
                      echo 'something went wrong';
                }
             } // end if for check_merchant_isactive

        if($proid!='' && $cartuniqueid !='')
        {
            $delivery_addr = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$proid)->select('tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();

            return view('frontend.merchant.delivery_address',compact('delivery_addr')); 
        }
    }

    public function currentorder_viewdetail($cardid){
       
        $session_all=Session::get('sessionmerchant');
        if($session_all==false)
        {
            return Redirect::to('/');
            exit();
        }
        $userid = $session_all['userid']; 

        // check for merchant is active by madmin
            $check_merchant_isactive = DB::table('users')->where('userid',$userid)->where('status','0')->select('userid')->get();
          if(count($check_merchant_isactive)>0){
              $session = 'sessionmerchant';
                $objmerchantlogout = new myconfiguration();
               
                $user = $objmerchantlogout->logout($session);
                if($user == true){
                   // return Redirect::to('/');
                    return redirect('/merchant-signin');
                    exit();
             
                 }else if($user == false){
                       echo 'something went wrong';
                 }
              } // end if for check_merchant_isactive
       
        if($cardid!=''){
          $userdetail = DB::table('tbl_tl_treatuser')->where('cart_uniqueid',$cardid)                   ->select('tl_tuser_fullname')->get();

          $recieptdetail =  DB::table('tbl_tl_order')->where('cart_uniqueid',$cardid)                   ->select('tl_recipient_name','tl_recipient_address')->get();

          $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cardid)->where('store_merchant_id',$userid)->where('tl_cart_status','PLACED')->select('tl_product_name','tl_product_image1','tl_product_description','tl_product_price')->get();

            return view('frontend.merchant.order_view_detail',compact('userdetail','recieptdetail','treat'));
        }
    }



     public function view_voucher($cartid){
              $session_all=Session::get('sessionmerchant');
                if($session_all==false)
                {
                    return Redirect::to('/');
                    exit();
                }
      
             $userid = $session_all['userid']; 

                    // check for merchant is active by madmin
                        $check_merchant_isactive = DB::table('users')->where('userid',$userid)->where('status','0')->select('userid')->get();
                      if(count($check_merchant_isactive)>0){
                          $session = 'sessionmerchant';
                            $objmerchantlogout = new myconfiguration();
                           
                            $user = $objmerchantlogout->logout($session);
                            if($user == true){
                               // return Redirect::to('/');
                                return redirect('/merchant-signin');
                                exit();
                         
                             }else if($user == false){
                                   echo 'something went wrong';
                             }
                          } // end if for check_merchant_isactive
              
            if($cartid!=''){
                $data = DB::table('tbl_tl_user_cart AS t1')
                                ->join('tbl_tl_product AS t2','t1.tl_product_id','t2.tl_product_id')->where('t1.cart_uniqueid',$cartid)->where('t2.tl_product_type','Voucher')->select('t1.cart_id','t1.cart_uniqueid','t1.userid','t1.store_id','t1.tl_product_id','t1.tl_product_name','t1.tl_product_image1','t1.tl_product_description','t1.tl_product_price','t1.tl_cart_partial_reedeem')->get();
                              

                 return view('frontend.merchant.view_voucher',compact('data'));
            }

        }

       
       

   }
