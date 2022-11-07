@extends('../layout')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="/testvdoc_create"><h4><i class="fa fa-square"></i>เพิ่ม</h4></a>
            @foreach ($testvdoc as $row)
            <div class="card m-2">
                <div class="col-md-12 bg-warning py-1">
                    <h3><b>บทที่ : {{$row->id}}</b> {{$row->title}}</h3>
                </div>
                    <div class="row p-2 ">
                            <div class="col-md-12">
                                <h4> <b> คำอธิบาย </b> : {{$row->description}}</h4>
                                @if ($row->document == null)
                                @else 
                                <h4><b> ช่องสำหรับเอกสาร : </b> </h4>
                                <a href="{{ asset('storage/testvdoc/document_assets/'.$row->document) }}" target="_blank">
                                <button class="button3 btn-lg">
                                <h5>{{$row->document}}</h5>
                                </button>
                                </a>
                                @endif
                            </div>

                            @if ($row->up_image == null)
                                @else
                                <div class="col-md-3">
                                <h4><b> รูปภาพ : </b> </h4>
                                <img src="{{ asset('storage/testvdoc/image_assets/'.$row->up_image) }}" height="200px" width="300px"> <br> <br>
                                </div>
                            @endif

                            @if ($row->up_video == null)
                                @else
                                <div class="col-md-3">
                                <h4><b> วิดีโอที่อัพโหลด : </b> </h4> 
                                <video width="300" height="200" controls >
                                <source src="{{ asset('storage/testvdoc/video_assets/'.$row->up_video) }}">
                                </video>
                                </div>
                            @endif

                            @if ($row->link_y == null)
                                @else
                                <div class="col-md-3">
                                <h4><b> ลิงค์จากยูทูป : </b> </h4>
                                <div class="video" >
                                <x-embed url="{{$row->link_y}}" />
                                </div>
                                </div>
                            @endif

                            @if ($row->link_g == null)
                                @else
                                <div class="col-md-3">
                                <h4><b> ลิงค์จาก Google Drive : </b> </h4>
                                <div class="video" >
                                <iframe src="{{$row->link_g}}" ></iframe>
                                </div>
                                </div>
                            @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
@endsection