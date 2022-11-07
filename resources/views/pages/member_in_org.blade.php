@extends('/layouts/org_sidebar')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ข้อมูลสมาชิก - {{$data->org_name}}
        </h3>
    </div>
    @if (session('status'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center">
            <tr>
                @if ($mio_i == null and $mio_r == null)
                    <h3>องค์กรยังไม่มีสมาชิกเพิ่ม</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อ-สกุล :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เพศ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เบอร์โทร :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>อีเมล :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เข้าร่วมเมื่อ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>รูปแบบ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>สถานะ :</h4>
                    </span>
                </th>
                @if (Auth::user()->member_id == $data->org_owner)
                <th colspan="2">
                    <span class="font-weight-bolder">
                    </span>
                </th>
                @else
                @endif
                @endif
            </tr>
            @foreach($member_in_org_inv as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->name}} {{$row->member->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->gender}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->email}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->created_at}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>เชิญเข้าร่วม</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        @if ($row->status == null)
                        <h5>สมาชิกองค์กร</h5>
                        @else
                        <h5>{{$row->status}}</h5>
                        @endif
                    </div>
                </td>
                @if (Auth::user()->member_id == $data->org_owner)
                <td>
                    <div class="nav-link dropdown"><button class="btn btn-primary btn-sm"><h5><i class='bx bxs-chat'></i></h5></button></div>
                </td>
                <td>
                    <form action="{{route('member_in_org_inv.destroy',$row->id)}}" class="nav-link dropdown" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm('คุณต้องการลบสมาชิกที่ชื่อ {{$row->member->name}} {{$row->member->surname}} หรือไม่?')">
                        <h5><i class='bx bxs-user-minus' ></i></h5></button>
                    </form>
                </td>
                @else
                @endif
            </tr>
            @endforeach
            @foreach($member_in_org_req as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->name}} {{$row->member->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->gender}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->member->email}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->created_at}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ขอเข้าร่วม</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        @if ($row->status == null)
                        <h5>สมาชิกองค์กร</h5>
                        @else
                        <h5>{{$row->status}}</h5>
                        @endif
                    </div>
                </td>
                @if(Auth::user()->member_id == $data->org_owner)
                <td>
                    <div class="nav-link dropdown"><button class="btn btn-primary btn-sm"><h5><i class='bx bxs-chat'></i></h5></button></div>
                </td>
                <td>
                    <form action="{{route('member_in_org_req.destroy',$row->id)}}" class="nav-link dropdown" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm" 
                        onclick="return confirm('คุณต้องการลบสมาชิกที่ชื่อ {{$row->member->name}} {{$row->member->surname}} หรือไม่?')">
                        <h5><i class='bx bxs-user-minus'></i></h5></button>
                    </form>
                </td>
                @else
                @endif
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$member_in_org_inv->links("pagination::bootstrap-4")}}</h3>
                    <h3>{{$member_in_org_req->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection