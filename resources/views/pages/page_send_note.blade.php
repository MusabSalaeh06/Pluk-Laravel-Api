@extends('/layouts/manage_lesson_sidebar') @section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <div class="row px-2">
            <h3>
                <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
                จัดการบทเรียนรายวิชา - {{$data->course_id}} - {{$data->course_name}} -  {{$lesson->lesson_name}} - บันทึกย่อรูปแบบบุคคล
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
                @if ( $send_note == null)
                   <h3>ระบบตรวจสอบเเล้วไม่พบบันทึกย่อรูปแบบบุคคลภายในบทเรียนนี้</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อผู้ส่ง:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>สถานะ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ส่งเมื่อ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เนื้อหาบันทึกย่อ:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @endif
            </tr>
            @foreach($note as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>
                            {{$row->creator_detail->name}}
                            {{$row->creator_detail->surname}}
                        </h5>
                    </div>
                </td>
                <td>
                    @if ($row->note == null) 
                        <div class="text-muted font-weight-bold">
                            <h5>ยังไม่ส่ง</h5>
                        </div>
                    @else
                        <div class="text-muted font-weight-bold">
                            <h5>ส่งเเล้ว</h5>
                        </div>
                    @endif
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->created_at}}</h5>
                    </div>
                </td>
                <td>
                    <div class="dropdown">
                      {{-- Toggle --}}
                      <div class="topbar-item"  data-toggle="dropdown" data-offset="10px,0px">
                          <button class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-sm px-2 btn-warning text-white"><h5>กดดูบันทึกย่อ</h5>
                          </button>
                      </div>
                      {{-- Dropdown --}}
                      <div class="dropdown-menu w-400px bg-light-warning">
                        <div class="container">
                          <h5>
                              {{$row->note}}
                          </h5>
                        </div>
                      </div>
                    </div>
                   </td>
                   <td>
                    <form action="{{route('note.destroy',$row->id)}}" method="post" >
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger btn-sm "
                            onclick="return confirm('คุณต้องการลบข้อมูลบันทึกย่อ ของ  {{$row->creator_detail->name}} {{$row->creator_detail->surname}} หรือไม่?')" title="ลบบันทึกย่อ">
                            <h4><i class='bx bxs-trash-alt'></i></h4>
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
                    <h3>{{$note->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection