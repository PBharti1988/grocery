@extends('admin.admin-layouts.app')
@section('content')
<?php $ruppeeSign='&#8377;'; ?>

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Payments Report</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Payments Report</li>
                </ol>
               
            
            </div>
        </div>
    </div>
    <?php
                      if(isset($_GET['search'])){
                            $from =$_GET['from_date'];
                             $to = $_GET['to_date'];
                             
                             if($_GET['mode'] !=""){
                              $mode =$_GET['mode'];
                             }else{
                                 $mode="blank";
                                
                             }
                            
                          }else{
                           $from ="";
                           $to ="";
                          
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name">From Date<span class="color-required">*</span></label>
                                <input value="" type="text" class="form-control" id="from_date" name="from_date"
                                    placeholder="Enter From Date" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name">To Date<span class="color-required">*</span></label>
                                <input value="" type="text" class="form-control" id="to_date" name="to_date"
                                    placeholder="Enter To Date" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="name">Status<span class="color-required"></span></label>
                                <select name="mode" class="form-control">
                                <option value="">select</option>
                               <option value="paypal">Paypal</option>
                               <option value="stripe">Stripe</option>
                               <option value="payu">Payu Money</option>
                               <option value="razor">Razor Pay</option>
                               <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">                
                        <button type="submit" style="margin-top:30px;" class="btn btn-primary width-sm waves-effect waves-light">Search</button>                   
                        </div>
                                              
                       <a href="{{url('payment-reports')}}" style="margin-top:34px; margin-left:10px;" ><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                       
                    </div>
                   
                </form>
                
                @if($_GET && isset($_GET['search']))
                <p> <a class="btn btn-info btn-addon btn-sm pull-right" href="{{url('/payment-export-new/'.$_GET['from_date'].'/'.$_GET['to_date'].'/'.$mode)}}">
                        <i class="fa fa-level-up"></i>Export</a></p>
                 @else
                 <p> <a class="btn btn-info btn-addon btn-sm pull-right" href="{{url('/payment-export')}}">
                        <i class="fa fa-level-up"></i>Export</a></p>               
                 @endif
                    <h4 class="card-title">Order Report</h4>
                    @if($_GET && isset($_GET['search']))

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                    <th>#</th>
                                    <th>Payment ID</th>
                                    <th>Mobile No.</th>
                                    <th>Payment Mode</th>
                                    <th>Amount (<?php echo $ruppeeSign;?>)</th>  
                                    <th>Order Date</th>  
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
                                   @if(count($payments) > 0)
                                  @foreach($payments as $val)
                                  <tr>
                                    <td>{{$i}}</td>
                                    <!-- <td>
                                    <a href="{{url('/order/'.$val->id.'/order-detail')}}">{{$val->order_id}}</a>
                                    </td> -->
                                    <td>{{$val->payment_id}}</td>                                
                                    <td>{{$val->mobile_no}}</td>
                                    <td>{{$val->payment_mode}}</td>
                                    <td><?php echo $ruppeeSign;?> {{$val->amount}}</td>    
                                    <td><?php echo date("d-M-Y", strtotime($val->created_at)); ?></td>                                                                                         
                                </tr>                               
                                <?php $i++ ?>                          
                                    @endforeach
                                    @else
                             <tr><td>No record</td></tr>
                                @endif
                            </tbody>
                        </table>
                        @if(count($payments) > 0)
                        {{$payments->appends(['search'=>'search','from_date'=>$from,'to_date'=>$to,'mode'=>$mode])->links()}}
                        @endif

                    </div>

                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                    < <th>#</th>
                                    <th>Payment ID</th>
                                    <th>Mobile No.</th>
                                    <th>Payment Mode</th>
                                    <th>Amount (<?php echo $ruppeeSign;?>)</th> 
                                    <th>Order Date</th>   
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
                                 @if(count($payments) > 0)
                                  @foreach($payments as $val)
                                  <tr>
                                    <td>{{$i}}</td>
                                    <!-- <td>
                                        <a href="{{url('/order/'.$val->id.'/order-detail')}}">{{$val->order_id}}</a>
                                    </td> -->                             
                                    <td>{{$val->payment_id}}</td>                                
                                    <td>{{$val->mobile_no}}</td>
                                    <td>{{$val->payment_mode}}</td>
                                    <td><?php echo $ruppeeSign;?> {{$val->amount}}</td>    
                                    <td><?php echo date("d-M-Y", strtotime($val->created_at)); ?></td>                                                                                  
                                </tr>
                                <?php $i++ ?>
                                    @endforeach

                                    @else
                                    <tr>
                                    <td>No record</td>
                                </tr>
                                    @endif
                            </tbody>
                        </table>
                        @if(count($payments) > 0)
                        {{$payments->links()}}
                          @endif
                    </div>

                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#from_date,#to_date').flatpickr({
        dateFormat: "Y-m-d",
    });

});
</script>
@endsection