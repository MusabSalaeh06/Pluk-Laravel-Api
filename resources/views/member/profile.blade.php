@extends('/layouts/default')
@section('content')
<div class="card  shadow-sm mt-2">
    <div class="col-md-12 bg-primary py-1 text-white">
        <div class="row p-1 px-3">
            <h3>
                <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
                ข้อมูลส่วนตัว
            </h3>
            <div class="ml-auto">
                @foreach($profile as $row)
                <a href="{{route('profile.edit',$row->member_id)}}"><button class="btn btn-light">
                        <h5><i class='bx bxs-edit'></i></h5>
                    </button></a>
                @endforeach
            </div>
        </div>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    @if (session('edit'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('edit') }}</h5>
        </div>
    @endif
    @if (session('destroy'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('destroy') }}</h5>
        </div>
    @endif
    <div class="row py-2">
    </div>
    <div class="bg-white text-black m-1">
        <div class="row ">
            <div class="col-md-4">
                <div class="card-body">
                    <div class="profile">
                        @if ($row->profile == null && $row->gender == 'ชาย')
                        <center><img src="/media/svg/avatars/001-boy.svg" height="150px" width="150px"></center>
                        @elseif($row->profile == null && $row->gender == 'หญิง')
                        <center><img src="/media/svg/avatars/002-girl.svg" height="150px" width="150px"></center>
                        @elseif($row->profile == null && $row->gender == null)
                        <center><img src="/images/no_image.png" height="150px" width="150px"></center>
                        @else
                        <center><img src="{{ asset('storage/member/member_assets/'.$row->profile) }}" height="150px"
                                width="150px"></center>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <h3>ข้อมูลโปรไฟล์</h3>
                @foreach($profile as $row)
                <h4>
                    <b>ชื่อ</b> : {{$row->name}} {{$row->surname}} <br>
                    <b>เพศ</b> : {{$row->gender}} <br>
                    <b>เบอร์โทรศัพท์</b> : {{$row->tel}} <br>
                    <b>บัตรประจำตัวประชาชน</b> : {{$row->card_id}} <br>
                    <b>วันเกิด</b> : {{$row->birth_day}} <br>
                    <b>อีเมลแอดเดรส</b> : {{$row->email}}
                </h4>
                @endforeach
            </div>
            <div class="col-md-4 py-3">
                <h3>ข้อมูลที่อยู่</h3>
                @foreach($profile as $row)
                <h4>
                    <b>เขต</b> : {{$row->county ??null}} <b>ถนน</b> : {{$row->road ??null}} <b>ตรอก/ซอย</b> :
                    {{$row->alley ??null}} <br>
                    <b>บ้านเลขที่</b> : {{$row->house_number ??null}} <b>หมู่</b> : {{$row->group_no ??null}}
                    <b>ตำบล</b> : {{$row->sub_district ??null}} <br>
                    <b>อำเภอ</b> : {{$row->district ??null}} <b>จังหวัด</b> : {{$row->province ??null}}
                    <b>รหัสไปรษณีย์</b> : {{$row->ZIP_code ??null}}
                </h4>
                @endforeach
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->count_co == null)
@else
<div class="card shadow-sm mt-3">
<div class="col-md-12 bg-primary py-1 text-white">
    <h3>
        ข้อมูลสถาบัน
        <button style="float: right" type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-my-school">เพิ่มข้อมูลสถาบัน</button>
        <div class="modal fade bd-example-my-school" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog my-school">
            <div class="modal-content">
                    <div class="col-md-12 bg-primary pt-2 text-white">
                        <h3>เพิ่มข้อมูลสถาบัน</h3>
                    </div>
            <div class="card-body text-dark"> 
                <div class="container">
                <div class="form-register">
                    <form action="{{route('my_school.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}">
                        ชื่อสถาบัน :
                        <input type="text" class="form-control" name="school_name" placeholder="ป้อนชื่อสถาบัน...">
                        เริ่มศึกษาปี :
                            <input type="date" class="form-control" name="start" placeholder="เริ่มศึกษาปี...">
                            จบการศึกษาปี :
                                <input type="date" class="form-control" name="end"placeholder="จบการศึกษาปี...">
                                    ระดับการศึกษา :
                                    <input type="text" class="form-control" name="edu_level" placeholder="ป้อนระดับการศึกษา...">
                                        ชื่อสาขาวิชาที่ศึกษา :
                                        <input type="text" class="form-control" name="fac_name" placeholder="ป้อนชื่อสาขาวิชาที่ศึกษา...">
                        <center><button type="submit" class="btn btn-primary mt-3"><h4>ยืนยัน</h4></button></center>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
    </h3>
</div>
<div class="card-body">
@if ($my_school == null)
<h5>ไม่พบข้อมูลสถาบัน</h5>
@else
    <table class="table table-vertical-center" id="employee_table">
        <tr>
            <th>
                <span class="font-weight-bolder">
                    <h4></h4>
                </span>
            </th>
            <th>
                <span class="font-weight-bolder">
                    <h4>ชื่อสถาบัน :</h4>
                </span>
            </th>
            <th>
                <span class="font-weight-bolder">
                    <h4>เริ่มศึกษาปี :</h4>
                </span>
            </th>
            <th>
                <span class="font-weight-bolder">
                    <h4>จบการศึกษาปี :</h4>
                </span>
            </th>
            <th>
                <span class="font-weight-bolder">
                    <h4>ระดับการศึกษา :</h4>
                </span>
            </th>
            <th>
                <span class="font-weight-bolder">
                    <h4>ชื่อสาขาวิชาที่ศึกษา :</h4>
                </span>
            </th>
            <th colspan="2" width="5%">
            </th>
        </tr>
        @foreach($my_school as $i=>$row)
        <tr>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$i+1}}</h5>
                </div>
            </td>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$row->school_name}} </h5>
                </div>
            </td>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$row->start}}</h5>
                </div>
            </td>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$row->end}}</h5>
                </div>
            </td>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$row->edu_level}}</h5>
                </div>
            </td>
            <td>
                <div class="text-muted font-weight-bold">
                    <h5>{{$row->fac_name}}</h5>
                </div>
            </td>
            <td> <button type="button" class="btn btn-warning text-white" data-toggle="modal" data-target=".bd-example-my-school-{{$row->id}}">แก้ไข</button>
                <div class="modal fade bd-example-my-school-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog my-school-{{$row->id}}">
                    <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>แก้ไขข้อมูลสถาบัน</h3>
                            </div>
                    <div class="card-body text-dark"> 
                        <div class="container">
                        <div class="form-register">
                            <form action="{{route('my_school.update',$row->id)}}" class="form" method="POST" enctype="multipart/form-data">
                                {{ csrf_field()}}
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}">
                                ชื่อสถาบัน :
                                <input type="text" class="form-control" name="school_name" value="{{$row->school_name ??null}}"
                                    placeholder="ป้อนชื่อสถาบัน...">
                                    ปีที่ศึกษา :
                                    <input type="date" class="form-control" name="start" value="{{$row->start ??null}}"
                                        placeholder="เริ่มศึกษาปี...">
                                        ปีที่จบการศึกษา :
                                        <input type="date" class="form-control" name="end" value="{{$row->end ??null}}"
                                            placeholder="จบการศึกษาปี...">
                                            ระดับการศึกษา :
                                            <input type="text" class="form-control" name="edu_level" value="{{$row->edu_level ??null}}"
                                                placeholder="ป้อนระดับการศึกษา...">
                                                ชื่อสาขาวิชาที่ศึกษา :
                                                <input type="text" class="form-control" name="fac_name" value="{{$row->fac_name ??null}}"
                                                    placeholder="ป้อนชื่อสาขาวิชาที่ศึกษา...">
                                <center><button type="submit" class="btn btn-primary mt-3"><h4>ยืนยัน</h4></button></center>
                            </form>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                </div>
            </td>
            <td>
                <form action="{{route('my_school.destroy',$row->id)}}" method="post">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-icon btn-danger"
                        onclick="return confirm('คุณต้องการลบข้อมูลสถาบัน ที่ชื่อ {{$row->school_name}} หรือไม่?')">
                        <h5>ลบ</h5>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endif
</div>
</div>

<div class="card shadow-sm mt-3">
<div class="col-md-12 bg-primary py-1 text-white">
    <h3>
        ข้อมูลประวัติการทำงาน
        <button style="float: right" type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-my-job">เพิ่มข้อมูลประวัติการทำงาน</button>
        <div class="modal fade bd-example-my-job" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog my-job">
            <div class="modal-content">
                    <div class="col-md-12 bg-primary pt-2 text-white">
                        <h3>เพิ่มข้อมูลประวัติทำงาน</h3>
                    </div>
            <div class="card-body text-dark"> 
                <div class="container">
                <div class="form-register">
                    <form action="{{route('my_job.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}">
                        ชื่อสถานที่ทำงาน :
                        <input type="text" class="form-control" name="wp_name" placeholder="ป้อนชื่อสถานที่ทำงาน...">
                            เริ่มทำงานปี :
                            <input type="date" class="form-control" name="start"  placeholder="เริ่มทำงานปี...">
                                ทำงานถึงปี :
                                <input type="date" class="form-control" name="end" placeholder="เริ่มทำงานปี...">
                                    ตำแหน่งงาน :
                                    <input type="text" class="form-control" name="job_title" placeholder="ป้อนตำแหน่งงาน...">
                        <center><button type="submit" class="btn btn-primary mt-3"><h4>ยืนยัน</h4></button></center>
                    </form>
                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
    </h3>
</div>
    <div class="card-body">
        @if ($my_job == null)
        <h5>ไม่พบข้อมูลประวัติการทำงาน</h5>
        @else
        <table class="table table-vertical-center" id="employee_table">
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4></h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อสถานที่ทำงาน :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เริ่มทำงานปี :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ทำงานถึงปี :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ตำแหน่งงาน :</h4>
                    </span>
                </th>
                <th colspan="2" width="5%">
                </th>
            </tr>
            @foreach($my_job as $i=>$row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$i+1}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->wp_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->start}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->end}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->job_title}}</h5>
                    </div>
                </td>
                <td>
                    <button style="float: right" type="button" class="btn btn-warning text-white mx-1" data-toggle="modal" data-target=".bd-example-my-job-{{$row->id}}">แก้ไข</button>
            <div class="modal fade bd-example-my-job-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog my-job-{{$row->id}}">
                <div class="modal-content">
                        <div class="col-md-12 bg-primary pt-2 text-white">
                            <h3>แก้ไขข้อมูลประวัติการทำงาน</h3>
                        </div>
                <div class="card-body text-dark"> 
                    <div class="container">
                    <div class="form-register">
                        <form action="{{route('my_job.update',$row->id)}}" class="form" method="POST" enctype="multipart/form-data">
                            {{ csrf_field()}}
                            {{ method_field('PUT') }}
                            @csrf
                            <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}">
                            ชื่อสถานที่ทำงาน :
                            <input type="text" class="form-control" name="wp_name" value="{{$row->wp_name ??null}}"
                                placeholder="ป้อนชื่อสถานที่ทำงาน...">
                                เริ่มทำงานปี :
                                <input type="date" class="form-control" name="start" value="{{$row->start ??null}}"
                                    placeholder="เริ่มทำงานปี...">
                                    ทำงานถึงปี :
                                    <input type="date" class="form-control" name="end" value="{{$row->end ??null}}"
                                        placeholder="เริ่มทำงานปี...">
                                        ตำแหน่งงาน :
                                        <input type="text" class="form-control" name="job_title" value="{{$row->job_title ??null}}"
                                            placeholder="ป้อนตำแหน่งงาน...">
                            <center><button type="submit" class="btn btn-primary mt-3"><h4>ยืนยัน</h4></button></center>
                        </form>
                    </div>
                </div>
                </div>
                </div>
            </div>
            </div>
                </td>
                <td>
                    <form action="{{route('my_job.destroy',$row->id)}}" method="post">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger"
                            onclick="return confirm('คุณต้องการลบข้อมูลสถานที่ทำงาน ที่ชื่อ {{$row->wp_name}} หรือไม่?')">
                            <h5>ลบ</h5>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @endif
</div>
</div>
@endif
@endsection