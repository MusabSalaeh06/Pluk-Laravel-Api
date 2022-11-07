<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'API\Auth\LoginController@login')->name('login');

Route::get('/report-main-menu', 'API\PagesController@report_main_menu')->name('report.main.menu');
Route::get('/report-org-menu', 'API\PagesController@report_org_menu')->name('report.org.menu');
Route::get('/report-course-menu', 'API\PagesController@report_course_menu')->name('report.course.menu');
Route::get('/dashboard', 'API\PagesController@dashboard')->name('dashboard');

//profile
Route::get('/profile', 'API\MemberController@profile')->name('profile');//ข้อมูลโปรไฟล์
Route::put('/profile/update/{member_id}', 'API\MemberController@profile_update')->name('profile.update');//บันทึกการแก้ไขข้อมูลโปรไฟล์
Route::get('/my-school', 'API\MemberController@my_school')->name('my.school');//ข้อมูลสถาบัน
Route::post('/my-school/store', 'API\MemberController@my_school_store')->name('my.school.store');//บันทึกข้อมูลสถาบัน
Route::post('/my-school/update/{id}', 'API\MemberController@my_school_update')->name('my.school.update');//แก้ไขข้อมูลสถาบัน
Route::delete('/my-school/delete/{id}', 'API\MemberController@my_school_destroy')->name('my.school.destroy');//ลบข้อมูลสถาบัน
Route::get('/my-job', 'API\MemberController@my_job')->name('my.job');//ข้อมูลการทำงาน
Route::post('/my-job/store', 'API\MemberController@my_job_store')->name('my.job.store');//บันทึกข้อมูลการทำงาน
Route::post('/my-job/update/{id}', 'API\MemberController@my_job_update')->name('my.job.update');//แก้ไขข้อมูลการทำงาน
Route::delete('/my-job/delete/{id}', 'API\MemberController@my_job_destroy')->name('my.job.destroy');//ลบข้อมูลการทำงาน

/**

Route::get('/my_org', 'API\GroupOrgController@my_org')->name('my_org'); 
Route::get('/org/detail/{org_id}', 'API\GroupOrgController@detail_my_org')->name('detail.my_org'); 
Route::post('/org/store', 'API\GroupOrgController@store')->name('group_org.store');//บันทึกข้อมูล
Route::DELETE('/org/destroy/{id}', 'API\GroupOrgController@org_destroy')->name('org.destroy'); 

Route::get('/org_my_join', 'API\GroupOrgController@org_my_join')->name('org_my_join');

Route::post('/course_category/store', 'API\CourseController@cc_store')->name('course_category.store');//บันทึกข้อมูล
Route::get('/course_category/show', 'API\CourseController@cc_show')->name('course_category.show');//หมวดหมู่รายวิชาทั้งหมด
Route::delete('/course_category/destroy/{id}', 'API\CourseController@cc_destroy')->name('course_category.destroy');//หมวดหมู่รายวิชาทั้งหมด

Route::get('/my_opencourse', 'API\CourseController@my_opencourse')->name('my_opencourse');
Route::get('/course/detail/{id}', 'API\CourseController@course_detail')->name('my_opencourse.detail');
Route::get('/course/create', 'API\CourseController@create')->name('course.create');
Route::post('/course/store', 'API\CourseController@store')->name('course.store');//บันทึกข้อมูล
Route::DELETE('/course/destroy/{id}', 'API\CourseController@course_destroy')->name('org.destroy'); 

Route::get('/my_course', 'API\CourseController@my_course')->name('my_course');

Route::get('/lesson/page/{id}', 'API\CourseController@lesson_page')->name('lesson.page');
Route::get('/quest/quiz/{id}', 'API\CourseController@quest_quiz')->name('quest.quiz');

Route::get('/learning/pages/{id}', 'API\CourseController@learning_pages')->name('learning.pages');
Route::get('/ans/quiz/{id}', 'API\CourseController@ans_quiz')->name('ans.quiz');

Route::get('/set_score', 'API\CourseController@set_score')->name('set.score');
Route::get('/score/{id}', 'API\CourseController@score')->name('score');

Route::get('/respond_org_invite', 'API\GroupOrgController@respond_org_invite')->name('respond_org_invite'); 
 */