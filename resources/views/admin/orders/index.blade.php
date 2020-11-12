@extends('admin.admin-layouts.app')
@section('content')
<?php $ruppeeSign=$currency_symbol; ?>
<style type="text/css">
    .unread{
        background: #f3faff;
        background: #ddf1a3;
        font-weight: 600;
        color:#111;
    }
</style>

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Orders</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('admin')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{url('order')}}">Orders</a></li>
                </ol>
               
             <!-- <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>
    
                <?php
                         if(isset($_GET['search'])){
                            $order =$_GET['order_number'];
                            $mobile=$_GET['mobile'];
                            $name=$_GET['customer_name'];
                          }else{
                            $order ="";
                            $mobile="";
                            $name="";        
                         }
                         ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <form  method="get">
                    {{ csrf_field() }}
                    <div class="row">
                       <input type="hidden" name="search" value="search">
                       <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputEmail4">Order Number</label>
                                    <input type="text" class="form-control" name="order_number" id="" placeholder="order number...">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile" id=""
                                        placeholder="mobile number...">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputPassword4">Customer name</label>
                                    <input type="text" class="form-control" name="customer_name" id=""
                                        placeholder="customer name...">
                                </div>
                                <div class="form-group col-md-1">
                                <button type="submit" style="margin-top:30px;" class="btn btn-primary width-sm waves-effect waves-light">Search</button>   
                                </div>
                                <a href="{{url('/order')}}" style="margin-top:34px; margin-left:10px;" ><i class="fa fa-refresh" aria-hidden="true"></i></a>   
                                              
                            </div>                                                                          
                    </div>
                   
                </form>
                    <h4 class="card-title">Order Table </h4>
                    @if($_GET && isset($_GET['search']))
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Order Date</th>
                                    <th>Room / Table No</th>
                                    <!-- <th>Daily Display Number</th> -->
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Delivey Type</th>
                                    <th>Order Status</th>
                                    <th style="min-width: 120px;">Total (<?php echo $ruppeeSign;?>)</th>  
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
// dd($orders)
                      ?>
                            @if(count($orders)>0)
                            @foreach($orders as $val)
                                <tr <?php if($val->view_status==0)echo 'class="unread"'; ?>>
                                    <td class="index">{{$i}}</td>
                                    <td>
                                        <a href="{{url('/order/'.$val->id.'/detail')}}">{{$val->order_id}}</a>
                                    </td>
                                    <td><?php echo date("d-M-Y", strtotime($val->created_at)); ?></td>
                                    <td>@if($val->table_name){{$val->table_name}}@else{{'Restaurant'}}@endif</td>                                
                                    <!-- <td>{{$val->daily_display_number}}</td>                                 -->
                                    <td><?php echo ucfirst($val->customer_name) ;?></td>
                                    <td><?php echo ucfirst($val->mobile_no) ;?></td>
                                    <td><?php  echo $val->address ;?></td>
                                    <td>{{$val->orderstatus}}</td>
                                    <td><?php echo $ruppeeSign;?> {{$val->total}}</td>                                                                                      
                                </tr>
                                <?php 
                                if($i==1)
                                {
                                    $latest_order_id=$val->id;
                                }
                                $i++ 
                                ?>
                              @endforeach    
                              
                              @else
                              <tr><td colspan="4"><h3>No record found</h3></td></tr>
                              @endif
                              
                            </tbody>
                        </table>
                        {{$orders->appends(['search'=>'search','order_number'=>$order,'mobile'=>$mobile,'customer_name'=>$name])->links()}}
                       
                    </div>

                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Number</th>
                                    <th>Order Date</th>
                                    <th>Room / Table No</th>
                                    <!-- <th>Daily Display Number</th> -->
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Delivey Type</th>
                                    <th>Order Status</th>
                                    <th style="min-width: 120px;">Total (<?php echo $ruppeeSign;?>)</th>  
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
// dd($orders)
                      ?>
                            @foreach($orders as $val)
                                <tr <?php if($val->view_status==0)echo 'class="unread"'; ?>>
                                    <td class="index">{{$i}}</td>
                                    <td>
                                        <a href="{{url('/order/'.$val->id.'/detail')}}">{{$val->order_id}}</a>
                                    </td>
                                    <td><?php echo date("d-M-Y", strtotime($val->created_at)); ?></td>
                                    <td>@if($val->table_name){{$val->table_name}}@else{{'Restaurant'}}@endif</td>                                
                                    <!-- <td>{{$val->daily_display_number}}</td>                                 -->
                                    <td><?php echo ucfirst($val->customer_name) ;?></td>
                                    <td><?php echo ucfirst($val->mobile_no) ;?></td>
                                    <td><?php  echo $val->address ;?></td>
                                    <td>{{$val->orderstatus}}</td>
                                    <td><?php echo $ruppeeSign;?> {{$val->total}}</td>                                                                                      
                                </tr>
                                <?php 
                                if($i==1)
                                {
                                    $latest_order_id=$val->id;
                                }
                                $i++ 
                                ?>
                              @endforeach                          
                              
                            </tbody>
                        </table>
                        {{$orders->links()}}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<audio controls style="position: absolute; bottom: -100%;">
    <source id="source" src="" type="audio/mpeg">1
    Your browser does not support the audio element.
</audio>

<script type="text/javascript">
var oid= '<?php if(isset($latest_order_id) && $latest_order_id !="" ) echo $latest_order_id; else echo "0";?>';

// oid = 147;
if('{{$orders->currentPage()}}'=='1')
{
    setInterval(function(){
        get_details(oid);
    },15000);
}

function get_details(order_id)
{
    var send_data=new FormData();
    send_data.append('order_id',order_id);
    // $('.preloader').fadeIn();
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
            ring_buzzer()
            console.log(result);

                $.each(result.data,function(index,val){
                
                    newcontent+='<tr class="unread"><td class="index">'+ind+'</td><td><a href="./order/'+val.id+'/detail">'+val.order_id+'</a></td><td>'+val.created_at+'</td><td>'+val.table_name+'</td><td>'+val.customer_name+'</td><td>'+val.mobile_no+'</td><td>'+val.address+'</td><td>'+val.orderstatus+'</td><td>'+val.total+'</td></tr>';
                    oid=result.data['0'].id;
                })
                ring_buzzer()
                $('.table tbody').prepend(newcontent);
                $('.index').each(function(){ $(this).html(ind); ind++;})
            }
            else
            {
                console.log(result);
            }
            // $('.preloader').fadeOut(500);


        },
        cache: true,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false
    });

} 

function ring_buzzer(){
    $('audio #source').attr('src', "{{URL::asset('public/assets/sound/piece-of-cake.mp3')}}");
    $('audio').get(0).load();
    $('audio').get(0).play();    
};


</script>





@endsection