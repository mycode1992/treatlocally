<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\tbl_tl_banner;
use Illuminate\Support\Facades\Auth;
use App\tbl_tl_contactus;
use App\myconfiguration;
use DB;
use Session;
use DateTime;
require (getcwd().'/app/helpers.php');
session_start();

class frontUser_Controller extends Controller
{

   public function index(){
    $data = DB::table('tbl_tl_contactus')->select('icon_1_image','icon_1_title','icon_1_desp','icon_2_image','icon_2_title','icon_2_desp','icon_3_image','icon_3_title','icon_3_desp')->where('id','1')->get();
    return view('frontend.contact',compact('data'));
   }

   public function store(Request $request){
  
    $name = ucfirst(trim($request->name));
    $email = trim($request->email);
    $phoneno = $request->phoneno;
    $companyname = ucfirst(trim($request->company_name));
    $message = addslashes($request->message);
    $curDate = new \DateTime();
    $ip_address =  \Request::ip(); 
    $sql = tbl_tl_contactus::insert([
		'tl_contactus_name' => $name,
        'tl_contactus_email' => $email,
        'tl_contactus_phone' => $phoneno,
        'tl_contactus_company' => $companyname,
        'tl_contactus_message' => $message,
        'tl_contactus_ip' => $ip_address,
        'tl_contactus_created_at' => $curDate,
        'tl_contactus_updated_at' => $curDate,
        ]);
        
        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
            'msg' => '<b>Thank You! Your enquiry has been submitted successfully,We will get back to you Soon!</b>'
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
		
		// return redirect('/contact');
    
   }

    public function get_index()
   {
       $data['banner']= DB::table('tbl_tl_banner')->select('tl_banner_title','tl_banner_image')->where('tl_banner_id',1)->get();
       $data['banner'] = json_decode(json_encode($data['banner']), True);
       $data['howitworks'] = DB::table('tbl_tl_howitworks')->select('tl_howitworks_icon1','tl_howitworks_icon2','tl_howitworks_icon3','tl_howitworks_text1','tl_howitworks_text2','tl_howitworks_text3')->where('tl_howitworks_id',1)->get();
       $data['howitworks'] = json_decode(json_encode($data['howitworks']), True);
       $data['merchant'] = DB::table('tbl_tl_merchant_of_month')->select('tl_merchant_of_month_title','tl_merchant_of_month_desp','tl_merchant_of_monthbgimg','tl_merchant_of_month_logo','merchant_userid')->where('tl_merchant_of_month_id',1)->get();
       $data['merchant'] = json_decode(json_encode($data['merchant']), True);
       
       return view('frontend.index',compact('data'));
   }

    public function getaboutus(){
    $data = DB::table('tbl_tl_aboutuses')->select('tl_aboutus_imagename','tl_aboutus_content')->get();
  
    return view('frontend.about-us',compact('data'));
   }

    public function getprivacypolicy(){
    $data = DB::table('tbl_tl_privacypolicies')->select('tl_privacypolicies_imagename','tl_privacypolicies_content')->where('tl_privacypolicies_id',1)->get();
    return view('frontend.privacy-policy',compact('data'));
   }

    public function get_terms_condition(){

    $data = DB::table('tbl_tl_terms_condition')->select('tl_terms_condition_imagename','tl_terms_condition_content')->where('tl_terms_condition_id',1)->get();

     return view('frontend.terms&condition',compact('data'));
   }

   /* subscribe submit start*/
    public function subscribesubmit(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $dt = new \DateTime();
            $ip_address =  \Request::ip(); 
            $subscribeemail = trim($request->subscribeemail);
          //  $verify_token=$request->_token;

            $sql=DB::table('tbl_tl_subscribe')
                    ->where('tl_subscribe_email', '=', $subscribeemail)
                    ->get(['tl_subscribe_id']);  

            if(count($sql)>0)
            {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'You have already subscribed'
                        ]);
            }
            else
            {

                $verify_token = $this->getRandomString(50);

             //  $verify_token = Hash::make(str_random(50));  


                $sql=DB::table('tbl_tl_subscribe')->insert([
                            'tl_subscribe_email'=>$subscribeemail,
                            'tl_subscribe_token'=>$verify_token,                            
                             'tl_subscribe_ip'=>$ip_address,
                            'tl_subscribe_date'=>$dt
                            ]);

                if($sql==true)
                {
                    $sendemail= $this->SubscribedEmail($subscribeemail,$verify_token);

                  return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'You have successfully subscribed'
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


        }// end of post method
        else
        {
             return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Invalid request, please try again'
                    ]);
        }// end of else post method



    }
    /* subscribe submit end*/
//////////////////////////////////////////////////////////////////////////////////////////

    private function ordergenhitmerchant($to_merchant,$order_ref,$productinfo,$sender_detail,$curDate,$occasion_select,$cart_id,$treatcard_cost)
{
   
    
    $subject ='Your Order With Treat Locally';
    $baseurl=url('/');
    $logo_path=url('/').'/public/frontend/img/logo.png';
    $admin_mail="sweta.gupta@karmatech.in";
    $admin_mail3="rituraj.kumar@karmatech.in";
    $admin_mail2="";
    $message ="      
<!DOCTYPE html>
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
    <table cellpadding='0' cellspacing='0' align='center' style='border:1px solid #000; padding:10px;margin:auto;max-width:100%; width:100%'>
    <tbody>
        <tr>
            <td colspan='2'>
                <div style='text-align:center;padding:30px 0'>
                    <img src='$logo_path' style='margin: auto; display: block; width:250px' />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='float:right; font-size: 16px;'><strong>Order Confirmation number:</strong>$order_ref</p>
            </td>
        </tr>
         <tr>
            <td height='30' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style='font-size: 16px;'>Hello</p>
            </td>
        </tr>
        <tr>
            <td height='15' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='font-size: 16px; line-height: 22px;'>Thanks for your order. We will package up your personalised Treat Card and send it via first class post within the next 24 hours.</p>
            </td>
        </tr>
        <tr>
            <td height='30' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='font-size: 16px;'><strong>Order Confirmation:</strong></p>
            </td>
        </tr>
         <tr>
            <td height='15' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td  colspan='2'>
                <table cellpadding='0' cellspacing='0' align='center' style='width:100%; border:1px solid #ddd;'>
                    <thead>
                        <tr>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>S.No</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px;border-right:1px solid #ddd'>Voucher Number</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>Order Date</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>Recipient Details</th>
                            <th style='text-align: left; border-right: 1px solid #ddd;border-bottom: 1px solid #ddd; padding: 10px;'>Treat Details</th>
                             <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px;'>Price</th>
                             <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px;'>Postage and Packaging</th>
                             
                        </tr>
                        <tbody>";
                        $sn = 0;
                         $total_pro_price = 0;
                        foreach($productinfo AS $proval)
                        {
                         $sn++;
                         $total_pro_price = $total_pro_price + $proval->tl_product_price;
                        
                         $arr_ord_voucher = explode("_",$proval->tl_cart_voucher);
                         $store_merchant_id = $proval->store_merchant_id;
                         $store_details = DB::table('tbl_tl_addstore')->where('userid',$store_merchant_id)->select('tl_addstore_address')->get();
                         $store_address = $store_details[0]->tl_addstore_address;

                          $store_mobile = DB::table('tbl_tl_user_detail')->where('tl_userdetail_userid',$store_merchant_id)->select('tl_userdetail_phoneno')->get();
                         $store_mobile1 = $store_mobile[0]->tl_userdetail_phoneno;

                         $receipient_details = DB::table('tbl_order_recipient_address')
                                ->where('cart_uniqueid',$cart_id)
                                ->where('cart_id',$proval->cart_id)
                                ->select('tl_recipient_address','tl_recipient_name')->get();

                         $message .="<tr>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>
                                $sn
                                </td>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>".
                                $arr_ord_voucher[1]
                                ."</td>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>";
                                $date=date_create($curDate); $orderdate = date_format($date,"D, M d, Y");
                                $message .="$orderdate         
                                </td>
                                 <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>".$receipient_details[0]->tl_recipient_name.",<br>Addr:- ".$receipient_details[0]->tl_recipient_address."</td>
                                <td style='padding:10px; border-right: 1px solid #ddd; border-bottom:1px solid #ddd '>
                                    ".ucfirst($proval->store_name).", 
                                <br/>
                                ".ucfirst($proval->tl_product_name)."
                                <br/>
                                $store_address ($store_mobile1)
                                </td>

                                <td style='padding:10px;border-right: 1px solid #ddd; border-bottom:1px solid #ddd '>
                                 &pound;".$proval->tl_product_price."
                                </td>
                                <td style='padding:10px; border-bottom:1px solid #ddd '>
                                    &pound;3.50
                                </td>
                                ";

                        }
                        $total_price = $total_pro_price + ($treatcard_cost*$sn);
                     $message .="</tr>
                           
                        </tbody>
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <td height='30' width='100' >&nbsp;</td>
        </tr>
        <tr>
            <td style='width:50%'>
                <p style='font-size: 16px;'><strong>Treat By : </strong>".ucfirst($sender_detail['guest_name'])." 
                </p>
                <p><b>Address- </b>".$sender_detail['guest_address']."</p>
                <p><b>Mobile Number - </b>".$sender_detail['guest_mobile']."</p>
                <p><b>E-mail - </b>".$sender_detail['guest_email']."</p>
            </td>
            <td style='width:100%'>
                <p  style='font-size: 16px;float:right'><strong>Total Price:</strong>
                 &pound;".number_format((float)$total_price, 2, '.', '')."</p>
            </td>
        </tr>
        <tr>
            <td height='10' width='100' >&nbsp;</td>
        </tr>
    </tbody>
     </table>

    </body>
</html>
";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: TreatLocally. <info@Treatlocally.com>' . "\r\n";
    $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
    if(mail($to_merchant, $subject, $message, $headers))
    {
    $status="success"; 
    
    }
    else
    {
    $status="Error";
    }


}// end of subscribed emailer function

////////////////////////////////////////////////////////////////////////////////////////
    private function ordergeneratehitemail($to,$order_ref,$productinfo,$sender_detail,$curDate,$occasion_select,$cart_id,$treatcard_cost)
    {
       
        $subject ='Your Order With Treat Locally';
        $baseurl=url('/');
        $logo_path=url('/').'/public/frontend/img/logo.png';
        $admin_mail="sweta.gupta@karmatech.in";
        $admin_mail3="rituraj.kumar@karmatech.in";
        $admin_mail2="";
        $message ="      
            <!DOCTYPE html>
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
    <table cellpadding='0' cellspacing='0' align='center' style='border:1px solid #000; padding:10px;margin:auto;max-width:100%; width:100%'>
    <tbody>
        <tr>
            <td colspan='2'>
                <div style='text-align:center;padding:30px 0'>
                    <img src='$logo_path' style='margin: auto; display: block; width:250px' />
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='float:right; font-size: 16px;'><strong>Order Confirmation number:</strong>$order_ref</p>
            </td>
        </tr>
         <tr>
            <td height='30' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p style='font-size: 16px;'>Hello</p>
            </td>
        </tr>
        <tr>
            <td height='15' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='font-size: 16px; line-height: 22px;'>Thanks for your order. We will package up your personalised Treat Card and send it via first class post within the next 24 hours.</p>
            </td>
        </tr>
        <tr>
            <td height='30' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td colspan='2'>
                <p style='font-size: 16px;'><strong>Order Confirmation:</strong></p>
            </td>
        </tr>
         <tr>
            <td height='15' width='100' colspan='3'>&nbsp;</td>
        </tr>
        <tr>
            <td  colspan='2'>
                <table cellpadding='0' cellspacing='0' align='center' style='width:100%; border:1px solid #ddd;'>
                    <thead>
                        <tr>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>S.No</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px;border-right:1px solid #ddd'>Voucher Number</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>Order Date</th>
                            <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px; border-right:1px solid #ddd'>Recipient Details</th>
                            <th style='text-align: left;border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 10px;'>Treat Details</th>
                            <th style='text-align: left; border-right: 1px solid #ddd;border-bottom: 1px solid #ddd; padding: 10px;'>Price</th>
                             <th style='text-align: left; border-bottom: 1px solid #ddd; padding: 10px;'>Postage and Packaging</th>
                        </tr>
                        <tbody>";
                        $sn = 0;
                         $total_pro_price = 0;
                        foreach($productinfo AS $proval)
                        {
                         $sn++;
                         $total_pro_price = $total_pro_price + $proval->tl_product_price;
                         // $total_price = $total_pro_price + $treatcard_cost;
                         $arr_ord_voucher = explode("_",$proval->tl_cart_voucher);
                         $store_merchant_id = $proval->store_merchant_id;
                          $store_details = DB::table('tbl_tl_addstore')->where('userid',$store_merchant_id)->select('tl_addstore_address')->get();
                         $store_address = $store_details[0]->tl_addstore_address;

                          $store_mobile = DB::table('tbl_tl_user_detail')->where('tl_userdetail_userid',$store_merchant_id)->select('tl_userdetail_phoneno')->get();
                         $store_mobile1 = $store_mobile[0]->tl_userdetail_phoneno;

                          $receipient_details = DB::table('tbl_order_recipient_address')
                                ->where('cart_uniqueid',$cart_id)
                                ->where('cart_id',$proval->cart_id)
                                ->select('tl_recipient_address','tl_recipient_name')->get();

                         $message .="<tr>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>
                                $sn
                                </td>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>
                                ".$arr_ord_voucher[1]."
                                </td>
                                <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>";
                                $date=date_create($curDate); $orderdate = date_format($date,"D, M d, Y");
                                $message .="$orderdate         
                                </td>
                                 <td style='padding:10px; border-right:1px solid #ddd;border-bottom:1px solid #ddd'>".$receipient_details[0]->tl_recipient_name.",<br>Addr:- ".$receipient_details[0]->tl_recipient_address."</td>
                               <td style='padding:10px;border-right: 1px solid #ddd; border-bottom:1px solid #ddd '>
                                    ".ucfirst($proval->store_name).", 
                                <br/>
                                ".ucfirst($proval->tl_product_name)."
                                <br/>
                                $store_address ($store_mobile1)
                                </td>
                                 <td style='padding:10px;border-right: 1px solid #ddd; border-bottom:1px solid #ddd '>
                                 &pound;".$proval->tl_product_price."
                                </td>
                                <td style='padding:10px; border-bottom:1px solid #ddd '>
                                    &pound;3.50
                                </td>
                                ";

                        }
                        $total_price = $total_pro_price + ($treatcard_cost*$sn);
                     $message .="</tr>
                           
                        </tbody>
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <td height='30' width='100' >&nbsp;</td>
        </tr>
        <tr>
             <td style='width:50%'>
                <p style='font-size: 16px;'><strong>Treat By : </strong>".ucfirst($sender_detail['guest_name'])." 
                </p>
                <p><b>Address   - </b>".$sender_detail['guest_address']."</p>
                <p><b>Mobile Number - </b>".$sender_detail['guest_mobile']."</p>
                <p><b>E-mail - </b>".$sender_detail['guest_email']."</p>
            </td>
            <td style='width:100%'>
                <p  style='font-size: 16px;float:right'><strong>Total Price:</strong>
                 &pound;".number_format((float)$total_price, 2, '.', '')."</p>
            </td>
        </tr>
        <tr>
            <td height='10' width='100' >&nbsp;</td>
        </tr>
    </tbody>
     </table>

    </body>
</html>
        ";

  //  foreach($to AS $emailto){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: TreatLocally. <info@Treatlocally.com>' . "\r\n";
        $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
        if(mail($to, $subject, $message, $headers))
        {
        $status="success"; 
        
        }
        else
        {
        $status="Error";
        }
   // }
    
    }// end of subscribed emailer function

private function ordergenhitmerchant_old($to_merchant,$order_ref,$productinfo,$sender_detail,$curDate,$occasion_select,$cart_id)
{
   
    foreach($productinfo AS $proval){
         $mercant_card = DB::table('tbl_tl_card')
            ->where('cart_uniqueid',$cart_id)
            ->where('tl_product_id',$proval->tl_product_id)
            ->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name')->get();

            if($mercant_card[0]->template_id=='1')
            {
                $template1 = "
                <td style='padding:10px 0;'>
                <div class='trSampleTemplateWidth' style='max-width: 180px;margin: background:#fdf6e8; auto;border: 1px solid #000;padding: 10px;'>
                    <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                        <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                        <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>

                        <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>

                        <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                        ".$mercant_card[0]->card_message."
                        </div>

                            <div class='from'>
                                <div class='from-title' style='text-align:center'></div>
                                <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                            </div>
                            <div class='foot-logo'>
                                <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                            </div>
                        </div>
                    </div>     
                </td>
                ";
            }
            else if($mercant_card[0]->template_id=='2')
            {
                $template2 = "
                <td style='padding:10px 0;'> 
                <div class='trSampleTemplateWidth' style='max-width: 180px;margin: auto;border: 1px solid #000;padding: 10px;'>
                <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                    <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                    <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>
    
                    <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>
    
                    <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                    ".$mercant_card[0]->card_message."
                    </div>
    
                        <div class='from'>
                            <div class='from-title' style='text-align:center'></div>
                            <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                        </div>
                        <div class='foot-logo'>
                            <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                        </div>
                    </div>
                </div>     
            </td>";
            }
            else if($mercant_card[0]->template_id=='3')
            {
                $template3 = "
                <td style='padding:10px 0;'> 
                <div class='trSampleTemplateWidth' style='max-width: 180px;margin: auto;border: 1px solid #000;padding: 10px;'>
                <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                    <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                    <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>
    
                    <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>
    
                    <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                    ".$mercant_card[0]->card_message."
                    </div>
    
                        <div class='from'>
                            <div class='from-title' style='text-align:center'></div>
                            <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                        </div>
                        <div class='foot-logo'>
                            <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                        </div>
                    </div>
                </div>     
            </td>";
            }
    }
   
    $subject ='TreatLocally Order Details';
    $baseurl=url('/');
    $logo_path=url('/').'/public/frontend/img/logo.png';
    $admin_mail="sweta.gupta@karmatech.in";
    $admin_mail3="rituraj.kumar@karmatech.in";
    $admin_mail2="";
    $message ="      
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>Treatlocally</title>
<link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
<style>
    html,body{
        margin:0;
        padding:0;
        font-size: 15px;
        color: #000 !important;
        font-family: 'Work Sans', sans-serif !important;
        background-color: #eef1f6;
    }	
</style>
</head>
<body>
<div style='width:800px;margin:auto;background-color:#fff;padding:15px 50px;font-size:16px;'>
 <table style='width:800px;margin:auto;background-color:#fff;' cellspacing='0' cellpadding='0'>
                <tr>
                    <td style='text-align:center;padding:10px 0;'><img src='$logo_path' alt='' style='width:200px;'></td>
                </tr>
 </table>
 <table style='width:800px;margin:auto;background-color:#fff;' cellspacing='0' cellpadding='0'>
        <tr>
            <td style='padding-bottom:5px;'>Order Number - <b>$order_ref</b></td>
        </tr>
        <tr>
            <td style='border:1px solid #ccc;padding:13px 20px;border-right:none;font-weight:bold;'>List of orders</td>

            
            <td style='border:1px solid #ccc;padding:13px 20px;border-left:none;text-align:right;font-weight:bold;'>Price</td>
        </tr>
    </table>
    
    <table style='width:800px;margin:auto;background-color:#fff; border:1px solid #ccc; border-top:none;padding:5px 15px' cellspacing='0' cellpadding='0'>";
    $total_pro_price = 0;
    foreach($productinfo AS $proval){
        
        $mercant_card = DB::table('tbl_tl_card')
        ->where('cart_uniqueid',$cart_id)
        ->where('tl_product_id',$proval->tl_product_id)
        ->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name')->get();

        $total_pro_price = $total_pro_price + $proval->tl_product_price;
        $message .="<tr>
            <td style='padding:10px 0; vertical-align:top;padding-right:10px;'><img src='".url('/public/tl_admin/upload/merchantmod/product')."/".$proval->tl_product_image1."' alt='' style='width:200px;'></td>
            <td style='padding:10px 0; vertical-align:top;'><span style='display:block;font-weight:bold;font-size:14px;text-transform:uppercase;'>$proval->store_name </span><span style='display:block;'>$proval->tl_product_name</span></td>
            <td>";
            if($mercant_card[0]->template_id=='1')
            {
         
            $message .="$template1";
               
            }
            else if($mercant_card[0]->template_id=='2')
            {
                $message .="$template2";
            }
            else if($mercant_card[0]->template_id=='3')
            {
                $message .="$template3";
            }

        $message.= "</td>";
         $total_price = $total_pro_price + 3.50;
    }
   
     $message .="</tr>
        <tr>";
               
            $message .="<td style='padding:0 10px; text-align:right; color:#01008b;'>&pound;3.50</td>
        </tr>
    </table>
    
    <table style='width:800px;margin:auto;background-color:#fff; border:1px solid #ccc; border-top:none;padding:5px 0' cellspacing='0' cellpadding='0'>
    <tr>
        <td style='padding:10px 15px;' width='50%;'>Order On <b>";
        $date=date_create($curDate); $orderdate = date_format($date,"D, M d, Y");$message .="    $orderdate </b></td>
        <td style='padding:10px 25px; text-align:right;' width='50%;'>Grand total <b style='color:#01008b;'>&pound;$total_price</b></td>
    </tr>
    </table>
    <table style='width:800px;margin:auto;background-color:#fff; padding:15px 0' cellspacing='0' cellpadding='0'>
        <tr>
            <td><span style='font-weight:bold;'>Treat By</span>
                <p style='font-size:14px;'>".ucfirst($sender_detail['guest_name'])." ,<br>
                ".$sender_detail['guest_address']."
                <p><b>Mobile Number - </b>".$sender_detail['guest_mobile']."</p>
                <p><b>E-mail - </b>".$sender_detail['guest_email']."</p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: TreatLocally. <info@Treatlocally.com>' . "\r\n";
    $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
    if(mail($to_merchant, $subject, $message, $headers))
    {
    $status="success"; 
    
    }
    else
    {
    $status="Error";
    }


}// end of subscribed emailer function



//////////////////////////////////////////////////////////////////////////////////////////
    private function ordergeneratehitemail_old($to,$order_ref,$productinfo,$sender_detail,$curDate,$occasion_select,$cart_id)
    {

        foreach($productinfo AS $proval){
            $mercant_card = DB::table('tbl_tl_card')
               ->where('cart_uniqueid',$cart_id)
               ->where('tl_product_id',$proval->tl_product_id)
               ->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name')->get();
   
               if($mercant_card[0]->template_id=='1')
               {
                   $template1 = "
                   <td style='padding:10px 0;'>
                   <div class='trSampleTemplateWidth' style='max-width: 180px;margin: background:#fdf6e8; auto;border: 1px solid #000;padding: 10px;'>
                       <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                           <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                           <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>
   
                           <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>
   
                           <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                           ".$mercant_card[0]->card_message."
                           </div>
   
                               <div class='from'>
                                   <div class='from-title' style='text-align:center'></div>
                                   <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                               </div>
                               <div class='foot-logo'>
                                   <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                               </div>
                           </div>
                       </div>     
                   </td>
                   ";
               }
               else if($mercant_card[0]->template_id=='2')
               {
                   $template2 = "
                   <td style='padding:10px 0;'> 
                   <div class='trSampleTemplateWidth' style='max-width: 180px;margin: auto;border: 1px solid #000;padding: 10px;'>
                   <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                       <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                       <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>
       
                       <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>
       
                       <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                       ".$mercant_card[0]->card_message."
                       </div>
       
                           <div class='from'>
                               <div class='from-title' style='text-align:center'></div>
                               <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                           </div>
                           <div class='foot-logo'>
                               <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                           </div>
                       </div>
                   </div>     
               </td>";
               }
               else if($mercant_card[0]->template_id=='3')
               {
                   $template3 = "
                   <td style='padding:10px 0;'> 
                   <div class='trSampleTemplateWidth' style='max-width: 180px;margin: auto;border: 1px solid #000;padding: 10px;'>
                   <div class='template' style='  max-width: 100%; margin: auto; border: 8px solid #000;'>
                       <div class='title' style='font-size: 22px; text-align: center; margin-bottom: 10px;'></div>
                       <div class='subtitle' id='card1_reciepnt_name' style='text-align:center;'>".$mercant_card[0]->card_recipient_name."</div>
       
                       <div class='slogtitle' id='card1_occasion' style='text-align: center;color: #c49a2e;     padding: 12px 0px; font-family: 'JelyttaRegular';'>".$mercant_card[0]->card_occasion."</div>
       
                       <div class='article' id='card1_message' style='    line-height: 18px; font-size: 12px; padding: 15px 0 15px; text-align: center; max-width: 150px; width: 100%;'>
                       ".$mercant_card[0]->card_message."
                       </div>
       
                           <div class='from'>
                               <div class='from-title' style='text-align:center'></div>
                               <div class='from-name'style='text-align:center' id='card1_sender_name'>".$mercant_card[0]->card_sender_name."</div>
                           </div>
                           <div class='foot-logo'>
                               <img src='".url('/')."'/public/tl_admin/upload/merchantmod/product/black_new-mailer.png' alt='' style='width: 50px; text-align: center; margin: auto; display: block; padding: 20px;'>  
                           </div>
                       </div>
                   </div>     
               </td>";
               }
       }
       
        $subject ='TreatLocally Order Details';
        $baseurl=url('/');
        $logo_path=url('/').'/public/frontend/img/logo.png';
        $admin_mail="sweta.gupta@karmatech.in";
        $admin_mail3="rituraj.kumar@karmatech.in";
        $admin_mail2="";
        $message ="      
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>Treatlocally</title>
<link href='https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900' rel='stylesheet'>
    <style>
        html,body{
            margin:0;
            padding:0;
            font-size: 15px;
            color: #000 !important;
            font-family: 'Work Sans', sans-serif !important;
            background-color: #eef1f6;
        }	
    </style>
</head>
<body>
<div style='width:800px;margin:auto;background-color:#fff;padding:15px 50px;font-size:16px;'>
     <table style='width:800px;margin:auto;background-color:#fff;' cellspacing='0' cellpadding='0'>
                    <tr>
                        <td style='text-align:center;padding:10px 0;'><img src='$logo_path' alt='' style='width:200px;'></td>
                    </tr>
     </table>
     <table style='width:800px;margin:auto;background-color:#fff;' cellspacing='0' cellpadding='0'>
			<tr>
				<td style='padding-bottom:5px;'>Order Number - <b>$order_ref</b></td>
			</tr>
			<tr>
				<td style='border:1px solid #ccc;padding:13px 20px;border-right:none;font-weight:bold;'>List of orders</td>
				<td style='border:1px solid #ccc;padding:13px 20px;border-left:none;text-align:right;font-weight:bold;'>Price</td>
			</tr>
        </table>
        
        <table style='width:800px;margin:auto;background-color:#fff; border:1px solid #ccc; border-top:none;padding:5px 15px' cellspacing='0' cellpadding='0'>";
        $total_pro_price = 0;
        foreach($productinfo AS $proval){
            $total_pro_price = $total_pro_price + $proval->tl_product_price;
            $mercant_card = DB::table('tbl_tl_card')
            ->where('cart_uniqueid',$cart_id)
            ->where('tl_product_id',$proval->tl_product_id)
            ->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name')->get();

            $message .="<tr>
				<td style='padding:10px 0; vertical-align:top;padding-right:10px;'><img src='".url('/public/tl_admin/upload/merchantmod/product')."/".$proval->tl_product_image1."' alt='' style='width:200px;'></td>
                <td style='padding:10px 0; vertical-align:top;'><span style='display:block;font-weight:bold;font-size:14px;text-transform:uppercase;'>$proval->store_name </span><span style='display:block;'>$proval->tl_product_name</span></td>";

                if($mercant_card[0]->template_id=='1')
                {
            
                $message .="$template1";
                
                }
                else if($mercant_card[0]->template_id=='2')
                {
                    $message .="$template2";
                }
                else if($mercant_card[0]->template_id=='3')
                {
                    $message .="$template3";
                }

            $message .="<td style='padding:0 10px; text-align:right; color:#01008b;' width='52%'>&pound;$proval->tl_product_price</td>";
            $total_price = $total_pro_price + 3.50;
        }
		
         $message .="</tr>
        </table>
        
        <table style='width:800px;margin:auto;background-color:#fff; border:1px solid #ccc; border-top:none;padding:5px 0' cellspacing='0' cellpadding='0'>
        <tr>
            <td style='padding:10px 15px;' width='50%;'>Order On <b>";
            $date=date_create($curDate); $orderdate = date_format($date,"D, M d, Y");$message .="    $orderdate </b></td>
            <td style='padding:10px 25px; text-align:right;' width='50%;'>Grand total <b style='color:#01008b;'>&pound;$total_price</b></td>
        </tr>
        </table>
        <table style='width:800px;margin:auto;background-color:#fff; padding:15px 0' cellspacing='0' cellpadding='0'>
			<tr>
				<td><span style='font-weight:bold;'>Treat By</span>
					<p style='font-size:14px;'>".ucfirst($sender_detail['guest_name'])." ,<br>
					".$sender_detail['guest_address']."
					<p><b>Mobile Number - </b>".$sender_detail['guest_mobile']."</p>
					<p><b>E-mail - </b>".$sender_detail['guest_email']."</p>
				</td>
				
			</tr>
		</table>
	</div>
</body>
</html>
  ";

  //  foreach($to AS $emailto){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: TreatLocally. <info@Treatlocally.com>' . "\r\n";
        $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
        if(mail($to, $subject, $message, $headers))
        {
        $status="success"; 
        
        }
        else
        {
        $status="Error";
        }
   // }
    
    }// end of subscribed emailer function

     /* getRandomString function start*/
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
                        return $result;
                    }   //  end  getRandomString function

     private  function SubscribedEmail($subscribeemail,$verify_token)
                    {
                        $to = $subscribeemail; 
                        $varification_code=url('/').'/unsubscribe/'.$verify_token;
                        $subscribed_code = url('/').'/subscribe/'.$verify_token;
                        $subject ='Welcome To TreatLocally. Newsletters';
                        $baseurl=url('/');
                        $logo_path=url('/').'/public/frontend/img/logo.png';
                        $admin_mail="sweta.gupta@karmatech.in";
                        $admin_mail3="rituraj.kumar@karmatech.in";
                        $admin_mail2="";
                        $message = "<!DOCTYPE html>
                                    <html lang='en'>
                                    <head>
                                    <meta charset='UTF-8'>
                                    <title>TreatLocally. Newsletters</title>
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
                                                                   
                                                                  </header>
                                         
                                                <p style='font: normal 30px arial; line-height: 20px; padding: 0px 40px 15px 40px; text-align: center; color: #b22329; font-weight: bold;'></p>
                                             
                                                                  <section>
                                                                    <p style='color:#000;font-weight:bold;margin-top:15px;margin-bottom:15px; padding:0 0 0 14px;'>Dear user,</p>
                                                                    <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Thank you for subscribing to TreatLocally. </p><p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>We are glad to have you onboard
                                                                    <br>
                                                                    
                                                                    </p>

<p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'> Click <a href='$subscribed_code'>here</a> to successful newsletter subscription.</p>

                                                                    <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Got subscribed to TreatLocally. by mistake? Click <a href='$varification_code'>here</a> to unsubscribe.</p>
                                                                    <div>
                                                        
                                                        </div></section></div><span class='m_1398701988460775340im'>
                                                       
                                                              <div style='text-align:left;padding:0px 0;margin:10px 0 0 0;float:left;border-right:8px;border-right:solid 1px #ccc'>
                                                                <img src='$logo_path' alt='Logo' style='width:200px,padding:35px 0' class=''>
                                                              </div>
                                                              <div style='padding:50px 2px;margin:0 2px;float:left'>
                                                                <p style='font-size:12px;line-height:25px'><b>TreatLocally. Team</b></p>
                                                              
                                                                <a href='#' target='_blank'><p style='font-size:13px;line-height:5px'>$baseurl</p></a>
                                                              </div>
                                                            </span></td></tr></tbody></table>
                    
                                                </body>
                                                </html>
                                                  ";
                                          $headers  = 'MIME-Version: 1.0' . "\r\n";
                                          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                          $headers .= 'From: TreatLocally. <info@Treatlocally.com>' . "\r\n";
                                          $headers .= 'Bcc:'.$admin_mail.','.$admin_mail2.','.$admin_mail3.'' . "\r\n";
                                          if(mail($to, $subject, $message, $headers))
                                          {
                                            $status="success"; 
                                            
                                          }
                                          else
                                          {
                                            $status="Error";
                                          }
                                         

                                         
                    
                    
                    }// end of subscribed emailer function

