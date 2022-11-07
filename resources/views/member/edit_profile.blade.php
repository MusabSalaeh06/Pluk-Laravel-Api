@extends('/layouts/default')

@section('content')
<link rel="stylesheet" href="{{ asset('jquery.Thailand.js/dist/jquery.Thailand.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/jquery-3.6.0.min.js') }} ">
<div class="card shadow-sm">
    <div class="col-md-12 bg-primary py-1 text-white">
        <h3>
            <a href="javascript:history.back()" class="text-white"><i class='bx bxs-left-arrow-square' ></i></a>
            ตั้งค่าข้อมูลส่วนตัว
        </h3>
    </div>
    <div class="card-body">
        <div class="form-register">
            <form action="{{ route('profile.update',$data->member_id)}}" id="kt_form" class="form" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field()}}
                {{ method_field('PUT') }}
                @csrf
                <div class="col-md-12 bg-secondary py-1 text-white">
                    <h3>
                        ข้อมูลส่วนตัว
                    </h3>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                ชื่อ
                                <input type="text" class="form-control" name="name" value="{{$data->name}}"
                                    placeholder="ป้อนชื่อ..." >
                            </div>
                            <div class="col-md-4">
                                นามสกุล
                                <input type="text" class="form-control" name="surname" value="{{$data->surname}}"
                                    placeholder="ป้อนนามสกุล..." >
                            </div>
                            <div class="col-md-4">
                                เพศ
                                <select class="form-control" name="gender" type="text">
                                    <option value="{{$data->gender}}">เลือกเพศ..</option>
                                    <option value="ชาย">ชาย</option>
                                    <option value="หญิง">หญิง</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                เบอร์โทรศัพท์
                                <input type="text" class="form-control" name="tel" value="{{$data->tel}}" 
                                placeholder="ป้อนเบอร์โทรศัพท์..." >
                            </div>
                            <div class="col-md-4">
                                เลขบัตรประจำตัวประชาชน
                                <input type="text" class="form-control" name="card_id" value="{{$data->card_id}}"
                                    placeholder="ป้อนเลขบัตรประจำตัวประชาชน...">
                            </div>
                            <div class="col-md-4">
                                วันเกิด
                                <input type="date" class="form-control" name="birth_day" value="{{$data->birth_day}}" >
                            </div>
                            <div class="col-md-4">
                                อีเมล
                                <input type="text" class="form-control" name="email" value="{{$data->email}}"
                                    placeholder="รหัสคอร์สเรียน.." required>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <br>
                <div class="col-md-12 bg-secondary py-1 text-white">
                    <h3>
                        ข้อมูลที่อยู่
                    </h3>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            เขต
                            <input type="text" class="form-control" name="county" value="{{$data->county}}"
                                placeholder="ป้อนชื่อเขต...">
                        </div>
                        <div class="col-md-4">
                            ถนน
                            <input type="text" class="form-control" name="road" value="{{$data->road}}"
                                placeholder="ป้อนชื่อถนน...">
                        </div>
                        <div class="col-md-4">
                            ตรอก/ซอย
                            <input type="text" class="form-control" name="alley" value="{{$data->alley}}"
                                placeholder="ป้อนชื่อตรอก/ซอย...">
                        </div>
                        <div class="col-md-4">
                            บ้านเลขที่
                            <input type="text" class="form-control" name="house_number" value="{{$data->house_number}}"
                                placeholder="ป้อนบ้านเลขที่...">
                        </div>
                        <div class="col-md-4">
                            หมู่ที่
                            <input type="text" class="form-control" name="group_no" value="{{$data->group_no}}"
                                placeholder="ป้อนหมายเลขหมู่ที่...">
                        </div>
                        <div class="col-md-4">
                            ตำบล
                            <input type="text" class="form-control" name="sub_district" value="{{$data->sub_district}}"
                            placeholder="ป้อนตำบล..." >
                        </div>
                        <div class="col-md-4">
                            อำเภอ
                            <input type="text" class="form-control" name="district" value="{{$data->district}}"
                            placeholder="ป้อนอำเภอ..." >
                        </div>
                        <div class="col-md-4">
                            จังหวัด :
                            <input type="text" class="form-control" name="province" value="{{$data->province}}"
                            placeholder="ป้อนจังหวัด" >
                        </div>
                        <div class="col-md-4">
                            รหัสไปรษณีย์
                            <input type="text" class="form-control" name="ZIP_code" value="{{$data->ZIP_code}}"
                            placeholder="ป้อนรหัสไปรษณีย์" >
                        </div>
                        <div class="col-md-4">
                            รูปโปรไฟล์
                            <input type="file" class="form-control" name="profile">
                        </div>
                    </div>
                </div>
            </div>
                </div> 
                <div class="col-md-12 mt-3">
                    <center><button type="submit" class="btn btn-success ">
                            <h4>อัพเดต</h4>
                        </button></center>
                </div>
            </form>
        </div>
    </div>
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