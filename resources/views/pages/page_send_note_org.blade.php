@extends('/layouts/manage_lesson_sidebar') @section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <div class="row px-2">
            <h3>
                <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
                จัดการบทเรียนรายวิชา - {{$data->course_id}} - {{$data->course_name}} -  {{$lesson->lesson_name}} - บันทึกย่อรูปแบบองค์กร
            </h3>
            <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          เลือกรูปแบบ
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="{{route('pages.page_send_note',$lesson->lesson_id)}}"><h5>รูปแบบบุคคล</h5></a>
                          <a class="dropdown-item" href="{{route('pages.page_send_note_org',$lesson->lesson_id)}}"><h5>รูปแบบองค์กร</h5></a>
                        </div>
                      </div>
            </div>
        </div>
    </div>
    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center">
            <tr>
                @if ( $num_enroll == null)
                   <h3>ระบบตรวจสอบเเล้วไม่พบองค์กรที่ลงทะเบียนรายวิชานี้</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อองค์กร:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ผู้ก่อตั้ง :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @endif
            </tr>
            @foreach($enroll as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>
                            {{$row->org_detail->org_name}}
                        </h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_detail->owner->name}} {{$row->org_detail->owner->surname}}</h5>
                    </div>
                </td>
                   <td>
                    <form action="{{route('pages.note_member_in_org',$lesson->lesson_id)}}" method="post" >
                        @csrf
                        <input type="hidden" name="org_id" value="{{$row->org_id}}" >
                        <button type="submit" class="btn btn-icon btn-warning text-white btn-sm ">
                            <h4><i class='bx bxs-show' ></i> </h4>
                        </button>
                    </form>
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