@extends('/layouts/org_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            คำขอเข้าร่วมองค์กร - {{$data->org_name}}
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
            @forelse($org_request as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ชื่อองค์กร : {{$row->org->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ขอเมื่อ : {{$row->created_at}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ผู้ขอเข้าร่วม : {{$row->member->name}} {{$row->member->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ผู้ตอบรับ : {{Auth::user()->name}} {{Auth::user()->surname}}</h5>
                    </div>
                </td>
                <td>
                                <div class="form-register">
                                    <form action="{{route('pages.respond_request_org.store',$data->org_id)}}"
                                        class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="request_id" value="{{$row->request_id}}" readonly>
                                        <input type="hidden" class="form-control" name="member_id" value="{{$row->member_id}}" readonly>
                                        <input type="hidden" class="form-control" name="org_id" value="{{$row->org_id}}" readonly>
                                        <button type="submit" value="ยืนยัน" name="answer" class="btn btn-success btn-sm" onclick="return confirm('คุณต้องการ ยืนยัน การขอเข้าร่วมองค์กรหรือไม่ ?')" >
                                            <h5><i class='bx bx-check' ></i></h5>
                                        </button>
                                        <button type="submit" value="ปฎิเสธ" name="answer" class="btn btn-danger btn-sm" onclick="return confirm('คุณต้องการ ปฏิเสธ การขอเข้าร่วมองค์กรหรือไม่ ?')" >
                                            <h5><i class='bx bx-x' ></i></h5>
                                        </button>
                                    </form>
                                </div>
                </td>
            </tr>
            @empty
            <h3>ยังไม่มีการขอเข้าร่วมองค์กร</h3>
            @endforelse
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$org_request->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection