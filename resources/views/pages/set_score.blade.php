@extends('/layouts/learn_page_sidebar')
@section('content')
<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <h3>
      <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
      {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}} - ดูคะแนน
    </h3>
</div>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        <h5>{{ session('status') }}</h5>
    </div>
@endif
<div class="card-body">
<table class="table table-vertical-center">
  <tr>
      <th>
          <span class="font-weight-bolder">
              <h4>ชื่อแบบทดสอบ :</h4>
          </span>
      </th>
      <th width="10%">
          <span class="font-weight-bolder">
          </span>
      </th>
  </tr>
  @foreach($set_score as $row)
  <tr>
      <td>
          <div class="text-muted font-weight-bold">
            <a href="{{route('quiz.score',$row->id)}}" class="text-dark">
              <h5>{{$row->set_name}}</h5>
            </a>
          </div>
      </td>
      <td>
        <a href="{{route('quiz.score',$row->id)}}" class="btn btn-primary">
            <h5>ดูคะแนน</h5>
        </a>
      </td>
  </tr>
  @endforeach
</table>
</div>
</div>
@endsection
