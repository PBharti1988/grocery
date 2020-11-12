<html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    <style>

          /* Media query for mobile viewport */
          @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
        
        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
            }
        }
        
        *{
            margin:0;
            padding:0;
        }
        
        .for-sizing{
            min-height:100vh;
        }
        .order-page{
            box-shadow: 0px 0px 10px 5px #00000015;
            width:65%;
            position:Absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            height:350px;
            
        }

        .order-form h3{
            font-size:30;
            color:#ee3135;
            font-weight:600;
            text-align:center;
            padding-bottom:0px;
            margin-top: -15px!important;
            margin-bottom: 0px!important;
            padding-top:70px;
            
        }
        .order-form h3 span{
         color:#505050;
     }
     .payment-option-1 form{
        text-align:center;
        padding-bottom:50px;
        width: fit-content;
        margin-left:auto;
    }
    .payment-option-2 form{
        text-align:center;
        padding-bottom:50px;
        width: fit-content;
    }
    .payment-btn{
        display: inline-block;
        text-decoration: none;
        /*transition: all ease-in-out .4s;*/
        cursor: pointer;
        text-decoration:none;

    }

    .note-font{
        font-size:12px;
        text-align:center;
        font-family:Roboto;
        padding-left:50px;
        padding-right:50px;
        padding-top:10px;
    }
    .payment-option-2 {
        position:relative;
    }

    .for-content-alignment {
        margin: 0;
        position: absolute;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        /*padding: 30px;*/
        /* margin-top: 10px; */
        margin-bottom: 30px;
        width:130px!important;


    }
    .for-content-alignment:hover{
       box-shadow: 0px 0px 1px 1px #00000035;

   }

   .for-content-alignment-1 {
     display:block;
     margin:auto;
     margin-top:35px;
 }

 .razorpay-payment-button{
   color:#ffffff !important;
   background-color:#7266ba;
   border-color: #7266ba;
   font-size: 14px;
   padding: 10px;
   width: 129px;

}

.button-secondary {
    color: white;
    border-radius: 4px;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
}

.button-secondary {
    background: rgb(66, 184, 221);
    font-size: 14px;
    padding: 10px;

}

.payment-option-1{
  /* width: 300px;
  height: 300px; */
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
</style>

<script
src="https://code.jquery.com/jquery-3.1.0.min.js"
integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
crossorigin="anonymous"></script>

</head>
<body>
    <div class="container-fluid for-sizing">
        <div class="order-page">
            <!--<div class="order-head">-->
                <!--    <h2>Please pay using PayUmoney</h2>-->
                <!--</div>-->
            <div class="order-form">
              
           <?php if($razor)
           {
              
            if($razor->payment_gateway_id == 4){ 
            if($razor->active==1)
            {

            // dd($razor);
                $key='';
                if($razor->live_mode==1)
                {
                    $key=$razor->key_1;
                }
                if($razor->live_mode==0)
                {
                    $key=$razor->key_2;
                }
                ?>
                <div class="payment-option-1">

                    <form action="{{url('chargebyinstant')}}" method="POST" name="razorpay">
                        {{csrf_field()}}
                        <input type="hidden" name="order_id" value="{{$orderId}}"/>
                        <input type="hidden" name="coupon_id" value=""/>
                        <input type="hidden" name="gateway_name" value="razor">
                        <?php 
                        $amount = (float)$amt * 100; 
                        // $amount = 100;
                        ?>
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{$key}}" 
                        data-amount="{{$amount}}"  
                        data-currency="INR"
                        data-buttontext="Razorpay"
                        data-name="{{$restaurant->name}}"
                        data-description="Payment on qresto plateform"
                        data-image="{{URL::asset('public/assets/restaurant-logo/')}}{{$restaurant->logo}}"
                        data-prefill.name="{{$restaurant->name}}"
                        data-prefill.email=""
                        data-prefill.contact="" 
                        data-theme.color="#F37254"
                        ></script>

                        <input type="hidden" custom="Hidden Element" name="hidden">
                    </form>
                </div>

                <?php
            }
        }
            else if($razor->payment_gateway_id == 1){
                if($razor->active==1)
                {
                    $key='';
                    if($razor->live_mode==1)
                    {
                        $key=$razor->key_1;
                    }
                    if($razor->live_mode==0)
                    {
                        $key=$razor->key_2;
                    }
                   ?>
                   <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $key; ?>&currency=INR&commit=false&disable-funding=credit,card"></script>
                   <div id="paypal-button-container" ></div>
                   <form action="{{url('chargebyinstant')}}" method="post" name="paypal" style="display:none;">
                   {{ csrf_field() }}
                   <input type="text" id="idOrder" name="order_id" value="{{$orderId}}">
                   <input type="text" id="payment_id" name="payment_id">
                   <input type="text" name="gateway_name" value="paypal">
                    </form>

                   <?php 
                        $amount = (float)$amt; 
                        ?>
                   <script>
                   paypal.Buttons({
                   createOrder: function(data, actions) {
                  // This function sets up the details of the transaction, including the amount and line item details.
                   return actions.order.create({
                   purchase_units: [{
                   amount: {
                   value: '{{$amount}}',
                   currency:'INR'
          }
        }]
      });
    },
      onApprove: function(data, actions) {
      // This function captures the funds from the transaction.
      return actions.order.capture().then(function(details) {

         if(details.status =='COMPLETED'){
            var transaction_id=details.id;
            $('#payment_id').val(transaction_id);
           // console.log(details);
            document.paypal.submit();
         }else{
            window.history.go(-1);
         }
      });
    },
    onCancel: function (data) {
        window.history.go(-1);
    
  }
  }).render('#paypal-button-container');
  //This function displays Smart Payment Buttons on your web page.
</script>  



                  <?php

                }    
            }

        }   
    ?>     

                <div class="payment-option-2" style="display: none;">
                    <?php 
                    define('MERCHANT_KEY', 'tFgeds');
                    define('SALT', 'W8gX2OX9');
                        // define('MERCHANT_KEY', 'hhFfC2zp');
                        // define('SALT', 'PWcycpStPL');
                     define('PAYU_BASE_URL', 'https://sandboxsecure.payu.in');    //Testing url Use in development mode
                   // define('PAYU_BASE_URL', 'https://secure.payu.in');

                     define('SUCCESS_URL', 'order-success.php');
                     define('FAIL_URL', 'order-fail.php');
                     $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
                     $email = "vishal.iimtgn@gmail.com";
                     $mobile = "8826126514";
                     $firstName = "vishal";
                     $lastName =  "gupta";
                     $totalCost = $amt;
                     $hash         = '';
                     $hash_string = MERCHANT_KEY."|".$txnid."|".$totalCost."|"."productinfo|".$firstName."|".$email."|||||||||||".SALT;
                     $hash = strtolower(hash('sha512', $hash_string));
                     $action = PAYU_BASE_URL . '/_payment'; 
                     ?>
                     <form action="<?php echo $action; ?>" name="payuForm" id="payuForm">

                        <input type="hidden" name="key" value="<?php echo MERCHANT_KEY ?>" />
                        <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                        <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                        <input name="amount" type="hidden" value="<?php echo $totalCost; ?>" />
                        <input type="hidden" name="firstname" id="firstname" value="<?php echo $firstName; ?>" />
                        <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                        <input type="hidden" name="phone" value="<?php echo $mobile; ?>" />
                        <textarea name="productinfo" style="display:none;"><?php echo "productinfo"; ?></textarea>
                        <input type="hidden" name="surl" value="{{url('payment-status')}}"/>
                        <input type="hidden" name="furl" value="{{url('payment-status')}}"/>
                        <input type="hidden" name="service_provider" value="payu_paisa"/>
                        <input type="hidden" name="lastname" id="lastname" value="<?php echo $lastName ?>" />
                        <!--<input type="submit" name="paumoneysubmit" value="Pay With payUmoney" />-->

                        <input class="for-content-alignment button-secondary pure-button" type="submit" style="width:195px;" name="paumoneysubmit" value="PayuMoney">
                        <!--<p class="sub-info-2">(For Indian Client)</p>-->

                    </form>
                    <div class="card-banner">


                    </div>


                </div>
            </div>
        </div>
    </div>


<script>
// document.razorpay.submit();
var check_gateway = <?php echo $razor->payment_gateway_id; ?>;
$(function(){
    if(check_gateway == 4){ 
    $(".razorpay-payment-button").trigger('click');
    }
    else if(check_gateway == 1){
        $("#paypal-button-container").trigger('click');
    }
});
</script>

</body>
</html>