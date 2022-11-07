@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            เพิ่มหมวดหมู่รายวิชา
        </h3>
    </div>
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('error') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <div class="form-register">
            <form action="{{route('course_category.store')}}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    ชื่อหมวดหมู่ :
                    <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อหมวดหมู่..." required>
                    อักษรย่อ :
                    <input type="text" class="form-control" name="short_name" placeholder="ป้อนอักษรย่อ 3 ตัว..." required>
                </div>
                <center><button type="submit" class="btn btn-success ">
                        <h4>บันทึก</h4>
                    </button></center>
            </form>
        </div>
    </div>
</div>
@endsection