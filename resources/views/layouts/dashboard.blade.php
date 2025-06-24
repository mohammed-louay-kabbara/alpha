<!-- resources/views/layouts/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    {{-- <title>@yield('title', 'لوحة التحكم')</title> --}}
    <!--     Fonts and icons     -->
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700') }}" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css ') }}"
        rel="stylesheet" />
    <link href="{{ asset('https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css') }}"
        rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/alpha3.png') }}">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
</head>

<body>

    <aside
        class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
        id="sidenav-main">
        <div class="sidenav-header">
            <a class="navbar-brand m-0" href="#">
                <img src="{{ asset('assets/img/alpha3.png') }}" width="26px" height="26px" class="navbar-brand-img"
                    alt="logo">
                <span class="ms-1 font-weight-bold">لوحة التحكم إلفا</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active bg-danger text-white' : '' }}"
                        href="">
                        <i class="ni ni-tv-2 text-sm opacity-10"></i>
                        <span class="nav-link-text ms-1">الصفحة الرئيسية</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('users*') ? 'active bg-danger text-white' : '' }}"
                        href="">
                        <i class="ni ni-calendar-grid-58 text-sm opacity-10"></i>
                        <span class="nav-link-text ms-1">إدارة المستخدمين</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('categories*') ? 'active bg-danger text-white' : '' }}"
                        href="">
                        <i class="ni ni-credit-card text-sm opacity-10"></i>
                        <span class="nav-link-text ms-1">إدارة الأصناف</span>
                    </a>
                </li>
                <!-- أضف باقي العناصر بنفس الطريقة -->
            </ul>
        </div>
    </aside>


    {{-- المحتوى --}}
    <main class="main-content position-relative border-radius-lg ps">
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>

  <script src="{{asset('assets/js/core/popper.min.js')  }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
</body>

</html>
