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
<?php $subtotal=0.00;
$tax=0.00;
$total=0.00; ?>

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Orders</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Table</li>
                </ol>
               
           
            </div>
        </div>
    </div>
    

   
    <?php  
       $lastest_orderid="";
       if(count($orders)>0){
       for($i=0; $i<1;$i++){
        $lastest_orderid=$orders[$i]->order_id;
        $order_type="accepted";
       }
    }else{
        $lastest_orderid=0;
    }

    ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Table Item Details  @if($lastest_orderid > 0) <a style="max-width: 120px; float:right; margin: 0 0 10px 8px;" class="btn btn-primary" href="{{url('add-more-to-order/'.$lastest_orderid.'/'.$order_type.'/'.$tid)}}">Add More Item</a>@endif  @if(count($orders)>0)<a href="#" style="clear: both;"> <span style="max-width: 120px; float:right; margin: 0 0 10px 8px;" class="btn btn-info edit-order" ><i class="fa fa-edit"></i>Edit Item</a>@endif  <a href="{{url('table-order/')}}/{{$tid}}" style="clear: both;"> <span style="max-width: 120px; float: right; margin: 0 0 10px 0;" class="btn btn-success" ><i class="fa fa-refresh"></i> Refresh</span></a></h4>
                   
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No</th>
                                    <th>Table</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>                                
                                    <th>Price</th>      
                                    <th class="edit-action">Action</th>                            
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
                      $totalcartCount=0;
                      ?>
                    
                            @foreach($orders as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->order_number}}</td>                                  
                                    <td>{{$val->table_name}}</td>
                                    <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>{{$val->price}}</td>
                                    <td>{{$val->quantity*$val->price}}<?php $subtotal+=$val->quantity*$val->price;?></td>
                                    <td class="border-0 align-middle edit-action">
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
                                 </td>

                                                                                      
                                </tr>
                                <?php $i++ ?>
                              @endforeach 
                              <?php if(count($orders) > 0) { ?>                         
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Sub Total</td>
                                    <td id="subtotal" data-val="{{$subtotal}}">{{$subtotal}}</td>
                                </tr>
                                <tr class="discount_section">
                                    <td colspan="4"></td>
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
                                        <td colspan="4"></td>
                                        <td colspan="2">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</td>
                                        <td class="taxamt" data-taxp="'.$tax->tax_value.'">'.$taxAmt.'</td>
                                    </tr>';                              
                            }
                        }
                        else
                        {
                            echo '<tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Tax (Inclusive in price)</td>
                                    <td class="taxamt" data-taxp="0">'.$taxAmt.'</td>
                                </tr>';

                        }
                    } 
                else 
                    {
                      echo '<tr>
                                <td colspan="4"></td>
                                <td colspan="2">Tax (Inclusive in price)</td>
                                <td class="taxamt" data-taxp="0">'.$taxAmt.'</td>
                            </tr>';
                    }
                  ?>

                                <tr>
                                    <td colspan="4"></td>
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

                    <form method="post" action="{{url('/')}}/table-order/{{$tid}}/conclude" enctype="multipart/form-data">
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

<!--                                 <a href="{{url('table-order/')}}/{{$tid}}/conclude"  class=" center" style="clear: both;"> <span style=" right; margin: 0 0 10px 0;" class="btn btn-success" >Conclude Bill <i class="fa fa-file-text-o"></i></span></a> -->
                            </div>
                        </div>
                    </form>
                <?php } ?>
            
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
    $('.acceptorder').click(function() {
        var order_id=$(this).data('order_id');
        var item_id=$(this).data('item_id');
        var varient_id=$(this).data('varient_id');

        var send_data=new FormData();
        send_data.append('status','1');
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
        send_data.append('status','2');
        send_data.append('order_id',order_id);
        send_data.append('item_id',item_id);
        send_data.append('varient_id',varient_id);
        orderStatus($(this).parent().parent().parent(),send_data);     
    });
});
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
                row.fadeOut('1000');
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
     // alert(itemQty);
      removeItem(itemId,itemName,itemPrice,itemQty,itemOrderid,Orderid,action,status)
      var itemQty1 = pad_with_zeroes(itemQty, 1)
      $(this).parent().next().val(itemQty1);
      if(itemQty1 <=0)
      {
        $(this).parent().next().val(0);
       
      //  $(this).parent().parent().parent().parent().parent().parent().remove();        
      }

   }
   
   

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
              //  console.log(res);
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