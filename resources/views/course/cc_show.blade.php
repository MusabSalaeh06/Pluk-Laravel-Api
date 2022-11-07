@extends('/layouts/default')
@section('content')
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            หมวดหมู่รายวิชาทั้งหมด
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-vertical-center">
            <tr>
                <th>
                    <span class="font-weight-bolder">
                        <h4>ชื่อหมวดหมู่ :</h4>
                    </span>
                </th>
                <th>
                    <span class="font-weight-bolder">
                        <h4>อักษรย่อ :</h4>
                    </span>
                </th>
                <th colspan="3">
                    <span class="font-weight-bolder">
                    </span>
                </th>
                {{----}}
                <th>
                    <span class="font-weight-bolder">
                        <h4></h4>
                    </span>
                </th>
                {{-- <h3>ไม่พบข้อมูลหมวดหมู่รายวิชา</h3>--}}
            </tr>
            @foreach($cc as $row)
                        <tr>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->name}}</h5>
                                </div>
                            </td>
                            <td>
                                <div class="text-muted font-weight-bold">
                                    <h5>{{$row->short_name}}</h5>
                                </div>
                            </td>
                            <td>
                                <a href="{{route('course_category.edit',$row->cc_id)}}" class="btn btn-icon btn-success btn-sm">
                                    <h5><i class='bx bxs-edit'></i></h5>
                                </a>
                            </td>
                            <td>
                                <form action="{{route('course_category.destroy',$row->cc_id)}}" method="post">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                        onclick="return confirm('คุณต้องการลบหมวดหมู่รายวิชาที่ชื่อ {{$row->name}} หรือไม่?')">
                                       <h5> <i class='bx bxs-trash-alt'></i> </h5>
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
                    <h3>{{$cc->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endsection