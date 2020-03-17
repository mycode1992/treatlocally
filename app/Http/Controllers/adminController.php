<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_tl_contactus;
use App\tbl_tl_aboutus;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\myconfiguration;
use Session;
use DB;
use DateTime;

class adminController extends Controller
{

    public function logout()
    {
       
        $objadminlogout = new myconfiguration();
        $session = 'sessionadmin';
        $user = $objadminlogout->logout($session);
        if($user == true){
           // return Redirect::to('/');
            return redirect('/tladminpanel');
            exit();
     
         }else if($user == false){
               echo 'something went wrong';
         }
       
    }


    public function get_dashboard(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

      $total_subscriber = DB::table('tbl_tl_subscribe')->get(['tl_subscribe_id']);
      $total_contact = DB::table('tbl_tl_contactuses')->get(['tl_contactus_id']);

      $total_merchant_active = DB::table('users')->where('role_id','2')->where('status','1')->get(['id']);

      $total_merchant_deactive = DB::table('users')->where('role_id','2')->where('status','0')->get(['id']);

      $total_user_active = DB::table('users')->where('role_id','3')->where('status','1')->get(['id']);

      $total_user_deactive = DB::table('users')->where('role_id','3')->where('status','0')->get(['id']);

      $total_product_active = DB::table('tbl_tl_product')->where('tl_product_status','1')->get(['tl_product_id']);

      $total_product_deactive = DB::table('tbl_tl_product')->where('tl_product_status','0')->get(['tl_product_id']);
      $total_order = DB::table('tbl_tl_order')->get(['tl_order_id']);
    // print_r($total_product_active); exit;
        return view('tl_admin.dashboard',compact('total_subscriber','total_contact','total_merchant_active','total_merchant_deactive','total_user_active','total_user_deactive','total_product_active','total_product_deactive','total_order'));
    }

    public function get_contact_detail(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $users = tbl_tl_contactus::orderBy('tl_contactus_id', 'desc')->get();
        return view('tl_admin.contact',compact('users'));
    }

    public function getcontactmsg(Request $request){
         $id =  $request->id;
        $msg = DB::table('tbl_tl_contactuses')->select('tl_contactus_message')->where('tl_contactus_id', $id)->get();
           return response()->json($msg);
    }

    public function get_about_us(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
         $data = DB::table('tbl_tl_aboutuses')->select('tl_aboutus_imagename', 'tl_aboutus_content')->where('id',1)->get();
        return view('tl_admin.about-us',compact('data'));
    }    

  
 public function addaboutus(Request $request){
        
        if($request->isMethod('POST'))
        {

            
            $curDate = new \DateTime();
            $aboutdesp = addslashes($request->aboutdesp);
            $aboutusimage = $request->file('aboutusimage');
            if($aboutusimage!="")
            {
                $extension = $aboutusimage->getClientOriginalExtension();
                $filesize  =  $aboutusimage->getClientSize();

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
                $dir = public_path().'/tl_admin/upload/aboutus/';
                $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
                $upload_image = $aboutusimage->move($dir, $filename);
                if($upload_image==false)
                {
                     return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload banner, please try again'
                        ]);
                }
            }
         
        }   // end if aboutusimage not blank
      
        if($aboutusimage!="")
            {
                $sql=DB::table('tbl_tl_aboutuses')
                    ->where('id', '=','1')
                    ->update([
                    'tl_aboutus_imagename'=>$filename,
                    'tl_aboutus_content'=>$aboutdesp,
                    'tl_contactus_updated_at'=>$curDate     
                ]);
            }else{
                $sql=DB::table('tbl_tl_aboutuses')
                ->where('id', '=','1')
                ->update([
                'tl_aboutus_content'=>$aboutdesp,
                'tl_contactus_updated_at'=>$curDate 
            ]);
            }

            if($sql==true)
            {
              return response()->json(
                [
                'status' =>'200',
                'msg' => 'About Us Updated Successfully!'
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

     public function get_privacy_policy(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $data = DB::table('tbl_tl_privacypolicies')->select('tl_privacypolicies_imagename', 'tl_privacypolicies_content')->where('tl_privacypolicies_id',1)->get();
       return view('tl_admin.privacy-policy',compact('data'));
   }

   public function updateprivacypolicy(Request $request){
        
    if($request->isMethod('POST'))
    {

        
        $curDate = new \DateTime();
        $ip_address =  \Request::ip(); 
        $privacydesp = addslashes($request->privacydesp);
        $privacypolicyimage = $request->file('privacypolicyimage');

        if($privacypolicyimage!="")
        {
            $extension = $privacypolicyimage->getClientOriginalExtension();
            $filesize  =  $privacypolicyimage->getClientSize();

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
            $dir = public_path().'/tl_admin/upload/privacy-policy/';
            $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
            $upload_image = $privacypolicyimage->move($dir, $filename);
            if($upload_image==false)
            {
                 return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Unable to upload image, please try again'
                    ]);
            }
        }
     
    }   // end if aboutusimage not blank
  
    if($privacypolicyimage!="")
        {
            $sql=DB::table('tbl_tl_privacypolicies')
                ->where('tl_privacypolicies_id', '=','1')
                ->update([
                'tl_privacypolicies_imagename'=>$filename,
                'tl_privacypolicies_content'=>$privacydesp,
                'tl_privacypolicies_ip'=>$ip_address,
                'tl_privacypolicies_updated_at'=>$curDate     
            ]);
        }else{
            $sql=DB::table('tbl_tl_privacypolicies')
            ->where('tl_privacypolicies_id', '=','1')
            ->update([
            'tl_privacypolicies_content'=>$privacydesp,
            'tl_privacypolicies_ip'=>$ip_address,
            'tl_privacypolicies_updated_at'=>$curDate 
        ]);
        }

        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
            'msg' => 'Privacy Policy Updated Successfully!'
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

}  // end privacy policy function

 // subscriber STart //

 public function get_websubscriber()
 {
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
     $data = DB::table('tbl_tl_subscribe')->orderBy('tl_subscribe_id', 'desc')->get();
     return view('tl_admin.websubscription',compact('data'));
 }

 public function websubsstatus(Request $request){
    $id=trim($request->id);
    $status=trim($request->status);
    $ip_address =  \Request::ip();

    $sql=DB::table('tbl_tl_subscribe')
                ->where('tl_subscribe_id', '=', $id)
                ->update([
                    'tl_subscribe_admin_status'=>$status,
                    'tl_subscribe_ip'=>$ip_address
                    ]);
    
    if($sql){
        return "yes";

    }else {
        return "no";

    }

}

  // get_terms_condition STart //

 public function get_terms_condition()
 {
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
     $data = DB::table('tbl_tl_terms_condition')->select('tl_terms_condition_imagename', 'tl_terms_condition_content')->where('tl_terms_condition_id',1)->get();
     return view('tl_admin.terms&condition',compact('data'));
 } // end get_terms_condition


// start of updatetermscondition function
 public function updatetermscondition(Request $request){
        
    if($request->isMethod('POST'))
    {

        
        $curDate = new \DateTime();

        $ip_address =  \Request::ip(); 
        
        $termsconditiondesp = addslashes($request->termsconditiondesp);
        $termsconditionimage = $request->file('termsconditionimage');

        if($termsconditionimage!="")
        {
            $extension = $termsconditionimage->getClientOriginalExtension();
            $filesize  =  $termsconditionimage->getClientSize();

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
            $dir = public_path().'/tl_admin/upload/terms-condition/';
            $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
            $upload_image = $termsconditionimage->move($dir, $filename);
            if($upload_image==false)
            {
                 return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Unable to upload image, please try again'
                    ]);
            }
        }   // end if aboutusimage not blank
     
if($termsconditionimage!="")
        {
            $sql=DB::table('tbl_tl_terms_condition')
                ->where('tl_terms_condition_id', '=','1')
                ->update([
                'tl_terms_condition_imagename'=>$filename,
                'tl_terms_condition_content'=>$termsconditiondesp,
                'tl_terms_condition_ip'=>$ip_address,
                'tl_terms_condition_updated_at'=>$curDate     
            ]);
              
        }else{
            $sql=DB::table('tbl_tl_terms_condition')
            ->where('tl_terms_condition_id', '=','1')
            ->update([
            'tl_terms_condition_content'=>$termsconditiondesp,
            'tl_terms_condition_ip'=>$ip_address,
            'tl_terms_condition_updated_at'=>$curDate 
        ]);
            
        }
       

        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
            'msg' => 'Terms&Condition Updated Successfully!'
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
  
    

}  // end updatetermscondition function

 
 // faqs start here  

    public function get_faqs(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $data = DB::table('tbl_tl_faq_category')->select('tl_faq_category_id','tl_faq_category_name','tl_faq_category_status')->get();
         return view('tl_admin.faqs',compact('data'));
    }

    public function faqsupdate(Request $request){
        $id=trim($request->id);
        $status=trim($request->status);
        $ip_address =  \Request::ip();

        $sql=DB::table('tbl_tl_faq_category')
                    ->where('tl_faq_category_id', '=', $id)
                    ->update([
                        'tl_faq_category_status'=>$status,
                        'tl_faq_category_ip'=>$ip_address
                        ]);
        
        if($sql){
            return "yes";

        }else {
            return "no";

        }

    }
    
   public function get_addfaqscat($id=null){
      
        if(!$id)
        {
            $data = [];
            return view("tl_admin.addfaqcat", compact('data'));
        }
        else
        {          
           
            $data = DB::table('tbl_tl_faq_category')->select('tl_faq_category_id','tl_faq_category_name')->where('tl_faq_category_id', '=', $id)->get();
            $data = json_decode(json_encode($data), True);
            return view('tl_admin.addfaqcat',compact('data'));     
        } 
   }

  public function store_addfaqscat(Request $request){
    if($request->isMethod('POST'))
    {
        
        $curDate = new \DateTime();
        $ip_address =  \Request::ip();
        $catname = ucfirst(trim($request->tl_faq_cat_name));
      $update_cat_id = $request->update_cat_id;  
        
    $query = DB::table('tbl_tl_faq_category')->where('tl_faq_category_name',$catname)->get(['tl_faq_category_id']);
    // print_r($query);exit;
    if(count($query) > 0){
        return response()->json([
            'status' => '401',
            'msg' => 'This category is already exist'
        ]);
     
        } else{
            if($update_cat_id == "0"){
                $sql = DB::table('tbl_tl_faq_category')->insert([
                    'tl_faq_category_name' =>  $catname ,
                    'tl_faq_category_ip' =>  $ip_address ,
                    'tl_faq_category_created_at' =>  $curDate ,
                    'tl_faq_category_updated_at' =>  $curDate 
                ]); 
    
                if($sql==true)
                        {
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Category added successfully!'
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
                if($update_cat_id != "0"){

                    $sql=DB::table('tbl_tl_faq_category')
                        ->where('tl_faq_category_id', '=', $update_cat_id)
                        ->update([
                            'tl_faq_category_name' => $catname,
                            'tl_faq_category_ip' => $ip_address,
                            'tl_faq_category_created_at' => $curDate,
                            'tl_faq_category_updated_at' => $curDate
                        ]); 
                    if($sql==true)
                    {
                      return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Faq category updated successfully!'
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
} ////////////////////////

 public function get_addfaqs($id=null){
        if(!$id)
            {
                $data['result'] = [];
                $data['catogories'] = DB::table('tbl_tl_faq_category')->select('tl_faq_category_id','tl_faq_category_name')->get();
            return view('tl_admin.addfaq',compact('data'));
            }
            else
            {          
              
              //  $data = DB::table('tbl_tl_faq_category_detail')->where('tl_faq_category_detail_id', '=', $id)->get(['tl_faq_category_detail_catid']);
              //  $data = json_decode(json_encode($data), True);
              //  $cat_id = $data[0]['tl_faq_category_detail_catid']; exit;
              $data['result'] = DB::table('tbl_tl_faq_category_detail')
                             ->join('tbl_tl_faq_category','tbl_tl_faq_category.tl_faq_category_id','tbl_tl_faq_category_detail.tl_faq_category_detail_catid')
                             ->select('tbl_tl_faq_category.tl_faq_category_id','tbl_tl_faq_category.tl_faq_category_name','tbl_tl_faq_category_detail.tl_faq_category_detail_title','tbl_tl_faq_category_detail.tl_faq_category_detail_description','tbl_tl_faq_category_detail.tl_faq_category_detail_id')
                             ->where('tl_faq_category_detail_id',$id)->get();
                             $data['catogories'] = DB::table('tbl_tl_faq_category')->select('tl_faq_category_id','tl_faq_category_name')->get();
              $data['result'] = json_decode(json_encode($data['result']), True);
            // print_r($data['result']); exit;
           // echo $data['result'][0]['tl_faq_category_id']; exit;
               return view('tl_admin.addfaq',compact('data'));     
            }
        }

        public function store_addfaqs(Request $request){
            
            if($request->isMethod('POST'))
        {
           
            $curDate = new \DateTime();
            $ip_address =  \Request::ip();
            $cat_id = $request->tl_faq_q_catid;
            $faq_title = ucfirst(trim($request->tl_faq_title));
            $faq_desp = addslashes($request->tl_faq_desp);
            $tl_faq_cat_detail_id = $request->tl_faq_cat_detail_id;  
            
            $query = DB::table('tbl_tl_faq_category_detail')->where('tl_faq_category_detail_title',$faq_title)->get(['tl_faq_category_detail_id']);
              if(count($query) > 0){
                return response()->json([
                    'status' => '401',
                    'msg' => 'This category title  already exist'
                ]);
             
                } else{  
            
                 if($tl_faq_cat_detail_id == "0"){
                        $sql=DB::table('tbl_tl_faq_category_detail')->insert([
                            'tl_faq_category_detail_catid' => $cat_id,
                            'tl_faq_category_detail_title' => $faq_title,
                            'tl_faq_category_detail_description' => $faq_desp,
                            'tl_faq_category_detail_ip' => $ip_address,
                            'tl_faq_category_detail_created_at' => $curDate,
                            'tl_faq_category_detail_updated_at' => $curDate,
                        ]);      
                        if($sql==true)
                        {
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Faq added successfully!'
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
                if($tl_faq_cat_detail_id != "0"){

                    $sql=DB::table('tbl_tl_faq_category_detail')
                    ->where('tl_faq_category_detail_id', '=', $tl_faq_cat_detail_id)
                    ->update([
                        'tl_faq_category_detail_catid' => $cat_id,
                        'tl_faq_category_detail_title' => $faq_title,
                        'tl_faq_category_detail_description' => $faq_desp,
                        'tl_faq_category_detail_ip' => $ip_address,
                        'tl_faq_category_detail_created_at' => $curDate,
                        'tl_faq_category_detail_updated_at' => $curDate,
                    ]); 
                if($sql==true)
                {
                  return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Faq updated successfully!'
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
        }

         public function get_faqdetail($id){
        $data = DB::table('tbl_tl_faq_category_detail')->where('tl_faq_category_detail_catid', '=', $id)->get();
        return view("tl_admin.faqdetail",compact('data')); 
    }

    public function faqdetailupdate(Request $request){
        $id=trim($request->id);
        $status=trim($request->status);
        $ip_address =  \Request::ip();

        $sql=DB::table('tbl_tl_faq_category_detail')
                    ->where('tl_faq_category_detail_id', '=', $id)
                    ->update([
                        'tl_faq_category_detail_status'=>$status,
                        'tl_faq_category_detail_ip'=>$ip_address
                        ]);
        
        if($sql){
            return "yes";

        }else {
            return "no";

        }

    }


    // manage blog

    public function get_blog()
    {
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        return view('tl_admin.addblog');
    } 

    public function addblog(Request $request){
        if($request->isMethod('POST'))
        {
         
         
          $curDate = new \DateTime();
          $ip_address =  \Request::ip(); 

          $blogtitle =  $_POST['blogtitle'];
          $blogdetail = addslashes($request->blogdetail);
          $blogimage = $request->file('blogimage');

          if($blogimage!="")
          {
              $extension = $blogimage->getClientOriginalExtension();
              $filesize  =  $blogimage->getClientSize();
              $filename = $blogimage->getClientOriginalName();

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
              $dir = public_path().'/tl_admin/upload/blog/';
              $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
              $upload_image = $blogimage->move($dir, $filename);
              if($upload_image==false)
              {
                   return response()->json(
                      [
                      'status' =>'401',
                      'msg' => 'Unable to upload blog image, please try again'
                      ]);
              }
          }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Please select image'
                ]);
          }

            $sql = DB::table('tbl_tl_blog')->insert([
                'tl_blog_title' =>  $blogtitle ,
                'tl_blog_description' =>  $blogdetail , 
                'tl_blog_image' =>  $filename ,
                'tl_blog_addby' =>  'Admin' ,
                'tl_blog_ip' =>  $ip_address, 
                'tl_blog_created_at' =>  $curDate ,
                'tl_blog_updated_at' =>  $curDate,   
                'tl_blog_status' => '1'    

            ]); 
            if($sql==true)
            {
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'Blog added successfully!'
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

    public function get_banner(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
       
        $data = DB::table('tbl_tl_blogbanner')->where('tl_blogbanner_id',1)->select('tl_blogbanner_image','tl_blogbanner_title')->get();
        
      return view('tl_admin.blog_banner',compact('data'));

    }


    public function updateblogbanner(Request $request){
        if($request->isMethod('POST'))
        {
         
         
          $curDate = new \DateTime();
          $ip_address =  \Request::ip(); 
          $blogbannerimg = $request->file('blogbannerimg');
          $tl_blog_title = $request->tl_blog_title;

          if($blogbannerimg!="")
          {
              $extension = $blogbannerimg->getClientOriginalExtension();
              $filesize  =  $blogbannerimg->getClientSize();
              $filename = $blogbannerimg->getClientOriginalName();

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
              $dir = public_path().'/tl_admin/upload/blog_banner/';
              $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
              $upload_image = $blogbannerimg->move($dir, $filename);
              if($upload_image==false)
              {
                   return response()->json(
                      [
                      'status' =>'401',
                      'msg' => 'Unable to upload blog banner, please try again'
                      ]);
              }
          }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'Please select image'
                ]);
          }

             $sql=DB::table('tbl_tl_blogbanner')
             ->where('tl_blogbanner_id', '=','1')
             ->update([
             'tl_blogbanner_title'=>$tl_blog_title,
             'tl_blogbanner_image'=>$filename,
             'tl_blogbanner_ip'=>$ip_address,
             'tl_blogbanner_updated_at'=>$curDate     
             ]);
        

            if($sql==true)
            {
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'Blog banner updated successfully!'
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

    public function blogpage(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $data = DB::table('tbl_tl_blog')->select('tl_blog_status','tl_blog_id','tl_blog_title','tl_blog_description','tl_blog_image','tl_blog_addby','tl_blog_created_at')->orderBy('tl_blog_id','desc')->get();
      //  $data = json_decode(json_encode($data), true);
      return view('tl_admin.blogpage',compact('data'));

    }

    public function getblogdesc(Request $request){
        $id =  $request->id;
       $msg = DB::table('tbl_tl_blog')->select('tl_blog_description')->where('tl_blog_id', $id)->get();
    return response()->json($msg);
   }

   public function editblog($id=null){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
        $data = DB::table('tbl_tl_blog')->select('tl_blog_id','tl_blog_title','tl_blog_description','tl_blog_image')->where('tl_blog_id',$id)->get();
        $data = json_decode(json_encode($data), True);
        return view('tl_admin.editblog',compact('data'));
   }



   public function updateblog(Request $request){
   if($request->isMethod('POST'))
   {
    
     
     $curDate = new \DateTime();
     $ip_address =  \Request::ip(); 

     $blogtitle =  $_POST['blogtitle'];
     $blogdetail = addslashes($request->blogdetail);
     $blogimage = $request->file('blogimage'); 
     $updateid =  $_POST['updateid'];


     if($blogimage!="")
     {
         $extension = $blogimage->getClientOriginalExtension();
         $filesize  =  $blogimage->getClientSize();
         $filename = $blogimage->getClientOriginalName();

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
         $dir = public_path().'/tl_admin/upload/blog/';
         $filename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
         $upload_image = $blogimage->move($dir, $filename);
         if($upload_image==false)
         {
              return response()->json(
                 [
                 'status' =>'401',
                 'msg' => 'Unable to upload blog image, please try again'
                 ]);
         }

         $sql = DB::table('tbl_tl_blog')->where('tl_blog_id',$updateid)->update([
            'tl_blog_title' =>  $blogtitle ,
            'tl_blog_description' =>  $blogdetail , 
            'tl_blog_image' =>  $filename ,
            'tl_blog_updated_at' =>  $curDate 
        ]); 

        if($sql==true)
        {
        return response()->json(
            [
            'status' =>'200',
            'msg' => 'Blog updated successfully!'
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

        $sql = DB::table('tbl_tl_blog')->where('tl_blog_id',$updateid)->update([
            'tl_blog_title' =>  $blogtitle ,
            'tl_blog_description' =>  $blogdetail , 
            'tl_blog_updated_at' =>  $curDate 
        ]); 

        if($sql==true)
        {
        return response()->json(
            [
            'status' =>'200',
            'msg' => 'Blog updated successfully!'
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
 
}
    // end manage blog

    //    change status
    public function changestatus(Request $request){
        // if($request->isMethod('POST'))
        // {
         if($request->isMethod('POST')){
            $tblname = $request->tblname;
            $id =  $request->id;
            $status =  $request->status;
            $colname =  $request->colname;  
            $colstatus =  $request->colstatus;

           if($tblname=='tbl_tl_blog'){
             $blogid_exists = DB::table('tbl_tl_blogview')->where('tl_blogview_blogid',$id)->select('tl_blogview_blogid')->get();
                 if(count($blogid_exists)>0)
                 {
                    $sqltrending_count = "update tbl_tl_blogview set tl_blogview_status='$status' where tl_blogview_blogid='$id' ";
                 $data1 = DB::select($sqltrending_count);
                 }
           }

         $sql = "update $tblname set $colstatus='$status' where $colname='$id' ";
        $data = DB::select($sql);
      if($data==true){ echo '1';}else{
          echo '2'; 
      }
             

         }
    }

     public function featuretreat(Request $request){
        // if($request->isMethod('POST'))
        // {
         if($request->isMethod('POST')){
            $id =  $request->id;
            $status =  $request->status;

         $sql = "update `tbl_tl_product` set `tl_product_feature`='$status' where `tl_product_id`='$id' ";
        $data = DB::select($sql);
      if($data==true){ echo '1';}else{
          echo '2'; 
      }
             

         }
    }

    public function readmore(Request $request){
        
         if($request->isMethod('POST')){
            $tblname = $request->tblname;
            $id =  $request->id;
            $colnamewhere =  $request->colnamewhere;
            $colmsg =  $request->colmsg;  
        //   echo  $sql=DB::table($tblname')->where($colname,$id)->update([$colstatus =>$status]); exit;
         $sql = "select $colmsg from $tblname where $colnamewhere='$id'"; 
        $data = DB::select($sql);
        $data = json_decode(json_encode($data), True);
      if($data==true){ echo $data[0][$colmsg] ;}else{
          echo 'Something went wrong'; 
      }
             

         }
    }

    // end change status

    /////////////////// merchant module manage///////////////
  
    public function merchant(Request $request,$today=null){
            
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

         $today_date = $request->today;

          if($today_date=='')
            {
                
            $data = DB::table('users AS t1')
                ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
                ->where('role_id','2')->where('status','!=','2')
                ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_postcode','t2.tl_userdetail_address','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->orderBy('id','desc')->get();
              return view('tl_admin.merchant.merchant',compact('data'));
            }
            else
            {
                

                 $data = DB::table('users AS t1')
                ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
                ->where('role_id','2')
                ->where('created_at', 'like', $today_date.'%')
                ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_postcode','t2.tl_userdetail_address','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->orderBy('id','desc')->get();
                return view('tl_admin.merchant.merchant',compact('data'));
            }

      
    }    

    public function get_merchant($id=null){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

        if($id==''){
            return view('tl_admin.merchant.add_merchant');
        }else{
            $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_postcode','t2.tl_userdetail_address','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')
            ->where('t1.userid',$id)->get();
            $data = json_decode(json_encode($data), True);
            //print_r($data); exit;
            return view('tl_admin.merchant.add_merchant',compact('data'));
           }
        
     }   

   

     public function addmerchant(Request $request){

         if($request->isMethod('POST')){
            
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 
            $first_name = $request->first_name; 
            $last_name = $request->last_name;
            $name = $first_name.' '.$last_name;
            $phoneno = $request->phoneno;
            $address = $request->address;
            $post_code = $request->post_code;
            $password = $request->password;
            $email = $request->email;
            $userid = $request->user_id; 

            if($userid==''){
            $user_id = date('Ymdhis');
            $role_id = '2';
           
            $isemail_exists = DB::table('users')->select('email')->where('email',$email)->get();
             
            if(count($isemail_exists)>0){
                echo '5';exit;
            }
         
            $_token = $request->_token;
            $verify_token=$this->getRandomString(20);
        $sql =   DB::table('users')->insert([
                'userid'=>  $user_id,
                'name'=> $name ,
                'email'=> $email ,
                'password'=> md5($password) ,
                'role_id'=>  $role_id, 
                'remember_token'=> $_token , 
                'email_verify_token'=> $verify_token , 
                'email_verify_status'=> '1', 
                'status'=> '1',  
                'created_at'=> $curDate, 
                'updated_at'=> $curDate 
            ]);

            $sql =    DB::table('tbl_tl_user_detail')->insert([
                'tl_userdetail_userid'=>  $user_id,
                'tl_userdetail_firstname'=> $first_name ,
                'tl_userdetail_lastname'=> $last_name ,
                'tl_userdetail_phoneno'=> $phoneno ,
                'tl_userdetail_address'=> $address ,
                'tl_userdetail_postcode'=> $post_code ,
                'tl_userdetail_ip'=>  $ip_address, 
                'tl_userdetail_created_at'=> $curDate ,
                'tl_userdetail_updated_at'=> $curDate
            ]);
          
            if($sql){
                $sendemail=$this->WelcomeEmail($name,$email,$verify_token);
                return response()->json([
                    'status' =>'200',
                    'msg' => 'Merchant info added successfully',
                    're_userid' => $user_id
                ]);
            }else{
              
                return response()->json([
                    'status' =>'401',
                    'msg' => 'Something went wrong, please try again later'
                ]);
            }

        }else{

             if($email!=''){
                 $mail_exist = DB::table('users')
                ->where('email', '=',$email)
                ->where('userid', '!=',$userid)
                ->select('email')->get();

                if(count($mail_exist)>0){
                       echo '6'; exit;
                }
            }
               
            if($password!=''){
             //  echo 'sweta';exit;
            $sql=DB::table('users')
                    ->where('userid', '=',$userid)
                    ->update([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>md5($password),
                    'updated_at' => $curDate

                ]);

                $sql=DB::table('tbl_tl_user_detail')
                ->where('tl_userdetail_userid', '=',$userid)
                ->update([
                    'tl_userdetail_firstname'=> $first_name ,
                    'tl_userdetail_lastname'=> $last_name ,
                    'tl_userdetail_phoneno'=> $phoneno ,
                    'tl_userdetail_address'=> $address ,
                    'tl_userdetail_postcode'=> $post_code ,
                    'tl_userdetail_ip'=>  $ip_address, 
                    'tl_userdetail_updated_at'=> $curDate

            ]);


              }else{
                $sql=DB::table('users')
                ->where('userid', '=',$userid)
                ->update([
                'name'=>$name,
                'email'=>$email,
                'updated_at' => $curDate
            ]);

            $sql=DB::table('tbl_tl_user_detail')
            ->where('tl_userdetail_userid', '=',$userid)
            ->update([
                'tl_userdetail_firstname'=> $first_name ,
                'tl_userdetail_lastname'=> $last_name ,
                'tl_userdetail_phoneno'=> $phoneno ,
                'tl_userdetail_address'=> $address ,
                'tl_userdetail_postcode'=> $post_code ,
                'tl_userdetail_ip'=>  $ip_address, 
                'tl_userdetail_updated_at'=> $curDate

        ]);
              }

              if($sql){
                echo '3'; exit;
            }else{
                echo '4'; exit;
            }
        }

         }
        // return view('tl_admin.merchant.add_merchant');
     } 

     public function viewstore($id){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
      $data =  DB::table('tbl_tl_addstore')->where('userid',$id)
         ->select('userid','tl_addstore_name','tl_addstore_logo','tl_addstore_services','tl_addstore_treat_cardmsg','tl_addstore_address','tl_addstore_aboutmerchant','tl_addstore_termscondt','tl_addstore_postcode','tl_addstore_status','tl_addstore_id')
         ->get();
         return view('tl_admin.merchant.view_store',compact('data'));
     }
     
    
    public function get_addstore($id){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

        $data = DB::table('tbl_tl_addstore')
                ->where('userid',$id)
                ->select('userid','tl_addstore_name','tl_addstore_services','tl_addstore_logo','tl_addstore_lat','tl_addstore_lng'
                ,'tl_addstore_address','tl_addstore_treat_cardmsg','tl_addstore_aboutmerchant','tl_addstore_postcode','tl_addstore_termscondt'
                )->get();
                if(count($data)>0){
                   return view('tl_admin.merchant.add_store',compact('data'));
                }else{
                    return view('tl_admin.merchant.add_store');
                   }
     }  

     

  

    public function addstore(Request $request){

        if($request->isMethod('POST')){
          
            $treatcard_msg = $request->treatcard_msg; 
            $store_name = $request->store_name; 
            $location = $request->location;
            $lat = $request->lat;
            $lng = $request->lng;
            $userid = $request->userid;
            $post_code = $request->post_code;
            $updateid = $request->updateid;
            $service = $request->service;
            $about_merchant = addslashes($request->about_merchant);  
            $termsconditiondesp = addslashes($request->termsconditiondesp);
            $store_logo = $request->file('store_logo');  
            $addstore_status = '1';
            //$updateid = '';
          
            $objadminaddstore = new myconfiguration();
            $data = $objadminaddstore->addstore($store_name,$location,$lat,$lng,$userid,$about_merchant,$termsconditiondesp,$store_logo,$service,$addstore_status,$updateid,$post_code,$treatcard_msg);
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

    public function get_editstore($id){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
      $data = Db::table('tbl_tl_addstore')->where('tl_addstore_id',$id)
       ->select('tl_addstore_name','tl_addstore_logo','tl_addstore_address','tl_addstore_lat','tl_addstore_lng','tl_addstore_aboutmerchant','tl_addstore_termscondt')->get();
       $data = json_decode(json_encode($data), True);
       return view('tl_admin.merchant.edit_store',compact('data'));
 } 


 public function updatestore(Request $request){

    if($request->isMethod('POST')){
       
       $curDate = new \DateTime();
       $ip_address =  \Request::ip(); 
       $store_name = $request->store_name; 
       $location = $request->location;
       $lat = $request->lat;
       $lng = $request->lng;
       $id = $request->id;
       $about_merchant = $request->about_merchant;  
       $termsconditiondesp = addslashes($request->termsconditiondesp);
       $store_logo = $request->file('store_logo'); 

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

           $sql=DB::table('tbl_tl_addstore')
           ->where('tl_addstore_id', '=',$id)
           ->update([
            'tl_addstore_name'=> $store_name ,
            'tl_addstore_logo'=> $filename ,
            'tl_addstore_address'=>$location ,
            'tl_addstore_lat'=>$lat ,
            'tl_addstore_lng'=>$lng ,
            'tl_addstore_aboutmerchant'=>  $about_merchant, 
            'tl_addstore_termscondt'=> $termsconditiondesp ,  
            'tl_addstore_ip'=>  $ip_address,
            'tl_addstore_updatedat'=> $curDate 
       ]);
          
        if($sql==true)
        {
          return response()->json(
            [
            'status' =>'200',
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
         
        $sql=DB::table('tbl_tl_addstore')
        ->where('tl_addstore_id', '=',$id)
        ->update([
         'tl_addstore_name'=> $store_name ,
         'tl_addstore_address'=>$location ,
         'tl_addstore_lat'=>$lat ,
         'tl_addstore_lng'=>$lng ,
         'tl_addstore_aboutmerchant'=>  $about_merchant, 
         'tl_addstore_termscondt'=> $termsconditiondesp ,  
         'tl_addstore_ip'=>  $ip_address,
         'tl_addstore_updatedat'=> $curDate 
    ]);
       
     if($sql==true)
     {
       return response()->json(
         [
         'status' =>'200',
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

  }
///////////////////merchant store starts//////////////
  public function viewproduct($id){  
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
    $data =  DB::table('tbl_tl_product')->where('userid',$id)
       ->select('tl_product_id','userid','tl_product_categoryid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
       'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status','tl_product_feature','tl_product_redeem')
       ->orderBy('tl_product_id','desc')->get();
       return view('tl_admin.merchant.view_product',compact('data'));
   }

   public function get_addproduct($id){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
    return view('tl_admin.merchant.add_product');
}  

public function addproduct(Request $request){
    
    if($request->isMethod('POST')){
        $treatfor = array();

       
       $curDate = new \DateTime();
       $ip_address =  \Request::ip(); 

       $user_id = $request->user_id;
       $treat_name = $request->treat_name;
       $producttype = $request->producttype; 
       $treatfor = $request->treatfor;
       $pro_category = $request->pro_category;
       $treattype = $request->treattype;
       $treat_price = $request->treat_price;
       $treat_valid = $request->treat_valid; 
       $addcategory = $request->addcategory; 
       $reedeem_msg = $request->reedeem_msg; 

       if($treat_valid!=''){
            $treat_valid = date("Y-m-d H:i:00", strtotime($treat_valid)); 
       }
       

       $max_no = $request->max_no;
       $description = addslashes($request->description);  
       $cardmessage = addslashes($request->cardmessage);

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
           $filename1 = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
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
           $filename2 = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
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
           $filename3 = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
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

       if($frontstoreimg!="")   // start product image 3
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
           $filename4 = uniqid().'_'.time().'_'.date('Ymd').'.'.$extension;
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

       if($addcategory!=''){
                $category_exist = DB::table('tbl_tl_category')
                ->where('tl_category_name',$addcategory)
                ->select('tl_category_name')->get();

                if(count($category_exist)>0){
                return response()->json([
                        'status' =>'401',
                        'msg' => 'Category already exists.'
                    ]); 
                }else{

                $insertcatsql =  DB::table('tbl_tl_category')->insert([
                'tl_category_name' =>  $addcategory,
                'tl_category_status' => '1'
                ]); 
                $pro_category = DB::getPdo()->lastInsertId();
                }
       }
       
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
        'tl_product_redeem'=> $reedeem_msg,
        'tl_product_ip'=> $ip_address, 
        'tl_product_created_at'=> $curDate,
        'tl_product_updated_at'=> $curDate,
        'tl_product_status'=> '1',
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
                'tl_product_redeem'=> $reedeem_msg,
                'tl_product_ip'=> $ip_address, 
                'tl_product_created_at'=> $curDate,
                'tl_product_updated_at'=> $curDate,   
                'tl_product_status'=> '1',
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





    }
   // return view('tl_admin.merchant.add_merchant');
}

    public function get_editproduct($id){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $data = DB::table('tbl_tl_product')->where('tl_product_id',$id)
        ->select('tl_product_id','tl_product_categoryid','userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
        'tl_product_image2','tl_product_image3','tl_product_storeimage','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_redeem','tl_product_status')
        ->get();
        $data = json_decode(json_encode($data), True);
        //print_r($data); exit;
        return view('tl_admin.merchant.edit_product',compact('data'));
    } 

    public function updateproduct(Request $request){
    
        if($request->isMethod('POST')){
            $treatfor = array();
    
           
           $curDate = new \DateTime();
           $ip_address =  \Request::ip(); 
    
           $updateid = $request->updateid;
           $treat_name = $request->treat_name;
           $producttype = $request->producttype; 
           $treatfor = $request->treatfor;
           $treattype = $request->treattype;
           $pro_category = $request->pro_category;
           $treat_price = $request->treat_price;  
           $treat_valid = $request->treat_valid;  
           $reedeem_msg = $request->reedeem_msg;  
    
           $max_no = $request->max_no;
           $description = addslashes($request->description);  
           $cardmessage = addslashes($request->cardmessage);
    
           $product_imageidd = $request->file('product_imageidd'); 
                              
           $product_imageidd1 = $request->file('product_imageidd1');
           $product_imageidd2 = $request->file('product_imageidd2');
           $frontstoreimg = $request->file('frontstoreimg');
           
    
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

           if($frontstoreimg!="")   // start product image 3
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
            $filename4 = DB::table('tbl_tl_product')->select('tl_product_storeimage')->where('tl_product_id',$updateid)->get();
            $filename4 = json_decode(json_encode($filename4), True);
            $filename4 = $filename4[0]['tl_product_storeimage'];
           }///end product image 3
           
      if($treat_valid!=''){
        $sql =    DB::table('tbl_tl_product')
        ->where('tl_product_id',$updateid)
        ->update([  
            'tl_product_name'=> $treat_name ,
            'tl_product_for'=> $treatfor ,
            'tl_product_treat_type'=>$treattype ,
            'tl_product_categoryid'=> $pro_category,
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
            'tl_product_redeem'=> $reedeem_msg,
            'tl_product_ip'=> $ip_address,
            'tl_product_updated_at'=> $curDate
        ]);
      }else{
        $sql =    DB::table('tbl_tl_product')
        ->where('tl_product_id',$updateid)
        ->update([
                    'tl_product_name'=> $treat_name ,
                    'tl_product_for'=> $treatfor ,
                    'tl_product_treat_type'=>$treattype ,
                    'tl_product_categoryid'=> $pro_category,
                    'tl_product_price'=>$treat_price ,
                    'tl_product_maxlimit'=>$max_no ,
                    'tl_product_image1'=> $filename1 ,  
                    'tl_product_image2'=>  $filename2,
                    'tl_product_image3'=> $filename3, 
                    'tl_product_storeimage'=> $filename4,
                    'tl_product_description'=> $description,   
                    'tl_product_cardmsg'=> $cardmessage,
                    'tl_product_type'=> $producttype,
                    'tl_product_redeem'=> $reedeem_msg,
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
       // return view('tl_admin.merchant.add_merchant');
    }



////////////////////////end merchant store/////////////////////


   ///////////////////end merchant module ///////////////

   public function treat_for(){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
    $relation = DB::table('_relation')->where('parent_cat_id','0')->select('id','name','status')->orderBy('id','desc')->get();
       return view('tl_admin.treat_for',compact('relation'));
   }

   public function add_treat_for($id=null){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
      $data = DB::table('_relation')->select('id','name')->where('id',$id)->first();
      $data = json_decode(json_encode($data), True);
       return view('tl_admin.add_treat_for',compact('data'));
   }

   public function addtreatfor(Request $request){
    if($request->isMethod('POST')){
        
       $curDate = new \DateTime();
       $ip_address =  \Request::ip(); 
      $treat_for =  trim($request->treat_for);
      $updateid =  trim($request->updateid);
      if($updateid==''){
            if($treat_for!=''){

                $sql1 =  DB::table('_relation')->select('name')->where('name',$treat_for)->get();
                if(count($sql1)>0){
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Relation type already exists'
                        ]);
                }else{
                
                $sql =  DB::table('_relation')->insert([
                        'name' =>  $treat_for ,
                        'parent_cat_id' => '0',
                        'ip_address' =>  $ip_address ,
                        'created_at' =>  $curDate ,
                        'updated_at' =>  $curDate 
                    ]);
                    if($sql == true){
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Added successfully'
                            ]);
                    }else{
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Something went wrong, please try again later'
                            ]);
                    }
                }// check relation type already exists
            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Field can not be blank'
                    ]);
            } // check for blank
            }  
        else{
            if($treat_for!=''){
                $updatesql=DB::table('_relation')
                ->where('id', '=',$updateid)
                ->update([
                    'name' =>  $treat_for ,
                    'ip_address' =>  $ip_address ,
                    'updated_at' =>  $curDate 
            ]);

            if($updatesql == true){
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated successfully'
                    ]);
            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong, please try again later'
                    ]);
            }

            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Field can not be blank'
                    ]);
            } // check for blank
           
        }  //
    }
    else{
        return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid request'
            ]);
    }  // check request method
   }

   public function view_subcategory($cat_id){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
    if($cat_id!='')
    {
        $relation = DB::table('_relation')->where('parent_cat_id',$cat_id)->select('id','name','status')->orderBy('id','desc')->get();
       return view('tl_admin.view_subcategory',compact('relation'));
    }
   }

   public function add_sub_category($id=null)
   {
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
    if($id!='')
    {
      
        $data = DB::table('_relation')->select('id','name','parent_cat_id')->where('id',$id)->first();
      // print_r($data); exit;
       // $data = json_decode(json_encode($data), True);
        return view('tl_admin.add_sub_category',compact('data'));
    }
    else
    {
       
        return view('tl_admin.add_sub_category');
    }
    
   }

   public function addsubcat(Request $request){
    if($request->isMethod('POST')){
        
       $curDate = new \DateTime();
       $ip_address =  \Request::ip(); 
      $catid =  trim($request->catid);
      $treat_for =  trim($request->treat_for);
      $updateid =  trim($request->updateid);
      if($updateid==''){
            if($treat_for!=''){

                $sql1 =  DB::table('_relation')->select('name')->where('name',$treat_for)->get();
                if(count($sql1)>0){
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Relation type already exists'
                        ]);
                }else{
                
                $sql =  DB::table('_relation')->insert([
                        'name' => $treat_for ,
                        'parent_cat_id' => $catid ,
                        'ip_address' =>  $ip_address ,
                        'created_at' =>  $curDate ,
                        'updated_at' =>  $curDate 
                    ]);
                    if($sql == true){
                        return response()->json(
                            [
                            'status' =>'200',
                            'msg' => 'Added successfully'
                            ]);
                    }else{
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Something went wrong, please try again later'
                            ]);
                    }
                }// check relation type already exists
            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Field can not be blank'
                    ]);
            } // check for blank
            }  
        else{
            if($treat_for!=''){
                $updatesql=DB::table('_relation')
                ->where('id', '=',$updateid)
                ->update([
                    'name' =>  $treat_for ,
                    'parent_cat_id' => $catid ,
                    'ip_address' =>  $ip_address ,
                    'updated_at' =>  $curDate 
            ]);

            if($updatesql == true){
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated successfully'
                    ]);
            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong, please try again later'
                    ]);
            }

            }else{
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Field can not be blank'
                    ]);
            } // check for blank
           
        }  //
    }
    else{
        return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid request'
            ]);
    }  // check request method
   }

   public function deletetreatfor(Request $request){
        if($request->isMethod('POST')){
            $id = trim($request->id);
            if($id!=''){
              $sql =  DB::table('_relation')->where('id', $id)->delete();
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
                    'msg' => 'Something went wrong, please try again later'
                 ]);
              }
            }
        }
   }

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
             } 

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

    public function support_enquiry(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        return view('tl_admin.support_enquiry');
       
    }

    public function support_enquiry_merchant(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
          $data =  DB ::table('tl_support')
             ->select('tl_support_email','tl_support_phone','tl_support_message','tl_support_id')
             ->where('tl_support_roleid','2')
             ->orderBy('tl_support_id','desc')
             ->get();
           //  echo 'sweta'; exit;
        return view('tl_admin.support_enquiry_merchant',compact('data'));
    }

    public function support_enquiry_user(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 
        $data =  DB::table('tl_support')
           ->select('tl_support_email','tl_support_phone','tl_support_message','tl_support_id')
           ->where('tl_support_roleid','3')
           ->orderBy('tl_support_id','desc')
           ->get();
        
      return view('tl_admin.support_enquiry_user',compact('data'));
  }

  public function manage_social_link(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

        $data =  DB::table('tbl_tl_social_link')
           ->select('tl_social_link_facebook','tl_social_link_twitter','tl_social_link_youtube','tl_social_link_insta')
           ->where('tl_social_link_id','1')
           ->get();
        
      return view('tl_admin.social_link',compact('data'));
  }

  public function save_sociallink(Request $request)
  {
    if($request->isMethod('post'))
      {
        $fb_link = $request->fb_link;
        $tw_link = $request->tw_link;
        $utube_link = $request->utube_link;
        $insta_link = $request->insta_link;
        
        $sql = DB::table('tbl_tl_social_link')->where('tl_social_link_id','1')->get(['tl_social_link_id']);

        if( count($sql) > 0)
        {
         
           $sql1 = DB::table('tbl_tl_social_link')->where('tl_social_link_id','1')->update([
                 'tl_social_link_facebook' => $fb_link,
                 'tl_social_link_twitter' => $tw_link,
                 'tl_social_link_youtube' => $utube_link,
                 'tl_social_link_insta' => $insta_link
            ]);
        }
        else
        {
           
           $sql1 = DB::table('tbl_tl_social_link')->insert([
                           'tl_social_link_facebook' => $fb_link,
                           'tl_social_link_twitter' => $tw_link,
                           'tl_social_link_youtube' => $utube_link,
                           'tl_social_link_insta' => $insta_link

                       ]);
        }
       
        
            return response()->json(
            [
            'status' =>'200',
            'msg' => 'Links Updated Successfully'
            ]);
        

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

  public function viewbusiness(Request $request){
      if($request->isMethod('post'))
      {
       $userid = $request->userid;
       if($userid!='')
       {

        $sql = DB::table('tbl_tl_mybusiness')
        ->select('userid')
        ->where('userid',$userid)->get();
        if(count($sql)>0)
        {
            $data = DB::table('tbl_tl_mybusiness')
            ->where('userid',$userid)
            ->select('tl_mybusiness_address','tl_mybusiness_type','tl_mybusiness_vatno','tl_mybusiness_phoneno','tl_mybusiness_about')
            ->get();
            echo  $html ='
               <h1 class="tl-adheading">Business Info</h1>
                <div class="tl-adflexmain"><div class="tl-adcolsflex"><span>Address:</span><span>'.$data[0]->tl_mybusiness_address.'</span></div>
                  <div class="tl-adcolsflex"><span>Phone Number :</span><span>'.$data[0]->tl_mybusiness_phoneno.'</span></div>
                  <div class="tl-adcolsflex"><span>Business Type:</span><span>'.$data[0]->tl_mybusiness_address.'</span></div>
                  <div class="tl-adcolsflex"><span>Vat Number :</span><span>'.$data[0]->tl_mybusiness_vatno.'</span></div></div>
                  <p class="tl-desp"> <span class="para-heading">About Business</span>'.$data[0]->tl_mybusiness_about.'</p>
                '; exit;
        }
        else{
            echo 'No Record Found'; exit;
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

    $data =  DB ::table('tl_support')
       ->select('tl_support_email','tl_support_phone','tl_support_message','tl_support_id')
       ->where('tl_support_roleid','3')
       ->get();
    
  return view('tl_admin.support_enquiry_user',compact('data'));
}

public function user(Request $request,$today=null){
  
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 

    $today_date = $request->today;
    if($today_date=='')
    {
   $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->where('role_id','3')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->orderBy('id','desc')->get();
    return view('tl_admin.user.user',compact('data'));
    }
    else
    {
        
        $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->where('role_id','3')->where('created_at', 'like', $today_date.'%')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->orderBy('id','desc')->get();
    return view('tl_admin.user.user',compact('data'));
    }
}



public function exportuserdata(Request $request)
{ 

     $today_date = $request->today;
    if($today_date=='')
    {
     
   $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->where('role_id','3')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->get();
    return view('tl_admin.user.exportuserdata',compact('data'));
    }
    else
    {
        
        $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->where('role_id','3')->where('created_at', 'like', $today_date.'%')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip')->get();
    return view('tl_admin.user.exportuserdata',compact('data'));
    }

}

public function all_product(){
    $session_all=Session::get('sessionadmin');

    if($session_all==false)
    {
        return Redirect::to('/tladminpanel');
        exit();
    } 
   
    $data =  DB::table('tbl_tl_product')
            ->join('tbl_tl_addstore','tbl_tl_addstore.userid','tbl_tl_product.userid')
            ->join('users','users.userid','tbl_tl_product.userid')
            ->where('users.status','1')
            ->select('tbl_tl_addstore.tl_addstore_name','tl_product_id','tbl_tl_product.userid','tl_product_name','tl_product_for','tl_product_treat_type','tl_product_price','tl_product_maxlimit','tl_product_validity','tl_product_image1',
            'tl_product_image2','tl_product_image3','tl_product_description','tl_product_cardmsg','tl_product_type','tl_product_status','tl_product_feature')
            ->orderBy('tl_product_id','desc')->get();
    return view('tl_admin.product',compact('data'));

}  


public function edit_user($id=null){
    if($id!=''){
         $data = DB::table('users AS t1')
            ->join('tbl_tl_user_detail AS t2','t1.userid','t2.tl_userdetail_userid')
            ->select('t1.status','t1.userid','t1.email','t2.tl_userdetail_firstname','t2.tl_userdetail_lastname','t2.tl_userdetail_phoneno','t2.tl_userdetail_ip','t2.tl_userdetail_address')
            ->where('t1.userid',$id)->get();
            $data = json_decode(json_encode($data), True);
            return view('tl_admin.user.edit_user',compact('data'));
    }

}

public function update_user(Request $request){
    if($request->isMethod('POST')){
        
            $curDate = new \DateTime();
            $ip_address =  \Request::ip(); 
            $first_name = $request->first_name; 
            $last_name = $request->last_name;
            $name = $first_name.' '.$last_name;
            $phoneno = $request->phoneno;
            $password = $request->password;
            $email = $request->email;
            $address = $request->address;

            $userid = $request->user_id; 

            if($email!=''){
                 $mail_exist = DB::table('users')
                ->where('email', '=',$email)
                ->where('userid', '!=',$userid)
                ->select('email')->get();

                if(count($mail_exist)>0){
                       echo '3'; exit;
                }
            }



             if($password!=''){
             //  echo 'sweta';exit;
            $sql=DB::table('users')
                    ->where('userid', '=',$userid)
                    ->update([
                    'name'=>$name,
                    'email'=>$email,
                    'password'=>md5($password),
                    'updated_at' => $curDate

                ]);

                $sql=DB::table('tbl_tl_user_detail')
                ->where('tl_userdetail_userid', '=',$userid)
                ->update([
                    'tl_userdetail_firstname'=> $first_name ,
                    'tl_userdetail_lastname'=> $last_name ,
                    'tl_userdetail_phoneno'=> $phoneno ,
                    'tl_userdetail_address'=> $address ,
                    'tl_userdetail_ip'=>  $ip_address, 
                    'tl_userdetail_updated_at'=> $curDate

            ]);


              }else{
                $sql=DB::table('users')
                ->where('userid', '=',$userid)
                ->update([
                'name'=>$name,
                'email'=>$email,
                'updated_at' => $curDate
            ]);
                 $sql=DB::table('tbl_tl_user_detail')
            ->where('tl_userdetail_userid', '=',$userid)
            ->update([
                'tl_userdetail_firstname'=> $first_name ,
                'tl_userdetail_lastname'=> $last_name ,
                'tl_userdetail_phoneno'=> $phoneno ,
                'tl_userdetail_address'=> $address ,
                'tl_userdetail_ip'=>  $ip_address, 
                'tl_userdetail_updated_at'=> $curDate

        ]);
              }

               if($sql==true){
                echo '1'; exit;
            }else{
                echo '2'; exit;
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

  public function deleteuser(Request $request){
    if($request->isMethod('POST')){
        $id = trim($request->id); 
        if($id!=''){
          $sql =  DB::table('users')->where('userid', $id)->delete();   
          $sql1 =  DB::table('tbl_tl_user_detail')->where('tl_userdetail_userid', $id)->delete();  
          if($sql==true && $sql1==true){
             return response()->json([
                'status' =>'200',
                'msg' => 'Deleted successfully'
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
    }


}
   
            public function get_category(){
                $data = DB::table('tbl_tl_category')->select('tl_category_id','tl_category_name','tl_category_status')->get();
                return view('tl_admin.view_category',compact('data'));
            }

            public function add_category($id=null){
              if($id!=''){
               $data  = DB::table('tbl_tl_category')->where('tl_category_id',$id)->select('tl_category_id','tl_category_name','tl_category_status')->get();
                return view('tl_admin.add_category',compact('data'));
              }else{
                return view('tl_admin.add_category');
              }
                
            }

            public function store_category(Request $request){
                if($request->isMethod('POST')){
                    $categoty_name = trim($request->categoty_name); 
                    $updateid = trim($request->updateid); 
                    if($updateid=='')
                    {
                        if($categoty_name!=''){
                            $category_exist = DB::table('tbl_tl_category')->where('tl_category_name',$categoty_name)->select('tl_category_name')->get();
                            if(count($category_exist)>0){
                                return response()->json([
                                    'status' =>'401',
                                    'msg' => 'Category already exists.'
                                ]); 
                            }else{
                                $sql =  DB::table('tbl_tl_category')->insert([
                                    'tl_category_name' =>  $categoty_name,
                                    'tl_category_status' => '1'
                                ]);   
                    
                                if($sql==true){
                                    return response()->json([
                                        'status' =>'200',
                                        'msg' => 'Category added successfully.'
                                    ]);
                                }
                                else
                                {
                                    return response()->json([
                                        'status' =>'401',
                                        'msg' => 'Something went wrong, please try again later.'
                                    ]);
                                }
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
                        if($categoty_name!=''){
                            $sql =  DB::table('tbl_tl_category')->where('tl_category_id',$updateid)->update([
                                        'tl_category_name' =>  $categoty_name
                                    ]);   
                        
                            if($sql==true){
                                return response()->json([
                                    'status' =>'200',
                                    'msg' => 'Category updated successfully'
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
                }
                else
                {
                    return response()->json([
                        'status' =>'401',
                        'msg' => 'Invalid Request'
                    ]);
                }
            }
            

    public function exportcon_queries(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        }
        return view('tl_admin.export.exportcon_queries'); 

    }

    public function exportweb_subscription(){

        
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        }
       
        return view('tl_admin.export.exportweb_subscription'); 

    }

    public function Personalise_info(){
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        }
        $data = DB::table('tbl_tl_personalise')
            ->where('tl_personalise_id', '=','1')
            ->select('tl_personalise_info')->get();

            return view('tl_admin.personalise_info',compact('data'));
    }

    public function save_personaliseinfo(Request $request){
        if($request->isMethod('POST'))
    {
        
        $curDate = new \DateTime();
        $ip_address =  \Request::ip(); 
        $personalise_info = $request->personalise_info; 
  
    if($personalise_info!="")
        {
            try {
               
                    $sql= DB::table('tbl_tl_personalise')
                            ->where('tl_personalise_id', '=','1')
                            ->update([
                            'tl_personalise_info'=>$personalise_info   
                          ]);
                return response()->json(
                 [
                 'status' =>'200',
                 'msg' => 'Updated successfully'
                 ]);
            } catch (\Exception $e) {
                 return response()->json(
                         [
                         'status' =>'401',
                         'msg' => 'Something went wrong, Please try again later'
                         ]);
            }

           

        }else{
            return response()->json(
                [
                'status' =>'401',
                'msg' => 'All fields arwe required.'
                ]); 
        }
        
    }else{
        return response()->json(
            [
            'status' =>'401',
            'msg' => 'Invalid Request.'
            ]); 
    }

}

        public function current_order(Request $request,$today=null){
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            $today_date = $request->today;

             if($today_date=='')
                {
                 $data = DB::table('tbl_tl_order')->where('tl_order_status','PLACED')->select('userid','cart_uniqueid','tl_order_ref','tl_cart_subtotal','store_id','tl_order_paymode','tl_order_paystatus','tl_order_partial_reedeem','tl_order_status','tl_order_created_at')->orderby('tl_order_id','desc')->get();

                return view('tl_admin.order.current_order',compact('data'));
                }
                else
                {
                    $data = DB::table('tbl_tl_order')->where('tl_order_created_at', 'like', $today_date.'%')->where('tl_order_status','PLACED')->select('userid','cart_uniqueid','tl_order_ref','tl_cart_subtotal','store_id','tl_order_paymode','tl_order_paystatus','tl_order_partial_reedeem','tl_order_status','tl_order_created_at')->orderby('tl_order_id','desc')->get();
                 return view('tl_admin.order.current_order',compact('data'));
                }
            
        }

        public function edit_card($proid,$cartid){
            if($proid!=''&& $cartid!=''){
                $data = DB::table('tbl_tl_card')->select('tl_product_id','cart_uniqueid','card_recipient_name', 'card_occasion', 'card_message','card_sender_name','card_sender_name1')->where('cart_uniqueid',$cartid)->where('tl_product_id',$proid)->get();
               return view('tl_admin.order.edit_card',compact('data'));
            }
        }

        public function view_card($proid,$cartid){
            if($proid!=''&& $cartid!=''){
                $data = DB::table('tbl_tl_card')->select('tl_product_id','cart_uniqueid','template_id','card_recipient_name', 'card_occasion', 'card_message','card_sender_name','card_sender_name1')->where('cart_uniqueid',$cartid)->where('tl_product_id',$proid)->get();

                $storeid = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cartid)->where('tl_product_id',$proid)->select('store_id','store_merchant_id','tl_cart_voucher','tl_product_name','store_name')->get();
              

                $merchant_phone = DB::table('tbl_tl_user_detail')->where('tl_userdetail_userid',$storeid[0]->store_merchant_id)->select('tl_userdetail_phoneno')->get();

                $pro_validity = DB::table('tbl_tl_product')->where('tl_product_id',$proid)->select('tl_product_validity','tl_product_redeem')->get();

                $abt_merchant = DB::table('tbl_tl_addstore')->where('tl_addstore_id',$storeid[0]->store_id)->select('tl_addstore_aboutmerchant','tl_addstore_treat_cardmsg')->get();
             
               return view('tl_admin.order.view_card',compact('data','abt_merchant','storeid','pro_validity','merchant_phone'));
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
                $sender_name1 = trim($request->sender_name1);  
                $updateid = trim($request->updateid);
                $updateid1 = trim($request->updateid1);

                    if($updateid!='' && $updateid1!=''){
                       // echo $datepicker; exit;
                        $sql =  DB::table('tbl_tl_card')->where('cart_uniqueid',$updateid)->where('tl_product_id',$updateid1)->update([
                            'card_recipient_name' =>  $recipient_name,
                            'card_occasion' =>  $recipient_occasion,
                            'card_message' =>  $message,
                            'card_sender_name' =>  $sender_name,
                            'card_sender_name1' =>  $sender_name1,
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

        public function view_voucher($cartid){
             $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            if($cartid!=''){
                $data = DB::table('tbl_tl_user_cart AS t1')
                                ->join('tbl_tl_product AS t2','t1.tl_product_id','t2.tl_product_id')->where('t1.cart_uniqueid',$cartid)->where('t2.tl_product_type','Voucher')->select('t1.cart_id','t1.cart_uniqueid','t1.userid','t1.store_id','t1.tl_product_id','t1.tl_product_name','t1.tl_product_image1','t1.tl_product_description','t1.tl_product_price','t1.tl_cart_partial_reedeem')->get();
                              

                 return view('tl_admin.order.view_voucher',compact('data'));
            }

        }

        public function completed_order(){
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            $data = DB::table('tbl_tl_order')->where('tl_order_status','DELIVERED')->select('userid','cart_uniqueid','tl_order_ref','tl_cart_subtotal','tl_order_paymode','tl_order_paystatus','tl_order_status','tl_order_created_at')->orderby('tl_order_id','desc')->get();

            return view('tl_admin.order.completed_order',compact('data'));
        }

        public function currentorder_viewtreat($cart_uniqueid){
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }
            if($cart_uniqueid!=''){
           
              $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_uniqueid)->where('tl_cart_status','PLACED')->select('cart_id','userid','store_id','cart_uniqueid','tl_product_id','tl_product_name','tl_product_image1','tl_product_description','tl_product_price','tl_cart_voucher','tl_cart_partial_reedeem')->get();

                return view('tl_admin.order.view_treat',compact('treat'));
            }
        }

         public function completeorder_viewtreat($cart_uniqueid){
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }
            if($cart_uniqueid!=''){
           
              $treat = DB::table('tbl_tl_user_cart')->where('cart_uniqueid',$cart_uniqueid)->where('tl_cart_status','PLACED')->select('cart_id','userid','store_id','cart_uniqueid','tl_product_id','tl_product_name','tl_product_image1','tl_product_description','tl_product_price','tl_cart_voucher','tl_cart_partial_reedeem')->get();

                return view('tl_admin.order.complete_view_treat',compact('treat'));
            }
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

        public function merchant_of_the_month(){
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            /*$merchant_userid = DB::table('tbl_tl_merchant_of_month')->where('tl_merchant_of_month_id','1')->select('merchant_userid')->get();



            $data =  DB::table('tbl_tl_addstore')->where('userid',$merchant_userid[0]->merchant_userid)->select('tl_addstore_name','tl_addstore_logo','tl_addstore_address','tl_addstore_aboutmerchant','tl_addstore_services')->get();*/


            $merchant_userid = DB::table('tbl_tl_merchant_of_month')->where('tl_merchant_of_month_id','1')->get(['merchant_userid']);

            if(count($merchant_userid) > 0)
            {
            	$data =  DB::table('tbl_tl_addstore')->where('userid',$merchant_userid[0]->merchant_userid)->get(['tl_addstore_name','tl_addstore_logo','tl_addstore_address','tl_addstore_aboutmerchant','tl_addstore_services']);
            }
            else
            {
            	$merchant_userid = null;
            	$data = [];
            }
            
            

            return view('tl_admin.merchant.merchant_of_the_month',compact('data','merchant_userid'));
        }

        public function save_merc_month(Request $request)
        {
            if($request->isMethod('POST'))
            {
              $merc_month_userid = $request->merc_month;  

               $storedata = DB::table('tbl_tl_merchant_of_month')->where('tl_merchant_of_month_id','1')->update([
                        'merchant_userid' => $merc_month_userid
                      ]);

              $storedata = DB::table('tbl_tl_addstore')->where('userid',$merc_month_userid)->select('tl_addstore_name','tl_addstore_logo','tl_addstore_address','tl_addstore_aboutmerchant','tl_addstore_services')->get();

              if(count($storedata)>0)
              {
                 return response()->json(
                    [
                    'status' =>'200',
                    'msg' => $storedata
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

        public function delivery_address($proid,$cartuniqueid)
        {
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            if($proid!='' && $cartuniqueid !='')
            {
                $delivery_addr = DB::table('tbl_order_recipient_address')->where('cart_uniqueid',$cartuniqueid)->where('tl_product_id',$proid)->select('tl_recipient_name','tl_recipient_address','tl_recipient_city','tl_recipient_country','tl_recipient_postcode')->get();

                return view('tl_admin.order.delivery_address',compact('delivery_addr')); 
            }
        }

         public function postage_packaging()
        {
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            $data = DB::table('tbl_postage_packaging')->select('postage_packaging_cost')->where('id','1')->get();
            return view('tl_admin.postage_packaging',compact('data'));
        }

        public function postagecost(Request $request)
        {
            if($request->isMethod('POST'))
            {
               $cost = $request->cost;
               if($cost!='')
               {
                $sql =  DB::table('tbl_postage_packaging')->where('id','1')->update(['postage_packaging_cost'=>$cost]);
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated successfully.'
                    ]);
               }
               else
               {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All fields are required.'
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

         public function thankyou()
        {
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            $data = DB::table('tbl_tl_thankyou')->select('tl_thankyou_content','email')->where('tl_thankyou_id','1')->get();
            return view('tl_admin.thankyou',compact('data'));
        }

        public function thankyou_update(Request $request)
        {
            if($request->isMethod('POST'))
            {
               $thankyou_content = $request->thankyou_content;
               $email = $request->email;
               if($thankyou_content!=''  && $email!='')
               {
                $sql =  DB::table('tbl_tl_thankyou')->where('tl_thankyou_id','1')->update(['tl_thankyou_content'=>$thankyou_content,'email'=>$email]);
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Updated successfully.'
                    ]);
               }
               else
               {
                return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'All fields are required.'
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

        public function contact_us()
        {
            $session_all=Session::get('sessionadmin');

            if($session_all==false)
            {
                return Redirect::to('/tladminpanel');
                exit();
            }

            $data = DB::table('tbl_tl_contactus')->select('icon_1_image','icon_1_title','icon_1_desp','icon_2_image','icon_2_title','icon_2_desp','icon_3_image','icon_3_title','icon_3_desp')->where('id','1')->get();

            return view('tl_admin.contact_us_cms',compact('data'));
        }

         public function update_icon1(Request $request){
        if($request->isMethod('POST'))
        {
            $text1desc = addslashes($request->text1desc);
            $icon1_img = $request->file('icon1_img');
            $icon1_title = $request->icon1_title;
    
            if($icon1_img!="")
            {
                $extension = $icon1_img->getClientOriginalExtension();
                $filename = $icon1_img->getClientOriginalName();
                $filesize  =  $icon1_img->getClientSize();
    
                if($extension!='jpg' && $extension!='jpeg' && $extension!='png'&& $extension!='svg')
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
                $dir = public_path().'/tl_admin/upload/howitworks/';
                $orgfilename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
                $upload_image = $icon1_img->move($dir, $orgfilename);
                if($upload_image==false)
                {
                     return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }else{
                    $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                             ->update(['icon_1_image' => $orgfilename, 'icon_1_desp' => $text1desc, 'icon_1_title' => $icon1_title]);

                    if($sql==true)
                    {
                      return response()->json(
                        [
                        'status' =>'200',
                        'msg' => 'Icon  Updated Successfully!'
                        ]);  
                    } // end if
                    else
                    {
                        return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Something went wrong,please try again'
                        ]);
                    } //end else
                }
            } // end if banner image not blank
            else
            {
                $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                ->update(['icon_1_desp' => $text1desc, 'icon_1_title' => $icon1_title]);
                
                if($sql==true)
                {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Icon  Updated Successfully!'
                    ]);  
                } // end if
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,please try again'
                    ]);
                } //end else

            } // end else

                }   
            }

            public function update_icon2(Request $request){
    if($request->isMethod('POST'))
    {

        $phone = $request->phone;
        $icon2_img = $request->file('icon2_img');
         $icon2_title = $request->icon2_title;

        if($icon2_img!="")
        {
            $extension = $icon2_img->getClientOriginalExtension();
            $filename = $icon2_img->getClientOriginalName();
            $filesize  =  $icon2_img->getClientSize();

            if($extension!='jpg' && $extension!='jpeg' && $extension!='png'&& $extension!='svg')
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
            $dir = public_path().'/tl_admin/upload/howitworks/';
            $orgfilename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
            $upload_image = $icon2_img->move($dir, $orgfilename);
            if($upload_image==false)
            {
                 return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Unable to upload image, please try again'
                    ]);
            }else{
                $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                         ->update(['icon_2_image' => $orgfilename, 'icon_2_desp' => $phone, 'icon_2_title' => $icon2_title]);

                if($sql==true)
                {
                  return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Icon  Updated Successfully!'
                    ]);  
                } // end if
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,please try again'
                    ]);
                } //end else
            }
        } // end if banner image not blank
     
  
        else{
                $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                ->update(['icon_2_desp' => $phone, 'icon_2_title' => $icon2_title]);
                
                if($sql==true)
                {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Icon  Updated Successfully!'
                    ]);  
                } // end if
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,please try again'
                    ]);
                } //end else

            } // end else

    }   
}

     public function update_icon3(Request $request){
    if($request->isMethod('POST'))
    {
        $email =     $request->email;
        $icon3_img = $request->file('icon3_img');
         $icon3_title = $request->icon3_title;

        if($icon3_img!="")
        {
            $extension = $icon3_img->getClientOriginalExtension();
            $filename = $icon3_img->getClientOriginalName();
            $filesize  =  $icon3_img->getClientSize();

            if($extension!='jpg' && $extension!='jpeg' && $extension!='png'&& $extension!='svg')
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
            $dir = public_path().'/tl_admin/upload/howitworks/';
            $orgfilename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
            $upload_image = $icon3_img->move($dir, $orgfilename);
            if($upload_image==false)
            {
                 return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Unable to upload image, please try again'
                    ]);
            }else{
                $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                         ->update(['icon_3_image' => $orgfilename, 'icon_3_desp' => $email, 'icon_3_title' => $icon3_title]);
                if($sql==true)
                {
                  return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Icon  Updated Successfully!'
                    ]);  
                } // end if
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,please try again'
                    ]);
                } //end else
            }
        } // end if banner image not blank
     
  
        else{
                $sql = DB::table('tbl_tl_contactus')->where('id', 1)
                ->update(['icon_3_desp' => $email, 'icon_3_title' => $icon3_title]);
                
                if($sql==true)
                {
                return response()->json(
                    [
                    'status' =>'200',
                    'msg' => 'Icon  Updated Successfully!'
                    ]);  
                } // end if
                else
                {
                    return response()->json(
                    [
                    'status' =>'401',
                    'msg' => 'Something went wrong,please try again'
                    ]);
                } //end else

            } // end else

    }   
}

    public function remove_pro_image(Request $request)
    {
        if($request->isMethod('POST'))
        {       
          $removeimage =  $request->removeimage;
          $updateid =  $request->updateid;
          if($removeimage == 'product_imageidd1')
          {
            $colname = 'tl_product_image2';
            $replace_img = '';
          }
          else if($removeimage == 'product_imageidd2')
          {
            $colname = 'tl_product_image3';
            $replace_img = '';
          }
          else if($removeimage == 'frontstoreimg_Path2')
          {
            $colname = 'tl_product_storeimage';
            $replace_img = '';
          }
          else if($removeimage == 'product_imageidd')
          {       
            $colname = 'tl_product_image1';
            $replace_img = 'product.jpg';
          }

          try
          {
            $sql_update = DB::table('tbl_tl_product')->where('tl_product_id',$updateid)->update([
                $colname =>  $replace_img
              ]);

              return response()->json([
                  'status' => '200',
                  'msg' => 'Image removed successfully.'
              ]);
          }
          catch(Exception $e)
          {
            return response()->json([
                'status' => '401',
                'msg' => 'Something went wrong,Please try again later.'
            ]);
          }
          

        }
        else
        {
            return response()->json([
                'status' => '401',
                'msg' => 'Invalid Requests'
            ]);
        }
    }

    public function deleterowstatus(Request $request){
        if($request->isMethod('POST')){   
            $id = trim($request->id);
            $tblname = trim($request->tblname);
            $colwhere = trim($request->colwhere);
            $statuscol = trim($request->statuscol);
    
    
            if($id!=''){
             
                $sql = "UPDATE $tblname SET $statuscol = '2' WHERE $colwhere='$id'"; 
                $data = DB::select($sql);
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
                    'msg' => 'Something went wrong, please try again later'
                 ]);
              }
            }
        }
    }

}