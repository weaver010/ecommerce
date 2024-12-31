<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminsRole;
use App\Models\User;
use Session;
use Auth;

class UserController extends Controller
{
    public function users(){
        Session::put('page','users');
        $users = User::orderBy('created_at','desc')->get()->toArray();
        /*dd($users);*/

        // Set Admin/Subadmins Permissions for Users
        $usersModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'users'])->count();
        $usersModule = array();
        if(Auth::guard('admin')->user()->type=="admin"){
            $usersModule['view_access'] = 1;
            $usersModule['edit_access'] = 1;
            $usersModule['full_access'] = 1;
        }else if($usersModuleCount==0){
            $message = "This feature is restricted for you!";
            return redirect('admin/dashboard')->with('error_message',$message);
        }else{
            $usersModule = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'users'])->first()->toArray();
        }

        return view('admin.users.users')->with(compact('users','usersModule'));
    }

    public function updateUserStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            User::where('_id',$data['user_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
        }
    }


}
