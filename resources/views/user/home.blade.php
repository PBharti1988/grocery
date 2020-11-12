<?php 
$cartCookie; 
if(isset($_COOKIE[$url])) 
    $cartCookie=json_decode($_COOKIE[$url],true);  // print_r($cartCookie); 
$totalcartCount=0;
// print_r($url);
 // print_r($cartCookie);
 // die;
// dd($currency->code);
$currency_code=strtolower($currency->code);
if($url=='e772f6bf')
{
    header('Location: https://techstreet.in/restaurant/moglicafe/');
    exit;
}

if(isset($_COOKIE['qcart1'])) 
{
    $detailsCookie=json_decode($_COOKIE['qcart1'],true);  
    // print_r($detailsCookie);
    // die; 
}


// echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))

{

// $browser = get_browser(null, true);
// print_r($browser);


// $browser=get_browser(null,true);
// print_r($browser);

// setcookie('qcart2', '', time() + (86400 * 30), "/"); // 86400 = 1 day
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
    <title>Qrestro.com - {{$find_resto->name}}</title>
    <link href="{{URL::asset('public/assets/images/favicon.png')}}" rel="icon" />
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">

    <link href="{{asset('public/assets/css/custom.css?v=1')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/css/login-box.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/intlTelInput.css')}}">

    <!-- <script src="{{asset('public/assets/js/custom_quiz.js')}}"></script> -->
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
    <link rel="stylesheet" href="{{URL::asset('public/assets/css/icons.min.css')}}">
<?php if (isset($find_resto->img_menu) && $find_resto->img_menu == '1')
{
?>
<link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main.css')}}">
<?php 
}
else if (isset($find_resto->img_menu) && $find_resto->img_menu == '2')
{
?>
<link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main-woi.css')}}">    
<?php 
}
else if (isset($find_resto->img_menu) && $find_resto->img_menu == '3')
{
?>
<link rel="stylesheet" href="{{URL::asset('public/assets/user/css/strips.css')}}">    
<?php 
}
else
{
?>
<link rel="stylesheet" href="{{URL::asset('public/assets/user/css/main-woi.css')}}">    
<?php 
}
?>

    <script>
 
 $(document).ready(function(){
  
//    var send_data=new FormData();
//    send_data.append('restaurant_id',<?php //echo $find_resto->id; ?>);
//    $.ajax({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//     type: "POST",
//     url: "{{url('/get-trackingId')}}",           
//     data:send_data,
//     async: false,
//     success: function(data){
      
//         if(data.status == 'success'){
//           var trackid =data.data['tracking_id'];
//            $('#trackingId').val(trackid);
//            $('#tracing').html(trackid);
//         }
//     },
//     cache: true,
//     enctype: 'multipart/form-data',
//     contentType: false,
//     processData: false
// });



});


</script>

    
</head>
<body @if($find_resto->bg_color!='') style="background:{{$find_resto->bg_color}}" @endif>

<?php $array= array('(',')','+','@','-','[',']','{','}','!','/','<','>','?','&','%','^','*','$','-','=','|'); ?>

@foreach($categories as $val)
    <?php $category = 'sub'.$val->category_name; ?>
    @if(!empty($val->$category))
        @foreach($val->$category as $val1)
            <?php $cat1 = $val1->category_name; ?>
            @if(!empty($val1->$cat1))
                @foreach($val1->$cat1 as $val2)
        <div id="pop" class="itp-{{$val2->id}} close-itp-{{$val2->id}}">
            <div id="allpopupContact">
                <div class="pop-container">
                    <?php $img =$val2->item_name; ?>
<?php 
if (isset($find_resto->img_menu) && $find_resto->img_menu == '3')
{
?>

<?php 
}
else{
?>
    <div class="slider-section">
          <div class="owl-carousel owl-theme">                     
              @if(!empty($val2->$img))
            @foreach($val2->$img as $val3)
            <div class="item">
                <img src="{{asset('public/assets/images/item-images/'.$val3->image)}}">
            </div>     
            @endforeach                 
            @else
            @if($val2->image !="")
             <div class="product-img">
             <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
               </div>
                 @endif 
            @endif
          </div>
    </div>
<?php 
}
?>
                   
                  
                    <div class="product-detail text-black">
                        <h1>{{$val2->item_name}}</h1>
                        @if($val2->discount_price !="")
                        <span><i class=""><b>{{$currency->symbol}}</b> {{$val2->discount_price}}</i></span>
                        <span class="item_discount"><del><i class=""><b>{{$currency->symbol}}</b> <del>{{$val2->item_price}}</i></del></span>
                        @else
                        <span><i class=""><b>{{$currency->symbol}}</b> {{$val2->item_price}}</i></span>


                        @endif
                    </div>
                    <ul class="product-content">
                        <li>
                            <h1>Description</h1>
                            <p>{{$val2->long_description}}</p>
                        </li>
                        <?php $desc ='desc'.$val2->item_name; ?>
                          @if(!empty($val2->$desc))
                      @foreach($val2->$desc as $val4)
                        <li>
                            <h1>{{$val4->title}}</h1>
                            <p>{{$val4->description}}</p>
                        </li>
                        @endforeach
                   @endif

                        <?php  ?>
                    </ul>

                    <?php if($find_resto->is_cart_active) { ?>

                    <div class="popup-addbuton-box">
                        <!-- <div class="popup-addbuton" style="background:{{$val2->card_color}};"> -->
                        <div class="popup-addbuton">
                          <!-- <div class="cls">x</div> -->
                          <div class="addCardOverlay item-{{$val2->id}} <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?> " data-id="item-{{$val2->id}}" data-tt="popup" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                            <?php if(count($val2['varient'.$val2->item_name])>0) 
                            {
                                echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                                echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                                //print_r($val2['varient'.$val2->item_name]);   
                                ?>
                                @foreach($val2['varient'.$val2->item_name] as $varient)
                                <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>

                                @endforeach
                                <?php                            
                                echo '</select></div></div>
                                <div class="cart-item">
                              <div class="addit btn">
                                <i class="dripicons-cutlery"></i>
                                Add Item
                              </div>
                            </div>';                            

                            }else{?>
                            <div class="cart-item"><span class="addItem">+</span></div>
                            <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>

                            <div class="cart-item"><span class="removeItem">-</span></div>
                            <!-- <div class="cart-item">
                              <div class="addit btn">
                                <i class="dripicons-cutlery"></i>
                                Add It
                              </div>
                            </div> -->
                           <?php } ?>
                          </div>
                        </div>
                    </div>
                   <?php } ?>
                    
                </div>
                <div id="close">
                    <button class="close" data-class="close-itp-{{$val2->id}}" onclick ="div_hide()">Close</button>
                </div>
            </div>
         
        <!-- Popup Div Ends Here -->
        </div>
                @endforeach
            @endif
        @endforeach
    @endif


      <!-- with out sub category  Ends Here -->
    <?php $categorys = $val->category_name; ?>
    @if(!empty($val->$categorys))
    @foreach($val->$categorys as $val2)
        <div id="pop" class="itp-{{$val2->id}} close-itp-{{$val2->id}}">
            <div id="allpopupContact">                             
                <div class="pop-container">
                    <?php $img =$val2->item_name; ?> 

<?php 
if (isset($find_resto->img_menu) && $find_resto->img_menu == '3')
{
?>

<?php 
}
else{
?>
    <div class="slider-section">
          <div class="owl-carousel owl-theme">                     
              @if(!empty($val2->$img))
            @foreach($val2->$img as $val3)
            <div class="item">
                <img src="{{asset('public/assets/images/item-images/'.$val3->image)}}">
            </div>     
            @endforeach                 
            @else
            @if($val2->image !="")
             <div class="product-img">
             <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
               </div>
                 @endif 
            @endif
          </div>
    </div>
<?php 
}
?>

                    <div class="product-detail text-black">
                        <h1>{{$val2->item_name}}</h1>
                        @if($val2->discount_price !="")
                        <span><i class=""><b>{{$currency->symbol}}</b> {{$val2->discount_price}}</i></span>
                        <span class="item_discount"><del><i class=""><b>{{$currency->symbol}}</b> <del>{{$val2->item_price}}</i></del></span>
                        @else
                        <span><i class=""><b>{{$currency->symbol}}</b> {{$val2->item_price}}</i></span>

                        @endif
                    </div>
                    <ul class="product-content">
                        <li>
                            <h1>Description</h1>
                            <p>{{$val2->long_description}}</p>
                        </li>
                        <?php $desc ='desc'.$val2->item_name; ?>
                        @if(!empty($val2->$desc))
                            @foreach($val2->$desc as $val4)
                            <li>
                                <h1>{{$val4->title}}</h1>
                                <p>{{$val4->description}}</p>
                            </li>
                            @endforeach
                        @endif

                        <?php  ?>
                    </ul>
<!--                     <div class="popup-addbuton-box">
                        <div class="popup-addbuton" data-itemid="9" data-itemname="Madras Idli Fries" ,="" data-price="155.00" data-image="http://localhost/restaurant/public/assets/images/item-images/main5e5e4d805da1dunnamed (1).png">
                            <div class="cart-item"><span class="addItem">+</span></div>
                            <div class="cart-item"><span class="item-qty">01</span></div>
                            <div class="cart-item"><span class="removeItem">-</span></div>
                        </div>                    
                    </div>  -->
                    <?php if($find_resto->is_cart_active) { ?>
                    <div class="popup-addbuton-box">
                        <!-- <div class="popup-addbuton" style="background:{{$val2->card_color}};"> -->
                        <div class="popup-addbuton">
                          <!-- <div class="cls">x</div> -->
                          <div class="addCardOverlay item-{{$val2->id}} <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?>" data-id="item-{{$val2->id}}" data-tt="popup" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                            <?php if(count($val2['varient'.$val2->item_name])>0) 
                            {
                                echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                                echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                                //print_r($val2['varient'.$val2->item_name]);   
                                ?>
                                @foreach($val2['varient'.$val2->item_name] as $varient)
                                <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>

                                @endforeach
                                <?php                            
                                echo '</select></div></div>
                                <div class="cart-item">
                              <div class="addit btn">
                                <i class="dripicons-cutlery"></i>
                                Add Item
                              </div>
                            </div>';                            

                            }else{?>
                            <div class="cart-item"><span class="addItem">+</span></div>
                            <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>

                            <div class="cart-item"><span class="removeItem">-</span></div>
                            <!-- <div class="cart-item">
                              <div class="addit btn">
                                <i class="dripicons-cutlery"></i>
                                Add It
                              </div>
                            </div> -->
                           <?php } ?>
                          </div>
                        </div>
                    </div>
                   <?php } ?>





                </div>
                <div id="close">
                    <button class="close" data-class="close-itp-{{$val2->id}}" onclick ="div_hide()">Close</button>
                </div>
            </div>
         
        <!-- Popup Div Ends Here -->
        </div>
    @endforeach
    @endif
      
@endforeach







      
      <?php
//dd($find_resto);
       ?>

<?php 
if (isset($find_resto->img_menu) && $find_resto->img_menu == '3')
{
?>

    <div class="top-header">     
        <div class="logo" ><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>    
        <h1 class="text-white">{{$find_resto->name}}</h1>   

    </div>
    <div class="grid-section">
        <input type="hidden" name="restro_id" class="restro_id"  id="restro_id" value="{{$find_resto->id}}">
        <?php if($find_table){ ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="{{$find_table->id}}">
        <?php } else { ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="0">
        <?php }?>

          <!-- <a href = "newpage.html">Next Page</a> -->  
        <section id="grid-container" class="transitions-enabled fluid masonry js-masonry grid" style="">
      <?php $i =1;
      $count=1;
      $j=1;
      $articleClass="tile-odd";
      $articleClass="tile-even";
      $articleClass="rect";
      $itemClass="first-box"
//      dd($categories);
      ?>

          @foreach($categories as $val)
            <article class="category-titles {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}}"> 
                <h1 class="cat-title">{{$val->category_name}}</h1>
            </article>
          <?php
                          
          $cat = 'sub'.$val->category_name; // $j=1;
             
          ?>
            @if(!empty($val->$cat))
            @foreach($val->$cat as $val1)
            <?php $cat1 = $val1->category_name; ?>
            <article class="category-titles {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} {{str_ireplace($array,'',str_replace(' ','_',$val1->category_name))}}-{{$val1->id}}"> 
                <h1 class="sub-cat-title">{{$val1->category_name}}</h1>
            </article>
<!--       
          <article class="@if($count%2==1){{'tile-odd'}} @else{{'tile-even'}}@endif {{str_replace(' ','_',$val->category_name)}}">
-->
            @if(!empty($val1->$cat1))
            @foreach($val1->$cat1 as $val2)
            <article class="{{$articleClass}} {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} {{str_ireplace($array,'',str_replace(' ','_',$val1->category_name))}}-{{$val1->id}}">
                


                <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}">

                    <?php if($find_resto->is_cart_active) { ?>
                    <span class="ic" <?php if(isset($cartCookie[$val2->id])  && !empty($cartCookie[$val2->id])) echo 'style="display: block;"';?> >

                        <?php
                        $varientQty=0; 
                        if(isset($cartCookie[$val2->id]) && !isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id])) 
                        {   
                            echo $cartCookie[$val2->id]['qty']; 
                            $totalcartCount+=$cartCookie[$val2->id]['qty']; 
                        }
                        if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id]))
                        {
                            if(isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id]['varientId']))
                            {
                                foreach($cartCookie[$val2->id]['varientId'] as $varient)
                                {
                                    $varientQty = $varientQty + $varient['varientQuantity'];
                                    $totalcartCount+= $varient['varientQuantity'];
                                }   
                                echo $varientQty;
                            }
                        } 

                        ?>                            
                    </span>
                    <div class="addbtnoverlay" style="background:#fff;"><div class="cls">x</div>
                        <div class="addCardOverlay <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?> " id="item-{{$val2->id}}" data-tt="overlay" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}"  data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                        <?php if(count($val2['varient'.$val2->item_name])>0) 
                        {
                            echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                            echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                            //print_r($val2['varient'.$val2->item_name]);   
                            ?>
                            @foreach($val2['varient'.$val2->item_name] as $varient)
                            <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>

                            @endforeach
                            <?php                            
                            echo '</select></div></div>
                            <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add Item
                          </div>
                        </div>';                            

                        }else{?>
                        <div class="cart-item"><span class="addItem">+</span></div>
                        <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>

                        <div class="cart-item"><span class="removeItem">-</span></div>
                        <!-- <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add It
                          </div>
                        </div> -->
                       <?php } ?>
                      </div>
                    </div>

                    <div class="pro-button">
                        <div class="item-count aaaa <?php if(count($val2['varient'.$val2->item_name])>0){} else{echo "additemcount";} ?>">+</div>                        
                    </div>

                   <?php } ?>
                    <div class="pro-type" style="@if($val2->item_type=='')display: none; @endif">
                      <div class="@if($val2->item_type == 'veg') veg-product @elseif($val2->item_type == 'non-veg') non-veg-product @endif"></div>
                    </div>
