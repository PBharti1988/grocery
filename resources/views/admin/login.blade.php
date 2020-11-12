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
    <title>Admin</title>

    <!-- page css -->
    <link href="{{URL::asset('public/assets/css/login.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{URL::asset('public/assets/css/style.min.css')}}" rel="stylesheet">



</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">admin</p>
        </div>
    </div>

    <section id="wrapper" class="login-register login-sidebar"
        style="background-image:url(public/assets/images/background/restaurant.jpg);">
        <div class="login-box card">
            <div class="card-body">
                
                 
                @include('admin.admin-layouts.flash-message')
                <form class="form-horizontal form-material" action="{{url('admin-login')}}" id="loginform" method="post">
                    {{ csrf_field() }}
                    <a href="javascript:void(0)" class="text-center db"><img
                 src="{{asset('public/assets/images/logo-icon.png')}}" alt="Home" /><br /><img
                 src="{{asset('public/assets/images/logo-text.png')}}" alt="Home" /></a>

                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" name="email" required="" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" name="password" required=""
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">

                                <!-- <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i
                                        class="fa fa-lock m-r-5"></i> Forgot pwd?</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Log
                                In</button>
                        </div>
                    </div>
                   
        
                </form>
               
            </div>
        </div>
    </section>

    <script src="{{asset('public/assets/node_modules/jquery/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('public/assets/node_modules/popper/popper.min.js')}}"></script>
    <script src="{{asset('public/assets/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>

</body>

</html>