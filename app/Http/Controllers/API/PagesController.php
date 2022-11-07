<?php

namespace App\Http\Controllers\API;

use App\course;
use App\course_category;
use App\enroll;
use App\group_org;
use App\Http\Controllers\Controller;
use App\lesson;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{

    public function dashboard()
    {
        $course = course::where('course_status', "เผยแพร่")->get();
        $cc = course_category::all();
        // $courses = DB::table('enrolls')
        // ->select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id')
        // ->whereIn('course_id', course::where('course_status',"เผยแพร่")->select('id'))
        // ->where('enroll_type','!=',"องค์กร")
        // ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        // ->groupBy('course_id')
        // ->get();
        // $course_ne = course::whereNotIn('id', enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id')
        //                ->where('enroll_type','!=',"องค์กร")
        //                ->where('status',"ลงทะเบียนเรียบร้อยเเล้ว")
        //                ->groupBy('course_id')->select('course_id'))
        //                ->where('course_status',"เผยแพร่")
        //                ->paginate();
        // $co_course = course::where('course_status',"เผยแพร่")->get()->count();

        // $my_course = enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id','status')
        // ->where('enroll_type','!=',"องค์กร")
        // ->where('member_id',Auth::user()->member_id)
        // ->whereIn('course_id', enroll::where('member_id',Auth::user()->member_id)->select('course_id'))
        // ->groupBy('course_id','status')
        // ->paginate();
        // $my_course_co=enroll::select(DB::raw('COUNT(enroll_id) as enr_count'),'course_id')
        // ->where('enroll_type','!=',"องค์กร")
        // ->whereIn('course_id', enroll::where('member_id',Auth::user()->member_id)->select('course_id'))
        // ->groupBy('course_id')
        // ->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'course' => $course->toArray(),
                'cc' => $cc->toArray(),
            ], 200);

    }
    public function report_org_menu($org_id)
    {
        $mio_i = respond_inv::where('org_id', '=', $org_id)
            ->where('answer', '=', 'ยืนยัน')->get()->count();
        $mio_r = respond_req::where('org_id', '=', $org_id)
            ->where('answer', '=', 'ยืนยัน')->get()->count();
        $mio_count = $mio_i + $mio_r;
        $cio_count = enroll::where('org_id', $org_id)->get()->count();
        $org_r_count = org_request::where('org_id', $org_id)->where('status', null)
            ->whereNotIn('member_id', respond_inv::where('org_id', '=', $org_id)
                    ->where('answer', '=', 'ยืนยัน')->select('member_id'))
            ->whereNotIn('member_id', respond_req::where('org_id', '=', $org_id)
                    ->where('answer', '=', 'ยืนยัน')->select('member_id'))
            ->get()->count();
    }
    public function report_course_menu(Request $request, $id)
    {
        $data = course::find($id);
        $Renroll_count = enroll::where('course_id', $id)
            ->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $id)
            ->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        if ($data->course_owner == Auth::user()->member_id) {
            $lesson_count = lesson::where('id', $id)->get()->count();
        } else {
            $lesson_count = lesson::where('id', $id)->where('lesson_status', "เผยแพร่")->get()->count();
        }
        if ($request->input('org_id') == null) {
            $data_org = '';
        } else {
            $data_org = group_org::find($request->input('org_id'));
        }
    }
    public function report_main_menu()
    {
        $member_id = 1;
        $co_my_org = group_org::where('org_owner', $member_id)->get()->count();
        $org_mjr_co = respond_req::where('member_id', $member_id)
            ->where('answer', '=', 'ยืนยัน')->get()->count();
        $org_mji_co = respond_inv::where('member_id', $member_id)
            ->where('answer', '=', 'ยืนยัน')->get()->count();
        $co_org_myjoin = $org_mji_co + $org_mjr_co;
        $co_cc=course_category::all()->count();
        $co_opc = course::where('course_owner', $member_id)->get()->count();
        $co_my_course = enroll::where('member_id', $member_id)->get()->count();
        $co_org_invite = org_invite::where('member_id', $member_id)->where('status', null)
            ->whereNotIn('org_id', respond_inv::where('member_id', $member_id)
                    ->where('answer', '=', 'ยืนยัน')->select('org_id'))
            ->whereNotIn('org_id', respond_req::where('member_id', $member_id)
                    ->where('answer', '=', 'ยืนยัน')->select('org_id'))
            ->get()->count();
        $co_set_score = DB::table('quiz_answers')->select('set_quizzes.set_name')
            ->join('set_quizzes','set_quizzes.id','=','quiz_answers.set_id')
            ->where('member_id',$member_id)
            ->distinct()
            ->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'co_my_org' => $co_my_org,
                'co_org_myjoin' => $co_org_myjoin,
                'co_cc' => $co_cc,
                'co_opc' => $co_opc,
                'co_my_course' => $co_my_course,
                'co_org_invite' => $co_org_invite,
                'co_set_score' => $co_set_score,
            ], 200);

    }
}
