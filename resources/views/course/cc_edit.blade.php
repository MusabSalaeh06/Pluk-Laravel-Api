@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ตั้งค่าหมวดหมู่รายวิชา
        </h3>
    </div>
    <div class="card-body">
        <div class="form-register">
            <form action="{{route('course_category.update',$data->cc_id)}}" class="form" method="POST" enctype="multipart/form-data">
                {{ csrf_field()}}
                {{ method_field('PUT') }}
                <div class="form-group">
                    ชื่อหมวดหมู่ :
                    <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
                    อักษรย่อ :
                    <input type="text" class="form-control" name="short_name" value="{{$data->short_name}}" required>
                </div>
                <center><button type="submit" class="btn btn-success ">
                        <h4>บันทึก</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection