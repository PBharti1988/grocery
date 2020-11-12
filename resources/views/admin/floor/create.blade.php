@extends('admin.admin-layouts.app')   
@section('content')

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Floor</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Floor</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Add Floor</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('floors.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Floor Name</label>
                                <input type="text" name="floor_name" class="form-control" placeholder="Enter Floor Name" required>
                            </div>
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1" checked>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/floors')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
