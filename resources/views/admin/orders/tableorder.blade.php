@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tables</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Tables View</li>
                </ol>
               
             <!-- <a href="{{url('order/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>
    
<style type="text/css">
    .table-box{
        width: 90%;
        margin: 0 auto;
        border: 1px solid #eee;
        margin: 20px 0;
        border-radius: 8px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #333;
        font-size: 20px;
    }
    .table-title{
        text-transform: capitalize;
    }
    .itemcounting{
        position: absolute;
        top: 0;
        right: 10px;
        background: #555;
        height: 40px;
        width: 40px;
        border-radius: 50%;
        color: #ffffff;
        text-align: center;
        font-size: 17px;
        line-height: 40px;
    }
</style>
<?php // print_r($tables);  ?>
<?php //print_r($itemCount);?>
<?php
                      if(isset($_GET['search'])){
                            $table =$_GET['table_name'];
                          }else{
                           $table ="";                
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Table name<span class="color-required">*</span></label>
                                <input value="" type="text" class="form-control" id="" name="table_name"
                                    placeholder="search here..." required>
                            </div>
                        </div>
                        <div class="col-md-1">                
                        <button type="submit" style="margin-top:30px;" class="btn btn-primary width-sm waves-effect waves-light">Search</button>                   
                        </div>
                                              
                       <a href="{{url('/table-order')}}" style="margin-top:34px; margin-left:10px;" ><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                       
                    </div>
                   
                </form>
                    <h4 class="card-title">Table Order View</h4>                 
                    <!-- <div class="table-responsive"> -->
                        <div class="row">
                        @if($_GET && isset($_GET['search']))
                        @if(count($tables) >0)
                        <?php foreach($tables as $table) { ?>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <a href="{{url('table-order/')}}/{{$table->id}}">
                                    <div class="table-box">
                                        <div class="table-title"><?php echo $table->table_name; $id = $table->id; ?></div>
                                        <?php if(isset($itemCount[$id])) echo '<div class="itemcounting">'.$itemCount[$id].'</div>';?>
                                    </div>
                                </a>
                            </div>
                            <?php }?> 
                            @else
                           <div><h3>No table found</h3></div>
                            @endif
                        @else

                            <?php foreach($tables as $table) { ?>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <a href="{{url('table-order/')}}/{{$table->id}}">
                                    <div class="table-box">
                                        <div class="table-title"><?php echo $table->table_name; $id = $table->id; ?></div>
                                        <?php if(isset($itemCount[$id])) echo '<div class="itemcounting">'.$itemCount[$id].'</div>';?>
                                    </div>
                                </a>
                            </div>
                            <?php }?> 
                            @endif
<!--                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 2</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 3</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 4</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 5</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 6</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 7</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 8</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 9</div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-md-3 col-sm-6">
                                <div class="table-box">
                                    <div class="table-title">Table 10</div>
                                </div>
                            </div> -->
                        </div>





                        <?php 

                        /* ?>



                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order No</th>
                                    <th>Table</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
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
                      ?>
                            @foreach($orders as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->order_id}}</td>                                  
                                    <td>{{$val->table_name}}</td>
                                    <!-- <td>{{$val->daily_display_number}}</td>                                   -->
                                    <td>{{$val->item_name}} @if($val->variety_name)- ({{$val->variety_name}})@endIf</td>
                                    <td>{{$val->quantity}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-xs acceptorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                <i class="fa fa-edit"></i> Accept </button>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-danger btn-xs rejectorder" data-order_id="{{$val->order_id}}" data-item_id="{{$val->item_id}}" data-varient_id="{{$val->varient_id}}">
                                                <i class="fa fa-edit"></i> Reject </button>
                                        </div>
                                     </td>

                                                                                      
                                </tr>
                                <?php $i++ ?>
                              @endforeach                          
                              
                            </tbody>
                        </table>

                        <?php 

                        */ ?>
                    <!-- </div> -->
                </div>
            </div>
        </div>

    </div>
</div>


@endsection