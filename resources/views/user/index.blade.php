<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-169203769-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-169203769-1');
</script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/assets/images/favicon.png')}}">
    <title>Qrestro.com</title>
    <link href="{{URL::asset('public/assets/images/favicon.png')}}" rel="icon" />

    <!-- page css -->
    <link href="{{URL::asset('public/assets/css/login.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{URL::asset('public/assets/css/style.min.css')}}" rel="stylesheet">



</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"></p>
        </div>
    </div>

    <section id="wrapper" class="login-register login-sidebar"
        style="background-image:url(public/assets/images/background/restaurant.jpg);">
        <div class="login-box card">
            <div class="card-body">
                
                 
                @include('admin.admin-layouts.flash-message')
                <form class="form-horizontal form-material" action="{{url('search-restaurant')}}" id="loginform" method="post">
                    {{ csrf_field() }}
                    <a href="javascript:void(0)" class="text-center db"><img
                 src="{{asset('public/assets/images/logo-icon.png')}}" alt="Home" /><br /><img
                 src="{{asset('public/assets/images/logo-text.png')}}" alt="Home" /></a>

                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required name="restaurant_id" required="" placeholder="Enter Resturant ID">
                        </div>
                    </div>
                    
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Serach
                                </button>
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