@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm mb-3">
    {{--ข้อมูลรายวิชา--}}
    <div class="col-md-12 bg-primary py-1 text-white ">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            เกี่ยวกับรายวิชา - {{$data->course_id}} - {{$data->course_name}}
        </h3>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    @if ( $data->course_img == null)
    @else
    <img class="m-2" src="/storage/course/course_img_assets/{{$data->course_img}}"width="1240px" height="650px">
    @endif
    @if ( $course_edit == null)
    <div class="col-md-12">
        <div class="card-body">
            <h4><b>รหัสรายวิชา</b> : {{$data->course_id}}</h4>
            <h4><b>ชื่อรายวิชา</b> : {{$data->course_name}}</h4>
            <h4><b>คำอธิบายรายวิชา</b> : {{$data->course_detail}}</h4>
            <h4><b>หมวดหมู่รายวิชา</b> : {{$data->cc->name ??null}}</h4>
            <h4><b>ประเภทรายวิชา</b> : {{$data->course_type}}</h4>
            <h4><b>สถานะรายวิชา</b> : {{$data->course_status}}</h4>
            <h4><b>ชื่อติวเตอร์ประจำรายวิชา</b> : {{$data->owner->name}} {{$data->owner->surname}}</h4>
        </div>
        @if ( Auth::user()->member_id == $data->course_owner )
        <div class="dropdown">
            <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='bx bx-dots-horizontal-rounded'></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="nav-link dropdown" href="{{route('course.edit',$data->id)}}">
                  <button class="btn btn-warning btn-sm text-white"><h5>ตั้งค่ารายวิชา</h5></button></a>
                <form action="{{route('course.destroy',$data->id)}}" method="post" class="nav-link dropdown">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-icon btn-danger btn-sm"
                        onclick="return confirm('คุณต้องการลบข้อมูลรายวืชา ที่ชื่อ {{$data->course_name}} หรือไม่?')">
                        <h5>ลบรายวิชา</h5>
                    </button>
                </form>
            </div>
          </div>
        @else
            
        @endif
    </div>
    @else
    <div class="form-register m-3">
        <form action="{{ route('course.update',$data->id)}}" class="form" method="POST"
            enctype="multipart/form-data">
            {{ csrf_field()}}
            {{ method_field('PUT') }}
            @csrf
                    <select class="form-control" name="cc_id">
                        <option value="{{$data->cc_id}}">{{$data->cc->name ??null}}</option>
                        @foreach( $cc as $row)
                        <option value="{{$row->cc_id}}">{{$row->name}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" class="form-control" name="course_id" value="{{$data->course_id}}"
                        placeholder="รหัสคอร์สเรียน.." required>
                    <input type="text" class="form-control" name="course_name" value="{{$data->course_name}}"
                        placeholder="ชื่อคอร์สเรียน.." required>
                    <textarea name="course_detail" value="{{$data->course_detail}}" class="form-control"
                        placeholder="คำอธิบายรายวิชา..">{{$data->course_detail}}</textarea>
                        <select class="form-control" name="course_type">
                            <option value="{{$data->course_type}}">{{$data->course_type}}</option>
                            <option value="สาธารณะ">สาธารณะ</option>
                            <option value="ส่วนตัว">ส่วนตัว</option>
                        </select>
                        <select class="form-control" name="course_status">
                            <option value="{{$data->course_status}}">{{$data->course_status}}</option>
                            <option value="เผยแพร่">เผยแพร่</option>
                            <option value="ซ่อน">ซ่อน</option>
                        </select>
                        <input type="hidden" class="form-control" name="course_owner" value="{{Auth::user()->member_id}}" readonly>
                        <input type="text" class="form-control" value="{{Auth::user()->name}} {{Auth::user()->surname}}" readonly>
                        ภาพปกรายวิชา :
                        <input type="file" class="form-control" name="course_img" >
                    <button style="float: right" type="submit" class="btn btn-success mt-2 "><h4>อัพเดต</h4></button>
        </form>
    </div>
    @endif
</div>
@endsection