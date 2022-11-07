<?php

namespace App\Http\Controllers;

use App\course;
use Illuminate\Http\Request;
use App\tutor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\lesson;
use App\group_org;
use App\course_category;
use App\enroll;
use App\member;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
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
    public function create()
    {
        
        $cc = course_category::all();
        $con = course::get(); 

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

        return view('course.create',compact(['cc'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    //cc = course_category หมวดหมู่รายวิชา
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id'=>'',
            'cc_id'=>'required',
            'course_name'=>'required',
            'course_detail'=>'',
            'course_type'=>'required',
            'course_status'=>'required',
            'price'=>'',
            'course_owner'=>'required',
            'course_img'=>'mimes:jpg,jpeg,png',
        ]);
       $cou_cate = course_category::find($request->input('cc_id'));
       $count_co = course::where('cc_id',$request->input('cc_id'))->get()->count();
       if ($count_co == 0) {
        $count_co_id = 1;
       } else {
        $count_co_id = $count_co + 1;
       }
       $post = new course;
       $post->course_id = $cou_cate->short_name.$count_co_id;
       $post->cc_id = $request->input('cc_id');
       $post->course_name = $request->input('course_name');
       $post->course_detail = $request->input('course_detail');
       $post->course_type = $request->input('course_type');
       $post->course_status = $request->input('course_status');
       $post->price = $request->input('price');
       $post->course_owner = $request->input('course_owner');
       if   ($request->file('course_img')) {
        $file=$request->file('course_img');
        $ldate = date('YmdHis');
        $filename = $ldate.'.'.$file->getClientOriginalExtension();
        $request->course_img->move('storage/course/course_img_assets',$filename);
        $post->course_img =$filename; 
        } 
       //dd($post);
       $post->save();
       return redirect('/my_opencourse')->with('new','ระบบได้สร้างรายวิชาใหม่ของคุณเรียบร้อยเเล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $cc = course_category::all();
        $course = course::where('course_status', "เผยแพร่")
        ->paginate(10);
        return view('course.show',compact(['course','cc']));
    }


    public function search(Request $request)
    {
        $cc = course_category::all();
        $search = $request->get('search');

        if ($request->input('cc_id') == null){
            $course = course::whereNotIn('id', enroll::where('member_id', '=',Auth::user()->member_id)->select('course_id'))
            ->where('course_owner','!=',Auth::user()->member_id)
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $co_course = course::whereNotIn('id', enroll::where('member_id', '=',Auth::user()->member_id)->select('course_id'))
            ->where('course_owner','!=',Auth::user()->member_id)
            ->where('course_name', 'like', '%'.$search.'%')
            ->get()->count();

            $course_me_enroll = course::whereIn('id', enroll::where('member_id', '=',Auth::user()->member_id)->select('course_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $owner_course = course::where('course_owner','=', Auth::user()->member_id )
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);
        }
        else{
            $course = course::whereNotIn('id', enroll::where('member_id', '=',Auth::user()->member_id)           
            ->select('course_id'))
            ->where('course_owner','!=',Auth::user()->member_id)
            ->where('cc_id',$request->input('cc_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $co_course = course::whereNotIn('id', enroll::where('member_id', '=',Auth::user()->member_id)->select('course_id'))
            ->where('course_owner','!=',Auth::user()->member_id)
            ->where('course_name', 'like', '%'.$search.'%')
            ->get()->count();

            $course_me_enroll = course::whereIn('id', enroll::where('member_id', '=',Auth::user()->member_id)
            ->select('course_id'))
            ->where('cc_id',$request->input('cc_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $owner_course = course::where('course_owner','=', Auth::user()->member_id )
            ->where('cc_id',$request->input('cc_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);
        }
        
            $course_enr = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
            ->where('enroll_type','!=',"องค์กร")
            ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
            ->groupBy('course_id')
            ->get();

            $co_course = course::where('course_status',"เผยแพร่")->get()->count();

            $my_course_co=enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id') 
            ->where('enroll_type','!=',"องค์กร")  
            ->whereIn('course_id', enroll::where('member_id',Auth::user()->member_id)->select('course_id'))   
            ->groupBy('course_id')
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

        return view('course.show',compact(['course'],['course_enr'],['cc'],['co_course'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']
        ,['co_course'],['my_course_co'],['course_me_enroll'],['owner_course']));
    }

    public function org_search_course(Request $request,$org_id)
    {
        $data = group_org::find($org_id);
        $cc = course_category::all();
        $search = $request->get('search');
        
        if ($request->input('cc_id') == null){
            /**/
            $course = course::whereNotIn('id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            //->whereNotIn('id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereNotIn('id', enroll::where('org_id', '=',$org_id)->where('enroll_type','=','องค์กร')->select('course_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $co_course =  course::whereNotIn('id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            //->whereNotIn('id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereNotIn('id', enroll::where('org_id', '=',$org_id)->where('enroll_type','=','องค์กร')->select('course_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->get()->count();
            
            $course_in_org= enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')
            ->whereNotIn('course_id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            ->whereNotIn('course_id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereIn('course_id', course::where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);

            $course_me_enroll = enroll::where('org_id','=', $org_id )->where('enroll_type','องค์กร')
            ->whereIn('course_id',enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereIn('course_id', course::where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);

            $owner_course = enroll::where('org_id','=', $org_id )->where('enroll_type','องค์กร')
            ->whereIn('course_id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            ->whereIn('course_id', course::where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);

        }
        else{
            $course = course::whereNotIn('id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            //->whereNotIn('id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereNotIn('id', enroll::where('org_id', '=',$org_id)->where('enroll_type','=','องค์กร')->select('course_id'))
            ->where('cc_id',$request->input('cc_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $co_course = course::whereNotIn('id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            //->whereNotIn('id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereNotIn('id', enroll::where('org_id', '=',$org_id)->where('enroll_type','=','องค์กร')->select('course_id'))
            ->where('cc_id',$request->input('cc_id'))
            ->where('course_name', 'like', '%'.$search.'%')
            ->get()->count();
            
            $course_in_org= enroll::where('org_id',$org_id)->where('enroll_type','องค์กร')
            ->whereNotIn('course_id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            ->whereNotIn('course_id', enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereIn('course_id', course::where('cc_id',$request->input('cc_id'))->where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);

            $course_me_enroll = enroll::where('org_id','=', $org_id )->where('enroll_type','องค์กร')
            ->whereIn('course_id',enroll::where('member_id','=', Auth::user()->member_id )->select('course_id'))
            ->whereIn('course_id', course::where('cc_id',$request->input('cc_id'))->where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);

            $owner_course = enroll::where('org_id','=', $org_id )->where('enroll_type','องค์กร')
            ->whereIn('course_id', course::where('course_owner','=', Auth::user()->member_id )->select('id'))
            ->whereIn('course_id', course::where('cc_id',$request->input('cc_id'))->where('course_name', 'like', '%'.$search.'%')->select('id'))
            ->paginate(10);   
        }
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
        
        return view('course.org_search_course',compact(['course_in_org'],['course_me_enroll'],['course_enr'],['course_mio_enr']
        ,['owner_course'],['data'],['course'],['cc'],['co_course'],['mio_count'],['cio_count'],['org_r_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cc = course_category::all();
        $data=course::find($id); 
        $course_edit=course::find($id); 
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
        return view('pages.course_index',compact(['data','cc','course_edit','lesson_count','Penroll_count','Renroll_count']
        ,['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id'=>'',
            'cc_id'=>'required',
            'course_name'=>'required',
            'course_detail'=>'',
            'course_type'=>'required',
            'course_status'=>'required',
            'price'=>'',
            'course_owner'=>'required',
            'course_img'=>'mimes:jpg,jpeg,png',
        ]);
        $cou_cate = course_category::find($request->input('cc_id'));
        $count_co = course::where('cc_id',$request->input('cc_id'))->get()->count();
            if ($count_co == 0) {
            $count_co_id = 1;
            } 
            else {
            $count_co_id = $count_co + 1;
            }
       $co_id = $cou_cate->short_name.$count_co_id;
       $post = course::find($id);
            /**/
            if ( $post->cc_id ==  $request->input('cc_id')  ) {
                $post->course_id =  $post->course_id;
            } 
            else {
                $post->course_id =  $co_id;
            }
       $post->cc_id = $request->input('cc_id');
       $post->course_name = $request->input('course_name');
       $post->course_detail = $request->input('course_detail');
       $post->course_type = $request->input('course_type');
       $post->course_status = $request->input('course_status');
       $post->price = $request->input('price');
       $post->course_owner = $request->input('course_owner');

       if   ($request->file('course_img')) {
        $file=$request->file('course_img');
        $ldate = date('YmdHis');
        $filename = $ldate.'.'.$file->getClientOriginalExtension();
        $request->course_img->move('storage/course/course_img_assets',$filename);
        $post->course_img =$filename; 
        } 
       //dd($post);
       $post->save();
       return redirect()->back()->with('status','ระบบได้แก้ไขข้อมูลรายวิชาเรียบร้อยเเล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        course::find($id)->delete();
        return redirect('/my_opencourse');
    }

        
    public function cc_create()
    {
        $con = course_category::get(); 
        
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

        return view('course.cc_create',compact(['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function cc_store(Request $request)
    {

        $validator = Validator::make($request->all(),[
                'name'=>'required|unique:course_categories',
                'short_name'=>'required|unique:course_categories',
        ]);
        if ($validator->fails()) {
            redirect()->back()->with('error',"ชื่อหมวดหมู่หรืออักษรย่อซ้ำ กรุณาป้อนข้อมูลใหม่");
        }
        $request->validate([
            'name'=>'required|unique:course_categories',
            'short_name'=>'required|unique:course_categories',
        ]);

       $post = new course_category;
       $post->name = $request->input('name');
       $post->short_name = $request->input('short_name');
       //dd($post);
       $post->save();
       return redirect('/course_category/show');
    }
    
    public function cc_show()
    {
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

        return view('course.cc_show',compact(['cc'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    
    public function cc_edit($cc_id)
    {
        $data=course_category::find($cc_id); 

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

        return view('course.cc_edit',compact(['data'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }
    
    public function cc_update(Request $request, $cc_id)
    {
        $request->validate([
            'name'=>'required',
            'short_name'=>'required',
        ]);

       $post = course_category::find($cc_id);
       $post->name = $request->input('name');
       $post->short_name = $request->input('short_name');
       //dd($post);
       $post->save();
       return redirect('/course_category/show');
    }
    
    public function cc_destroy($cc_id)
    {
        course_category::find($cc_id)->delete();
        return redirect('/course_category/show');
    }
}
