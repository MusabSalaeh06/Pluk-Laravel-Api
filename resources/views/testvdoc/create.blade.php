@extends('../layout')
@section('content')
<div class="card">
    <div class="card-body">
    <form action="{{route('testvdoc.store')}}" class="form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <div class="sect1">
                <input type="text" class="form-control" name="title" placeholder="Title.."> <br>
                <input type="text" class="form-control" name="link_y" placeholder="link video youtube.."> <br>
                <input type="text" class="form-control" name="link_g" placeholder="link video google drive.."> <br>
                <textarea name="description" class="form-control" placeholder="Description.."></textarea>
            </div>
            <div class="dropz" id="image-upload">
                <h2>Upload image</h2>
                <input type="file" class="form-control" name="up_image">
            </div>
            <div class="dropz" id="video-upload">
                <h2>Upload video</h2>
                <input type="file" class="form-control" name="up_video">
            </div>
            <div class="dropz" id="document-upload">
                <h2>Upload Document</h2>
                <input type="file" class="form-control" name="document">
            </div>
        </div>
        <center><button type="submit" class="btn btn-bg-danger ">Create film</button></center>
    </form>
</div>
</div>
@endsection