<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\AdminsRole;
use Validator;
use Session;
use Image;
use Auth;

class BrandController extends Controller
{
    public function brands(){
        Session::put('page','brands');
        $brands = Brand::get();
        /*$brands = json_decode(json_encode($brands));
        echo "<pre>"; print_r($brands); die;*/

        // Set Admin/Subadmins Permissions for Brands
        $brandsModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'brands'])->count();
        $brandsModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $brandsModule['view_access'] = 1;
            $brandsModule['edit_access'] = 1;
            $brandsModule['full_access'] = 1;
        }else if($brandsModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }else{
            $brandsModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'brands'])->first()->toArray();
        }

    return view('admin.brands.brands')->with(compact('brands','brandsModule'));
    }

    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('_id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id){
        // Delete Brand
        Brand::where('_id',$id)->delete();
        return redirect()->back()->with('success_message','Brand deleted successfully!');
    }

    public function addEditBrand(Request $request,$id=null){
        Session::put('page','brands');
        if($id==""){
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand added successfully!";
        }else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            if($id==""){
                $rules = [
                    'brand_name' => 'required',
                    'url' => 'required|unique:brands',
                ];    
            }else{
                $rules = [
                    'brand_name' => 'required',
                    'url' => 'required',
                ];     
            }

            $customMessages = [
                'brand_name.required' => 'Brand Name is required',
                'url.required' => 'Brand URL is required',
                'url.unique' => 'Unique Brand URL is required',
            ];

            $request->validate($rules,$customMessages);

            // Upload Brand Image
            if($request->hasFile('brand_image')){
                $image_tmp = $request->file('brand_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $image_path = 'front/images/brands/'.$imageName;
                    // Upload the Brand Image
                    Image::make($image_tmp)->save($image_path);
                    $brand->brand_image = $imageName;
                }
            }

            // Upload Brand Logo
            if($request->hasFile('brand_logo')){
                $image_tmp = $request->file('brand_logo');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $image_path = 'front/images/brands/'.$imageName;
                    // Upload the Brand Image
                    Image::make($image_tmp)->save($image_path);
                    $brand->brand_logo = $imageName;
                }
            }

            // Remove Brand Discount from all products belongs to the specific Brand
            if(empty($data['brand_discount'])){
                $data['brand_discount'] = 0;
                if($id!=""){
                    $brandProducts = Product::where('brand_id',$id)->get()->toArray();
                    foreach ($brandProducts as $key => $product) {
                        /*echo "<pre>"; echo "<pre>"; print_r($product); die;*/
                        if($product['discount_type']=="brand"){
                            Product::where('id',$product['id'])->update(['discount_type'=>'','final_price'=>$product['product_price']]);    
                        }
                    }
                }
            }

            $brand->brand_name = $data['brand_name'];
            $brand->brand_discount = $data['brand_discount'];
            $brand->description = $data['description'];
            $brand->url = $data['url'];
            $brand->meta_title = $data['meta_title'];
            $brand->meta_description = $data['meta_description'];
            $brand->meta_keywords = $data['meta_keywords'];
            $brand->status = 1;
            $brand->save();
            return redirect('admin/brands')->with('success_message',$message);
        }

        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));
    }

    public function deleteBrandImage($id){
        // Get Brand Image
        $brandImage = Brand::select('brand_image')->where('_id',$id)->first();

        // Get Brand Image Path
        $brand_image_path = 'front/images/brands/';

        // Delete Brand Image from brands folder if exists
        if(file_exists($brand_image_path.$brandImage->brand_image)){
            unlink($brand_image_path.$brandImage->brand_image);
        }

        // Delete Brand Image from brands table
        Brand::where('_id',$id)->update(['brand_image'=>'']);

        return redirect()->back()->with('success_message','Brand image deleted successfully!');
    }

    public function deleteBrandLogo($id){
        // Get Brand Logo
        $brandLogo = Brand::select('brand_logo')->where('_id',$id)->first();

        // Get Brand Image Path
        $brand_logo_path = 'front/images/brands/';

        // Delete Brand Image from brands folder if exists
        if(file_exists($brand_logo_path.$brandLogo->brand_logo)){
            unlink($brand_logo_path.$brandLogo->brand_logo);
        }

        // Delete Brand Image from brands table
        Brand::where('_id',$id)->update(['brand_logo'=>'']);

        return redirect()->back()->with('success_message','Brand logo deleted successfully!');
    }

}