<?php /* ?>
                    @if($val2->image !="")
                    <div class="product-img" <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1'){ echo 'style="display:none;"'; } ?> >
                        <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                    </div>
                    @endif
<?php */ ?>
                    <div class="product-detail text-dark">
                        <h1>{{$val2->item_name}}</h1>
                        <p>{{$val2->short_description}}</p>
                        <div class="price-tag">                        
                            @if($val2->discount_price !="")
                            <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->discount_price}}</span>
                            <span style="margin-left:7px;"><del><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</del></span> 
                            @else 
                            <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</span>   
                            @endif
                        </div>
                        <div class="ingredient-info" data-class="itp-{{$val2->id}}"><i class="fa fa-info-circle"></i></div>


                    </div>
                    <?php /* ?>
                    <div class="cart-btns">
                      <div class="btn-size">
                        <div class="input-group" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price="@if($val2->discount_price !=''){{$val2->discount_price}}@else{{$val2->item_price}}@endif" data-image="{{$val2->image}}">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number removeItem"  data-type="minus" data-field="quant[2]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                          </span>
                          <input type="text" name="quant[2]" class="form-control input-number itemcount" readonly="true" value="<?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '0'; ?>" min="1" max="100">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number addItem" data-type="plus" data-field="quant[2]">
                                  <span class="glyphicon glyphicon-plus"></span>
                              </button>
                          </span>
                        </div>
                      </div>
                    </div>
                    <?php  */ ?>
                </div>
                <?php $j++;   ?>
                </article>
            <?php $count++; ?>
            <?php 
/*              if($count%2==0)
              if($articleClass=="tile-odd")
              {
                $articleClass="tile-even";
              }
              else if($articleClass=="tile-even"){
                $articleClass="tile-odd";
              }            
              */
              if($count%4==2 || $count%4==3)
              {
                $itemClass="first-box";
              }
              if($count%4==1 || $count%4==0)
              {
                
                $itemClass="first-box";
              }


?>
           @endforeach
           @endif
            @endforeach
          @endif


    <!-----No sub category--->
    <?php $cat1 = $val->category_name; // $j=1;
    // echo "<pre>";
    // print_r($val->$cat1);
    // die;
            
    ?>          
<!--       
            <article class="@if($count%2==1){{'tile-odd'}} @else{{'tile-even'}}@endif {{str_replace(' ','_',$val->category_name)}}">
-->
            @if(!empty($val->$cat1))
            @foreach($val->$cat1 as $val2)

            <article class="{{$articleClass}} {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} ">

                <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}">

                    <?php if($find_resto->is_cart_active) { ?>
                    <span class="ic" <?php if(isset($cartCookie[$val2->id])  && !empty($cartCookie[$val2->id])) echo 'style="display: block;"';?> >

                        <?php
                        $varientQty=0; 
                        if(isset($cartCookie[$val2->id]) && !isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id])) 
                        {   
                            echo $cartCookie[$val2->id]['qty']; 
                            $totalcartCount+=$cartCookie[$val2->id]['qty']; 
                        }
                        if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id]))
                        {
                            if(isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id]['varientId']))
                            {
                                foreach($cartCookie[$val2->id]['varientId'] as $varient)
                                {
//                                    print_r($varient['varientQuantity']);
                                    $varientQty = $varientQty + $varient['varientQuantity'];
                                    $totalcartCount+= $varient['varientQuantity'];                                   
                                }
                                echo $varientQty;
                            }
                        } 

                        ?>                            
                    </span>

                    <div class="addbtnoverlay" style="background:#fff;"><div class="cls">x</div>
                        <div class="addCardOverlay <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?> " id="item-{{$val2->id}}" data-tt="overlay" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                        <?php if(count($val2['varient'.$val2->item_name])>0) 
                        {   
                            echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                            echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                            //print_r($val2['varient'.$val2->item_name]);   
                            ?>
                            @foreach($val2['varient'.$val2->item_name] as $varient)
                            <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>


                            @endforeach
                            <?php                            
                            echo '</select></div></div>
                            <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add Item
                          </div>
                        </div>';
                            
                        }else{?>

                        <div class="cart-item"><span class="addItem">+</span></div>
                        <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>
                        <div class="cart-item"><span class="removeItem">-</span></div>
                        <!-- <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add It
                          </div>
                        </div> -->
                       <?php } ?>
                      </div>
                    </div>
                    <div class="pro-button">
                        <div class="item-count <?php if(count($val2['varient'.$val2->item_name])>0){} else{echo "additemcount";} ?>">+</div>                        
                    </div>

                    <?php } ?>                    
                    <div class="pro-type" style="@if($val2->item_type=='')display: none; @endif">
                        <div class="@if($val2->item_type == 'veg') veg-product @elseif($val2->item_type == 'non-veg') non-veg-product @endif"></div>
                    </div>
