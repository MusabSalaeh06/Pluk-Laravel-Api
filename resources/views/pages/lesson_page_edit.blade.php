@extends('/layouts/manage_lesson_sidebar')
@section('content')
{{--ข้อมูลรายวิชา--}}
{{--ข้อมูลบทเรียน--}}
<div class="card shadow-sm">
  <div class="col-md-12 bg-primary py-1 text-white">
    <div class="row mx-1">
      <h3>
        <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square'></i></a>
        จัดการรายวิชา - {{$data->course_id}} - {{$data->course_name}} - {{$lesson->lesson_name}}
      </h3> 
      <div class="ml-auto ">
        <div class="row">
          <!-- Large modal -->
          <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-link-youtube">
            <h3><i class='bx bxl-youtube'></i></h3>
          </button>
          <div class="modal fade bd-example-link-youtube" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog link-youtube">
              <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                  <h3>แนบลิงค์ยูทูป</h3>
                </div>
                <div class="card-body text-dark">
                  <div class="container">
                    <div class="form-register">
                      <form action="{{route('link.youtube.store')}}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}"
                          readonly>
                        ชื่อเรื่อง :
                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                        คำอธิบาย :
                        <textarea name="description" rows="3" class="form-control"
                          placeholder="ป้อนคำอธิบาย..."></textarea>
                        แนบลิงค์ยูทูป :
                        <input type="text" class="form-control" name="link" placeholder="เพิ่มลิงค์..." required>
                        <input type="hidden" class="form-control" name="owner" value="{{Auth::user()->member_id}}"
                          readonly><br>
                        <button type="submit" class="btn btn-primary ">
                          <h4>ยืนยัน</h4>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Large modal -->
          <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-link">
            <h3><i class='bx bx-link-alt'></i></h3>
          </button>
          <div class="modal fade bd-example-link" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog link">
              <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                  <h3>แนบลิงค์ภายนอก</h3>
                </div>
                <div class="card-body text-dark">
                  <div class="container">
                    <div class="form-register">
                      <form action="{{route('link.Gdrive.store')}}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}"
                          readonly>
                        ชื่อเรื่อง :
                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                        คำอธิบาย :
                        <textarea name="description" rows="3" class="form-control"
                          placeholder="ป้อนคำอธิบาย..."></textarea>
                        แนบลิงค์ :
                        <input type="text" class="form-control" name="link" placeholder="เพิ่มลิงค์..." required>
                        <input type="hidden" class="form-control" name="owner" value="{{Auth::user()->member_id}}"
                          readonly><br>
                        <button type="submit" class="btn btn-primary ">
                          <h4>ยืนยัน</h4>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Large modal -->
          <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-upload-video">
            <h3><i class='bx bxs-video-plus'></i></h3>
          </button>
          <div class="modal fade bd-example-upload-video" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog upload-video">
              <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                  <h3>อัพโหลดวิดีโอ</h3>
                </div>
                <div class="card-body text-dark">
                  <div class="container">
                    <div class="form-register">
                      <form action="{{route('video.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}"
                          readonly>
                        ชื่อเรื่อง :
                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                        คำอธิบาย :
                        <textarea name="description" rows="3" class="form-control"
                          placeholder="ป้อนคำอธิบาย..."></textarea>
                        อัพโหลดวิดีโอ :
                        <input type="file" class="form-control" name="file" required>
                        <input type="hidden" class="form-control" name="owner" value="{{Auth::user()->member_id}}"
                          readonly><br>
                        <button type="submit" class="btn btn-primary ">
                          <h4>ยืนยัน</h4>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Large modal -->
          <button type="button" class="btn btn-light mx-1" data-toggle="modal" data-target=".bd-example-upload-image">
            <h3><i class='bx bxs-image-add'></i></i></h3>
          </button>
          <div class="modal fade bd-example-upload-image" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog upload-image">
              <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                  <h3>อัพโหลดรูปภาพ</h3>
                </div>
                <div class="card-body text-dark">
                  <div class="container">
                    <div class="form-register">
                      <form action="{{route('image.store')}}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}"
                          readonly>
                        ชื่อเรื่อง :
                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                        คำอธิบาย :
                        <textarea name="description" rows="3" class="form-control"
                          placeholder="ป้อนคำอธิบาย..."></textarea>
                        อัพโหลดรูปภาพ :
                        <input type="file" class="form-control" name="file" required>
                        <input type="hidden" class="form-control" name="owner" value="{{Auth::user()->member_id}}"
                          readonly><br>
                        <button type="submit" class="btn btn-primary ">
                          <h4>ยืนยัน</h4>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Large modal -->
          <button type="button" class="btn btn-light mx-1" data-toggle="modal"
            data-target=".bd-example-upload-document">
            <h3><i class='bx bxs-file icon'></i></h3>
          </button>
          <div class="modal fade bd-example-upload-document" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog upload-document">
              <div class="modal-content">
                <div class="col-md-12 bg-primary pt-2 text-white">
                  <h3>อัพโหลดเอกสาร</h3>
                </div>
                <div class="card-body text-dark">
                  <div class="container">
                    <div class="form-register">
                      <form action="{{route('document.store')}}" class="form" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="lesson_id" value="{{$lesson->lesson_id}}"
                          readonly>
                        ชื่อเรื่อง :
                        <input type="text" class="form-control" name="name" placeholder="ป้อนชื่อเรื่อง..." required>
                        คำอธิบาย :
                        <textarea name="description" rows="3" class="form-control"
                          placeholder="ป้อนคำอธิบาย..."></textarea>
                        อัพโหลดเอกสาร :
                        <input type="file" class="form-control" name="file" required>
                        <input type="hidden" class="form-control" name="owner" value="{{Auth::user()->member_id}}"
                          readonly><br>
                        <button type="submit" class="btn btn-primary ">
                          <h4>ยืนยัน</h4>
                        </button>
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
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              <h5>{{ session('status') }}</h5>
          </div>
      @endif
    <h4> <b>เนื้อหาสรุปบทเรียน :</b></h4>
    <h5>{{$lesson->lesson_detail}}</h5>
    <hr>
    {{--------------------------------------------------------LINK YOUTUBE----------------------------------------------------------------}}
    @if ( $edit_link_y != null)
    {{--ส่วนวิดีโอยูทูป--}}
        <form action="{{ route('link.youtube.update',$lesson->lesson_id)}}" class="form" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          @csrf
    <div class="row">
          <div class="col-md-6"><br>
            <input type="hidden" class="form-control" name="lesson_id" value="{{$edit_link_y->lesson_id}}" >
            <input type="hidden" class="form-control" name="id" value="{{$edit_link_y->id}}" >
            <input type="hidden" class="form-control" name="owner" value="{{$edit_link_y->owner}}" >
            <input type="text" class="form-control" name="name" value="{{$edit_link_y->name}}" >
            <textarea class="form-control" name="description" cols="10" rows="3" >{{$edit_link_y->description}}</textarea>
            <div class="video">
              <x-embed url="{{$edit_link_y->link}}" />
            </div>
            <input type="text" class="form-control" name="link" value="{{$edit_link_y->link}}" >
          </div>
            <div class="col-md-5"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-warning text-white"> <h5>อัพเดท</i></h5> </button>
          </div>
      </div>
        </form>
      <hr>
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
        <img src="/storage/lesson/image_assets/{{$row->file}}" width="600px" height="400px">
      </div>
      <div class="col-md-1">
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse
    {{--------------------------------------------------------LINK Gdrive----------------------------------------------------------------}}
    @elseif ( $edit_link_Gdrive != null)
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse
    {{--ส่วนลิงค์ภายนอก--}}
        <form action="{{ route('link.Gdrive.update',$lesson->lesson_id)}}" class="form" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          @csrf
    <div class="row">
          <div class="col-md-6"><br>
            <input type="hidden" class="form-control" name="lesson_id" value="{{$edit_link_Gdrive->lesson_id}}" >
            <input type="hidden" class="form-control" name="id" value="{{$edit_link_Gdrive->id}}" >
            <input type="hidden" class="form-control" name="owner" value="{{$edit_link_Gdrive->owner}}" >
            <input type="text" class="form-control" name="name" value="{{$edit_link_Gdrive->name}}" >
            <textarea class="form-control" name="description" cols="10" rows="3" >{{$edit_link_Gdrive->description}}</textarea>
            <a href="{{$edit_link_Gdrive->link}}" target="_blank">
              <button class="btn btn-primary">
                <h5><i class='bx bx-link-alt'></i>{{$edit_link_Gdrive->name}}</h5>
              </button>
            </a>
            <input type="text" class="form-control" name="link" value="{{$edit_link_Gdrive->link}}" >
          </div>
            <div class="col-md-5"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-warning text-white"> <h5>อัพเดท</i></h5> </button>
          </div>
      </div>
        </form>
      <hr>
    {{--ส่วนรูปภาพ--}}
    @forelse($image as $row)
    <div class="row">
      <div class="col-md-11"><br>
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <img src="/storage/lesson/image_assets/{{$row->file}}" width="600px" height="400px">
      </div>
      <div class="col-md-1">
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse
    {{--------------------------------------------------------DOCUMENT----------------------------------------------------------------}}
    @elseif ( $edit_document != null)
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse
    {{--ส่วนเอกสาร--}}
        <form action="{{ route('document.update',$lesson->lesson_id)}}" class="form" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          @csrf
    <div class="row">
          <div class="col-md-6"><br>
            <input type="hidden" class="form-control" name="lesson_id" value="{{$edit_document->lesson_id}}" >
            <input type="hidden" class="form-control" name="id" value="{{$edit_document->id}}" >
            <input type="hidden" class="form-control" name="owner" value="{{$edit_document->owner}}" >
            <input type="text" class="form-control" name="name" value="{{$edit_document->name}}" >
            <textarea class="form-control" name="description" cols="10" rows="3" >{{$edit_document->description}}</textarea>
            <a href="/storage/lesson/document_assets/{{$edit_document->file}}" target="_blank">
                <button class="btn btn-primary">
                    <h5><i class='bx bxs-file icon'></i>{{$edit_document->file}}</h5>
                </button>
            </a>
            <input type="file" class="form-control" name="link"  >
          </div>
            <div class="col-md-5"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-warning text-white"> <h5>อัพเดท</i></h5> </button>
          </div>
      </div>
        </form>
      <hr>
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
        <img src="/storage/lesson/image_assets/{{$row->file}}" width="600px" height="400px">
      </div>
      <div class="col-md-1">
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse

    {{--------------------------------------------------------IMAGE----------------------------------------------------------------}}
    @elseif ( $edit_image != null)
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse
    {{--ส่วนรูปภาพ--}}
        <form action="{{ route('image.update',$lesson->lesson_id)}}" class="form" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          @csrf
    <div class="row">
          <div class="col-md-6"><br>
            <input type="hidden" class="form-control" name="lesson_id" value="{{$edit_image->lesson_id}}" >
            <input type="hidden" class="form-control" name="id" value="{{$edit_image->id}}" >
            <input type="hidden" class="form-control" name="owner" value="{{$edit_image->owner}}" >
            <input type="text" class="form-control" name="name" value="{{$edit_image->name}}" >
            <textarea class="form-control" name="description" cols="10" rows="3" >{{$edit_image->description}}</textarea>
            <img src="/storage/lesson/image_assets/{{$edit_image->file}}"width="600px" height="400px">
            <input type="file" class="form-control" name="link"  >
          </div>
            <div class="col-md-5"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-warning text-white"> <h5>อัพเดท</i></h5> </button>
          </div>
      </div>
        </form>
      <hr>
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
      </div>
    </div>
    <hr>
    @empty
    @endforelse

    {{--------------------------------------------------------VIDEO----------------------------------------------------------------}}
    @elseif ( $edit_video != null)
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
            </div>
        </div>
        <hr>
        @empty
        @endforelse
    {{--ส่วนวิดีโอ--}}
        <form action="{{ route('video.update',$lesson->lesson_id)}}" class="form" method="POST"
          enctype="multipart/form-data">
          {{ csrf_field()}}
          {{ method_field('PUT') }}
          @csrf
    <div class="row">
          <div class="col-md-6"><br>
            <input type="hidden" class="form-control" name="lesson_id" value="{{$edit_video->lesson_id}}" >
            <input type="hidden" class="form-control" name="id" value="{{$edit_video->id}}" >
            <input type="hidden" class="form-control" name="owner" value="{{$edit_video->owner}}" >
            <input type="text" class="form-control" name="name" value="{{$edit_video->name}}" >
            <textarea class="form-control" name="description" cols="10" rows="3" >{{$edit_video->description}}</textarea>
            <video width="600" height="400" controls>
                <source src="/storage/lesson/video_assets/{{$row->file}}">
            </video>
            <input type="file" class="form-control" name="link"  >
          </div>
            <div class="col-md-5"></div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-warning text-white"> <h5>อัพเดท</i></h5> </button>
          </div>
      </div>
        </form>
      <hr>
    @else
    <h3>มีปัญหาครับท่าน</h3>
    @endif
  </div>
</div>
@endsection