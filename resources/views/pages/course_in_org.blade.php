@extends('/layouts/org_sidebar')
@section('content')
        <div class="card shadow-sm">
            <div class="col-md-12 bg-primary py-1 text-white">
                    <h3>
                        <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
                        รายวิชาขององค์กร - {{$data->org_name}}
                        @if (Auth::user()->member_id == $data->org_owner)
                        <a style="float: right" href="{{route('enroll.in.org',$data->org_id)}}" class="btn btn-light"><h5>จัดการรายวิชา</h5></a>
                        @else
                        @endif
                    </h3>
                    {{-- <div class="ml-auto">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              ตัวเลือก
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{route('enroll.in.org',$data->org_id)}}"><h5>ลงทะเบียนเเล้ว</h5></a>
                              <a class="dropdown-item" href="{{route('pages.course_in_org',$data->org_id)}}"><h5>รายวิชาที่ยังไม่ลงทะเบียน</h5></a>
                              <a class="dropdown-item" href="{{route('pages.course_in_org',$data->org_id)}}"><h5>รายวิชาทั้งหมด</h5></a>
                            </div>
                          </div>
                    </div>--}} 
            </div>
            @if (session('enroll'))
                <div class="alert alert-success" role="alert">
                    <h5>{{ session('enroll') }}</h5>
                </div>
            @endif
            <div class="card-body">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6 my-3">
                    <div class="search">
                        <form action="{{route('pages.org_search_course',$data->org_id)}}" method="get">
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
            </div> 
                        <table class="table table-vertical-center" id="employee_table">
                        <tr>
                            @if ($cio_count == null)
                            @if (Auth::user()->member_id == $data->org_owner)
                            <h3>คุณยังไม่ได้ลงทะเบียนรายวิชา</h3>
                            <h5>กรุณาค้นหารายวิชาเเละทำการลงทะเบียนรายวิชาก่อน</h5>
                            @else
                            <h3>ยังไม่มีรายวิชาภายในองค์กร</h3>
                            @endif
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
                                    <h4>ประเภทรายวิชา :</h4>
                                </span>
                            </th>
                            <th>
                                <span class="font-weight-bolder">
                                    <h4>สถานะการลงทะเบียน :</h4>
                                </span>
                            </th>
                            <th colspan="2">
                                <span class="font-weight-bolder">
                                </span>
                            </th>
                            @endif
                        </tr>
                        @foreach($course as $row)
                        <tr>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->co_detail->course_id}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <a href="{{route('pages.course_detail_org',$row->enroll_id)}}" class="text-dark">
                                    <h5>{{$row->co_detail->course_name}} 
                                        @foreach($course_enr as $subrow)
                                        @if ($subrow->course_id == $row->course_id)
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
                                    <h5>{{$row->co_detail->owner->name}} {{$row->co_detail->owner->surname}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->co_detail->course_type}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->status}}
                                        @foreach($course_mio_enr as $subrow)
                                        @if ($subrow->course_id == $row->course_id)
                                        ({{$subrow->enr_count}}/{{$mio_count}})
                                        @else
                                        @endif
                                        @endforeach
                                    </h5>
                                </div>
                            </td>
                            <td>
                                @if ( $row->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
                                <div class="form-register">
                                    <form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="org_id" value="{{$data->org_id}}" readonly>
                                        <input type="hidden" class="form-control" name="course_id" value="{{$row->co_detail->id}}" readonly>
                                        <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
                                        <button type="submit" class="btn btn-icon btn-success btn-sm" 
                                        onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->co_detail->course_name}} หรือไม่ ?')">
                                        <h5><i class='bx bxs-user-circle' ></i> เข้าร่วมรายวิชาขององค์กร</h5></button>
                                    </form>
                                </div>
                                @elseif($row->status == 'รอดำเนินการ')
                                <div class="text-muted font-weight-bold">
                                    <button class="btn btn-secondary"><h5>เข้าร่วมรายวิชาขององค์กร</h5></button>
                                </div>
                                @elseif($row->status == 'การลงทะเบียนถูกยกเลิก')
                                <div class="text-muted font-weight-bold">
                                    <button class="btn btn-danger"><h5>การลงทะเบียนถูกยกเลิก</h5></button>
                                </div>
                                @elseif($row->status == 'การลงทะเบียนถูกปฏิเสธ')
                                <div class="text-muted font-weight-bold">
                                    <button class="btn btn-danger"><h5>การลงทะเบียนถูกปฏิเสธ</h5></button>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                       
                        @foreach($course_me_enroll as $row)
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
                                            @endforeach
                                        </h5>
                                    </a>
                                </div>
                                @else
                                <div class="text-muted font-weight-bold">
                                    <a href="{{route('pages.course_detail_org',$row->enroll_id)}}" class="text-dark">
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
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->status}}</h5>
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
                                            @endforeach
                                        </h5>
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
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>-</h5>
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
                </div>
            </div>
@endsection