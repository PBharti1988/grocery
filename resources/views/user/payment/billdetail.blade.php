<?php $cartCookie; 
// setcookie('qcart2', '', time() + (86400 * 30), "/"); // 86400 = 1 day
if(isset($_COOKIE[$url])) 
    $cartCookie=json_decode($_COOKIE[$url],true);  // print_r($cartCookie); 
$totalcartCount=0;
// print_r($url);
 // print_r($cartCookie);
 // die;
?>
<?php $subtotal=0.00;
$tax=0.00;
$total=0.00; ?>
<?php $ruppeeSign=$currency_symbol; ?>
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

    <style>
        .discount_section{
            display: none;
        }
        .discount_section.active{
            display: table-row;
        }
        #apply_cpn{
            margin-top: 24px;
        }
        #paythebill{
            /*margin: 10px auto;*/
            margin: 10px;
        }
    </style>
</head>
<body>

<?php $array= array('(',')','+','@','-','[',']','{','}','!','/','<','>','?','&','%','^','*','$','-','=','|'); ?>

    <div class="top-header"></div>
      
      <?php
//dd($find_resto);
       ?>
    <div class="grid-section">
        <!-- <div class="logo" ><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>     -->
        <h1 class="text-white">{{$find_resto->name}}</h1>    
        <input type="hidden" name="restro_id" class="restro_id"  id="restro_id" value="{{$find_resto->id}}">
        <?php if($find_table){ ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="{{$find_table->id}}">
        <?php } else { ?>
        <input type="hidden" name="table_id" class="table_id"  id="table_id" value="0">
        <?php }?>



