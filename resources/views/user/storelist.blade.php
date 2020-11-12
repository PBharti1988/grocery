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
    <title>Stores | Qrestro.com</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/assets/images/favicon.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
    <script
      src="https://code.jquery.com/jquery-3.1.0.min.js"
      integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
      crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/icons.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/login-box.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/intlTelInput.css')}}">

    <style>
        select.form-control{
            height: 40px !important;
        }
    </style>


</head>

<body>

    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"></p>
        </div>
    </div>
    <a href="javascript:void(0)" class="text-center db"><img src="{{asset('public/assets/images/logo-icon.png')}}" alt="Home" /></a>

    <section id="wrapper" class="login-register login-sidebar"
        style="background-image:url(public/assets/images/background/restaurant.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <div class="choose_dt" style="display: block;">
                    <h3 class=" rounded-pill px-4 py-3 font-weight-bold" >Choose an option</h3>

<!--                     <div class="col-lg-6">
                      <div class="icon-box choose_delivery" data-id="hd">
                        <div class="icon-outline rd">
                          <img src="{{URL::asset('public/assets/user/images/delivery1.jpg')}}"  title="Home Delivery" alt="Home Delivery">
                        </div>
                        <div class="icon-text">Home Delivery</div>
                      </div>
                    </div>
 -->                    
                    <div class="col-lg-6">
                      <div class="icon-box choose_delivery" data-id="ta">
                        <div class="icon-outline gr">
                          <img src="{{URL::asset('public/assets/user/images/takeaway2.jpg')}}" title="Pick Up" alt="Pick Up">
                        </div>
                        <div class="icon-text">Pick Up</div>
                      </div>

                      <!-- <button class="big_button choose_delivery" >Take Away</button> -->
                    </div>
                </div>

                <div class="choose_city" style="display: none;">
                    <div class=" rounded-pill px-4 py-3 text-uppercase font-weight-bold">Select City & Area</div>

                    <div class="col-lg-4">
                        <div class="icon-box" data-id="hd">
                            <div class="form-group">
                                <label for="name">Select City<span class="color-required"></span></label>
                                <select class="form-control" name="select_city" id="select_city">
                                    <option value=""></option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->city_name}}">{{$city->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Select Area<span class="color-required"></span></label>
                                <select class="form-control" name="select_area" id="select_area">                            
                                    <option value="">No Area listed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="store_details">
<!--                             <div class="store_unit">
                                <h4>Store Name</h4>
                                <p>Address</p>
                                <p>Address line 2</p>
                                <button class="btn btn-info">Select Store</button>
                            </div> -->
                        </div>
                    </div>
                </div>

                <form class="form-horizontal form-material" action="{{url('stores')}}" id="storeform" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" name="dt" value="">
                    <input type="hidden" name="cn" value="">
                    <input type="hidden" name="an" value="">
                    <!-- <input type="hidden" name="restaurant_id" value=""> -->
                    <button class="btn btn-info btn-block" type="submit">Submit</button> 
                </form>

            </div>
        </div>
    </section>

    <footer style="padding: 10px">
    <a href="{{url('/privacy-policy')}}">Privacy Policy</a> | <a href="{{url('/terms-conditions')}}">Terms and Conditions</a> | <a href="{{url('return-refund-policy')}}">Returns and Refund Policy</a> | <a href="{{url('contact-us')}}">Contact Us</a>
    </footer>

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

$(document).ready(function(){

    $('.choose_delivery').click(function(){
        var dt=$(this).data('id');
        if(dt=='hd')
        {
            $('input[name="dt"]').val('hd');
            $('.choose_dt').hide();
            $('.choose_city').show();
        }
        else if(dt=='ta')
        {
            $('input[name="dt"]').val('ta');
            $('.choose_dt').hide();
            $('.choose_city').show();
        }
    });


    $('#select_city').on('change',function(){
        var city_name=$('#select_city').val();
        $('input[name="cn"]').val(city_name);
        var send_data=new FormData();
        send_data.append('city_name',city_name);
        send_data.append('fn_action','area_list');
        if(city_name!='')
        {
            $.ajax({
                 headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                type: "POST",
                url: "{{url('/getcity')}}",           
              //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
               data:send_data,
                async: false,
                dataType: 'json',
                success: function(result){
                    console.log(result);
                    if(result.status == 'success'){
                        $('#select_area').html(''); 
                        $('#select_area').append('<option value="">Choose Area</option>'); 
                        $.each(result.data,function(index,val){
                            $('#select_area').append('<option value="'+val.area_name+'">'+val.area_name+'</option>'); 
                        })
                    }
                },
                cache: false,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false
            });            
        }
        else{
            $('#select_area').html(''); 
        }
    });


    $('#select_area').on('change',function(){
        var area_name=$('#select_area').val();
        $('input[name="an"]').val(area_name);

        var send_data=new FormData();
        send_data.append('area_name',area_name);
        send_data.append('fn_action','store_list');    
        if(area_name!='')
        $.ajax({
             headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
            type: "POST",
            url: "{{url('/getstore')}}",           
          //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
           data:send_data,
            async: false,
            dataType: 'json',
            success: function(result){
                console.log(result);
                if(result.status == 'success'){

                    $('.store_details').html(''); 
                    $.each(result.data,function(index,val){
                        $('.store_details').append('<div class="store_unit"><h4>'+val.name+'</h4><p>'+val.address+'</p><p>'+val.address_line_2+'</p><button class="btn btn-info choose_store" data-rest_id="'+val.id+'" data-url="'+val.url+'">Select store</button></div>');
                    })
                }
                else{
                    $('.store_details').html('<p>No store found in this area.</p>'); 

                }
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });
    });

    $('.store_details').on('click','.choose_store', function(){
        var rest_id = $(this).data('rest_id');
        var url = $(this).data('url');
        // $('input[name="restaurant_id"]').val(rest_id);
        $('#storeform').attr('action',url);
        $('#storeform').submit();
    })



});

    </script>

</body>

</html>