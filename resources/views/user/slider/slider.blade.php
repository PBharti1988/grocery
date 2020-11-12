    <?php $cartCookie; 
    // setcookie('qcart2', '', time() + (86400 * 30), "/"); // 86400 = 1 day
    if(isset($_COOKIE['qcart2'])) 
        $cartCookie=json_decode($_COOKIE['qcart2'],true);  // print_r($cartCookie); 
    $totalcartCount=0;
     // print_r($cartCookie);
     // die;
    ?>
    <html lang="en">

    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $trackingId; ?>"></script>
<script>
    
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config','<?php echo $trackingId; ?>');
</script>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Restaurant Project</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
      <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <!-- Owl Stylesheets -->
        <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
            integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
            integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
        <script src="https://code.jquery.com/jquery-3.1.0.min.js"
            integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
        </script>
        <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main.css')}}">
        <link rel="stylesheet" href="{{URL::asset('public/assets/css/icons.min.css')}}">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css" rel="stylesheet" type="text/css">
        <link href="{{asset('public/slider/dist/css/cardslider.css')}}" rel="stylesheet">
        <link href="{{asset('public/slider/demo.css')}}" rel="stylesheet">

        <style>
        p {
            font-size: 16px;
            margin-left: 10px;
        }

        hr {
            border-top: 1px solid grey;
        }

        span {
            border: 1px solid #1da1f2;
            font-size: 15px;
            border-radius: 1rem;
            margin-left: 5px;
            display: inline-block;
        }

        .title_head {
            display: inline-block;
            font-weight: 700 !important;
            font-size: 22px !important;
            margin-top:20px;
        }

        .story_card {
            background: url("{{URL::asset('public/story.jpg')}}") 0 0/cover no-repeat;
            height: 50rem;
        }

        .story_section {
            padding-left: 1rem !important;
            padding-bottom: 1rem !important;
            padding-right: 1rem !important;
            padding-top: 1rem !important;
            margin-bottom: 0rem !important;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            /* background-color: #fff; */
        }


        @media only screen and (max-width: 500px) {
            p {
                font-size: 18px;
            }

            #map {
                width: 288px;
                height: 251px;
            }
            .cardslider__cards
            {width: 100%;}

        }

        @media only screen and (max-width: 768px) {

            #map {
                width: 288px;
                height: 251px;
            }
        }


        @media only screen and (min-width: 992px) {

            #map {
                width: 819px;
                height: 588px;
            }

        }
        i {
          color:darkcyan;
        }
        </style>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
    </head>

    <body>
