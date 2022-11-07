@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            เพิ่มบทเรียนรายวิชา - {{$data->course_id}} - {{$data->course_name}}
        </h3>
    </div>
    <div class="card-body">
        <div class="form-register">
            <form action="{{route('lesson.store')}}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
                    ชื่อบทเรียน :
                    <input type="text" class="form-control" name="lesson_name" placeholder="ป้อนชื่อบทเรียน...">
                    เนื้อหา :
                    <textarea name="lesson_detail" class="form-control" rows="5" placeholder="ป้อนเนื้อหา..."></textarea>
                    สถานะบทเรียน :
                    <select class="form-control" name="lesson_status">
                        <option value="">เลือกสถานะรายวิชา</option>
                        <option value="เผยแพร่">เผยแพร่</option>
                        <option value="ซ่อน">ซ่อน</option>
                    </select>
                </div>
                <center><button type="submit" class="btn btn-success ">
                    <h4>บันทึก</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection