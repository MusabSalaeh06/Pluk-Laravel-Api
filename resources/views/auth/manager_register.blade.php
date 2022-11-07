<link rel="stylesheet" href="{{ asset('jquery.Thailand.js/dist/jquery.Thailand.min.css') }}">
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
    <div class="card">
        <div class="form-register">
    <div class="card-header">{{ __('ระบบสมัครสำหรับผู้บริหาร') }}</div>
    <div class="card-body">
        <form method="POST" id="kt_form" action="{{ route('register') }}">
            @csrf       
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ประเภทผู้ใช้') }}</label>
                <div class="col-md-6">
                    <select class="form-control" name="user_status_id" readonly>
                        @foreach ($user_status as $row)
                        <option value="3">{{$row->user_status_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('อีเมล') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อ') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('นามสกุล') }}</label>
                <div class="col-md-6">
                    <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('เพศ') }}</label>
                <div class="col-md-6">
                    <select class="form-control" name="gender" type="text" >
                        <option value=""></option>
                        <option value="ชาย">ชาย</option>
                        <option value="หญิง">หญิง</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="tell" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทรศัพท์') }}</label>
                <div class="col-md-6">
                    <input id="tell" type="text" class="form-control " name="tell" value="{{ old('tell') }}" required autocomplete="tell" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="school_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อโรงเรียนที่สังกัดอยู่ ณ ปัจจุบัน') }}</label>
                <div class="col-md-6">
                    <input id="school_name" type="text" class="form-control " name="school_name" value="{{ old('school_name') }}" required autocomplete="school_name" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="school_Detail" class="col-md-4 col-form-label text-md-right">{{ __('คำอธิบายโรงเรียน') }}</label>
                <div class="col-md-6">
                    <textarea id="school_Detail" rows="5" cols="5" class="form-control" name="school_Detail" value="{{ old('school_Detail') }}" required autocomplete="school_Detail" autofocus></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_hn" class="col-md-4 col-form-label text-md-right">{{ __('บ้านเลขที่') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_hn"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_m" class="col-md-4 col-form-label text-md-right">{{ __('หมู่ที่') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_m"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_t" class="col-md-4 col-form-label text-md-right">{{ __('ตำบล') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_t"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_a" class="col-md-4 col-form-label text-md-right">{{ __('อำเภอ') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_a"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_j" class="col-md-4 col-form-label text-md-right">{{ __('จังหวัด') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_j"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="Address_p" class="col-md-4 col-form-label text-md-right">{{ __('รหัสไปรษณีย์') }}</label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="Address_p"  required>
                </div>
            </div>
            <div class="form-group row">
                <label for="school_tell" class="col-md-4 col-form-label text-md-right">{{ __('เบอร์โทรศัพท์โรงเรียน') }}</label>
                <div class="col-md-6">
                    <input id="school_tell" type="text" class="form-control " name="school_tell" value="{{ old('school_tell') }}" required autocomplete="school_tell" autofocus>
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        <h5>{{ __('สมัคร') }}</h5>
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
        </div>
    </div>
</div>
<!-- dependencies for zip mode -->
<script type="text/javascript" src="{{ asset('jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
<!-- / dependencies for zip mode -->

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


       $district: $('#kt_form [name="Address_t"]'),
       $amphoe: $('#kt_form [name="Address_a"]'),
       $province: $('#kt_form [name="Address_j"]'),
       $zipcode: $('#kt_form [name="Address_p"]'),

       onDataFill: function (data) {
           console.info('Data Filled', data);
       },

       onLoad: function () {
           console.info('Autocomplete is ready!');
           $('#loader, .demo').toggle();
       }
   });

   // watch on change
   $('#kt_form [name="Address_t"]').change(function () {
       console.log('ตำบล', this.value);
   });
   $('#kt_form [name="Address_a"]').change(function () {
       console.log('อำเภอ', this.value);
   });
   $('#kt_form [name="Address_j"]').change(function () {
       console.log('จังหวัด', this.value);
   });
   $('#kt_form [name="Address_p"]').change(function () {
            console.log('รหัสไปรษณีย์', this.value);
        });
</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".selectt").not(targetBox).hide();
            $(targetBox).show();
        });
    });
</script>
@endsection
