 <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Document</title>
    <style>
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
</head>
<body>
    
    <div class="container-fluid for-sizing">
    <div class="order-page">
        <!--<div class="order-head">-->
        <!--    <h2>Please pay using PayUmoney</h2>-->
        <!--</div>-->
        <div class="order-form">
             <h3><span></span></h3>
            <div class="payment-option-1">
        
            <form action="{{url('charge')}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="order_id" value="{{$orderId}}"/>
    
        <?php $amount = (float)$amt * 100; ?>
        <script src="https://checkout.razorpay.com/v1/checkout.js"
         data-key="rzp_test_LIJZ3cEiZzbUoq" 
            from the Dashboard data-amount="{{$amount}}" 
            50000 refers to 50000 paise data-currency="INR"
            
            Order ID. Pass the `id` obtained in the response of the previous step. id="pay" data-buttontext="Razorpay"
            data-name="vishal Corp" 
            data-description="Test transaction"
             data-image="https://example.com/your_logo.jpg"
            data-prefill.name="vishal" 
            data-prefill.email="Test@gmail.com"
            data-prefill.contact="{{$mob}}" 
            data-theme.color="#F37254">
        </script><input type="hidden" custom="Hidden Element" name="hidden"></form>
        </div>



        <div class="payment-option-2">
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
     <div>



</div>

<script>
   $(function(){ 
  // $(".razorpay-payment-button").trigger('click'); 
});
</script>
    
</body>
</html>