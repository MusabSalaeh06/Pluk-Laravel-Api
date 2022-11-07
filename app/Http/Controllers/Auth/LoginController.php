<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:member')->except('logout');
        /**
        $this->middleware('guest:tutor')->except('logout');
        $this->middleware('guest:student')->except('logout');
        $this->middleware('guest:manager')->except('logout');
         */
    }
    public function login(Request $request){
        //dd($request);
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        
            if (Auth::guard('member')->attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember'))){
                return redirect()->route('index');
            }
            /**
            elseif (Auth::guard('manager')->attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember'))){
                return redirect()->route('manager');
            }
            elseif (Auth::guard('tutor')->attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember'))){
                return redirect()->route('tutor');
            }
            elseif (Auth::guard('student')->attempt(['email'=>$request->email,'password'=>$request->password],$request->get('remember'))){
                return redirect()->route('student');
            } 
            */
            else {
                return redirect()->route('login')->with('error', 'อีเมลหรือรหัสผ่านไม่ถูกต้อง!');
            }      
    }
}