<?php /* ?>                    @if($val2->image !="")
                    <div class="product-img" <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1') { echo 'style="display:none;"'; } ?> >
                        <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                    </div>
                    @endif
<?php */ ?>
                    <div class="product-detail text-dark">
                        <h1>{{$val2->item_name}}</h1>
                        
                        <p>{{$val2->short_description}}</p>
                        
                        <div class="price-tag">                        
                            @if($val2->discount_price !="")
                            <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->discount_price}}</span>
                            <span style="margin-left:7px;"><del><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</del></span> 
                            @else 
                            <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</span>   
                            @endif
                        </div> 
                        <div class="ingredient-info" data-class="itp-{{$val2->id}}"><i class="fa fa-info-circle"></i></div>
                    </div>
                    
                    <?php /* ?>                    
                    <div class="cart-btns">
                      <div class="btn-size">
                        <div class="input-group" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price="@if($val2->discount_price !=''){{$val2->discount_price}}@else{{$val2->item_price}}@endif" data-image="{{$val2->image}}">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number removeItem"  data-type="minus" data-field="quant[2]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                          </span>
                          <input type="text" name="quant[2]" class="form-control input-number itemcount" readonly="true" value="<?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '0'; ?>" min="1" max="100">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number addItem" data-type="plus" data-field="quant[2]">
                                  <span class="glyphicon glyphicon-plus"></span>
                              </button>
                          </span>
                        </div>
                      </div>
                    </div>
                    <?php */ ?>
                </div>
                <?php $j++;   ?>
                </article>
            <?php $count++; ?>
            <?php 
/*              if($count%2==0)
              if($articleClass=="tile-odd")
              {
                $articleClass="tile-even";
              }
              else if($articleClass=="tile-even"){
                $articleClass="tile-odd";
              }
              */
              if($count%4==2 || $count%4==3)
              {
                $itemClass="first-box";
              }
              if($count%4==1 || $count%4==0)
              {
                $itemClass="first-box";
              }

           ?>
           @endforeach
           @endif
          

  <!------>

        
            @endforeach
           
       
        </section>
    </div>

<?php 
}
else
{
?>

<!-- <input type="text" id="myInput" onkeyup="searchItems()" placeholder="Search Items.."> -->
<!-- Search form -->
    <div class="top-header"></div>

    <div class="grid-section">
        <!-- <div class="logo" ><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>     -->
         @if($find_resto->logo_enabled == 1)
        <div class="logo" ><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>   
         @else
        <h1 class="text-white">{{$find_resto->name}}</h1>    
        @endif

        <!-- <input class="form-control" type="text" placeholder="Search Items" aria-label="Search"  id="myInput" onkeyup="searchItems()"> -->
        
    <div class="container">
      <div class="d-flex justify-content-md-center">
        <div class="searchbar">
          <input class="search_input" type="text" placeholder="Search Items" aria-label="Search"  id="myInput" onkeyup="searchItems()">
          <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
        </div>
      </div>
    </div>


        <input type="hidden" name="restro_id" class="restro_id"  id="restro_id" value="{{$find_resto->id}}">
        <?php if($find_table){ ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="{{$find_table->id}}">
        <?php } else { ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="0">
        <?php }?>

          <!-- <a href = "newpage.html">Next Page</a> -->  
        <section id="grid-container" class="transitions-enabled fluid masonry js-masonry grid" style="">
      <?php $i =1;
      $count=1;
      $j=1;
      $articleClass="tile-odd";
      $articleClass="tile-even";
      $itemClass="first-box"
//      dd($categories);
      ?>

          @foreach($categories as $val)
          <?php
                          
          $cat = 'sub'.$val->category_name; // $j=1;
             
          ?>
            @if(!empty($val->$cat))
            @foreach($val->$cat as $val1)
            <?php $cat1 = $val1->category_name; ?>
<!--       
          <article class="@if($count%2==1){{'tile-odd'}} @else{{'tile-even'}}@endif {{str_replace(' ','_',$val->category_name)}}">
-->
            @if(!empty($val1->$cat1))
            @foreach($val1->$cat1 as $val2)
            <article class="{{$articleClass}} {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} {{str_ireplace($array,'',str_replace(' ','_',$val1->category_name))}}-{{$val1->id}}">
                <a class="text-white" style="display: none;">{{$val2->item_name}}</a>
                <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1')
                {
                ?>
                  <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}" style="background:transparent;background-image: url('{{asset('public/assets/images/item-images/'.$val2->image)}}'); background-size: cover;" onclick="div_show()">

            <?php } else {?>
                  <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}" style="background:{{$val2->card_color}}" onclick="div_show()">

            <?php }?>
                    <?php if($find_resto->is_cart_active) { ?>
                    <span class="ic" <?php if(isset($cartCookie[$val2->id])  && !empty($cartCookie[$val2->id])) echo 'style="display: block;"';?> >

                        <?php
                        $varientQty=0; 
                        if(isset($cartCookie[$val2->id]) && !isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id])) 
                        {   
                            echo $cartCookie[$val2->id]['qty']; 
                            $totalcartCount+=$cartCookie[$val2->id]['qty']; 
                        }
                        if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id]))
                        {
                            if(isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id]['varientId']))
                            {
                                foreach($cartCookie[$val2->id]['varientId'] as $varient)
                                {
                                    $varientQty = $varientQty + $varient['varientQuantity'];
                                    $totalcartCount+= $varient['varientQuantity'];
                                }   
                                echo $varientQty;
                            }
                        } 

                        ?>                            
                    </span>
                    <div class="addbtnoverlay" style="background:{{$val2->card_color}};"><div class="cls">x</div>
                        <div class="addCardOverlay <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?> " id="item-{{$val2->id}}" data-tt="overlay" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}"  data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                        <?php if(count($val2['varient'.$val2->item_name])>0) 
                        {
                            echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                            echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                            //print_r($val2['varient'.$val2->item_name]);   
                            ?>
                            @foreach($val2['varient'.$val2->item_name] as $varient)
                            <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>

                            @endforeach
                            <?php                            
                            echo '</select></div></div>
                            <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add Item
                          </div>
                        </div>';                            

                        }else{?>
                        <div class="cart-item"><span class="addItem">+</span></div>
                        <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>

                        <div class="cart-item"><span class="removeItem">-</span></div>
                        <!-- <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add It
                          </div>
                        </div> -->
                       <?php } ?>
                      </div>
                    </div>

                    <div class="pro-button" @if($find_resto->cb_color!='') style="background:{{$find_resto->cb_color}}59" @endif>
                        <div class="item-count aaaa <?php if(count($val2['varient'.$val2->item_name])>0){} else{echo "additemcount";} ?>" @if($find_resto->cbt_color!='') style="color:{{$find_resto->cbt_color}}" @endif>+</div>                        
                    </div>

                   <?php } ?>               
                    @if($val2->image !="")
                    <div class="product-img" <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1'){ echo 'style="display:none;"'; } ?> >
                        <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                    </div>
                    @endif
                    <div class="product-detail text-white" style="background: {{$val2->card_color}}; background: -webkit-linear-gradient(to top, {{$val2->card_color}}, transparent); background: linear-gradient(to top, {{$val2->card_color}}, transparent);  color:{{$val2->font_color}} !important;">
                        <div class="pro-type" style="@if($val2->item_type=='')display: none; @endif">
                          <div class="@if($val2->item_type == 'veg') veg-product @elseif($val2->item_type == 'non-veg') non-veg-product @endif"></div>
                        </div>
                        <h1>{{$val2->item_name}}</h1>
                       @if($val2->discount_price !="") <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->discount_price}}</span><span style="margin-left:7px;"><del><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</del></span> @else <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</span>   @endif
                        <p>{{$val2->short_description}}</p>
                    </div>
                </div>
                <?php $j++;   ?>
                </article>
            <?php $count++; ?>
            <?php 
/*              if($count%2==0)
              if($articleClass=="tile-odd")
              {
                $articleClass="tile-even";
              }
              else if($articleClass=="tile-even"){
                $articleClass="tile-odd";
              }            
              */
              if($count%4==2 || $count%4==3)
              {
                $itemClass="second-box";
              }
              if($count%4==1 || $count%4==0)
              {
                
                $itemClass="first-box";
              }


?>
           @endforeach
           @endif
            @endforeach
          @endif


    <!-----No sub category--->
    <?php $cat1 = $val->category_name; // $j=1;
    // echo "<pre>";
    // print_r($val->$cat1);
    // die;
            
    ?>
          
<!--       
            <article class="@if($count%2==1){{'tile-odd'}} @else{{'tile-even'}}@endif {{str_replace(' ','_',$val->category_name)}}">
-->
            @if(!empty($val->$cat1))
            @foreach($val->$cat1 as $val2)

            <article class="{{$articleClass}} {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} ">

                <a class="text-white" style="display: none;">{{$val2->item_name}}</a>
                <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1')
                {
                ?>
                  <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}" style="background:transparent;background-image: url('{{asset('public/assets/images/item-images/'.$val2->image)}}'); background-size: cover;" onclick="div_show()">

            <?php } else {?>
                  <div class="{{$itemClass}} box-category {{str_ireplace($array,'',str_replace(',', '--',str_replace(' ', '_',$val2->item_name)))}}-{{$val2->id}}" data-class="{{str_ireplace($array,'',str_replace(',', '--',str_replace(' ', '_',$val2->item_name)))}}-{{$val2->id}}" style="background:{{$val2->card_color}}" onclick="div_show()">
                  <div class="{{$itemClass}} box-category itp-{{$val2->id}}" data-class="itp-{{$val2->id}}" style="background:{{$val2->card_color}}" onclick="div_show()">

            <?php }?>

                    <?php if($find_resto->is_cart_active) { ?>
                    <span class="ic" <?php if(isset($cartCookie[$val2->id])  && !empty($cartCookie[$val2->id])) echo 'style="display: block;"';?> >

                        <?php
                        $varientQty=0; 
                        if(isset($cartCookie[$val2->id]) && !isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id])) 
                        {   
                            echo $cartCookie[$val2->id]['qty']; 
                            $totalcartCount+=$cartCookie[$val2->id]['qty']; 
                        }
                        if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id]))
                        {
                            if(isset($cartCookie[$val2->id]['varientId']) && !empty($cartCookie[$val2->id]['varientId']))
                            {
                                foreach($cartCookie[$val2->id]['varientId'] as $varient)
                                {
//                                    print_r($varient['varientQuantity']);
                                    $varientQty = $varientQty + $varient['varientQuantity'];
                                    $totalcartCount+= $varient['varientQuantity'];                                   
                                }
                                echo $varientQty;
                            }
                        } 

                        ?>                            
                    </span>

                    <div class="addbtnoverlay" style="background:{{$val2->card_color}};"><div class="cls">x</div>
                        <div class="addCardOverlay <?php if(count($val2['varient'.$val2->item_name])>0) echo "flex-col";?> " id="item-{{$val2->id}}" data-tt="overlay" data-itemid="{{$val2->id}}" data-itemname="{{$val2->item_name}}" data-itemtype="{{$val2->item_type}}" data-price=@if($val2->discount_price !="") "{{$val2->discount_price }}" @else "{{$val2->item_price}}" @endif data-image="{{asset('public/assets/images/item-images/'.$val2->image)}}">

                        <?php if(count($val2['varient'.$val2->item_name])>0) 
                        {   
                            echo '<div class="cart-item"><label for="item'.$val2->id.'">Select Varient</label></div>';
                            echo '<div class="cart-item"><div class="form-group"><select class="form-control" id="item'.$val2->id.'">';
                            //print_r($val2['varient'.$val2->item_name]);   
                            ?>
                            @foreach($val2['varient'.$val2->item_name] as $varient)
                            <option value="{{$varient->id}}" price="{{$varient->price}}" name="{{$varient->name}}">{{$varient->name}}, {{$currency->symbol}}{{$varient->price}}</option>


                            @endforeach
                            <?php                            
                            echo '</select></div></div>
                            <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add Item
                          </div>
                        </div>';
                            
                        }else{?>

                        <div class="cart-item"><span class="addItem">+</span></div>
                        <div class="cart-item"><span class="item-qty"><?php if(isset($cartCookie[$val2->id]) && !empty($cartCookie[$val2->id])) echo $cartCookie[$val2->id]['qty']; else echo '00'; ?></span></div>
                        <div class="cart-item"><span class="removeItem">-</span></div>
                        <!-- <div class="cart-item">
                          <div class="addit btn">
                            <i class="dripicons-cutlery"></i>
                            Add It
                          </div>
                        </div> -->
                       <?php } ?>
                      </div>
                    </div>
                    <div class="pro-button" @if($find_resto->cb_color!='') style="background:{{$find_resto->cb_color}}59" @endif>
                        <div class="item-count <?php if(count($val2['varient'.$val2->item_name])>0){} else{echo "additemcount";} ?>" @if($find_resto->cbt_color!='') style="color:{{$find_resto->cbt_color}}" @endif>+</div>                        
                    </div>

                    <?php } ?>                    
                    @if($val2->image !="")
                    <div class="product-img" <?php if (isset($find_resto->p_img_bg) && $find_resto->p_img_bg == '1') { echo 'style="display:none;"'; } ?> >
                        <img src="{{asset('public/assets/images/item-images/'.$val2->image)}}">
                    </div>
                    @endif
                    <div class="product-detail text-white" style="background: {{$val2->card_color}}; background: -webkit-linear-gradient(to top, {{$val2->card_color}}, transparent); background: linear-gradient(to top, {{$val2->card_color}}, transparent); color:{{$val2->font_color}} !important;">
                        <div class="pro-type" style="@if($val2->item_type=='')display: none; @endif">
                            <div class="@if($val2->item_type == 'veg') veg-product @elseif($val2->item_type == 'non-veg') non-veg-product @endif"></div>
                        </div>
                        <h1>{{$val2->item_name}}</h1>
                      @if($val2->discount_price !="")<span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->discount_price}}</span><span style="margin-left:7px;"><del><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</del></span> @else <span><i class=""><b>{{$currency->symbol}}</b> </i>{{$val2->item_price}}</span>   @endif
                        <p>{{$val2->short_description}}</p>
                    </div>
                </div>
                <?php $j++;   ?>
                </article>
            <?php $count++; ?>
            <?php 
/*              if($count%2==0)
              if($articleClass=="tile-odd")
              {
                $articleClass="tile-even";
              }
              else if($articleClass=="tile-even"){
                $articleClass="tile-odd";
              }
              */
              if($count%4==2 || $count%4==3)
              {
                $itemClass="second-box";
              }
              if($count%4==1 || $count%4==0)
              {
                $itemClass="first-box";
              }

           ?>
           @endforeach
           @endif
          

  <!------>

        
            @endforeach
           
       
        </section>
    </div>
















<?php 
}
?>




    <!--dummy data for testing sub category---->      
    <!-- <div class="grid-button1 cats  Snacks">
        <div class="button-group1 filters-button-group1">
           <button class="button1 is-checked " data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>All</p>
                </div>
            </button>
            <button class="button1  " data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>Masala Dosa</p>
                </div>
            </button>
            <button class="button1" data-filter1=".Snacks">
                <div class="restaurant-list">
                    <p>Plain Dosa</p>
                </div>
            </button>       
     </div>
     </div>   -->

     <!-- <div class="grid-button1 cats Chinese">
        <div class="button-group1 filters-button-group1">
           <button class="button1 is-checked " data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Noodles</p>
                </div>
            </button>
            <button class="button1  " data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Momos</p>
                </div>
            </button>
            <button class="button1" data-filter1=".Chinese">
                <div class="restaurant-list">
                    <p>Ramen</p>
                </div>
            </button>       
     </div>
     </div>   -->


<div class="menu-box">
    <div class="menu-btn">
        <div><i class="fa fa-angle-up"></i></div>
        <div>Menu</div>
        <div><i class="fa fa-angle-down"></i></div>
    </div>

    <div class="menu-items">


@foreach($categories as $val)
<?php $category = $val->category_name;
 $subcategory = 'sub'.$val->category_name;
// echo "<pre>";
// print_r($val->$subcategory);
// die;

 ?>

   <div class="grid-button1 cats subCategory {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}} ">
   <div class="button-group1 filters-button-group1"> 
        @if($val->$subcategory)
        
        @foreach($val->$subcategory as $val1)       
        <button class="button1" data-filter1=".{{str_ireplace($array,'',str_replace(' ','_',$val1->category_name))}}-{{$val1->id}}">
                <div class="restaurant-list">
                <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/category-icon/'.$val1->icon)}}" class="restaurant-img"/>
                    <p>{{$val1->category_name}}</p>
                </div>
            </button>
        @endforeach
     @endif

     </div>
     </div> 
       
     @endforeach  

    <!---------->


    <div class="grid-button">
        <div class="button-group filters-button-group">

            <!-- <button class="button is-checked sub " data-filter="*">
                <div class="restaurant-list">
                        <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/category-icon/all.jpg')}}" class="restaurant-img">

                    <p>All</p>
                    <p></p>
                </div>
            </button> -->
        <?php $i=1;
        ?>
         @foreach($categories as $val)
         <?php $i==1? $active="is-checked":$active=""; ?>
            <button class="button sub {{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}}"  data-filter=".{{str_ireplace($array,'',str_replace(' ','_',$val->category_name))}}-{{$val->id}}">
                <div class="restaurant-list">
                   
                        <img fit="contain" alt="Tiffin Centre" src="{{asset('public/assets/images/category-icon/'.$val->icon)}}" class="restaurant-img"/>
                  
                    <p>{{$val->category_name}}</p>
                    </div>
          </button>
          <?php $i++; ?>
          @endforeach
       
      </div>
  </div>
</div>

</div>    
  <footer class="footer-section"> 
<?php if($find_resto->is_cart_active) { ?>
    <div><a href="<?php echo url()->current(); ?>"><i class="fa fa-home" aria-hidden="true"></i></a></div>
    <!-- <div><a href="#" class="explore-btn" data-toggle="modal"  data-toggle="modal" data-target="#feedbackDialog"><i class="fa fa-comment-alt" aria-hidden="true"></i></a></div> -->
    <!-- <div><a href="#" id="order-details" data-toggle="modal" data-target="#orderDetails"><i class="fa fa-user" aria-hidden="true"></i></a></div> -->
    <div><a href="#" id="order-details"><i class="fa fa-user" aria-hidden="true"></i></a></div>
    <div class="cart-icon"><a href="<?php echo url()->current(); ?>/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{$totalcartCount}}</span></a></div>
<?php }
else{ 
?>  
    <div><a href="#" class="explore-btn" data-toggle="modal"  data-toggle="modal" data-target="#feedbackDialog"><i class="fa fa-comment-alt" aria-hidden="true"></i></a></div>
<?php } ?>
  </footer>

  <!--- <dialog id="dialog" class="dialog"> -->
  <div id="feedbackDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <span class="error"></span>
        <div class="modal-body">
          <!-- <form id="feedback" enctype="multipart/form-data">
            <div class="form-group">
              <input type="hidden" name="res_id" id="res_id" value="{{$find_resto->id}}">
              <label for="recipient-name" class="control-label">Restaurant Name:</label>
              <input type="text" name="restaurant_name" id="restaurant_name" readonly value="{{$find_resto->name}}" class="form-control">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Name:</label>
              <input type="text" name="name" id="name" required class="form-control" id="">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control" id="recipient_name">
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
              <textarea type="text"  id="feedback" name="feedback" class="form-control" required></textarea>
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
              <button type="button" class="btn btn-success" onclick="javascript:Feedback('feedback');" style="margin-right: 10px;">Submit</button>
              <button id="close-modal" class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            </div>                                   
          </form> -->
        <!---feedback-->

          <form id="feedback" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="restaurant_id" value="{{$find_resto->id}}">
            <input type="hidden" name="orderid" id="orderid" value="">
            <div class="form-group">
              <label for="recipient-name" class="control-label">Name:</label>
              <input type="text" name="name" id="name" required class="form-control" id="">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control" id="recipient_name">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" class="form-control" id="recipient_name">
            </div>


<?php 
// print_r($questions);
$q_count=0;
$i = 1;
$c=1;
$time=0;
$q_type="";
$count = count($questions);
foreach($questions as $question){

// $time=$time+$question['time'];

    $questionType =QuestionType($question['question_type_id']);
    $q_type= $questionType;

    if($count==1){
    $num = "q-last";
    }
    else{
    $num = " ";
    }

    if($i == 1){
    $active = "q-active";
    $number = "q-first";
    }
    elseif($i == $count){
    $active = "";
    $number = "q-last";
    }
    else{
    $active = "";
    $number = "";
    }

    if($question['question_type_id']==1)
    {
    ?>
    <div class="form-group">
        <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
        <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
        <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
        <div class="feedback-options">
            <?php  foreach($question['options'] as $val){   ?>
                <div class="radio radio-success form-check-inline">
                    <input type="radio" id="answer-{{$val['id']}}" value="{{$val['id']}}" name="answer_id-{{$question['id']}}">
                    <label for="answer-{{$val['id']}}">{!! html_entity_decode(strip_tags($val['options'])) !!}</label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    } 
    else if($question['question_type_id']==2)
    {
    ?>
    <div class="form-group">
        <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
        <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
        <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
        <div class="feedback-options">
            <?php  foreach($question['options'] as $val){   ?>
                <div class="checkbox checkbox-success form-check-inline">
                    <input type="checkbox" id="answer-{{$val['id']}}" value="{{$val['id']}}" name="answer_id-{{$question['id']}}">
                    <label for="answer-{{$val['id']}}">{!! html_entity_decode(strip_tags($val['options'])) !!}</label>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    }
    else if($question['question_type_id']==3)
    {
    ?>
    <div class="form-group">
      <label for="question_id-{{$question['id']}}" class="control-label">{{$question['question']}}</label>
      <input type="hidden" name="question_id-{{$question['id']}}" value="{{$question['id']}}">
      <input type="hidden" name="question_type_id-{{$question['id']}}" value="{{$question['question_type_id']}}">
      <textarea type="text" id="answer-{{$val['id']}}" name="answer_id-{{$question['id']}}" class="form-control" required></textarea>
    </div>

    <?php
    } 
    ?>



<?php $i++; $c++; 
}
?>

            <input type="hidden" name="rating" id="rating">
            <div class="form-group">
              <label for="recipient-name" class="control-label">File:</label>
              <input type="file" name="file_img" id="file_img" class="" id="recipient_name">
            </div>
            <div class="form-group">
                <label for="stars_form" class="control-label">Give Rating:</label>
                <div id="stars_form">
                  <fieldset class="stars">
                    <input type="radio" name="stars" value="5" id="star1" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star1"></label>
                    <input type="radio" name="stars" value="4" id="star2" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star2"></label>
                    <input type="radio" name="stars" value="3" id="star3" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star3"></label>
                    <input type="radio" name="stars" value="2" id="star4" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star4"></label>
                    <input type="radio" name="stars" value="1" id="star5" ontouchstart="ontouchstart"/>
                    <label class="fa fa-star" for="star5"></label>
<!--                     <input type="radio" name="stars" id="star-reset"/>
                    <label class="reset" for="star-reset">reset</label> -->
                <!--     <figure class="face"><i></i><i></i>
                      <u>
                        <div class="cover"></div>
                      </u>
                    </figure> -->
                  </fieldset>
                </div>
            </div>

            <div class="form-group form_buttons">                               
              <button type="button" class="btn btn-success" id="end-survey" onclick="javascript:Feedback('feedback');" style="margin-right: 10px;">Submit</button>
              <button id="close-modal " class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            </div>                                   
        </form>
        <!---feedback-->

        </div>
        <span id="success" style="display:block; text-align:center;"></span>    
      </div>
    </div>


</div>
<!-- </dialog> -->

<div id="orderDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
       
        <div class="modal-body" id="">

        <div class="col-lg-12 p-5  mb-5">
        <button id="" style="float:right;" class="right btn btn-info close_button" data-dismiss="modal"> Close</button>
            <h1 class="display-4">Order Details</h1>
           
            <!-- Shopping cart table -->
            <div id="details-order">
            
            
            
            </div>
           
        </div>

        </div>
      </div>
    </div>
  </div>
<!--- popup mobile vefication start -->
  <div id="mobileLoginDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">       
        <div class="limiter" style="display:block;">
                <div class="wrap-login100">
                    <form class="login100-form validate-form" id="mobileOtp" enctype="multipart/form-data">
                        <span class="login100-form-logo">
                            <img src="{{URL::asset('public/assets/images/favicon.png')}}">
                        </span>

                        <span class="login100-form-title p-b-34 p-t-27">
                            Sign In
                        </span>
                        <div class="generate_otp">


                
<!--                             <div class="form-group">
                                <label for="mobile_for_otp" class="control-label">Mobile:</label>
                                <input type="number" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" class="input100" placeholder="Enter mobile number to receive otp" >
                            </div> -->

                            <div class="wrap-input100 validate-input" data-validate = "Enter username">
<?php if($currency_code==="inr")
{
    echo '<input class="input100" type="tel" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" placeholder="Enter Mobile Number">';
}
else
{
    echo '<input class="input100" type="tel" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" placeholder="e.g. +1 702 123 4567">';
}
?>
                                <input class="input100" type="hidden" name="validate_mobile_no" id="validate_mobile_no" >
                                <span class="focus-input100"><i class="fa fa-mobile-alt" aria-hidden="true"></i></span>
                            </div> 
                            <span id="mobile_validation"></span>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn" onclick="javascript:generate_otp();">
                                    Generate OTP
                                </button>
                            </div>
                        </div>
                        <div class="verify_otp">
                            <div class="wrap-input100 validate-input otpbox" data-validate="Enter password">
                                <input class="input100" type="text" maxlength="5" name="entered_otp" id="entered_otp" placeholder="OTP">
                                <span class="focus-input100"><i class="fa fa-key" aria-hidden="true"></i></span>                        
                            </div>
                            <a id="resent_otp" class="" href="#" data-count="0">Resend Otp</a>
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn close_button" onclick="javascript:validate_otp();">
                                    Submit
                                </button>
                            </div>
                        </div>
                        <div id="divOuter">
                            <div id="divInner">
                            </div>
                        </div>                    

                    </form>
                </div>
        </div>

<!--         <div class="modal-body">
          <form id="mobileOtp11" enctype="multipart/form-data"> -->
<!--             <div class="generate_otp">


    
              <div class="form-group">
                <label for="mobile_for_otp" class="control-label">Mobile:</label>
                <input type="number" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" class="form-control" placeholder="Enter mobile number to receive otp" ><span id="mobile_validation"></span>
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-success" onclick="javascript:generate_otp();" style="margin-right: 10px;">Generate OTP</button>
              </div>                                   
            </div>
 -->            

 <!--            <div class="verify_otp">
              <div class="form-group">
                <label for="recipient-name" class="control-label">Enter OTP:</label>
                <input type="number" name="entered_otp" id="entered_otp" class="form-control" placeholder="Enter otp received on mobile">
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-info close_button" onclick="javascript:validate_otp();" style="margin-right: 10px;">Submit</button>
                <a id="resent_otp" class="" href="#" data-count="0">Resend Otp</a>
              </div>                                   
            </div> -->                                   
<!--           </form>
        </div> -->
        <span id="success" style="display:block; text-align:center;"></span>
        <button id="clsOtpModal" style="display: none;" class="right" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
<!--- popup mobile vefication end-->

  
<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
<script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>
<?php if($currency_code!=="inr")
{
?>
<script src="{{URL::asset('public/assets/js/intlTelInput.js')}}"></script>
<?php 
}
?>


     
   
<script>

var uqid='<?php echo $url;?>';

$(document).ready(function() {
<?php if($currency_code!=="inr")
{
    echo '  $("#mobile_for_otp").intlTelInput();';
}
?>



  var owl = $('.owl-carousel');
  owl.owlCarousel({
    margin: 10,
    nav: true,
    loop: true,
    dots: false,
    nav: false,
    autoplay:true,
    autoplayTimeout:3000,
    // autoplayHoverPause:true

    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 1
      }
    }
  })
})



$( function() {

  $('#details-order').on( 'click', '.feedback_order', function(){
    var ord_id = $(this).attr('data-orderId');
    $('#orderid').val(ord_id);
    $('#orderDetails').modal('hide');
    //$("#feedbackDialog").load(location.href + " #feedbackDialog");
    $('#feedbackDialog').modal('show');
   

});



  $('.subCategory').hide();

  $('.sub').click(function(){
    var subFilter = $(this).attr('data-filter');
   // $('.sub-cat').fadeIn().delay(1000).fadeOut();
    $('.cats').removeClass('activated');
    $(subFilter).addClass('activated');

    //$('.activated').css('display','block');
  //  var t ='.subCategory';
   // $('.subCategory'+ subFilter +'').fadeIn().next().delay(10000).fadeOut(); 
   //  $('.subCategory').removeClass('visible');
   if($('.subCategory'+ subFilter +'').hasClass('visible')){
      $('.subCategory'+ subFilter +'').hide();
      $('.subCategory'+ subFilter +'').removeClass('visible');
   }
   else{
    $('.subCategory').hide();
    $('.subCategory').removeClass('visible');
    $('.subCategory'+ subFilter +'').addClass('visible');
    $('.subCategory'+ subFilter +'').show();
   
   }
  });


  var $grid = $('.grid').isotope({
    itemSelector: 'article'
  });

  // filter buttons
  $('.filters-button-group').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter');
    var itc = 1;
    var itemClass="first-box";
    $("article"+filterValue).each(function(){
      $(this).children().removeClass('second-box');
      $(this).children().removeClass('first-box');
      $(this).children().addClass(itemClass);
      itc++;
      if(itc%4==2 || itc%4==3)
      {
        itemClass="second-box";
      }
      if(itc%4==1 || itc%4==0)
      {
        itemClass="first-box";
      }
    });

    $grid.isotope({ filter: filterValue });
  });
  
  //for sub category///
  $('.filters-button-group1').on( 'click', 'button', function() {
    var filterValue = $(this).attr('data-filter1');
    var itc = 1;
    var itemClass="first-box";
    $("article"+filterValue).each(function(){
      $(this).children().removeClass('second-box');
      $(this).children().removeClass('first-box');
      $(this).children().addClass(itemClass);
      itc++;
      if(itc%4==2 || itc%4==3)
      {
        itemClass="second-box";
      }
      if(itc%4==1 || itc%4==0)
      {
        itemClass="first-box";
      }
    });

    $grid.isotope({ filter: filterValue });
  });


  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });

  //////for sub category////
  $('.button-group1').each( function( i, buttonGroup1 ) {
    var $buttonGroup1 = $( buttonGroup1 );
    $buttonGroup1.on( 'click', 'button', function() {
      $buttonGroup1.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });
});

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    timeout = setTimeout( delayed, threshold || 100 );
  }
}

$(window).bind("load", function() {
  $('#all').click();
});


/*************slider***********/




/*************Popup***********/

//Function To Display Popup

