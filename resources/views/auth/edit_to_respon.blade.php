<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Smart E-learning</title>
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
            margin-left: 35%;
            margin-right: 35%;
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
        tab0 { padding-right: 113.5em; }
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
        @include('layouts.css.topnav')
<body>
    <div class="topnav" id="myTopnav">
    <a href="#home" class="active">Home</a>
    <a href="#news">News</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
    <a href="#about">About</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
  </div>
<div class="row">
        <div class="mg-top">
        <div class="card bg-white shadow-sm">
            {{----}}
            @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h3> {{ session()->get('error') }} </h3>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            <div class="card-body">
        <div class="row p-5">
            <div class="col-md-6">
                <figure><img src="images/signin-image.jpg"></figure>
             </div>
            <div class="col-md-6">
                    <h3><b>เข้าสู่ระบบ</b></h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                <div class="form-register">
                            <div class="row">
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-envelope' ></i> อีเมล 
                                <input type="email" name="email" class="form-control" required/>
                            </div>
                            <div class="col-md-12 mt-1">
                                <i class='bx bxs-lock-alt' ></i> รหัสผ่าน 
                                <input type="password" name="password" class="form-control" required/>
                            </div>
                            <div class="col-md-12 mt-3">
                            <center><button type="submit" class="btn btn-md btn-primary "><h4>เข้าสู่ระบบ</h4></button></center>
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
@include('layouts.script.mytopnav')
</body>
</html>