@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            เปิดรายวิชาการสอน
        </h3>
    </div>
    <div class="card-body">
        <div class="form-register">
            <form action="{{route('course.store')}}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    หมวดหมู่รายวิชา :
                    <select class="form-control" name="cc_id">
                        <option>เลือกหมวดหมู่รายวิชา</option>
                        @foreach( $cc as $row)
                        <option value="{{$row->cc_id}}">{{$row->name}}</option>
                        @endforeach
                    </select>{{--
                    รหัสรายวิชา :
                    <input type="text" class="form-control" name="course_id" placeholder="ป้อนรหัสรายวิชา.." required>
                    --}}
                    ชื่อรายวิชา :
                    <input type="text" class="form-control" name="course_name" placeholder="ป้อนชื่อรายวิชา.." required>
                    คำอธิบายรายวิชา :
                    <textarea name="course_detail" class="form-control" placeholder="เพิ่มคำอธิบายรายวิชา.."></textarea>
                    ประเภทรายวิชา :
                    <select class="form-control" name="course_type">
                        <option value="">เลือกประเภทรายวิชา</option>
                        <option value="สาธารณะ">สาธารณะ</option>
                        <option value="ส่วนตัว">ส่วนตัว</option>
                    </select>
                    สถานะรายวิชา :
                    <select class="form-control" name="course_status">
                        <option value="">เลือกสถานะรายวิชา</option>
                        <option value="เผยแพร่">เผยแพร่</option>
                        <option value="ซ่อน">ซ่อน</option>
                    </select>
                    ติวเตอร์ประจำรายวิชา :
                    <input type="hidden" class="form-control" name="course_owner" value="{{Auth::user()->member_id}}" required>
                    <input type="text" class="form-control" value="{{Auth::user()->name}} {{Auth::user()->surname}}" readonly>
                    ภาพปกรายวิชา :
                    <input type="file" class="form-control" name="course_img"  >
                </div>
                <center><button type="submit" class="btn btn-success ">
                        <h4>บันทึก</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection