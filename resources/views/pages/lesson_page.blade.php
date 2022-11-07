@extends('/layouts/manage_lesson_sidebar')
@section('content')
{{--ข้อมูลรายวิชา--}}
{{--ข้อมูลบทเรียน--}}
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <div class="row mx-1">
            <h3>
                <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
                จัดการรายวิชา - {{$data->course_id}} - {{$data->course_name}} -  {{$lesson->lesson_name}}
            </h3>
            <div class="ml-auto ">
                <div class="row">       
                    <!-- Large modal -->
                    <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-link-youtube"> <h3><i class='bx bxl-youtube'></i></h3></button>
                    <div class="modal fade bd-example-link-youtube" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog link-youtube">
                        <div class="modal-content">
                                <div class="col-md-12 bg-primary pt-2 text-white">
                                    <h3>แนบลิงค์ยูทูป</h3>
                                </div>
                        <div class="card-body text-dark"> 
                            <div class="container">
                            <div class="form-register">
                                <form action="{{route('link.youtube.store')}}" class="form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                    ชื่อเรื่อง :
                                    <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                                    คำอธิบาย :
                                   <textarea name="description" rows="3" class="form-control" placeholder="ป้อนคำอธิบาย..."></textarea>
                                    แนบลิงค์ยูทูป :
                                    <input type="text" class="form-control" name="link" placeholder="เพิ่มลิงค์..." required>
                                    <input type="hidden" class="form-control" name="owner"   value="{{Auth::user()->member_id}}" readonly><br>
                                    <button type="submit" class="btn btn-primary "><h4>ยืนยัน</h4></button>
                                </form>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <!-- Large modal -->
                    <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-link">  <h3><i class='bx bx-link-alt'></i></h3></button>
                    <div class="modal fade bd-example-link" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog link">
                        <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>แนบลิงค์ภายนอก</h3>
                            </div>
                        <div class="card-body text-dark"> 
                            <div class="container">
                                <div class="form-register">
                                    <form action="{{route('link.Gdrive.store')}}"
                                        class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                        ชื่อเรื่อง :
                                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                                        คำอธิบาย :
                                       <textarea name="description" rows="3" class="form-control" placeholder="ป้อนคำอธิบาย..."></textarea>
                                        แนบลิงค์ :
                                        <input type="text" class="form-control" name="link" placeholder="เพิ่มลิงค์..." required>
                                        <input type="hidden" class="form-control" name="owner"   value="{{Auth::user()->member_id}}" readonly><br>
                                        <button type="submit" class="btn btn-primary "><h4>ยืนยัน</h4></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    
                    <!-- Large modal -->
                    <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-upload-video"><h3><i class='bx bxs-video-plus'></i></h3></button>
                    <div class="modal fade bd-example-upload-video" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog upload-video">
                        <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>อัพโหลดวิดีโอ</h3>
                            </div>
                        <div class="card-body text-dark"> 
                            <div class="container">
                                <div class="form-register">
                                    <form action="{{route('video.store')}}"
                                        class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                        ชื่อเรื่อง :
                                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                                        คำอธิบาย :
                                       <textarea name="description" rows="3" class="form-control" placeholder="ป้อนคำอธิบาย..."></textarea>
                                        อัพโหลดวิดีโอ :
                                        <input type="file" class="form-control" name="file" required>
                                        <input type="hidden" class="form-control" name="owner"   value="{{Auth::user()->member_id}}" readonly><br>
                                        <button type="submit" class="btn btn-primary "><h4>ยืนยัน</h4></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    
                    <!-- Large modal -->
                    <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-upload-image"><h3><i class='bx bxs-image-add'></i></i></h3></button>
                    <div class="modal fade bd-example-upload-image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog upload-image">
                        <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>อัพโหลดรูปภาพ</h3>
                            </div>
                        <div class="card-body text-dark"> 
                            <div class="container">
                                <div class="form-register">
                                    <form action="{{route('image.store')}}"
                                        class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                        ชื่อเรื่อง :
                                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                                        คำอธิบาย :
                                       <textarea name="description" rows="3" class="form-control" placeholder="ป้อนคำอธิบาย..."></textarea>
                                        อัพโหลดรูปภาพ :
                                        <input type="file" class="form-control" name="file" required>
                                        <input type="hidden" class="form-control" name="owner"   value="{{Auth::user()->member_id}}" readonly><br>
                                        <button type="submit" class="btn btn-primary "><h4>ยืนยัน</h4></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    
                    <!-- Large modal -->
                    <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-upload-document"><h3><i class='bx bxs-file icon'></i></h3></button>
                    <div class="modal fade bd-example-upload-document" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog upload-document">
                        <div class="modal-content">
                            <div class="col-md-12 bg-primary pt-2 text-white">
                                <h3>อัพโหลดเอกสาร</h3>
                            </div>
                        <div class="card-body text-dark"> 
                            <div class="container">
                                <div class="form-register">
                                    <form action="{{route('document.store')}}"
                                        class="form" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}" readonly>
                                        ชื่อเรื่อง :
                                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                                        คำอธิบาย :
                                       <textarea name="description" rows="3" class="form-control" placeholder="ป้อนคำอธิบาย..."></textarea>
                                        อัพโหลดเอกสาร :
                                        <input type="file" class="form-control" name="file" required>
                                        <input type="hidden" class="form-control" name="owner"   value="{{Auth::user()->member_id}}" readonly><br>
                                        <button type="submit" class="btn btn-primary "><h4>ยืนยัน</h4></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    <div class="card-body">
        @if (session('destroy'))
            <div class="alert alert-danger" role="alert">
                <h5>{{ session('destroy') }}</h5>
            </div>
        @endif
        @if (session('input'))
            <div class="alert alert-success" role="alert">
                <h5>{{ session('input') }}</h5>
            </div>
        @endif
        <h4> <b>เนื้อหาสรุปบทเรียน :</b></h4>
        <h5>{{$lesson->lesson_detail}}</h5>
        <hr>

        {{--ส่วนวิดีโอยูทูป--}}
        @forelse($link_y as $row)
        <div class="row">
            <div class="col-md-11"><br>
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <div class="video">
            <x-embed url="{{$row->link}}" />
        </div>
        </div>
        <div class="col-md-1">
            <div class="dropdown">
                <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-dots-horizontal-rounded'></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <form action="{{route('link.youtube.edit',$lesson->lesson_id)}}" 
                        class="nav-link dropdown" method="GET" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                        <button type="submit" class="btn btn-warning text-white">แก้ไขเนื้อหา</i></h5></button>
                    </form>
                    <form action="{{route('link.youtube.destroy',$row->id)}}" method="post" class="nav-link dropdown">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-icon btn-danger btn-sm"
                            onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">
                            <h5>ลบเนื้อหา</h5>
                        </button>
                    </form>
                </div>
              </div>
        </div> 
        </div>
        <hr>
        @empty
        @endforelse

        {{--ส่วนเอกสาร--}}
            @forelse($document as $row)
            <div class="row">
                <div class="col-md-11"><br>
            <h4><b> {{$row->name}}</b></h4>
            <h4>{{$row->description}}</h4>
            <a href="/storage/lesson/document_assets/{{$row->file}}" target="_blank">
                <button class="btn btn-primary">
                    <h5><i class='bx bxs-file icon'></i>{{$row->file}}</h5>
                </button>
            </a>
            </div>
            <div class="col-md-1">
                    <div class="dropdown">
                        <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form action="{{route('document.edit',$lesson->lesson_id)}}"
                                class="nav-link dropdown" method="GET" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                                <button type="submit" class="btn btn-warning text-white">แก้ไขเนื้อหา</i></h5></button>
                            </form>
                            <form action="{{route('document.destroy',$row->id)}}" method="post" class="nav-link dropdown">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                    onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">
                                    <h5>ลบเนื้อหา</h5>
                                </button>
                            </form>
                        </div>
                      </div>
            </div>
            </div>
            <hr>
            @empty
            @endforelse

        {{--ส่วนลิงค์ภายนอก--}}
        @forelse($link_g as $row)
        <div class="row">
            <div class="col-md-11"><br>
            <h4><b> {{$row->name}}</b></h4>
            <h4>{{$row->description}}</h4>
        <a href="{{$row->link}}" target="_blank">
            <button class="btn btn-primary">
                <h5><i class='bx bx-link-alt'></i>{{$row->name}}</h5>
            </button>
        </a>
        </div>
        <div class="col-md-1">
                <div class="dropdown">
                    <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-dots-horizontal-rounded'></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form action="{{route('link.Gdrive.edit',$lesson->lesson_id)}}" class="nav-link dropdown" 
                            method="GET" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                            <button type="submit" class="btn btn-warning text-white">แก้ไขเนื้อหา</i></h5></button>
                        </form>
                        <form action="{{route('link.Gdrive.destroy',$row->id)}}" method="post" class="nav-link dropdown">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">
                                <h5>ลบเนื้อหา</h5>
                            </button>
                        </form>
                    </div>
                  </div>
        </div>
        </div>
        <hr>
        @empty
        @endforelse

        {{--ส่วนรูปภาพ--}}
        @forelse($image as $row)
        <div class="row">
            <div class="col-md-11"><br>
                <h4><b> {{$row->name}}</b></h4>
                <h4>{{$row->description}}</h4>
        <img src="/storage/lesson/image_assets/{{$row->file}}"width="600px" height="400px">
            </div>
            <div class="col-md-1">
                    <div class="dropdown">
                        <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bx bx-dots-horizontal-rounded'></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form action="{{route('image.edit',$lesson->lesson_id)}}"
                                class="nav-link dropdown" method="GET" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                                <button type="submit" class="btn btn-warning text-white">แก้ไขเนื้อหา</i></h5></button>
                            </form>
                            <form action="{{route('image.destroy',$row->id)}}" method="post" class="nav-link dropdown">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                    onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">
                                    <h5>ลบเนื้อหา</h5>
                                </button>
                            </form>
                        </div>
                      </div>
            </div>
        </div>
        <hr>
        @empty
        @endforelse
        
        {{--ส่วนวิดีโอ--}}
        @forelse($video as $row)
        <div class="row">
        <div class="col-md-11"><br>
            <h4><b> {{$row->name}}</b></h4>
            <h4>{{$row->description}}</h4>
        <video width="600" height="400" controls>
            <source src="/storage/lesson/video_assets/{{$row->file}}">
        </video>
        </div>
        <div class="col-md-1">
                <div class="dropdown">
                    <button style="float: right" class="btn btn-primary text-white m-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-dots-horizontal-rounded'></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form action="{{route('video.edit',$lesson->lesson_id)}}"
                            class="nav-link dropdown" method="GET" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="id" value="{{$row->id}}" readonly>
                            <button type="submit" class="btn btn-warning text-white">แก้ไขเนื้อหา</i></h5></button>
                        </form>
                        <form action="{{route('video.destroy',$row->id)}}" method="post" class="nav-link dropdown">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-danger btn-sm"
                                onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่?')">
                                <h5>ลบเนื้อหา</h5>
                            </button>
                        </form>
                    </div>
                  </div>
        </div>
        </div>
        <hr>
        @empty
        @endforelse
        {{--
    <form class="form-group" method="#" action="#">
    @csrf
    <div class="card border-dark ">
        <div class="col-md-12 bg-warning py-1 text-dark">
            <div class="row mx-1">
                <h3><b>เว็บบอร์ดสำหรับรายวิชา</b> : laravel</h3>
            </div>
        </div>
        <div class="card-body mx-3">
            <div class="row">
                <div class="mr-auto">
                    <h5><img src="/media/svg/avatars/006-girl-3.svg" width="25px" height="25px"> นิสวีรา
                        มะแน : ไม่เข้าใจตรงไหนถามได้นะค่ะ </h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="mr-auto">
                    <h5><img src="/media/svg/avatars/006-girl-3.svg" width="25px" height="25px"> นิสวีรา
                        มะแน : อาจารย์จะรีบมาตอบนะค่ะ </h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="ml-auto">
                    <h5> ขอบคุณครับอาจารย์ : มุซอับ สาแหละ <img src="/media/svg/avatars/016-boy-7.svg" width="25px"
                            height="25px"></h5>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="mr-auto">
                    <h5><img src="/media/svg/avatars/006-girl-3.svg" width="25px" height="25px"> นิสวีรา
                        มะแน : ยินดีจ้า </h5>
                </div>
            </div>
            <hr>
        </div>
        <textarea name="#" cols="20" rows="2" placeholder="ถาม-ตอบ สำหรับรายวิชานี้ ...."></textarea>
        <button class="btn btn-warning" type="submit">
            <h5>ส่ง</h5>
        </button>
    </div>
</form>
--}}
    </div>
</div>
@endsection
