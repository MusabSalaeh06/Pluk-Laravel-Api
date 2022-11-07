@extends('/layouts/default')
@section('content')
@if ($my_course_co == null)
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            รายวิชาที่เปิดให้ลงทะเบียน({{$co_course}})
        </h3>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
            <div class="row">
            @foreach($course as $row)
              <div class="col-md-2 my-1">
                <div class="card border-dark">
                      <div class="card-body">
                        <center>  
                            @if ( $row->co_detail->course_img == null)
                            <img src="/img/no_image.jpg" style="width: 250px; height: 150px; object-fit: fill;"/>
                            @else
                            <img src="/storage/course/course_img_assets/{{$row->co_detail->course_img}}" style="width: 250px; height: 150px; object-fit: fill;"/>
                            @endif
                        <a href="{{route('pages.course_detail',$row->course_id)}}" class="text-dark">
                            <h4><b>{{$row->co_detail->course_name}}</b></h4>
                        </a>
                       <h5>ติวเตอร์ : {{$row->co_detail->owner->name}} {{$row->co_detail->owner->surname}}</h5>
                       <h5>จำนวนผู้ลงทะเบียน : {{$row->enr_count}}</h5>
                       
                       <form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="course_id" value="{{$row->course_id}}" readonly>
                        <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
                        <center>
                          @if ($row->co_detail->course_type == "สาธารณะ")
                          <button type="submit" class="btn btn-icon btn-success" 
                          onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->co_detail->course_name}} หรือไม่ ?')">
                          <h5><i class='bx bxs-user-circle' ></i> ลงทะเบียนฟรี</h5></button>
                          @else
                          <button type="submit" class="btn btn-icon btn-success" 
                          onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->co_detail->course_name}} หรือไม่ ?')">
                          <h5><i class='bx bxs-user-circle' ></i> ลงทะเบียน</h5></button>
                          @endif

                        </center>
                        </form>
                       </center>
                      </div>
                  </div>
              </div>
            @endforeach
            @foreach($course_ne as $row)
            <div class="col-md-2 my-1">
              <div class="card border-dark">
                    <div class="card-body">
                      <center>  
                          @if ( $row->course_img == null)
                          <img src="/img/no_image.jpg" style="width: 250px; height: 150px; object-fit: fill;"/>
                          @else
                          <img src="/storage/course/course_img_assets/{{$row->course_img}}" style="width: 250px; height: 150px; object-fit: fill;"/>
                          @endif
                      <a href="{{route('pages.course_detail',$row->id)}}" class="text-dark">
                          <h4><b>{{$row->course_name}}</b></h4>
                      </a>
                     <h5>ติวเตอร์ : {{$row->owner->name}} {{$row->owner->surname}}</h5>
                     <h5>จำนวนผู้ลงทะเบียน : 0</h5>
                     
                     <form action="{{route('enroll.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="course_id" value="{{$row->id}}" readonly>
                        <input type="hidden" class="form-control" name="member_id" value="{{Auth::user()->member_id}}" readonly>
                        <center>
                          @if ($row->course_type == "สาธารณะ")
                          <button type="submit" class="btn btn-icon btn-success" 
                          onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->course_name}} หรือไม่ ?')">
                          <h5><i class='bx bxs-user-circle' ></i> ลงทะเบียนฟรี</h5></button>
                          @else
                          <button type="submit" class="btn btn-icon btn-success" 
                          onclick="return confirm('คุณยืนยันที่จะลงทะเบียนรายวิชา {{$row->course_name}} หรือไม่ ?')">
                          <h5><i class='bx bxs-user-circle' ></i> ลงทะเบียน</h5></button>
                          @endif

                        </center>
                    </form>
                     </center>
                    </div>
                </div>
            </div>
          @endforeach
            </div><br>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$my_course->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@else
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            รายวิชาที่ฉันลงทะเบียน({{$co_my_course}})
        </h3>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
            <div class="row">
            @foreach($my_course as $row)
              <div class="col-md-2 my-1">
                <div class="card border-dark">
                      <div class="card-body">
                        <center>  
                            @if ( $row->co_detail->course_img == null)
                            <img src="/img/no_image.jpg" style="width: 250px; height: 150px; object-fit: fill;"/>
                            @else
                            <img src="/storage/course/course_img_assets/{{$row->co_detail->course_img}}" style="width: 250px; height: 150px; object-fit: fill;"/>
                            @endif
                            @if ( $row->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
                        <a href="{{route('pages.course_index',$row->course_id)}}" class="text-dark">
                            <h4><b>{{$row->co_detail->course_name}}</b></h4>
                        </a>
                        @else
                        <a href="#" class="text-dark">
                            <h4><b>{{$row->co_detail->course_name}}</b></h4>
                        </a>
                        @endif
                       <h5>ติวเตอร์ : {{$row->co_detail->owner->name}} {{$row->co_detail->owner->surname}}</h5>
                       <h5>จำนวนผู้ลงทะเบียน : {{$row->enr_count}}</h5>
                       </center>
                      </div>
                      @if ( $row->status == 'ลงทะเบียนเรียบร้อยเเล้ว')
                          <a href="{{route('pages.course_index',$row->course_id)}}" 
                              class="btn btn-icon btn-warning btn-sm text-white" title="ดูรายวิชา">
                              <h5><i class='bx bxs-show' ></i></h5>
                          </a>
                      @else
                          <a class="btn btn-icon btn-secondary btn-sm text-white" title="รอดำเนินการ">
                              <h5><i class='bx bxs-hide'></i> </h5>
                          </a>
                      @endif
                  </div>
              </div>
            @endforeach
            {{-- @foreach($my_course_ne as $row)
            <div class="col-md-2 my-1">
              <div class="card border-dark">
                    <div class="card-body">
                      <center>  
                          @if ( $row->course_img == null)
                          <img src="/img/no_image.jpg" style="width: 250px; height: 150px; object-fit: fill;"/>
                          @else
                          <img src="/storage/course/course_img_assets/{{$row->course_img}}" style="width: 250px; height: 150px; object-fit: fill;"/>
                          @endif
                      <a href="{{route('pages.course_index',$row->course_id)}}" class="text-dark">
                          <h4><b>{{$row->course_name}}</b></h4>
                      </a>
                     <h5>ติวเตอร์ : {{$row->owner->name}} {{$row->owner->surname}}</h5>
                     <h5>จำนวนผู้ลงทะเบียน : 0</h5>
                     </center>
                    </div>
                </div>
            </div>
          @endforeach --}}
            </div><br>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-3">
                <center>
                    <h3>{{$my_course->links("pagination::bootstrap-4")}}</h3>
                </center>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
@endif
@endsection