<?php

namespace App\Http\Controllers;

use App\lesson;
use App\course;
use App\course_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\enroll;
use App\group_org;
use App\org_invite;
use App\respond_inv;
use App\respond_req;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data=course::find($id); 
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

        return view('lesson.create',compact(['data','Renroll_count','Penroll_count','lesson_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'lesson_name'=>'required',
            'lesson_detail'=>'',
            'lesson_status'=>'required',
        ]);

       $post = new lesson;
       $post->id = $request->input('id');
       $post->lesson_name = $request->input('lesson_name');
       $post->lesson_detail = $request->input('lesson_detail');
       $post->lesson_status = $request->input('lesson_status');
       //dd($post);
       $post->save();
       return Redirect::action('PagesController@manage_lesson',$request->input('id'))->with('new','ระบบได้สร้างบทเรียนใหม่ของคุณเรียบร้อยเเล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit($lesson_id)
    {
        $data=lesson::find($lesson_id); 
    
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
        
        return view('lesson.edit',compact(['data'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(request $request,$lesson_id)
    {;
        $request->validate([
            'id'=>'required',
            'lesson_name'=>'required',
            'lesson_detail'=>'',
            'lesson_status'=>'required',
        ]);

       $post = lesson::find($lesson_id);
       $post->id = $request->input('id');
       $post->lesson_name = $request->input('lesson_name');
       $post->lesson_detail = $request->input('lesson_detail');
       $post->lesson_status = $request->input('lesson_status');
       //dd($post);
       $post->save();
       //return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลบทเรียนเรียบร้อยเเล้ว');
        return Redirect::action('PagesController@manage_lesson',$request->input('id'))->with('edit','ระบบได้แก้ไขข้อมูลบทเรียนของคุณเรียบร้อยเเล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($lesson_id)
    {
        lesson::find($lesson_id)->delete();
        return redirect()->back()->with('status','ระบบได้ลบข้อมูลบทเรียนของคุณเรียบร้อยเเล้ว');
    }
}
