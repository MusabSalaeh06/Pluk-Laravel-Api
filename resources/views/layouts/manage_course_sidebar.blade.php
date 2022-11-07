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

    <!-- Styles -->
    <link href="{{ asset('../frontend/css/bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ asset('../frontend/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   
   <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
   <link rel="stylesheet" href="{{ asset('js/owl.carousel.min.js') }}">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
       
    <!-- สคริปการค้นหาข้อมูลในตาราง -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
    <script>  
        $(document).ready(function(){  
             $('#search').keyup(function(){  
                  search_table($(this).val());  
             });  
             function search_table(value){  
                  $('#employee_table tr').each(function(){  
                       var found = 'false';  
                       $(this).each(function(){  
                            if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
                            {  
                                 found = 'true';  
                            }  
                       });  
                       if(found == 'true')  
                       {  
                            $(this).show();  
                       }  
                       else  
                       {  
                            $(this).hide();  
                       }  
                  });  
             }  
        });  
   </script>

   
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


   <style>
        .button {
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .button3 {
            border-radius: 12px;
        }

        .button3 {
            background-color: white;
            color: black;
            border: 2px solid #f44336;
        }

        .button3:hover {
            background-color: #f44336;
            color: white;
        }

        div .video {
            height: 400px;
            width: 600px;
            overflow: hidden;
            position: relative;
            /* requires for to position video properly */
        }

        body {
            font-family: "TH SarabunPSK";
        }

        div .navbar {
            font-size: 20px;
        }

        div .naxxx {
            font-size: 20px;
        }

        div .form-register {
            font-size: 22px;
        }

        div .form-control {
            font-size: 20px;
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

        div .profile img {
            border-radius: 100%;
        }

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
</head>

<body>
 <!-- Bottom Bar Start -->
 <div class="card bg-white px-5 py-2 ">
    <div class="row">
        <div class="logo">
        <h3>
            <b>Pluk</b> 
        </h3>
        </div> 
        <div class="navbar-nav ml-auto">
            <div class="nav-item dropdown">
                <div class="profile border-dark">
                    <h5>
                        @if (Auth::user()->profile == null && Auth::user()->gender == 'ชาย')
                        <img src="/media/svg/avatars/001-boy.svg" height="25px" width="25px">
                        @elseif(Auth::user()->profile == null && Auth::user()->gender == 'หญิง')
                        <img src="/media/svg/avatars/002-girl.svg" height="25px" width="25px">
                        @elseif(Auth::user()->profile == null && Auth::user()->gender == null)
                        <img src="/images/no_image.png" height="25px" width="25px">
                        @else
                        <img src="{{ asset('storage/member/member_assets/'.Auth::user()->profile) }}" height="25px"width="25px">
                        @endif
                        @if ( Auth::user()->name == null )
                        {{ Auth::user()->email}}
                        @else
                        {{ Auth::user()->name}} {{Auth::user()->surname }}
                        @endif
                        @if ($data->course_owner == Auth::user()->member_id)
                            (ติวเตอร์)
                        @else
                            (นักศึกษา)
                        @endif
                        <a href="{{ route('profile') }}">
                            <button class="btn btn-primary" title="โปรไฟล์"><h5><i class='bx bxs-user-account icon'></i> </h5></button></a>
                        <a href="{{ route('logout') }}">
                            <button class="btn btn-primary" title="ออกจากระบบ"><h5><i class='bx bx-log-out icon'></i> </h5></button></a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="header">
    <div class="row">
        <div class="col-md-2">
            {{--
            @if ( Auth::user()->count_org == null )
            @else
            <div class="col-md-12 bg-primary py-1 mt-3 text-white">
                <h3>เมนูสำหรับผู้บริหาร</h3>
            </div>
            <div class="card shadow-sm">
                <ul class="navbar-nav px-3">
                    <li class="nav-item">
                        <div class="nav-item dropdown">
                            <a href="{{route('group_org.create')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-plus-circle'></i> เปิดองค์กร</h4>
                            </a>
                            <a href="{{route('pages.my_org')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-group icon'></i> องค์กรของฉัน</h4>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            @endif
            --}}
            @if ( Auth::user()->count_co == null )
            @else
            <div class="col-md-12 bg-primary py-1 mt-3 text-white">
                <h3>เมนูสำหรับแอดมิน</h3>
            </div>
            <div class="card shadow-sm">
                <ul class="navbar-nav px-3">
                    <li class="nav-item">
                        <div class="nav-item dropdown">
                            <a href="{{route('course_category.create')}}" class="nav-link dropdown ">
                                <h4> <i class='bx bxs-plus-circle'></i> เพิ่มหมวดหมู่รายวิชา</h4>
                            </a>
                            <a href="{{route('course_category.show')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-book'></i> หมวดหมู่รายวิชา</h4>
                            </a>
                            {{--
                            <a href="{{route('course.create')}}" class="nav-link dropdown ">
                                <h4> <i class='bx bxs-plus-circle'></i> เปิดรายวิชาการสอน</h4>
                            </a>
                            <a href="{{route('pages.my_opencourse')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-book'></i> รายวิชาที่ฉันเปิดสอน</h4>
                            </a>
                            <a href="/testvdoc_show" class="nav-link dropdown ">
                                <h4><i class="fa fa-square"></i>ทดสอบการป้อนบทเรียน</h4>
                            </a>
                            --}}
                        </div>
                    </li>
                </ul>
            </div>
            @endif
            <div class="col-md-12 bg-primary py-1 mt-3 text-white">
                <h3>เมนูพื้นฐาน</h3>
            </div>
            <div class="card shadow-sm">
                <ul class="navbar-nav px-3">
                    <li class="nav-item">
                        <div class="nav-item dropdown">
                            <a href="{{route('index')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-home' ></i> หน้าแรก</h4>
                            </a>
                            <a href="{{route('pages.my_org')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-group icon'></i> องค์กรของฉัน({{$co_my_org}})</h4>
                            </a>
                            <a href="{{route('pages.my_opencourse')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-book'></i> รายวิชาที่ฉันเปิดสอน({{$co_opc}})</h4>
                            </a>
                            <a href="{{route('pages.org_my_join')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-group'></i> องค์กรที่ฉันเข้าร่วม({{$co_org_myjoin}})</h4>
                            </a>
                            <a href="{{route('page.my_course')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-book'></i> รายวิชาที่ฉันลงทะเบียน({{$co_my_course}})</h4>
                            </a>
                            <a href="{{route('pages.respond_invite_org')}}" class="nav-link dropdown ">
                                <h4><i class='bx bxs-envelope' ></i> คำเชิญเข้าร่วมองค์กร({{$co_org_invite}})</h4>
                            </a>
                            <a href="{{route('pages.page_search')}}" class="nav-link dropdown ">
                                <h4><i class='bx bx-search' ></i> การค้นหา</h4>
                            </a>
                            {{--
                            <a href="{{route('group_org.show')}}" class="nav-link dropdown ">
                                <h4><i class='bx bx-search-alt-2'></i> ค้นหาองค์กร</h4>
                            </a>
                            <a href="{{route('course.course_show')}}" class="nav-link dropdown ">
                                <h4><i class='bx bx-search-alt-2'></i> ค้นหารายวิชา</h4>
                            </a>
                            --}}
                            <a href="#" class="nav-link dropdown ">
                                <h4><i class='bx bxs-file' ></i> ใบประกาศของฉัน</h4>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
            <div class="col-md-8">
                <div class="mt-3 bg-white">
                    @yield('content')
                </div>
            </div>
            <div class="col-md-2">
                <div class="card  mt-3 shadow-sm">
                    <div class="col-md-12 bg-primary text-white">
                        <h3>เมนูสำหรับรายวิชา</h3>
                    </div>
                    <ul class="navbar-nav px-3">
                        <li class="nav-item">
                            <div class="nav-item dropdown">
                                @if (Auth::user()->member_id == $data->course_owner)
                                <a href="{{route('pages.course_index',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-detail'></i> เกี่ยวกับรายวิชา</h4>
                                </a>
                                <a href="{{route('pages.manage_lesson',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-book'></i> จัดการบทเรียน ({{$lesson_count}}) </h4>
                                </a>
                                <a href="{{route('pages.person.enroll',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-user-detail'></i> รายชื่อผู้ลงทะเบียน ({{$Penroll_count}})</h4>
                                </a>
                                @if($data->course_type == 'สาธารณะ')
                                @else
                                <a href="{{route('pages.response.enroll',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-user'></i> คำขอลงทะเบียน ({{$Renroll_count}})</h4>
                                </a>
                                @endif
                                {{--
                                <a href="{{route('lesson.create',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-book-add' ></i> เพิ่มบทเรียน</h4>
                                </a>
                                <a href="#" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-wrench'></i> กำหนดสิทธิ์</h4>
                                </a>
                                <a href="{{route('course.edit',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-cog'></i> การตั้งค่า</h4>
                                </a>
                                <form action="{{route('course.destroy',$data->id)}}" method="post" class="nav-link dropdown">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-outline-danger btn-sm"
                                        onclick="return confirm('คุณต้องการลบข้อมูลรายวืชา ที่ชื่อ {{$data->course_name}} หรือไม่?')">
                                        <h4><i class='bx bxs-trash-alt'></i> ลบรายวิชา</h4>
                                    </button>
                                </form>
                                --}}
                                @else
                                <a href="{{route('pages.course_index',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-detail'></i> เกี่ยวกับรายวิชา</h4>
                                </a>
                                <a href="{{route('pages.manage_lesson',$data->id)}}" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-book'></i>บทเรียน</h4>
                                </a>
                                <a href="#" class="nav-link dropdown ">
                                    <h4><i class='bx bxs-book-heart' ></i> ดูคะเเนน</h4>
                                </a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Bottom End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/slick/slick.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>