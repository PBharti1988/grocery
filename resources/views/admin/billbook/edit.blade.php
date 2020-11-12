@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Order</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Order</li>
                </ol>
                <!-- <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>
                    Create New</button> -->

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Edit Table</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">

                        <div class="tsf-nav-step">
                            <!-- BEGIN STEP INDICATOR-->
                            <ul class="gsi-step-indicator triangle gsi-style-1 gsi-transition">
                                <li class="current" data-target="step-1">
                                    <a href="#0">
                                        <span class="number">1</span>
                                        <span class="desc">
                                            <label>New</label>
                                        </span>
                                    </a>
                                </li>
                                <li data-target="step-2" class="">
                                    <a href="#0">
                                        <span class="number">2</span>
                                        <span class="desc">
                                            <label>Confirmed</label>
                                        </span>
                                    </a>
                                </li>
                                <li data-target="step-3" class="">
                                    <a href="#0">
                                        <span class="number">
                                            3
                                        </span>
                                        <span class="desc">
                                            <label>Kitchen</label>
                                        </span>
                                    </a>
                                </li>
                                <li data-target="step-4" class="">
                                    <a href="#0">
                                        <span class="number">
                                            4
                                        </span>
                                        <span class="desc">
                                            <label>Complete</label>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <!-- END STEP INDICATOR--->
                        </div>
                        <form method="post" action="{{route('order.update',$order->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <?php // print_r($order);?>
                            <?php //print_r($orderItems);?>

                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/order')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->