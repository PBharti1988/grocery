<!DOCTYPE html>
<html>

<head>
    <style>
      .razorpay-payment-button{
         color:#ffffff !important;
         background-color:#7266ba;
         border-color: #7266ba;
         font-size: 14px;
         padding: 10px;

      }
  </style>
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

</head>

<body>

 
    <form action="{{url('charge')}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="order_id" value="{{$orderId}}"/>
    
        <?php $amount = (float)$amt * 100; ?>
        <script src="https://checkout.razorpay.com/v1/checkout.js"
         data-key="rzp_test_LIJZ3cEiZzbUoq" 
            from the Dashboard data-amount="{{$amount}}" 
            50000 refers to 50000 paise data-currency="INR"
            
            Order ID. Pass the `id` obtained in the response of the previous step. id="pay" data-buttontext="Pay with Razorpay"
            data-name="vishal Corp" 
            data-description="Test transaction"
             data-image="https://example.com/your_logo.jpg"
            data-prefill.name="vishal" 
            data-prefill.email="Test@gmail.com"
            data-prefill.contact="{{$mob}}" 
            data-theme.color="#F37254">
        </script><input type="hidden" custom="Hidden Element" name="hidden"></form>
<script>
   $(function(){ 
   $(".razorpay-payment-button").trigger('click'); 
});
</script>
</body>

</html>