<div class="conta">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-5 col-md-12 col-sm-12">
                <div class="my-slider">
                    <ul>

                        @foreach($card as $val)
                        @if($val->category_id != 8 && $val->category_id !=9)
                        <li class="center">
                            <p class="title_head" style=" ">{{$val->card_name}}</p>
                            <div>
                                @if($val->category_id == 1)
                                <p><i class="{{$val->email_code}}"></i> {{$val->email}}</p>
                                <hr>
                                <p><i class="{{$val->phone_code}}"></i> {{$val->phone}}</p>
                                <hr>
                                <p><i class="{{$val->gst_code}}"></i> {{$val->gst}}</p>
                                <hr>
                                <p style="word-wrap: break-word"><i class="{{$val->address_code}}"></i> {{$val->address}}</p>
                                <div style="position:absolute; bottom:0; height:2.5rem; width:100%; border-top:1px solid #bcbcbc; ">
                                </div>
                                @elseif($val->category_id == 2)
                                <input type="hidden" value="{{$val->latitude}}" id="lat">
                                <input type="hidden" value="{{$val->longitude}}" id="long">
                                <p><i class="fas fa-flag"></i> {{$val->address}}</p>
                                <hr>
                                <div id="map" style=""></div>
                                <div style="position:absolute; bottom:0; height:2.5rem; width:100%; border-top:1px solid #bcbcbc; ">
                                </div>
                                @elseif($val->category_id == 3)
                                <img style="float:right; width:17.75rem; border-top-right-radius: 1rem; margin-top:-62px;"
                                    src="{{URL::asset('public/slider/phool__paati.png')}}">
                                <div style="width:100%; overflow:hidden;">
                                    <?php $data =(array)$val->offering; 
                                         foreach($data as $val){
                                        ?> <span style="word-break:break-all;max-height:3.5rem;overflow:hidden;">{{$val->val}}</span> <?php
                                         }
                                        ?>
                                </div>
                                <div style="position:absolute; bottom:0; height:2.5rem; width:100%; border-top:1px solid #bcbcbc; ">
                                </div>

                                @elseif($val->category_id == 4)
                                <img style="float:right; width:17.75rem; border-top-right-radius: 1rem; margin-top:-62px;"
                                    src="{{URL::asset('public/slider/phool__paati.png')}}">
                                <div style="width:100%; overflow:hidden;">
                                    <p style="padding-left:1rem!important;">{{$val->famous_for}}</p>
                                </div>
                                <div style="position:absolute; bottom:0; height:2.5rem; width:100%; border-top:1px solid #bcbcbc; ">

                                </div>
                                @elseif($val->category_id == 5)
                                <img style="float:right; width:17.75rem; border-top-right-radius: 1rem; margin-top:-62px;"
                                    src="{{URL::asset('public/slider/phool__paati.png')}}">
                                <div style="width:100%; overflow:hidden;">
                                    <p style="padding-left:1rem!important;">{{$val->facilities}}</p>
                                </div>
                                <div style="position:absolute; bottom:0; height:2.5rem; width:100%; border-top:1px solid #bcbcbc; ">

                                </div>
                                @elseif($val->category_id == 6)
                                <div class="story_card">
                                    <p class="story_section">{{$val->story}}</p>
                                </div>

                                @endif
                            </div>
                        </li>
                        @endif
                        @if(!empty($val->custom_detail))
                        <li class="center">
                            <div class="colorcard" style="color:{{$val->font_color}} !important;background:{{$val->card_color}}; ">
                                <p class="title_head" style=" ">{{$val->title}}</p>
                                @foreach($val->custom_detail as $val1)
                                    @if($val1->type=='text')
                                    <!-- <p>{{$val1->title}}</p> -->
                                    <p>
                                        <i class="fa {{$val1->code}}" style="color:{{$val->font_color}} !important;"></i><span></span>{{$val1->text}}</p>
                                    @else
                                    <!-- <p>{{$val1->title}}</p> -->
                                        
                                    <p>
                                        <i class="fa {{$val1->code}}" style="color:{{$val->font_color}} !important;"></i>
                                        {{htmlspecialchars($val1->text)}}</p>
                                    @endif
                                @endforeach
                                    
                            </div>
                        </li>
                        @endif

                        @if(!empty($val->social_detail))
                        @foreach($val->social_detail as $val2)
                        <li class="center">
                            <p class="title_head" style=" ">{{$val2->social_media}}</p>
                            <p><a href="{{$val2->link}}">Like Page</a></p>
                            <div>
                              <img src="{{url('public/card-images/'.$val2->image)}}" style="width:200px; height:200px;" >
                            </div>
                        </li>
                        @endforeach
                        @endif
                          
                        
                        <!-- <li>jQuery cardSlider Plugin👋</li>
                <li class="center">This is card 2</li>
                <li class="center">This is card 3</li>
                <li>This is card 4</li>
                <li>This is card 5 </li>
                <li>This is card 6 </li>
                <li> This is card 7 </li> -->
                        <!-- <li class="center">This is the last card </li> -->
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


      

        <footer class="footer-section">
            <div><a href="<?php echo url()->current(); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></div>

            <div><a href="#" class="explore-btn" data-toggle="modal" data-toggle="modal"
                    data-target="#feedbackDialog">Feedback</a></div>
            <div><a href="#" id="order-details" data-toggle="modal" data-target="#orderDetails"><i class="fa fa-user"
                        aria-hidden="true"></i></a></div>

            <div class="cart-icon"><a href="<?php echo url()->current(); ?>/cart"><i class="fa fa-shopping-cart"
                        aria-hidden="true"></i><span>0</span></a></div>
        </footer>


        <!--- <dialog id="dialog" class="dialog"> -->
        <div id="feedbackDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <span class="error"></span>
                    <div class="modal-body">
                        <form id="feedback" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="res_id" id="res_id" value="">
                                <label for="recipient-name" class="control-label">Restaurant Name:</label>
                                <input type="text" name="restaurant_name" id="restaurant_name" readonly value=""
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Name:</label>
                                <input type="text" name="name" id="name" required class="form-control" id="">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Email:</label>
                                <input type="email" id="email" name="email" required class="form-control"
                                    id="recipient_name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Mobile:</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" id="recipient_name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">File:</label>
                                <input type="file" name="file_img" id="file_img" class="form-control" id="recipient_name">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">Feedback:</label>
                                <textarea type="text" id="feedback" name="feedback" class="form-control"
                                    required></textarea>
                            </div>
                            <input type="hidden" name="rating" id="rating">
                            <div class="form-group">
                                <section class='rating-widget'>
                                    <div class='rating-stars text-center' style="margin-right: 0px;
                    margin-top: 0px;">
                                        <span>Give Rating</span>
                                        <ul id='stars'>
                                            <li class='star' title='Poor' data-value='1'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Fair' data-value='2'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Good' data-value='3'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='Excellent' data-value='4'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                            <li class='star' title='WOW!!!' data-value='5'>
                                                <i class='fa fa-star fa-fw'></i>
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                            </div>

                            <div class="form-group form_buttons">
                                <button type="button" class="btn btn-success" onclick="javascript:Feedback('feedback');"
                                    style="margin-right: 10px;">Submit</button>
                                <button id="close-modal" class="right btn btn-info close_button" data-dismiss="modal">
                                    Close</button>
                            </div>
                        </form>
                    </div>
                    <span id="success" style="display:block; text-align:center;"></span>
                </div>
            </div>
        </div>
        <!-- </dialog> -->

        <div id="orderDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body" id="">

                        <div class="col-lg-12 p-5  mb-5">
                            <button id="close-modal" style="float:right;" class="right btn btn-info close_button"
                                data-dismiss="modal"> Close</button>
                            <h1 class="display-4">Order Details</h1>

                            <!-- Shopping cart table -->
                            <div id="details-order">



                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>


        <script
            src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'>
        </script>
        <script
            src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'>
        </script>
        <script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>
        <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
        <script src="{{asset('public/slider/jquery.event.move.js')}}"></script>
        <script src="{{asset('public/slider/jquery.event.swipe.js')}}"></script>
        <script src="{{asset('public/slider/dist/js/jquery.cardslider.min.js')}}"></script>
        <script>
        $('.my-slider').cardslider({
            swipe: true,
            dots: false,
            loop: true,
            nav: false,
            keys: {
                next: 39,
                prev: 37
            },
            direction: 'left'

        });
        </script>
        <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        </script>

        <script type="text/javascript">
        function initialize() {
            var lat = document.getElementById('lat').value;
            var long = document.getElementById('long').value;
            //var latlng = new google.maps.LatLng(28.535516,77.391026);
            var latlng = new google.maps.LatLng(lat, long);
            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 13
            });
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                draggable: false,
                anchorPoint: new google.maps.Point(0, -29)
            });
            var infowindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function() {
                var iwContent = '<div id="iw_container">' +
                    '<div class="iw_title"><b>Location</b> : Noida</div></div>';
                // including content to the infowindow
                infowindow.setContent(iwContent);
                // opening the infowindow in the current map and at the current marker location
                infowindow.open(map, marker);
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </body>

    </html>