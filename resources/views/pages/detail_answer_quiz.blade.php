@extends('/layouts/learn_page_sidebar')
@section('content')
<div class="card shadow-sm mb-3">
    <div class="col-md-12 bg-primary py-1 text-white ">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - เกี่ยวกับแบบทดสอบ
        </h3>
    </div>
    <div class="col-md-12">
        <div class="card-body">
            @if ($h_quizx == null)
            <div class="card-body">
              <h3>ไม่พบแบบทดสอบ</h3>
            </div>
            @else
            @if ($answer == null )
            <h4><b>รหัสรายวิชา</b> : {{$data->course_id}}</h4>
            <h4><b>ชื่อรายวิชา</b> : {{$data->course_name}}</h4>
            <h4><b>คำอธิบายรายวิชา</b> : {{$data->course_detail}}</h4>
            <h4><b>หมวดหมู่รายวิชา</b> : {{$data->cc->name ??null}}</h4>
            <h4><b>ชื่อติวเตอร์ประจำรายวิชา</b> : {{$data->owner->name}} {{$data->owner->surname}}</h4>
            <center><a href="{{route('answer.quiz',$set_quiz->id)}}" class="btn btn-primary"><h3>เริ่มทำแบบทดสอบ</h3></a></center>
            @elseif($answer != null && $try == null)
                  <div class="my-5">
                      <center>
                        <h1>คุณได้ทำแบบทดสอบเเล้ว</h1>
                        <a href="{{route('quiz.score',$set_quiz->id)}}" class="btn btn-primary my-3">
                          <h3>ดูคะเเนน</h3>
                        </a>
                        <form action="{{route('detail.answer.quiz',$set_quiz->id)}}" method="get">
                          @csrf
                          <input type="hidden" name="try" value="ทำอีกครั้ง">
                          <button class="btn btn-primary"><h3>ทำอีกครั้ง</h3></button>
                        </form>
                      </center>
                  </div>
            @elseif($answer != null && $try != null)
            <h4><b>ชื่อชุดแบบทดสอบ</b> : {{$set_quiz->set_name}} </h4>
            <h4><b>เวลาที่ใช้ในการทำแบบทดสอบ</b> : {{$set_quiz->time}} นาที</h4>
            <h4><b>จำนวนข้อ</b> : {{$co_h_quiz}} ข้อ</h4>
            <h4><b>คะแนนรวม</b> : {{$co_h_quiz}} คะแนน</h4>
            <h4><b>รหัสรายวิชา</b> : {{$data->course_id}}</h4>
            <h4><b>ชื่อรายวิชา</b> : {{$data->course_name}}</h4>
            <h4><b>คำอธิบายรายวิชา</b> : {{$data->course_detail}}</h4>
            <h4><b>หมวดหมู่รายวิชา</b> : {{$data->cc->name ??null}}</h4>
            <h4><b>ชื่อติวเตอร์ประจำรายวิชา</b> : {{$data->owner->name}} {{$data->owner->surname}}</h4>
            <center><a href="{{route('answer.quiz',$set_quiz->id)}}" class="btn btn-primary"><h3>เริ่มทำแบบทดสอบ</h3></a></center>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection