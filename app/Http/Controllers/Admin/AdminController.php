<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminsRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\User;
use Validator;
use Session;
use Auth;
use Hash;
use Image;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        /*echo "<pre>"; print_r(Auth::guard('admin')->user()); die;*/
        $categoriesCount = Category::get()->count();
        $productsCount = Product::get()->count();
        $brandsCount = Brand::get()->count();
        $usersCount = User::get()->count();
        return view('admin.dashboard')->with(compact('categoriesCount','productsCount','brandsCount','usersCount'));
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                // Add custom messages here
                'email.required' => 'Email is required!',
                'email.email' => 'Valid Email is required!',
                'password.required' => 'Password is required!',
            ];

            $request->validate($rules,$customMessages);


            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){

                if(!empty($_POST['remember'])){
                    // Cookies set successfully
                    setcookie("email",$_POST['email'],time()+3600);
                    setcookie("password",$_POST['password'],time()+3600);
                }else{
                    // Cookies Not set
                    setcookie("email","");
                    setcookie("password","");
                }

                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password!');
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword(Request $request){
        if(Auth::guard('admin')->user()->type!="admin"){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','update-password');
        if($request->isMethod('post')){
            $data = $request->input();
            /*cho "<pre>"; print_r($data); die;*/
            // Check if Current Password is correct
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                // Check if new password and confirm password is same
                if($data['new_pwd']==$data['confirm_pwd']){
                    Admin::where('email',Auth::guard('admin')->user()->email)->update(['password'=>bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message','Password has been updated successfully!');
                }else{
                    return redirect()->back()->with('error_message','New Password and Confirm Password not match!');
                }
            }else{
                return redirect()->back()->with('error_message','Your current password is Incorrect!');
            }
        }
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        if(Auth::guard('admin')->user()->type!="admin"){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
            'admin_name' => 'required|alpha',
            'admin_mobile' => 'required|numeric',
            ];
            $customMessages = [
            //Add custom Messages here
            'admin_name.required' => 'Name is required',
            'admin_name.alpha' => 'Valid Name is required',
            'admin_mobile.required' => 'Mobile is required',
            'admin_mobile.numeric' => 'Valid Mobile is required',
            ];

            $request->validate($rules,$customMessages);

            // Upload Image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $fileName = rand(111,99999).'.'.$extension;
                    $banner_path = 'admin/images/photos/'.$fileName;
                    Image::make($image_tmp)->save($banner_path);
                }
            }else if(!empty($data['current_image'])){
                $fileName = $data['current_image'];
            }else{
                $fileName = '';
            }

            // Update admin details
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$fileName]);

            return redirect()->back()->with('success_message','Admin details updated successfully!');
    }
    return view('admin.update_admin_details');
        return view('admin.update_admin_details');
    }

    public function subadmins(){
        if(Auth::guard('admin')->user()->type!="admin"){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }
        Session::put('page','subadmins');
        $subadmins = Admin::where('type','subadmin')->get();
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }

    public function updateSubadminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('_id',$data['subadmin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'subadmin_id'=>$data['subadmin_id']]);
        }
    }

    public function deleteSubadmin($id){
        // Delete Admin/Sub-Admin
        Admin::where('_id',$id)->delete();
        return redirect()->back()->with('success_message', 'Subadmin has been deleted successfully');
    }

    public function addEditSubadmin(Request $request,$id=null){
        if($id==""){
            $title = "Add Subadmin";
            $subadmindata = new Admin;
            $message = "Subadmin added successfully!";
        }else{
            $title = "Edit Subadmin";
            $subadmindata = Admin::find($id);
            /*echo "<pre>"; print_r($subadmindata); die;*/
            $message = "Subadmin updated successfully!";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($id==""){
                $subadminCount = Admin::where('email',$data['subadmin_email'])->count();
                if($subadminCount>0){
                    Session::flash('error_message','Sub-Admin already exists!');
                    return redirect('admin/subadmins');
                }
            }
            $rules = [
                'subadmin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'subadmin_mobile' => 'required|numeric',
                'subadmin_image' => 'image',
            ];
            $customMessages = [
                'subadmin_name.required' => 'Name is required',
                'subadmin_name.regex' => 'Valid Name is required',
                'subadmin_mobile.required' => 'Mobile is required',
                'subadmin_image.image' => 'Valid Image is required',
            ];
            $request->validate($rules,$customMessages);

            // Upload Image
            if($request->hasFile('subadmin_image')){
                $image_tmp = $request->file('subadmin_image');
                if($image_tmp->isValid()){
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    // Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_subadmin_image'])){
                $imageName = $data['current_subadmin_image'];
            }else{
                $imageName = "";
            }
            
            $subadmindata->image = $imageName;
            $subadmindata->name = $data['subadmin_name'];
            $subadmindata->mobile = $data['subadmin_mobile'];
            if($id==""){
                $subadmindata->email = $data['subadmin_email'];    
                $subadmindata->type = "subadmin";   
            }
            if($data['subadmin_password']!=""){
                $subadmindata->password = bcrypt($data['subadmin_password']);
            }
            $subadmindata->save();

            session::flash('success_message',$message);
            return redirect('admin/subadmins');
        }

        return view('admin.subadmins.add_edit_subadmin')->with(compact('title','subadmindata'));
    }

    public function updateRole($id,Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            AdminsRole::where('subadmin_id',$data['subadmin_id'])->delete();

            foreach ($data as $key => $value) {

                if(isset($value['view'])){
                    $view = $value['view'];
                }else{
                    $view = 0;
                }
                if(isset($value['edit'])){
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }
                if(isset($value['full'])){
                    $full = $value['full'];
                }else{
                    $full = 0;
                }

                $adminsRoleCount = AdminsRole::where(['subadmin_id'=>$data['subadmin_id'],'module'=>$key])->count();
                if($adminsRoleCount>0){
                    AdminsRole::where('subadmin_id',$data['subadmin_id'])->update(['module'=>$key,'view_access'=>$view,'edit_access'=>$edit,'full_access'=>$full]);    
                }else{
                    $role = new AdminsRole;
                    $role->subadmin_id = $data['subadmin_id'];
                    $role->module = $key;
                    $role->view_access = $view;
                    $role->edit_access = $edit;
                    $role->full_access = $full;
                    $role->save();
                }
            }

            $message = "Subadmins Roles Updated Successfully!";
            return redirect()->back()->with('success_message',$message);
        }

        $subadminRoles = AdminsRole::where('subadmin_id',$id)->get()->toArray();
        $subadminDetails = Admin::where('_id',$id)->first()->toArray();
        $title = "Update ".$subadminDetails['name']." Subadmin Roles/Permissions";
        return view('admin.subadmins.update_roles')->with(compact('title','id','subadminRoles'));
    }


}
