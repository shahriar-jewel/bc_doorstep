<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Mail\ForgetPassMail;
use App\Models\Userinfo;

class AuthController extends Controller
{
    public $errors = array(
        'username'  => '',
        'password'  => ''
    );

    public function __construct()
    {
        $this->errors = array(
            'username'      => '',
            'password'      => ''
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($this->isLoggedIn()===true){
            return redirect()->to('dashboard');
        }
        if (session()->has('errors')) {
            return view('auth.login');
        }
        if( $request->isMethod('post') ) {
            if( $this->_validateLogin($request)===true && ($user=$this->_checkUser($request))!==false  && $this->_checkPassword($request,$user)===true ){
                    unset($user['password']);
                    unset($user['forgetpasswordtoken']);
                    unset($user['remembermetoken']);
                    // session()->put('authorizedBranch',$this->_checkGroup($user) );
                    session()->put('doorstepuser', $user);
                    $this->lastActivity($request,$user['userid']);

                    // dd($user);

                    if ($request->input('remember') == '1' ) {
                        $this->_setCookie($user['userid']);
                    }                    
                    return redirect()->to('dashboard');
            }else{
                session()->flash('errors' , $this->errors);
                return redirect()->route('login');
            }
        }else{
            return view('auth.login');
        }
    }

    private function _validateLogin(Request $request)
    {
        $rules = array(
            "username"      => "required",
            "password"      => "required"
            );
        $validator = Validator::make($request->all(), $rules);
        $messages = $validator->messages();
        if($messages->has('username')){
            $this->errors['username'] = 'Username field is required.';
        }
        if($messages->has('password')){
            $this->errors['password'] = 'Password field is required.';
        }
        return ($validator->fails()) ? false : true;
    }

    private function _checkUser(Request $request)
    {
        $username = $request->input('username');
        $user = Userinfo::where('isactive', 1)
                    ->where(function($query) use ($username)
                    {
                        $query->where('email', '=', $username )
                              ->orwhere('contactno', $username );
                    })
                    ->first();
        if($user){
            return $user->toArray();
        }else{
            $this->errors['username'] = 'Username and Password mismatched.';
            return false;
        }
    }

    private function _checkPassword(Request $request,$user)
    {
        $inputPass = $request->input('password');
        if(Hash::check($inputPass, $user['password'])){
            return true;
        }else{
            $this->errors['password'] = 'Username and Password mismatched.';
            return false;
        }
    }

    public function forgetPassword(Request $request)
    {
        if( $request->isMethod('post') ) {
            $rules = array(
                "email"      => "required|email"
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()){            
                $errors = $validator->messages()->toArray();

                return  redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
            }

            $userInfo =  Userinfo::where('email','=',$request->input('email') )->first();
            if ($userInfo) {
                // $_token = base64_encode(random_bytes(10)); 
                $_token = str_random(30);
                $userInfo->forgetpasswordtoken = $_token;
                $userInfo->save();
                Mail::to($userInfo->email)->send(new ForgetPassMail($_token));
                
                session()->flash('message', 'Reset password link Successfully sent to your email ! Please check and reset your password !');
                session()->flash('class', '1');
                return  redirect()->back();
            }else{

                return  redirect()->back()->withErrors(['email' => "Email does not exist ! Please use your valid email!"]);
            }

        }else{
            return view('auth.forget_password');
        }
    }

    public function passwordReset(Request $request,$resetToken)
    {
        $userInfo = Userinfo::where('forgetpasswordtoken',$resetToken)->first();
        if ( $userInfo ) {
            if( $request->isMethod('post') ) 
            {
                $rules = array(
                    'password'              => 'required|min:4',
                    'password_confirmation' => 'min:4|same:password'
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails())
                {
                    $errors = $validator->messages()->toArray();

                    return  redirect()->back()
                                    ->withErrors($validator)
                                    ->withInput();
                }
                else
                {
                    // $userInfo = Userinfo::find($id);
                    $userInfo->password             = Hash::make($request->input('password'));
                    $userInfo->forgetpasswordtoken  = NULL ;
                    $userInfo->save();

                    session()->flash('message', 'Password Reset Successfully ! Please login !' );
                    session()->flash('class', '1' );
                    return redirect()->route('login') ;
                }
            }
            else
            {
                return view('auth.reset_password',compact('resetToken'));
            }
        }
        else
        {
            session()->flash('message', 'Your requested link is expired or you already reset your password !' );
            session()->flash('class', '2' );
            return redirect()->route('login');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function lastActivity(Request $request,$id)
    {
        $webuser = Userinfo::find($id);
        if ( $webuser ) {
            $webuser->lastactivetime      = date("Y-m-d H:i:s");
            $webuser->lastloginipaddress  = $request->ip();
            // $webuser->lastloginipaddress  = $this->get_client_ip();
            $webuser->save();
        }
    }

    

    public static function isLoggedIn()
    {
        return (session()->has('doorstepuser') || self::_checkCookie() ) ? true : false;
        // return (session()->has('doorstepuser')   ) ? true : false;
    }

    public static function _checkCookie()
    {
        if ( isset($_COOKIE['foodwebuser']) && $_COOKIE['foodwebuser'] !="" ) 
        {
            $webuserToken = $_COOKIE['foodwebuser'] ;
            $user = Userinfo::where('remembermetoken',$webuserToken)
                                ->where('isactive',1)->first()->toArray();
            if ( $user ){
                unset($user['password']);
                session()->put('doorstepuser', $user);
                return true;
            }
            else{   
                $this->processLogout();
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public function _setCookie($id)
    {
        $cookie_name = "foodwebuser";
        //expiriry time. 86400 = 1 day (86400*30 = 1 month)
        $expiry = time() + (86400 * 30);
        $cookie_value = Hash::make( $id.''.$expiry.''.str_random(16) );
        //setting cookie variable
        setcookie($cookie_name, $cookie_value, $expiry);
        //save the token to database
        $this->saveCookieValue($cookie_value,$id);
    }

    private function saveCookieValue($cookieValue,$id)
    {
        $webuser = Userinfo::find($id);
        if ( $webuser ) {
            $webuser->remembermetoken      = $cookieValue;
            $webuser->save();
        }
    }

    public function processLogout()
    {
        session()->flush();
        $cookie_name = "foodwebuser";
        $cookie_value = "";
        $expiry = time() - (86400 * 30);
        setcookie($cookie_name, $cookie_value, $expiry);
        return redirect()->route('login');
    }
}
