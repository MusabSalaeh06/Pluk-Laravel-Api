@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ตั้งค่าบทเรียน
        </h3>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <div class="form-register">
            <form action="{{ route('lesson.update',$data->lesson_id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <input type="hidden" class="form-control" name="id" value="{{$data->id}}">
                    ชื่อบทเรียน :
                    <input type="text" class="form-control" name="lesson_name" value="{{$data->lesson_name}}">
                    เนื้อหา :
                    <textarea name="lesson_detail" class="form-control" rows="5" >{{$data->lesson_detail}}</textarea>
                    สถานะบทเรียน :
                    <select class="form-control" name="lesson_status">
                        <option value="{{$data->lesson_status}}">{{$data->lesson_status}}</option>
                        <option value="เผยแพร่">เผยแพร่</option>
                        <option value="ซ่อน">ซ่อน</option>
                    </select>
                </div>
                <center><button type="submit" class="btn btn-success ">
                    <h4>อัพเดต</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection