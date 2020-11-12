@extends('admin.admin-layouts.app')
<style>

.align-middle {
    vertical-align: middle!important;
}

    .center {
    width: 120px;
    /* margin: 24px auto; */
}
    .input-group {
    position: relative;
    display: table;
    /* border-collapse: separate; */
}
input.form-control.input-number {
    padding: 5px;
    text-align: center;
    height: 34px;
}

button.btn.btn-danger.btn-number{
    padding: 9px;
    font-size: 14px;
    height: 34px;
    width: 33px;

}

.input-group-btn {
    position: relative;
    font-size: 0;
    white-space: nowrap;
}
 </style>
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"><a href="{{url('/order')}}">Orders</a></h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
               
             <!-- <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>

    <div class="row" id="orderDetails">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">

                        Order Details 
                        <div style="float: right;">                            
                            <?php
                                if(isset($billdetails->id))
                                {
                                    echo 'Bill is already generated. <a';
                                }


                                if(Auth::guard('restaurant')->id())
                                {
                                    $rest_id= Auth::guard('restaurant')->id();
                                }
                                else if(Auth::guard('manager')->id())
                                {
                                    $manager = Auth::guard('manager')->user();
                                    $rest_id=$manager->restaurant_id;
                                    $user_type=$manager->user_type;
                                    $perms=get_admin_module_permission($rest_id,$user_type,'order');

                                    // if(isset($perms))
                                    // {
                                    //     if($perms->create)
                                    //     {}
                                    //     else{
                                    //         return view('admin.nopermission')->with('error', 'Permission Denied');
                                    //     }         
                                    // }



                                }



                            ?>
                        @if($generate_bill)
                            @if($show_gen_btn==0)
                            <?php $order_type ="new"; $tab=1; ?>

                                @if(isset($perms))
                                @if($perms->update)
                                @endif
                                @endif
                                <a style="max-width: 120px; margin: 0 0 10px 0;" class="btn btn-primary" href="{{url('add-more-to-order/'.$order_id.'/'.$order_type.'/'.$tab)}}">Add More Item</a>
                                <a href="#" style="clear: both;"> <span style="max-width: 120px;margin: 0 0 10px 8px;" class="btn btn-info edit-order" ><i class="fa fa-edit"></i>Edit Item</a>


                                @if(isset($perms))
                                @if($perms->create)
                                @endif
                                @endif

                                <span id="accept_all" data-order_id="{{$order_id}}" style="max-width: 120px; margin: 0 0 10px 0;" class="btn btn-success" ><i class="fa fa-check"></i> Accept All</span>
                                <span id="reject_all" data-order_id="{{$order_id}}" style="max-width: 120px; margin: 0 0 10px 0;" class="btn btn-danger" ><i class="fa fa-close"></i> Reject All</span>

                            @endif
                           
                            @if($show_gen_btn==1)
<!--                             <span id="generate_bill" data-order_id="{{$order_id}}" style="max-width: 160px; margin: 0 0 10px 0; " class="btn btn-primary" ><i class="fa fa-print"></i> Genererate Bill</span> -->
                            @endif

                            @if(!empty($check_kot))
                            <button class="btn btn-info" style="max-width: 120px; margin: 0 0 10px 0;" onclick="print_bill()">Print KOT</button>
                            @endif
                        @endif
                        </div>
                    </h4>
                    <?php
                        if(isset($billdetails->id))
                        {
                            echo '<p class="billdetail_strip"> <span>Bill No: '.$billdetails->bill_number . '</span><span style="float: right;"> Bill Date: '.date("d-M-Y", strtotime($billdetails->created_at)) . '</span></p>';
                            echo '<div style="float: none;clear:both;"></div>';

                        }
                    ?>
                    <div id="print_kot">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order No</th>
                                        <th>Table</th>
                                        <th>Veg/Non-veg</th>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                     
                                        <th class="edit-action alway_remove">Action</th>
                                      
                                        <th class="alway_remove">Status</th>                                
                                    </tr>
                                </thead>
                                <tbody>
                                <?php


                                $i = 1;
                                $instructions = '';
                                if (isset($_REQUEST['page'])) {
                                $page_no = $_REQUEST['page'];
                                $i = ($page_no - 1) * 10 + 1;
                                }
                                $totalcartCount=0;
                                ?>
                              
                                    @foreach($order_items as $val)
                                    <tr class="@if($val->order_status != 2) not_print @endif">
                                        <td>{{$i}}</td>
                                        <td>{{$val->order_number}}</td>                                  
                                        <td>{{$val->table_name}}</td>
                                        <td>
                                            <span class="{{$val->item_type}}">
                                                <span class="info">{{ucfirst($val->item_type)}}
                                                </span>
                                            </span>
                                        </td>
                                        <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                        <td>
                                            <span class="p-itm-name">{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</span>
                                            @if($val->short_description)
                                            <span  class="p-itm-desc">Description: {{$val->short_description}}</span>
                                            @endIf
                                        </td>
                                        <td>{{$val->quantity}}</td>
                                       
                                        <td class="edit-action alway_remove">
                                        @if($val->order_status_name == 'New')
                                    <strong>
                                    <div class="center">
                                     <div class="input-group" data-itemid="{{$val->item_id}}" data-status="{{$val->order_status}}" data-orderid="{{$val->order_id}}" data-itemorderid="{{$val->id}}" data-itemname="{{$val->item_name}}" data-price="{{$val->price}}">
                                      <span class="input-group-btn">
                                     <button type="button" class="btn btn-danger btn-number removeItem"  data-type="minus" data-field="quant[2]">
                                    <span class="glyphicon glyphicon-minus"></span>-
                                    </button>
                                   </span>
                                       <input type="text" name="quant[2]" class="form-control input-number itemcount" readonly="true" value="<?php echo $val->quantity; $totalcartCount+=$val->quantity; ?>" min="1" max="100">
                                     <span class="input-group-btn">
                                    <button type="button" class="btn btn-success btn-number addItem" data-type="plus" data-field="quant[2]">
                                      <span class="glyphicon glyphicon-plus"></span>+
                                  </button>
                                  </span>
                                     </div>
                                    </div>
                                 </strong>
                                 @endif
                                 </td>
                             

                                        </td>
                                        <td class="alway_remove act-btn-gp">
                                        @if(isset($perms))
                                        @if($perms->update)
                                            @if($val->order_status_name == 'New')
                                            <div class="btn-group">
                                                <button class="btn btn-success btn-xs acceptorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                    <i class="fa fa-edit"></i> Accept </button>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-danger btn-xs rejectorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                    <i class="fa fa-edit"></i> Reject </button>
                                            </div>
                                            @elseif($val->order_status_name != 'New')
                                            {{$val->order_status_name}}

                                              &nbsp     
                                            @if($val->order_status_name != 'Completed')                                                                
                                            <a href="javascript:" class="btn btn-primary edit-order edit{{$val->item_id}}" data-attr="{{$val->item_id}}" data-edit="{{$val->order_status_name}}"><i class="fa fa-edit"></i></a>
                                            @endif

                                            <div class="btn-group accept{{$val->item_id}}" style="display:none" >
                                                <button class="btn btn-success btn-xs acceptorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                    <i class="fa fa-edit"></i> Accept </button>
                                                    <span class="remove_edit_btn" data-attr="accept" attr-data="{{$val->item_id}}" >X</span>  
                                            </div>
                                            <div class="btn-group reject{{$val->item_id}}" style="display:none">
                                                <button class="btn btn-danger btn-xs rejectorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                    <i class="fa fa-edit"></i> Reject </button>
                                                    &nbsp
                                                  <span class="remove_edit_btn" data-attr="reject" attr-data="{{$val->item_id}}" >X</span>  
                                            </div>
                                            @endif
                                        @else
                                            {{$val->order_status_name}}

                                        @endif
                                        @else
                                            {{$val->order_status_name}}
                                        @endif

                                         </td>
                                    </tr>
                                    <?php $i++ ;
                                    $instructions = $val->instruction;

                                    ?>
                                    @endforeach                          
                                  
                                </tbody>
                            </table>
    <?php  /* ?>                        {{$order_items->links()}}  <?php */ ?>
                            
                            <?php

                            // if($instructions!='') 
                            //     echo '<b class="instruction-title">Additional Instruction:</b> <span class="instruction-text">'.$instructions.'</span>' ; 
                            // else  
                            //     echo '<b class="instruction-title">Additional Instruction: No </b>';
                             
                            if($instructions!='') 
                                echo '<div class="ribbon-wrapper card">
                                    <div class="ribbon ribbon-bookmark  ribbon-danger" style="font-size:16px; font-weight:600;">Additional Instruction</div>
                                    <p class="ribbon-content">'.$instructions.'</p>
                                </div>' ; 
                            else  
                                echo '<div class="ribbon-wrapper card">
                                    <div class="ribbon ribbon-bookmark  ribbon-danger">Additional Instruction</div>
                                    <p class="ribbon-content">No</p>
                                </div>' ; 
                             




                             ?>
                        </div>
                    </div>
                    @if($generate_bill)
                    @if($show_gen_btn==1)

<hr>
<div class="text-center"><h4>Bill Conclude Section</h4></div>
<hr>

<?php $subtotal=0.00;
$tax=0.00;
$total=0.00; 
?>


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>                                
                                    <th>Price</th>                                
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
                      // print_r($orders);
                      // die;
                      ?>
                            @foreach($orders as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->order_number}}</td>
                                    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>{{$val->price}}</td>
                                    <td>{{$val->quantity*$val->price}}<?php $subtotal+=$val->quantity*$val->price;?></td>

                                                                                      
                                </tr>
                                <?php $i++ ?>
                              @endforeach 
                              <?php if(count($orders) > 0) { ?>                         
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">Sub Total</td>
                                    <td id="subtotal" data-val="{{$subtotal}}">{{$subtotal}}</td>
                                </tr>
                                <tr class="discount_section">
                                    <td colspan="3"></td>
                                    <td colspan="2">Order Discount: <span>(<b id="applied_coupon"></b>)</span> </td>
                                    <td id="discounted_amt">{{0}}</td>
                                </tr>

                  <?php 
                  $taxAmt=0;
                  $totalTax=0;
// todo: add tax module check here
                  // if($find_resto->gst)
                  if($taxes)
                    {
                        if(count($taxes)>0)
                        {                      
                            foreach($taxes as $tax)
                            {
                              $taxAmt= (($subtotal*$tax->tax_value)/100);
                              $totalTax+=$taxAmt; 


                                echo '<tr>
                                        <td colspan="3"></td>
                                        <td colspan="2">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</td>
                                        <td class="taxamt" data-taxp="'.$tax->tax_value.'">'.$taxAmt.'</td>
                                    </tr>';                              
                            }
                        }
                        else
                        {
                            echo '<tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">Tax (Inclusive in price)</td>
                                    <td class="taxamt" data-taxp="0">'.$taxAmt.'</td>
                                </tr>';

                        }
                    } 
                else 
                    {
                      echo '<tr>
                                <td colspan="3"></td>
                                <td colspan="2">Tax (Inclusive in price)</td>
                                <td class="taxamt" data-taxp="0">'.$taxAmt.'</td>
                            </tr>';
                    }
                  ?>

                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">Total:</td>
                                    <td id="total"><?php echo $subtotal+$totalTax; ?></td>
                                </tr>
                                <?php } 
                                else{
                                    echo '<tr><td colspan="7">No Record Found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>



            <?php
            
            if(Auth::guard('restaurant')->id())
            {
                $rest_id= Auth::guard('restaurant')->id();
            }
            else if(Auth::guard('manager')->id())
            {
                $manager = Auth::guard('manager')->user();
                $rest_id=$manager->restaurant_id;

                $user_type=$manager->user_type;
                $perms=get_admin_module_permission($rest_id,$user_type,'discount');
            }

            if(count($orders) > 0) {?>

                <form method="post" action="{{url('/')}}/order/{{$order_id}}/conclude" enctype="multipart/form-data">
                {{csrf_field()}}

                    <?php
                
                    if(isset($perms) && !empty($perms))
                    {
                        if($perms->create)
                        {
                            if(count($coupons)>0){
                            ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Select Discount<span class="color-required"></span></label>
                                    <select class="form-control" name="select_coupon" id="select_coupon">
                                        <option value="">No Coupon Selected</option>
                                        @foreach($coupons as $coupon)
                                        <option value="{{$coupon->id}}" data-code="{{$coupon->coupon_code}}">{{$coupon->coupon_code}}, ({{$coupon->description}})</option>
                                        @endforeach
                                    </select>
                                    <p id="copuon_status" style=""></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <input type="hidden" name="applied_coupon" id="coupon_id" value=""/>

                                <button class="btn btn-info btn" id="apply_cpn">Apply Coupon</button>    
                            </div>
                        </div>

                    <?php 
                            }
                        }
                    }        ?>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customer_notification" checked="checked" name="customer_notification"/>
                                        <label class="custom-control-label" for="customer_notification" style=" padding-left: 30px; font-size: 15px; font-weight: 600;"> Send Generated Bill Notification to Customer</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-12 text-center"> -->
                            <div class="col-12">
                                <div style=" right; margin: 0 0 10px 0;" >
                                    <button class="btn btn-success btn-lg"> 
                                        Conclude Bill <i class="fa fa-file-text-o"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
            <?php } ?>

                    @endif
                    @endif



                </div>
            </div>
        </div>
    </div>
<!-- <audio controls>
    <source id="source" src="" type="audio/mpeg">1
    Your browser does not support the audio element.
</audio> -->
    <div id="accepted" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title align-self-center">
                        All items are accepted in this order.
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div id="rejected" style="display: none;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title align-self-center">
                        All items are rejected in this order.
                    </h4>
                </div>
            </div>
        </div>        
    </div>

</div>

<script type="text/javascript">
$(document).ready(function(){

    $('.edit-action').hide();
    $('.edit-order').click(function(){
        $('.edit-action').show();
       // alert(1);
    });


    $('#select_coupon').change(function(){
        if($(this).val()=='')
        {
            $('#apply_cpn').hide();
            $('#apply_cpn').trigger('click');
        }
        else{
            $('#apply_cpn').show();
        }
        // alert($(this).val());
    });

    $('#apply_cpn').click(function(e){
        $('#copuon_status').text('');
        var coupon_id=$('#select_coupon').val();
        // coupon_id=11;
        var send_data=new FormData();
        send_data.append('cid',coupon_id);

        $.ajax({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },

            type: "POST",
            url: "{{url('/chkcpn')}}",           
            data:send_data,
            async: false,
            dataType: 'json',
            success: function(res){
                console.log(res); 
                var st=parseFloat($('#subtotal').data('val'));
                if(res.status=="success")
                {
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
})

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

$(document).ready(function(){

    $(".edit-order").click(function() {
     var edit_status =$(this).attr('data-edit');
     var attr =$(this).attr('data-attr'); 
     if(edit_status == 'Accepted'){
         $('.edit'+attr).hide();
         $('.reject'+attr).css('display','block');
     }else{
         $('.edit'+attr).hide();
         $('.accept'+attr).css('display','block');
     }

    });

    $(".remove_edit_btn").click(function() {
          var attr_status =$(this).attr('data-attr');
          var attr =$(this).attr('attr-data');
       if(attr_status == "accept"){
          $('.edit'+attr).show();
          $('.accept'+attr).css('display','none');
       }else{
         $('.edit'+attr).show();
         $('.reject'+attr).css('display','none');
       }
    });

    $('.acceptorder').click(function() {
        var order_id=$(this).data('order_id');
        var item_id=$(this).data('item_id');
        var varient_id=$(this).data('varient_id');

        var send_data=new FormData();
        send_data.append('status','2');
        send_data.append('order_id',order_id);
        send_data.append('item_id',item_id);
        send_data.append('varient_id',varient_id);
        orderStatus($(this).parent().parent().parent(),send_data);     
    });

    $('.rejectorder').click(function() {
        var order_id=$(this).data('order_id');
        var item_id=$(this).data('item_id');
        var varient_id=$(this).data('varient_id');

        var send_data=new FormData();
        send_data.append('status','3');
        send_data.append('order_id',order_id);
        send_data.append('item_id',item_id);
        send_data.append('varient_id',varient_id);
        orderStatus($(this).parent().parent().parent(),send_data);     
    });

    $('#accept_all').click(function() {
        var order_id=$(this).data('order_id');
        var send_data=new FormData();
        send_data.append('status','2');
        send_data.append('order_id',order_id);
        accept_all(send_data);     
    });

    $('#reject_all').click(function() {
        var order_id=$(this).data('order_id');
        var send_data=new FormData();
        send_data.append('status','3');
        send_data.append('order_id',order_id);
        accept_all(send_data);     
    });

    $('#generate_bill').click(function() {
        var order_id=$(this).data('order_id');
        var send_data=new FormData();
        send_data.append('status','1');
        send_data.append('order_id',order_id);
        generate_bill(send_data);     
    });


});
// setInterval(function(){
//     $('audio #source').attr('src', "{{URL::asset('public/assets/sound/logoff.wav')}}");
//     $('audio').get(0).load();
//     $('audio').get(0).play();    
// }, 3000);
function orderStatus(row,data)
{
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },

        type: "POST",
        url: "{{url('/orderstatus')}}",           
        data:data,
        async: false,
        dataType: 'json',
        success: function(data){
/*            console.log(data); */
            if(data.status=='success'){
                // row.fadeOut('1000');
                window.location.reload();
            }
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });        

}

function accept_all(data)
{
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },

        type: "POST",
        url: "{{url('/acceptorder')}}",           
        data:data,
        async: false,
        dataType: 'json',
        success: function(data){
/*            console.log(data); */
            if(data.status=='success'){
                window.location.reload();

    //            alert('success');
                // $('#orderDetails').hide();
                // $('#'+data.res).show();                
            }
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });        

}

function generate_bill(data)
{
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
           },

        type: "POST",
        url: "{{url('/generatebill')}}",           
        data:data,
        async: false,
        dataType: 'json',
        success: function(data){
/*            console.log(data); */
            if(data.status=='success'){
                window.location.reload();

    //            alert('success');
                // $('#orderDetails').hide();
                // $('#'+data.res).show();                
            }
        },
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });        

}

function print_bill()
{    
    $('.alway_remove').remove();
    $('.not_print').remove();
    printDiv('print_kot');

    $("#print_kot").load(location.href + " #print_kot");
    // location.reload();
}

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}

update_read_status('{{$order_id}}');

function update_read_status(order_id)
{
    var send_data=new FormData();
    send_data.append('order_id',order_id);
    send_data.append('update_status','read');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        type: "POST",
        // url: "{{url('/get-details')}}",           
        url: "{{url('/get-neworder')}}",           
      //  data: 'id=' + id + '&restaurant_name=' +res_name+'&name='+name+'&email='+email+'&mobile='+mobile+'&feedback='+feedback + '&rating='+rating + '&file_img='+file,
        data:send_data,
        async: false,
        success: function(result){

            var newcontent='';
            var ind=1;

            if(result.status=='success')
            {                
                // console.log(result);   
            }
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
 $('.addItem').click(function(){
    var itemQty= $(this).parent().prev().val();
    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    var itemOrderid= itemDetail.data('itemorderid');
    var Orderid= itemDetail.data('orderid');
    var action = $(this).attr('data-type');
    var status = itemDetail.data('status');
    itemQty=parseInt(itemQty)+1;
    addItem(itemId,itemName,itemPrice,itemQty,itemOrderid,Orderid,action,status);
    var itemQty1 = pad_with_zeroes(itemQty, 1);
    // alert(itemQty1);
    $(this).parent().prev().val(itemQty1);
    //calcTotal();
   


  });
  $('.removeItem').click(function(){
    var itemQty= $(this).parent().next().val();
    var itemDetail = $(this).parent().parent();
    var itemId= itemDetail.data('itemid');
    var itemName= itemDetail.data('itemname');
    var itemPrice= itemDetail.data('price');
    var itemOrderid= itemDetail.data('itemorderid');
    var Orderid= itemDetail.data('orderid');
    var action = $(this).attr('data-type');
    var status = itemDetail.data('status');
    if(parseInt(itemQty)!=0)
     {
      itemQty=parseInt(itemQty)-1;
      removeItem(itemId,itemName,itemPrice,itemQty,itemOrderid,Orderid,action,status)
      var itemQty1 = pad_with_zeroes(itemQty, 1)
      $(this).parent().next().val(itemQty1);
      if(itemQty1<=0)
      {
        $(this).parent().next().val(0);
      //  $(this).parent().parent().parent().parent().parent().parent().remove();        
      }

    }
    // else{
    //    // $(this).parent().parent().parent().parent().parent().parent().remove();
    // }
   

  });


  function pad_with_zeroes(number, length) {
   var my_string = '' + number;
   while (my_string.length < length) {
    my_string = '0' + my_string;
   }
   return my_string;
   }

  function addItem(itemId,itemName,itemPrice,itemQty,itemOrderid,orderid,action,status)
   {

    var send_data=new FormData();
    send_data.append('action',action);
    send_data.append('item_id',itemId);
    send_data.append('item_name',itemName);
    send_data.append('item_price',itemPrice);
    send_data.append('item_qty',itemQty);
    send_data.append('item_orderid',itemOrderid);
    send_data.append('order_id',orderid);
    send_data.append('order_status',status);

     
    $.ajax({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },

            type: "POST",
            url: "{{url('/update-item-qty')}}",           
            data:send_data,
            async: false,
            dataType: 'json',
            success: function(res){
                if(res.status=="success"){ 
                location.reload();      
                }else{
                    alert('something went wrong!')
                }
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });  
        

}


function removeItem(itemId,itemName,itemPrice,itemQty,itemOrderid,orderid,action,status)
{
   
    var send_data=new FormData();
    send_data.append('action',action);
    send_data.append('item_id',itemId);
    send_data.append('item_name',itemName);
    send_data.append('item_price',itemPrice);
    send_data.append('item_qty',itemQty);
    send_data.append('item_orderid',itemOrderid);
    send_data.append('order_id',orderid);
    send_data.append('order_status',status);

     
    $.ajax({
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
               },

            type: "POST",
            url: "{{url('/update-item-qty')}}",           
            data:send_data,
            async: false,
            dataType: 'json',
            success: function(res){
                if(res.status=="success"){ 
                location.reload();      
                }    
               
            },
            cache: false,
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false
        });  
   
}



function calcTotal(){
  var subtotal=0, total=0, gst=0, cartCount=0;  
  <?php ?>
  <?php //if($find_resto->gst){ echo 'var taxPercent=5;'; } else { echo 'var taxPercent=0;'; } ?>
  $('.itemRow').each(function(){
    var price = $(this).find('.price').data('price');
    var qty = $(this).find('.input-number').val();
    cartCount+=parseInt(qty);
    subtotal+=price*qty;
  });

  $('.tax').each(function(){
    var rate= $(this).data('rate');
    var cur_tax=(subtotal*rate)/100;
    gst+=cur_tax;
    $(this).text(cur_tax);
  })

  total=subtotal+gst;
  gst=(subtotal*5)/100;
  $('.subtotal').text(subtotal);
  // $('.tax').text(gst);
  $('.finaltotal').text(total);
  $('.cart-icon').find('span').text(cartCount);
//  alert(total);
}

});

</script>   

@endsection