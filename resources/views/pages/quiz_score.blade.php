@extends('/layouts/learn_page_sidebar')
@section('content')
<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <h3>
      <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
      {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - {{$set_quiz->set_name}} - คะแนน
    </h3>
  </div>
</div>
<div class="card border-dark">
  @if (session('status'))
  <div class="alert alert-success" role="alert">
    <h5>{{ session('status') }}</h5>
  </div>
  @endif
    <div class="card-body">
        @if ($quiz_score == null )
        <center>
          <h3>คุณยังไม่ได้ทำแบบทดสอบ</h3><br>
          <a href="{{route('detail.answer.quiz',$set_quiz->id)}}" class="btn btn-primary">
            <h3>ไปหน้าทำแบบทดสอบ</h3>
        </a>
        </center>
        @else
        <table class="table table-vertical-center">
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ครั้งที่ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>วัน-เวลาที่ส่ง :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>คะแนนที่ทำได้ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>คะแนนเต็ม :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>คิดเป็นเปอร์เซ็น :</h4>
                    </span>
                </th>
                @endif
            </tr>
            @foreach($answer_score as $i=>$row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$i+1}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->created_at}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->value}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$co_quiz}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{number_format($row->value*(100/$co_quiz), 2, '.', '')}}%</h5>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection