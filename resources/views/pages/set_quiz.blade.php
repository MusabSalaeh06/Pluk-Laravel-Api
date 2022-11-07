@extends('/layouts/manage_lesson_sidebar')
@section('content')
<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <h3>
      <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
      {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - สร้างชุดแบบทดสอบ
      <button style="float: right" type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-set-quiz">สร้างชุดแบบทดสอบ</button>
      <div class="modal fade bd-example-set-quiz" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog set-quiz">
          <div class="modal-content">
                  <div class="col-md-12 bg-primary pt-2 text-white">
                      <h3>สร้างชุดแบบทดสอบ</h3>
                  </div>
          <div class="card-body text-dark"> 
              <div class="container">
              <div class="form-register">
                  <form action="{{route('quiz.store')}}" class="form" method="POST" enctype="multipart/form-data">
                      @csrf
                              <h5>ชื่อแบบทดสอบ :</h5>
                              <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                              <input type="text" class="form-control" name="set_name" placeholder="ป้อนชื่อแบบทดสอบ..." required>
                              <h5>เวลาในการทำแบบทดสอบ(ระบุจำนวนนาที) :</h5>
                              <input type="text" class="form-control" name="time" placeholder="ป้อนเวลาในการทำแบบทดสอบ..." required>
                              <h5>สถานะ :</h5>
                              <select name="status" class="form-control" >
                                <option >เลือกสถานะ</option>
                                <option value="เผยแพร่"><h5>เผยแพร่</h5></option>
                                <option value="ซ่อน"><h5>ซ่อน</h5></option>
                              </select>
                      <center><button type="submit" class="btn btn-primary mt-3"><h4>บันทึก</h4></button></center>
                  </form>
              </div>
          </div>
          </div>
          </div>
      </div>
      </div>
    </h3>
</div>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        <h5>{{ session('status') }}</h5>
    </div>
@endif
<div class="card-body">
@if ($set_quizz == null)
   <h3>ไม่พบชุดแบบทดสอบ </h3>
@else
<table class="table table-vertical-center">
  <tr>
      <th>
          <span class="font-weight-bolder">
              <h4>ชื่อแบบทดสอบ :</h4>
          </span>
      </th>
      <th>
          <span class="font-weight-bolder">
              <h4>เวลาในการทำแบบทดสอบ :</h4>
          </span>
      </th>
      <th>
          <span class="font-weight-bolder">
              <h4>สถานะ :</h4>
          </span>
      </th>
      <th colspan="3" width="20%">
          <span class="font-weight-bolder">
          </span>
      </th>
  </tr>
  @foreach($set_quiz as $row)
  <tr>
      <td>
          <div class="text-muted font-weight-bold">
            <a href="{{route('add.quiz',$row->id)}}" class="text-dark">
              <h5>{{$row->set_name}}</h5>
            </a>
          </div>
      </td>
      <td>
          <div class="text-muted font-weight-bold">
              <h5>{{$row->time}}</h5>
          </div>
      </td>
      <td>
          <div class="text-muted font-weight-bold">
              <h5>{{$row->status}}</h5>
          </div>
      </td>
      <td>
        <a href="{{route('add.quiz',$row->id)}}" class="btn btn-primary">
            <h5>สร้างแบบทดสอบ</h5>
        </a>
      </td>
      <td>
        <button  type="button" class="btn btn-warning text-white" data-toggle="modal" data-target=".bd-example-set-quiz-edit-{{$row->id}}"><h5>แก้ไข</h5></button>
        <div class="modal fade bd-example-set-quiz-edit-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog set-quiz-edit-{{$row->id}}">
            <div class="modal-content">
                    <div class="col-md-12 bg-primary pt-2 text-white">
                        <h3>สร้างชุดแบบทดสอบ</h3>
                    </div>
            <div class="card-body text-dark"> 
                <div class="container">
                <div class="form-register">
                    <form action="{{route('set_quiz.edit',$row->id)}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{ csrf_field()}}
                        {{ method_field('PUT') }}
                                <h5>ชื่อแบบทดสอบ :</h5>
                                <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                <input type="text" class="form-control" name="set_name" value="{{$row->set_name}}"  required>
                                <h5>เวลาในการทำแบบทดสอบ(ระบุจำนวนนาที) :</h5>
                                <input type="text" class="form-control" name="time" value="{{$row->time}}"  required>
                                <h5>สถานะ :</h5>
                                <select name="status" class="form-control" >
                                  <option value="{{$row->status}}"><h5>{{$row->status}}</h5></option>
                                  <option value="เผยแพร่"><h5>เผยแพร่</h5></option>
                                  <option value="ซ่อน"><h5>ซ่อน</h5></option>
                                </select>
                        <center><button type="submit" class="btn btn-primary mt-3"><h4>อัพเดท</h4></button></center>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
      </td>
      <td>
        <form action="{{route('set_quiz.destroy',$row->id)}}" method="post">
            @csrf 
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('คุณต้องการลบชุดทดสอบ : {{$row->set_name}} หรือไม่?')">
               <h5>ลบ</h5>
            </button>
        </form>
      </td>
  </tr>
  @endforeach
</table>
@endif
</div>
</div>
@endsection