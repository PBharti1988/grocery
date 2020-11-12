@extends('superadmin.superadmin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Currency</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Currency</li>
                </ol>
                <!-- <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>
                    Create New</button> -->

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
        @include('superadmin.superadmin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Add Currency</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('currency.store')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter name " required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Code</label>
                                <input type="text" name="code" maxlength="3" class="form-control"
                                    placeholder="Enter code " required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Symbol</label>
                                <input type="text" name="symbol" class="form-control"
                                    placeholder="Enter symbol " required>
                            </div>
                          
                        
                       
                         

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/currency')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection
