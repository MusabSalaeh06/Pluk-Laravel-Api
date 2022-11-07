@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            รายวิชาที่ฉันลงทะเบียน({{$co_my_course}})
        </h3>
    </div>
    @if (session('drop'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('drop') }}</h5>
        </div>
    @endif
    @if (session('enroll'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('enroll') }}</h5>
        </div>
    @endif
    @if (session('cancel'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('cancel') }}</h5>
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
                @if ($co_my_course == null)
                <h3>คุณยังไม่ได้ลงทะเบียนรายวิชา</h3>
                <h5>กรุณาค้นหารายวิชาเเละทำการลงทะเบียนรายวิชาก่อน</h5>
                @else
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>รหัสรายวิชา :</h4>
                    </span>
                </th>
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>ชื่อรายวิชา :</h4>
                    </span>
                </th>
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>ติวเตอร์ประจำวิชา :</h4>
                    </span>
                </th>
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>ประเภทรายวิชา :</h4>
                    </span>
                </th>
                {{--
                <th>
                    <span class="font-weight-bolder">
                        <h4>สถานะการลงทะเบียน :</h4>
                    </span>
                </th>--}}
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>รูปแบบ :</h4>
                    </span>
                </th>
                <th width="15%">
                    <span class="font-weight-bolder">
                        <h4>สถานะ :</h4>
                    </span>
                </th>
                <th width="10%">
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @endif
            </tr>
            @foreach($my_course as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->co_detail->course_id}}</h5>
                    </div>
                </td>
                <td>
                    @if ( $row->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
                    <div class="text-muted font-weight-bold">
                        <a href="{{route('pages.course_index',$row->co_detail->id)}}" class="text-dark">
                        <h5>{{$row->co_detail->course_name}}
                            @foreach($course_enr as $subrow)
                            @if ($subrow->course_id == $row->course_id)
                            ({{$subrow->enr_count}})
                            @else
                            @endif
                            @endforeach</h5>
                        </a>
                    </div>
                    @else
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->co_detail->course_name}}</h5>
                        </a>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->co_detail->owner->name}} {{$row->co_detail->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->co_detail->course_type}}</h5>
                    </div>
                </td>
                {{--<td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->status}}</h5>
                    </div>
                </td>--}}
                <td>
                    <div class="text-muted font-weight-bold">
                        @if ($row->org_id == null)
                        <h5>{{$row->enroll_type}}</h5>
                        @else
                        <h5>{{$row->enroll_type}} {{$row->org_detail->org_name}}</h5>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->status}}</h5>
                    </div>
                </td>
                <td>
                    <div class="row">
                        @if ( $row->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
                        <a href="{{route('pages.course_index',$row->co_detail->id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                            <h5><i class='bx bxs-show' ></i> </h5>
                        </a>  &nbsp; &nbsp;
                        <form action="{{route('pages.invite.enroll',$row->enroll_id)}}" class="form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="member_id" value="{{$row->member_id}}">
                            <input type="hidden" name="course_id" value="{{$row->course_id}}">
                            <input type="hidden" name="status" value="การลงทะเบียนถูกยกเลิก">
                            <button type="submit" class="btn btn-danger btn-sm " 
                                onclick="return confirm('คุณต้องการยกเลิกลงทะเบียนรายวิชา {{$row->co_detail->course_name}} หรือไม่ ?')">
                                <h5><i class='bx bxs-minus-circle' ></i> </h5>
                            </button>
                        </form>
                    @else
                        <a class="btn btn-icon btn-secondary btn-sm text-white">
                            <h5><i class='bx bxs-hide' ></i> </h5>
                        </a>  &nbsp; &nbsp;
                        <form action="{{route('enroll.destroy',$row->enroll_id)}}" method="post">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                onclick="return confirm('คุณต้องการดรอปรายวิชา {{$row->co_detail->course_name}} หรือไม่?')">
                               <h5><i class='bx bxs-minus-circle' ></i> </h5>
                            </button>
                        </form>
                    @endif
                </div>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$my_course->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection