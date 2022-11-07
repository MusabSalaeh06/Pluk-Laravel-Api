<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\course;
use App\course_category;
use App\group_org;
use App\member;
use Illuminate\Support\Facades\Auth;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use App\enroll;
use App\Http\Resources\MyOrgDetailResource;
use App\Http\Resources\MyOrgResource;
use Illuminate\Support\Facades\DB;

class GroupOrgController extends Controller
{
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
    //    if   ($request->file('book_cer')) {
    //     $file=$request->file('book_cer');
    //     $fileN=$request->input('org_name');
    //     $filename = $fileN.'.'.$file->getClientOriginalExtension();
    //     $request->book_cer->move('storage/group_org/book_cer_assets',$filename);
    //     $post->book_cer =$filename; 
    //     } 
       $post->save();

        return response()->json(
            [
                'status' => 'success'
            ], 200);
            
    }

    public function org_destroy($id){
        group_org::find($id)->delete();
        return response()->json(
            [
                'status' => 'success'
            ], 200);
    }

    public function my_org()
    {
 /*        
        $my_org = DB::table('group_orgs')
        ->select('group_orgs.*','members.name','members.surname')
        ->join('members', 'members.member_id', '=', 'group_orgs.org_owner')
        ->where('group_orgs.org_owner','1')
        ->get();
        return response()->json($my_org);
 */   
        $my_org = group_org::where('org_owner','1')->get();
        return response()->json(
            [
               'my_org' =>  MyOrgResource::collection($my_org)
           ], 200);
        
    }

    public function org_my_join()
    {
        $org_my_join_inv = DB::table('group_orgs')
        ->select('group_orgs.*','members.*')
        ->join('members','members.member_id','=', 'group_orgs.org_owner')
        ->whereIn('group_orgs.org_id', DB::table('respond_invs')->where('member_id','1')->where('answer','=','ยืนยัน')->select('org_id'))
        ->get();
        
        $org_my_join_req = DB::table('group_orgs')
        ->select('group_orgs.*','members.*')
        ->join('members','members.member_id','=', 'group_orgs.org_owner')
        ->whereIn('group_orgs.org_id', DB::table('respond_reqs')->where('member_id','1')->where('answer','=','ยืนยัน')->select('org_id'))
        ->get();

        return response()->json(
            [
                'status' => 'success',
                'org_my_join_inv' => $org_my_join_inv->toArray(),
                'org_my_join_req' => $org_my_join_req->toArray(),
            ], 200);

    }

    public function detail_my_org($org_id)
    {
         $data = group_org::find($org_id);
         //$member_data = member::find($data->org_owner);
         //dd($member);

         $course = DB::table('enrolls')
         ->select('courses.course_id','courses.course_name','courses.course_owner','courses.course_type','enrolls.status','members.name','members.surname') 
         ->join('courses', 'courses.id','=','enrolls.course_id')
         ->join('members', 'members.member_id','=','courses.course_owner')
         ->where('enrolls.org_id',$org_id)
         ->where('enrolls.enroll_type','องค์กร')
         ->whereNotIn('enrolls.course_id', DB::table('enrolls')->where('enrolls.member_id','1')->select('enrolls.course_id'))
         ->whereNotIn('enrolls.course_id', DB::table('courses')->where('courses.course_owner','1' )->select('courses.id'))
         ->get();

         $course_me_enroll = DB::table('enrolls')
         ->select('courses.course_id','courses.course_name','courses.course_owner','courses.course_type','enrolls.status','members.name','members.surname') 
         ->join('courses', 'courses.id','=','enrolls.course_id')
         ->join('members', 'members.member_id','=','courses.course_owner')
         ->where('enrolls.member_id','1')
         ->whereIn('enrolls.course_id', DB::table('enrolls')->where('enrolls.org_id','=', $org_id )->where('enrolls.enroll_type','องค์กร')->select('enrolls.course_id'))
         ->get();


         $owner_course = DB::table('enrolls')
         ->select('courses.course_id','courses.course_name','courses.course_owner','courses.course_type','enrolls.status','members.name','members.surname') 
         ->join('courses', 'courses.id','=','enrolls.course_id')
         ->join('members', 'members.member_id','=','courses.course_owner')
         ->where('enrolls.org_id','=', $org_id )->where('enrolls.enroll_type','องค์กร')
         ->whereIn('enrolls.course_id', DB::table('courses')->where('courses.course_owner','1')->select('courses.id'))
         ->get();

        $member_in_org_inv = DB::table('respond_invs')
        ->select('members.*','respond_invs.created_at') 
        ->join('members', 'members.member_id','=','respond_invs.member_id')
        ->where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->get();

        $member_in_org_req = DB::table('respond_reqs')
        ->select('members.*') 
        ->join('members', 'members.member_id','=','respond_reqs.member_id')
        ->where('org_id','=', $org_id )
        ->where('answer','=','ยืนยัน')
        ->get();

        $org_request = DB::table('org_requests')
        ->select('members.*','org_requests.created_at') 
        ->join('members', 'members.member_id','=','org_requests.member_id')
        ->where('org_requests.org_id',$org_id)->where('org_requests.status',null)
        ->whereNotIn('org_requests.member_id', DB::table('respond_invs')
        ->where('respond_invs.org_id','=', $org_id )
        ->where('respond_invs.answer','=','ยืนยัน')
        ->select('respond_invs.member_id'))
        ->whereNotIn('org_requests.member_id', DB::table('respond_reqs')
        ->where('respond_reqs.org_id','=', $org_id )
        ->where('respond_reqs.answer','=','ยืนยัน')
        ->select('respond_reqs.member_id'))
        ->get();
        //dd($org_request);

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
        ->get();

        $member_join = member::whereIn('member_id', respond_req::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->orwhereIn('member_id', respond_inv::where('org_id','=', $org_id )->where('answer','=','ยืนยัน')->select('member_id'))
        ->where('name','!=',null)
        ->get();

        $member_request = member::whereIn('member_id', org_request::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name','!=',null)
        ->get();
        
        $member_invite = member::whereIn('member_id', org_invite::where('org_id','=', $org_id )->where('status',null)->select('member_id'))
        ->where('name','!=',null)
        ->get();   

        $member_owner = member::where('member_id','=',$data->org_owner)
        ->where('name','!=',null)
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

        return response()->json(
            [
                 'org_id' => $data->org_id,
                 'org_name' => $data->org_name,
                 'description' => $data->description,
                 'org_tel' => $data->org_tel,
                 'org_owner' => $data->owner->name." ".$data->owner->surname,
                 'address' => "เขต :"." ".$data->county." "."ถนน :"." ".$data->road." "."ตรอก/ซอย :"." ".$data->alley." "."บ้านเลขที่ :".
                                " ".$data->house_number." "."หมู่ :"." ".$data->group_no." "."ตำบล :"." ".$data->sub_district." "."อำเภอ :".
                                $data->district." "."จังหวัด :"." ".$data->province." "."รหัสไปรษณีย์ :"." ".$data->ZIP_code,
                                
                 'course' => $course->toArray(),
                //  'course_enr' => $course_enr->toArray(),
                //  'course_mio_enr' => $course_mio_enr->toArray(),oArray(),
                 'course_me_enroll' => $course_me_enroll->toArray(),
                 'owner_course' => $owner_course->toArray(),
                 'member_in_org_inv' => $member_in_org_inv->toArray(),
                 'member_in_org_req' => $member_in_org_req->toArray(),
                 'org_request' => $org_request->toArray(),
                 'member' => $member->toArray(),
                 'member_join' => $member_join->toArray(),
                 'member_request' => $member_request->toArray(),
                 'member_invite' => $member_invite->toArray(),
                 'member_owner' => $member_owner->toArray(),
                 'mio_count' => $mio_count,
                 'cio_count' => $cio_count,
                 'org_r_count' => $org_r_count,
                 //'data_org' =>  MyOrgDetailResource::collection($data)
            ], 200);
    }

    public function respond_org_invite()
    {
        $org_invite = DB::table('org_invites')
        ->select('group_orgs.*','members.name','members.surname')
        ->join('group_orgs', 'group_orgs.org_id', '=', 'org_invites.org_id')
        ->join('members', 'members.member_id', '=', 'org_invites.owner_invite')
        
        ->where('org_invites.member_id','1')->where('org_invites.status',null)
        ->whereNotIn('org_invites.org_id', respond_inv::where('member_id','1')
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->whereNotIn('org_invites.org_id', respond_req::where('member_id','1')
        ->where('answer','=','ยืนยัน')->select('org_id'))
        ->get();
        //dd($org_invite);
        $member = "มุซอับ สาแหละ";
        return response()->json(
            [
                'status' => 'success',
                'org_invite' => $org_invite->toArray(),
                'member' => $member
            ], 200);
    }

}
