<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\AdminsRole;
use Session;
use Image;
use Auth;

class BannerController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        /*dd($banners); die;*/

        // Set Admin/Subadmins Permissions for Banners
        $bannersModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'banners'])->count();
        $bannersModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $bannersModule['view_access'] = 1;
            $bannersModule['edit_access'] = 1;
            $bannersModule['full_access'] = 1;
        }else if($bannersModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }else{
            $bannersModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'banners'])->first()->toArray();
        }

        return view('admin.banners.banners')->with(compact('banners','bannersModule'));
    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('_id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id){
        // Get Banner Image
        $bannerImage = Banner::where('_id',$id)->first();

        // Get Banner Image Path
        $banner_image_path = 'front/images/banner_images/';

        // Delete Banner Image if exists in Folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        // Delete Banner Image from banners table
        Banner::where('_id',$id)->delete();

        $message = "Banner deleted successfully!";
        return redirect('admin/banners')->with('success_message',$message);
    }

    public function addEditBanner(Request $request,$id=null){
        Session::put('page','banners');
        if($id==""){
            // Add Banner
            $title = "Add Banner";
            $banner = new Banner;
            $message = "Banner added successfully!";
        }else{
            // Edit Banner
            $title = "Edit Banner";
            $banner = Banner::find($id);
            $message = "Banner updated successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            if($id==""){
                $rules = [
                    'type' => 'required',
                    'banner_image' => 'required',
                ];    
                
                $customMessages = [
                    'type.required' => 'Banner Type is required',
                    'banner_image.required' => 'Banner Image is required',
                ];
                $this->validate($request,$rules,$customMessages);
            }

            // Upload Banner Image
            if($request->hasFile('banner_image')){
                $image_tmp = $request->file('banner_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $image_path = 'front/images/banners/'.$imageName;
                    // Upload the Banner Image
                    Image::make($image_tmp)->save($image_path);
                    $banner->image = $imageName;
                }
            }

            if(!isset($data['title'])){
                $data['title'] = "";
            }

            if(!isset($data['alt'])){
                $data['alt'] = "";
            }

            if(!isset($data['link'])){
                $data['link'] = "";
            }

            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->link = $data['link'];
            $banner->sort = $data['sort'];
            $banner->type = $data['type'];
            $banner->status = 1;
            $banner->save();
            return redirect('admin/banners')->with('success_message',$message);
        }
        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }



}
