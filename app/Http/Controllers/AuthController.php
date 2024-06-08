<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\PasswordReset;
use Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;



class AuthController extends Controller
{
    public function loadRegister(){
        if(Auth::user() && Auth::user()->is_admin ==1){
            return redirect('/admin/dashboard');
        }
        else if(Auth::user() && Auth::user()->is_admin ==0 ){
            return redirect('/dashboard');
        }
        return view('register');
    }
    public function StudentRegister(Request $request){
        $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|email|required|max:100|unique:users',
            'password' => 'string|required|confirmed|min:6'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return back()->with('success','Your Registration has been sucessful');


    }

    public function loadlogin(){

        if(Auth::user() && Auth::user()->is_admin ==1){
            return redirect('/admin/dashboard');
        }
        else if(Auth::user() && Auth::user()->is_admin ==0 ){
            return redirect('/dashboard');
        }
        return view('login');
    }
    public function userlogin(Request $request){
        $request->validate([
            'email'=> 'string|required|email',
             'password' => 'string|required'
        ]);
       $userCredential = $request->only('email','password');
       if(Auth::attempt($userCredential)){
            if(Auth::user()->is_admin == 1){
                    return redirect('/admin/dashboard');
            }else{
                return redirect('/dashboard');
            }
       }else{
            return back() -> with('error','Username and password is incorrect');
       }
    }
    public function loadDashboard(){
        return view('student.studashboard');
    }
    public function adminDashboard(){
        $subjects =subject::all();
        return view('admin.dashboard',compact('subjects'));
    }
    public function logout(Request $request){
       $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
    public function forgetpasswordLoad(){
        return view('forget-password');
    }
    
    public function forgetpassword( Request $request){
        try{
          $user =  User::where('email',$request->email)->get();

          if(count($user)>0){
            $token = Str::random(40);
            $domain = URL::to('/');
           $url = $domain.'/reset-password?token='.$token;

           $data['url'] = $url;
           $data['email'] = $request->email;
           $data['title'] = 'password reset';
           $data['body'] = 'Please click on below lint to reset your password';

           Mail::send('forgetPasswordMail',['data'=>$data],function($message) use ($data){
            $message->to($data['email'])->subject($data['title']);
           }); 
           $dateTime = Carbon::now()->format('y-m-d h:i:s');
             
           PasswordReset::updateOrCreate(
            ['email'=>$request->email],
            ['email'=>$request->email,
            'token'=>$token,
            'created_at'=> $dateTime
            ]

           );
           return back()->with('success','please check your mail to reset your password ');
 
          }else{
            return back()->with('error','Email is not exitsts!');
          }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
    public function resetpasswordLoad(Request $request){

        $resetData = PasswordReset::where('token',$request->token)->get();

        if(isset($request->token) && count($resetData) > 0){

          $user=  User::where('email',$resetData[0]['email'])->get();

          return view('resetPassword',compact('user'));

        }else{
            return view('404');
        }
    }
    public function resetpassword(Request $request){
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);
        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email',$user->email)->delete();

        return " <h2> Your password had been reset successfully </h2>";
    }
}
