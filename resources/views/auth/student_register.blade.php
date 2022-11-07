@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
    <div class="card">
        <div class="form-register">
        <div class="card-header">{{ __('ระบบสมัครสำหรับนักเรียน') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
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
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อโรงเรียนที่สังกัด') }}</label>
                    <div class="col-md-6">
                        <select class="form-control" name="manager_id" type="text" >
                            <option value=""></option>
                            @foreach ($manager as $row)
                            <option value="{{$row->manager_id}}">{{$row->school_name}}</option>
                            @endforeach
                        </select>
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
@endsection
