@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        @if (Auth::user()->member_id == $data->course_owner)
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            จัดการบทเรียนรายวิชา - {{$data->course_id}} - {{$data->course_name}}
            <a  href="{{route('lesson.create',$data->id)}}" style="float: right" class="btn btn-light m-2"><h5>เพิ่มบทเรียน</h5></a>
        </h3>
        @else
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            บทเรียนรายวิชา - {{$data->course_id}} - {{$data->course_name}}
        </h3>
        @endif
    </div>
    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    @if (session('new'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('new') }}</h5>
        </div>
    @endif
    @if (session('edit'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('edit') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center">
            @if( $lesson_count == null)
            <h3>รายวิชาดังกล่าวยังไม่มีการเพิ่มบทเรียน</h3>
            @else
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อบทเรียน:</h4>
                    </span>
                </th>
                @if (Auth::user()->member_id == $data->course_owner)
                <th>
                    <span class="font-weight-bolder">
                        <h4>สถานะบทเรียน:</h4>
                    </span>
                </th>
                <th colspan="3">
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @else
                <th>
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @endif
            </tr>
            @endif
            @foreach($lesson as $row)
            <tr>
                @if (Auth::user()->member_id == $data->course_owner)
                <td>
                    <div class="text-muted font-weight-bold">
                        <a href="{{route('pages.lesson_page',$row->lesson_id)}}" class="text-dark">
                            <h5>{{$row->lesson_name}}</h5>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                            <h5>{{$row->lesson_status}}</h5>
                        </a>
                    </div>
                </td>
                <td>
                    <a href="{{route('pages.lesson_page',$row->lesson_id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                        <h5> <i class='bx bxs-show' ></i> </h5>
                    </a>
                </td>
                <td>
                    <a href="{{route('lesson.edit',$row->lesson_id)}}" class="btn btn-icon btn-success btn-sm">
                        <h5><i class='bx bxs-edit'></i></h5>
                    </a>
                </td>
                <td>
                    <form action="{{route('lesson.destroy',$row->lesson_id)}}" method="post">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger btn-sm"
                            onclick="return confirm('คุณต้องการลบบทเรียนที่ชื่อ {{$row->lesson_name}} หรือไม่?')">
                           <h5> <i class='bx bxs-trash-alt'></i> </h5>
                        </button>
                    </form>
                </td>
                @else
                <td>
                    <div class="text-muted font-weight-bold">
                        <a href="{{route('pages.learning_page',$row->lesson_id)}}" class="text-dark">
                            <h5>{{$row->lesson_name}}</h5>
                        </a>
                    </div>
                </td>
                <td>
                    <a href="{{route('pages.learning_page',$row->lesson_id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                        <h5> <i class='bx bxs-show' ></i></h5>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$lesson->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection