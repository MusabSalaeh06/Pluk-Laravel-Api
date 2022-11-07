@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            รายวิชาที่เปิดให้ลงทะเบียน({{$co_course}})
        </h3>
    </div>
    @if (session('enroll'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('enroll') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center" id="employee_table">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="search">
                        <form action="{{route('pages.search_course')}}" method="get">
                            <div class="input-group">
                                <input type="text" name="search" id="search" class="form-control" placeholder="ป้อนชื่อรายวิชาที่ต้องการค้นหา" /> 
                                <select class="form-control" name="cc_id">
                                    <option value="">เลือกหมวดหมู่รายวิชา</option>
                                    <option value="">รายวิชาทั้งหมด</option>
                                    @foreach($cc as $row)
                                    <option value="{{$row->cc_id}}">{{$row->name}}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary"><i class='bx bx-search-alt-2'></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div><br>
            <tr>
                @if ($co_course == null)
                    <h3>ระบบค้นหาเเล้วไม่พบรายวิชาที่คุณต้องการ</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>รหัสรายวิชา :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อรายวิชา :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ติวเตอร์ประจำวิชา :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>หมวดหมู่รายวิชา :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ประเภทรายวิชา :</h4>
                    </span>
                </th>
                {{----}}
                <th>
                    <span class="font-weight-bolder">
                        <h4></h4>
                    </span>
                </th>
                @endif
            </tr>
            @foreach($course as $row)
                        <tr>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->course_id}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <a href="{{route('pages.course_detail',$row->id)}}" class="text-dark">
                                        <h5>{{$row->course_name}} 
                                            @foreach($course_enr as $subrow)
                                            @if ($subrow->course_id == $row->id)
                                            ({{$subrow->enr_count}})
                                            @else
                                            @endif
                                            @endforeach
                                        </h5>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->cc->name}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->course_type}}</h5>
                                </div>
                            </td>
                            <td>
                            <div class="form-register">
                                <form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control" name="course_id" value="{{$row->id}}" readonly>
                                    <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
                                    @if ($row->course_type == "สาธารณะ")
                                        <button type="submit" class="btn btn-icon btn-primary btn-sm" 
                                            onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->course_name}} หรือไม่ ?')">
                                            <h5><i class='bx bxs-user-circle' ></i>ลงทะเบียนฟรี</h5>
                                        </button>
                                        @else
                                        <button type="submit" class="btn btn-icon btn-primary btn-sm" 
                                            onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->course_name}} หรือไม่ ?')">
                                            <h5><i class='bx bxs-user-circle' ></i>ลงทะเบียน</h5>
                                        </button>
                                        @endif
                                </form>
                            </div>
                            </td>
                        </tr>
            @endforeach
            @foreach($course_me_enroll as $row)
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
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->cc->name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_type}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <button class="btn btn-secondary"><h5>ลงทะเบียนเเล้ว</h5></button>
                    </div>
                </td>
                <td></td>
            </tr>
            @endforeach
            @foreach($owner_course as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_id}}</h5>
                    </div>
                </td>
                <td>
                    <a href="{{route('pages.course_index',$row->id)}}" class="text-dark">
                        <h5>{{$row->course_name}}
                            @foreach($course_enr as $subrow)
                            @if ($subrow->course_id == $row->id)
                            ({{$subrow->enr_count}})
                            @else
                            @endif
                            @endforeach</h5>
                        </a>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->cc->name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->course_type}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <button class="btn btn-secondary"><h5>รายวิชาที่ฉันสอน</h5></button>
                    </div>
                </td>
                <td></td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$course->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection