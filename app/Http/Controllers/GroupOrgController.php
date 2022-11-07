<?php

namespace App\Http\Controllers;

use App\course;
use App\course_category;
use App\group_org;
use App\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use App\enroll;

class GroupOrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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

        return view('group_org.create',compact(['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
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
            'org_name'=>'required',
            'description'=>'required',
            'org_tel'=>'required',
            'county'=>'required',
            'road'=>'required',
            'alley'=>'required',
            'house_number'=>'required',
            'group_no'=>'required',
            'sub_district'=>'required',
            'district'=>'required',
            'province'=>'required',
            'ZIP_code'=>'required',
            //'book_cer'=>'required|mimes:pdf',
            'org_owner'=>'required',

        ]);

       $post = new group_org;
       $post->org_name = $request->input('org_name');
       $post->description = $request->input('description');
       $post->org_tel = $request->input('org_tel');
       $post->county = $request->input('county');
       $post->road = $request->input('road');
       $post->alley = $request->input('alley');
       $post->house_number = $request->input('house_number');
       $post->group_no = $request->input('group_no');
       $post->sub_district = $request->input('sub_district');
       $post->district = $request->input('district'); 
       $post->province = $request->input('province');
       $post->ZIP_code = $request->input('ZIP_code');
       $post->org_owner = $request->input('org_owner');
       if   ($request->file('book_cer')) {
        $file=$request->file('book_cer');
        $fileN=$request->input('org_name');
        $filename = $fileN.'.'.$file->getClientOriginalExtension();
        $request->book_cer->move('storage/group_org/book_cer_assets',$filename);
        $post->book_cer =$filename; 
        } 
       //dd($post);
       $post->save();
       return redirect('/my_org')->with('new','ระบบได้สร้างองค์กรใหม่ของคุณเรียบร้อยเเล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\group_org  $group_org
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $group_org=group_org::paginate(10);
        $co_msro=org_request::where('member_id',Auth::user()->member_id)
        ->where('status',null)
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

        return view('group_org.show',compact(['group_org'],['co_msro'],['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
            $group_org = group_org::whereNotIn('org_id', respond_req::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')->select('org_id'))
            ->whereNotIn('org_id', org_request::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->whereNotIn('org_id', respond_inv::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')->select('org_id'))
            ->whereNotIn('org_id', org_invite::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->whereNotIn('org_id', group_org::where('org_owner','=',Auth::user()->member_id )->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $group_org_join = group_org::whereIn('org_id', respond_req::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')
            ->select('org_id'))
            ->orwhereIn('org_id', respond_inv::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')
            ->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $group_org_request = group_org::whereIn('org_id', org_request::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')
            ->paginate(10);
            
            $group_org_invite = group_org::whereIn('org_id', org_invite::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')
            ->paginate(10);   

            $group_org_owner = group_org::whereIn('org_id', group_org::where('org_owner','=',Auth::user()->member_id )->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')
            ->paginate(10);

            $co_group_org = group_org::whereNotIn('org_id', respond_req::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')->select('org_id'))
            ->whereNotIn('org_id', org_request::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->whereNotIn('org_id', respond_inv::where('member_id','=',Auth::user()->member_id )->where('answer','=','ยืนยัน')->select('org_id'))
            ->whereNotIn('org_id', org_invite::where('member_id','=',Auth::user()->member_id )->where('status',null)->select('org_id'))
            ->where('org_name', 'like', '%'.$search.'%')->get()->count();
            
        $co_msro=org_request::where('member_id',Auth::user()->member_id)
        ->where('status',null)
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
        
        return view('group_org.show',compact(['group_org','co_msro','group_org_join','group_org_request'
        ,'group_org_invite','group_org_owner','co_group_org'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\group_org  $group_org
     * @return \Illuminate\Http\Response
     */
    public function edit($org_id)
    {
        $data = group_org::find($org_id);
        $org_edit = group_org::find($org_id);

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
        
        return view('pages.org_index',compact(['data','org_edit','mio_count','cio_count','org_r_count'],
        ['co_my_org','co_opc','co_my_course','co_org_myjoin','co_org_invite']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\group_org  $group_org
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $org_id)
    {
        $request->validate([
            'org_name'=>'required',
            'description'=>'required',
            'org_tel'=>'required',
            'county'=>'required',
            'road'=>'required',
            'alley'=>'required',
            'house_number'=>'required',
            'group_no'=>'required',
            'sub_district'=>'required',
            'district'=>'required',
            'province'=>'required',
            'ZIP_code'=>'required',
            'org_owner'=>'required',

        ]);

       $post = group_org::find($org_id);
       $post->org_name = $request->input('org_name');
       $post->description = $request->input('description');
       $post->org_tel = $request->input('org_tel');
       $post->county = $request->input('county');
       $post->road = $request->input('road');
       $post->alley = $request->input('alley');
       $post->house_number = $request->input('house_number');
       $post->group_no = $request->input('group_no');
       $post->sub_district = $request->input('sub_district');
       $post->district = $request->input('district'); 
       $post->province = $request->input('province');
       $post->ZIP_code = $request->input('ZIP_code');
       $post->org_owner = $request->input('org_owner');

       if   ($request->file('book_cer')) {
        $file=$request->file('book_cer');
        $fileN=$request->input('org_name');
        $filename = $fileN.'.'.$file->getClientOriginalExtension();
        $request->book_cer->move('storage/group_org/book_cer_assets',$filename);
        $post->book_cer =$filename; 
        } 

       //dd($post);
       $post->save();
       $data=group_org::find($org_id);
       return redirect()->back()->with('status','แก้ไขข้อมูลเรียบร้อยเเล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\group_org  $group_org
     * @return \Illuminate\Http\Response
     */
    public function destroy($org_id)
    {
        group_org::find($org_id)->delete();
        return redirect('/my_org');
    }
    
}
