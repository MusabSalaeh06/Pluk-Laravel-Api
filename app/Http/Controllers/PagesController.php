<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\course;
use App\course_category;
use App\manager;
use App\student;
use App\tutor;
use App\user_status;
use App\lesson;
use App\member;
use App\group_org;
use App\org_invite;
use App\respond_inv;
use App\org_request;
use App\respond_req;
use App\link_youtube;
use App\link_Gdrive;
use App\document;
use App\video;
use App\image;
use App\enroll;
use App\note;
use App\quiz;
use App\quiz_answer;
use App\quiz_header;
use App\set_quiz;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
   
public function index()
{
    //$course = course::where('course_status',"เผยแพร่")->paginate(6);
    $course = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
                   ->whereIn('course_id', course::where('course_status',"เผยแพร่")->select('id'))  
                   ->where('enroll_type','!=',"องค์กร")
                   ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")        
                   ->groupBy('course_id')
                   ->paginate();
    $course_ne = course::whereNotIn('id', enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
                   ->where('enroll_type','!=',"องค์กร") 
                   ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")     
                   ->groupBy('course_id')->select('course_id'))  
                   ->where('course_status',"เผยแพร่")
                   ->where('course_owner','!=',Auth::user()->member_id)  
                   ->paginate(); 
                   
                   //dd($course_ne);
    $co_course = course::where('course_status',"เผยแพร่")->get()->count();

    $my_course = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id','status') 
    ->where('enroll_type','!=',"องค์กร")  
    ->where('member_id',Auth::user()->member_id)  
    ->whereIn('course_id', enroll::where('member_id',Auth::user()->member_id)->select('course_id'))   
    ->groupBy('course_id','status')
    ->paginate();
    $my_course_co=enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
    ->where('enroll_type','!=',"องค์กร")  
    ->whereIn('course_id', enroll::where('member_id',Auth::user()->member_id)->select('course_id'))   
    ->groupBy('course_id')
    ->get()->count();
    

    $co_courses = course::where('course_status',"เผยแพร่")->get()->count();

    
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

    return view('dashboard',compact(['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite','co_courses'
    ,'course','course_ne','co_course','my_course','my_course_co',]));
}
    public function page_search()
    {
        $cc=course_category::all();
        $cc = course_category::paginate(10);        
    
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
        
        return view('pages.page_search',compact(['cc'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function my_opencourse()
    {
        $opc=course::where('course_owner',Auth::user()->member_id)
        ->paginate(10);
        $cc = course_category::paginate(10);   
    
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

        $course_enr = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
        ->where('enroll_type','!=',"องค์กร")
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        ->groupBy('course_id')
        ->get();
        
        return view('pages.my_opencourse',compact(['opc'],['co_my_org','co_opc','co_my_course','co_org_myjoin',
        'co_org_invite','course_enr']));
    }
    public function course_index(Request $request, $id)
    {
        
        $data=course::find($id);
        $course_edit = '';

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

        $Renroll_count = enroll::where('course_id',$id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$id)
            ->where('lesson_status',"เผยแพร่")
            ->get()->count();
        }
        if ( $request->input('org_id') == null) {
            $data_org='';
            return view('pages.course_index',compact(['data_org','data','course_edit','lesson_count','Penroll_count','Renroll_count'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        } else {
            $data_org=group_org::find($request->input('org_id'));
            return view('pages.course_index',compact(['data_org','data','course_edit','lesson_count','Penroll_count','Renroll_count'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }
        
    }

    public function course_detail(Request $request, $id)
    {
        $enroll = '';
        $org_data ='';
        $data=course::find($id);
        $lesson=lesson::where('id',$id)->get();

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
        
        return view('course.course_detail',compact(['lesson'],['data'],['enroll'],['org_data'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function course_detail_org(Request $request, $enroll_id)
    {
        $enroll = enroll::find($enroll_id);
        $data=course::find($enroll->course_id);
        $lesson=lesson::where('id',$enroll->course_id)->get();
        if ($enroll->org_id == null) {
            $org_data='';
        } else {
            $org_data=group_org::find($enroll->org_id);
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
        
        return view('course.course_detail',compact(['lesson'],['data'],['org_data'],['enroll'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function manage_lesson($id)
    {
        $data = course::find($id);
        if ($data->course_owner == Auth::user()->member_id){
            $lesson = lesson::where('id',$id)->paginate(10);
        }
        else{
            $lesson = lesson::where('id',$id)->where('lesson_status',"เผยแพร่")->paginate(10);
        }
        $Renroll_count = enroll::where('course_id',$id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.manage_lesson',compact(['lesson'],['data'],['lesson_count'],['Renroll_count'],['Penroll_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function lesson_page($lesson_id)
    {
        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';

        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.lesson_page',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['Penroll_count'],['lesson_count'],['Renroll_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function my_course()
    {
        $cc = course_category::all();
        $my_course=enroll::where('member_id',Auth::user()->member_id)->paginate(10);
        
        // $my_course_org = DB::table('enrolls')
        // ->select('enrolls.*')
        //     ->join('group_orgs','group_orgs.org_id','=','enrolls.org_id')
        //     ->join('members','members.member_id','=','enrolls.member_id')
        //     ->where('enrolls.enroll_type','องค์กร')
        //     ->whereIn('enrolls.enroll_id', enroll::where('enrolls.member_id',Auth::user()->member_id)
        //     ->where('enrolls.enroll_type','สมาชิกองค์กร')
        //     ->select('enrolls.enroll_id'))
        //     ->get();

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

            $course_enr = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
            ->where('enroll_type','!=',"องค์กร")
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
            ->groupBy('course_id')
            ->get();

        return view('pages.my_course',compact(['my_course','cc','course_enr'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function learning_page($lesson_id)
    {
        $lesson = lesson::find($lesson_id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $note = note::where('lesson_id',$lesson->lesson_id)->where('creator',Auth::user()->member_id)->paginate();
        $data = course::find($lesson->id);
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
        /*
        **/
        $enrolll = enroll::where('member_id','=',Auth::user()->member_id)->where('course_id','=',$data->id)->first();
       //dd($enrolll);
        if ($enrolll == null) {
            $enroll_org = '';
        } else {
            $enroll_org = $enrolll->org_id;
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
        
        //dd($enroll_org);
        return view('pages.learning_page',compact(['lesson'],['enroll_org'],['lesson_all'],['lesson_null'],['data']
        ,['link_y'],['link_g'],['document'],['video'],['image'],['note'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    /** ********************************************************************* Note บันทึกย่อ ********************************************* */
    public function page_send_note($lesson_id)
    {
        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $note = note::where('lesson_id',$lesson->lesson_id)->where('org_id',null)->paginate(10);
        $send_note = note::where('lesson_id',$lesson->lesson_id)->where('org_id',null)->get()->count();
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';

        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.page_send_note',compact(['lesson'],['data'],['note'],['send_note'],['lesson_all'],['lesson_null']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'], ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function page_send_note_org($lesson_id)
    {
        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $enroll = enroll::where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->where('course_id',$data->id)->where('member_id',null)->paginate(10);
        $num_enroll = enroll::where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->where('course_id',$data->id)->where('member_id',null)->get()->count();
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';

        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.page_send_note_org',compact(['lesson'],['data'],['num_enroll'],['enroll'],['lesson_all'],['lesson_null']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function note_member_in_org(Request $request, $lesson_id)
    {
       
        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $data_org = group_org::find($request->input('org_id'));
        $note = note::where('lesson_id',$lesson->lesson_id)->where('org_id',$request->input('org_id'))->paginate(10);
        $send_note = note::where('lesson_id',$lesson->lesson_id)->where('org_id',$request->input('org_id'))->get()->count();
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.note_member_in_org',compact(['lesson'],['data'],['note'],['send_note'],['data_org'],['lesson_all'],['lesson_null']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function note_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'org_id'=>'',
            'note'=>'required',
            'creator'=>'required',
        ]);
        $post = new note();
        if ( $request->input('org_id') == null ) {
        } else {
            $post->org_id = $request->input('org_id');
        }
        $post->lesson_id = $request->input('lesson_id');
        $post->note = $request->input('note');
        $post->creator = $request->input('creator');
        $post->save();
        return redirect()->back()->with('status','คุณได้ทำการเพิ่ม บันทึกย่อ เรียบร้อยเเล้ว');
    }
    public function note_update(Request $request,$id)
    {
        $request->validate([
            'note'=>'required',
        ]);
        $post = note::find($id);
        $post->note = $request->input('note');
        $post->save();
        return redirect()->back()->with('status','คุณได้ทำการแก้ไข บันทึกย่อ เรียบร้อยเเล้ว');
    }    
    public function note_destroy($id)
    {
        note::find($id)->delete();
        return redirect()->back()->with('status','คุณได้ทำการลบบันทึกย่อเรียบร้อยเเล้ว' );
    }
        /** ********************************************************************* quiz แบบทดสอบ ********************************************* */
        public function set_quiz($lesson_id)
        {
            $lesson = lesson::find($lesson_id);
            $data = course::find($lesson->id);
            //dd($h_quiz);
            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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
            
            if (Auth::user()->member_id == $data->course_owner) {
                $set_quiz = set_quiz::where('lesson_id','=',$lesson_id)->get();
                if ($set_quiz->isEmpty()) { 
                    $set_quizz = '';
                } else {
                    $set_quizz = $set_quiz;
                }
                return view('pages.set_quiz',compact(['lesson'],['data'],['Renroll_count'],['Penroll_count'],['lesson_count']
                ,['set_quiz'],['set_quizz'],
                ['lesson_all'],['lesson_null'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
            } else {
                $set_quiz_ans = set_quiz::where('lesson_id','=',$lesson_id)->where('status',"เผยแพร่")->get();
                if ($set_quiz_ans->isEmpty()) { 
                    $set_quizz = '';
                } else {
                    $set_quizz = $set_quiz_ans;
                }
                return view('pages.set_quiz_ans',compact(['lesson'],['data'],['Renroll_count'],['Penroll_count'],['lesson_count']
                ,['set_quizz'],['set_quiz_ans'],
                ['lesson_all'],['lesson_null'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
            }
            
        }
        public function set_quiz_edit(Request $request, $id)
        {
                 $request->validate([
                     'lesson_id'=>'required',
                     'set_name'=>'required',
                     'time'=>'required',
                     'status'=>'required',
                 ]);
                 $post = set_quiz::find($id);
                 $post->lesson_id = $request->input('lesson_id');
                 $post->set_name = $request->input('set_name');
                 $post->time = $request->input('time');
                 $post->status = $request->input('status');
                 $post->save();
                return redirect()->back()->with('status','คุณได้ทำการแก้ไขชุดทดสอบเรียบร้อยเเล้ว');
            }
        public function set_quiz_destroy($id)
        {
            set_quiz::find($id)->delete();
            return redirect()->back()->with('delete','คุณได้ทำการลบชุดทดสอบเรียบร้อยเเล้ว');
        }
        public function add_quiz($id)
        {
            $set_quiz = set_quiz::find($id);
            $h_quiz = quiz_header::where('id','=',$set_quiz->id)
            //->orderBy('qh_id','desc')
            ->get();
            if ($h_quiz->isEmpty()) { 
                $h_quizx = '';
            } else {
                $h_quizx = $h_quiz;
            }
            $quiz = quiz::all();
            $lesson = lesson::find($set_quiz->lesson_id);
            $data = course::find($lesson->id);
            //dd($h_quiz);
            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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
            
            return view('pages.add_quiz',compact(['lesson'],['data'],['h_quiz'],['h_quizx'],['quiz'],['set_quiz']
            ,['Renroll_count'],['Penroll_count'],['lesson_count'],['lesson_all'],['lesson_null'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }

        public function quiz_store(Request $request)
        {
            //dd($request);
            if ($request->quiz != null) {
                if($request->has('qh_id')) {
                    foreach($request->quiz as $key=>$quiz){
                        $quiz =array(
                                        'quiz'=> $quiz,
                                        'result'=> $request->result[$key],
                                        'qh_id'=> $request->qh_id,
                                        );
                        quiz::query()->create($quiz);
                    } 
                }
                return redirect()->back()->with('status','คุณได้ทำการเพิ่ม ช้อย เรียบร้อยเเล้ว');
            }elseif ($request->header_name != null) {
                 $request->validate([
                     'id'=>'required',
                     'header_name'=>'required',
                     'status'=>'required',
                 ]);
                 $post = new quiz_header();
                 $post->id = $request->input('id');
                 $post->header_name = $request->input('header_name');
                 $post->status = $request->input('status');
                 $post->save();
                return redirect()->back()->with('status','คุณได้ทำการเพิ่ม หัวข้อแบบทดสอบ เรียบร้อยเเล้ว');
            } elseif ($request->set_name != null) {
                $request->validate([
                    'lesson_id'=>'required',
                    'set_name'=>'required',
                    'time'=>'required',
                    'status'=>'required',
                ]);
                $post = new set_quiz();
                $post->lesson_id = $request->input('lesson_id');
                $post->set_name = $request->input('set_name');
                $post->time = $request->input('time');
                $post->status = $request->input('status');
                $post->save();
               return redirect()->back()->with('status','คุณได้ทำการเพิ่ม ชุดแบบทดสอบ เรียบร้อยเเล้ว');
           }
        }
        public function quiz_h_edit(Request $request, $qh_id)
        {
                 $request->validate([
                     'id'=>'required',
                     'header_name'=>'required',
                     'status'=>'required',
                 ]);
                 $post = quiz_header::find($qh_id);
                 $post->id = $request->input('id');
                 $post->header_name = $request->input('header_name');
                 $post->status = $request->input('status');
                 $post->save();
                return redirect()->back()->with('status','คุณได้ทำการแก้ไขหัวข้อแบบทดสอบเรียบร้อยเเล้ว');
            }
        public function quiz_h_destroy($qh_id)
        {
            quiz_header::find($qh_id)->delete();
            return redirect()->back()->with('delete','คุณได้ทำการลบหัวข้อแบบทดสอบเรียบร้อยเเล้ว');
        }
        public function quiz_edit(Request $request, $id)
        {
                 $request->validate([
                     'qh_id'=>'required',
                     'quiz'=>'required',
                     'result'=>'required',
                 ]);
                 $post = quiz::find($id);
                 $post->qh_id = $request->input('qh_id');
                 $post->quiz = $request->input('quiz');
                 $post->result = $request->input('result');
                 $post->save();
                return redirect()->back()->with('status','คุณได้ทำการแก้ไขช้อยเรียบร้อยเเล้ว');
            }
        public function quiz_destroy($id)
        {
            quiz::find($id)->delete();
            return redirect()->back()->with('delete','คุณได้ทำการลบช้อยเรียบร้อยเเล้ว');
        }

        public function detail_answer_quiz(Request $request,$id)
        {
            $set_quiz = set_quiz::find($id);
            $h_quiz = quiz_header::where('id','=',$set_quiz->id)->get(); 
            $co_h_quiz = quiz_header::where('id','=',$set_quiz->id)->get()->count(); 
            //$co_score = quiz::where('qh_id',$h_quiz->qh_id)->sum('result');
            //dd($co_score);
            if ($h_quiz->isEmpty()) { 
                $h_quizx = '';
            } else {
                $h_quizx = $h_quiz;
            }
            $quiz = quiz::inRandomOrder()->get();
            $lesson = lesson::find($set_quiz->lesson_id);
            $data = course::find($lesson->id);
            $answer_quiz = quiz_answer::where('set_id',$set_quiz->id)->where('member_id',Auth::user()->member_id)->get();
            if ($answer_quiz->isEmpty()) { 
                $answer = '';
                $try = '';
            } else {
                $answer = $answer_quiz;
                if ($request->input('try') == null) {
                    $try = '';
                } else {
                    $try = $request->input('try');
                }
                
            }

            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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

            return view('pages.detail_answer_quiz',compact(['lesson'],['data'],['quiz'],['answer'],['try'],['h_quiz'],['set_quiz'],
            ['h_quizx'],['Renroll_count'],['Penroll_count'],['lesson_count'],['lesson_all'],['lesson_null'],['co_h_quiz'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }

        public function answer_quiz(Request $request,$id)
        {
            $set_quiz = set_quiz::find($id);
            $h_quiz = quiz_header::inRandomOrder()->where('id','=',$set_quiz->id)->get(); 
            //$h_quiz = quiz_header::inRandomOrder()->where('id','=',$set_quiz->id)->where('status','=',"เผยแพร่")->get(); 
            $quiz = quiz::inRandomOrder()->get();
            $lesson = lesson::find($set_quiz->lesson_id);
            $data = course::find($lesson->id);
            $answer_quiz = quiz_answer::where('set_id',$set_quiz->id)->where('member_id',Auth::user()->member_id)->get();

            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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

            return view('pages.answer_quiz',compact(['lesson'],['data'],['quiz'],['h_quiz'],['Renroll_count'],['Penroll_count'],['set_quiz']
            ,['lesson_count'],['lesson_all'],['lesson_null'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }

        public function answer_store(Request $request, $id)
        {
                //dd($request);
            
            if($request->has('qh_id')) {
            foreach($request->qh_id as $key=>$qh_id){
                $answer = array (
                                'set_id'=> $request->id,
                                'member_id'=> $request->member_id,
                                'qh_id'=> $qh_id,
                                'result'=> $request->result[$qh_id],
                                );
                                //dd($answer);

                quiz_answer::query()->create($answer);
            } 
           
        }
            
        return redirect()->route('detail.answer.quiz',$id)->with('status','คุณได้ทำการส่งแบบทดสอบเรียบร้อยเเล้ว');
        }

        public function set_score(Request $request ,$lesson_id)
        {
            $set_score = set_quiz::where('lesson_id',$lesson_id)->get();
            $lesson = lesson::find($lesson_id);
            $data = course::find($lesson->id);

            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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

            return view('pages.set_score',compact(['lesson'],['data'],['Renroll_count']
            ,['Penroll_count'] ,['lesson_count'],['lesson_all'],['lesson_null'],['set_score'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }


        public function quiz_score(Request $request,$id)
        {
            $set_quiz = set_quiz::find($id);
            $answer = quiz_answer::where('set_id',$set_quiz->id)->where('member_id',Auth::user()->member_id)->get();
            
            if ($answer->isEmpty()) { 
                $quiz_score = '';
            } else {
                $quiz_score = $answer;
            }
            
            $answer_score = DB::table('quizzes')
            ->join('quiz_answers','quiz_answers.result','=','quizzes.id')
            ->select( 'quiz_answers.member_id','quiz_answers.created_at',DB::raw('SUM(quizzes.result) AS value'))
            ->where('quiz_answers.member_id',Auth::user()->member_id)
            ->groupBy('quiz_answers.member_id','quiz_answers.created_at')
            ->get();
            $co_quiz = quiz_header::where('id',$set_quiz->id)->get()->count();
            $lesson = lesson::find($set_quiz->lesson_id);
            $data = course::find($lesson->id);

            $lesson_all = lesson::where('id',$data->id)->get();
            $lesson_null = '';
            $Renroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"รอดำเนินการ")->get()->count();
            $Penroll_count = enroll::where('course_id',$lesson->id)
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
            if ($data->course_owner == Auth::user()->member_id){
                $lesson_count = lesson::where('id',$lesson->id)->get()->count();
            }
            else{
                $lesson_count = lesson::where('id',$lesson->id)
                ->where('lesson_status',"เผยแพร่")->get()->count();
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

            return view('pages.quiz_score',compact(['lesson'],['data'],['answer_score'],['quiz_score'],['co_quiz'],['Renroll_count']
            ,['Penroll_count'] ,['lesson_count'],['lesson_all'],['lesson_null'],['set_quiz'],
            ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
        }

    /** ********************************************************************* ORG กลุ่มองค์กร ********************************************* */
    
    public function org_index($org_id)
    {
        $data=group_org::find($org_id);
        $org_edit = '';
        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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

        return view('pages.org_index',compact(['data','org_edit'],['mio_count'],['cio_count'],['org_r_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function my_org()
    {
        $my_org=group_org::where('org_owner',Auth::user()->member_id)
        ->paginate(10);
    
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
        
        return view('pages.my_org',compact(['my_org'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function course_in_org($org_id)
    {
        $data=group_org::find($org_id);
        $cc = course_category::all();

        $course = enroll::where('org_id',$org_id)
        ->where('enroll_type','องค์กร')
        ->whereNotIn('course_id', enroll::where('member_id','=', Auth::user()->member_id )
        ->select('course_id'))
        ->whereNotIn('course_id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
        ->paginate(10);

        $course_enr = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
        ->where('enroll_type','!=',"องค์กร")
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        ->groupBy('course_id')
        ->get();

        $course_mio_enr = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
        ->where('enroll_type',"สมาชิกองค์กร")
        ->where('org_id',$org_id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        ->groupBy('course_id')
        ->get();
        //dd($course_enr);

        $course_me_enroll = enroll::where('member_id','=', Auth::user()->member_id )
        ->whereIn('course_id', enroll::where('org_id','=', $org_id )
        ->where('enroll_type','องค์กร')
        ->select('course_id'))
        ->paginate(10);

        $owner_course = enroll::where('org_id','=', $org_id )->where('enroll_type','องค์กร')
        ->whereIn('course_id', course::where('course_owner','=', Auth::user()->member_id )
        ->select('id'))
        ->paginate(10);

        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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

        return view('pages.course_in_org',compact(['course'],['course_enr'],['course_mio_enr'],['owner_course'],['course_me_enroll']
        ,['data'],['mio_count'],['cio_count'],['org_r_count'],['cc'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function member_in_org($org_id)
    {
        $data=group_org::find($org_id);
        $member_in_org_inv=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->paginate(10);
        $member_in_org_req=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->paginate(10);
        
        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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

        return view('pages.member_in_org',compact(['member_in_org_inv'],['member_in_org_req'],['data']
        ,['mio_i'],['mio_r'],['mio_count'],['cio_count'],['org_r_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /** *********************************************************** org_my_join ***************************************************** */
     public function org_my_join()
    {
        // $org_my_join_req=org_request::where('member_id',Auth::user()->member_id )->where('status',null)
        // ->paginate(10);
        // $org_mjr_co=org_request::where('member_id',Auth::user()->member_id )->where('status',null)
        // ->get()->count();
        
        $org_my_join_respond_inv=respond_inv::where('member_id',Auth::user()->member_id )->where('answer','=','ยืนยัน')
        ->paginate(10);
        $org_mjri_co=respond_inv::where('member_id',Auth::user()->member_id )->where('answer','=','ยืนยัน')
        ->get()->count();

        $org_my_join_respond_req=respond_req::where('member_id',Auth::user()->member_id )->where('answer','=','ยืนยัน')
        ->paginate(10);
        $org_mjrr_co=respond_req::where('member_id',Auth::user()->member_id )->where('answer','=','ยืนยัน')
        ->get()->count();

        $sum_omj =$org_mjri_co + $org_mjrr_co;
        //dd($sum_omj);

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

        return view('pages.org_my_join',compact(['org_my_join_respond_inv'],['org_my_join_respond_req'],
        ['org_mji_co'],['org_mjr_co'],['org_mjrr_co'],['org_mjri_co'],['sum_omj'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function org_my_join_inv_destroy($id)
    {
        respond_inv::find($id)->delete();
        return redirect()->back();
    }
    public function org_my_join_req_destroy($id)
    {
        respond_req::find($id)->delete();
        return redirect()->back();
    }
/* ************************************************************ invite_org ******************************************************** **/
    public function invite_org($org_id)
    {
        $data=group_org::find($org_id);
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
        ->where('name','!=',null)
        ->paginate(10);

        $member_join = member::whereIn('member_id', respond_req::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->orwhereIn('member_id', respond_inv::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->where('name','!=',null)
        ->paginate(10);

        $member_request = member::whereIn('member_id', org_request::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name','!=',null)
        ->paginate(10);
        
        $member_invite = member::whereIn('member_id', org_invite::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name','!=',null)
        ->paginate(10);   

        $member_owner = member::where('member_id','=',$data->org_owner)
        ->where('name','!=',null)
        ->paginate(10);

        $co_msio=org_invite::where('org_id',$org_id)
        ->where('status',null)->get()->count();

        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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
        
        return view('pages.invite_org',compact(['data'],['member'],['mio_count'],['cio_count'],['org_r_count'],['co_msio']
        ,['member_join'],['member_request'],['member_invite'],['member_owner'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function invite_org_store(Request $request, $org_id )
    {
        $request->validate([
            'org_id'=>'required',
            'member_id'=>'required',
            'owner_invite'=>'required',
        ]);

       $post = new org_invite;
       $post->org_id = $request->input('org_id');
       $post->member_id = $request->input('member_id');
       $post->owner_invite = $request->input('owner_invite');
       //dd($post);
       $post->save();
       $data=group_org::find($org_id);
       $member=member::where('member_id','!=',Auth::user()->count_org->org_owner )
       ->paginate(10);
       $member = member::find($request->input('member_id'));
       return redirect()->back()->with('status','คุณได้ทำการเชิญ '.$member->name.$member->surname.' เข้าร่วมองค์กรเรียบร้อยเเล้ว');
    }

    public function respond_invite_org()
    {
        $org_invite=org_invite::where('member_id',Auth::user()->member_id)->where('status',null)
        ->whereNotIn('org_id', respond_inv::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->whereNotIn('org_id', respond_req::where('member_id',Auth::user()->member_id)
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->paginate(10);
        
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

        return view('pages.respond_invite_org',compact(['org_invite'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function respond_invite_org_store(Request $request,$invite_id)
    {
        $request->validate([
            'invite_id'=>'required',
            'org_id'=>'required',
            'answer'=>'required',
            'member_id'=>'required',
        ]);

       $post = new respond_inv;
       $post->org_id = $request->input('org_id');
       $post->invite_id = $request->input('invite_id');
       $post->answer = $request->input('answer');
       $post->member_id = $request->input('member_id');
       $post->save();

       $post2 = org_invite::find($invite_id);
       $post2->status = 'ตอบเเล้ว';
       $post2->save();
       //dd($post);
       $org = group_org::find($request->input('org_id'));
       if ($request->input('answer') == "ยืนยัน") {
           return redirect()->back()->with('confirm','คุณได้ทำการ ตอบรับ การเชิญเข้าร่วมเป็นสมาชิกองค์กร '.$org->org_name.' เรียบร้อยเเล้ว');
       } elseif ($request->input('answer') == "ปฎิเสธ") {
           return redirect()->back()->with('refuse','คุณได้ทำการ ปฎิเสธ การเชิญเข้าร่วมเป็นสมาชิกองค์กร '.$org->org_name.' เรียบร้อยเเล้ว');
       }
    }
    public function member_in_org_inv_destroy($id)
    {
        $respon_inv = respond_req::find($id);
        if ($respon_inv->status == null) {
            $respon_inv->status = "พ้นสภาพการเป็นสมาชิกองค์กร";
            $respon_inv->save();
        } else {
            respond_req::find($id)->delete();
        }

        return redirect()->back()->with('status','คุณได้ทำการลบ '.$respon_inv->member->name.$respon_inv->member->surname.' ออกจากองค์กรเรียบร้อยเเล้ว' );
    }
    /* ****************************************************************** request_org********************************************** **/

    public function request_org_store(Request $request)
    {
        $request->validate([
            'member_id'=>'required',
            'org_id'=>'required',
        ]);

       $post = new org_request;
       $post->org_id = $request->input('org_id');
       $post->member_id = $request->input('member_id');
       $org = group_org::find($request->input('org_id'));
       //dd($post);
       $post->save();
       return redirect()->back()->with('status','คุณได้ทำการขอเข้าร่วมองค์กร '.$org->org_name. ' เรียบร้อยเเล้ว' );
    }
    public function respond_request_org($org_id)
    {
        $data=group_org::find($org_id);
        $org_request=org_request::where('org_id',$org_id)->where('status',null)
        ->whereNotIn('member_id', respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->select('member_id'))
        ->whereNotIn('member_id', respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->select('member_id'))
        ->paginate(10);

        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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

        return view('pages.respond_request_org',compact(['org_request'],['data'],['mio_count'],['cio_count'],['org_r_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function respond_request_org_store(Request $request,$org_id)
    {
        $request->validate([
            'request_id'=>'required',
            'member_id'=>'required',
            'answer'=>'required',
            'org_id'=>'required',
        ]);

        $post = new respond_req;
        $post->request_id = $request->input('request_id');
        $post->member_id = $request->input('member_id');
        $post->answer = $request->input('answer');
        $post->org_id = $request->input('org_id');
        $post->save();

        $post2 = org_request::find($request->input('request_id'));
        $post2->status = 'ตอบเเล้ว';
        $post2->save();
        //dd($post);
        $data=group_org::find($org_id);
        $org_request=org_request::where('org_id',$org_id)
        ->where('status',null)
        ->paginate(10);
        $member = member::find($request->input('member_id'));
        if ($request->input('answer') == "ยืนยัน") {
            return redirect()->back()->with('confirm','คุณได้ทำการตอบรับ '.$member->name .$member->surname.' เข้าเป็นสมาชิกเรียบร้อยเเล้ว');
        } elseif ($request->input('answer') == "ปฎิเสธ") {
            return redirect()->back()->with('refuse','คุณได้ทำการปฎิเสธการขอเข้าร่วมองค์กรของ '.$member->name .$member->surname.' เรียบร้อยเเล้ว');
        }
        
    }
    public function member_in_org_req_destroy(Request $request, $id)
    {
        $respond_req = respond_req::find($id);
        if ($respond_req->status == null) {
            $respond_req->status = "พ้นสภาพการเป็นสมาชิกองค์กร";
            $respond_req->save();
        } else {
            respond_req::find($id)->delete();
        }
        return redirect()->back()->with('status','คุณได้ทำการลบ '.$respond_req->member->name.$respond_req->member->surname.' ออกจากองค์กรเรียบร้อยเเล้ว' );
    }
    //--------------------------------------------------LINK youtube-------------------------------------------------------------------//
    public function link_youtube_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'name'=>'required',
            'link'=>'required',
            'owner'=>'required',
        ]);

        $post = new link_youtube;
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->link = $request->input('link');
        $post->owner = $request->input('owner');
        $post->save();
        //dd($post);
        return redirect()->back()->with('input','ระบบได้บันทึกข้อมูลเรียบร้อยเเล้ว');
    }
    public function link_youtube_edit(Request $request, $lesson_id)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $edit_link_y = link_youtube::find($request->input('id'));
        $edit_link_Gdrive = null;
        $edit_document = null;
        $edit_video = null;
        $edit_image = null;
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
        
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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

        return view('pages.lesson_page_edit',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['edit_link_y'],['edit_link_Gdrive'],['edit_document'],['edit_video'],['edit_image']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function link_youtube_update(Request $request,$lesson_id)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'link'=>'required',
            'owner'=>'required',
        ]);

        $post = link_youtube::find($request->input('id'));
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->link = $request->input('link');
        $post->owner = $request->input('owner');
        $post->save();

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();

        
        return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }
    public function link_youtube_destroy($id)
    {
        link_youtube::find($id)->delete();
        return redirect()->back()->with('destroy','ระบบได้ลบข้อมูลเรียบร้อยเเล้ว');
    }
//-------------------------------------------------------------------LINK Gdrive--------------------------------------------------------------//
    public function link_Gdrive_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'name'=>'required',
            'link'=>'required',
            'owner'=>'required',
        ]);

        $post = new link_Gdrive();
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->link = $request->input('link');
        $post->owner = $request->input('owner');
        $post->save();
        //dd($post);

        return redirect()->back()->with('input','ระบบได้บันทึกข้อมูลเรียบร้อยเเล้ว');
    }
    public function link_Gdrive_edit(Request $request, $lesson_id)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $edit_link_Gdrive = link_Gdrive::find($request->input('id'));
        $edit_link_y = null;
        $edit_document = null;
        $edit_video = null;
        $edit_image = null;
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
        
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.lesson_page_edit',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['edit_link_y'],['edit_link_Gdrive'],['edit_document'],['edit_video'],['edit_image']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function link_Gdrive_update(Request $request,$lesson_id)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'link'=>'required',
            'owner'=>'required',
        ]);

        $post = link_Gdrive::find($request->input('id'));
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->link = $request->input('link');
        $post->owner = $request->input('owner');
        $post->save();

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();

        
        return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }

    public function link_Gdrive_destroy($id)
    {
        link_Gdrive::find($id)->delete();
        return redirect()->back()->with('destroy','ระบบได้ลบข้อมูลเรียบร้อยเเล้ว');
    }
    //------------------------------------------------------------DOCUMENT------------------------------------------------------------//
    public function document_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'name'=>'required',
            'file'=>'mimes:pdf,docx,pptx',
            'owner'=>'required',
        ]);

        $post = new document();
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->owner = $request->input('owner');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/document_assets',$filename);
            $post->file =$filename; 
        } 
        $post->save();
        //dd($post);

        return redirect()->back()->with('input','ระบบได้บันทึกข้อมูลเรียบร้อยเเล้ว');
    }
    public function document_edit(Request $request, $lesson_id)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $edit_document = document::find($request->input('id'));
        $edit_link_y = null;
        $edit_link_Gdrive = null;
        $edit_video = null;
        $edit_image = null;
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
        
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.lesson_page_edit',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['edit_link_y'],['edit_link_Gdrive'],['edit_document'],['edit_video'],['edit_image']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function document_update(Request $request,$lesson_id)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'file'=>'mimes:pdf,docx,pptx',
            'owner'=>'required',
        ]);

        $post = document::find($request->input('id'));
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/document_assets',$filename);
            $post->file =$filename; 
        } 
        $post->owner = $request->input('owner');
        $post->save();

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();

        
        return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }
    public function document_destroy($id)
    {
        document::find($id)->delete();
        return redirect()->back()->with('destroy','ระบบได้ลบข้อมูลเรียบร้อยเเล้ว');
    }
    
    //------------------------------------------------------------VIDEO------------------------------------------------------------//
    public function video_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'name'=>'required',
            'file'=>'mimes:mp4',
            'owner'=>'required',
        ]);

        $post = new video();
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->owner = $request->input('owner');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/video_assets',$filename);
            $post->file =$filename; 
        } 
        $post->save();
        //dd($post);

        return redirect()->back()->with('input','ระบบได้บันทึกข้อมูลเรียบร้อยเเล้ว');
    }
    public function video_edit(Request $request, $lesson_id)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $edit_video = video::find($request->input('id'));
        $edit_link_y = null;
        $edit_link_Gdrive = null;
        $edit_document = null;
        $edit_image = null;
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
     
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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

        return view('pages.lesson_page_edit',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['edit_link_y'],['edit_link_Gdrive'],['edit_document'],['edit_video'],['edit_image']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function video_update(Request $request,$lesson_id)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'file'=>'mimes:mp4',
            'owner'=>'required',
        ]);

        $post = video::find($request->input('id'));
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/video_assets',$filename);
            $post->file =$filename; 
        } 
        $post->owner = $request->input('owner');
        $post->save();

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();

        
        return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }
    public function video_destroy($id)
    {
        video::find($id)->delete();
        return redirect()->back()->with('destroy','ระบบได้ลบข้อมูลเรียบร้อยเเล้ว');
    }
    
    //------------------------------------------------------------IMAGE------------------------------------------------------------//
    public function image_store(Request $request)
    {
        $request->validate([
            'lesson_id'=>'required',
            'name'=>'required',
            'file'=>'mimes:jpg,jpeg,png',
            'owner'=>'required',
        ]);

        $post = new image();
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        $post->owner = $request->input('owner');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/image_assets',$filename);
            $post->file =$filename; 
        } 
        $post->save();
        //dd($post);

        return redirect()->back()->with('input','ระบบได้บันทึกข้อมูลเรียบร้อยเเล้ว');
    }
    public function image_edit(Request $request, $lesson_id)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();
        $edit_image = image::find($request->input('id'));
        $edit_link_y = null;
        $edit_link_Gdrive = null;
        $edit_document = null;
        $edit_video = null;
        $lesson_all = lesson::where('id',$data->id)->get();
        $lesson_null = '';
       
        $Renroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$lesson->id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$lesson->id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$$lesson->id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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
        
        return view('pages.lesson_page_edit',compact(['lesson'],['data'],['link_y'],['link_g'],['lesson_all'],['lesson_null']
        ,['document'],['video'],['image'],['edit_link_y'],['edit_link_Gdrive'],['edit_document'],['edit_video'],['edit_image']
        ,['Renroll_count'],['Penroll_count'],['lesson_count'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function image_update(Request $request,$lesson_id)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'file'=>'mimes:jpg,jpeg,png',
            'owner'=>'required',
        ]);

        $post = image::find($request->input('id'));
        $post->lesson_id = $request->input('lesson_id');
        $post->name = $request->input('name');
        $post->description = $request->input('description');
        if   ($request->file('file')) {
            $file=$request->file('file');
            $fileN=$request->input('name');
            $filename = $fileN.'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/lesson/image_assets',$filename);
            $post->file =$filename; 
        } 
        $post->owner = $request->input('owner');
        $post->save();

        $lesson = lesson::find($lesson_id);
        $data = course::find($lesson->id);
        $link_y = link_youtube::where('lesson_id',$lesson->lesson_id)->paginate();
        $link_g = link_Gdrive::where('lesson_id',$lesson->lesson_id)->paginate();
        $document = document::where('lesson_id',$lesson->lesson_id)->paginate();
        $video = video::where('lesson_id',$lesson->lesson_id)->paginate();
        $image = image::where('lesson_id',$lesson->lesson_id)->paginate();

        
        return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }
    public function image_destroy($id)
    {
        image::find($id)->delete();
        return redirect()->back()->with('destroy','ระบบได้ลบข้อมูลเรียบร้อยเเล้ว');
    }
    //-----------------------------------------------------------------------------------------------------------------------------//
    public function enroll_in_org($org_id) {
        $data = group_org::find($org_id);
        $course = enroll::where('org_id','=',$org_id)->where('enroll_type','=','องค์กร')
        ->paginate(10);

        $mio_i=respond_inv::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_r=respond_req::where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')->get()->count();
        $mio_count =  $mio_i + $mio_r;
        $cio_count=enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')->get()->count();
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

        return view('pages.enroll_in_org',compact(['course'],['data'],['mio_count'],['cio_count'],['org_r_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    
    public function enroll_store(Request $request)
    {
        $course = course::find($request->input('course_id'));
        if ($request->input('org_id') == null)
        {
            $post = new enroll();
            $post->course_id = $request->input('course_id');
            $post->member_id = $request->input('member_id');
            $post->enroll_type = "บุคคล";
            $post2 = course::find($request->input('course_id'));
            if ($post2->course_type == 'สาธารณะ')
            {
            $post->status = 'ลงทะเบียนเรียบร้อยเเล้ว';
            }
            else if ($post2->course_type == 'ส่วนตัว')
            {
            $post->status = 'รอดำเนินการ';
            }
            else
            $post->status = null;
            $post->save();
            //dd($post);
        return redirect('/my_course')->with('enroll','คุณได้ลงทะเบียนรายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
        }
        elseif ($request->input('member_id') == null)
        {
            $post = new enroll();
            $post->course_id = $request->input('course_id');
            $post->org_id = $request->input('org_id');
            $post->enroll_type = "องค์กร";
            $post->creator = $request->input('creator');
            $post2 = course::find($request->input('course_id'));
            if ($post2->course_type == 'สาธารณะ')
            {
            $post->status = 'ลงทะเบียนเรียบร้อยเเล้ว';
            }
            else if ($post2->course_type == 'ส่วนตัว')
            {
            $post->status = 'รอดำเนินการ';
            }
            else
            $post->status = null;
            $post->save();
            //dd($post);
        return redirect()->back()->with('enroll','คุณได้ลงทะเบียนรายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
        }
        else {
            $post = new enroll();
            $post->course_id = $request->input('course_id');
            $post->org_id = $request->input('org_id');
            $post->member_id = $request->input('member_id');
            $post->enroll_type = "สมาชิกองค์กร";
            $post->creator = $request->input('creator');
            $post2 = course::find($request->input('course_id'));
            if ($post2->course_type == 'สาธารณะ')
            {
            $post->status = 'ลงทะเบียนเรียบร้อยเเล้ว';
            }
            else if ($post2->course_type == 'ส่วนตัว')
            {
            $post->status = 'รอดำเนินการ';
            }
            else
            $post->status = null;
            $post->save();
            //dd($post);
        return redirect('/my_course')->with('enroll','คุณได้ลงทะเบียนรายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
        }
    }
    public function response_enroll($course_id)
    {
        $id = $course_id;
        $data = course::find($id);
        $enroll = enroll::where('course_id',$course_id)
        ->where('status',"รอดำเนินการ")
        ->paginate(10);
        $Renroll_count = enroll::where('course_id',$course_id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$id)
            ->where('lesson_status',"เผยแพร่")
            ->get()->count();
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

        return view('pages.response_enroll',compact(['enroll'],['data'],['lesson_count'],['Penroll_count'],['Renroll_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    public function invite_enroll(Request $request, $enroll_id)
    {
        $request->validate([
            'status'=>'required',
            'org_id'=>'',
            'member_id'=>'',
            'course_id'=>'',
        ]);
        if ($request->input('member_id') == null) {
            $post = enroll::find($enroll_id);
            enroll::where('org_id',$post->org_id)->where('course_id',$post->course_id)->update(['status' =>  $request->input('status')]);
        } else {
            $post = enroll::find($enroll_id);
            $post->status = $request->input('status');
            $post->save();
        }
        
        //dd($post1);
        $course = course::find($request->input('course_id'));

        if ( $request->input('status') == "ลงทะเบียนเรียบร้อยเเล้ว") {
        
            if ($request->input('member_id') == null) {
                $org = group_org::find($request->input('org_id'));
                return redirect()->back()->with('confirm','ระบบได้ตอบรับองค์กร '.$org->org_name.' เข้าสู่รายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            } elseif ($request->input('org_id') == null) {
                $member = member::find($request->input('member_id'));
                return redirect()->back()->with('confirm','ระบบได้ตอบรับ '.$member->name.$member->surname.' เข้าสู่รายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            }
        } elseif ( $request->input('status') == "การลงทะเบียนถูกปฏิเสธ" ) {
        
            if ($request->input('member_id') == null) {
                $org = group_org::find($request->input('org_id'));
                return redirect()->back()->with('refuse','ระบบได้ปฏิเสธองค์กร '.$org->org_name.' ในการเข้าสู่รายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            } elseif ($request->input('org_id') == null) {
                $member = member::find($request->input('member_id'));
                return redirect()->back()->with('refuse','ระบบได้ปฏิเสธ '.$member->name.$member->surname.' ในการเข้าสู่รายวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            }
        } elseif ( $request->input('status') == "การลงทะเบียนถูกยกเลิก" ) {
        
            if ($request->input('member_id') == null) {
                $org = group_org::find($request->input('org_id'));
                return redirect()->back()->with('cancel','ระบบได้ตัดองค์กร '.$org->org_name.' ออกจากรายชื่อผู้ลงทะเบียนวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            } elseif ($request->input('org_id') == null) {
                $member = member::find($request->input('member_id'));
                return redirect()->back()->with('cancel','ระบบได้ตัด '.$member->name.$member->surname.' ออกจากรายชื่อผู้ลงทะเบียนวิชา '.$course->course_name.' เรียบร้อยเเล้ว');
            }
        }
    }
    
    public function person_enroll($course_id)
    {
        $id = $course_id;
        $data = course::find($id);
        $enroll = enroll::where('course_id',$id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        ->paginate(10);
        $Renroll_count = enroll::where('course_id',$id)
        ->where('status',"รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id',$id)
        ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id){
            $lesson_count = lesson::where('id',$id)->get()->count();
        }
        else{
            $lesson_count = lesson::where('id',$id)
            ->where('lesson_status',"เผยแพร่")->get()->count();
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

        return view('pages.person_enroll',compact(['enroll'],['data'],['lesson_count'],['Penroll_count'],['Renroll_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function enroll_destroy($enroll_id)
    {
        $enroll = enroll::find($enroll_id);
        enroll::find($enroll_id)->delete();
        return redirect()->back()->with('drop','คุณได้ทำการดรอปรายวิชา '.$enroll->co_detail->course_name.' เรียบร้อยเเล้ว');
    }
}