<?php  // dd($orders);?>


    <div class="container" id="bill_preview">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <button class="btn btn-info" onclick="print_bill()">Print Bill</button>
                        <p></p>
                        <div id="print_bill">
                            <h4 class="card-title"> <span>Bill Number: {{$billdetails->bill_number}}</span> 

                                <div style="float: right;">                            
                                    <?php
                                        if(isset($billdetails->id))
                                        {
                                            echo '<span>Order No: '.$billdetails->order_number . '</span>';
                                        }
                                    ?>
                                </div>
                            </h4>
                            <?php
                                if(isset($billdetails->id))
                                {
                                    echo '<p class="billdetail_strip"><span>Store Name: '.$billdetails->table_name . '</span> <span style="float: right;"> Bill Date: '.date("M d, Y h:i a", strtotime(cnvt_UTC_to_usrTime($billdetails->created_at,'Asia/Kolkata'))) . '</span></p>';
                                    echo '<div style="float: none;clear:both;"></div>';

                                }
                            ?>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
        <!--                                     <th>Order No</th>
                                            <th>Table</th> -->
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>                                
                                            <th>Price (<?php echo $ruppeeSign;?>)</th>                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $customer_name='';
                              if (isset($_REQUEST['page'])) {
                              $page_no = $_REQUEST['page'];
                              $i = ($page_no - 1) * 10 + 1;
                              }
                              ?>
                                    @foreach($orders as $val)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <!-- <td>{{$val->order_number}}</td>                                   -->
                                            <!-- <td>{{$val->table_name}}</td> -->
                                            <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                            <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                            <td>{{$val->quantity}}</td>
                                            <td>{{$val->price}}</td>
                                            <td>{{$val->quantity*$val->price}}<?php $subtotal+=$val->quantity*$val->price;?></td>

                                                                                              
                                        </tr>
                                        <?php $i++; 
                                        $customer_name=$val->customer_name;

                                        ?>
                                      @endforeach 
                                      <?php if(count($orders) > 0) {?>                         
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">Sub Total</td>
                                            <td id="subtotal" data-val="{{$subtotal}}">{{$subtotal}}</td>
                                        </tr>
                                        @if($billdetails->discount!=0)
                                        <tr class="discount_section active">
                                            <td colspan="2"></td>
                                            <td colspan="2">Discount Applied <span id="applied_coupon">({{$discount_details->coupon_code}})</span> </td>
                                            <td id="discounted_amt">{{$billdetails->discount}}</td>
                                        </tr>
                                        @else
                                        <tr class="discount_section">
                                            <td colspan="2"></td>
                                            <td colspan="2">Order Discount: <span>(<b id="applied_coupon"></b>)</span> </td>
                                            <td id="discounted_amt">{{0}}</td>
                                        </tr>

                                        @endif
                                        <?php 
                                        if($gstDetails->gst){ 
                                            
                                            $taxAmt=0;
                                            $totalTax=0;
                                            if($bill_taxes)
                                            {
                                                if(count($bill_taxes)>0)
                                                {                      
                                                    foreach($bill_taxes as $tax)
                                                    {
                                                        $taxAmt= $tax->tax_amount;
                                                        $totalTax+=$taxAmt; 
                                                        echo '<tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</td>
                                                        <td class="taxamt" data-taxp="'.$tax->tax_value.'">'.$taxAmt.'</td>
                                                        </tr>';                              
                                                    }
                                                }
                                                else
                                                {
                                                    echo '<tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">Tax (Inclusive in price)</td>
                                                    <td>'.$taxAmt.'</td>
                                                    </tr>';
                                                }
                                            } 
                                            else 
                                            {
                                              echo '<tr>
                                                        <td colspan="2"></td>
                                                        <td colspan="2">Tax (Inclusive in price)</td>
                                                        <td>'.$taxAmt.'</td>
                                                    </tr>';
                                            }

                                            ?>                              

                                    <?php } else {?>
                                        <tr>
                                            <td colspan="2" style="border: none;"></td>
                                            <td colspan="2">Tax: (Inclusive in Price)</td>
                                            <td><?php echo $totalTax=0;?> </td>
                                        </tr>                                    
                                    <?php } ?>
                                        <tr style="font-weight: 600;">
                                            <td colspan="2" style="border: none;"></td>
                                            <td colspan="2">Total:</td>
                                            <td  id="total"><?php //echo ( $totalTax + $subtotal); ?>{{$billdetails->total}}</td>
                                        </tr>
                                        <?php } 
                                        else{
                                            echo '<tr><td colspan="7">No Record Found</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <?php

                        if($bill->payment_id =='') 
                            {?>
                        <form action="{{url('payments')}}" method="post" name="myForm" style="display:none;">
                            {{ csrf_field() }}
                            <input type="hidden" id="mob" name="mob" value="{{$bill->mobile_no}}">
                            <input type="hidden" id="amt" name="amt" value="{{$billdetails->total}}">
                            <input type="hidden" id="idOrder" name="idOrder" value="{{$billdetails->id}}">
                            <input type="hidden" name="applied_coupon" id="coupon_id" value=""/>
                        </form>
                        @if($billdetails->discount==0)

                        <div class="row">
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="name">Enter Your Coupon<span class="color-required"></span></label>
                                    <input class="form-control" name="coupon_code" id="coupon_code"/>
                                    <p id="copuon_status" style=""></p>
                                </div>
                            </div>
                            <div class="col-5">
                                <button class="btn btn-info btn" id="apply_cpn">Apply Coupon</button>    
                            </div>
                        </div>

                        @endif

                    </div>
                    <button class="btn btn-success" id="paythebill">Pay the Bill</button>
                </div>
                <?php }
                else 
                {
                    echo '<h4 class="payment_response"> <span>Your bill is already paid. Your transaction id: <b>'.$bill->payment_id.'</b></span></h4>';

                } ?>


                </div>
            </div>

        </div>
    </div>
<script type="text/javascript">
$(document).ready(function(){
var bid='<?php echo $bill->id; ?>'
    $('#apply_cpn').click(function(e){
        var code=$('#coupon_code').val();
        var send_data=new FormData();
        send_data.append('code',code);
        send_data.append('bid',bid);
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },

            type: "POST",
            url: "{{url('/applycpn')}}",           
            data:send_data,
            async: false,
            dataType: 'json',
            success: function(res){
                console.log(res); 
                var st=parseFloat($('#subtotal').data('val'));
                if(res.status=="success")
                {
                    $('#copuon_status').text('Coupon Applied');
                    $('#coupon_id').val(res.data.id);
                    $('#applied_coupon').html(res.data.coupon_code);
                    if(res.data.coupon_type=='percentage'){
                        var p=res.data.coupon_value;
                        var dis=parseFloat((st*p)/100);
                        if(res.data.max_discount!==null)
                        {
                            if(dis<=res.data.max_discount)
                            {
                                $('#discounted_amt').html(dis);
                            }
                            else{                                
                                dis = res.data.max_discount;
                                $('#discounted_amt').html(dis);
                            }
                        }
                        else{
                            $('#discounted_amt').html(dis);
                        }
                        taxC(st-dis);

                    }
                    else if(res.data.coupon_type=='fixed'){
                        var dis=res.data.coupon_value;

                        if(dis>st)
                        {
                            dis=st;
                            $('#discounted_amt').html(st);
                        }
                        else{
                            $('#discounted_amt').html(dis);
                        }
                        taxC(st-dis);
                    }
                    else{}
                     // if(res.data.coupon_code)
                    $('.discount_section').addClass('active');        
                }
                else{
                    $('#copuon_status').text(res.message);
                    $('#discounted_amt').html('');
                    $('#applied_coupon').html('');
                    $('.discount_section').removeClass('active');
                    $('#coupon_id').val('');

                    taxC(st);
                }
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });  
        e.preventDefault();
    })

}); 

function taxC(amt)
{
    var t=amt;
    $('.taxamt').each(function(){
        var per=$(this).data('taxp');
        var tax=parseFloat((amt*per)/100);
        // alert(per);
        $(this).html(parseFloat(tax).toFixed(2));
        t+=tax;
    });
    $('#total').html(parseFloat(t).toFixed(2));
}   
</script>

          <!-- <a href = "newpage.html">Next Page</a> -->  

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


  <footer class="footer-section"> 
<?php if($find_resto->is_cart_active) { ?>
    <div><a href="<?php echo url('qrestro') .'/'. $url ; ?>"><i class="fa fa-home" aria-hidden="true"></i></a></div>
    <div><a href="#" class="explore-btn" data-toggle="modal"  data-toggle="modal" data-target="#feedbackDialog"><i class="fa fa-comment-alt" aria-hidden="true"></i></a></div>
    <!-- <div><a href="#" id="order-details" data-toggle="modal" data-target="#orderDetails"><i class="fa fa-user" aria-hidden="true"></i></a></div> -->
    <!-- <div><a href="#" id="order-details"><i class="fa fa-user" aria-hidden="true"></i></a></div> -->
    <!-- <div class="cart-icon"><a href="<?php echo url()->current(); ?>/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>{{$totalcartCount}}</span></a></div> -->
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
              <input type="text" name="name" id="name" required class="form-control" id="recipient_name" value="<?php if(isset($customer_name)) { echo $customer_name; }?>">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control" id="recipient_name">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" class="form-control" id="recipient_mobile" value="<?php if(isset($bill)) { echo $bill->mobile_no; }?>">
              <input type="hidden" name="orderid" id="recipient_orderid" value="<?php if(isset($bill)) { echo $bill->id; }?>">

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
        <span class="error"></span>
        <div class="modal-body">
          <form id="mobileOtp" enctype="multipart/form-data">
            <div class="generate_otp">
              <div class="form-group">
                <label for="mobile_for_otp" class="control-label">Mobile:</label>
                <!-- <input type="text" name="mobile_number" id="mobile_for_otp" class="form-control" placeholder="Enter mobile number to receive otp"> -->
                <input type="number" name="mobile_number" id="mobile_for_otp" required onchange="check(); return false;" class="form-control" placeholder="Enter mobile number to receive otp" ><span id="mobile_validation"></span>
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-success" onclick="javascript:generate_otp();" style="margin-right: 10px;">Generate OTP</button>
              </div>                                   
            </div>
            <div class="verify_otp">
              <div class="form-group">
                <label for="recipient-name" class="control-label">Enter OTP:</label>
                <input type="number" name="entered_otp" id="entered_otp" class="form-control" placeholder="Enter otp received on mobile">
              </div>
              <div class="form-group form_buttons">                               
                <button type="button" class="btn btn-info close_button" onclick="javascript:validate_otp();" style="margin-right: 10px;">Submit</button>
                <a id="resent_otp" class="" href="#" data-count="0">Resend Otp</a>
              </div>                                   
            </div>                                   
          </form>
        </div>
        <span id="success" style="display:block; text-align:center;"></span>
        <button id="clsOtpModal" style="display: none;" class="right" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
<!--- popup mobile vefication end-->

  
<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
<script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>

     
   
<script>


 

function print_bill()
{
    printDiv('print_bill');
}

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}




var uqid='<?php echo $url;?>';

$(document).ready(function() {
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

$('#paythebill').click(function(){
    document.myForm.submit();
});


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


 
  
$('.box-category').click(function(){
  var b =  $(this).attr('data-class');
  $('.'+b+'').css("display","block")
  //document.getElementById(b).style.display = "block";
});

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
        addItemVarient(itemId,itemName,itemPrice,varientId,name,price,quantity,itemImage);
    


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
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        addItem(itemId,itemName,itemPrice,itemImage);
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
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        addItem(itemId,itemName,itemPrice,itemImage);



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
        var itemPrice= itemDetail.data('price');
        var itemImage= itemDetail.data('image');
        removeItem(itemId,itemName,itemPrice,itemImage)
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

if(qcartDetails===null)
{
    qcartDetails={
        details:{  
            restaurant_id:resID,
            table_id:tabID,
            home_url:'<?php echo url()->current();?>'
        }
    };
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
else if(!qcartDetails['details'])
{
    qcartDetails={
        details:{  
            restaurant_id:resID,
            table_id:tabID,
            home_url:'<?php echo url()->current();?>'
        }
    }
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
else if(qcartDetails['details']['mobile'])
{
    qcartDetails['details']['restaurant_id']=resID;
    qcartDetails['details']['table_id']=tabID;
    qcartDetails['details']['home_url']='<?php echo url()->current();?>';
    cm_createCookie('qcart1',JSON.stringify(qcartDetails),0.25);
}
var qcartDetails=JSON.parse( cm_readCookie('qcart1'));

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

function addItemVarient(itemId,itemName,itemPrice,varientId,name,price,quantity,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                varientId:{}                         
                            }
        cartArr[itemId]['varientId'][varientId] = {
                                    varientName:name,
                                    varientPrice:price,
                                    varientQuantity:quantity
                                }
                                // alert(' null cart');
        cm_createCookie(uqid,JSON.stringify(cartArr),30);
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =   {
                                    item: itemName,
                                    price:itemPrice,
                                    image:itemImage,
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
        cm_createCookie(uqid,JSON.stringify(cart),30);
        console.log(cart);
    }

}

function addItem(itemId,itemName,itemPrice,itemImage)
{
    var cart = JSON.parse(cm_readCookie(uqid));
    if(cart===null)
    {
//        alert('cart is empty');
        cartArr[itemId] =   {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                qty: 1
                            }
        cm_createCookie(uqid,JSON.stringify(cartArr),30);
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
    }
    else{
        if(!cart[itemId])
        {
            cart[itemId] =  {
                                item: itemName,
                                price:itemPrice,
                                image:itemImage,
                                qty: 1
                            }
        }
        else{
            cart[itemId]['qty']=cart[itemId]['qty']+1;
        }
        $('.cart-icon span').text(parseInt($('.cart-icon span').text())+1);
        cm_createCookie(uqid,JSON.stringify(cart),30);
        console.log(cart);
    }
}

function removeItem(itemId,itemName,itemPrice,itemImage)
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
        cm_createCookie(uqid,JSON.stringify(cart),30);
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

    // var mobile =cartdetails['details']['mobile'];
    // alert(cartdetails);
    if(cartdetails['details']['mobile'])
    {
        mobile=cartdetails['details']['mobile'];
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
  var badColor = "#FF0000";

  if(mobile_number.value.length!=10){
    // mobile_number.style.backgroundColor = badColor;
    message.style.color = badColor;
    message.style.display = 'block';
    message.innerHTML = "Required 10 digits, match requested format!"
    mobile_number.style.borderColor = badColor;
    mobile_number.focus();
    return false;
  }
  else{
    message.style.display = 'none';
    mobile_number.style.borderColor = goodColor;
    return true;
  }
}

function generate_otp(){
  if(check())
  {
    var mobNum= $('#mobile_for_otp').val();
    mobileVerification(mobNum);
  }
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
    var mobile_number= $('#mobile_for_otp').val();
    var tabID=document.getElementById('table_id').value;
    if(op==pas)
    { 
        get_details(mobile_number); 
        var cartdetails = JSON.parse(cm_readCookie('qcart1'));
        cartdetails['details']['mobile']= mobile_number;
        cm_createCookie('qcart1',JSON.stringify(cartdetails),0.25);
        $('#clsOtpModal').trigger('click');
        get_orders(mobile_number,tabID); 
        $('#orderDetails').modal('show');
        // console.log(cartdetails);

    }
    else{
        alert('OTP does not match.');
    }
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
            cartdetails['details']['mobile']= mobile;
            cartdetails['details']['fullname']= data.name;
            cartdetails['details']['delivery_address']= data.address;
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



</body>
</html>