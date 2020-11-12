@extends('admin.admin-layouts.app')
@section('content')
<?php $ruppeeSign=$currency_symbol; ?>

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{__('Bill Book')}}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">Billbook</li>
                </ol>
               
             <!-- <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>
    


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{__('Bill List')}} </h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Date</th>
                                    <th>Bill Number</th>
                                    <th>Order Number</th>
                                    <!-- <th>Table Id</th> -->
                                    <th>Customer Name</th>
                                    <th>Mobile No</th>
                                    <th>Order Status</th>
                                    <th>Total (<?php echo $ruppeeSign;?>)</th>  
                                    <th>Action</th>  
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
                      // dd($orders);
                      ?>
                            @foreach($orders as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><?php echo date("d-M-Y", strtotime($val->created_at)); ?></td>
                                    <td><a href="{{url('/billbook/'.$val->id.'/detail')}}">{{$val->bill_number}}</a> </td>
                                    <td><?php   echo $val->order_number ;?></td>
                                    <!-- <td>{{$val->table_id}}</td>                                 -->
                                    <td><?php   echo $val->customer_name ;?></td>
                                    <td><?php echo $val->mobile_no ;?></td>
                                    <td>{{$val->orderstatus}}</td>
                                    <td><?php echo $ruppeeSign;?> {{$val->total}}</td>                                                                                      
                                    <td><a href="{{url('/billbook/'.$val->id.'/detail')}}"> View Details</a></td>                                                                                      
                                </tr>
                                <?php $i++ ?>
                              @endforeach                          
                              
                            </tbody>
                        </table>
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection