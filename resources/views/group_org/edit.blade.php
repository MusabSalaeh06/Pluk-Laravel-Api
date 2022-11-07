@extends('/layouts/org_sidebar')

@section('content')
<link rel="stylesheet" href="{{ asset('jquery.Thailand.js/dist/jquery.Thailand.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/jquery-3.6.0.min.js') }} ">
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ตั้งค่าองค์กร
        </h3>
    </div>
    <form action="{{ route('group_org.update',$data->org_id)}}" method="POST" enctype="multipart/form-data" id="kt_form" >
        <div class="card-body">
            <div class="form-register">
                {{ csrf_field()}}
                {{ method_field('PUT') }}
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            ชื่อองค์กร 
                            <input type="text" class="form-control" name="org_name" value="{{$data->org_name}}"
                             placeholder="..." required>
                        </div>
                        <div class="col-md-4">
                            เบอร์โทรศัพท์องค์กร 
                            <input type="text" class="form-control" name="org_tel" value="{{$data->org_tel}}"
                            placeholder="..." required>
                        </div>
                        <div class="col-md-4">
                            คำอธิบาย 
                            <textarea class="form-control" name="description" rows="2">{{$data->description}}</textarea>
                        </div>
                        <div class="col-md-4">
                            เขต
                            <input type="text" class="form-control" name="county" value="{{$data->county}}"
                                placeholder="...">
                        </div>
                        <div class="col-md-4">
                            ถนน
                            <input type="text" class="form-control" name="road" value="{{$data->road}}"
                                placeholder="...">
                        </div>
                        <div class="col-md-4">
                            ตรอก/ซอย
                            <input type="text" class="form-control" name="alley" value="{{$data->alley}}"
                                placeholder="...">
                        </div>
                        <div class="col-md-4">
                            บ้านเลขที่
                            <input type="text" class="form-control" name="house_number" value="{{$data->house_number}}"
                                placeholder="...">
                        </div>
                        <div class="col-md-4">
                            หมู่ที่
                            <input type="text" class="form-control" name="group_no" value="{{$data->group_no}}"
                                placeholder="...">
                        </div>
                        <div class="col-md-4">
                            ตำบล
                            <input type="text" class="form-control" name="sub_district" value="{{$data->sub_district}}"
                                required>
                        </div>
                        <div class="col-md-4">
                            อำเภอ
                            <input type="text" class="form-control" name="district" value="{{$data->district}}"
                                required>
                        </div>
                        <div class="col-md-4">
                            จังหวัด 
                            <input type="text" class="form-control" name="province" value="{{$data->province}}"
                                required>
                        </div>
                        <div class="col-md-4">
                            รหัสไปรษณีย์
                            <input type="text" class="form-control" name="ZIP_code" value="{{$data->ZIP_code}}"
                                required>
                        </div>
                        <div class="col-md-4">
                            ใบรับรองการก่อตั้งองค์กร ( *แนบไฟล์ PDF) 
                            <input type="file" class="form-control" name="book_cer" >
                        </div>
                        <div class="col-md-4">
                            ผู้ก่อตั้ง 
                            <select class="form-control" name="org_owner" readonly>
                                <option value="{{Auth::user()->member_id}}">{{Auth::user()->name}}
                                    {{Auth::user()->surname}}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-3">
                            <center><button type="submit" class="btn btn-success ">
                                <h4>อัพเดต</h4>
                                </button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    <script type="text/javascript" src="{{ asset('jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jquery.Thailand.js/dependencies/JQL.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jquery.Thailand.js/dependencies/typeahead.bundle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jquery.Thailand.js/dist/jquery.Thailand.min.js') }}"></script>
    <script type="text/javascript">
    /******************\
            *     DEMO 1     *
            \******************/
            // demo 1: load database from json. if your server is support gzip. we recommended to use this rather than zip.
            // for more info check README.md

            $.Thailand({
            database: '{{ asset('jquery.Thailand.js/database/db.json') }}',
            $district: $('#kt_form [name="sub_district"]'),
            $amphoe: $('#kt_form [name="district"]'),
            $province: $('#kt_form [name="province"]'),
            $zipcode: $('#kt_form [name="ZIP_code"]'),

            onDataFill: function (data) {
                console.info('Data Filled', data);
        },

            onLoad: function () {
                console.info('Autocomplete is ready!');
            $('#loader, .demo').toggle();
        }
    });

            // watch on change
            $('#kt_form [name="sub_district"]').change(function () {
                console.log('ตำบล', this.value);
    });
            $('#kt_form [name="district"]').change(function () {
                console.log('อำเภอ', this.value);
    });
            $('#kt_form [name="province"]').change(function () {
                console.log('จังหวัด', this.value);
    });
            $('#kt_form [name="ZIP_code"]').change(function () {
                console.log('รหัสไปรษณีย์', this.value);
    });
</script>
@endsection