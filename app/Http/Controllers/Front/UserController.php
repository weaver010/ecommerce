<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Country;
use Validator;
use Session;
use Hash;
use Auth;

class UserController extends Controller
{

    public function registerUser(Request $request){
        if($request->ajax()){
            
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'mobile'=>'required|numeric|digits:10',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6'
            ],
            [
                'email.regex'=>'This email is not a valid email address'
            ]);

            if($validator->passes()) {

                $data = $request->all();
                /*echo "<pre>"; print_r($data); die;*/

                // Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                /* Activate the user only when user confirms his email account */

                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation',$messageData,function($message)use($email){
                    $message->to($email)->subject('Confirm your SiteMakers.in Account');
                });

                // Redirect back user with success message
                $redirectTo = url('user/register');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Please confirm your email to activate your account!']);


                /*// Send Register Email
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                Mail::send('emails.register',$messageData,function($message) use($email){
                        $message->to($email)->subject('Registration with E-commerce Website');
                 });

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    // Update User Cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectUrl = url('cart');
                    return response()->json(['status'=>true,'type'=>'success','redirectUrl'=>$redirectUrl]);
                }*/
           
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
        return view('front.users.register');
    }

    public function logoutUser(){
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                // Redirect the user to Login Page with error message
                return redirect('user/login')->with('error_message','Your account is already activated. You can login now.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                // Send Welcome Email
                $messageData = ['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Welcome to SiteMakers.in');
                });

                // Redirect the user to Login Page with success message
                return redirect('user/login')->with('success_message','Your account is activated. You can login now.');

            }
        }else{
            abort(404);
        }
    }

    public function loginUser(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6'
                ]
            );

            if($validator->passes()){
                
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    
                    if(Auth::user()->status ==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>"Your account is deactivated by system administrator"]);
                    }

                    // Remember User Email and Password
                    if(!empty($data["remember-me"])) {
                        setcookie ("user-email",$data["email"],time()+ 3600);
                        setcookie ("user-password",$data["password"],time()+ 3600);
                        /*echo "Cookies Set Successfuly";*/
                    } else {
                        setcookie("user-email","");
                        setcookie("user-password","");
                        /*echo "Cookies Not Set";*/
                    }

                    // Update User Cart with user id 
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>"You have entered wrong email or password!"]);
                }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
            
        }
        return view('front.users.login');
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                    'email' => 'required|email|max:150|exists:users'
                ],
                [
                    'email.exists'=>'Email does not exists!'
                ]
            );

            if($validator->passes()){

                /* Send Email to User to Reset his Password */
                $email = $data['email'];
                $messageData = ['email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.reset_password',$messageData,function($message)use($email){
                    $message->to($email)->subject('Reset your Password - SiteMakers.in');
                });

                // Show Success Message
                return response()->json(['type'=>'success','message'=>'Reset Password link sent to your registered email.']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            return view('front.users.forgot_password');    
        }    
    }

    public function resetPassword(Request $request,$code=null){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6'
                ]
            );

            if($validator->passes()){

                $email = base64_decode($data['code']);
                $userCount = User::where('email',$email)->count();
                if($userCount>0){
                    // Update New Password
                    User::where('email',$email)->update(['password'=>bcrypt($data['password'])]);

                    // Send Confirmation Email to User
                    $messageData = ['email'=>$email];
                    Mail::send('emails.user_new_password',$messageData,function($message) use($email){
                        $message->to($email)->subject('Password Updated - SiteMakers.in');
                    });

                    // Show success message
                    return response()->json(['type'=>'success','message'=>'Password reset for your account. You can login now.']);

                }else{
                    abort(404);
                }

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }    

        }else{
            return view('front.users.reset_password')->with(compact('code'));
        }
    }

    public function account(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'address' => 'required|string|max:100',
                'pincode' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:10'
            ]
        );

            if($validator->passes()){

                // Update User Details
                User::where('_id',Auth::user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                // Redirect back user with success message
                $redirectTo = url('user/account');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'User details successfully updated!']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
            
        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.account')->with(compact('countries'));
        }

    }

    public function changePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:new_password'

                ]
            );

            if($validator->passes()){

                $current_password = $data['current_password'];
                $checkPassword = User::where('_id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){

                    // Update User Current Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Account password successfully updated!']);

                }else{
                    // Redirect back user with error message
                    return response()->json(['type'=>'incorrect','message'=>'Your current password is incorrect!']);    
                }


                // Redirect back user with success message
                return response()->json(['type'=>'success','message'=>'Your contact/billing details successfully updated!']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.change_password')->with(compact('countries'));
        }
    }

}