//  start function unsubscribe

     public function unsubscribe(Request $request,$id=null)
    {  
     

        if(!$id)
        {
            return view("frontend.unsubscribe")->with('token_status','3');
        }
        else
        {
            
            $dt = new \DateTime();

            $verifydata = DB::table('tbl_tl_subscribe')
    ->where('tl_subscribe_token', '=',$id)->get(['tl_subscribe_admin_status','tl_subscribe_id']);

       
            if(count($verifydata)>0)
            {
                $subscribe_admin_status = $verifydata[0]->tl_subscribe_admin_status;

                $subscribe_id = $verifydata[0]->tl_subscribe_id;

                if($subscribe_admin_status=='1')
                {
                    // To do verified

                    $sql=DB::table('tbl_tl_subscribe')
                            ->where('tl_subscribe_id','=',$subscribe_id)
                            ->update([
                            'tl_subscribe_admin_status'=>'0',
                            'tl_subscribe_date'=>$dt
                            ]);

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
            return view("frontend.unsubscribe")->with('token_status',$token_status);
        }

    } //end of function unsubscribe

    //  start function subscribe

     public function subscribe(Request $request,$id=null)
    {  
     

        if(!$id)
        {
            return view("frontend.subscribe")->with('token_status','3');
        }
        else
        {
            
            $dt = new \DateTime();

            $verifydata = DB::table('tbl_tl_subscribe')
           ->where('tl_subscribe_token', '=',$id)->get(['tl_subscribe_admin_status','tl_subscribe_id']);

       // $verifydata = DB::table('tbl_tl_subscribe')
       // ->select('tl_subscribe_admin_status','tl_subscribe_id')
       // ->where('tl_subscribe_token',$id)->get();

            if(count($verifydata)>0)
            {
                $subscribe_admin_status = $verifydata[0]->tl_subscribe_admin_status;

                $subscribe_id = $verifydata[0]->tl_subscribe_id;

                if($subscribe_admin_status == '0')
                {
                    // To do verified

                    $sql=DB::table('tbl_tl_subscribe')
                            ->where('tl_subscribe_id','=',$subscribe_id)
                            ->update([
                            'tl_subscribe_admin_status'=>'1',
                            'tl_subscribe_date'=>$dt
                            ]);

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
            return view("frontend.subscribe")->with('token_status',$token_status);
        }

    } //end of function subscribe

     public  function get_faq(){
        $data = DB::table('tbl_tl_faq_category')->select('tl_faq_category_id','tl_faq_category_name')->where('tl_faq_category_status',1)->get();
        return view('frontend.faq',compact('data'));
    }

    // manage blog
  public function get_blog(Request $request,$id=null){

    if($id=="")
    {
      
    $data = DB::table('tbl_tl_blog')->select('tl_blog_id','tl_blog_title','tl_blog_description','tl_blog_image','tl_blog_addby','tl_blog_created_at')
    ->where('tl_blog_status','1')->orderBy('tl_blog_id','desc')->paginate(6);
    }
  else
    {
    
         $search = $id; 
        $data = DB::table('tbl_tl_blog')
        ->select('tl_blog_id','tl_blog_title','tl_blog_description','tl_blog_image','tl_blog_addby','tl_blog_created_at')
        ->Where('tl_blog_status','1')
        ->where(function ($subquery) use ($search) {
            $subquery->Where('tl_blog_title','LIKE','%'.$search.'%')
        ->orWhere('tl_blog_description','LIKE','%'.$search.'%');
        });
        $data=$data->paginate(6);
        
    }
    $blogimg = DB::table('tbl_tl_blogbanner')
    ->select('tl_blogbanner_image','tl_blogbanner_title')
    ->where('tl_blogbanner_id',1)->get();
    $blogimg = json_decode(json_encode($blogimg), True);

    $recentblog = DB::table('tbl_tl_blog')
    ->select('tl_blog_title','tl_blog_id','tl_blog_image','tl_blog_description')
    ->where('tl_blog_status','1')->orderBy('tl_blog_id','desc')->limit(3)->get();

    $viewcount = DB::table('tbl_tl_blogview')
    ->where('tl_blogview_status','1')
    ->select('tl_blogview_blogid','tl_blogview_update_at')
    ->orderBy('tl_blogview_viewcount','desc')->limit(4)->get();
   
    return view('frontend.blog', compact('data','recentblog','blogimg','viewcount'));
  }
  

  public function blog_detail($id=null){
   $data['detail'] = DB::table('tbl_tl_blog')
         ->select('tl_blog_updated_at','tl_blog_addby','tl_blog_status','tl_blog_title','tl_blog_description','tl_blog_image','tl_blog_addby','tl_blog_created_at')
         ->where('tl_blog_id',$id)->get();
        // print($data['detail']); exit;
         $data['detail'] = json_decode(json_encode($data['detail']), True);

       

    $data['blogimg'] = DB::table('tbl_tl_blogbanner')
    ->select('tl_blogbanner_image','tl_blogbanner_title')
    ->where('tl_blogbanner_id',1)->get();
    $data['blogimg'] = json_decode(json_encode($data['blogimg']), True);

    $data['recentblog'] = DB::table('tbl_tl_blog')
    ->select('tl_blog_title','tl_blog_image','tl_blog_id','tl_blog_description')
    ->where('tl_blog_status','1')->orderBy('tl_blog_id','desc')->limit(3)->get();
    //$data['recentblog'] = json_decode(json_encode($data['recentblog']), True);

    $data['viewcount'] = DB::table('tbl_tl_blogview')
    ->where('tl_blogview_status','1')
    ->select('tl_blogview_blogid','tl_blogview_update_at')
    ->orderBy('tl_blogview_viewcount','desc')->limit(4)->get();
         
         return view('frontend.blogdetail', compact('data'));
  }

  public function blogviewcount(Request $request){
      if($request->isMethod('POST')){
         
          $dt = new \DateTime();
          $blogid =  $request->blogid;

          if($blogid!=''){
            $sql =  DB::select("INSERT INTO tbl_tl_blogview(tl_blogview_blogid,tl_blogview_viewcount,tl_blogview_status,tl_blogview_update_at)
              VALUES('$blogid',`tl_blogview_viewcount`+1,'1','$dt')
              ON DUPLICATE KEY UPDATE `tl_blogview_viewcount` = `tl_blogview_viewcount` + 1;");
              if($sql!=''){
                  echo '1';
              }else{
                echo '2';
              }
          }
      }

  }



    // end manage blog

    function login(Request $request){
      
        if($request->isMethod('POST'))//start of post
        {
            $email=trim($request->email);
            $password=trim($request->password);
            $cartunique_id='';
            $session = 'sessionadmin';
            $role_id = '1'; 
           
    
            if($email!=""&&$password!="")
            {
            $objadminlogin = new myconfiguration();
              $user =  $objadminlogin->login($email,$password,$role_id,$session,$cartunique_id);
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

//    public function forgot_email(Request $request){
  
//         $email = trim($request->email); 
//         if($email!="")
//          {
//                      $sql=DB::table('users')
//                      ->where([
//                             ['email','=',$email],
//                             ['role_id','=','1']
//                          ])
//                      ->select('userid')
//                      ->get();
//                if(count($sql)>0)
//                 {
//                      $verify_token=$this->getRandomString(50);
                    
//                      $sql= DB::table('users')
//                                  ->where('email', $email)
//                                  ->update(['remember_token' =>$verify_token,'token_status' => '1','token_verify_status'=>'0']);
                   
//                        if($sql==true)
//                      { 
//                         $user = DB::table('users')->where('email', $email)->first();
//                         $name=$user->name;
//                         $sendemail=$this->ForgotPasswordEmail($name,$email,$verify_token);
                         
//                        return response()->json(
//                          [
//                          'status' =>'200',
//                          'msg' => 'Please check your inbox and get a new password'
//                          ]);  
//                      }



//                 }
//              else
//                {
//                     return response()->json(
//                      [
//                      'status' =>'401',
//                      'msg' => 'E- mail id does not exist'
//                      ]);
//                }


//          }
//          else
//          {
//               return response()->json(
//                  [
//                  'status' =>'401',
//                  'msg' => 'All fileds required'
//                  ]);// all fileds required;
//          }
//     }

public function forgot_email(Request $request){
    if($request->isMethod('POST')){
       
       $email = trim($request->email); 
       $role_id = '1'; 
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
    function changepassword($id=null){
             return view('tl_admin.changepassword');
    }

    // function change_password(Request $request){
    //    if($request->isMethod('POST')){
    //         $password = $request->password;
    //         $con_password = $request->con_password;
    //         $token = $request->segment;
    //         if($token!=''){
    //           // echo $token;exit;
    //             $sql_validtoken = DB::table('users')->select('remember_token')
    //                             ->where('remember_token', $token)->get();
    //         if(count($sql_validtoken)>0)
    //         {
    //             $sql_expiretoken = DB::table('users')->select('token_status')
    //                             ->where([
    //                                 ['remember_token',$token],
    //                                 ['token_status','0'],
    //                                 ['token_verify_status','1']
    //                                 ])->get();
    //             if(count($sql_expiretoken)>0)
    //             {
    //                 return response()->json(
    //                     [
    //                     'status' =>'401',
    //                     'msg' => 'your token has been expire'   
    //                     ]);
    //             }

    //            if($password!=$con_password)
    //            {
    //             return response()->json(
    //                 [
    //                 'status' =>'401',
    //                 'msg' => 'Password did not match'
    //                 ]);
    //            }



    //            $sql_chgpass = DB::table('users')
    //                           ->where([
    //                                 ['remember_token',$token],
    //                                 ['role_id',1]
    //                               ])
    //                           ->update([
    //                             'password'=>bcrypt($password),
    //                             'token_status'=>'0',
    //                             'token_verify_status'=>'1'
    //                             ]);
    //             if($sql_chgpass==true)
    //             {
    //                 return response()->json(
    //                     [
    //                     'status' =>'200',
    //                     'msg' => 'your password is successfully changed'
    //                     ]);
    //             }
    //             else
    //             {
    //                 return response()->json(
    //                     [
    //                     'status' =>'401',
    //                     'msg' => 'Something went wrong'
    //                     ]);
    //             }
    //         }
    //         else  
    //         {
    //             return response()->json(
    //             [
    //             'status' =>'401',
    //             'msg' => 'Invalid Token'
    //             ]); 
    //         }// check for invalid token
    //         }
    //    } // check for method post
    // }

    function change_password(Request $request){
        if($request->isMethod('POST')){
             $password = $request->password;
             $con_password = $request->con_password;
             $token = $request->segment;
             $role_id='1';
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

   private function ForgotPasswordEmail($name,$email,$token)
{
  $to = $email;
    $varification_code=url('/').'/tl_admin/changepassword/'.$token;
    $username=$name;
    $subject ='Treatlocally Forgot Password';
  $baseurl=url('/');
    $logo_path=url('/').'/public/tl_admin/dist/img/white-logo.png';
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
                                      <p style='margin-top:15px;margin-bottom:15px;padding:0 0 0 14px;'>Ohh seems that you forgot your password . Click the button below to get new password.
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
                                  <img src='$logo_path' alt='Logo' style='width:110px' class=''>
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

       public function get_search(Request $request){
          
        if($request->isMethod('GET')){
                  $filter_by =  $request->filter_by; 
               if($filter_by=='asc' || $filter_by=='desc' || $filter_by!='' ){
                   $categoryclause = $filter_by; 
               }else{
                $categoryclause = '';
               }
             $relation =  $request->select_relation; 
             $location =  $request->location;
              $lat =  $request->lat;
             $lng =  $request->lng; 
        if($relation!='' && $location!='' && $lat!='' && $lng!=''){
             
            $data = array(
                'relation'=> $relation,
                'location'=> $location,
                'lat'=> $lat,
                'lng'=> $lng
            );
            $sender_latitude = $data['lat'];
            $sender_longitude = $data['lng'];
            $relation = $data['relation'];  
       
        if($categoryclause==''){
            $price =  "min(tbl_tl_product.tl_product_price) AS price";
            $orderby = 'ASC';
        }
        else{
            if($categoryclause=='asc'){
                $price =  "min(tbl_tl_product.tl_product_price) AS price";
                $orderby = 'ASC';
            }
            else if($categoryclause=='desc'){
                $price =  "max(tbl_tl_product.tl_product_price) AS price";
                $orderby = 'DESC';
            }else{
                $price =  "min(tbl_tl_product.tl_product_price) AS price";
                $orderby = 'ASC';
            }  
            
          }

         $sql = "SELECT $price ,tbl_tl_addstore.userid,tbl_tl_addstore.tl_addstore_logo,tbl_tl_addstore.tl_addstore_name,tbl_tl_addstore.tl_addstore_services,tbl_tl_addstore.tl_addstore_address,tbl_tl_addstore.tl_addstore_lat,tbl_tl_addstore.tl_addstore_lng, ( 3959 * acos( cos( radians($sender_latitude) ) * cos( radians(tl_addstore_lat) ) * cos( radians(tl_addstore_lng) - radians($sender_longitude) ) + sin( radians($sender_latitude) ) * sin( radians(tl_addstore_lat) ) ) ) AS distance FROM tbl_tl_addstore INNER JOIN tbl_tl_product ON tbl_tl_product.userid = tbl_tl_addstore.userid INNER JOIN users ON users.userid = tbl_tl_addstore.userid WHERE tl_addstore_status='1' AND find_in_set('$relation',tl_product_for)  AND tbl_tl_product.tl_product_status='1' AND users.status = '1'"; 

         if($filter_by!=='asc' && $filter_by!=='desc' && $filter_by!='' ){
             $sql .= "AND tbl_tl_product.tl_product_categoryid = '$filter_by'";
         }

         $sql .= "GROUP BY tbl_tl_addstore.tl_addstore_id HAVING distance <=15 ORDER BY price $orderby ";
            $store = DB::select($sql);
            return view('frontend.search', compact('data','store'));
        }
        else{
             return redirect('/');
        }
       }
      
    }

    function openproductinfo(Request $request){
        if($request->isMethod('POST')){
         
           $productid = $request->productid; 
           $data = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
           ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
           'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
            ->get();
            $producttype = $data[0]->tl_product_treat_type;

            $curDate = new \DateTime();
            $curDate = $curDate->format("Y-m-d");
            $data[0]->tl_product_validity;

           if($curDate < $data[0]->tl_product_validity)
            {
            $expire = ''; 
            }
            else
            {
            $expire = 'expire';
            }
           

            $producttype = DB::table('_treat_type')->select('id','name')->where('id',$producttype)->get();
            $store_trmscond = DB::table('tbl_tl_addstore')->where('userid',$data[0]->userid)
                              ->select('tl_addstore_termscondt','tl_addstore_logo','tl_addstore_name','tl_addstore_aboutmerchant','tl_addstore_address')->get();


        
            $html ='
        
         <div class="flipmodal-box" id="tl_treat">         
         <div class="title ';
            if($producttype[0]->name=='Premium'){
                    $treattypecol = 'tl-title-gold';
            }else{
                $treattypecol = 'tl-title-silver';
            }
            $html.= $treattypecol.'">'.$producttype[0]->name.' TREATS</div>
         <div class="flipmodal-box-detail">
				    		<div class="col-sm-4 col-md-4 col-xs-12">
                                <div class="flipdetail-slide tlflip-slideh">
                                
					    		    <div>
				    					<div class="tlflip-slide-img">
				    						<img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image1.'" alt="" class="img-responsive">
				    					</div>
                                    </div>';
                          if($data[0]->tl_product_image2!=''){  
				    	 $html.='<div>
                                    <div class="tlflip-slide-img">
                                        <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image2.'" alt="" class="img-responsive">
                                    </div>
                                 </div>';
                          }
                                    if($data[0]->tl_product_image3!=''){
                                    $html.=
                                    '<div>
                                        <div class="tlflip-slide-img">
                                            <img src="'.url('/public').'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image3.'" alt="" class="img-responsive">
                                        </div>
                                     </div>';
                                    }
                         $html.='</div>
                            </div>
                            
                            <div class="col-sm-8 col-md-8 col-xs-12">
                            <div class="tlflip-textdetail">
                                <div class="sb-title">'.ucfirst($store_trmscond[0]->tl_addstore_name).'</div>
                                <div class="">'.ucfirst($data[0]->tl_product_name).'</div>
                                <div class="tlflip-cols">';
                                     if($data[0]->tl_product_type=="Voucher"){
                                        $html.='<li>For <b>'.$data[0]->tl_product_maxlimit.' Person</b></li>';
                                        if($expire=='')
                                        {
                                            $html.=' <li>Valid until... date <b>'.
                                           date("d-m-Y", strtotime($data[0]->tl_product_validity))
                                           .'</b></li>';
                                        }
                                        else
                                        {
                                           $html.=' <li>This voucher is expired</li>'; 
                                        }
                                        
                                     }
                                    
                                     $html.='
                                </div>
                                <div class="tlflip-uro">
				    					&pound;'.$data[0]->tl_product_price.'
                                    </div>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> '.
                                    $store_trmscond[0]->tl_addstore_address.
                                    '</p>
                                <div class="tlflip-buybtn" >
                                    <a href="'.url('review_treat').'/'.$productid.'" class="hvr-sweep-to-right">Buy Now</a>';

                                    //  <a href="'.url('make_treat_personal').'/'.$productid.'" class="hvr-sweep-to-right">Buy Now</a>

                                    if(isset($_SESSION["shopping_cart"]))
                                    {
                                        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                                        if(in_array($productid, $item_array_id))
                                        {
                                          $addcart_value = 'Already added';
                                        }else{
                                            $addcart_value = 'Add to cart';;
                                        }
                                    }else{
                                        $addcart_value = 'Add to cart';
                                    }

                                    $html.='<a href="javascript:void(0)" class="hvr-sweep-to-right tl-orange"  id="cartId'.$productid.'" onclick="return addtocart('.$productid.','.$data[0]->userid.');">'.$addcart_value.'</a>
                                    </div>
                                </div>
				    		</div>
			    		</div>
                </div>';
                
                
           
          $abt_term = '
          <div class="flipmodal-box-article" id="tl_terms">
          <div class="tl-fliparticle-text">
          <div class="tl-fliparticle-title text-left">Terms & Conditions</div>
          <p>'.
          $store_trmscond[0]->tl_addstore_termscondt
          .'</p>
                                    
            </div>
            </div> ';

            $abt_merchant = '
            <div class="tl-fliparticle-img">
            <img src="'.url('/public').'/tl_admin/upload/storelogo/'.$store_trmscond[0]->tl_addstore_logo.'" alt="" class="img-responsive">
        </div>
       
        <div class="tl-fliparticle-text">
            <div class="tl-fliparticle-title">About the merchant</div>'.
            $store_trmscond[0]->tl_addstore_aboutmerchant.
                                
        '</div> ';

            return response()->json(
                [
                'status' =>'200',
                'msg' => $html,
                'productid' => $data[0]->tl_product_id,
                'abt_term' => $abt_term,
                'abt_merchant' => $abt_merchant
                ]);     
                
            
                }else{
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Invalid Request'
                        ]); 
                }
            }
 
    function openmodalprdinfo(Request $request){
        if($request->isMethod('POST')){
           $categoryid =  $request->categoryid; 
           $storeid = $request->storeid; 
           $relation = $request->relation; 
           if($categoryid=='asc' || $categoryid=='desc' || $categoryid=='' ){
                $data = DB::table('tbl_tl_product')->where('userid',$storeid)->where('tl_product_status','1')->whereRaw("find_in_set('$relation',tl_product_for)")
                ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
                'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
                ->get();
 
           }
           else{
                $data = DB::table('tbl_tl_product')
                ->where('userid',$storeid)->where('tl_product_status','1')->where('tl_product_categoryid',$categoryid)->whereRaw("find_in_set('$relation',tl_product_for)")
                 ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
                 'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
                  ->get();
           }

            $curDate = new \DateTime();
            $curDate = $curDate->format("Y-m-d");
           

          
            $store_trmscond = DB::table('tbl_tl_addstore')->where('userid',$storeid)
            ->select('tl_addstore_termscondt','tl_addstore_logo','tl_addstore_name','tl_addstore_aboutmerchant')->get();

            $html ='<div class="flipmodal-box" id="tl_treat">'; 
            foreach($data AS $value){
                $producttype = $value->tl_product_treat_type;

                $producttype = DB::table('_treat_type')->select('id','name')->where('id',$producttype)->get();

                 if($curDate < $value->tl_product_validity)
                {
                $expire = ''; 
                }
                else
                {
                $expire = 'expire';
                }

                $html.='<div class="title ';
                 if($producttype[0]->name=='Premium'){
                      $treattypecol = 'tl-title-gold';
                 }else{
                    $treattypecol = 'tl-title-silver';
                 }
                $html.= $treattypecol.'">'.$producttype[0]->name.' TREATS</div>
                        <div class="flipmodal-box-detail">
                        <div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="flipdetail-slide tlflip-slideh">
                        <div>
                        <div class="tlflip-slide-img">
                          <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image1.'" alt="" class="img-responsive">
				    	</div>
                        </div>';
                          if($value->tl_product_image2!=''){ 
                $html.='<div>
                        <div class="tlflip-slide-img">
                         <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image2.'" alt="" class="img-responsive">
                         </div>
                        </div>';
                          }
                          if($value->tl_product_image3!=''){
                $html.='<div>
                        <div class="tlflip-slide-img">
                           <img src="'.url('/public').'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image3.'" alt="" class="img-responsive">
                        </div>
                        </div>';
                          }
                $html.='</div>
                        </div>
                        <div class="col-sm-8 col-md-8 col-xs-12">
                        <div class="tlflip-textdetail">
                        <div class="sb-title">'.ucfirst($store_trmscond[0]->tl_addstore_name).'</div>
                        <div class="">'.ucfirst($value->tl_product_name).'</div>
                        <div class="tlflip-cols">';
                          if($value->tl_product_type=="Voucher"){
                $html.='<li>For <b>'.$value->tl_product_maxlimit.' Person</b></li>';
                if($expire=='')
                {
                $html.='<li>Valid until... date <b>'.
                        date("d-m-Y", strtotime($value->tl_product_validity))
                        .'</b></li>';
                }
                else
                {
                $html.=' <li>This voucher is expired</li>'; 
                }
                }
                $html.='</div>
                        <div class="tlflip-uro">
                           &pound;'.$value->tl_product_price.'
                        </div>
                        <p>'.
                        $value->tl_product_description.
                       '</p>
                       <div class="tlflip-buybtn" >
                       <a href="'.url('review_treat').'/'.$value->tl_product_id.'" class="hvr-sweep-to-right tl_buynow">Buy Now</a>';
                       //<a href="'.url('make_treat_personal').'/'.$value->tl_product_id.'" class="hvr-sweep-to-right tl_buynow">Buy Now</a>
                       if(isset($_SESSION["shopping_cart"]))
                       {
                           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                           if(in_array($value->tl_product_id, $item_array_id))
                           {
                             $addcart_value = 'Already added';
                           }else{
                               $addcart_value = 'Add to cart';;
                           }
                       }else{
                           $addcart_value = 'Add to cart';
                       }

                       $html.='<a href="#" class="hvr-sweep-to-right tl_addcart"  id="cartId'.$value->tl_product_id.'" onclick="return addtocart('.$value->tl_product_id.','.$value->userid.');">'.$addcart_value.'</a>
                                    </div>
                                </div>
				    		</div>
			    		</div>';
  
            }                     
            $html.=' </div>';

          $abt_term = '
                <div class="flipmodal-box-article" id="tl_terms">
                <div class="tl-fliparticle-text">
                <div class="tl-fliparticle-title text-left">Terms & Conditions</div>
                <p>'.
                $store_trmscond[0]->tl_addstore_termscondt
                .'</p>
                                    
            </div>
            </div> ';


    $abt_merchant = '
    <div class="tl-fliparticle-img">
    <img src="'.url('/public').'/tl_admin/upload/storelogo/'.$store_trmscond[0]->tl_addstore_logo.'" alt="" class="img-responsive">
</div>
<div class="tl-fliparticle-text">
    <div class="tl-fliparticle-title">About the merchant</div>'.
    $store_trmscond[0]->tl_addstore_aboutmerchant.
   		    			
'</div> ';

    return response()->json(
        [
        'status' =>'200',
        'msg' => $html,
        'abt_term' => $abt_term,
        'abt_merchant' => $abt_merchant
        ]);     
        
    
        }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid Request'
                ]); 
        }
    }

     function openmodalstorepro(Request $request){
        if($request->isMethod('POST')){

           $storeid = $request->storeid;
              
            $storepro = DB::table('tbl_tl_product')
            ->where('userid',$storeid)->where('tl_product_status','1')
             ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
             'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
              ->get();

            // print_r($storepro); exit;

            $store_trmscond = DB::table('tbl_tl_addstore')->where('userid',$storeid)
            ->select('tl_addstore_termscondt','tl_addstore_logo','tl_addstore_name','tl_addstore_aboutmerchant')->get();
             $curDate = new \DateTime();
             $curDate = $curDate->format("Y-m-d");

            $html ='<div class="flipmodal-box" id="tl_treat">'; 
            foreach($storepro AS $value){
                $producttype = $value->tl_product_treat_type;

                $producttype = DB::table('_treat_type')->select('id','name')->where('id',$producttype)->get();

                if($curDate < $value->tl_product_validity)
                {
                $expire = ''; 
                }
                else
                {
                $expire = 'expire';
                }

                $html.='<div class="title ';
                 if($producttype[0]->name=='Premium'){
                      $treattypecol = 'tl-title-gold';
                 }else{
                    $treattypecol = 'tl-title-silver';
                 }
                $html.= $treattypecol.'">'.$producttype[0]->name.' TREATS</div>
                        <div class="flipmodal-box-detail">
                        <div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="flipdetail-slide tlflip-slideh">
                        <div>
                        <div class="tlflip-slide-img">
                          <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image1.'" alt="" class="img-responsive">
                        </div>
                        </div>';
                          if($value->tl_product_image2!=''){ 
                $html.='<div>
                        <div class="tlflip-slide-img">
                         <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image2.'" alt="" class="img-responsive">
                         </div>
                        </div>';
                          }
                          if($value->tl_product_image3!=''){
                $html.='<div>
                        <div class="tlflip-slide-img">
                           <img src="'.url('/public').'/tl_admin/upload/merchantmod/product/'.$value->tl_product_image3.'" alt="" class="img-responsive">
                        </div>
                        </div>';
                          }
                $html.='</div>
                        </div>
                        <div class="col-sm-8 col-md-8 col-xs-12">
                        <div class="tlflip-textdetail">
                        <div class="sb-title">'.ucfirst($store_trmscond[0]->tl_addstore_name).'</div>
                        <div class="">'.ucfirst($value->tl_product_name).'</div>
                        <div class="tlflip-cols">';
                          if($value->tl_product_type=="Voucher"){
                $html.='<li>For <b>'.$value->tl_product_maxlimit.' Person</b></li>';
                if($expire=='')
                {
                $html.='<li>Valid until... date <b>'.
                        date("d-m-Y", strtotime($value->tl_product_validity))
                        .'</b></li>';
                }
                else
                {
                $html.=' <li>This voucher is expired</li>'; 
                }
                           }
                $html.='</div>
                        <div class="tlflip-uro">
                           &pound;'.$value->tl_product_price.'
                        </div>
                        <p>'.
                        $value->tl_product_description.
                       '</p>
                       <div class="tlflip-buybtn" >
                       <a href="'.url('review_treat').'/'.$value->tl_product_id.'" class="hvr-sweep-to-right tl_buynow">Buy Now</a>';
                       //<a href="'.url('make_treat_personal').'/'.$value->tl_product_id.'" class="hvr-sweep-to-right tl_buynow">Buy Now</a>
                       if(isset($_SESSION["shopping_cart"]))
                       {
                           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                           if(in_array($value->tl_product_id, $item_array_id))
                           {
                             $addcart_value = 'Already added';
                           }else{
                               $addcart_value = 'Add to cart';;
                           }
                       }else{
                           $addcart_value = 'Add to cart';
                       }

                       $html.='<a href="#" class="hvr-sweep-to-right tl_addcart"  id="cartId'.$value->tl_product_id.'" onclick="return addtocart('.$value->tl_product_id.','.$value->userid.');">'.$addcart_value.'</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
  
            }                     
            $html.=' </div>';

           // echo $html; exit;

          $abt_term = '
                <div class="flipmodal-box-article" id="tl_terms">
                <div class="tl-fliparticle-text">
                <div class="tl-fliparticle-title text-left">Terms & Conditions</div>
                <p>'.
                $store_trmscond[0]->tl_addstore_termscondt
                .'</p>
                                    
            </div>
            </div> ';


                $abt_merchant = '
                <div class="tl-fliparticle-img">
                <img src="'.url('/public').'/tl_admin/upload/storelogo/'.$store_trmscond[0]->tl_addstore_logo.'" alt="" class="img-responsive">
            </div>
            <div class="tl-fliparticle-text">
                <div class="tl-fliparticle-title">About the merchant</div>'.
                $store_trmscond[0]->tl_addstore_aboutmerchant.
                                    
            '</div> ';

           

        return response()->json(
            [
            'status' =>'200',
            'msg' => $html,
            'abt_term' => $abt_term,
            'abt_merchant' => $abt_merchant
            ]);     
            
    
            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Invalid Request'
                    ]); 
            }
    }

    function prdinfo(Request $request){
        if($request->isMethod('POST')){
         
           $productid = $request->productid; 
           $curDate = new \DateTime();
           $curDate = $curDate->format("Y-m-d");
           $data = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
           ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
           'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
            ->get();
            $producttype = $data[0]->tl_product_treat_type;

            $producttype = DB::table('_treat_type')->select('id','name')->where('id',$producttype)->get();
            $store_trmscond = DB::table('tbl_tl_addstore')->where('userid',$data[0]->userid)
                              ->select('tl_addstore_termscondt','tl_addstore_logo','tl_addstore_name','tl_addstore_aboutmerchant')->get();
            if($curDate < $data[0]->tl_product_validity)
            {
            $expire = ''; 
            }
            else
            {
            $expire = 'expire';
            }
           

            $html ='
        
            <div class="flipmodal-box" id="tl_treat2">        
            <div class="title tl-title-gold">'.$producttype[0]->name.'  Treats</div>
            <div class="flipmodal-box-detail flipmodal-box-mr0">
            <div class="col-sm-4 col-md-4 col-xs-12">
            <div class="flipdetail-slide tlflip-slide">
                <div>
                    <div class="tlflip-slide-img">
                    <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image1.'" alt="" class="img-responsive">
                    </div>
                </div>
                <div>
                    <div class="tlflip-slide-img">
                    <img src="'.url("/public").'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image2.'" alt="" class="img-responsive">
                    </div>
                </div>
                <div>
                    <div class="tlflip-slide-img">
                    <img src="'.url('/public').'/tl_admin/upload/merchantmod/product/'.$data[0]->tl_product_image3.'" alt="" class="img-responsive">
                    </div>
                </div>
            </div>
                    </div>
                    <div class="col-sm-8 col-md-8 col-xs-12">
                    <div class="tlflip-textdetail">
                        <div class="sb-title">'.$store_trmscond[0]->tl_addstore_name.'</div>
                        <div class="">'.$data[0]->tl_product_name.'</div>
                        <div class="tlflip-cols">';
                         if($data[0]->tl_product_type=="Voucher"){
                            $html.='<li>For <b>'.$data[0]->tl_product_maxlimit.' Person</b></li>';
                            if($expire=='')
                            {
                            $html.='<li>Valid until... date <b>'.
                            date("d-m-Y", strtotime($data[0]->tl_product_validity))
                            .'</b></li>'; 
                            }
                            else
                            {
                            $html.=' <li>This voucher is expired</li>'; 
                            }
                         }
                            $html.='<li><i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i></li>
                        </div>

                        <div class="tlflip-uro">
                            &pound;'.$data[0]->tl_product_price.'
                        </div>
                        <p>'.
                        $data[0]->tl_product_description.
                        ' </p>

                    </div>
                </div>
                </div>
                </div>
                <div class="tl-treatheader-collapse">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel">
                    <div class="panel-heading" role="tab" id="headingone">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseone" aria-expanded="false" aria-controls="collapseone">
                          Terms and conditions
                        </a>
                      </h4>
                    </div>
                    <div id="collapseone" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingone">
                      <div class="panel-body">'.
                      $store_trmscond[0]->tl_addstore_termscondt
                      .' </div>
                    </div>
                  </div>
                  <div class="panel">
                    <div class="panel-heading" role="tab" id="headingtwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwo" aria-expanded="false" aria-controls="collapsetwo">
                            About the merchant
                        </a>
                      </h4>
                    </div>
                    <div id="collapsetwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwo">
                      <div class="panel-body">'.
                      $store_trmscond[0]->tl_addstore_aboutmerchant.
                                             
                  ' </div>
                    </div>
                  </div>
            </div>
           </div>
                
                ';

    return response()->json(
        [
        'status' =>'200',
        'msg' => $html
    
        ]);     
        
    
        }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Invalid Request'
                ]); 
        }
    }

    public function get_make_treat_personal($productid){
       if($productid!=''){
            $personalise_info = DB::table('tbl_tl_personalise')
            ->where('tl_personalise_id', '=','1')
            ->select('tl_personalise_info')->get();
            $data = DB::table('_template')->select('id','template')->get();
        return view('frontend.maketreat_personal',compact('data','personalise_info'))->with('productid', $productid);;

            
        //     $product_detail = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
        //     ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
        //     'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
        //      ->get();
            
        //     $tl_product_id = $product_detail[0]->tl_product_id;
        //     $tl_product_name = $product_detail[0]->tl_product_name;
        //     $tl_product_image1 = $product_detail[0]->tl_product_image1;
        //     $tl_product_description = $product_detail[0]->tl_product_description;
        //     $tl_product_price = $product_detail[0]->tl_product_price;
        //     $userid = $product_detail[0]->userid;

        //     $datastorename = DB::table('tbl_tl_addstore')->where('userid',$userid)->select                           ('tl_addstore_id','tl_addstore_name')->get();

        //     $storename = $datastorename[0]->tl_addstore_name;
        //     $tl_addstore_id = $datastorename[0]->tl_addstore_id;

        //    if(!empty($_SESSION["shopping_cart"]))
        //    {	
        //      $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        //      if(!in_array($productid, $item_array_id))
        //             {
                      
        //                 $count = count($_SESSION["shopping_cart"]);
        //                 $item_array = array(
        //                     'item_id'			=>	$productid,
        //                     'item_name'			=>	$tl_product_name,
        //                     'item_price'		=>	$tl_product_price,
        //                     'item_image'		=>	$tl_product_image1,
        //                     'item_description'		=>	$tl_product_description,
        //                     'item_storeid'    =>  $tl_addstore_id,
        //                     'item_storemerchant_id'   =>  $userid,
        //                     'item_storename'		=>	$storename
        //                 );
        //                 $_SESSION["shopping_cart"][$count] = $item_array;
        //                 $data = DB::table('_template')->select('id','template')->get();
        //                 return view('frontend.maketreat_personal',compact('data','personalise_info'));

        //             }else{
        //                 $data = DB::table('_template')->select('id','template')->get();
        //                 return view('frontend.maketreat_personal',compact('data','personalise_info'));
        //             }
        //    }
        //    else
        //         {
                   
        //             $item_array = array(
        //                 'item_id'			=>	$productid,
        //                 'item_name'			=>	$tl_product_name,
        //                 'item_price'		=>	$tl_product_price,
        //                 'item_image'		=>	$tl_product_image1,
        //                 'item_description'		=>	$tl_product_description,
        //                 'item_storeid'    =>  $tl_addstore_id,
        //                 'item_storemerchant_id'   =>  $userid,
        //                 'item_storename'		=>	$storename
        //             );
                    
        //             $_SESSION["shopping_cart"][0] = $item_array;
                  
        //             $data = DB::table('_template')->select('id','template')->get();
        //              return view('frontend.maketreat_personal',compact('data','personalise_info'));
        //         }
        //    }
        
        // else{
           
        //     if(!empty($_SESSION["shopping_cart"])){	

        //         $personalise_info = DB::table('tbl_tl_personalise')
        //         ->where('tl_personalise_id', '=','1')
        //         ->select('tl_personalise_info')->get();

        //         $data = DB::table('_template')->select('id','template')->get();
        //         return view('frontend.maketreat_personal',compact('data','personalise_info'));
        //       }
        //       else{
        //         return redirect('/');
        //       }
             
        // }
      
    }

    // public function get_make_treat_personal($productid=null){
  
     
    //     if($productid!=''){

    //         $personalise_info = DB::table('tbl_tl_personalise')
    //         ->where('tl_personalise_id', '=','1')
    //         ->select('tl_personalise_info')->get();
            
    //         $product_detail = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
    //         ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
    //         'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
    //          ->get();
            
    //         $tl_product_id = $product_detail[0]->tl_product_id;
    //         $tl_product_name = $product_detail[0]->tl_product_name;
    //         $tl_product_image1 = $product_detail[0]->tl_product_image1;
    //         $tl_product_description = $product_detail[0]->tl_product_description;
    //         $tl_product_price = $product_detail[0]->tl_product_price;
    //         $userid = $product_detail[0]->userid;

    //         $datastorename = DB::table('tbl_tl_addstore')->where('userid',$userid)->select                           ('tl_addstore_id','tl_addstore_name')->get();

    //         $storename = $datastorename[0]->tl_addstore_name;
    //         $tl_addstore_id = $datastorename[0]->tl_addstore_id;

    //        if(!empty($_SESSION["shopping_cart"])){	
    //          $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
    //          if(!in_array($productid, $item_array_id))
    //                 {
                      
    //                     $count = count($_SESSION["shopping_cart"]);
    //                     $item_array = array(
    //                         'item_id'			=>	$productid,
    //                         'item_name'			=>	$tl_product_name,
    //                         'item_price'		=>	$tl_product_price,
    //                         'item_image'		=>	$tl_product_image1,
    //                         'item_description'		=>	$tl_product_description,
    //                         'item_storeid'    =>  $tl_addstore_id,
    //                         'item_storemerchant_id'   =>  $userid,
    //                         'item_storename'		=>	$storename
    //                     );
    //                     $_SESSION["shopping_cart"][$count] = $item_array;
    //                     $data = DB::table('_template')->select('id','template')->get();
    //                     return view('frontend.maketreat_personal',compact('data','personalise_info'));

    //                 }else{
    //                     $data = DB::table('_template')->select('id','template')->get();
    //                     return view('frontend.maketreat_personal',compact('data','personalise_info'));
    //                 }
    //        }
    //        else
    //             {
                   
    //                 $item_array = array(
    //                     'item_id'			=>	$productid,
    //                     'item_name'			=>	$tl_product_name,
    //                     'item_price'		=>	$tl_product_price,
    //                     'item_image'		=>	$tl_product_image1,
    //                     'item_description'		=>	$tl_product_description,
    //                     'item_storeid'    =>  $tl_addstore_id,
    //                     'item_storemerchant_id'   =>  $userid,
    //                     'item_storename'		=>	$storename
    //                 );
                    
    //                 $_SESSION["shopping_cart"][0] = $item_array;
                  
    //                 $data = DB::table('_template')->select('id','template')->get();
    //                  return view('frontend.maketreat_personal',compact('data','personalise_info'));
    //             }
    //     }else{
           
    //         if(!empty($_SESSION["shopping_cart"])){	

    //             $personalise_info = DB::table('tbl_tl_personalise')
    //             ->where('tl_personalise_id', '=','1')
    //             ->select('tl_personalise_info')->get();

    //             $data = DB::table('_template')->select('id','template')->get();
    //             return view('frontend.maketreat_personal',compact('data','personalise_info'));
    //           }
    //           else{
    //             return redirect('/');
    //           }
             
    //     }
      
     }

    public function store_make_treat_personal(Request $request){
        if($request->isMethod('POST')){
            
            $dt = new \DateTime();
            $ip_address =  \Request::ip(); 
           $templateid = $request->button_value;
           $recipient_name = $request->recipient_name;
           $recipient_occasion = $request->recipient_occasion;
           $message = $request->message;
           $sender_name = $request->sender_name;

          // $date = $request->datepicker;
           $unique_id = uniqid();
           $session_all=Session::get('sessionuser');
           if($session_all!=false){
             $userid = $session_all['userid']; 
           }else{
            $userid = ''; 
           }
          
        

           if(!empty($_SESSION["shopping_cart"])){	
               $cart_product = $_SESSION["shopping_cart"];
             
               DB::beginTransaction();
               try {
                   foreach($cart_product AS $value){
                     DB::table('tbl_tl_user_cart')
                         ->insert([
                             'cart_uniqueid'=> $unique_id,
                             'userid'=> $userid,
                             'store_id'=> $value['item_storeid'],
                             'store_merchant_id'=> $value['item_storemerchant_id'],
                             'store_name'=> $value['item_storename'],
                             'tl_product_id'=> $value['item_id'],
                             'tl_product_name'=> $value['item_name'],
                             'tl_product_image1'=> $value['item_image'],
                             'tl_product_description'=> $value['item_description'],
                             'tl_product_price'=> $value['item_price'],
                             'cart_create_at'=> $dt,
                             'cart_updatetime'=> $dt,
                             'ip_address'=> $ip_address,
                             'tl_cart_status'=>'CART'

                         ]);

                         }
               
                        DB::table('tbl_tl_card')->insert([
                            'cart_uniqueid'=> $unique_id,
                             'userid'=> $userid,
                             'template_id'=>$templateid,
                             'card_recipient_name'=>$recipient_name,
                             'card_occasion'=>$recipient_occasion,
                             'card_message'=>$message,
                             'card_sender_name'=>$sender_name,
                            // 'card_delievery_date'=> $date,
                             'template_create_at'=> $dt,
                             'template_updated_at'=> $dt,
                             'ip_address'=> $ip_address
                        ]);

                        if(isset($_SESSION["unique_cart_id"]) && !empty($_SESSION["unique_cart_id"]))
                        {
                                unset($_SESSION["unique_cart_id"]);
                                $_SESSION["unique_cart_id"] = $unique_id;
                        }
                        else
                        {
                            $_SESSION["unique_cart_id"] = $unique_id;
                        }
                        

                  DB::commit();
                // all good
                   return response()->json(   
                    [
                    'status' =>'200',
                    'msg' => 'Inserted successfully',
                    'cart_uniqueid' => $unique_id
                    ]);
               } catch (\Exception $e) {
                   DB::rollback();
                    return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Something went wrong'
                            ]);
               }
           }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Add item in your cart.'
                ]);
           }
        }
       // return view('frontend.payment_mode');
     }

     public function store_make_treat_personal1(Request $request){  
        if($request->isMethod('POST')){
            
            $dt = new \DateTime();
            $ip_address =  \Request::ip(); 
           $templateid = $request->button_value;
           $productid = $request->productid;
           $unique_cart_id1 = $request->unique_cart_id1;
           $recipient_name = $request->recipient_name;
           $recipient_occasion = $request->recipient_occasion;
           $message = $request->message;
           $sender_name = $request->sender_name;
           $sender_name1 = $request->sender_name1;

           if($productid!='' && $unique_cart_id1!='')
           {
            DB::table('tbl_tl_card')->where('cart_uniqueid',$unique_cart_id1)->where('tl_product_id',$productid)->update([
                'template_id'=>$templateid,
                'card_recipient_name'=>$recipient_name,
                'card_occasion'=>$recipient_occasion,
                'card_message'=>$message,
                'card_sender_name'=>$sender_name,
                'card_sender_name1'=> $sender_name1,
                'template_updated_at'=> $dt,
                'ip_address'=> $ip_address
            ]);
                return response()->json(   
                [
                'status' =>'200',
                'msg' => 'Updated successfully',
                'cart_uniqueid' => ''
                ]);
           }
           else
           if($productid!='' && $unique_cart_id1==''){
                if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"]))
                {
                 $unique_id = $_SESSION["cartuniqueid"];
                }
                else
                {
                 $unique_id = date('Ymdhis').'_'.uniqid();
                 $_SESSION["cartuniqueid"] = $unique_id;
                }
               
                $session_all=Session::get('sessionuser');
                if($session_all!=false){
                  $userid = $session_all['userid']; 
                }else{
                 $userid = ''; 
                }
     
                 $product_detail = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
                 ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
                 'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
                 ->get();
                 
                 $tl_product_id = $product_detail[0]->tl_product_id;
                 $tl_product_name = $product_detail[0]->tl_product_name;
                 $tl_product_image1 = $product_detail[0]->tl_product_image1;
                 $tl_product_description = $product_detail[0]->tl_product_description;
                 $tl_product_price = $product_detail[0]->tl_product_price;
                 $merchantuserid = $product_detail[0]->userid;
 
                 $datastorename = DB::table('tbl_tl_addstore')->where('userid',$merchantuserid)->select('tl_addstore_id','tl_addstore_name')->get();
 
                 $storename = $datastorename[0]->tl_addstore_name;
                 $tl_addstore_id = $datastorename[0]->tl_addstore_id;
                 
                     DB::beginTransaction();
                     try {
                         DB::table('tbl_tl_user_cart')
                             ->insert([
                                 'cart_uniqueid'=> $unique_id,
                                 'userid'=> $userid,
                                 'store_id'=> $tl_addstore_id,
                                 'store_merchant_id'=> $merchantuserid,
                                 'store_name'=> $storename,
                                 'tl_product_id'=> $tl_product_id,
                                 'tl_product_name'=> $tl_product_name,
                                 'tl_product_image1'=> $tl_product_image1,
                                 'tl_product_description'=> $tl_product_description,
                                 'tl_product_price'=> $tl_product_price,
                                 'cart_create_at'=> $dt,
                                 'cart_updatetime'=> $dt,
                                 'ip_address'=> $ip_address,
                                 'tl_cart_status'=>'CART'
     
                             ]);
 
                             $cart_id = DB::getPdo()->lastInsertId();
 
                             DB::table('tbl_tl_card')->insert([
                                 'cart_id'=> $cart_id,
                                 'cart_uniqueid'=> $unique_id,
                                 'tl_product_id'=> $tl_product_id,
                                 'userid'=> $userid,
                                 'template_id'=>$templateid,
                                 'card_recipient_name'=>$recipient_name,
                                 'card_occasion'=>$recipient_occasion,
                                 'card_message'=>$message,
                                 'card_sender_name'=>$sender_name,
                                 'card_sender_name1'=> $sender_name1,
                                 'template_create_at'=> $dt,
                                 'template_updated_at'=> $dt,
                                 'ip_address'=> $ip_address
                             ]);
                             $card_id = DB::getPdo()->lastInsertId();
                             DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid)->update([
                                'card_id'=>$card_id,
                                'cart_id'=>$cart_id,
                                'userid'=>$userid
                            ]);
     
                     DB::commit();
                     // all good
                         return response()->json(   
                         [
                         'status' =>'200',
                         'msg' => 'Inserted successfully',
                         'cart_uniqueid' => $unique_id
                         ]);
                     } catch (\Exception $e) {
                         DB::rollback();
                         return response()->json(
                                 [
                                 'status' =>'401',
                                 'msg' => 'Something went wrong'
                                 ]);
                     }
            
           }
           
          
        }
       // return view('frontend.payment_mode');
     }

     public function addtocart(Request $request){
             $productid = $request->productid; 
             $userid = $request->userid; 
         if($productid!=''){
        
            $data = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
            ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
            'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
             ->get();
            
            $storename = DB::table('tbl_tl_addstore')->where('userid',$userid)->select('tl_addstore_name','tl_addstore_id')->get();
            
            $tl_product_id = $data[0]->tl_product_id;
            $tl_product_name = $data[0]->tl_product_name;
            $tl_product_image1 = $data[0]->tl_product_image1;
            $tl_product_description = $data[0]->tl_product_description;
            $tl_product_price = $data[0]->tl_product_price;
            $tl_addstore_name = $storename[0]->tl_addstore_name;
            $tl_addstore_id = $storename[0]->tl_addstore_id;
            

                if(isset($_SESSION["shopping_cart"]))
                {
                  // echo  $count_cart_item = 'awsfg'.count($_SESSION["shopping_cart"]); exit;
                    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                 
                    if(!in_array($productid, $item_array_id))
                    {
                 
                        $count = count($_SESSION["shopping_cart"]);
                        $item_array = array(
                            'item_id'			=>	$productid,
                            'item_name'			=>	$tl_product_name,
                            'item_price'		=>	$tl_product_price,
                            'item_image'		=>	$tl_product_image1,
                            'item_description'		=>	$tl_product_description,
                            'item_storeid'		=>	$tl_addstore_id,
                            'item_storemerchant_id'		=>	$userid,
                            'item_storename'		=>	$tl_addstore_name
                        );
                        $_SESSION["shopping_cart"][$count] = $item_array;
                     
                    }
                    else
                    {
                      
                       return response()->json(
                        [
                        'status' =>'401',
                         'item_id' => $productid,
                        'msg' => 'Item already added'
                        ]); 
                    }
                } 
                else
                {
                  //  echo  $count_cart_item = count($_SESSION["shopping_cart"]); exit;
                  
                    $item_array = array(
                        'item_id'			=>	$productid,
                        'item_name'			=>	$tl_product_name,
                        'item_price'		=>	$tl_product_price,
                        'item_image'		=>	$tl_product_image1,
                        'item_description'		=>	$tl_product_description,
                        'item_storeid'		=>	$tl_addstore_id,
                        'item_storemerchant_id'		=>	$userid,
                        'item_storename'		=>	$tl_addstore_name
                    );
                    // session(['user_id' => $user_id]);
                    $_SESSION["shopping_cart"][0] = $item_array;
                }
                $count_cart_item = count($_SESSION["shopping_cart"]);

                $cart_index = $count_cart_item-1; 
               $image_name = $_SESSION["shopping_cart"][$cart_index]['item_image'];
               $item_name = $_SESSION["shopping_cart"][$cart_index]['item_name']; 
               $item_description = $_SESSION["shopping_cart"][$cart_index]['item_description']; 

                  $string = $item_description;
                      if (strlen($string) > 100) {
                       $stringCut = substr($string, 0, 100);
                       $endPoint = strrpos($stringCut, ' ');
                       $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                      
                   }

               $item_price = $_SESSION["shopping_cart"][$cart_index]['item_price']; 
               $item_id = $_SESSION["shopping_cart"][$cart_index]['item_id']; 
               $item_storename = $_SESSION["shopping_cart"][$cart_index]['item_storename'];
               return response()->json(
                [
                'status' =>'200',
                'msg' => 'Added to cart',
                'count_cart_item' => $count_cart_item,
               'image_name' => $image_name,
               'item_name' => $item_name,
               'item_description' => $string,
               'item_price' => $item_price,
               'item_id' => $item_id,
               'cart_index' => $cart_index,
               'item_storename' => $item_storename
                
                ]); 

         }
          

     }

     public function remove_cart_item(Request $request){
       
                  $itemid =  $request->itemid;
                 
                       
            if($itemid!=''){
                foreach($_SESSION["shopping_cart"] as $keys => $values)
                {
                    if($values["item_id"] == $itemid)
                    {
                        unset($_SESSION["shopping_cart"][$keys]);
                        $count_cart_item = count($_SESSION["shopping_cart"]);
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Item removed successfully',
                            'count_cart_item' => $count_cart_item
                            ]); 
                    }
                }
           }
     }

     public function payment_mode($id){

        if(isset($_SESSION["shopping_cart"]))
        {  
           
            
            $curDate = new \DateTime();
            $data = DB::table('tbl_tl_user_cart')
                ->where('cart_uniqueid',$id)
            ->select('cart_uniqueid','userid','store_name','tl_product_name','tl_product_image1','tl_product_description','tl_product_price')->get();
                  
            $card_details = DB::table('tbl_tl_card')->where('cart_uniqueid',$id)->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name','card_sender_name1')->get();
           
             
           return view('frontend.payment_mode',compact('data','card_details'))->with('curdate',$curDate->format("Y-m-d"));
        }else{
            return redirect('/');
        }
     }

     public function store_payment_old(Request $request){
         if($request->isMethod('POST')){
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip();

            $total_price = $request->formdata_total_price;
            $recipient_name = $request->formdata_recipient_name;
            $recipient_mobile = '';
            $recipient_email = '';
            $recipient_address = $request->formdata_recipient_address;
            $recipient_city = $request->formdata_recipient_city;
            $recipient_country    = $request->formdata_recipient_country ;
            $recipient_postcode = $request->formdata_recipient_postcode;
            $cart_id = $request->cart_id;
            $user_type = $request->formdata_user_type;
            $paytoken = $request->stripeToken;

            $orderdetail = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select                    ('store_id','store_merchant_id','tl_product_id')->get();
            
            $merchantuserid = '';
            $store_id = '';
            $producttype1 = array();
             foreach($orderdetail AS $val){
                $merchantuserid .= $val->store_merchant_id.',';
                $store_id .= $val->store_id.',';

                $producttype = DB::table('tbl_tl_product')->where('tl_product_id',$val->tl_product_id)->where('tl_product_type','Voucher')->select('tl_product_id')->get();

                $producttype = json_decode(json_encode($producttype), True);
                if(count($producttype)>0){
                 array_push($producttype1,$producttype[0]['tl_product_id']);
                }
             }

            
             if(count($producttype1)>0)
             {
                $restprice = 0;
                foreach($producttype1 AS $producttype1_val){
                    $reedeemprice = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',     $cart_id)->where('tl_product_id',$producttype1_val)->select('tl_product_price')->get(); 
     
                    $restprice = $restprice + $reedeemprice[0]->tl_product_price;
                  }
             }
             else
             {
                $restprice = '';
             }
            
           
        //   echo $merchantuserid = implode(',',$orderdetail); exit;

            $session_all=Session::get('sessionuser');
            if($session_all==true){
                $userid = $session_all['userid']; 
                $register_user_data = DB::table('users')
                                        ->join('tbl_tl_user_detail','users.userid','tbl_tl_user_detail.tl_userdetail_userid')
                                        ->where('userid',$userid)
                                        ->select('name','email','tbl_tl_user_detail.tl_userdetail_phoneno','tbl_tl_user_detail.tl_userdetail_address')->get();
                 if($register_user_data[0]->name!=''){
                    $guest_name = $register_user_data[0]->name;
                 }else{
                    $guest_name = '';
                 }

                 if($register_user_data[0]->tl_userdetail_phoneno!=''){
                    $guest_mobile = $register_user_data[0]->tl_userdetail_phoneno;
                 }else{
                    $guest_mobile ='';
                 }

                 if($register_user_data[0]->email!=''){
                    $guest_email = $register_user_data[0]->email;
                 }else{
                    $guest_email = '';
                 }

                 if($register_user_data[0]->tl_userdetail_address!=''){
                    $guest_address = $register_user_data[0]->tl_userdetail_address;
                 }else{
                    $guest_address = '';
                 }

                $guest_city = '';
                $guest_country = '';
                $guest_postcode ='';

            }else{
                $userid = date('Ymdhis'); 
                $guest_name = $request->formdata_guest_name;
                $guest_mobile = $request->formdata_guest_mobile;
                $guest_email = $request->formdata_guest_email;
                $guest_address = $request->formdata_guest_address; 
                $guest_city = $request->formdata_guest_city;
                $guest_country = $request->formdata_guest_country;
                $guest_postcode = $request->formdata_guest_postcode;
            }
           
             function generateorderref() {
                    $number = mt_rand(100000, 999999); 
                
                 
                    if (generateorderrefExists($number)) {
                        return generateorderref();
                    }
                
                   
                    return $number;
                }
                
                function generateorderrefExists($number) {
                   
                    return DB::table('tbl_tl_order')->where('tl_order_ref',$number)->exists();
                }
                 $order_ref = '#'.generateorderref(); 
                 $orderid = $userid.'_'.$order_ref;

                $amount = "2";

                $charge = chargeuser($paytoken,$amount,$orderid);
                if(isset($charge['chargeid'])  && $charge['chargeid']!=''  && isset($charge['transactionid']) && $charge['transactionid']!='' )
                {
                        // DB::beginTransaction();
                        // try {
                    DB::table('tbl_tl_treatuser')
                    ->insert([
                        'userid'=> $userid,
                        'cart_uniqueid'=> $cart_id,
                        'tl_tuser_fullname'=> $guest_name,
                        'tl_tuser_mobile'=> $guest_mobile,
                        'tl_tuser_email'=> $guest_email, 
                        'tl_tuser_address'=> $guest_address,
                        'tl_tuser_city'=> $guest_city,
                        'tl_tuser_country'=> $guest_country,
                        'tl_tuser_postcode'=> $guest_postcode,
                        'tl_tuser_type'=> $user_type,
                        'tl_tuser_ip'=>$ip_address ,
                       'tl_tuser_created_at'=> $curDate ,
                       'tl_tuser_updated_at'=> $curDate
                    ]);
                   
                   
                    $data = DB::table('tbl_tl_order')  
                    ->insert([
                       'cart_uniqueid'=> $cart_id,
                       'userid'=> $userid,
                       'tl_order_ref'=> $orderid,
                       'store_id'=>  rtrim($store_id,','),
                       'store_merchant_id'=> rtrim($merchantuserid,','),
                       'tl_cart_subtotal'=> $total_price,
                       'tl_recipient_name'=> $recipient_name ,
                       'tl_recipient_mobile'=> $recipient_mobile,
                       'tl_recipient_email'=>$recipient_email ,
                       'tl_recipient_address'=>$recipient_address ,
                       'tl_recipient_city'=> $recipient_city ,
                       'tl_recipient_country'=> $recipient_country,
                       'tl_recipient_postcode'=> $recipient_postcode,
                       'tl_order_chargeid'=> $charge['chargeid'],
                       'tl_order_transactionid'=> $charge['transactionid'],
                       'tl_order_paymode'=> 'CARD',
                       'tl_order_paystatus'=>'YES',
                       'tl_order_status'=>'PLACED',   
                       'tl_order_partial_reedeem'=> $restprice,
                       'tl_thankyou_status'=>'1',
                       'tl_order_userip'=>$ip_address ,
                       'tl_order_created_at'=> $curDate ,   
                       'tl_order_updated_at'=> $curDate
                       
                   ]);

                   DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->update(['tl_cart_status' => 'PLACED']);

                     //   DB::commit();

                         //////////////// email send ///////////////////////////
                        // $to = array();
                         $to_merchant = array();
                         $sender_detail = array();
                         $reciever_detail = array();
 
                       //  $to = array($guest_email,$recipient_email);
                         $to = $guest_email;

                         $sender_detail = array('guest_name'=>$guest_name,'guest_email'=>$guest_email,'guest_mobile'=>$guest_mobile,'guest_address'=>$guest_address);
                     

                         $reciever_detail = array('recipient_name'=>$recipient_name,'recipient_email'=>$recipient_email,'recipient_mobile'=>$recipient_mobile,'recipient_address'=>$recipient_address);
 
                        $merchantid = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select('store_merchant_id','store_name','tl_product_name','tl_product_image1','tl_product_price')->get();
 
                       $occasion = DB::table('tbl_tl_card')->where('cart_uniqueid',$cart_id)->select('card_occasion')->get();

                       $occasion_select = $occasion[0]->card_occasion;

                       $merchantid2 = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select('store_merchant_id')->distinct('store_merchant_id')->get();
                       
                        foreach($merchantid2 AS $value){
                            $dataemail =  DB::table('users')->where('userid',              $value->store_merchant_id)->select('email')->get();
                            $to_merchant = $dataemail[0]->email;

                            $mercant_product = DB::table('tbl_tl_user_cart')
                                    ->where('cart_uniqueid',$cart_id)
                                    ->where('store_merchant_id',$value->store_merchant_id)
                                    ->select('store_merchant_id','store_name','tl_product_name','tl_product_image1','tl_product_price')->get();

                            $res_email_merchant = $this->ordergenhitmerchant($to_merchant,$order_ref,$mercant_product,$sender_detail,$reciever_detail,$curDate,$occasion_select);

                          
                        }

                        
 
                       

                        $result = $this->ordergeneratehitemail($to,$order_ref,$merchantid,$sender_detail,$curDate,$occasion_select);
                       
                     // all good
                    return redirect('/thankyou'.'/'.$cart_id);
                        
                          return redirect('/thankyou'.'/'.$cart_id);
                    //    } catch (\Exception $e) {
                    //        DB::rollback();
                    //        echo "Something went wrong, Please try again later.";
                    //    }
    
                }
                else
                {
                    echo $charge;
                } 

              
         }
     }

     public function store_payment(Request $request){
        if($request->isMethod('POST')){
          
           $curDate = new \DateTime();
           $ip_address =  \Request::ip();

           $total_price = $request->formdata_total_price;
           $recipient_name = '';
           $recipient_mobile = '';
           $recipient_email = '';
           $recipient_address = '';
           $recipient_city = '';
           $recipient_country    = '';
           $recipient_postcode = '';
           $cart_id = $request->cart_id;
           $user_type = $request->formdata_user_type;
           $paytoken = $request->stripeToken;

           $orderdetail = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select                    ('store_id','store_merchant_id','tl_product_id')->get();

           $merchantuserid = '';
           $store_id = '';
           $producttype1 = array();
            foreach($orderdetail AS $val){
               $merchantuserid .= $val->store_merchant_id.',';
               $store_id .= $val->store_id.',';

               $producttype = DB::table('tbl_tl_product')->where('tl_product_id',$val->tl_product_id)->where('tl_product_type','Voucher')->select('tl_product_id')->get();

               $producttype = json_decode(json_encode($producttype), True);
               if(count($producttype)>0){
                array_push($producttype1,$producttype[0]['tl_product_id']);
               }
            }

           
            if(count($producttype1)>0)
            {
               $restprice = 0;
               foreach($producttype1 AS $producttype1_val){
                   $reedeemprice = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',     $cart_id)->where('tl_product_id',$producttype1_val)->select('tl_product_price')->get(); 
    
                   $restprice = $restprice + $reedeemprice[0]->tl_product_price;
                 }
            }
            else
            {
               $restprice = '';
            }

           $session_all=Session::get('sessionuser');
           if($session_all==true){
               $userid = $session_all['userid']; 
               $register_user_data = DB::table('users')
                                       ->join('tbl_tl_user_detail','users.userid','tbl_tl_user_detail.tl_userdetail_userid')
                                       ->where('userid',$userid)
                                       ->select('name','email','tbl_tl_user_detail.tl_userdetail_phoneno','tbl_tl_user_detail.tl_userdetail_address')->get();
                if($register_user_data[0]->name!=''){
                   $guest_name = $register_user_data[0]->name;
                }else{
                   $guest_name = '';
                }

                if($register_user_data[0]->tl_userdetail_phoneno!=''){
                   $guest_mobile = $register_user_data[0]->tl_userdetail_phoneno;
                }else{
                   $guest_mobile ='';
                }

                if($register_user_data[0]->email!=''){
                   $guest_email = $register_user_data[0]->email;
                }else{
                   $guest_email = '';
                }

                if($register_user_data[0]->tl_userdetail_address!=''){
                   $guest_address = $register_user_data[0]->tl_userdetail_address;
                }else{
                   $guest_address = '';
                }

               $guest_city = '';
               $guest_country = '';
               $guest_postcode ='';

           }else{
               $userid = date('Ymdhis'); 
               $guest_name = $request->formdata_guest_name;
               $guest_mobile = $request->formdata_guest_mobile;
               $guest_email = $request->formdata_guest_email;
               $guest_address = $request->formdata_guest_address; 
               $guest_city = $request->formdata_guest_city;
               $guest_country = $request->formdata_guest_country;
               $guest_postcode = $request->formdata_guest_postcode;
           }
          
            function generateorderref() {
                   $number = mt_rand(100000, 999999); 
               
                
                   if (generateorderrefExists($number)) {
                       return generateorderref();
                   }
               
                  
                   return $number;
               }
               
               function generateorderrefExists($number) {
                  
                   return DB::table('tbl_tl_order')->where('tl_order_ref',$number)->exists();
               }
                $order_ref = '#'.generateorderref(); 
                $orderid = $userid.'_'.$order_ref;

               $amount = "2";

               $charge = chargeuser($paytoken,$amount,$orderid);
               if(isset($charge['chargeid'])  && $charge['chargeid']!=''  && isset($charge['transactionid']) && $charge['transactionid']!='' )
               {
                        DB::beginTransaction();
                        try {
                   DB::table('tbl_tl_treatuser')
                   ->insert([
                       'userid'=> $userid,
                       'cart_uniqueid'=> $cart_id,
                       'tl_tuser_fullname'=> $guest_name,
                       'tl_tuser_mobile'=> $guest_mobile,
                       'tl_tuser_email'=> $guest_email, 
                       'tl_tuser_address'=> $guest_address,
                       'tl_tuser_city'=> $guest_city,
                       'tl_tuser_country'=> $guest_country,
                       'tl_tuser_postcode'=> $guest_postcode,
                       'tl_tuser_type'=> $user_type,
                       'tl_tuser_ip'=>$ip_address ,
                      'tl_tuser_created_at'=> $curDate ,
                      'tl_tuser_updated_at'=> $curDate
                   ]);
                  
                  
                   $data = DB::table('tbl_tl_order')  
                   ->insert([
                      'cart_uniqueid'=> $cart_id,
                      'userid'=> $userid,
                      'tl_order_ref'=> $orderid,
                      'store_id'=>  rtrim($store_id,','),
                      'store_merchant_id'=> rtrim($merchantuserid,','),
                      'tl_cart_subtotal'=> $total_price,
                      'tl_recipient_name'=> $recipient_name ,
                      'tl_recipient_mobile'=> $recipient_mobile,
                      'tl_recipient_email'=>$recipient_email ,
                      'tl_recipient_address'=>$recipient_address ,
                      'tl_recipient_city'=> $recipient_city ,
                      'tl_recipient_country'=> $recipient_country,
                      'tl_recipient_postcode'=> $recipient_postcode,
                      'tl_order_chargeid'=> $charge['chargeid'],
                      'tl_order_transactionid'=> $charge['transactionid'],
                      'tl_order_paymode'=> 'CARD',
                      'tl_order_paystatus'=>'YES',
                      'tl_order_status'=>'PLACED',   
                      'tl_order_partial_reedeem'=> $restprice,
                      'tl_thankyou_status'=>'1',
                      'tl_order_userip'=>$ip_address ,
                      'tl_order_created_at'=> $curDate ,   
                      'tl_order_updated_at'=> $curDate
                  ]);

                  DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->update(['tl_cart_status' => 'PLACED','tl_order_ref'=>$orderid]);

                  $insert_vouchernum = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select('cart_id')->get();
                  
                  function generatevoucherref() {
                    $number1 = mt_rand(100000, 999999); 
                
                
                    if (generatevoucherrefExists($number1)) {
                        return generatevoucherref();
                    }
                
                
                    return $number1;
                }
                
                function generatevoucherrefExists($number1) {
                
                    return DB::table('tbl_tl_user_cart')->where('tl_cart_voucher',$number1)->exists();
                }

                  foreach($insert_vouchernum AS $insert_vouchernum_val)
                  {
                        $voucher_ref = '#'.generatevoucherref(); 
                        $voucherid = date('Ymdhis').'_'.$voucher_ref;
                        
                        DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->where('cart_id',$insert_vouchernum_val->cart_id)->update(['tl_cart_voucher' => $voucherid]);
                  }

                       DB::commit();

                        //////////////// email send ///////////////////////////
                     
                        $to_merchant = array();
                        $sender_detail = array();
                      
                        $to = $guest_email;

                        $treatcard_cost1 = DB::table('tbl_postage_packaging')->where('id','1')->select('postage_packaging_cost')->get();
                        $treatcard_cost = $treatcard_cost1[0]->postage_packaging_cost;

                        $sender_detail = array('guest_name'=>$guest_name,'guest_email'=>$guest_email,'guest_mobile'=>$guest_mobile,'guest_address'=>$guest_address);
                    

                       

                       $merchantid = DB::table('tbl_tl_user_cart')
                                    ->where('cart_uniqueid',$cart_id)
                                    ->select('tl_product_id','store_merchant_id','store_name','tl_product_name','tl_product_image1','tl_product_price','tl_cart_voucher','cart_id')->get();

                      $occasion = DB::table('tbl_tl_card')->where('cart_uniqueid',$cart_id)->select('card_occasion')->get();

                      $occasion_select = $occasion[0]->card_occasion;

                      $merchantid2 = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)->select('store_merchant_id')->distinct('store_merchant_id')->get();
                      
                       foreach($merchantid2 AS $value){
                           $dataemail =  DB::table('users')->where('userid',              $value->store_merchant_id)->select('email')->get();
                           $to_merchant = $dataemail[0]->email;

                           $mercant_product = DB::table('tbl_tl_user_cart')
                                   ->where('cart_uniqueid',$cart_id)
                                   ->where('store_merchant_id',$value->store_merchant_id)
                                   ->select('tl_product_id','store_merchant_id','store_name','tl_product_name','tl_product_image1','tl_product_price','tl_cart_voucher','cart_id')->get();

                           $res_email_merchant = $this->ordergenhitmerchant($to_merchant,$order_ref,$mercant_product,$sender_detail,$curDate->format("Y-m-d"),$occasion_select,$cart_id,$treatcard_cost);

                         
                       }

                       

                      

                       $result = $this->ordergeneratehitemail($to,$order_ref,$merchantid,$sender_detail,$curDate->format("Y-m-d"),$occasion_select,$cart_id,$treatcard_cost);
                      
                  
                         return redirect('/thankyou'.'/'.$cart_id);
                       
                      
                } catch (\Exception $e) {
                    DB::rollback();
                    echo "Something went wrong, Please try again later.";
                }
   
               }
               else
               {
                   echo $charge;
               } 

             
        }
    }


        public function thankyou($cart_id=null){
             session_destroy();
            
            if($cart_id!=''){
               
                $thankyou_pagestatus = DB::table('tbl_tl_order')->where('cart_uniqueid',$cart_id)
                ->select('tl_thankyou_status')->get();

                $check_thankyou_pagestatus = $thankyou_pagestatus[0]->tl_thankyou_status; 

                if($check_thankyou_pagestatus=='1'){
                    $order_detail_data = DB::table('tbl_tl_order')->where('cart_uniqueid',$cart_id)

                    ->select('tl_order_ref','tl_order_created_at','tl_recipient_name','tl_recipient_mobile','tl_recipient_email','tl_recipient_address','tl_cart_subtotal')->get();
                
                    $user_data = DB::table('tbl_tl_treatuser')->where('cart_uniqueid',$cart_id)
                    ->select('tl_tuser_fullname','tl_tuser_mobile','tl_tuser_email','tl_tuser_address')->get();
                    
                    $product = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_id)
                    ->select('tl_product_name','tl_product_image1','tl_product_description','tl_product_price')->get();

                     $card_details = DB::table('tbl_tl_card')->where('cart_uniqueid',$cart_id)->select('template_id','card_recipient_name','card_occasion','card_message','card_sender_name','card_sender_name1')->get();

                       $thankyou_con = DB::table('tbl_tl_thankyou')->select('tl_thankyou_content','email')->where('tl_thankyou_id','1')->get();

                    DB::table('tbl_tl_order')->where('cart_uniqueid',$cart_id)->update(['tl_thankyou_status' => '0']);

                    return view('frontend.thankyou',compact('order_detail_data','user_data','product','card_details','thankyou_con'));
                }
                else if($check_thankyou_pagestatus=='0'){
                    return redirect('/');
                }
               

            }
        }       


  
        public function testpay()
    {
         return view('frontend.testpay');
    }

    public function makecharge(Request $request)
    {
        if($request->isMethod('POST')){
        $paytoken = $request->stripeToken;
        $sweta = $request->sweta; 
        $amount = "2";
        $charge = chargeuser($paytoken,$amount,$orderid);
        }else{
        return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request'
            ]);
        }
    }

    public function review_treat($productid=null){
         if($productid!=''){
            
            $product_detail = DB::table('tbl_tl_product')->where('tl_product_id',$productid)
            ->select('tl_product_id','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
            'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status')
             ->get();
            
            $tl_product_id = $product_detail[0]->tl_product_id;
            $tl_product_name = $product_detail[0]->tl_product_name;
            $tl_product_image1 = $product_detail[0]->tl_product_image1;
            $tl_product_description = $product_detail[0]->tl_product_description;
            $tl_product_price = $product_detail[0]->tl_product_price;
            $userid = $product_detail[0]->userid;

            $datastorename = DB::table('tbl_tl_addstore')->where('userid',$userid)->select                           ('tl_addstore_id','tl_addstore_name')->get();

            $storename = $datastorename[0]->tl_addstore_name;
            $tl_addstore_id = $datastorename[0]->tl_addstore_id;

           if(!empty($_SESSION["shopping_cart"])){  
             $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
             if(!in_array($productid, $item_array_id))
                    {
                      
                        $count = count($_SESSION["shopping_cart"]);
                        $item_array = array(
                            'item_id'           =>  $productid,
                            'item_name'         =>  $tl_product_name,
                            'item_price'        =>  $tl_product_price,
                            'item_image'        =>  $tl_product_image1,
                            'item_description'      =>  $tl_product_description,
                            'item_storeid'    =>  $tl_addstore_id,
                            'item_storemerchant_id'   =>  $userid,
                            'item_storename'        =>  $storename
                        );
                        $_SESSION["shopping_cart"][$count] = $item_array;
                       
                        return view('frontend.review_treat');

                    }else{
                        
                        return view('frontend.review_treat');
                    }
           }
           else
                {
                   
                    $item_array = array(
                        'item_id'           =>  $productid,
                        'item_name'         =>  $tl_product_name,
                        'item_price'        =>  $tl_product_price,
                        'item_image'        =>  $tl_product_image1,
                        'item_description'      =>  $tl_product_description,
                        'item_storeid'    =>  $tl_addstore_id,
                        'item_storemerchant_id'   =>  $userid,
                        'item_storename'        =>  $storename
                    );
                    
                    $_SESSION["shopping_cart"][0] = $item_array;
                  
                   
                     return view('frontend.review_treat');
                }
        }else{
            return view('frontend.review_treat');
        }
        
    }

    public function addaddress(Request $request){
        if($request->isMethod('POST'))
        {
            $productid = $request->productid;
            if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"]))
            {
            $unique_id = $_SESSION["cartuniqueid"];
            }
            else
            {
            $unique_id = date('Ymdhis').'_'.uniqid();
            $_SESSION["cartuniqueid"] = $unique_id;
            }
            $isanyotheraddr = DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$unique_id)->groupBy('tl_recipient_name','tl_recipient_address','tl_recipient_address2','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();

            // query for uopdate address or add
            $sql_updateaddr = DB::table('tbl_order_recipient_address')->select('tl_recipient_name','tl_recipient_address','tl_recipient_address2','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid)->get();

            if(count($sql_updateaddr)>0)
            {
                $tl_recipient_name = $sql_updateaddr[0]->tl_recipient_name;
                $tl_recipient_address = $sql_updateaddr[0]->tl_recipient_address;
                $tl_recipient_address2 = $sql_updateaddr[0]->tl_recipient_address2;
                $tl_recipient_city = $sql_updateaddr[0]->tl_recipient_city;
                $tl_recipient_country = $sql_updateaddr[0]->tl_recipient_country;
                $tl_recipient_postcode = $sql_updateaddr[0]->tl_recipient_postcode;
                $buttontext = 'Update';
            }
            else
            {
                $tl_recipient_name = '';
                $tl_recipient_address = '';
                $tl_recipient_address2 = '';
                $tl_recipient_city = '';
                $tl_recipient_country = '';
                $tl_recipient_postcode = '';
                $buttontext = 'Submit';
            }
           
           $form = ' <form>
           <input type="hidden" id="productid" name="productid" class="form-control" value="'.$productid.'">
           <div class="row">
             <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">Full Name*</label>
                   <label for="">
                     <input type="text" id="recipient_name" name="recipient_name" onkeypress="return isChar(event)" class="form-control" value="'.$tl_recipient_name.'" placeholder="Full Name">
                   </label>
                 </div>
               </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">Address 1*</label>
                   <label for="">
                     <input type="text" id="recipient_address" onkeypress="return isChar1(event)" name="recipient_address" class="form-control" value="'.$tl_recipient_address.'" placeholder="Address 1">
                   </label>
                 </div>
               </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">Address 2</label>
                   <label for="">
                     <input type="text" id="recipient_address2" onkeypress="return isChar1(event)" name="recipient_address2" class="form-control" value="'.$tl_recipient_address2.'" placeholder="Address 2">
                   </label>
                 </div>
               </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">City*</label>
                   <label for="">
                     <input type="text" onkeypress="return isChar1(event)" id="recipient_city" name="recipient_city" class="form-control" value="'.$tl_recipient_city.'" placeholder="City">
                   </label>
                 </div>
               </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">County*</label>
                   <label for="">
                     <input type="text" onkeypress="return isChar1(event)" id="recipient_country" name="recipient_country" class="form-control" value="'.$tl_recipient_country.'" placeholder="County">
                   </label>
                 </div>
               </div>
               <div class="col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                   <label for="">Postcode*</label>
                   <label for="">
                     <input type="text" onkeypress="return isChar1(event)" id="recipient_postcode" name="recipient_postcode" maxlength="10" value="'.$tl_recipient_postcode.'" class="form-control" placeholder="Postcode">
                   </label>
                 </div>
               </div>

               <div class="col-sm-12 col-md-12 col-xs-12">
                 <div class="form-group">
                 <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                 <div class="overlay" style="position: relative !important;display:none;">
                              <i class="fa fa-refresh fa-spin"></i>
                            </div>
                   <label for="" >
                   <button onclick="return recipient_form();" id="button_addaddr" class="tl-tabform-btn hvr-sweep-to-right">'.$buttontext.'</button>	
                   </label>
                 </div>	
               </div>
            
             
           </div>
         </form>';
         
         if(count($sql_updateaddr) > 0 && count($isanyotheraddr) > 1){
            $form .='<button  onclick="useanotheraddress('.$productid.',\''.$unique_id.'\',\''.$tl_recipient_name.'\',\''.$tl_recipient_address.'\',\''.$tl_recipient_city.'\',\''.$tl_recipient_country.'\',\''.$tl_recipient_postcode.'\',\''.$tl_recipient_address2.'\')" class="tl-tabform-btn hvr-sweep-to-right">Use Another Address</button>';
         }
        
         return response()->json(
            [
            'status' =>'200',
            'msg' => $form
            ]);
        }
        else
        {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request'
            ]);
         }
    }
    

    public function addrecipient_address(Request $request)
    {
        if($request->isMethod('POST'))
        {
          
           $dt = new \DateTime();
           $ip_address =  \Request::ip();  

           $productid = $request->productid;
           $recipient_name = $request->recipient_name;
           $recipient_address = $request->recipient_address;
           $recipient_address2 = $request->recipient_address2;
           $recipient_city = $request->recipient_city;
           $recipient_country = $request->recipient_country;
           $recipient_postcode = $request->recipient_postcode;

           if($recipient_name!='' && $recipient_address!='')
           {
             if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"]))
             {
             $unique_id = $_SESSION["cartuniqueid"];
             }
             else
             {
             $unique_id = date('Ymdhis').'_'.uniqid();
             $_SESSION["cartuniqueid"] = $unique_id;
             }

             $session_all=Session::get('sessionuser');
             if($session_all!=false)
             {
               $userid = $session_all['userid']; 
             }else
             {
              $userid = ''; 
             }

             /// query for update or insert order recepient address
             $sql_insert_update = DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid)->get();
             
             if(count($sql_insert_update)>0)
             {
                try {
               
                    $sql = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid)->update([
                        'userid' =>  $userid,
                        'tl_recipient_name' =>  $recipient_name,
                        'tl_recipient_address' =>  $recipient_address,
                        'tl_recipient_address2' =>  $recipient_address2,
                        'tl_recipient_city' =>  $recipient_city,
                        'tl_recipient_country' =>  $recipient_country,
                        'tl_recipient_postcode' =>  $recipient_postcode,
                        'tl_userip' =>  $ip_address,
                        'tl_updated_at' =>  $dt
                      ]); 
                        return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Updated successfully'
                        ]);
                     } 
                     catch (\Exception $e)
                      {
                        return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong, Please try again later'
                        ]);
                      }
             }
             else
             {
                 /// query for card id
                $sql_forcartid = DB::table('tbl_tl_card')->select('cart_id','card_id')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid)->get();

                if(count($sql_forcartid)>0)
                {
                    $cart_id = $sql_forcartid[0]->cart_id;
                    $card_id = $sql_forcartid[0]->card_id;
                }
                else
                {
                    $cart_id = '';
                    $card_id = '';
                }  
                /// end query for card id

                $sql = DB::table('tbl_order_recipient_address')->insert([
                    'cart_uniqueid' =>  $unique_id,
                    'tl_product_id' => $productid ,
                    'card_id' =>  $card_id,
                    'cart_id' =>  $cart_id,
                    'userid' =>  $userid,
                    'tl_recipient_name' =>  $recipient_name,
                    'tl_recipient_address' =>  $recipient_address,
                    'tl_recipient_address2' =>  $recipient_address2,
                    'tl_recipient_city' =>  $recipient_city,
                    'tl_recipient_country' =>  $recipient_country,
                    'tl_recipient_postcode' =>  $recipient_postcode,
                    'tl_userip' =>  $ip_address,
                    'tl_created_at' =>  $dt,
                    'tl_updated_at' =>  $dt
                  ]);
                    if($sql==true)
                    {
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
                            'msg' => 'Something went wrong, please try again later.'
                            ]);
                    }
             }
             /// end  query for update or insert order recepient address
           }
           else
           {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All field are required.'
                    ]); 
           }
        }
        else
        {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request'
            ]);
        }
    }

    public function addrecipient_useaddress(Request $request)
    {
        if($request->isMethod('POST'))
        {
         
           $dt = new \DateTime();
           $ip_address =  \Request::ip();  

           $addr_id = $request->addr_id;
           $productid1 = $request->productid1; 
           if($addr_id!='')
           {
             if(isset($_SESSION["cartuniqueid"]) && !empty($_SESSION["cartuniqueid"]))
             {
             $unique_id = $_SESSION["cartuniqueid"];
             }
             else
             {
             $unique_id = date('Ymdhis').'_'.uniqid();
             $_SESSION["cartuniqueid"] = $unique_id;
             }

             $session_all=Session::get('sessionuser');
             if($session_all!=false)
             {
               $userid = $session_all['userid']; 
             }else
             {
              $userid = ''; 
             }

             /// query for update or insert order recepient address
             $sql_insert_update = DB::table('tbl_order_recipient_address')->select('id')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid1)->get();

             $recpdetail_addrid = DB::table('tbl_order_recipient_address')->where('id',$addr_id)->select('tl_recipient_name','tl_recipient_address','tl_recipient_address2','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();
            
           
             if(count($sql_insert_update)>0)
             {   
                try {
               
                    $sql = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid1)->update([
                        'userid' =>  $userid,
                        'tl_recipient_name' =>  $recpdetail_addrid[0]->tl_recipient_name,
                        'tl_recipient_address' =>  $recpdetail_addrid[0]->tl_recipient_address,
                        'tl_recipient_address2' =>  $recpdetail_addrid[0]->tl_recipient_address2,
                        'tl_recipient_city' =>  $recpdetail_addrid[0]->tl_recipient_city,
                        'tl_recipient_country' =>  $recpdetail_addrid[0]->tl_recipient_country,
                        'tl_recipient_postcode' =>  $recpdetail_addrid[0]->tl_recipient_postcode,
                        'tl_userip' =>  $ip_address,
                        'tl_updated_at' =>  $dt
                      ]); 
                        return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Updated successfully'
                        ]);
                     } 
                     catch (\Exception $e)
                      {
                        return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong, Please try again later'
                        ]);
                      }
             }
             else
             {
                 /// query for card id
                $sql_forcartid = DB::table('tbl_tl_card')->select('cart_id','card_id')->where('cart_uniqueid',$unique_id)->where('tl_product_id',$productid1)->get();

                if(count($sql_forcartid)>0)
                {
                    $cart_id = $sql_forcartid[0]->cart_id;
                    $card_id = $sql_forcartid[0]->card_id;
                }
                else
                {
                    $cart_id = '';
                    $card_id = '';
                }  
                /// end query for card id

                $sql = DB::table('tbl_order_recipient_address')->insert([
                    'cart_uniqueid' =>  $unique_id,
                    'tl_product_id' => $productid1 ,
                    'card_id' =>  $card_id,
                    'cart_id' =>  $cart_id,
                    'userid' =>  $userid,
                    'tl_recipient_name' =>  $recpdetail_addrid[0]->tl_recipient_name,
                    'tl_recipient_address' =>  $recpdetail_addrid[0]->tl_recipient_address,
                     'tl_recipient_address2' =>  $recpdetail_addrid[0]->tl_recipient_address2,
                    'tl_recipient_city' =>  $recpdetail_addrid[0]->tl_recipient_city,
                    'tl_recipient_country' =>  $recpdetail_addrid[0]->tl_recipient_country,
                    'tl_recipient_postcode' =>  $recpdetail_addrid[0]->tl_recipient_postcode,
                    'tl_userip' =>  $ip_address,
                    'tl_created_at' =>  $dt,
                    'tl_updated_at' =>  $dt
                  ]);
                    if($sql==true)
                    {
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
                            'msg' => 'Something went wrong, please try again later.'
                            ]);
                    }
             }
             /// end  query for update or insert order recepient address
           }
           else
           {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All field are required.'
                    ]); 
           }
        }
        else
        {
            return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request'
            ]);
        }
    }
   
    public function deletecart_card_item(Request $request)
    {
        if($request->isMethod('POST')){
          $productid = $request->productid;
          $cartuniqueid = $request->cartuniqueid;
          if($productid!='' && $cartuniqueid!='')
          {
              //delete recepient address item
            $sql_delrecp_addr = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$productid)->select('id')->get();

            if(count($sql_delrecp_addr)>0){ 
                $sql1 = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$productid)->delete();
            }

            $is_treat_personalise = DB::table('tbl_tl_card')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$productid)->select('card_id')->get();

            if(count($is_treat_personalise)>0)
            {  
                $sql2 = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$productid)->delete();

                $sql3 = DB::table('tbl_tl_card')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$productid)->delete();

            }
            return response()->json([
                'status' =>'200',
                'msg' => 'Deleted Successfully.'
            ]);
          }
          else
          {
            return response()->json([
                'status' =>'401',
                'msg' => 'Somethinh went wrong, please try again later.'
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

    public function chkcartitem_ispersonalise(Request $request)
    {
        if($request->isMethod('POST')){
          $unique_cartid =  $request->unique_cartid; 
            if(isset($_SESSION["shopping_cart"]) && !empty($_SESSION["shopping_cart"]))
            {
               $count_sessionitem = count($_SESSION["shopping_cart"]);
               $chk_cart = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$unique_cartid)->select('cart_id')->get();
               if(count($chk_cart)==$count_sessionitem)
               {   
                $chk_card = DB::table('tbl_tl_card')->where('cart_uniqueid',$unique_cartid)->select('card_id')->get();  
                    if(count($chk_card)==$count_sessionitem)
                    {  
                        $chk_address = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$unique_cartid)->select('id')->get();
                        if(count($chk_address)==$count_sessionitem)
                        {
                            return response()->json([  
                                'status' =>'200',        
                                'cart_uniqueid' =>$unique_cartid,        
                                'msg' => 'Done'
                            ]); 
                        }
                        else
                        {
                            return response()->json([
                                'status' =>'401',
                                'cart_uniqueid' =>'',
                                'msg' => 'Please personalise and add address on each item in your cart.'
                            ]);  
                        }
                        

                    }
                    else
                    {
                        return response()->json([
                            'status' =>'401',
                            'cart_uniqueid' =>'',
                            'msg' => 'Please personalise and add address on each item in your cart.'
                        ]); 
                    }
               }
               else
               {
                return response()->json([
                    'status' =>'401',
                    'cart_uniqueid' =>'',
                    'msg' => 'Please personalise and add address on each item in your cart.'
                ]); 
               }
            }
            else
            {
                return response()->json([
                    'status' =>'401',
                    'cart_uniqueid' =>'',
                    'msg' => 'Add item in your cart.'
                ]); 
            }
            
        }
        else
        {
            return response()->json([
                'status' =>'401',
                'cart_uniqueid' =>'',
                'msg' => 'Invalid Request'
            ]);
        }  
    }

    public function useaddress(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $cartuniqueid = $request->cartuniqueid;
            $productid1 = $request->productid1;
            if($cartuniqueid!='')
            {
                $isaddress_present = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$cartuniqueid)->select('id','tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->groupBy( 'tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();

                if(count($isaddress_present)>0)
                {
                    $form = '<form>';
                    foreach($isaddress_present AS $value){
                        $form.='<input type="hidden" id="productid1" name="productid1" class="form-control" value="'.$productid1.'">
                       
                        <div class="col-sm-12 col-md-12 col-xs-12">
                             <div class="address-modal"> 
                             <label class="radio-modal">
                                    <input type="Radio" id="useaddr" name="useaddr"  class="form-control" value="'.$value->id.'" >
                                <span class="checkmark"></span>
                               </label> 
                               <div>
                              Address:- '.$value->tl_recipient_name.',</br>
                                        '.$value->tl_recipient_address.','.$value->tl_recipient_city.' - '.$value->tl_recipient_country.' ('.$value->tl_recipient_postcode.')
                              
                                
                            </div>
                           </div> 
                            </div>
                            ';
                    }
                    
                    $form.='<div class="col-sm-4 col-md-4 col-xs-12">
                              <div class="adress-modal-submit">
                              
                                <input type="Submit" id="button_useaddr1" onclick="return useaddr_form();" class="form-control" value="Submit">
                               </di> 
                        </div></div>
                <div class="clearfix"></div>
                        </form>';

                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => $form
                        ]);
                }
                
                
            }
            else
            {
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something went wrong, Please try again later.'
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


    public function useanotheraddress(Request $request)
    {
        if($request->isMethod('POST'))
        {
            $cartuniqueid = $request->cartuniqueid;
            $productid1 = $request->productid1;
            $tl_recipient_name = $request->tl_recipient_name;
            $tl_recipient_address = $request->tl_recipient_address;
            $tl_recipient_address2 = $request->tl_recipient_address2;
            $tl_recipient_city = $request->tl_recipient_city;
            $tl_recipient_country = $request->tl_recipient_country;
            $tl_recipient_postcode = $request->tl_recipient_postcode;
            if($cartuniqueid!='')
            {
            
                $rawQuery = "select `id`, `tl_recipient_name`, `tl_recipient_address`,`tl_recipient_address2` ,`tl_recipient_city`, `tl_recipient_country`, `tl_recipient_postcode` from `tbl_order_recipient_address` where `cart_uniqueid` = '$cartuniqueid' AND (`tl_recipient_name` NOT LIKE '$tl_recipient_name' OR `tl_recipient_address` NOT LIKE '$tl_recipient_address' OR `tl_recipient_address2` NOT LIKE '$tl_recipient_address2' OR `tl_recipient_city` NOT LIKE '$tl_recipient_city' OR `tl_recipient_country` NOT LIKE '$tl_recipient_country' OR `tl_recipient_postcode` NOT LIKE '$tl_recipient_postcode')  group by `tl_recipient_name`, `tl_recipient_address`, `tl_recipient_city`, `tl_recipient_country`, `tl_recipient_postcode`";
                $isaddress_present = DB::select($rawQuery);

                // $isaddress_present = DB::table('tbl_order_recipient_addres')
                // ->where('tl_recipient_name','NOT LIKE',$tl_recipient_name)
                // ->where('tl_recipient_address','NOT LIKE',$tl_recipient_address)
                // ->where('tl_recipient_city','NOT LIKE',$tl_recipient_city)
                // ->where('tl_recipient_country','NOT LIKE',$tl_recipient_country)
                // ->where('tl_recipient_postcode','NOT LIKE',$tl_recipient_postcode)
                // ->where('cart_uniqueid',$cartuniqueid)->select('id','tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->groupBy('tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();

                if(count($isaddress_present)>0)
                {
                    $form = '<form>';
                    foreach($isaddress_present AS $value){
                        $form.='<input type="hidden" id="productid1" name="productid1" class="form-control" value="'.$productid1.'">
                       
                        <div class="col-sm-12 col-md-12 col-xs-12">
                             <div class="address-modal"> 
                             <label class="radio-modal">
                                    <input type="Radio" id="useaddr" name="useaddr"  class="form-control" value="'.$value->id.'" >
                                <span class="checkmark"></span>
                               </label> 
                               <div>
                              Address:- '.$value->tl_recipient_name.',</br>
                                        '.$value->tl_recipient_address.',
                                        '.$value->tl_recipient_address2.',
                                        '.$value->tl_recipient_city.' - '.$value->tl_recipient_country.' ('.$value->tl_recipient_postcode.')
                              
                                
                            </div>
                           </div> 
                            </div>
                            ';
                    }
                    
                    $form.='<div class="col-sm-4 col-md-4 col-xs-12">
                              <div class="adress-modal-submit">
                               <div id="errormsg" style="font-size: 15px;text-align: center;"></div>
                           <div class="overlay" style="position: relative !important;display:none;">
                              <i class="fa fa-refresh fa-spin"></i>
                            </div>
                                <input type="Submit" id="button_useaddr2" onclick="return useaddr_form();" class="form-control" value="Submit">
                               </di> 
                        </div></div>
                <div class="clearfix"></div>
                        </form>';

                    return response()->json(
                        [
                        'status' =>'200',
                        'msg' => $form
                        ]);
                }
                
                
            }
            else
            {
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something went wrong, Please try again later.'
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

  


}// end of class
