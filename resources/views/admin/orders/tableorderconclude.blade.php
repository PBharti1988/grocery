@extends('admin.admin-layouts.app')
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
               
             <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
<?php 
if($bill_id!='')
{

echo 'Bill is generated Successfully: <a href="'.url('/').'/billbook/'.$bill_id.'/detail">'.'Checkbill'.'</a>';
    
}
else{
echo 'No orders found to process.';

}

?>

</h4>
                    @if($bill_id!='')
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
                                    <td>{{$val->order_number}}</td>                                  
                                    <td>{{$val->table_name}}</td>
                                    <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>{{$val->price}}</td>
                                    <td>{{$val->quantity*$val->price}}<?php $subtotal+=$val->quantity*$val->price;?></td>

                                                                                      
                                </tr>
                                <?php $i++ ?>
                              @endforeach 
                              <?php if(count($orders) > 0) { ?>                         
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Sub Total</td>
                                    <td>{{$subtotal}}</td>
                                </tr>
                                @if($billdetails->discount!='0')
                                <tr class="discount_section active">
                                    <td colspan="4"></td>
                                    <td colspan="2">Discount Applied <span id="applied_coupon">({{$discount_details->coupon_code}})</span> </td>
                                    <td id="discounted_amt">{{$billdetails->discount}}</td>
                                </tr>
                                @endif

                  <?php 
                  $taxAmt=0;
                  $totalTax=0;
// todo: add tax module check here
                  // if($find_resto->gst)
                    
                    if($bill_taxes)
                    {
                        if(count($bill_taxes)>0)
                        {                      
                            foreach($bill_taxes as $tax)
                            {

                                $taxAmt= $tax->tax_amount;
                                $totalTax+=$taxAmt; 


                                echo '<tr>
                                        <td colspan="4"></td>
                                        <td colspan="2">'.$tax->tax_name.'  ('.$tax->tax_value.'%)</td>
                                        <td>'.$taxAmt.'</td>
                                    </tr>';                              
                            }
                        }
                        else
                        {
                            echo '<tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Tax (Inclusive in price)</td>
                                    <td>'.$taxAmt.'</td>
                                </tr>';

                        }
                    } 
                    else 
                    {
                      echo '<tr>
                                <td colspan="4"></td>
                                <td colspan="2">Tax (Inclusive in price)</td>
                                <td>'.$taxAmt.'</td>
                            </tr>';
                    }
                  ?>

                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">Total:</td>
                                    <td><?php
                                    // echo $subtotal+$totalTax; ?>
                                        {{$billdetails->total}}
                                        
                                    </td>
                                </tr>
                                <?php } 
                                else{
                                    echo '<tr><td colspan="7">No Record Found</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    @endif
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