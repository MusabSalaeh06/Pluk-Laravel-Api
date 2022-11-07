<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>PLUK</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="eCommerce HTML Template Free Download" name="keywords">
    <meta content="eCommerce HTML Template Free Download" name="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap"
        rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/slick/slick.css" rel="stylesheet">
    <link href="lib/slick/slick-theme.css" rel="stylesheet">
    <link href="lib/slick/register.scss" rel="stylesheet">
    <x-embed-styles />
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('js/owl.carousel.min.js') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<style>
     body {
            font-family: "TH SarabunPSK";
        }
        div .form-register {
            font-size: 20px;
        }

        div .form-control {
            font-size: 18px;
        }
        div .mg-top {
            margin-top: 5%;
            margin-left: 40%;
            margin-right: 40%;
        }

        h3 {
            font-size: 28px;
        }

        h4 {
            font-size: 23px;
        }

        h5 {
            font-size: 21px;
        }
        tab0 { padding-right: 120em; }
        ::placeholder {
            font-family: "TH SarabunPSK";
            font-size: 20px;
        }

        [value] {
            font-family: "TH SarabunPSK";
            font-size: 20px;
        }

        [type] {
            font-family: "TH SarabunPSK";
            font-size: 20px;
        }
</style>

<body>
<div class="row">
    <ul class="nav shadow-sm py-2">
        <tab0> 
        <li class="nav-item pl-5 ">
            <h3> <b>PLUK</b> </h3>
        </li>
        </tab0>
        {{--
            <li class="nav-item ">
                <a class="nav-link" href="/index"><h4>หน้าแรก</h4></a>
            </li>
            --}}
        <li class="nav-item pl-3">
            <a class="nav-link text-dark" href="/login"> <h4>เข้าสู่ระบบ</h4></a>
        </li>
        <li class="nav-item pl-3 pr-5">
            <a class="nav-link text-dark" href="/register"><h4>สมัครสมาชิก</h4></a>
        </li>
      </ul>
        
        <div class="mg-top">
        <div class="card bg-white shadow-sm">
                {{----}}
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            <h5>{{ session('error') }}</h5>
        </div>
        @endif
            <div class="card-body">
        <div class="row p-5">
            <div class="col-md-12">
                    <h3><b>สมัครบัญชีผู้ใช้ใหม่</b></h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                <div class="form-register">
                            <div class="row">
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-user-detail'></i> ชื่อ 
                                <input type="text" name="name" class="form-control" placeholder="ป้อนชื่อ..." required/>
                            </div>
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-user-detail'></i> นามสกุล 
                                <input type="text" name="surname" class="form-control" placeholder="ป้อนนามสกุล..." required/>
                            </div>
                                {{--
                            <div class="col-md-6 mt-1">
                                <i class='bx bx-male-sign' ></i> เพศ 
                                <select class="form-control" name="gender" required>
                                    <option>เลือกเพศ...</option>
                                    <option value="ชาย">ชาย</option>
                                    <option value="หญิง">หญิง</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-1">
                                <i class='bx bxs-calendar' ></i> วันเกิด 
                                <input type="date" name="birth_day" class="form-control" required/>
                            </div>
                            <div class="col-md-6 mt-1">
                                <i class='bx bxs-phone' ></i> เบอร์โทรศัพท์ 
                                <input type="text" name="tel" class="form-control" placeholder="ป้อนเบอร์โทรศัพท์..." required/>
                            </div>
                            --}}
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-envelope' ></i> อีเมล 
                                <input type="email" name="email" class="form-control" placeholder="ป้อนอีเมล..." required/>
                            </div>
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-lock-alt' ></i> รหัสผ่าน (กรุณาป้อน 8 ตัวขึ้นไป)
                                <input type="password" name="password" class="form-control" placeholder="ป้อนรหัสผ่าน..." required/>
                            </div>
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-lock-alt' ></i> ยืนยันรหัสผ่าน 
                                <input type="password" name="password_confirmation" class="form-control" placeholder="ป้อนรหัสผ่าน..." required/>
                            </div>
                            <div class="col-md-12 mt-3">
                            <center><button type="submit" class="btn btn-sm btn-primary "><h4>สมัครสมาชิก</h4></button></center>
                        </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</body>
</html>