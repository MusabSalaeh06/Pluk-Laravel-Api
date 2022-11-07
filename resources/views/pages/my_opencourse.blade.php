@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ข้อมูลรายวิชาที่ฉันเปิดสอน
            <a  href="{{route('course.create')}}" style="float: right" class="btn btn-light m-2"><h5>สร้างรายวิชา</h5></a>
        </h3>
    </div>
    @if (session('new'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('new') }}</h5>
        </div>
    @endif
    <div class="card-body">
        @if( Auth::user()->count_co == null )
        <h3>
            คุณยังไม่ได้สร้างรายวิชาสำหรับการสอน
        </h3>
        @else
        <table class="table table-vertical-center">
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>รหัสรายวิชา:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อรายวิชา:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>คำอธิบายรายวิชา:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>สถานะรายวิชา:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                    </span>
                </th>
            </tr>
            @foreach($opc as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_id}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <a href="{{route('pages.course_index',$row->id)}}" class="text-dark">
                            <h5>{{$row->course_name}}
                                @foreach($course_enr as $subrow)
                                @if ($subrow->course_id == $row->id)
                                ({{$subrow->enr_count}})
                                @else
                                @endif
                                @endforeach</h5>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_detail}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_status}}</h5>
                    </div>
                </td>
                <td>
                    <a href="{{route('pages.course_index',$row->id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                       <h5><i class='bx bxs-show' ></i> จัดการรายวิชา</h5> 
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$opc->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
        @endif


    </div>
</div>
@endsection