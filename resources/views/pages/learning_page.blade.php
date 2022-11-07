@extends('/layouts/learn_page_sidebar')
@section('content')
{{--ข้อมูลรายวิชา--}}
{{--ข้อมูลบทเรียน--}}
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <div class="row mx-1">
            <h3>
                <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
               รายวิชา - {{$data->course_id}} - {{$data->course_name}} -  {{$lesson->lesson_name}}
            </h3>
        </div>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <h5>{{ session('status') }}</h5>
        </div>
    @endif
    <div class="card-body">
        <h4>เนื้อหาสรุปบทเรียน :</h4>
        <h5>{{$lesson->lesson_detail}}</h5>
        <hr>
        {{--ส่วนวิดีโอยูทูป--}}
        @forelse($link_y as $row)
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <div class="video">
            <x-embed url="{{$row->link}}" />
        </div> 
        <hr>
        @empty
        @endforelse
        {{--ส่วนเอกสาร--}}
            @forelse($document as $row)
            <h4><b> {{$row->name}}</b></h4>
            <h4>{{$row->description}}</h4>
            <a href="/storage/lesson/document_assets/{{$row->file}}" target="_blank">
                <button class="btn btn-primary">
                    <h5><i class='bx bxs-file icon'></i>{{$row->file}}</h5>
                </button>
            </a>
            <hr>
            @empty
            @endforelse
        {{--ส่วนลิงค์ภายนอก--}}
        @forelse($link_g as $row)
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <a href="{{$row->link}}" target="_blank">
            <button class="btn btn-primary">
                <h5><i class='bx bx-link-alt'></i>{{$row->name}}</h5>
            </button>
        </a>
        <hr>
        @empty
        @endforelse
        {{--ส่วนรูปภาพ--}}
        @forelse($image as $row)
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <img src="/storage/lesson/image_assets/{{$row->file}}"width="600px" height="400px">
        <hr>
        @empty
        @endforelse
        {{--ส่วนวิดีโอ--}}
        @forelse($video as $row)
        <h4><b> {{$row->name}}</b></h4>
        <h4>{{$row->description}}</h4>
        <video width="600" height="400" controls>
            <source src="/storage/lesson/video_assets/{{$row->file}}">
        </video>
        <hr>
        @empty
        @endforelse
        @forelse ( $note as $row)
        <div class="card shadow-sm my-3">
            <div class="col-md-12 bg-primary py-1 text-white">
                <div class="row mx-1 pt-1">
                    <h4><b>บันทึกย่อ</b></h4>
                    <div class="ml-auto">
                        <button class="btn btn-light">
                            <h5>สถานะ : ส่งเเล้ว</h5>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-register">
                    <form action="{{route('note.update',$row->id)}}" class="form-group" method="post">
                        @csrf
                        <textarea name="note" cols="10" rows="5" class="form-control">{{$row->note}}</textarea><br>
                        <div class="row mx-1">
                            <div class="ml-auto">
                                <button type="submit" class="btn btn-success">
                                    <h5>แก้ไข</h5>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card shadow-sm my-3">
            <div class="col-md-12 bg-primary py-1 text-white">
                <div class="row mx-1 pt-1">
                    <h4><b>บันทึกย่อ</b></h4>
                    <div class="ml-auto">
                        <button class="btn btn-light">
                            <h5>สถานะ : ยังไม่ส่ง</h5>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('note.store')}}" class="form-group" method="post">
                    @csrf
                    @if ( $enroll_org == null)
                    @else
                    <input type="hidden" name="org_id" value="{{$enroll_org}}"> 
                    @endif
                    <input type="hidden" name="lesson_id" value="{{$lesson->lesson_id}}">
                    <input type="hidden" name="creator" value="{{Auth::user()->member_id}}">
                    <textarea name="note" cols="10" rows="5" class="form-control" placeholder="เพิ่มบันทึกย่อ..."></textarea><br>
                    <div class="row mx-1">
                        <div class="ml-auto">
                            <button type="submit" class="btn btn-success">
                                <h5>บันทึก</h5>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection