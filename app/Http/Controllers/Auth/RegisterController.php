<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\member;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/login' ;

    public function __construct()
    {
        $this->middleware('guest');
    }
     

    protected function validator(array $data)
    {
        $validatorEmail = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
        ]);
        if ($validatorEmail->fails()) {
            redirect()->back()->with('error',"อีเมลที่ป้อนเข้ามา มีผู้ใช้เเล้ว กรุณากรอกอีเมลใหม่");
        }
        $validatorPass = Validator::make($data, [
            'password' => ['required','min:8','same:password_confirmation'],
        ]);
        if ($validatorPass->fails()) {
            redirect()->back()->with('error',"รหัสผ่านที่ยืนยันไม่ตรงกัน กรุณากรอกรหัสผ่านใหม่");
        }
        return Validator::make($data, [
            
            /*
            'gender' => ['required', 'string', 'max:30'],
            'tel' => ['required', 'string', 'max:10'],
            'birth_day' => ['required', 'string', 'max:30'],
            */
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:members'],
            'password' => ['required','min:8','same:password_confirmation'],
        ]);
        
    }
    public function create(array $data)
    {
       $post = new member;
       
       /*
       $post->gender = $data['gender'];
       $post->tel = $data['tel'];
       $post->birth_day = $data['birth_day'];
        */
       $post->name = $data['name'];
       $post->surname = $data['surname'];
       $post->email = $data['email'];
       $post->password = Hash::make($data['password']);
       $post->save();
       return $post;
    }
       //return redirect('/login');
        /**
        if ($data['user_status_id'] == 1) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:30'],
            'tell' => ['required', 'string', 'max:10'],
            'school_name' => ['required', 'string', 'max:255'],
            'school_Detail' => ['required', 'string', 'max:255'],
            'Address_hn' => ['required', 'string', 'max:10'],
            'Address_m' => ['required', 'string', 'max:255'],
            'Address_t' => ['required', 'string', 'max:255'],
            'Address_a' => ['required', 'string', 'max:255'],
            'Address_j' => ['required', 'string', 'max:255'],
            'Address_p' => ['required', 'string', 'max:6'],
            'school_tell' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
    if ($data['user_status_id'] == 2) {
        return Validator::make($data, [
            'name' => ['required', 'stringz', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'tell' => ['required', 'string', 'max:10'],
            'status' => [ 'required','string', 'max:50'],
            'manager_id' => ['max:10'],
            'card_id' => [ 'max:13'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tutors'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
    if ($data['user_status_id'] == 3) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'tell' => ['required', 'string', 'max:255'],
            'manager_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
         */

        /**
        if ($data['user_status_id'] == 1) {

       $post = new manager;
       $post->name = $data['name'];
       $post->surname = $data['surname'];
       $post->gender = $data['gender'];
       $post->tell = $data['tell'];
       $post->school_name = $data['school_name'];
       $post->school_Detail = $data['school_Detail'];
       $post->Address_hn = $data['Address_hn'];
       $post->Address_m =$data['Address_m'];
       $post->Address_t = $data['Address_t'];
       $post->Address_a = $data['Address_a'];
       $post->Address_j = $data['Address_j'];
       $post->Address_p = $data['Address_p'];
       $post->school_tell = $data['school_tell'];
       $post->email = $data['email'];
       $post->password = Hash::make($data['tell']);
       $post->user_status_id = $data['user_status_id'];
       $post->save();
       return redirect()->route('login');
        }

        else if ($data['user_status_id'] == 2)  {
            if ($data['status'] == "ไม่มีสังกัด") 
            {
                $post = new tutor;
                $post->name = $data['name'];
                $post->surname = $data['surname'];
                $post->gender = $data['gender'];
                $post->tell = $data['tell'];
                $post->status = $data['status'];
                $post->email = $data['email'];
                $post->password = Hash::make($data['tell']);
                $post->user_status_id = $data['user_status_id'];
            }
            else
            {
                $post = new tutor;
                $post->name = $data['name'];
                $post->surname = $data['surname'];
                $post->gender = $data['gender'];
                $post->tell = $data['tell'];
                $post->status = $data['status'];
                $post->manager_id = $data['manager_id'];
                $post->card_id = $data['card_id'];
                $post->email = $data['email'];
                $post->password = Hash::make($data['tell']);
                $post->user_status_id = $data['user_status_id'];
            }
           $post->save();
           return redirect()->route('login');
        }

        else if ($data['user_status_id'] == 3) {
            $post = new student;
            $post->name = $data['name'];
            $post->surname = $data['surname'];
            $post->gender = $data['gender'];
            $post->tell = $data['tell'];
            $post->manager_id = $data['manager_id'];
            $post->email = $data['email'];
            $post->password = Hash::make($data['tell']);
            $post->user_status_id = $data['user_status_id'];
            $post->save();
            return redirect()->route('login');
        }
        return redirect()->route('login');
         */

}
