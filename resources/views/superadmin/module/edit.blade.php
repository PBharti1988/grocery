@extends('superadmin.superadmin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Module</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Module</li>
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
                <h3 class="box-title m-b-0">Edit Resturant</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('module.update',$module->id)}}" enctype="multipart/form-data">
                        {{method_field('put')}}
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Module Name</label>
                                <input type="text" name="module_name" value="{{$module->module_name}}" class="form-control"
                                    placeholder="Enter module " required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <input type="text" name="description" value="{{$module->description}}" class="form-control" id=""
                                    placeholder="Enter description">
                            </div>
                           
                       
                         

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/module')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection
