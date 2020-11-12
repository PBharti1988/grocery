@extends('admin.admin-layouts.app')
@section('content')
<?php $subtotal=0.00;
$tax=0.00;
$total=0.00; ?>
<?php $ruppeeSign=$currency_symbol; ?>

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Bill Detail</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Bill Book</li>
                </ol>

                <!-- <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>
    
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
                                        // echo '<span>Order No: '.$billdetails->order_number . '</span>';
                                }
                                ?>
                                <?php
                                if(isset($billdetails->payment_id) && $billdetails->payment_id!='')
                                {
                                    echo '<span>Transaction No: '.$billdetails->payment_id . '</span>';
                                }
                                ?>
                            </div>
                        </h4>
                        <?php
                        if(isset($billdetails->id))
                        {
                                // $billtime = cnvt_UTC_to_usrTime($billdetails->created_at,'Asia/Kolkata');

                                // dd($billtime);
                                // date_default_timezone_set('Asia/Kolkata');

                            $invoice_link='';
                            if(isset($billdetails->payment_id) && $billdetails->payment_id!='')
                            {
                                $invoice_link= '<a target="_blank" href="'.url('/').'/invoice/'.$billdetails->id.'/">View Invoice</a>';
                            }



                            echo '<p class="billdetail_strip"><b><span>Store Name: '.$billdetails->restaurant_name . '</span></b> <span style="float: right;"> Bill Date: '.date("M d, Y h:i A", strtotime(cnvt_UTC_to_usrTime($billdetails->created_at,'Asia/Kolkata'))) . '</span></p>';
                            if($billdetails->table_name)
                                echo '<p class="billdetail_strip"><span>Room / Table No: '.$billdetails->table_name . '</span> <span style="float: right;"></span></p>';
                            if($billdetails->customer_name)
                                echo '<p class="billdetail_strip"><span>Customer Name: '.$billdetails->customer_name . '</span> <span style="float: right;"></span></p>';
                            if($billdetails->mobile_no)
                                echo '<p class="billdetail_strip"><span>Mobile No: '.$billdetails->mobile_no . '</span> <span style="float: right;">'.$invoice_link.'</span></p>';
                            echo '<div style="float: none;clear:both;"></div>';

                        }
                        ?>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>Order No</th> -->
        <th>Table</th>
        <!-- <th>Veg / Non-veg</th> -->
        <th>Item</th>
        <th>Quantity</th>
        <th>Rate</th>                                
        <th>Price (<?php echo $ruppeeSign;?>)</th>                                
    </tr>
</thead>
<tbody>
    <?php
    $i = 1;
    if (isset($_REQUEST['page'])) {
      $page_no = $_REQUEST['page'];
      $i = ($page_no - 1) * 10 + 1;
  }
  ?>
  @foreach($orders as $val)
  <tr>
    <td>{{$i}}</td>
    <!-- <td>{{$val->order_number}}</td>                                   -->
    <td>{{$val->table_name}}</td>
    <!-- <td>{{$val->daily_display_number}}</td>                                   -->
    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
    <td>{{$val->quantity}}</td>
    <td>{{$val->price}}</td>
    <td>{{$val->quantity*$val->price}}<?php $subtotal+=$val->quantity*$val->price;?></td>


</tr>
<?php $i++ ?>
@endforeach 
<?php 
if(count($orders) > 0) 
{
    ?>                         
    <tr>
        <td colspan="3"></td>
        <td colspan="2">Sub Total</td>
        <td>{{$subtotal}}</td>
    </tr>
    @if($billdetails->discount!='0')
    <tr class="discount_section active">
        <td colspan="3" style="border: none;"></td>
        <td colspan="2">Discount Applied <span id="applied_coupon">({{$discount_details->coupon_code}})</span> </td>
        <td id="discounted_amt">{{$billdetails->discount}}</td>
    </tr>
    @endif
    <?php 
    if($gstDetails->gst)
    { 

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
                    <td colspan="3" style="border: none;"></td>
                    <td colspan="2">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</td>
                    <td>'.$taxAmt.'</td>
                    </tr>';                              
                }
            }
            else
            {
                echo '<tr>
                <td colspan="3" style="border: none;"></td>
                <td colspan="2">Tax (Inclusive in price)</td>
                <td>'.$taxAmt.'</td>
                </tr>';
            }
        } 
        else 
        {
            echo '<tr>
            <td colspan="3" style="border: none;"></td>
            <td colspan="2">Tax (Inclusive in price)</td>
            <td>'.$taxAmt.'</td>
            </tr>';
        }

    ?>                              

    <?php   
    } 
    else 
    {
    ?>
        <tr>
            <td colspan="3" style="border: none;"></td>
            <td colspan="2">Tax: (Inclusive in Price)</td>
            <td><?php echo $totalTax=0;?> </td>
        </tr>                                    

    <?php 
    } 
    ?>
    <tr style="font-weight: 600;">
        <td colspan="3" style="border: none;"></td>
        <td colspan="2">Total:</td>
        <td><?php // echo ( $totalTax + $subtotal);?> {{$billdetails->total}}</td>
    </tr>
<?php 
} 
else
{
    echo '<tr><td colspan="7">No Record Found</td></tr>';
}
?>
</tbody>
</table>


</div>
</div>
@if($billdetails->payment_id=='')
<form action="" method="post" name="myForm" style="text-align: center;">
    {{ csrf_field() }}
    <input type="hidden" name="mobile_no" value="{{$billdetails->mobile_no}}">
    <input type="hidden" name="amount" value="{{$billdetails->total}}">
    <input type="hidden" name="bill_id" value="{{$billdetails->id}}">
    <input type="hidden" name="table_id" value="{{$billdetails->table_id}}">
    <input type="hidden" name="order_id" value="{{$billdetails->order_id}}">
    <input type="hidden" name="payment_mode" value="cash"/>
    <button type="submit" class="btn btn-success btn-lg"> Accept Cash Payment</button>
</form>
@endIf



</div>
</div>
</div>

</div>
</div>

<script type="text/javascript">

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

@endsection