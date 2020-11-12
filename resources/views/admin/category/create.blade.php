@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Category</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Category</li>
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
                <h3 class="box-title m-b-0">Add Category</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name</label>
                                <input type="text" name="category_name" class="form-control"
                                    placeholder="Enter Category Name" required>
                            </div>

                            <div class="form-group">
                                <label for="name">Parent Category<span class="color-required"></span></label>
                                <select class="form-control" name="parent_id">
                                    <option value="">Select</option>
                                    @foreach($category as $val)
                                    <option value="{{$val->id}}">{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Category Logo</label>
                                <input type="file" class="form-control" name="category_logo" placeholder="" required>
                            </div>

                            <div class="form-row" style="margin-bottom:15px;">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Start Time</label>
                                    <input type="time" class="form-control" name="start_time" id="" placeholder="start time">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">End Time</label>
                                    <input type="time" class="form-control" name="end_time" id=""
                                        placeholder="end time">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                  
                                <input type="time"  style="width:191px;" class="form-control"  id="start_time" name="start_time"
                                    placeholder="Start Time">
                                    <input type="time" style="width:191px;" class="form-control" id="end_time" name="end_time"
                                    placeholder="End Time">
                            </div> -->
                            <div class="form-group">
                                <label for="exampleInputPassword1">Sort Order</label>
                                <input type="text" class="form-control" name="sort_order" placeholder="sort order"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>

                            <!-- <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                {{old('Enabled') == 'on' ? 'checked': ''}}>
                            <label class="custom-control-label" for="customSwitch1">Enabled</label>
                        </div>
                    </div> -->

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light"
                                href="{{url('/category')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection