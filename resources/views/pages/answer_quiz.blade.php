@extends('/layouts/learn_page_sidebar')
@section('content')
<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <h3>
      <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
      {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - ตอบแบบทดสอบ
    </h3>
  </div>
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    <h5>{{ session('status') }}</h5>
  </div>
  @endif 
        <div class="card-body"> 
          <div class="form-register">
            <form action="{{route('answer.store',$set_quiz->id)}}" class="form" method="POST" enctype="multipart/form-data">
          @foreach ($h_quiz as $row)
          <input type="hidden" name="qh_id[]" value="{{$row->qh_id}}">
          <div class="col-md-12 bg-primary py-1 text-white">
            <h3>
              {{$row->header_name}}
            </h3>
          </div>
          <div class="card border-dark">
            <div class="card-body">
                  @csrf
                  <table class="table">
                    <tbody class="journal">
                      @foreach ($quiz as $key=>$subrow)
                      @if ($row->qh_id == $subrow->qh_id)
                      <tr>
                        <td width="5%">
                          <div class="form-check">
                            <input type="hidden" name="set_id" value="{{$row->id}}">
                            <input type="hidden" name="member_id" value="{{Auth::user()->member_id}}">
                            {{--<input type="hidden" name="qh_id[]" value="{{$row->qh_id}}">--}}
                            <input class="form-check-input" type="radio" name="result[{{$row->qh_id}}]" value="{{$subrow->id}}">
                          </div>
                        </td>
                        <td>
                          <h5>
                            <h5>{{$subrow->quiz}}</h5>
                          </h5>
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
          <center><button type="submit" class="btn btn-success">บันทึก</button></center>
                </form>
              </div>
        </div>
</div>
{{--
<div class="form-register">
  <form action="{{route('quiz.store')}}" class="form" method="POST" enctype="multipart/form-data">
    @csrf
    <table class="table">
      <tbody class="journal">
        <tr>
          <td width="15%">
            <h4><b>หัวข้อแบบทดสอบ:</b></h4>
          </td>
          <td>
            <input type="text" class="form-control" name="header_name" placeholder="หัวข้อแบบทดสอบ.." required>
          </td>
          <td colspan="3"></td>
        </tr>
        <tr>
          <td>
            <h4><b>ช้อย :</b></h4>
          </td>
          <td>
            <input type="text" class="form-control" name="quiz[]" placeholder="เขียนช้อย..." required>
          </td>
          <td width="5%">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="result[]" value="1">
            </div>
          </td>
          <td width="5%">
            <h5>เฉลย</h5>
          </td>
          <td width="5%"><a type="button" class="btn btn-primary addRow"> + </a></td>
        </tr>
        <tr>
          <td colspan="5">
            <center><button type="submit" class="btn btn-success ">
                <h4>บันทึก</h4>
              </button></center>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
--}}
{{--
<script>
  $('.journal').on('click', '.addRow', function () {
    var tr = '<tr>' +
      '<td>' +
      '<input type="hidden" class="form-control" name="qh_id" value="{{$row->qh_id}}" required>' +
      '<input type="text" class="form-control" name="quiz[]" placeholder="เขียนช้อย..." required>' +
      '</td>' +

      '<td>' +
      '<div class="form-check">' +
      '<input class="form-check-input" type="radio" name="result[]" value="1">' +
      '</div>' +
      '</td>' +

      '<td><h5>เฉลย</h5></td>' +

      '<td><a href="javascript:;" type="button" class="btn btn-danger deleteRow">-</a></td>' +
      '</tr>';
    $('.journal').append(tr);
  });
  $('.journal').on('click', '.deleteRow', function () {
    $(this).parent().parent().remove();
  });
</script>
--}}
@endsection