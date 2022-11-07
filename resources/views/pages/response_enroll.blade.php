@extends('/layouts/manage_course_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            รายวิชา - {{$data->course_id}} - {{$data->course_name}} - คำขอลงทะเบียน
        </h3>
    </div>
    @if (session('confirm'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('confirm') }}</h5>
        </div>
    @endif
    @if (session('refuse'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('refuse') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center">
            <tr>
                @if ($Renroll_count == null)
                    <h3>รายวิชานี้ยังไม่มีคำขอลงทะเบียน</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>รายวิชา :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ผู้ลงทะเบียน :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>รูปแบบ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เข้าร่วมวันที่ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @endif
            </tr>
            @foreach ($enroll as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->co_detail->course_name}}</h5>
                    </div>
                </td>
                @if ( $row->org_id == null)
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member_detail->name}} {{$row->member_detail->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->enroll_type}}</h5>
                    </div>
                </td>
                @else
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_detail->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->enroll_type}}</h5>
                    </div>
                </td>
                @endif
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->updated_at}}</h5>
                    </div>
                </td>
                <td>
                    @if ( $row->org_id == null)
                        <form action="{{route('pages.invite.enroll',$row->enroll_id)}}" class="form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="course_id" value="{{$row->course_id}}">
                            <input type="hidden" name="member_id" value="{{$row->member_id}}">
                            <button type="submit" name="status" value="ลงทะเบียนเรียบร้อยเเล้ว" class="btn btn-success btn-sm"
                            onclick="return confirm('ท่านต้องการยืนยันการลงทะเบียนให้คุณ {{$row->member_detail->name}} {{$row->member_detail->surname}} หรือไม่ ?')">
                            <h5><i class='bx bx-check' ></i></h5></button>
                            <button type="submit"  name="status" value="การลงทะเบียนถูกปฏิเสธ" class="btn btn-danger btn-sm"
                            onclick="return confirm('ท่านต้องการปฏิเสธการลงทะเบียนให้คุณ {{$row->member_detail->name}} {{$row->member_detail->surname}} หรือไม่ ?')">
                            <h5><i class='bx bx-x' ></i></h5></button>
                        </form>
                    @else
                        <form action="{{route('pages.invite.enroll',$row->enroll_id)}}" class="form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="course_id" value="{{$row->course_id}}">
                            <input type="hidden" name="org_id" value="{{$row->org_id}}">
                            <button type="submit" name="status" value="ลงทะเบียนเรียบร้อยเเล้ว" class="btn btn-success btn-sm"
                            onclick="return confirm('ท่านต้องการยืนยันการลงทะเบียนให้องค์กร {{$row->org_detail->org_name}} หรือไม่ ?')">
                            <h5><i class='bx bx-check' ></i></h5></button>
                            <button type="submit"  name="status" value="การลงทะเบียนถูกปฏิเสธ" class="btn btn-danger btn-sm"
                            onclick="return confirm('ท่านต้องการปฏิเสธการลงทะเบียนให้องค์กร {{$row->org_detail->org_name}} หรือไม่ ?')">
                            <h5><i class='bx bx-x' ></i></h5></button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$enroll->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection