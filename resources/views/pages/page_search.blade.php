@extends('/layouts/default')
@section('content')
<div class="card bg-white shadow-sm">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <center>
          <h4>ค้นหารายวิชา :</h4>
        </center>
        <div class="search">
          <form action="{{route('pages.search_course')}}" method="get">
            <div class="input-group">
              <input type="text" name="search" id="search" class="form-control"
                placeholder="ป้อนชื่อรายวิชาที่ต้องการค้นหา" />
              <select class="form-control" name="cc_id">
                <option value="">เลือกหมวดหมู่รายวิชา</option>
                <option value="">รายวิชาทั้งหมด</option>
                @foreach($cc as $row)
                <option value="{{$row->cc_id}}">{{$row->name}}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn-primary"><i class='bx bx-search-alt-2'></i></button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div><br>

    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <center>
          <h4>ค้นหาองค์กร :</h4>
        </center>
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
  </div>
</div>
@endsection