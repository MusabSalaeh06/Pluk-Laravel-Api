<?php

use App\user_status;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {return view('test_blade');});
Route::get('/index', function () {return view('index');});
Route::get('/welcome', function () {return view('welcome');});

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:member'], function () {

    //profile
    Route::get('/profile', 'MemberController@show_profile')->name('profile');//หน้าโปรไฟล์
    Route::get('/profile_edit_{member_id}', 'MemberController@edit_profile')->name('profile.edit');//แก้ไขข้อมูลส่วนตัว
    Route::put('/profile_update_{member_id}', 'MemberController@update_profile')->name('profile.update');//บันทึกการแก้ไข
    Route::post('/my_school/store', 'MemberController@my_school')->name('my_school.store');//บันทึกข้อมูลสถาบัน
    Route::post('/my_job/store', 'MemberController@my_job')->name('my_job.store');//บันทึกข้อมูลการทำงาน
    Route::put('/my_school/update/{id}', 'MemberController@my_school_update')->name('my_school.update');//บันทึกข้อมูลสถาบัน
    Route::put('/my_job/update/{id}', 'MemberController@my_job_update')->name('my_job.update');//บันทึกข้อมูลการทำงาน
    Route::delete('/my_school/delete/{id}', 'MemberController@my_school_destroy')->name('my_school.destroy');//บันทึกข้อมูลสถาบัน
    Route::delete('/my_job/delete/{id}', 'MemberController@my_job_destroy')->name('my_job.destroy');//บันทึกข้อมูลการทำงาน

    //หน้าแรก
    Route::get('/', 'PagesController@index')->name('index'); 
    //องค์กรของฉัน.
    Route::get('/my_org', 'PagesController@my_org')->name('pages.my_org'); 
    //รายวิชาที่เปิดสอน
    Route::get('/my_opencourse', 'PagesController@my_opencourse')->name('pages.my_opencourse'); 
    //องค์กรที่ฉันเข้าร่วม
    Route::get('/org_my_join', 'PagesController@org_my_join')->name('pages.org_my_join'); 
    //ออกจากองค์กรที่ฉันเข้าร่วม
    Route::DELETE('/delete/org_my_join/inv/{id}', 'PagesController@org_my_join_inv_destroy')->name('org_my_join_inv.destroy');//ลบข้อมูล
    Route::DELETE('/delete/org_my_join/req/{id}', 'PagesController@org_my_join_req_destroy')->name('org_my_join_req.destroy');//ลบข้อมูล 
    //หน้ารายวิชาที่เฉันลงทะเบียน
    Route::get('/my_course', 'PagesController@my_course')->name('page.my_course'); 
    //หน้าคำเชิญเข้าองค์กร
    Route::get('respond/invite/org', 'PagesController@respond_invite_org')->name('pages.respond_invite_org'); 
    //ตอบรับการเชิญ
    Route::post('respond/invite/org/store/{invite_id}', 'PagesController@respond_invite_org_store')->name('pages.respond_invite_org.store');
    //หน้าการค้นหา
    Route::get('/page_search', 'PagesController@page_search')->name('pages.page_search'); 
    //หน้าค้นหาองค์กร
    Route::get('/search_org', 'GroupOrgController@search')->name('pages.search_org'); 
    //ขอเข้าร่วมองค์กร
    Route::post('/request/org/store', 'PagesController@request_org_store')->name('pages.request_org.store');
    //ค้นหารายวิชา
    Route::get('/search_course', 'CourseController@search')->name('pages.search_course'); 
    //ข้อมูลรายวิชา
    Route::get('/course/detail/{id}','PagesController@course_detail')->name('pages.course_detail'); 
    //ทำการลงทะเบียนรายวิชา
    Route::post('/enroll/store', 'PagesController@enroll_store')->name('enroll.store'); 

    //กลุ่มองค์กร group_org
    Route::get('/group_org_create', 'GroupOrgController@create')->name('group_org.create');
    Route::post('/group_org/store', 'GroupOrgController@store')->name('group_org.store');//บันทึกข้อมูล
    Route::get('/group_org/show', 'GroupOrgController@show')->name('group_org.show'); //หน้าแสดง
    Route::get('/group_org/edit/{org_id}', 'GroupOrgController@edit')->name('group_org.edit');//หน้าแก้ไข
    Route::put('/group_org/update/{org_id}', 'GroupOrgController@update')->name('group_org.update');//บันทึกการแก้ไข
    Route::DELETE('/group_org/destroy/{org_id}', 'GroupOrgController@destroy')->name('group_org.destroy');//ลบข้อมูล

    //หน้าแรกขององค์กร
    Route::get('/index/org/{org_id}','PagesController@org_index')->name('pages.index_org'); 
    //รายวิชาขององค์กร
    Route::get('/course/in/org/{org_id}', 'PagesController@course_in_org')->name('pages.course_in_org'); 
    //ค้นหารายวิชาสำหรับองค์กร
    Route::get('/org_search_course/{org_id}', 'CourseController@org_search_course')->name('pages.org_search_course');
    //ข้อมูลรายวิชาสำหรับลงทะเบียนผ่านองค์กร
    Route::get('/course/detail/org/{enroll_id}','PagesController@course_detail_org')->name('pages.course_detail_org'); 
    //รายวิชาที่องค์กรลงทะเบียน
    Route::get('/enroll/in/org/{org_id}', 'PagesController@enroll_in_org')->name('enroll.in.org'); 
    //สมาชิกขององค์กร
    Route::get('/member/in/org/{org_id}', 'PagesController@member_in_org')->name('pages.member_in_org'); 
    //ลบสมาชิกออจากองค์กร
    Route::DELETE('/delete/member/in/org/inv/{id}', 'PagesController@member_in_org_inv_destroy')->name('member_in_org_inv.destroy');//ลบข้อมูล
    Route::DELETE('/delete/member/in/org/req/{id}', 'PagesController@member_in_org_req_destroy')->name('member_in_org_req.destroy');//ลบข้อมูล
    //หน้าตอบกลับการขอเข้าร่วมองค์กร
    Route::get('/respond/request/org/{org_id}', 'PagesController@respond_request_org')->name('pages.respond_request_org'); 
    //ตอบกลับการขอข้าร่วมองค์กร
    Route::post('/respond/request/org/store/{org_id}', 'PagesController@respond_request_org_store')->name('pages.respond_request_org.store');
    //หน้าเชิญคนเข้าองค์กร
    Route::get('/invite/org/{org_id}', 'PagesController@invite_org')->name('pages.invite_org'); 
    //เชิญคนเข้าองค์กร
    Route::post('/invite/org/store/{org_id}', 'PagesController@invite_org_store')->name('pages.invite_org.store'); 
    //ค้นหาสมาชิกสำหรับเชิญเข้าองค์กร
    Route::get('/member/search/{org_id}', 'MemberController@member_search')->name('pages.member_search'); 
    
    //หมวดหมู่รายวิชา
    Route::get('/course_category/create', 'CourseController@cc_create')->name('course_category.create');
    Route::post('/course_category/store', 'CourseController@cc_store')->name('course_category.store');//บันทึกข้อมูล
    Route::get('/course_category/edit/{id}', 'CourseController@cc_edit')->name('course_category.edit');//แก้ไข
    Route::put('/course_category/update/{id}', 'CourseController@cc_update')->name('course_category.update');//บันทึกการแก้ไข
    Route::DELETE('/course_category/destroy/{id}', 'CourseController@cc_destroy')->name('course_category.destroy');//ลบข้อมูล
    Route::get('/course_category/show', 'CourseController@cc_show')->name('course_category.show');//หมวดหมู่รายวิชาทั้งหมด

    //รายวิชา course  
    Route::get('/course_create', 'CourseController@create')->name('course.create');
    Route::post('/course/store', 'CourseController@store')->name('course.store');//บันทึกข้อมูล
    Route::get('/course/edit/{id}', 'CourseController@edit')->name('course.edit');//แก้ไข
    Route::put('/course/update/{id}', 'CourseController@update')->name('course.update');//บันทึกการแก้ไข
    Route::DELETE('/course/destroy/{id}', 'CourseController@destroy')->name('course.destroy');//ลบข้อมูล
    Route::get('/course_show', 'CourseController@show')->name('course.course_show');//รายวิชาทั้งหมด   
    //เกี่ยวกับรายวิชา
    Route::get('/course/index/{id}','PagesController@course_index')->name('pages.course_index');  
    //จัดการบทเรียน
    Route::get('/manage/lesson/{id}','PagesController@manage_lesson')->name('pages.manage_lesson');   
    //หน้าเพิ่มบทเรียน
    Route::get('/lesson/create/course_id/{id}', 'LessonController@create')->name('lesson.create');
    Route::post('/lesson/store', 'LessonController@store')->name('lesson.store'); 
    //หน้าแก้ไขบทเรียน
    Route::get('/lesson/edit/{lesson_id}', 'LessonController@edit')->name('lesson.edit');
    Route::put('/lesson/update/{lesson_id}', 'LessonController@update')->name('lesson.update'); 
    //ลบบทเรียน
    Route::delete('/lesson/destroy/{lesson_id}', 'LessonController@destroy')->name('lesson.destroy'); 
    //หน้าคำขอลงทะเบียน
    Route::get('/response/enroll/{course_id}', 'PagesController@response_enroll')->name('pages.response.enroll'); 
    //ตอบกลับการลงทะเบียน
    Route::post('/invite/enroll/{enroll_id}', 'PagesController@invite_enroll')->name('pages.invite.enroll');  
    //รายชื่อผู้ลงทะเบียน
    Route::get('/person/enroll/{course_id}', 'PagesController@person_enroll')->name('pages.person.enroll'); 
    //ทำการลบผู้ลงทะเบียน
    Route::delete('/enroll/destroy/{enroll_id}', 'PagesController@enroll_destroy')->name('enroll.destroy'); 

    //หน้าบทเรียน
    Route::get('/lesson/page/{lesson_id}','PagesController@lesson_page')->name('pages.lesson_page');  

    //จัดการยูทูป.
     Route::post('/link/youtube/store', 'PagesController@link_youtube_store')->name('link.youtube.store');//เพิ่มลิงค์วิดีโอยูทูป
     Route::get('/link/youtube/edit/{lesson_id}', 'PagesController@link_youtube_edit')->name('link.youtube.edit');//แก้ไขลิงค์วิดีโอยูทูป
     Route::put('/link/youtube/update/{lesson_id}', 'PagesController@link_youtube_update')->name('link.youtube.update');//อัพเดทลิงค์วิดีโอยูทูป
     Route::delete('/link/youtube/destroy/{id}', 'PagesController@link_youtube_destroy')->name('link.youtube.destroy');//ลบลิงค์วิดีโอยูทูป
     //จัดการลิงค์ภายนอก.
     Route::post('/link/Gdrive/store', 'PagesController@link_Gdrive_store')->name('link.Gdrive.store'); //เพิ่มลิงค์ภายนอก
     Route::get('/link/Gdrive/edit/{lesson_id}', 'PagesController@link_Gdrive_edit')->name('link.Gdrive.edit');//แก้ไขลิงค์ภายนอก
     Route::put('/link/Gdrive/update/{lesson_id}', 'PagesController@link_Gdrive_update')->name('link.Gdrive.update');//อัพเดทลิงค์ภายนอก
     Route::delete('/link/Gdrive/destroy/{id}', 'PagesController@link_Gdrive_destroy')->name('link.Gdrive.destroy'); //ลบลิงค์ภายนอก
     //จัดการเอกสาร.
     Route::post('/document/store', 'PagesController@document_store')->name('document.store'); //เพิ่มไฟล์เอกสาร
     Route::get('/document/edit/{lesson_id}', 'PagesController@document_edit')->name('document.edit');//แก้ไขไฟล์เอกสาร
     Route::put('/document/update/{lesson_id}', 'PagesController@document_update')->name('document.update');//อัพเดทไฟล์เอกสาร
     Route::delete('/document/destroy/{id}', 'PagesController@document_destroy')->name('document.destroy'); //ลบไฟล์เอกสาร
     //จัดการไฟล์วิดีโอ.
     Route::post('/video/store', 'PagesController@video_store')->name('video.store');//เพิ่มไฟล์วิดีโอ
     Route::get('/link/video/edit/{lesson_id}', 'PagesController@video_edit')->name('video.edit');//แก้ไขไฟล์วิดีโอ
     Route::put('/link/video/update/{lesson_id}', 'PagesController@video_update')->name('video.update');//อัพเดทไฟล์วิดีโอ
     Route::delete('/video/destroy/{id}', 'PagesController@video_destroy')->name('video.destroy');//ลบไฟล์วิดีโอ
     //จัดการไฟล์ภาพ.
     Route::post('/image/store', 'PagesController@image_store')->name('image.store'); //เพิ่มไฟล์ภาพ
     Route::get('/link/image/edit/{lesson_id}', 'PagesController@image_edit')->name('image.edit');//แก้ไขไฟล์ภาพ
     Route::put('/link/image/update/{lesson_id}', 'PagesController@image_update')->name('image.update');//อัพเดทไฟล์ภาพ
     Route::delete('/image/destroy/{id}', 'PagesController@image_destroy')->name('image.destroy');//ลบไฟล์ภาพ

    //เพิ่มชุดแบบทดสอบ
    Route::get('/set/quiz/{lesson_id}', 'PagesController@set_quiz')->name('set.quiz');
    //เพิ่มชุดแบบทดสอบ
    Route::put('/set/quiz/edit/{id}', 'PagesController@set_quiz_edit')->name('set_quiz.edit');
    //เพิ่มชุดแบบทดสอบ
    Route::delete('/set/quiz/destroy/{id}', 'PagesController@set_quiz_destroy')->name('set_quiz.destroy');
    //แบบทดสอบ
    Route::get('/add/quiz/{id}', 'PagesController@add_quiz')->name('add.quiz'); 
    //เพิ่มแบบทดสอบ
    Route::post('/quiz/store', 'PagesController@quiz_store')->name('quiz.store'); 
    //แก้ไขหัวข้อแบบทดสอบ
    Route::put('/quiz_h/edit/{qh_id}', 'PagesController@quiz_h_edit')->name('quiz_h.edit'); 
    //ลบหัวข้อแบบทดสอบ
    Route::delete('/quiz_h/destroy/{qh_id}', 'PagesController@quiz_h_destroy')->name('quiz_h.destroy'); 
    //แก้ไขช้อย
    Route::put('/quiz/edit/{id}', 'PagesController@quiz_edit')->name('quiz.edit'); 
    //ลบช้อย
    Route::delete('/quiz/destroy/{id}', 'PagesController@quiz_destroy')->name('quiz.destroy'); 

    //หน้าการเรียนรู้
    Route::get('/learning/page/{lesson_id}', 'PagesController@learning_page')->name('pages.learning_page'); 

    //หน้าบันทึกย่อแบบบุคคล
    Route::get('/page_send_note/{lesson_id}','PagesController@page_send_note')->name('pages.page_send_note');  
    //หน้าบันทึกย่อแบบองค์กร
    Route::get('/page_send_note_org/{lesson_id}','PagesController@page_send_note_org')->name('pages.page_send_note_org');  
    //หน้าบันทึกย่อของสมาชิกภายในองค์กร
    Route::post('/note_member_in_org/{lesson_id}','PagesController@note_member_in_org')->name('pages.note_member_in_org');  
    //เพิ่มบันทึกย่อ
    Route::post('/note/store', 'PagesController@note_store')->name('note.store'); 
    //แก้ไขบันทึกย่อ
    Route::post('/note/update/{id}', 'PagesController@note_update')->name('note.update');
    //ลบบันทึกย่อ
    Route::delete('/note/destroy/{id}', 'PagesController@note_destroy')->name('note.destroy');  

    //รายละเอียดแบบทดสอบ
    Route::get('/detail/answer/quiz/{id}', 'PagesController@detail_answer_quiz')->name('detail.answer.quiz'); 
    //ตอบแบบทดสอบ
    Route::get('/answer/quiz/{id}', 'PagesController@answer_quiz')->name('answer.quiz'); 
    //บันทึกคำตอบ จากการทำแบบทดสอบ
    Route::post('/answer/store/{id}', 'PagesController@answer_store')->name('answer.store'); 
    //ดูชุดคะแนน
    Route::get('/set/score/{lesson_id}', 'PagesController@set_score')->name('set.score'); 
    //ดุคะแนน
    Route::get('/quiz/score/{id}', 'PagesController@quiz_score')->name('quiz.score');  

    //testvdoc
    Route::get('/testvdoc_create', 'TestvdocController@create');
    Route::post('/testvdoc_store', 'TestvdocController@store')->name('testvdoc.store');//บันทึกข้อมูล
    Route::get('/testvdoc_show', 'TestvdocController@show'); 
    Route::get('/testvdoc_edit_{member_id}', 'TestvdocController@edit')->name('testvdoc.edit');//แก้ไข
    Route::put('/testvdoc_update_{member_id}', 'TestvdocController@update')->name('testvdoc.update');//บันทึกการแก้ไข
    Route::DELETE('/testvdoc_destroy_{member_id}', 'TestvdocController@destroy')->name('testvdoc.destroy');//ลบข้อมูล

});

// Route::group(['middleware' => 'auth:manager'], function () {
   
// });

// Route::group(['middleware' => 'auth:tutor'], function () {
   
// });

// Route::group(['middleware' => 'auth:student'], function () {
   
// });
 
