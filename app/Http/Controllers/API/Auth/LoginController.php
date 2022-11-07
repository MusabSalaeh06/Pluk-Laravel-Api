<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
       // dd($request);
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
            if (Auth::guard('member')->attempt(['email'=>$request->email,'password'=>$request->password],
            )){
               //dd(Auth::guard('member')->user()->full_name);
                $user = Auth::guard('member')->user();
                return response()->json(
                    [
                        'status' => true,
                        'member_id' => $user->member_id,
                        //'data' => Auth::guard('member')->user(),
                        'data' => [
                                   'member_id' => $user->member_id,
                                   'full_name' => $user->name." ".$user->surname,
                        ],
                        'message' => "เข้าสู่ระบบสำเร็จ",
                    ], 200);
            }
            else {
                return response()->json(
                    [
                        'status' => false,
                        'data' => [],
                        'message' => "กรุณาทำการเข้าสู่ระบบใหม่ เนื่องอีเมลหรือรหัสผ่านไม่ถูกต้อง",
                    ], 200);
            }      
    }
}
