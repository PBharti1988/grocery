@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Table</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Table</li>
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
                        <form method="post" action="{{route('table.update',$table->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Table Name</label>
                                <input type="text" name="table_name" value="{{$table->table_name}}" class="form-control"
                                    placeholder="Enter Table Name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Short Description</label>
                                <input type="text" name="short_description" value="{{$table->short_description}}"
                                    class="form-control" placeholder="Enter short Description" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Long Description</label>
                                <textarea class="form-control" value=""
                                    name="long_description">{{$table->long_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input"
                                        id="customSwitch1" {{$table->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>

                                <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/table')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->