<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'pagetitle')</title>
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendors/chartjs/Chart.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/app.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Ultra&family=Vina+Sans&display=swap" rel="stylesheet">


    <link rel="shortcut icon" href="{{asset('admin/images/favicon.svg')}}" type="image/x-icon">
        @stack('css')
        <style>
            .judul{
                font-family: "Vina Sans", sans-serif;
  font-weight: 400;
  font-style: normal;
  color: black;

            }
        </style>

</head>
<body>
    <div id="app"  style="background-color: black">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active" >
    <div class="sidebar-header">
        <img src="{{asset('costumer/img/logo.png')}}" style="width: 5em; height:2em; margin-left:13px" alt="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">


                <li class='sidebar-title'>Main Menu</li>



                <li class="sidebar-item active ">

                    <a href="{{route('admindasboard')}}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>


                </li>

                <li class='sidebar-title'>Produk</li>


                <li class="sidebar-item  ">

                    <a href="{{route('adminallproduk')}}" class='sidebar-link'>

                        <span>Semua Produk</span>
                    </a>
                </li>

                <li class='sidebar-title'>Categori Produk</li>


                <li class="sidebar-item">

                    <a href="{{route('adminallkategori')}}" class='sidebar-link'>

                        <span>Semua Kategori</span>
                    </a>
                </li>

                <li class='sidebar-title'>slider</li>


                <li class="sidebar-item  ">

                    <a href="{{route('slider')}}" class='sidebar-link'>
                        <span>Semua Slider</span>
                    </a>
                </li>


                <li class='sidebar-title'>Faq</li>


                <li class="sidebar-item  ">

                    <a href="{{route('adminallfaq')}}" class='sidebar-link'>
                        <span>Semua Faq</span>
                    </a>
                </li>







        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown nav-icon">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">
                                    <i data-feather="bell"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success me-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="avatar bg-success me-3">
                                            <span class="avatar-content"><i data-feather="shopping-cart"></i></span>
                                        </div>
                                        <div>
                                            <h6 class='text-bold'>New Order</h6>
                                            <p class='text-xs'>
                                                An order made by Ahmad Saugi for product Samsung Galaxy S69
                                            </p>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    {{-- <img src="{{asset('admin/images/avatar/avatar-s-1.png')}}" alt="" srcset=""> --}}
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Admin</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                                <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href=""><i data-feather="log-out"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

@yield('main-content')
    <script src="{{asset('admin/js/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('admin/js/app.js')}}"></script>

    <script src="{{asset('admin/vendors/chartjs/Chart.min.js')}}"></script>
    <script src="{{asset('admin/vendors/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('admin/js/pages/dashboard.js')}}"></script>

    <script src="{{asset('admin/js/main.js')}}"></script>
    <script src="{{asset('admin/vendors/simple-datatables/simple-datatables.js')}}"></script>
    @stack('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs5.min.js"></script>

</body>
</html>
