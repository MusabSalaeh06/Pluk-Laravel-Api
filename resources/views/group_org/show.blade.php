@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 mb-3 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ค้นหาองค์กร
            {{-- <a style="float: right" class="btn btn-light" href="{{route('pages.send_request_org')}}"><h5>ขอเข้าร่วมล่าสุด ({{$co_msro}})</h5></a>--}}
        </h3>
    </div>
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        <h5>{{ session('status') }}</h5>
    </div>
    @endif
    <div class="card-body">
        <table class="table table-vertical-center" id="employee_table">  
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
            <tr>
                @if ( $co_group_org == null)
                    <h3>ระบบค้นหาองค์กรที่คุณต้องการไม่พบ</h3>
                @else
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อองค์กร :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>คำอธิบาย :</h4>
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
                    </span>
                </th>
                @endif
            </tr>
            @foreach($group_org as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->description}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                                <div class="form-register">
                                    <form action="{{route('pages.request_org.store')}}" class="form"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="org_id" value="{{$row->org_id}}"
                                            readonly>
                                        <input type="hidden" class="form-control" name="member_id"
                                            value="{{Auth::user()->member_id}}" readonly>
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('ยืนยันการขอเข้าร่วมองค์กรหรือไม่ ?')" >
                                            <h5><i class='bx bx-log-in' ></i> ขอเข้าร่วม</h5>
                                        </button>
                                    </form>
                                </div>
                </td>
            </tr>
            @endforeach
            @foreach($group_org_join as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <a href="{{route('pages.index_org',$row->org_id)}}" class="text-dark">
                        <h5>{{$row->org_name}}</h5>
                    </a>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->description}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <button class="btn btn-secondary"><h5>เข้าร่วมเเล้ว</h5></button>
                </td>
            </tr>
            @endforeach
            @foreach($group_org_request as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->description}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <button class="btn btn-secondary"><h5>ขอเข้าร่วมเเล้ว</h5></button>
                </td>
            </tr>
            @endforeach
            @foreach($group_org_invite as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->description}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <button class="btn btn-secondary"><h5>ถูกเชิญเเล้ว</h5></button>
                </td>
            </tr>
            @endforeach
            @foreach($group_org_owner as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->description}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->org_tel}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->owner->name}} {{$row->owner->surname}}</h5>
                    </div>
                </td>
                <td>
                    <button class="btn btn-secondary"><h5>องค์กรที่ฉันเปิด</h5></button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection