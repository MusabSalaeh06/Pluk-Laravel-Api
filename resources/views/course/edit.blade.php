@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ตั้งค่ารายวิชา
        </h3>
    </div>
    <div class="card-body">
        <div class="form-register">
            <form action="{{ route('course.update',$data->id)}}" class="form" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field()}}
                {{ method_field('PUT') }}
                @csrf
                <div class="form-group">
                    <div class="sect1">
                        {{--
                        --}}
                        หมวดหมู่รายวิชา :
                        <select class="form-control" name="cc_id">
                            <option value="{{$data->cc_id}}">{{$data->cc->name ??null}}</option>
                            @foreach( $cc as $row)
                            <option value="{{$row->cc_id}}">{{$row->name}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="cc_id" value="{{$data->cc_id}}"
                            placeholder="รหัสคอร์สเรียน.." required>
                        {{----}}
                        <input type="hidden" class="form-control" name="course_id" value="{{$data->course_id}}"
                            placeholder="รหัสคอร์สเรียน.." required>
                        ชื่อรายวิชา :
                        <input type="text" class="form-control" name="course_name" value="{{$data->course_name}}"
                            placeholder="ชื่อคอร์สเรียน.." required>
                        คำอธิบายรายวิชา :
                        <textarea name="course_detail" value="{{$data->course_detail}}" class="form-control"
                            placeholder="คำอธิบายรายวิชา..">{{$data->course_detail}}</textarea>
                            ประเภทรายวิชา :
                            <select class="form-control" name="course_type">
                                <option value="{{$data->course_type}}">{{$data->course_type}}</option>
                                <option value="สาธารณะ">สาธารณะ</option>
                                <option value="ส่วนตัว">ส่วนตัว</option>
                            </select>
                            สถานะรายวิชา :
                            <select class="form-control" name="course_status">
                                <option value="{{$data->course_status}}">{{$data->course_status}}</option>
                                <option value="เผยแพร่">เผยแพร่</option>
                                <option value="ซ่อน">ซ่อน</option>
                            </select>
                        ติวเตอร์ประจำรายวิชา :
                        <select class="form-control" name="course_owner" readonly>
                            <option value="{{Auth::user()->member_id}}">{{Auth::user()->name}} {{Auth::user()->surname}}
                            </option>
                        </select>
                    </div>
                </div>
                <center><button type="submit" class="btn btn-success ">
                    <h4>อัพเดต</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection