@extends('/layouts/default')
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
    <div class="col-md-12">
        @if ( $data->course_img == null)
        @else
        <img class="m-2" src="/storage/course/course_img_assets/{{$data->course_img}}"width="1470px" height="650px">
        @endif
        <div class="card-body">
            <h4><b>รหัสรายวิชา</b> : {{$data->course_id}}</h4>
            <h4><b>ชื่อรายวิชา</b> : {{$data->course_name}}</h4>
            <h4><b>คำอธิบายรายวิชา</b> : {{$data->course_detail}}</h4>
            <h4><b>หมวดหมู่รายวิชา</b> : {{$data->cc->name ??null}}</h4>
            <h4><b>ประเภทรายวิชา</b> : {{$data->course_type}}</h4>
            <h4><b>สถานะรายวิชา</b> : {{$data->course_status}}</h4>
            <h4><b>ชื่อติวเตอร์ประจำรายวิชา</b> : {{$data->owner->name}} {{$data->owner->surname}}</h4>
        </div>
    </div>
</div>
<div class="col-md-12 bg-primary py-1 text-white ">
    <h3>บทเรียนรายวิชา  {{$data->course_name}} ประกอบด้วย</h3>
</div>
<div class="card shadow-sm">
<div class="card-body">
    @forelse($lesson as $row)
    <h3>{{$row->lesson_name}}</h3>
    @empty
    <h5>ไม่พบบทเรียน</h5>
    @endforelse
</div>
</div>
@if ($org_data == null)
@if ($enroll == null)
<form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control" name="course_id" value="{{$data->id}}" readonly>
    <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
    <center>
        @if ($data->course_type == "สาธารณะ")
        <button type="submit" class="btn btn-icon btn-primary btn-sm" 
            onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$data->course_name}} หรือไม่ ?')">
            <h5><i class='bx bxs-user-circle' ></i>ลงทะเบียนฟรี</h5>
        </button>
        @else
        <button type="submit" class="btn btn-icon btn-primary btn-sm" 
            onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$data->course_name}} หรือไม่ ?')">
            <h5><i class='bx bxs-user-circle' ></i>ลงทะเบียน</h5>
        </button>
        @endif
    </center>
</form>  
@else
    
@endif
@else
@if ($enroll->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
<form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" class="form-control" name="org_id" value="{{$org_data->org_id}}" readonly>
    <input type="hidden" class="form-control" name="course_id" value="{{$data->id}}" readonly>
    <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
    <center>
        <button type="submit" class="btn btn-icon btn-primary btn-sm" 
            onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$data->course_name}} หรือไม่ ?')">
            <h5><i class='bx bxs-user-circle' ></i>เข้าร่วมรายวิชาขององค์กร</h5>
        </button>
    </center>
</form>
@else

@endif
@endif
@endsection