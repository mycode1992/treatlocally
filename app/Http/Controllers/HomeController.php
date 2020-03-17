<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_tl_banner;    
use App\tbl_tl_howitwork;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;

class HomeController extends Controller
{
   
    public function index()
    {
        return view('home');
    }                
    public function managehomepage()
    {
        $session_all=Session::get('sessionadmin');

        if($session_all==false)
        {
            return Redirect::to('/tladminpanel');
            exit();
        } 

        $data = DB::table('tbl_tl_banner')->select('tl_banner_title','tl_banner_image')->where('tl_banner_id',1)->get();
        $data['howitworks'] = DB::table('tbl_tl_howitworks')->select('tl_howitworks_icon1','tl_howitworks_icon2','tl_howitworks_icon3','tl_howitworks_text1','tl_howitworks_text2','tl_howitworks_text3')->where('tl_howitworks_id',1)->get();
        $data = json_decode(json_encode($data), True);
        $data['howitworks'] = json_decode(json_encode($data['howitworks']), True);

        $data['merchant'] = DB::table('tbl_tl_merchant_of_month')->select('tl_merchant_of_month_title','tl_merchant_of_month_desp','tl_merchant_of_monthbgimg','tl_merchant_of_month_logo')->where('tl_merchant_of_month_id',1)->get();
        $data['merchant'] = json_decode(json_encode($data['merchant']), True);

        return view('tl_admin.managehomepage',compact('data'));
    }

    public function updatebanner(request $request)
    {
        if($request->isMethod('POST'))
        {
    
            date_default_timezone_set('Asia/Kolkata');
            $curDate = date("Y-m-d H:i:s"); 
            $ip_address =  \Request::ip(); 
            $banner_title = ucfirst(trim($request->banner_title));
            $banner_back_img = $request->file('banner_back_img');
    
            if($banner_back_img!="")
            {
                $extension = $banner_back_img->getClientOriginalExtension();
                $filename = $banner_back_img->getClientOriginalName();
                $filesize  =  $banner_back_img->getClientSize();
    
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
                $dir = public_path().'/tl_admin/upload/banner/';
                $orgfilename = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename;
                $upload_image = $banner_back_img->move($dir, $orgfilename);
                if($upload_image==false)
                {
                     return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }
            } // end if banner image not blank
         
        }   
      
            if($banner_back_img!="")
                {
                    $sql = tbl_tl_banner::where('tl_banner_id', 1)->update(['tl_banner_image' => $orgfilename, 'tl_banner_title' => $banner_title,'tl_banner_ip'=>$ip_address, 'tl_banner_update_at'=>$curDate]);

            } //end if
            else{
               $sql = tbl_tl_banner::where('tl_banner_id', 1)->update(['tl_banner_title' => $banner_title,'tl_banner_ip'=>$ip_address, 'tl_banner_update_at'=>$curDate]);
             } // end else
    
            if($sql==true)
            {
              return response()->json(
                [
                'status' =>'200',
                'msg' => 'Banner Updated Successfully!'
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

    // update_icon1 function starts
        
    public function update_icon1(Request $request){
        if($request->isMethod('POST'))
        {
    
            date_default_timezone_set('Asia/Kolkata');
            $curDate = date("Y-m-d H:i:s"); 
            $ip_address =  \Request::ip(); 
            $text1desc = addslashes($request->text1desc);
            $icon1_img = $request->file('icon1_img');
    
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
                    $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                             ->update(['tl_howitworks_icon1' => $orgfilename, 'tl_howitworks_text1' => $text1desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
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
                    $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                    ->update(['tl_howitworks_text1' => $text1desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
                    
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

 // update_icon1 function ends

 // update_icon2 function starts
        
 public function update_icon2(Request $request){
    if($request->isMethod('POST'))
    {

        date_default_timezone_set('Asia/Kolkata');
        $curDate = date("Y-m-d H:i:s"); 
        $ip_address =  \Request::ip(); 
        $text2desc = addslashes($request->text2desc);
        $icon2_img = $request->file('icon2_img');

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
                $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                         ->update(['tl_howitworks_icon2' => $orgfilename, 'tl_howitworks_text2' => $text2desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
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
                $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                ->update(['tl_howitworks_text2' => $text2desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
                
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

// update_icon3 function ends

 public function update_icon3(Request $request){
    if($request->isMethod('POST'))
    {

        date_default_timezone_set('Asia/Kolkata');
        $curDate = date("Y-m-d H:i:s"); 
        $ip_address =  \Request::ip(); 
        $text3desc = addslashes($request->text3desc);
        $icon3_img = $request->file('icon3_img');

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
                $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                         ->update(['tl_howitworks_icon3' => $orgfilename, 'tl_howitworks_text3' => $text3desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
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
                $sql = tbl_tl_howitwork::where('tl_howitworks_id', 1)
                ->update(['tl_howitworks_text3' => $text3desc,'tl_howitworks_ip'=>$ip_address, 'tl_howitworks_update_at'=>$curDate]);
                
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

// update_icon3 function ends

// update_merchant function starts

public function update_merchant(Request $request){
    if($request->isMethod('POST'))
    {

        date_default_timezone_set('Asia/Kolkata');
        $curDate = date("Y-m-d H:i:s"); 
        $ip_address =  \Request::ip(); 
        $merchant_desc = addslashes($request->merchant_desc);
        $merchant_bgimage = $request->file('merchant_bgimage');
        $merchant_logo = '';    
        $merchant_title = $request->merchant_title;

        if($merchant_bgimage!="" || $merchant_logo!="")
        {
            if($merchant_bgimage!=""){
                $extension_bgimage = $merchant_bgimage->getClientOriginalExtension();
                $filename_bgimage = $merchant_bgimage->getClientOriginalName();
                $filesize_bgimage  =  $merchant_bgimage->getClientSize();

                if($filesize_bgimage>='2048000')
                    {
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Image size should be less than 2mb'
                            ]);
                    }
                    if($extension_bgimage!='jpg' && $extension_bgimage!='jpeg' && $extension_bgimage!='png')
                    {
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Upload only jpeg,jpg or png file'
                            ]);
                    }
                    $dir = public_path().'/tl_admin/upload/merchant-of-month/';
                    $orgfilename_bgimage = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename_bgimage;
                    $upload_bgimage = $merchant_bgimage->move($dir, $orgfilename_bgimage);
                    
                    if($upload_bgimage==false)
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }
                else{

                      try
                      {
                         $sql=DB::table('tbl_tl_merchant_of_month')
                         ->where('tl_merchant_of_month_id', '=', 1)
                         ->update([
                             'tl_merchant_of_month_title' => $merchant_title,
                             'tl_merchant_of_month_desp' => $merchant_desc,
                             'tl_merchant_of_monthbgimg' => $orgfilename_bgimage,
                             'tl_merchant_of_month_ip' => $ip_address,
                             'tl_merchant_of_month_updated_at' => $curDate,
                         ]);

                          return response()->json(
                             [
                             'status' =>'200',
                             'msg' => 'merchant of month  updated successfully!'
                             ]);  
                      }
                      catch(Exceptoin $e)
                      {
                            return response()->json(
                             [
                             'status' =>'401',
                             'msg' => 'Something went wrong,please try again'
                             ]);
                      }
             }
            }
            if($merchant_logo!=""){
                $extension_logo = $merchant_logo->getClientOriginalExtension();
                $filename_logo = $merchant_logo->getClientOriginalName();
                $filesize_logo  =  $merchant_logo->getClientSize();
                if($filesize_logo>='2048000')
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Image size should be less than 2mb'
                        ]);
                }
                if($extension_logo!='jpg' && $extension_logo!='jpeg' && $extension_logo!='png')
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Upload only jpeg,jpg or png file'
                        ]);
                }
                $dir = public_path().'/tl_admin/upload/merchant-of-month/';
                $orgfilename_logo = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename_logo;
                $upload_logo = $merchant_logo->move($dir, $orgfilename_logo);
                if($upload_logo==false)
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }
                else{
                         $sql=DB::table('tbl_tl_merchant_of_month')
                         ->where('tl_merchant_of_month_id', '=', 1)
                         ->update([
                             'tl_merchant_of_month_title' => $merchant_title,
                             'tl_merchant_of_month_desp' => $merchant_desc,
                             'tl_merchant_of_month_logo' => $orgfilename_logo,
                             'tl_merchant_of_month_ip' => $ip_address,
                             'tl_merchant_of_month_updated_at' => $curDate,
                         ]);
                         if($sql==true)
                         {
                         return response()->json(
                             [
                             'status' =>'200',
                             'msg' => 'merchant of month  Updated Successfully!'
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
            }
           
           
            
            
        } // end if banner image not blank


        if($merchant_bgimage!="" && $merchant_logo!="")
        {
          
                $extension_bgimage = $merchant_bgimage->getClientOriginalExtension();
                $filename_bgimage = $merchant_bgimage->getClientOriginalName();
                $filesize_bgimage  =  $merchant_bgimage->getClientSize();
                $extension_logo = $merchant_logo->getClientOriginalExtension();
                $filename_logo = $merchant_logo->getClientOriginalName();
                $filesize_logo  =  $merchant_logo->getClientSize();

        

                if($filesize_bgimage>='2048000' && $filesize_logo>='2048000')
                    {
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Image size should be less than 2mb'
                            ]);
                    }
                    if( ($extension_bgimage!='jpg' && $extension_bgimage!='jpeg' && $extension_bgimage!='png') && ($extension_logo!='jpg' && $extension_logo!='jpeg' && $extension_logo!='png') )
                    {
                        return response()->json(
                            [
                            'status' =>'401',
                            'msg' => 'Upload only jpeg,jpg or png file'
                            ]);
                    }
                    $dir = public_path().'/tl_admin/upload/merchant-of-month/';
                    $orgfilename_bgimage = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename_bgimage;
                    $upload_bgimage = $merchant_bgimage->move($dir, $orgfilename_bgimage);
                   
                    $orgfilename_logo = uniqid().'_'.time().'_'.date('Ymd').'.'.$filename_logo;
                    $upload_logo = $merchant_logo->move($dir, $orgfilename_logo);
                    if($upload_bgimage==false && $upload_logo==false)
                {
                    return response()->json(
                        [
                        'status' =>'401',
                        'msg' => 'Unable to upload image, please try again'
                        ]);
                }
                else{
                         $sql=DB::table('tbl_tl_merchant_of_month')
                         ->where('tl_merchant_of_month_id', '=', 1)
                         ->update([
                             'tl_merchant_of_month_title' => $merchant_title,
                             'tl_merchant_of_month_desp' => $merchant_desc,
                             'tl_merchant_of_monthbgimg' => $orgfilename_bgimage,
                             'tl_merchant_of_month_logo' => $orgfilename_logo,
                             'tl_merchant_of_month_ip' => $ip_address,
                             'tl_merchant_of_month_updated_at' => $curDate,
                         ]);
                         if($sql==true)
                         {
                         return response()->json(
                             [
                             'status' =>'200',
                             'msg' => 'merchant of month  Updated Successfully!'
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
     
  
        if($merchant_bgimage == "" && $merchant_logo == "")
        {
            $sql=DB::table('tbl_tl_merchant_of_month')
            ->where('tl_merchant_of_month_id', '=', 1)
            ->update([
                'tl_merchant_of_month_title' => $merchant_title,
                'tl_merchant_of_month_desp' => $merchant_desc,
                'tl_merchant_of_month_ip' => $ip_address,
                'tl_merchant_of_month_updated_at' => $curDate,
            ]);
            if($sql==true)
            {
            return response()->json(
                [
                'status' =>'200',
                'msg' => 'merchant of month  Updated Successfully!'
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
                              
        } // end if banner image not blank

    }   
}

// update_merchant function ends

   
        
       
    
   
}
