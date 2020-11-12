@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Orders</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Orders Detail</li>
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
                           
                           
                        </div>
                    </h4>
                   
                <div id="print_kot">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No</th>
                                    <!-- <th>Table</th> -->
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th class="alway_remove">Status</th>                                
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
                                @foreach($order_items as $val)
                                <tr class="@if($val->order_status != 2) not_print @endif">
                                    <td>{{$i}}</td>
                                    <td>{{$val->order_number}}</td>                                  
                                    <!-- <td>{{$val->table_name}}</td> -->
                                    <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>{{$val->price}}</td>
                                    <td class="alway_remove">
                                        {{$val->order_status_name}}

                                     </td>
                                </tr>
                                <?php $i++ ?>
                                @endforeach                          
                              
                            </tbody>
                        </table>
                        {{$order_items->links()}}
                    </div>
                </div>
                        </div>
            </div>
        </div>
    </div>

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
    location.reload();
}

function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}




</script>

@endsection