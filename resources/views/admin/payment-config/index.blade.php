@extends('admin.admin-layouts.app')
@section('content')
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>

  /*  bhoechie tab */
  div.bhoechie-tab-container{
    z-index: 10;
    background-color: #ffffff;
    padding: 0 !important;
    border-radius: 4px;
    -moz-border-radius: 4px;
    border:1px solid #ddd;
    margin-top: 20px;
    margin-left: 50px;
    -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    box-shadow: 0 6px 12px rgba(0,0,0,.175);
    -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
    background-clip: padding-box;
    opacity: 0.97;
    filter: alpha(opacity=97);
  }
  div.bhoechie-tab-menu{
    padding-right: 0;
    padding-left: 0;
    padding-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group{
    margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a{
    margin-bottom: 0;
  }
  div.bhoechie-tab-menu div.list-group>a .glyphicon,
  div.bhoechie-tab-menu div.list-group>a .fa {
    color: #5A55A3;
  }
  div.bhoechie-tab-menu div.list-group>a:first-child{
    border-top-right-radius: 0;
    -moz-border-top-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a:last-child{
    border-bottom-right-radius: 0;
    -moz-border-bottom-right-radius: 0;
  }
  div.bhoechie-tab-menu div.list-group>a.active,
  div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
  div.bhoechie-tab-menu div.list-group>a.active .fa{
    background-color: #a1cece;
    background-image: #5A55A3;
    color: #ffffff;
  }
  div.bhoechie-tab-menu div.list-group>a.active:after{
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    margin-top: -13px;
    border-left: 0;
    border-bottom: 13px solid transparent;
    border-top: 13px solid transparent;
    border-left: 10px solid #5A55A3;
  }

  div.bhoechie-tab-content{
    background-color: #ffffff;
    /* border: 1px solid #eeeeee; */
    padding-left: 20px;
    padding-top: 10px;
  }

  div.bhoechie-tab div.bhoechie-tab-content:not(.active){
    display: none;
  }

</style>

<div class="container-fluid">

  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h4 class="text-themecolor">Payment configuration</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
      <div class="d-flex justify-content-end align-items-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
          <li class="breadcrumb-item active">Payment configuration</li>
        </ol>


      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">

      <div class="col-lg-10 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
        @include('admin.admin-layouts.flash-message')
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
          <div class="list-group">
            <?php $i=1; ?>
            @foreach($gateway as $val)
            <?php 
            if($i == 1){
              $active ="active";
            }else{
              $active ="";
            }

            if($val->payment_gateway_id == 1){
              $icon="paypal.png";
            }elseif($val->payment_gateway_id == 2){
              $icon="stripe.png";
            }elseif($val->payment_gateway_id == 3){
              $icon="payu.png";
            }elseif($val->payment_gateway_id == 4){
              $icon="razorpay.png";
            }elseif($val->payment_gateway_id == 5){
              $icon="cod.png";
            }

            ?>
            <a href="#" class="list-group-item {{$active}} text-center">

              <h3><img style="width:89px; height:48px;" src="{{asset('public/payment-gateway/'.$icon)}}" ></h3><br/>{{$val->gateway_name}}
            </a>
            <?php $i++; ?>
            @endforeach

          </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
          <?php $j=1; ?>
          @foreach($gateway as $val)
          <?php
          if($j == 1){
            $active1 ="active";
          }else{
            $active1 ="";
          }

          ?>
          <div class="bhoechie-tab-content {{$active1}}">
            @if($val->payment_gateway_id != 5)
              @if($val->payment_gateway_id == 4)
              <form method="post" action="{{url('payment-detail-store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="restaurant_id" value="{{$res_id}}">
                <input type="hidden" name="payment_gateway_id" value="{{$val->payment_gateway_id}}">  
                <input type="hidden" name="payment_type_id" value="<?php if(in_array($val->payment_gateway_id,array(1,2,3,4))){echo 1;} else{echo 2;} ?>">   
                <div class="form-group">
                  <label for="exampleInputEmail1">Razor Pay Live Key</label>
                  <input type="text" name="customer_id" value="{{$val->key_1}}" class="form-control"
                  placeholder="Enter customer id" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Razor Pay Test Key</label>
                  <input type="text" name="merchant_id" value="{{$val->key_2}}" class="form-control"
                  placeholder="Enter merchant id" required>
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="live_mode" class="custom-control-input" id="customSwitch{{$j}}"
                    {{$val->live_mode == 1 ? 'checked': ''}}>
                    <label class="custom-control-label" for="customSwitch{{$j}}">Live Mode</label>
                  </div>
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="active" class="custom-control-input" id="customSwitch2{{$j}}"
                    {{$val->active == 1 ? 'checked': ''}}>
                    <label class="custom-control-label" for="customSwitch2{{$j}}">Active</label>
                  </div>
                </div>

                <button type="submit"
                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>                 
              </form>
              @else
              <form method="post" action="{{url('payment-detail-store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="restaurant_id" value="{{$res_id}}">
                <input type="hidden" name="payment_gateway_id" value="{{$val->payment_gateway_id}}">  
                <input type="hidden" name="payment_type_id" value="<?php if(in_array($val->payment_gateway_id,array(1,2,3,4))){echo 1;} else{echo 2;} ?>">   
                <div class="form-group">
                  <label for="exampleInputEmail1">Live Client Id</label>
                  <input type="text" name="customer_id" value="{{$val->key_1}}" class="form-control"
                  placeholder="Enter customer id" required>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Test Client Id</label>
                  <input type="text" name="merchant_id" value="{{$val->key_2}}" class="form-control"
                  placeholder="Enter merchant id" required>
                </div>

    

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="live_mode" class="custom-control-input" id="customSwitch{{$j}}"
                    {{$val->live_mode == 1 ? 'checked': ''}}>
                    <label class="custom-control-label" for="customSwitch{{$j}}">Live Mode</label>
                  </div>
                </div>

                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" name="active" class="custom-control-input" id="customSwitch2{{$j}}"
                    {{$val->active == 1 ? 'checked': ''}}>
                    <label class="custom-control-label" for="customSwitch2{{$j}}">Active</label>
                  </div>
                </div>

                <button type="submit"
                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>                 
              </form>
              @endif
            @else
            <br>
            <br>
            <form method="post" action="{{url('payment-detail-store')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <input type="hidden" name="restaurant_id" value="{{$res_id}}">
              <input type="hidden" name="payment_gateway_id" value="{{$val->payment_gateway_id}}">  
              <input type="hidden" name="payment_type_id" value="<?php if(in_array($val->payment_gateway_id,array(1,2,3,4))){echo 1;} else{echo 2;} ?>">   

              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="live_mode" class="custom-control-input" id="customSwitch{{$j}}"
                  {{$val->live_mode == 1 ? 'checked': ''}}>
                  <label class="custom-control-label" for="customSwitch{{$j}}">Live Mode</label>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="active" class="custom-control-input" id="customSwitch2{{$j}}"
                  {{$val->active == 1 ? 'checked': ''}}>
                  <label class="custom-control-label" for="customSwitch2{{$j}}">Active</label>
                </div>
              </div>

              <button type="submit"
              class="btn btn-success waves-effect waves-light m-r-10">Submit</button>                 
            </form>


            @endif
          </div>
          <?php $j++; ?>
          @endforeach
          <!-- train section -->


          <!-- hotel search -->



        </div>
      </div>
    </div>


  </div>

</div>
<script>

  $(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
      e.preventDefault();
      $(this).siblings('a.active').removeClass("active");
      $(this).addClass("active");
      var index = $(this).index();
      $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
      $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
  });

</script>

@endsection