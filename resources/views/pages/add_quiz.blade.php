@extends('/layouts/manage_lesson_sidebar')
@section('content')

<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <h3>
      <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
      {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - {{$set_quiz->set_name}} - สร้างแบบทดสอบ
    <button style="float: right" type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-add-quiz-header">เพิ่มหัวข้อแบบทดสอบ</button>
    <div class="modal fade bd-example-add-quiz-header" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog add-quiz-header">
        <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                    <h3>เพิ่มหัวข้อแบบทดสอบ</h3>
                </div>
        <div class="card-body text-dark"> 
            <div class="container">
            <div class="form-register">
                <form action="{{route('quiz.store')}}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf
                            <h5>หัวข้อแบบทดสอบ :</h5>
                            <input type="hidden" class="form-control" name="id" value="{{$set_quiz->id}}" readonly>
                            <input type="text" class="form-control" name="header_name" placeholder="ป้อนหัวข้อแบบทดสอบ..." required>
                            <h5>สถานะ :</h5>
                            <select name="status" class="form-control" >
                              <option >เลือกสถานะ</option>
                              <option value="เผยแพร่"><h5>เผยแพร่</h5></option>
                              <option value="ซ่อน"><h5>ซ่อน</h5></option>
                            </select>
                    {{-- <table class="table">
                      <tbody class="journal2">
                        <tr>
                          <td>
                            <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                            <input type="text" class="form-control" name="header_name[]" placeholder="ป้อนหัวข้อแบบทดสอบ..." required>
                          </td>
                        <td width="5%"><a type="button" class="btn btn-primary addRow"> + </a></td>
                        </tr>
                      </tbody>
                    </table> --}}
                    <center><button type="submit" class="btn btn-primary mt-3"><h4>ยืนยัน</h4></button></center>
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

  @if (session('delete'))
      <div class="alert alert-danger" role="alert">
          <h5>{{ session('delete') }}</h5>
      </div>
  @endif
  
  <div class="card-body">
    @if ($h_quizx == null)
    <h3>คุณยังไม่มีการเพิ่มแบบทดสอบ</h3>
    @else
    @foreach ($h_quiz as $row)
    <div class="col-md-12 bg-primary py-1 text-white">
      <h3>
        {{$row->header_name}}  &nbsp;<b style="font-size: 20px;" class="text-dark"> สถานะ : {{$row->status}}</b>
        <div class="row" style="float: right">
            <button type="button" class="btn btn-warning text-white" data-toggle="modal" data-target=".bd-example-quiz-header-{{$row->qh_id}}">แก้ไข</button>
            <div class="modal fade bd-example-quiz-header-{{$row->qh_id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog quiz-header-{{$row->qh_id}}">
                <div class="modal-content">
                        <div class="col-md-12 bg-primary pt-2 text-white">
                            <h3>แก้ไขหัวข้อแบบทดสอบ</h3>
                        </div>
                <div class="card-body text-dark"> 
                    <div class="container">
                      <div class="form-register">
                          <form action="{{route('quiz_h.edit',$row->qh_id)}}" class="form" method="POST" enctype="multipart/form-data">
                              @csrf
                              {{ csrf_field()}}
                              {{ method_field('PUT') }}
                              <h5>หัวข้อแบบทดสอบ :</h5>
                              <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                              <input type="text" class="form-control" name="header_name" value="{{$row->header_name}}" required>
                              <h5>สถานะ :</h5>
                              <select name="status" class="form-control" >
                                <option value="{{$row->status ??null}}"><h5>{{$row->status ??null}}</h5></option>
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
            <form action="{{route('quiz_h.destroy',$row->qh_id)}}" method="post">
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-danger" >
                   ลบ
                </button>
            </form><br>
        <button type="button" class="btn btn-light " data-toggle="modal" data-target=".bd-example-{{$row->qh_id}}">เพิ่มช้อย</button>
        <div class="modal fade bd-example-{{$row->qh_id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog {{$row->qh_id}}">
            <div class="modal-content">
                    <div class="col-md-12 bg-primary pt-2 text-white">
                        <h3>เพิ่มช้อย</h3>
                    </div>
            <div class="card-body text-dark"> 
                <div class="container">
                <div class="form-register">
                    <form action="{{route('quiz.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <table class="table">
                          <tbody class="journal">
                            <tr>
                              <td>
                                <input type="hidden" class="form-control" name="qh_id" value="{{$row->qh_id}}" required>
                                <input type="text" class="form-control" name="quiz[]" placeholder="เขียนช้อย..." required>
                              </td>
                              <td width="5%">
                                <select  name="result[]">
                                  <option value="0">ไม่ใช่คำตอบ</option>
                                  <option value="1">คำตอบ</option>
                                </select>
                              </td>
                                {{--
                              <td width="5%">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="result[]" value="1" >
                                </div>
                              </td>
                              <td width="5%"><h5>เฉลย</h5></td>
                                  --}}
                            <td width="5%"><a type="button" class="btn btn-primary addRow"> + </a></td>
                            </tr>
                          </tbody>
                        </table>
                        <center><button type="submit" class="btn btn-success "><h4>บันทึก</h4></button></center>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
      </div>
      </h3>
    </div>
    <div class="card border-dark">
      <div class="card-body">   
        <table class="table">
        <tbody>
          @foreach ($quiz as $key=>$subrow)
            @if ($row->qh_id == $subrow->qh_id)
            <tr>
              <td width="5%">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="result[{{$key}}]" value="{{$subrow->id}}">
                </div>
              </td>
              <td><h5>{{$subrow->quiz}}</h5></td>
              <td width="10%">
                @if ($subrow->result == 1)
                <h5><b>คำตอบ</b></h5>
                @else
                @endif
              </td>
              <td width="5%">
                <button type="button" class="btn btn-warning text-white" data-toggle="modal" data-target=".bd-example-quiz-{{$subrow->id}}">แก้ไข</button>
                <div class="modal fade bd-example-quiz-{{$subrow->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog quiz-{{$subrow->id}}">
                    <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>แก้ไขหัวข้อแบบทดสอบ</h3>
                            </div>
                    <div class="card-body text-dark"> 
                        <div class="container">
                          <div class="form-register">
                              <form action="{{route('quiz.edit',$subrow->id)}}" class="form" method="POST" enctype="multipart/form-data">
                                  @csrf
                                  {{ csrf_field()}}
                                  {{ method_field('PUT') }}
                                    <input type="hidden" class="form-control" name="qh_id" value="{{$row->qh_id}}" required>
                                    เขียนช้อย :
                                    <input type="text" class="form-control" name="quiz" value="{{$subrow->quiz}}" required>
                                    สถานะ :
                                    <select  name="result" class="form-control" >
                                      @if ($subrow->result == 1)
                                      <option value="{{$subrow->result}}">คำตอบ</option>
                                      @else
                                      <option value="{{$subrow->result}}">ไม่ใช่คำตอบ</option>
                                      @endif
                                      <option value="0">ไม่ใช่คำตอบ</option>
                                      <option value="1">คำตอบ</option>
                                    </select>
                                    <center><button type="submit" class="btn btn-primary my-2"><h5>อัพเดท</h5></button></center>
                              </form>
                          </div>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
              </td>
              <td width="5%">
                <form action="{{route('quiz.destroy',$subrow->id)}}" onclick="return confirm('คุณต้องการลบช้อยหรือไม่?')" method="POST">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-danger">ลบ</button>
              </form>
              </td>
            </tr>
            @else
            @endif
          @endforeach
        </tbody>
      </table>
      </div>
    </div><br>
    @endforeach
{{--
                 ' <td width="5%">'+
                         ' <div class="form-check">'+
                              '<input class="form-check-input" type="radio" name="result[]" value="1" >'+
                            '</div>'+
                          '</td>'+
                          '<td width="5%"><h5>เฉลย</h5></td>'+
                          --}}
<script>
  $('.journal').on('click','.addRow',function () {
      var tr = '<tr>'+
                  '<td>'+
                  '<input type="hidden" class="form-control" name="qh_id" value="{{$row->qh_id}}" required>'+
                  '<input type="text" class="form-control" name="quiz[]" placeholder="เขียนช้อย..." required>'+
                  '</td>'+
                 ' <td width="5%">'+
                           ' <select  name="result[]">'+
                              '<option value="0">ไม่ใช่คำตอบ</option>'+
                              '<option value="1">คำตอบ</option>'+
                            '</select>'+
                          '</td>'+
                  
                  '<td><a href="javascript:;" type="button" class="btn btn-danger deleteRow">-</a></td>'+
              '</tr>';
      $('.journal').append(tr);
      });
      $('.journal').on('click','.deleteRow',function () {
      $(this).parent().parent().remove();
      });
</script>
{{-- <script>
  $('.journal2').on('click','.addRow',function () {
      var tr = '<tr>'+
                  '<td>'+
                    '<input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>'+
                    '<input type="text" class="form-control" name="header_name[]" placeholder="ป้อนหัวข้อแบบทดสอบ..." required>'+
                  '</td>'+
                  '<td><a href="javascript:;" type="button" class="btn btn-danger deleteRow">-</a></td>'+
              '</tr>';
      $('.journal2').append(tr);
      });
      $('.journal2').on('click','.deleteRow',function () {
      $(this).parent().parent().remove();
      });
</script> --}}
@endif
</div>
</div>
@endsection