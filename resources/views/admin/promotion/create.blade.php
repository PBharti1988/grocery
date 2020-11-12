@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Promotion</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Promotion</li>
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
                <h3 class="box-title m-b-0">Add Promotion</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('promotion.store')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                        
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Enter tax Name" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label>
                                <input type="file" class="form-control" name="file"
                                    placeholder="Enter file" required>
                            </div>
                            <div class="form-group">
                                <input type="text"  style="width:191px;" class="form-control"  id="start_date" name="start_date"
                                    placeholder="Start Date" required>
                                    <input type="text" style="width:191px;" class="form-control" id="end_date" name="end_date"
                                    placeholder="End Date" required>
                            </div>
                          
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                {{old('Enabled') == 'on' ? 'checked': ''}}>
                            <label class="custom-control-label" for="customSwitch1">Enabled</label>
                        </div>
                    </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/promotion')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>
<script>
$(document).ready(function() {
    $('#start_date,#end_date').flatpickr({
        dateFormat: "Y-m-d",
    });

});
</script>

@endsection
