@extends('/layouts/org_sidebar') @section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            เชิญเข้าองค์กร - {{$data->org_name}}
            {{--<a style="float: right" class="btn btn-light" href="{{route('pages.send_invite_org',$data->org_id)}}"><h5>เชิญเเล้วล่าสุด ({{$co_msio}})</h5></a>--}}
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
                    <form action="{{route('pages.member_search',$data->org_id)}}" method="get">
                      <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control"
                          placeholder="ป้อนรายชื่อบุคคลที่ต้องการค้นหา..." />
                        <button type="submit" class="btn btn-primary"><i class='bx bx-search-alt-2'></i></button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-3"></div>
              </div><br>
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อองค์กร :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อสมาชิก :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ผู้เชิญ:</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder"> </span>
                </th>
            </tr>
            @foreach($member as $row)
            <tr>
                <div class="form-register">
                    <form action="{{route('pages.invite_org.store',$data->org_id)}}" class="form" method="POST">
                        @csrf
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$data->org_name}}</h5>
                                <input type="hidden" class="form-control" name="org_id" value="{{$data->org_id}}"
                                    readonly />
                            </div>
                        </td>
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$row->name}} {{$row->surname}}</h5>
                                <input type="hidden" class="form-control" name="member_id" value="{{$row->member_id}}"
                                    readonly />
                            </div>
                        </td>
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$data->owner->name}} {{$data->owner->surname}}</h5>
                                <input type="hidden" class="form-control" name="owner_invite"
                                    value="{{Auth::user()->member_id}}" readonly />
                            </div>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm"  onclick="return confirm('ยืนยันการเชิญหรือไม่ ?')">
                                <h5><i class='bx bxs-user-plus' ></i>เชิญ</h5>
                            </button>
                        </td>
                    </form>
                </div>
            </tr>
            @endforeach
            @foreach($member_join as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->name}} {{$row->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->owner->name}} {{$data->owner->surname}}</h5>
                    </div>
                </td>
                        <td>
                            <button class="btn btn-secondary btn-sm"><h5>เป็นสมาชิกเเล้ว</h5></button>
                        </td>
            </tr>
            @endforeach
            @foreach($member_request as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->name}} {{$row->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->owner->name}} {{$data->owner->surname}}</h5>
                    </div>
                </td>
                        <td>
                            <button class="btn btn-secondary btn-sm"><h5>ขอเข้าร่วมเเล้ว</h5></button>
                        </td>
            </tr>
            @endforeach
            @foreach($member_invite as $row)
            <tr>
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$data->org_name}}</h5>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$row->name}} {{$row->surname}}</h5>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted font-weight-bold">
                                <h5>{{$data->owner->name}} {{$data->owner->surname}}</h5>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-secondary btn-sm"><h5>เชิญเเล้ว</h5></button>
                        </td>
            </tr>
            @endforeach
            @foreach($member_owner as $row)
            <tr>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->org_name}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$row->name}} {{$row->surname}}</h5>
                    </div>
                </td>
                <td>
                    <div class="text-muted font-weight-bold">
                        <h5>{{$data->owner->name}} {{$data->owner->surname}}</h5>
                    </div>
                </td>
                        <td>
                            <button class="btn btn-secondary btn-sm"><h5>ผู้บริหารองค์กร</h5></button>
                        </td>
            </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$member->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection