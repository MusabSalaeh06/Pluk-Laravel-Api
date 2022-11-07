@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            องค์กรที่ฉันเข้าร่วม
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-vertical-center">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                  <div class="search">
                    <form action="{{route('pages.search_org')}}" method="get">
                      <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control"
                          placeholder="ป้อนชื่อองค์กรที่ต้องการค้นหา..." />
                        <button type="submit" class="btn btn-primary"><i class='bx bx-search-alt-2'></i></button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-3"></div>
              </div><br>
            @if ($sum_omj == 0)
            <h3>คุณยังไม่ได้เข้าร่วมองค์กร</h3>
            <h5>กรุณาค้นหาองค์กรที่สนใจเเละทำการขอเข้าร่วมองค์กรก่อน</h5>
            @else
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อองค์กร :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>เบอร์โทรศัพท์องค์กร :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ผู้ก่อตั้ง :</h4>
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
                <th colspan="2">
                    <span class="font-weight-bolder">
                    </span>
                </th>
            </tr>
            @endif
            {{-- @foreach($org_my_join_req as $row)
            <tr>
                <td>
                    @if ($row->status == null)
                    <div class="text-muted font-weight-bold">
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @else
                    <div class="text-muted font-weight-bold">
                    <a href="#" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->owner->name}} {{$row->org->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ขอเข้าร่วม</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>ขอเข้าร่วมเเล้ว</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <button type="submit" class="btn btn-secondary btn-sm">
                        <h5>ขอเข้าร่วมเเล้ว</h5></button>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <button type="submit" class="btn btn-danger btn-sm">
                        <h5>เลิกขอเข้าร่วม</h5></button>
                    </div>
                </td>
            </tr>
            @endforeach --}}
            @foreach($org_my_join_respond_req as $row)
            <tr>
                <td>
                    @if ($row->status == null)
                    <div class="text-muted font-weight-bold">
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @else
                    <div class="text-muted font-weight-bold">
                    <a href="#" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->owner->name}} {{$row->org->owner->surname}}</h5>
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
                <td>
                    @if ($row->status == null)
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                        <h5>เข้าองค์กร</h5>
                    </a>
                    @else
                    <a href="#" class="btn btn-icon btn-secondary btn-sm">
                        <h5>เข้าองค์กร</h5>
                    </a>
                    @endif
                </td>
                <td>
                    <form action="{{route('member_in_org_req.destroy',$row->id)}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm"  
                        onclick="return confirm('คุณต้องการลบสมาชิกที่ชื่อ {{$row->member->name}} {{$row->member->surname}} หรือไม่?')">
                        <h5>ออกจากองค์กร</h5></button>
                    </form>
                </td>
            </tr>
            @endforeach
            @foreach($org_my_join_respond_inv as $row)
            <tr>
                <td>
                    @if ($row->status == null)
                    <div class="text-muted font-weight-bold">
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @else
                    <div class="text-muted font-weight-bold">
                    <a href="#" class="text-dark">
                        <h5>{{$row->org->org_name}}</h5>
                    </a>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org->owner->name}} {{$row->org->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>เชิญร่วม</h5>
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
                <td>
                    @if ($row->status == null)
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="btn btn-icon btn-warning btn-sm text-white">
                        <h5>เข้าองค์กร</h5>
                    </a>
                    @else
                    <a href="#" class="btn btn-icon btn-secondary btn-sm">
                        <h5>เข้าองค์กร</h5>
                    </a>
                    @endif
                </td>
                <td>
                    <form action="{{route('member_in_org_req.destroy',$row->id)}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger btn-sm"  
                        onclick="return confirm('คุณต้องการลบสมาชิกที่ชื่อ {{$row->member->name}} {{$row->member->surname}} หรือไม่?')">
                        <h5>ออกจากองค์กร</h5></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$org_my_join_respond_req->links("pagination::bootstrap-4")}}</h3>
                    <h3>{{$org_my_join_respond_inv->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection