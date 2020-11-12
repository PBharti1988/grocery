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

    <style></style>
</head>
<body>

<?php $array= array('(',')','+','@','-','[',']','{','}','!','/','<','>','?','&','%','^','*','$','-','=','|'); ?>


<div class="container-fluid">
    <div class="container">
        <div class="row justify-content-md-center">

            <div class="col-md-12 col-sm-12" style="color: #333;  background:#fff; ">
                <div class="row"  style="float: right;">
                    <div class="center-text">
                        <a class="btn btn-sm" id="btn-Convert-Html2Image" href="#"><i class="fa fa-download"></i> Download Invoice</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12 col-sm-12 invoice" id="invoice_box">
                <div class="center-text">
                    <div class="res_logo"><img src="{{asset('public/assets/restaurant-logo/'.$find_resto->logo)}}" style="weight:50px;height:50px;" title="{{$find_resto->name}}" alt="{{$find_resto->name}}"/></div>
                    <h4 class="res_name">{{ucfirst($find_resto->name)}}</h4>    
                    <p>{{ucfirst($find_resto->address)}}</p>
                    <!-- <p class="light"></p> -->
                    <p class="light">{{ucfirst($find_resto->text_title)}}:{{$find_resto->text_detail}} </p>
                    <h4>Invoice</h4>    
                </div>
                
                <div>                    
                    @if($find_table=='0')
                    <br>
                    @else 
                        <p>{{ucfirst($find_table->table_name)}}</p>
                        <br>
                    @endIf
                        <div>Customer: {{ucfirst($customer_name)}}</div>
                        <!-- <div>{{strtoupper($order_number)}}</div> -->


                </div>
                <hr>
                <div>  
                    <div><span>Invoice No: {{$billdetails->bill_number}}</span> <span class="fl-right"></span></div>
                    <div><span>{{date("M d, Y h:i a", strtotime(cnvt_UTC_to_usrTime($billdetails->created_at,'Asia/Kolkata')))}}</span> <span class="fl-right"></span></div>                    
                </div>
                <hr>
                <div>
                    <ul>
                    @foreach($orders as $val)
                        <li>
                          <dl>
                            <dt>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</dt>
                            <dd><span class="lite">{{$val->quantity}} @ <?php echo $ruppeeSign;?> {{$val->price}}/each</span><span class="fl-right"> <?php echo $ruppeeSign;?> {{number_format((float)$val->quantity*$val->price, 2, '.', '')}}<?php $subtotal+=$val->quantity*$val->price;?></span></dd>
                          </dl>
                        </li>
                    @endforeach
                    </ul>
                </div>
                <hr>
                <?php if(count($orders) > 0) {?>                         
                
                <div>  
                    <div><span>Sub Total</span> <span class="fl-right"><?php echo $ruppeeSign;?> {{number_format((float)$subtotal, 2, '.', '')}}</span></div>
                    
                @if($billdetails->discount!='0')
                    <div><span>Discount ({{$discount_details->coupon_code}})</span> <span class="fl-right"><?php echo $ruppeeSign;?> {{number_format((float)$billdetails->discount, 2, '.', '')}}</span></div>
                    @php
                        $subtotal=$subtotal-$billdetails->discount;
                    @endphp
                @endif


                <?php 
                $taxAmt=0;
                $totalTax=0;
                if($gstDetails->gst){
                    if($bill_taxes)
                    {
                        if(count($bill_taxes)>0)
                        {                      
                            foreach($bill_taxes as $tax)
                            {
                                $taxAmt= $tax->tax_amount;
                                $totalTax+=$taxAmt; 
                                echo '<div><span>'.$tax->tax_name.' '.$tax->tax_value.'% on '.$ruppeeSign.' '.number_format((float)$subtotal, 2, '.', '').'</span> <span class="fl-right">'.$ruppeeSign.' '.number_format((float)$taxAmt, 2, '.', '').'</span></div>';
                            }
                        }
                        else
                        {
                              echo '<div><span>Tax (Inclusive in price)</span> <span class="fl-right">'.$ruppeeSign.' '.number_format((float)$taxAmt, 2, '.', '').'</span></div>';

                        }
                    } 
                    else 
                    {
                        echo '<div><span>Tax (Inclusive in price)</span> <span class="fl-right">'.$ruppeeSign.' '.number_format((float)$taxAmt, 2, '.', '').'</span></div>';
                    }

                } 
                else 
                {
                    echo '<div><span>Tax (Inclusive in price)</span> <span class="fl-right">'.$ruppeeSign.' '.number_format((float)$totalTax, 2, '.', '').'</span></div>';
                } ?>
                <div class="large-text"><span>Invoice Total</span> <span class="fl-right"><?php echo $ruppeeSign;?> {{number_format((float)($totalTax + $subtotal), 2, '.', '')}}</span></div>
                <?php } 
                else{
                    echo '<tr><td colspan="7">No Record Found</td></tr>';
                }
                ?>
                </div>
                <div>  
                    <div><span>Payment Details</span> <span class="fl-right"></span></div>
                    <div><span>Paymentt Mode</span> <span class="fl-right">@if($billdetails->payment_mode=='2'){{'Cash'}}@elseIf($billdetails->payment_mode=='1'){{'Online'}}@endIf</span></div>
                    <div><span>Txn ID:</span> <span class="fl-right">{{$billdetails->payment_id}}</span></div>
                </div>
                <div class="center-text">
                    <div class="light thankyou"> Thank you for Dining with {{$find_resto->name}}. Visit us again.</div>
                    <div class="company_details"><span class="light">Powered By</span> <a href="https://www.qrestro.com">Qrestro.com</a></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="center-text thankyou"></div>
                <div class="center-text thankyou"><a href="#" class="explore-btn" data-toggle="modal"  data-toggle="modal" data-target="#feedbackDialog" style="color:beige">Feedback</a></div>
                <div class="center-text thankyou"></div>
            </div>

        </div>          
    </div>
</div>
<div id="previewImage" style="display: none;">
</div>



<!--- <dialog id="dialog" class="dialog"> -->
  <div id="feedbackDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <span class="error"></span>
        <div class="modal-body">

          <form id="feedback" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="restaurant_id" value="{{$find_resto->id}}">
            <input type="hidden" name="orderid" id="orderid" value="{{$billdetails->id}}">
            <div class="form-group">
              <label for="recipient-name" class="control-label">Name:</label>
              <input type="text" name="name" id="name" required class="form-control" value="{{ucfirst($customer_name)}}">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Email:</label>
              <input type="email" id="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
              <label for="recipient-name" class="control-label">Mobile:</label>
              <input type="text" name="mobile" id="mobile" class="form-control" value="{{$billdetails->mobile_no}}">
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

<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007714979/custom/page/hack-a-thon-3/masonry.min.min.js'></script>
<script src='https://cdn2.hubspot.net/hub/322787/hub_generated/style_manager/1440007849180/custom/page/hack-a-thon-3/isotope.min.js'></script>
<script src="{{URL::asset('public/assets/user/owlcarousel/owl.carousel.js')}}"></script>

<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->

<script src="{!!URL::to('/') . '/public/js/html2canvas.js' !!}"></script>
   
<script type="text/javascript">

$(document).ready(function(){
    var element = $("#invoice_box"); // global variable
    var getCanvas; // global variable
    preview_bill();

    $("#btn-Convert-Html2Image").on('click', function () {
        var imgageData = getCanvas.toDataURL("image/png");
        // Now browser starts downloading it instead of just showing it
        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
        $("#btn-Convert-Html2Image").attr("download", "{{$find_resto->name}} Invoice.png").attr("href", newData);
    });

    function preview_bill() {
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
    }




});


</script>


<script>


$(function() {
 
   // alert(1);
    $('#feedbackDialog').modal('show');
});

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

</script>
<script>


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


</body>
</html>