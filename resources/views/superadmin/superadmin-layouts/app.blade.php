<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/assets/images/favicon.png')}}">
    <title>Resturant</title>

    @include('superadmin.superadmin-layouts.head')

</head>

<body class="skin-default fixed-layout">

    <div class="preloader">
        <div class="">
            <div class="loader__figure"></div>
           
        </div>
    </div>

    <div id="main-wrapper">

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">

                <div class="navbar-header">
                    <a class="navbar-brand" href="{{URL('/')}}">

                        <img src="{{URL::asset('public/assets/images/logo-icon.png')}}" alt="homepage"
                            class="dark-logo" />

                        <img style="height:67px;"  src="{{asset('public/assets/images/logo.png')}}" alt="homepage"
                            class="light-logo" />
                        </b>
                        <span>

                            <img src="{{asset('public/assets/images/logo-text.png')}}" alt="homepage"
                                class="dark-logo" />

                            <!-- <img src="{{asset('public/assets/images/logo-light-text.png')}}" class="light-logo"
                                alt="homepage" /></span> </a> -->
                </div>

                <div class="navbar-collapse">

                    <ul class="navbar-nav mr-auto">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                                href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{asset('public/assets/images/users/gym.jpg')}}" alt="user" class=""> <span
                                    class="hidden-md-down">Admin &nbsp;<i class="fa fa-angle-down"></i></span> </a>
                            <div class="dropdown-menu dropdown-menu-right animated flipInY">
                                                            
                                <div class="dropdown-divider"></div>
                                <!-- text-->
                                <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account
                                    Setting</a>
                                <!-- text-->
                                <div class="dropdown-divider"></div>
                                
                                <a href="{{url('/logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                                <!-- text-->
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <!--side bar menu -->
        @include('superadmin.superadmin-layouts.nav-vertical')

        <div class="page-wrapper">

            @yield('content')

        </div>

        <footer class="footer">
            © 2018 Eliteadmin by themedesigner.in
        </footer>

    </div>

    @include('superadmin.superadmin-layouts.footer-script')
</body>

</html>