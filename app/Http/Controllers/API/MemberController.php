<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\course;
use App\enroll;
use App\group_org;
use App\lesson;
use App\member;
use App\my_job;
use App\my_school;
use App\org_invite;
use App\org_request;
use App\respond_inv;
use App\respond_req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function profile()
    {
        $profile = member::where('member_id', Auth::user()->member_id)->paginate(1);
    }
    public function profile_update(Request $request, $member_id)
    {
        $request->validate([
            'email' => 'required', 'string', 'email', 'max:255', 'unique:managers',
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
        if ($request->file('profile')) {
            $file = $request->file('profile');
            $fileN = $request->input('name');
            $filename = $fileN . '.' . $file->getClientOriginalExtension();
            $request->profile->move('storage/member/member_assets', $filename);
            $post->profile = $filename;
        }
        $post->save();
        return redirect('/profile')->with('edit', 'ระบบได้แก้ไขข้อมูลโปรไฟล์ของคุณเรียบร้อยเเล้ว');
    }
    public function my_school_store(Request $request)
    {
        $request->validate([
            'school_name' => 'required',
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
        return redirect('/profile')->with('status', 'ระบบได้เพิ่มข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }
    public function my_school()
    {
        $data_school = my_school::where('member_id', Auth::user()->member_id)->paginate();
        if ($data_school->isEmpty()) {
            $my_school = '';
        } else {
            $my_school = $data_school;
        }
    }
    public function my_school_update(Request $request, $id)
    {
        $request->validate([
            'school_name' => 'required',
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
        return redirect('/profile')->with('edit', 'ระบบได้แก้ไขข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }
    public function my_school_destroy($id)
    {my_school::destroy($id);
        return redirect('/profile')->with('destroy', 'ระบบได้ลบข้อมูลสถาบันของคุณเรียบร้อยเเล้ว');
    }
    public function my_job_store(Request $request)
    {
        $post = new my_job;
        $post->wp_name = $request->input('wp_name');
        $post->start = $request->input('start');
        $post->end = $request->input('end');
        $post->job_title = $request->input('job_title');
        $post->member_id = $request->input('member_id');
        $post->save();
        return redirect('/profile')->with('status', 'ระบบได้เพิ่มข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
    public function my_job()
    {
        $data_job = my_job::where('member_id', Auth::user()->member_id)->paginate(1);
        if ($data_job->isEmpty()) {
            $my_job = '';
        } else {
            $my_job = $data_job;
        }
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
        return redirect('/profile')->with('edit', 'ระบบได้แก้ไขข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
    public function my_job_destroy($id)
    {my_job::destroy($id);
        return redirect('/profile')->with('destroy', 'ระบบได้ลบข้อมูลสถานที่ทำงานของคุณเรียบร้อยเเล้ว');
    }
    public function member_search(Request $request, $org_id)
    {
        $data = group_org::find($org_id);
        $search = $request->get('search');
        $member = member::where('member_id', '!=', $data->org_owner)
            ->whereNotIn('member_id', respond_inv::where('org_id', '=', $org_id)
                    ->where('answer', '=', 'ยืนยัน')
                    ->select('member_id'))
            ->whereNotIn('member_id', org_invite::where('org_id', '=', $org_id)
                    ->where('status', null)
                    ->select('member_id'))
            ->whereNotIn('member_id', respond_req::where('org_id', '=', $org_id)
                    ->where('answer', '=', 'ยืนยัน')
                    ->select('member_id'))
            ->whereNotIn('member_id', org_request::where('org_id', '=', $org_id)
                    ->where('status', null)
                    ->select('member_id'))
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        $member_join = member::whereIn('member_id', respond_req::where('org_id', '=', $org_id)->where('answer', '=', 'ยืนยัน')->select('member_id'))
            ->orwhereIn('member_id', respond_inv::where('org_id', '=', $org_id)->where('answer', '=', 'ยืนยัน')->select('member_id'))
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        $member_request = member::whereIn('member_id', org_request::where('org_id', '=', $org_id)->where('status', null)->select('member_id'))
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        $member_invite = member::whereIn('member_id', org_invite::where('org_id', '=', $org_id)->where('status', null)->select('member_id'))
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);

        $member_owner = member::where('member_id', '=', $data->org_owner)
            ->where('name', 'like', '%' . $search . '%')
            ->paginate(10);
    }
}
