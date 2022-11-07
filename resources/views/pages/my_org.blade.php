@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            องค์กรของฉัน
            <a  href="{{route('group_org.create')}}" style="float: right" class="btn btn-light m-2"><h5>สร้างกลุ่มองค์กร</h5></a>
        </h3>
    </div>
    @if (session('new'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('new') }}</h5>
        </div>
    @endif
    <div class="card-body">
        @if( Auth::user()->count_org == null )
        <h3>คุณยังไม่ได้สร้างองค์กร</h3>
        @else
        <table class="table table-vertical-center">
            <tr>
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
            </tr>
            @foreach($my_org as $row)
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
                    <a href="{{route('pages.index_org',$row->org_id)}}" class="btn btn-icon btn-warning text-white btn-sm">
                        <h5><i class='bx bxs-show' ></i></h5> 
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
        @endif
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$my_org->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection