<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.container {
  background-color: #f2f2f2;
  padding: 5px 10px 5px 10px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}
.btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}
.btn:hover {
  background-color: #45a049;
}
input[type="submit"][disabled] {
   background-color: #737373;
}
</style>
</head>
<body>
<p style="text-align:center"><strong>Txn ID:</strong> {{$merchantTxnId}}</p>
<p style="text-align:center"><strong>Amount:</strong> {{$amount}} {{$currency}}</p>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form enctype="application/json" action="{{$action}}" method="post">
        <input value="{{$merchantId}}" name="merchantId" type="hidden">
        <input value="{{$platformId}}" name="platformId" type="hidden">
        <input value="{{$merchantTxnId}}" name="merchantTxnId" type="hidden">
        <input value="{{$amount}}" name="amount" type="hidden">
        <input value="{{$currency}}" name="currency" type="hidden">
        <input value="{{$furl}}" name="furl" type="hidden">
        <input value="{{$surl}}" name="surl" type="hidden">
        <input value="{{$productInfo}}" name="productInfo" type="hidden">
        <input value="{{$checksum}}" name="checksum" type="hidden">
        <input value="{{$email}}" name="email" type="hidden">
        <input value="{{$mobile}}" name="mobile" type="hidden">
        <input value="{{$customerName}}" name="customerName" type="hidden">
        <input value="{{$channel}}" name="channel" type="hidden">
        <input type="submit" class="btn" value="Proceed to Pay" onClick="this.form.submit(); this.disabled=true; this.value='Please wait...'"/>
      </form>
    </div>
  </div>
</div>

</body>
</html>
