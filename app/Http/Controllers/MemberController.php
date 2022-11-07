<?php

namespace App\Http\Controllers;

use App\course;
use App\course_category;
use App\enroll;
use App\group_org;
use App\member;
use App\my_job;
use App\my_school;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show_profile()
    {
        $profile=member::where('member_id',Auth::user()->member_id)->paginate();
        $data_school=my_school::where('member_id',Auth::user()->member_id)->paginate();
        if ($data_school->isEmpty()) { 
            $my_school = '';
        } else {
            $my_school = $data_school;
        }
        $data_job=my_job::where('member_id',Auth::user()->member_id)->paginate();
        if ($data_job->isEmpty()) { 
            $my_job = '';
        } else {
            $my_job = $data_job;
        }
        
        $co_my_org=group_org::where('org_owner',Auth::user()->member_id)->get()->count();
        $co_opc=course::where('course_owner',Auth::user()->member_id)->get()->count();
        $co_my_course=enroll::where('member_id',Auth::user()->member_id)->get()->count();
        $org_mjr_co=respond_req::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $org_mji_co=respond_inv::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        //dd($org_mji_co);
        $co_org_myjoin =  $org_mji_co + $org_mjr_co;
        $co_org_invite=org_invite::where('member_id',Auth::user()->member_id)->where('status',null)
        ->whereNotIn('org_id', respond_inv::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->whereNotIn('org_id', respond_req::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->get()->count();

        return view('member.profile',compact(['profile'],['co_my_org','co_opc','co_my_course','co_org_myjoin',
        'co_org_invite','my_job','my_school']));
    }

    public function edit_profile($member_id)
    {
        $data=member::find($member_id); 
    
        $co_my_org=group_org::where('org_owner',Auth::user()->member_id)->get()->count();
        $co_opc=course::where('course_owner',Auth::user()->member_id)->get()->count();
        $co_my_course=enroll::where('member_id',Auth::user()->member_id)->get()->count();
        $org_mjr_co=respond_req::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $org_mji_co=respond_inv::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        //dd($org_mji_co);
        $co_org_myjoin =  $org_mji_co + $org_mjr_co;
        $co_org_invite=org_invite::where('member_id',Auth::user()->member_id)->where('status',null)
        ->whereNotIn('org_id', respond_inv::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->whereNotIn('org_id', respond_req::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->get()->count();

        return view('member.edit_profile',compact(['data'],['co_my_org','co_opc','co_my_course',
        'co_org_myjoin','co_org_invite']));
    }

    public function update_profile(Request $request, $member_id)
    {   
            $request->validate([
                'email' =>'required','string', 'email', 'max:255', 'unique:managers',
            ]);
    
           $post = member::find($member_id);
           $post->name = $request->input('name');
           $post->surname = $request->input('surname');
           $post->gender = $request->input('gender');
           $post->tel = $request->input('tel');
           $post->birth_day = $request->input('birth_day');
           $post->card_id = $request->input('card_id');
           $post->county = $request->input('county');
           $post->road = $request->input('road');
           $post->alley = $request->input('alley');
           $post->house_number = $request->input('house_number');
           $post->group_no = $request->input('group_no');
           $post->sub_district = $request->input('sub_district');
           $post->district = $request->input('district'); 
           $post->province = $request->input('province');
           $post->ZIP_code = $request->input('ZIP_code');
           $post->email = $request->input('email');
    
           if   ($request->file('profile')) {
               $file=$request->file('profile');
               $fileN=$request->input('name');
               $filename = $fileN.'.'.$file->getClientOriginalExtension();
               $request->profile->move('storage/member/member_assets',$filename);
               $post->profile =$filename; 
           }
           $post->save();
       return redirect('/profile')->with('edit','ระบบได้แก้ไขข้อมูลโปรไฟล์ของคุณเรียบร้อยเเล้ว');
    }
    public function member_search(Request $request ,$org_id)
    {
        $data=group_org::find($org_id);
        $search = $request->get('search');  
        
        $member=member::where('member_id','!=',$data->org_owner)
        ->whereNotIn('member_id', respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->select('member_id'))
        ->whereNotIn('member_id', org_invite::where('org_id','=', $org_id )
        ->where('status',null)
        ->select('member_id'))
        ->whereNotIn('member_id', respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->select('member_id'))
        ->whereNotIn('member_id', org_request::where('org_id','=', $org_id )
        ->where('status',null)
        ->select('member_id'))
        ->where('name', 'like', '%'.$search.'%')
        ->paginate(10);

        $member_join = member::whereIn('member_id', respond_req::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->orwhereIn('member_id', respond_inv::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->where('name', 'like', '%'.$search.'%')
        ->paginate(10);

        $member_request = member::whereIn('member_id', org_request::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name', 'like', '%'.$search.'%')
        ->paginate(10);
        
        $member_invite = member::whereIn('member_id', org_invite::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name', 'like', '%'.$search.'%')
        ->paginate(10);   

        $member_owner = member::where('member_id','=',$data->org_owner)
        ->where('name', 'like', '%'.$search.'%')
        ->paginate(10);

        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->get()->count();
        $org_r_count=org_request::where('org_id',$org_id)->where('status',null)
        ->whereNotIn('member_id', respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->select('member_id'))
        ->whereNotIn('member_id', respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->select('member_id'))
        ->get()->count();

        $co_my_org=group_org::where('org_owner',Auth::user()->member_id)->get()->count();
        $co_opc=course::where('course_owner',Auth::user()->member_id)->get()->count();
        $co_my_course=enroll::where('member_id',Auth::user()->member_id)->get()->count();
        $org_mjr_co=respond_req::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $org_mji_co=respond_inv::where('member_id',Auth::user()->member_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        //dd($org_mji_co);
        $co_org_myjoin =  $org_mji_co + $org_mjr_co;
        $co_org_invite=org_invite::where('member_id',Auth::user()->member_id)->where('status',null)
        ->whereNotIn('org_id', respond_inv::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->whereNotIn('org_id', respond_req::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->get()->count();
        
        return view('pages.invite_org',compact(['member'],['data'],['mio_count'],['cio_count'],['org_r_count'],['member_join'],
        ['member_request'],['member_invite'],['member_owner'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    
    public function my_school(Request $request)
    {   

            $request->validate([
                'school_name' =>'required',
                'start' => 'required',
                'end' => 'required',
                'edu_level' => 'required',
                'fac_name' => 'required',
                'member_id' => 'required',
            ]);
            
           $post = new my_school;
           $post->school_name = $request->input('school_name');
           $post->start = $request->input('start');
           $post->end = $request->input('end');
           $post->edu_level = $request->input('edu_level');
           $post->fac_name = $request->input('fac_name');
           $post->member_id = $request->input('member_id');
           $post->save();

       return redirect('/profile')->with('status','ระบบได้เพิ่มข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }
    public function my_school_update(Request $request, $id)
    {   
            $request->validate([
                'school_name' =>'required',
                'start' => 'required',
                'end' => 'required',
                'edu_level' => 'required',
                'fac_name' => 'required',
                'member_id' => 'required',
            ]);
    
           $post = my_school::find($id);
           $post->school_name = $request->input('school_name');
           $post->start = $request->input('start');
           $post->end = $request->input('end');
           $post->edu_level = $request->input('edu_level');
           $post->fac_name = $request->input('fac_name');
           $post->member_id = $request->input('member_id');
           $post->save();
       return redirect('/profile')->with('edit','ระบบได้แก้ไขข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }
    public function my_school_destroy($id)
    {   my_school::destroy($id);
       return redirect('/profile')->with('destroy','ระบบได้ลบข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }

    public function my_job(Request $request)
    {   

           $post = new my_job;
           $post->wp_name = $request->input('wp_name');
           $post->start = $request->input('start');
           $post->end = $request->input('end');
           $post->job_title = $request->input('job_title');
           $post->member_id = $request->input('member_id');
           $post->save();


       return redirect('/profile')->with('status','ระบบได้เพิ่มข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
    public function my_job_update(Request $request, $id)
    {   
    
           $post = my_job::find($id);
           $post->wp_name = $request->input('wp_name');
           $post->start = $request->input('start');
           $post->end = $request->input('end');
           $post->job_title = $request->input('job_title');
           $post->member_id = $request->input('member_id');
           $post->save();

       return redirect('/profile')->with('edit','ระบบได้แก้ไขข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
    public function my_job_destroy($id)
    {   my_job::destroy($id);
       return redirect('/profile')->with('destroy','ระบบได้ลบข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
}
