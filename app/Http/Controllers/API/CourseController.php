<?php

namespace App\Http\Controllers\API;

use App\course;
use App\course_category;
use App\document;
use App\enroll;
use App\Http\Controllers\Controller;
use App\image;
use App\lesson;
use App\link_Gdrive;
use App\link_youtube;
use App\note;
use App\quiz;
use App\quiz_header;
use App\set_quiz;
use App\video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function create()
    {
        $cc = course_category::all();
        $con = course::get();
        return response()->json($cc);

    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => '',
            'cc_id' => 'required',
            'course_name' => 'required',
            'course_detail' => '',
            'course_type' => 'required',
            'course_status' => 'required',
            'price' => '',
            'course_owner' => 'required',
            'course_img' => '',
        ]);
        $cou_cate = course_category::find($request->input('cc_id'));
        $count_co = course::where('cc_id', $request->input('cc_id'))->get()->count();
        if ($count_co == 0) {
            $count_co_id = 1;
        } else {
            $count_co_id = $count_co + 1;
        }
        $post = new course;
        $post->course_id = $cou_cate->short_name . $count_co_id;
        $post->cc_id = $request->input('cc_id');
        $post->course_name = $request->input('course_name');
        $post->course_detail = $request->input('course_detail');
        $post->course_type = $request->input('course_type');
        $post->course_status = $request->input('course_status');
        $post->price = $request->input('price');
        $post->course_owner = $request->input('course_owner');
        if ($request->file('course_img')) {
            $file = $request->file('course_img');
            $fileN = $request->input('course_name');
            $filename = $fileN . '.' . $file->getClientOriginalExtension();
            $request->course_img->move('storage/course/course_img_assets', $filename);
            $post->course_img = $filename;
        }
        $post->save();

        return response()->json(
            [
                'status' => 'success',
            ], 200);

    }

    public function my_opencourse()
    {
        $opc = course::where('course_owner', '1')->get();
        return response()->json($opc);
    }

    public function my_course()
    {
        $my_course = DB::table('enrolls')
            ->select('courses.*', 'enrolls.enroll_type', 'enrolls.status as enr_status', 'members.name as tutor_name')
            ->join('courses', 'courses.id', '=', 'enrolls.course_id')
            ->join('members', 'members.member_id', '=', 'courses.course_owner')
            ->where('enrolls.member_id', '1')
            ->get();

        //dd($my_course);
        return response()->json($my_course);
    }

    public function course_destroy($id)
    {
        course::find($id)->delete();
        return response()->json(
            [
                'status' => 'success',
            ], 200);

    }

    public function cc_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:course_categories',
            'short_name' => 'required|unique:course_categories',
        ]);
        if ($validator->fails()) {
            redirect()->back()->with('error', "ชื่อหมวดหมู่หรืออักษรย่อซ้ำ กรุณาป้อนข้อมูลใหม่");
        }
        $request->validate([
            'name' => 'required|unique:course_categories',
            'short_name' => 'required|unique:course_categories',
        ]);

        $post = new course_category;
        $post->name = $request->input('name');
        $post->short_name = $request->input('short_name');
        //dd($post);
        $post->save();
        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }

    public function cc_show()
    {
        $cc = course_category::all();
        return response()->json($cc);
    }

    public function cc_destroy($id)
    {
        course_category::find($id)->delete();
        return response()->json(
            [
                'status' => 'success',
            ], 200);

    }

    public function course_detail($id)
    {
        $data_course = course::find($id);
        $lesson_owner = lesson::where('id', $id)->get();
        $lesson = lesson::where('id', $id)->where('lesson_status', "เผยแพร่")->get();
        $org_enroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_enroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_Renroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();
        $org_Renroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();

        $Renroll_count = enroll::where('course_id', $id)->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $id)->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        $lesson_owner_count = lesson::where('id', $id)->get()->count();
        $lesson_count = lesson::where('id', $id)->where('lesson_status', "เผยแพร่")->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'data_course' => $data_course,
                'lesson' => $lesson->toArray(),
                'lesson_owner' => $lesson_owner->toArray(),
                'person_enroll' => $person_enroll->toArray(),
                'org_enroll' => $org_enroll->toArray(),
                'person_Renroll' => $person_Renroll->toArray(),
                'org_Renroll' => $org_Renroll->toArray(),
                'Renroll_count' => $Renroll_count,
                'Penroll_count' => $Penroll_count,
                'lesson_owner_count' => $lesson_owner_count,
                'lesson_count' => $lesson_count,
            ], 200);
    }

    public function lesson_page($id)
    {
        $lesson_data = lesson::find($id);

        $link_y = link_youtube::where('lesson_id', $id)->get();
        $video = video::where('lesson_id', $id)->get();
        $link_g = link_Gdrive::where('lesson_id', $id)->get();
        $document = document::where('lesson_id', $id)->get();
        $image = image::where('lesson_id', $id)->get();

        $set_quiz_owner = set_quiz::where('lesson_id', $id)->get();
        $set_quiz = set_quiz::where('lesson_id', '=', $id)->where('status', "เผยแพร่")->get();

        $data_course = course::find($lesson_data->id);
        $lesson_owner = lesson::where('id', $lesson_data->id)->get();
        $lesson = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get();
        $org_enroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_enroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_Renroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();
        $org_Renroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();

        $Renroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        $lesson_owner_count = lesson::where('id', $lesson_data->id)->get()->count();
        $lesson_count = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'lesson_data' => $lesson_data,
                'link_y' => $link_y->toArray(),
                'video' => $video->toArray(),
                'link_g' => $link_g->toArray(),
                'document' => $document->toArray(),
                'image' => $image->toArray(),
                'set_quiz_owner' => $set_quiz_owner->toArray(),
                'set_quiz' => $set_quiz->toArray(),
                'data_course' => $data_course,
                'lesson_owner' => $lesson_owner->toArray(),
                'lesson' => $lesson->toArray(),
                'person_enroll' => $person_enroll->toArray(),
                'org_enroll' => $org_enroll->toArray(),
                'person_Renroll' => $person_Renroll->toArray(),
                'org_Renroll' => $org_Renroll->toArray(),
                'Renroll_count' => $Renroll_count,
                'Penroll_count' => $Penroll_count,
                'lesson_owner_count' => $lesson_owner_count,
                'lesson_count' => $lesson_count,
            ], 200);
    }

    public function learning_pages($id)
    {
        $lesson_data = lesson::find($id);

        $note = note::where('lesson_id', $id)->where('creator', '1')->get();
        //dd($note);
        $set_quiz = set_quiz::where('lesson_id', '=', $id)->where('status', "เผยแพร่")->get();

        $link_y = link_youtube::where('lesson_id', $id)->get();
        $video = video::where('lesson_id', $id)->get();
        $link_g = link_Gdrive::where('lesson_id', $id)->get();
        $document = document::where('lesson_id', $id)->get();
        $image = image::where('lesson_id', $id)->get();

        $data_course = course::find($lesson_data->id);
        $lesson_owner = lesson::where('id', $lesson_data->id)->get();
        $lesson = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get();
        //dd($lesson);
        $org_enroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_enroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_Renroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();
        $org_Renroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();

        $Renroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        $lesson_owner_count = lesson::where('id', $lesson_data->id)->get()->count();
        $lesson_count = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'lesson_data' => $lesson_data,
                'note' => $note->toArray(),
                'link_y' => $link_y->toArray(),
                'video' => $video->toArray(),
                'link_g' => $link_g->toArray(),
                'document' => $document->toArray(),
                'image' => $image->toArray(),
                'set_quiz' => $set_quiz->toArray(),
                //'set_score' => $set_score->toArray(),
                'data_course' => $data_course,
                'lesson_owner' => $lesson_owner->toArray(),
                'lesson' => $lesson->toArray(),
                'person_enroll' => $person_enroll->toArray(),
                'org_enroll' => $org_enroll->toArray(),
                'person_Renroll' => $person_Renroll->toArray(),
                'org_Renroll' => $org_Renroll->toArray(),
                'Renroll_count' => $Renroll_count,
                'Penroll_count' => $Penroll_count,
                'lesson_owner_count' => $lesson_owner_count,
                'lesson_count' => $lesson_count,
            ], 200);
    }

    public function quest_quiz($id)
    {
        $set_quiz_data = set_quiz::find($id);

        $h_quiz = quiz_header::where('id', $id)->get();
        //dd($h_quiz);
        $quiz = quiz::all();

        $lesson_data = lesson::find($set_quiz_data->lesson_id);

        $link_y = link_youtube::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $video = video::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $link_g = link_Gdrive::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $document = document::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $image = image::where('lesson_id', $set_quiz_data->lesson_id)->get();

        $set_quiz_owner = set_quiz::where('lesson_id', '=', $set_quiz_data->lesson_id)->get();
        //dd($set_quiz);
        $data_course = course::find($lesson_data->id);
        $lesson_owner = lesson::where('id', $lesson_data->id)->get();
        $lesson = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get();
        $org_enroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_enroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_Renroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();
        $org_Renroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();

        $Renroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        $lesson_owner_count = lesson::where('id', $lesson_data->id)->get()->count();
        $lesson_count = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'set_quiz_data' => $set_quiz_data,
                'h_quiz' => $h_quiz->toArray(),
                'quiz' => $quiz->toArray(),
                'lesson_data' => $lesson_data,
                'link_y' => $link_y->toArray(),
                'video' => $video->toArray(),
                'link_g' => $link_g->toArray(),
                'document' => $document->toArray(),
                'image' => $image->toArray(),
                'set_quiz_owner' => $set_quiz_owner->toArray(),
                'data_course' => $data_course,
                'lesson_owner' => $lesson_owner->toArray(),
                'lesson' => $lesson->toArray(),
                'person_enroll' => $person_enroll->toArray(),
                'org_enroll' => $org_enroll->toArray(),
                'person_Renroll' => $person_Renroll->toArray(),
                'org_Renroll' => $org_Renroll->toArray(),
                'Renroll_count' => $Renroll_count,
                'Penroll_count' => $Penroll_count,
                'lesson_owner_count' => $lesson_owner_count,
                'lesson_count' => $lesson_count,
            ], 200);
    }

    public function ans_quiz($id)
    {
        $set_quiz_data = set_quiz::find($id);
        $lesson = lesson::find($set_quiz_data->lesson_id);
        $h_quiz = quiz_header::inRandomOrder()->where('id', $id)->get();
        $quiz = quiz::inRandomOrder()->get();
        //dd($set_quiz_data);

        return response()->json(
            [
                'status' => 'success',
                'set_quiz_data' => $set_quiz_data,
                'lesson' => $lesson,
                'h_quiz' => $h_quiz->toArray(),
                'quiz' => $quiz->toArray(),
            ], 200);
    }

    public function set_score()
    {
        $set_score = DB::table('quiz_answers')->select('set_quizzes.set_name', 'quiz_answers.set_id')
            ->join('set_quizzes', 'set_quizzes.id', '=', 'quiz_answers.set_id')
            ->where('member_id', '1')
            ->distinct()
            ->get();
        //dd($set_score);

        return response()->json(
            [
                'status' => 'success',
                'set_score' => $set_score->toArray(),
            ], 200);
    }

    public function score($id)
    {
        $set_quiz_data = set_quiz::find($id);

        $score = DB::table('quizzes')
            ->select('members.name', 'members.surname', 'quiz_answers.created_at', DB::raw('SUM(quizzes.result) AS value'))
            ->join('quiz_answers', 'quiz_answers.result', '=', 'quizzes.id')
            ->join('members', 'members.member_id', '=', 'quiz_answers.member_id')
            ->where('quiz_answers.member_id', '1')
            ->groupBy('members.name', 'members.surname', 'quiz_answers.created_at')
            ->get();
        $co_quiz = quiz_header::where('id', $id)->get()->count();
        //dd($score);

        $h_quiz = quiz_header::where('id', $id)->get();
        //dd($h_quiz);
        $quiz = quiz::all();

        $lesson_data = lesson::find($set_quiz_data->lesson_id);

        $link_y = link_youtube::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $video = video::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $link_g = link_Gdrive::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $document = document::where('lesson_id', $set_quiz_data->lesson_id)->get();
        $image = image::where('lesson_id', $set_quiz_data->lesson_id)->get();

        $set_quiz = set_quiz::where('lesson_id', '=', $set_quiz_data->lesson_id)->where('status', "เผยแพร่")->get();
        // dd($set_quiz);
        $data_course = course::find($lesson_data->id);
        $lesson_owner = lesson::where('id', $lesson_data->id)->get();
        $lesson = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get();
        $org_enroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_enroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "ลงทะเบียนเรียบร้อยเเล้ว")
            ->get();
        $person_Renroll = DB::table('enrolls')
            ->join('members', 'members.member_id', '=', 'enrolls.member_id')
            ->select('members.name', 'members.surname', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();
        $org_Renroll = DB::table('enrolls')
            ->join('group_orgs', 'group_orgs.org_id', '=', 'enrolls.org_id')
            ->select('group_orgs.org_name', 'enrolls.enroll_type', 'enrolls.created_at')
            ->where('enrolls.course_id', $lesson_data->id)
            ->where('enrolls.status', "รอดำเนินการ")
            ->get();

        $Renroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "รอดำเนินการ")->get()->count();
        $Penroll_count = enroll::where('course_id', $lesson_data->id)->where('status', "ลงทะเบียนเรียบร้อยเเล้ว")->get()->count();
        $lesson_owner_count = lesson::where('id', $lesson_data->id)->get()->count();
        $lesson_count = lesson::where('id', $lesson_data->id)->where('lesson_status', "เผยแพร่")->get()->count();

        return response()->json(
            [
                'status' => 'success',
                'set_quiz_data' => $set_quiz_data,
                'score' => $score->toArray(),
                'co_quiz' => $co_quiz,
                'h_quiz' => $h_quiz->toArray(),
                'quiz' => $quiz->toArray(),
                'lesson_data' => $lesson_data,
                'link_y' => $link_y->toArray(),
                'video' => $video->toArray(),
                'link_g' => $link_g->toArray(),
                'document' => $document->toArray(),
                'image' => $image->toArray(),
                'set_quiz' => $set_quiz->toArray(),
                'data_course' => $data_course,
                'lesson_owner' => $lesson_owner->toArray(),
                'lesson' => $lesson->toArray(),
                'person_enroll' => $person_enroll->toArray(),
                'org_enroll' => $org_enroll->toArray(),
                'person_Renroll' => $person_Renroll->toArray(),
                'org_Renroll' => $org_Renroll->toArray(),
                'Renroll_count' => $Renroll_count,
                'Penroll_count' => $Penroll_count,
                'lesson_owner_count' => $lesson_owner_count,
                'lesson_count' => $lesson_count,
            ], 200);
    }

}