$(document).ready(function(){


<?php 
if (isset($find_resto->img_menu) && $find_resto->img_menu == '3')
{
?>
$('.ingredient-info').click(function(){
  var b =  $(this).attr('data-class');
  $('.'+b+'').css("display","block")
  //document.getElementById(b).style.display = "block";
});

<?php 
}
else{
?>
$('.box-category').click(function(){
  var b =  $(this).attr('data-class');
  $('.'+b+'').css("display","block")
  //document.getElementById(b).style.display = "block";
});
<?php 
}
?>
 
  

$('.close').click(function(){
  var b =  $(this).attr('data-class');
  
  $('.'+b+'').css("display","none")
  //document.getElementById(b).style.display = "block";
});

$('#grid-container').css('margin-bottom',($('.footer-section').outerHeight() + $('.grid-button').outerHeight()+60));
//$('.buttton').css('flex-direction','unset');

});
function div_show() {
    $(document).ready(function(){
       // console.log($(this).attr('data-class'));
    })
  
  }
  //Function to Hide Popup
  function div_hide(){
  document.getElementById('pop').style.display = "none";
  }


</script>

<script>
function searchItems() {
  // Declare variables
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('myInput');
  filter = input.value.toUpperCase();
  ul = document.getElementById("grid-container");
  li = ul.getElementsByTagName('article');

  // Loop through all list items, and hide those who don't match the search query
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
      li[i].classList.add("mystyle");


    } else {
      li[i].style.display = "none";
      li[i].classList.remove("mystyle");
    }
  }
    var $grid = $('.grid').isotope({
    itemSelector: 'article.mystyle'
    });  
}
</script>


<script>
var dailog = document.getElementById("dialog"); 
function openModal() { 
      dailog.showModal();
  
} 

function closeModal() { 
  
    dailog.close(); 

} 


function Feedback(form) {
      var name =$('#name').val();
      var email =$('#email').val();
      var mobile =$('#mobile').val();
      var feedback =$('textarea#feedback').val();

  if(name ==""){
    var error1 = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert"></button>' +
                    '<strong>Name is required</strong>' +
                    '</div>';
                $('.error').html(error1);
    return false;
  }
      var send_data = new FormData($('#feedback')[0]);
     //  send_data.append('restaurant_name',$("#restaurant_name").val());
      // send_data.append('name',$("#name").val());
       var res_name =$('#restaurant_name').val();
       var rating =$('#rating').val();
       var id=$('#res_id').val();
       var file =$('#file_img')[0].files[0];
    
    
      $.ajax({
             headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
            type: "POST",
            url: "{{url('/feedback')}}",           
          //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
           data:send_data,
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data);
             if(data.status == 'success'){
              $('#success').text("Thanks! For Your Feedback"); 
             setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); }, 1000);
             setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); $('#feedbackDialog').modal('hide'); location.reload();  }, 3000);
             }
              
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });

}

</script>
<script>

$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      $('#rating').val(ratingValue);
    var msg = "";
    if (ratingValue > 1) {
        msg = "";
    }
    else {
        msg = "";
    }
    responseMessage(msg);
    
  });
  /*
  var wd= $(window).width();
  $('.button.sub').each(function(){
  alert(wd);
    $(this).css('width', (wd*22/100)+'px !important');
  } );
  */  
  $('.pro-button').click(function() {
    $('.addbtnoverlay').hide();
    $(this).parent().children('.addbtnoverlay').show();
    //$(this).prev().prev().hide();
    return false;

  });
  $('.addCardOverlay').click(function() {
    return false;
  });

  

    $('.addbtnoverlay .cls').click(function() {
        $(this).parent().hide();
        var ct = $(this).parent().prev().text();
//       console.log(ct);
   //     console.log(typeof ct);
        if(ct=='0' || ct.trim()==''){
        	$(this).parent().prev().hide();
        }
        else{
        	$(this).parent().prev().show();
        }
        return false;
    });

    $('.addit').click(function(){
        var itemDetail = $(this).parent().parent();
        var itemId= itemDetail.data('itemid');
        var itemName= itemDetail.data('itemname');
        var itemType= itemDetail.data('itemtype');
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        var selectOption = itemDetail.find('select');
        //alert(itemDetail.find('select').val());
        var varientId = itemDetail.find('select').val();
        var name = $('option:selected', selectOption).attr('name');
        var price = $('option:selected', selectOption).attr('price');
//        alert(name);
  //      alert(price);
        var quantity = 1;
        addItemVarient(itemId,itemName,itemType,itemPrice,varientId,name,price,quantity,itemImage);
    


        var tt= itemDetail.data('tt');  /*triger type*/ 

        if(tt=='overlay')
        {
            var com_id= itemDetail.attr('id');
            // alert(com_id)
        }
        else if(tt=='popup')
        {
            var com_id= itemDetail.data('id'); 
            // alert(com_id);           
        }

//        var itemQty= $(this).parent().parent().parent().prev().text();
        var itemQty= $('#'+com_id).parent().prev().text();

        itemQty=itemQty.trim();
        if(itemQty==''){
            itemQty=0;    
        }
        itemQty=parseInt(itemQty)+1;
        $('#'+com_id).parent().prev().text(itemQty);

        if(itemQty==0){
            $('#'+com_id).parent().prev().hide();
        }
        else{
            $('#'+com_id).parent().prev().show();
        }

    });

	$('.additemcount').click(function(){
		var itemQty= $(this).parent().prev().find('.item-qty').text();
		// alert(itemQty);
        var itemDetail = $(this).parent().prev().find('.addCardOverlay');
        var itemId= itemDetail.data('itemid');
        var itemName= itemDetail.data('itemname');
        var itemType= itemDetail.data('itemtype');
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        addItem(itemId,itemName,itemType,itemPrice,itemImage);
		itemQty=parseInt(itemQty)+1;
		var	itemQty1 = pad_with_zeroes(itemQty, 2);
		// alert(itemQty1);
		$(this).parent().prev().prev().text(itemQty);
        $(this).parent().prev().find('.item-qty').text(itemQty1);


        var tt= itemDetail.data('tt');  /*triger type*/ 
        if(tt=='overlay')
        {
            var com_id= itemDetail.attr('id');
            $('.'+com_id).find('.item-qty').text(itemQty1);
        }
        else if(tt=='popup')
        {
            var com_id= itemDetail.data('id'); 
            $('#'+com_id).find('.item-qty').text(itemQty1);           
        }


        if(itemQty==0){
            $(this).parent().prev().prev().hide();
        }
        else{
            $(this).parent().prev().prev().show();
        }

	});

    $('.addItem').click(function(){
        var itemDetail = $(this).parent().parent();
        var itemId= itemDetail.data('itemid');
        var itemName= itemDetail.data('itemname');
        var itemType= itemDetail.data('itemtype');
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        addItem(itemId,itemName,itemType,itemPrice,itemImage);



        var itemQty= $(this).parent().next().children().text();

        itemQty=parseInt(itemQty)+1;
        var itemQty1 = pad_with_zeroes(itemQty, 2);

        var tt= itemDetail.data('tt');  /*triger type*/ 
        if(tt=='overlay')
        {
            var com_id= itemDetail.attr('id');
//            $('.'+com_id).children().next().children().text(itemQty1);
            $('.'+com_id).find('.item-qty').text(itemQty1);

        }
        else if(tt=='popup')
        {
            var com_id= itemDetail.data('id'); 
            $('#'+com_id).find('.item-qty').text(itemQty1);           
        }
        $(this).parent().next().children().text(itemQty1);
        
        $('#'+com_id).parent().prev().text(itemQty);

        if(itemQty==0){
            $('#'+com_id).parent().prev().hide();
        }
        else{
            $('#'+com_id).parent().prev().show();
        }   
    });
	$('.removeItem').click(function(){
		var itemQty= $(this).parent().prev().children().text();

        var itemDetail = $(this).parent().parent();
        var itemId= itemDetail.data('itemid');
        var itemName= itemDetail.data('itemname');
        var itemType= itemDetail.data('itemtype');
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        removeItem(itemId,itemName,itemType,itemPrice,itemImage)
		// alert(itemQty);


        var tt= itemDetail.data('tt');  /*triger type*/ 


		if(parseInt(itemQty)!=0)
		{
			itemQty=parseInt(itemQty)-1;
			// alert(itemQty);
			var	itemQty1 = pad_with_zeroes(itemQty, 2)
			// alert(itemQty1);
			
            if(tt=='overlay')
            {
                var com_id= itemDetail.attr('id');
                $('.'+com_id).find('.item-qty').text(itemQty1);
                $(this).parent().prev().children().text(itemQty1);

            }
            else if(tt=='popup')
            {
                var com_id= itemDetail.data('id'); 
                $('#'+com_id).find('.item-qty').text(itemQty1);           
                $(this).parent().prev().children().text(itemQty1);
            }


//			$(this).parent().prev().children().text(itemQty1);

            $('#'+com_id).parent().prev().text(itemQty);
		}
		else{
			$('#'+com_id).parent().prev().text('0');

		}

        if(itemQty==0){
            $('#'+com_id).parent().prev().hide();
        }
        else{
            $('#'+com_id).parent().prev().show();
        }
	});

});
/*	$(document).ready(function() {
         function disablePrev() { window.history.forward() }
         window.onload = disablePrev();
         window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });
*/

//    window.onbeforeunload = function() { return "Your work will be lost."; };
function pad_with_zeroes(number, length) {

    var my_string = '' + number;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }
    return my_string;
}

function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}



//var arval =  [['Work', 9], ['Eat', 2], ['Commute', 2], ['Play Game', 2], ['Sleep', 7] ];
// alert(uqid);
var cartArr={};
var cartdetails={};
var resID=document.getElementById('restro_id').value;
var tabID=document.getElementById('table_id').value;

//cm_createCookie('qcart4',JSON.stringify({}),1);
//cartdetails=cm_readCookie('qcart1');
//cartdetails3=cm_readCookie('qcart3');
//cartdetails4=cm_readCookie('qcart4');
//console.log(cartdetails);
//console.log(cartdetails3);
//console.log(cartdetails4);
cartArr['details']={
    restaurant_id:resID,
    table_id:tabID
};

var qcartDetails=JSON.parse(cm_readCookie('qcart1'));
<?php 
if(isset($_REQUEST['dt']) && $_REQUEST['dt']!='')
{
    // echo "cm_createCookie('qcart1',JSON.stringify({}),0.25);";
}

?>

if(qcartDetails===null)
{
    qcartDetails={
        '<?php echo $url;?>':{  
            restaurant_id:resID,
            table_id:tabID,
            home_url:'<?php echo url()->current();?>'
<?php
    if(isset($_REQUEST['dt']))
        echo ", dt:"."'".$_REQUEST['dt']."'";
?>
<?php
    if(isset($_REQUEST['cn']))
        echo ", cn:"."'".$_REQUEST['cn']."'";
?>
<?php
    if(isset($_REQUEST['an']))
        echo ", an:"."'".$_REQUEST['an']."'";
?>
        }
    };
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
else if(!qcartDetails[uqid])
{
    qcartDetails[uqid]={          
            restaurant_id:resID,
            table_id:tabID,
            home_url:'<?php echo url()->current();?>'
<?php
    if(isset($_REQUEST['dt']))
        echo ", dt:"."'".$_REQUEST['dt']."'";
?>
<?php
    if(isset($_REQUEST['cn']))
        echo ", cn:"."'".$_REQUEST['cn']."'";
?>
<?php
    if(isset($_REQUEST['an']))
        echo ", an:"."'".$_REQUEST['an']."'";
?>

    }
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
else if(qcartDetails[uqid]['mobile'])
{
   // console.log('email');
    $('#mobile').val(qcartDetails[uqid]['mobile']);
    $('#name').val(qcartDetails[uqid]['fullname']);
    qcartDetails[uqid]['restaurant_id']=resID;
    qcartDetails[uqid]['table_id']=tabID;
    qcartDetails[uqid]['home_url']='<?php echo url()->current();?>';
<?php
    if(isset($_REQUEST['dt']))
        echo "qcartDetails[uqid]['dt']='".$_REQUEST['dt']."';";

?>
<?php
    if(isset($_REQUEST['cn']))
        echo "qcartDetails[uqid]['cn']='".$_REQUEST['cn']."';";

?>
<?php
    if(isset($_REQUEST['an']))
        echo "qcartDetails[uqid]['an']='".$_REQUEST['an']."';";
?>


    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
var qcartDetails=JSON.parse( cm_readCookie('qcart1'));
/*
if(qcartDetails===null)
{
    qcartDetails={

      details:{  
        restaurant_id:13,
        table_id:0,
        home_url:'http://localhost/restaurant/qrestro/fca6662b'
      }
    };
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
*/

var qcart1=cm_readCookie('qcart1');
console.log(qcart1);

//console.log(cartdetails);

var arval = { 
    a:{
        item: "Product 1",
        price: 35.50,
        qty: 2
    },
    b:{
        item: "Product 2",
        price: 50,
        qty: 5
    }
};
arval['c']={
        item: "Product 3",
        price: 60,
        qty: 7
    };
//sessionStorage.setItem( "total", 120 );
//cm_createCookie('qcart',JSON.stringify(arval),10);


//sessionStorage.setItem( "qcart",JSON.stringify(arval));

//var cartValue = sessionStorage.getItem( "qcart" );
//var cartObj = JSON.parse( cartValue );

function cm_readCookie(name) 
{
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
};

function addItemVarient(itemId,itemName,itemType,itemPrice,varientId,name,price,quantity,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                itype:itemType,
                                varientId:{}                         
                            }
        cartArr[itemId]['varientId'][varientId] = {
                                    varientName:name,
                                    varientPrice:price,
                                    varientQuantity:quantity
                                }
                                // alert(' null cart');
        cm_createCookie(uqid,JSON.stringify(cartArr),0.020);
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =   {
                                    item: itemName,
                                    price:itemPrice,
                                    image:itemImage,
                                    itype:itemType,
                                    varientId:{}                        
                                }
            cart[itemId]['varientId'][varientId] = {
                                        varientName:name,
                                        varientPrice:price,
                                        varientQuantity:quantity
                                    }
            // alert('add varient to cart without item');
        }
        else if(!cart[itemId]['varientId'][varientId]) {
            cart[itemId]['varientId'][varientId] = {
                                        varientName:name,
                                        varientPrice:price,
                                        varientQuantity:quantity
                                    }

            // alert('add varient to cart existing item');    
        }
        else{
            // cart[itemId]['varientId'][varientId] = {
            //                             varientName:name,
            //                             varientPrice:price,
            //                             varientQuantity:quantity
            //                         }
            cart[itemId]['varientId'][varientId]['varientQuantity']=cart[itemId]['varientId'][varientId]['varientQuantity']+1;
            // alert('add qty in varient to cart existing item');
        }
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        cm_createCookie(uqid,JSON.stringify(cart),0.020);
        console.log(cart);
    }

}

function addItem(itemId,itemName,itemType,itemPrice,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                itype:itemType,
                                qty: 1
                            }
        cm_createCookie(uqid,JSON.stringify(cartArr),0.020);
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =  {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                itype:itemType,
                                qty: 1
                            }
        }
        else{
            cart[itemId]['qty']=cart[itemId]['qty']+1;
        }
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        cm_createCookie(uqid,JSON.stringify(cart),0.020);
        console.log(cart);
    }
}

function removeItem(itemId,itemName,itemType,itemPrice,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    console.log(typeof cart);
    if(cart===null)
    {
    }
    else{
        cart[itemId]['qty']=cart[itemId]['qty']-1;
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())-1);

        if(cart[itemId]['qty']==0)
        {
            delete cart[itemId];
            // delete cart[4];
        }
        cm_createCookie(uqid,JSON.stringify(cart),0.020);
        console.log(cart);
    }    
}

function cm_createCookie(name, value, days) 
{
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
    //cartUpdate(value);
    //mobileVerification('8010013798');
};

window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                         ( typeof window.performance != "undefined" && 
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});

function cartUpdate(cartdata){
     var send_data=new FormData();
     send_data.append('cartdata',cartdata);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/cartupdate')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        dataType: 'json',
        success: function(data){
            console.log(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
});

}


function mobileVerification(mobileNo){
     var send_data=new FormData();
     send_data.append('mob',mobileNo);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/otp')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        dataType: 'json',
        success: function(data){
            console.log(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

}
console.log(document.cookie);
//console.log(<?php //print_r(json_decode($_COOKIE[$url],true)); ?>);
//console.log(cartObj);
//alert(cartObj['c']['item']);

</script>
<?php
$cookie_name = "user";
$cookie_value = "John Doe";
// setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>
<?php //print_r($_COOKIE); ?>
<?php 

// $cartCookie=json_decode($_COOKIE[$url],true);
// print_r($cartCookie); 
// $cartCookie['mobile_no']= "8010013798";
// $cartCookie['cart_id']= "dwed7414ddss";
// unset($cartCookie['mobile_no']);
// unset($cartCookie['cart_id']);
// setcookie($url, '', time() + (86400 * 30), "/"); // 86400 = 1 day
// $cartCookie=json_decode($_COOKIE[$url],true);
// print_r($cartCookie); 

 ?>
<?php //($_COOKIE[$url]); ?>
<script>
$(function(){

  $("#order-details").click(function(){
     

    var cartdetails = JSON.parse(cm_readCookie('qcart1'));
    var mobile ="8826126514";
    var mobile ="8010013798";
   // var id_res =

    // var mobile =cartdetails[uqid]['mobile'];
    // alert(cartdetails);
    if(cartdetails[uqid]['mobile'])
    {
        mobile=cartdetails[uqid]['mobile'];
        get_orders(mobile,tabID,resID);
        $('#orderDetails').modal('show');

    }
    else
    {
//    var mobile ="0000000000";
        $('#mobileLoginDialog').modal('show');
                 
    }
/**
    var send_data=new FormData();
    send_data.append('mobile',mobile);
    send_data.append('table_id',tabID);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/order-details')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(data){
            //console.log(data);
            $('#details-order').html(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });
*/
  });

});

function get_orders(mobile,tabID,resID)
{
    var send_data=new FormData();
    send_data.append('mobile',mobile);
    send_data.append('table_id',tabID);
    send_data.append('res_id',resID);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/order-details')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(data){
            //console.log(data);
            $('#details-order').html(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });
}

function check()
{
    // alert();
    var mobile_number = document.getElementById('mobile_for_otp');
    var message = document.getElementById('mobile_validation');

    var goodColor = "#0C6";
    var badColor = "#fefefe";
    // alert(mobile_number.value);

    <?php if($currency_code!=="inr")
    {
    ?>

      if(mobile_number.value.length < 10 || mobile_number.value.length > 15 ){
        // mobile_number.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.style.display = 'block';
        message.innerHTML = "Phone Number should be 10-15 digits including country code!"
        mobile_number.style.borderColor = badColor;
        mobile_number.focus();
        return false;
      }
      else{
        message.style.display = 'none';
        mobile_number.style.borderColor = goodColor;
        return true;
      }

    <?php
    }
    else
    {
    ?>
      if(mobile_number.value.length != 10 ){
        // mobile_number.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.style.display = 'block';
        message.innerHTML = "Phone Number should be 10 digits!"
        mobile_number.style.borderColor = badColor;
        mobile_number.focus();
        return false;
      }
      else{
        message.style.display = 'none';
        mobile_number.style.borderColor = goodColor;
        return true;
      }
    <?php

    }
    ?>

}

$('#mobileOtp').submit(function(){
    return false;
})

function generate_otp(){

// alert($('#mobile_for_otp').val())
  if(check())
  {

    <?php if($currency_code!=="inr")
    {
    ?>
    var mobNum=$('#mobile_for_otp').val();
    <?php
    }
    else
    {
    ?>
    var mobNum='+91 ' + $('#mobile_for_otp').val();
    <?php
    }
    ?>

    mobileVerification(mobNum);
  }
  
  return false;
}

function mobileVerification(mobileNo){
  var send_data=new FormData();
  send_data.append('mob',mobileNo);

  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
      type: "POST",
      url: "{{url('/otp')}}",           
    //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
      data:send_data,
      async: false,
      dataType: 'json',
      success: function(data){
          console.log(data);
          $('.generate_otp').hide();
          $('.verify_otp').show();
          pas=data.otp;
          $('#validate_mobile_no').val(data.mobile_no);


      },
      cache: false,
      enctype: 'multipart/form-data',
      contentType: false,
      processData: false
  });

}
jQuery('#resent_otp').click(function(){
  generate_otp();
});


function validate_otp(){
    var op= $('#entered_otp').val();
    var mobile_number= $('#validate_mobile_no').val();
    var tabID=document.getElementById('table_id').value;
    var resID=document.getElementById('restro_id').value;
    if(op==pas)
    { 
        get_details(mobile_number); 
        var cartdetails = JSON.parse(cm_readCookie('qcart1'));
        cartdetails[uqid]['mobile']= mobile_number;
        cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
        $('#clsOtpModal').trigger('click');
        get_orders(mobile_number,tabID,resID); 
        $('#orderDetails').modal('show');
        // console.log(cartdetails);

    }
    else{
        alert('OTP does not match.');
    }
    return false;
}


function get_details(mobile)
{
    var send_data=new FormData();
    send_data.append('mobile',mobile);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: "{{url('/get-details')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(data){
            var cartdetails = JSON.parse(cm_readCookie('qcart1'));
            cartdetails[uqid]['mobile']= mobile;
            cartdetails[uqid]['fullname']= data.name;
            cartdetails[uqid]['delivery_address']= data.address;
            cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
        },
        cache: true,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

} 


</script>

<script>
  

</script>

<script>

  $(document).ready(function(){

   var qt =$('.q-btn-wrap').attr('data-count');
    var ct ='<?php ?>';

  $('#close-modal').hide();

$('.start-survey').click(function(event) {
    
    event.preventDefault();
    $(".survey-wrap").css({"margin-left": ""});
    startQuiz();
    $('.survey-wrapnew').show();
   
});


$('.survey-end').hide();
$('.end-survey').click(function(event) {
    finishQuiz();
     // $("#test_form").submit();

    // var send_data = new FormData($('#test_form')[0]);
    var send_data = new FormData($('#formdata')[0]);
    
    $.ajax({
             headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
            type: "POST",
            url: "{{url('/questionform-data')}}",           
          //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
           data:send_data,
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data);
             if(data.status == 'success'){
              $('.end-survey').hide();
              $('.go-back').hide();
              $('#close-modal').show();
              $('.tnk').html('Thank you for feedback!');
              setTimeout(function(){ $('#test_form')[0].reset(); location.reload()}, 4000);
            //  $('#success').text("Thanks! For Your Feedback"); 
           //  setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); }, 1000);
           //  setTimeout(function(){ $('#success').text("Thanks! For Your Feedback"); dailog.close(); location.reload();  }, 3000);
             }
              
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });





      
});

$('.go-back').click(function() {
    $('.survey-end').hide();
    $(".select_check1").trigger('click'); 
    $(".survey-questions").css({"display": ""});
    $(".questions").css({"display": ""});
    $(".br").removeClass('q-active1');

    startQuiz();
    $('.q-btn').show();
    $('.timernew').show();
    $(".survey-wrap").show();
    $('.survey-exit').hide();
    $('.survey-wrapnew').show();
    $('.questions').show();
   
});



$('.survey-wrapnew').hide();


$('.button5').click(function() {

 //$('.question.q-active').removeClass('q-active').addClass('q-active');
 //$('.question')
 if($('.question').hasClass('q-active')){
    $('.question').removeClass('q-active');
    $('.button5').removeClass('q-active1');
    $('.button5').removeClass('lapColor');
 }
//$(this).addClass('q-active2');

var get_class = $(this).attr("data-class");
var lap_check=$(this).attr('lap-check');
$('.' + get_class).addClass('q-active');

$('.' + lap_check).addClass('lapColor');
$('.' + lap_check).addClass('q-active1');


});


$('.button5').click(function() {

var btn_check12=$('.q-active1').attr('data-class');
var split_lap=btn_check12.split('p');
var lap12=split_lap[1];
var next_valuebtn=$('.q-btn-wrap').attr('data-count');


if(next_valuebtn == lap12){
    $('.q-btn').text('Submit');

}else{
    $('.q-btn').text('Next');
}

});

$('.lap_change').click(function(event) {
    event.preventDefault();
   var t=$('.button5').attr('lap-check');
  
});


$('.q-btn').click(function(event) {
    event.preventDefault();
    nextQuestion();
});

$('.q-btn.skip').click(function(event) {
    event.preventDefault();
    nextQuestionSkip();
});



$('.q-btn-ans').click(function() {
    
   // alert();
     var btn1=$(this).attr('data-count');
   
    if ($('.question').hasClass('q-active')) {
        var lap_take1=$('.q-active').attr('data-class');
        var split_var1=lap_take1.split('p');
             
        var lap_value1=split_var1[1];
        if(btn1-1 == lap_value1){
            $('.q-btn-ans').text('Finish');       
        }else{
             $('.q-btn-ans').text('Next');
         }

    } 
    
    
    
    
    nextAnswer();
});



$('.question').on('change', 'input', function() {
    $('.question.q-active .ans-wrap').removeClass("ans-selected");
    $(this).parent().addClass("ans-selected");
    if($(this).parent().hasClass('ans-selected')){
        var attr=$(this).parent().attr('checked_data');
         $('.'+attr).addClass('selected_color');
    }

    
});



function startQuiz() {
    $("#q-loader").show();
    setTimeout(function() {
        $('.survey-intro').hide();
        $("#q-loader").hide();
        $('.survey-questions').show();
    }, 0);
}


function nextQuestion() {
   // if ($('.question.q-active .ans').is(':checked')) {
        $("#q-loader").show();
        $('.button5').removeClass('lapColor');
        setTimeout(function() {
            $("#q-loader").hide();
            $('.question.q-active').removeClass('q-active').next().addClass('q-active');
            $('.q-active1').removeClass('q-active1').next().addClass('q-active1');
            //var check=$('')

        }, 500);
        
        
          $(".q-btn-wrap").click(function(){
           var btn=$('.q-btn-wrap').attr('data-count');
            if ($('.question').hasClass('q-active')) {
              
              //  var next_value=$('.q_btn').attr('data-count');
               var lap_take=$('.q-active').attr('data-class');
              // alert(lap_take);
              var split_var=lap_take.split('p');
             
              var lap_value=split_var[1];
              if(btn-1 == lap_value){
                  $('.q-btn').text('Submit');
              }else{
                $('.q-btn').text('Next');
              }
                }
            });

    if ($('.question.q-last').hasClass('q-active')) {
        $('.survey-wrapnew').hide();
         $('.survey-end').show();
      $('.q-btn').hide();
      $('.timernew').hide();
       
        
    } 
}



function nextAnswer() {
        $("#q-loader").show();
        setTimeout(function() {
            $("#q-loader").hide();
            $('.question.q-active').removeClass('q-active').next().addClass('q-active');

        }, 200);

        if ($('.question.q-last').hasClass("q-active")){
            //  $("#test_form").submit();
              finishQuiz();
              $("#alert1").hide();
              $("#status_ques").hide();
           //  alert();
          }
}

function finishQuiz() {
    $("#q-loader").show();
    setTimeout(function() {
        $('.survey-questions').hide();
        $("#q-loader").hide();
        $('.survey-exit').show();
    }, 100);
}


});
</script>
<script type="text/javascript">
var obj = document.getElementById('entered_otp');
obj.addEventListener('keydown', stopCarret); 
obj.addEventListener('keypress', stopCarret); 
obj.addEventListener('keyup', stopCarret); 

function stopCarret() {
    if (obj.value.length > 4){
        setCaretPosition(obj, 0);
    }
}

function setCaretPosition(elem, caretPos) {
    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            else
                elem.focus();
        }
    }
}


$('.menu-btn').on('click',function(e){
    $(this).toggleClass('active')
    $('.menu-items').toggleClass('active')
    // if(!$(this).hasClass('active'))
    // {
    //     $('.grid-button').hide()
    // }
    // else{
    //     $('.grid-button').show()
    // }
});


<?php if(isset($wapp))
{
?>

//testwhatapp();

/* function testwhatapp()
{
    var send_data=new FormData();
    send_data.append('channel','whatsapp');
    send_data.append('destination','919716076512');
    send_data.append('source','917838411114');
    send_data.append('src.name','qrestroapp');
    send_data.append('message','Hello');

    // send_data.append('message',{ "isHSM":"false",
    //     "type": "text",
    //     "text":"Hello"});

    $.ajax({
        headers: {
            // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            // 'Cache-Control': 'no-cache',
            'Content-Type': 'application/x-www-form-urlencoded',
            'apikey': 'd0fb0073a14c46a4c67f2dc7f34e2a5f'
        },
        type: "POST",
        url: "https://api.gupshup.io/sm/api/v1/msg",
        data:send_data,
        async: false,
        dataType: 'json',
        success: function(data){
            console.log(data);
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });
}
*/

/*
function testwhatapp_1()
{
    // var send_data=new FormData();
    // send_data.append('channel','whatsapp');
    // send_data.append('destination','919716076512');
    // send_data.append('source','917384811114');
    // send_data.append('src.name','qrestroapp');
    // send_data.append('message','Hello');


    var send_data={          
            'channel':'whatsapp',
            'destination':'919716076512',
            'source':'917384811114',
            'src.name':'qrestroapp',
            'message':'Hello'
        };



    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json',
            'apikey': 'd0fb0073a14c46a4c67f2dc7f34e2a5f'

        },
        type: "POST",
        url: "https://api.gupshup.io/sm/api/v1/msg",
        data:send_data,
        async: true,
        dataType: 'text',
        success: function(data){
            console.log(data);
        },
        // cache: false,
        // enctype: 'multipart/form-data',
        // contentType: false,
        // processData: false
    });
}
*/


<?php
}
?>
</script>


</body>
</html>
<?php 
}
else{
?>    

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Qrestro.com - {{$find_resto->name}}</title>
    <link href="{{URL::asset('public/assets/images/favicon.png')}}" rel="icon" />
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="assets/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/slick/slick-theme.css"> -->
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('public/assets/user/owlcarousel/assets/owl.theme.default.min.css')}}">

    <link href="{{asset('public/assets/css/custom.css?v=1')}}" rel="stylesheet">

    <!-- <script src="{{asset('public/assets/js/custom_quiz.js')}}"></script> -->
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

    <style></style>
</head>
<body>

<div  class="container-fluid">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-lg-5 col-md-12 col-sm-12 invoice">
                <div class="center-text">
                    <div class="res_logo"></div>
                    <h4 class="res_name">Only accessible in mobile browser. Please open it in mobile.</h4>
                </div>

                <hr>                
            </div>
        </div>          
    </div>
</div>

</body>
</html>
<?php 
}
?>