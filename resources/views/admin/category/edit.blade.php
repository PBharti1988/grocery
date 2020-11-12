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
                    <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="box-title m-b-0">Edit Category</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data">
                        {{ method_field('put') }}
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name</label>
                                <input type="text" name="category_name" value="{{$category->category_name}}" class="form-control"
                                    placeholder="Enter Category Name" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Parent Category<span class="color-required"></span></label>
                                <select class="form-control" name="parent_id">
                                <option value="">Select</option>
                                    @foreach($parent_category as $val)
                                    <option value="{{$val->id}}" @if($category->parent_id==$val->id) selected
                                @endif>{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <img src="{{asset('public/assets/images/category-icon/'.$category->icon)}}" width="50" height="50">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Category Logo</label>
                                <input type="file" class="form-control" name="category_logo"
                                    placeholder="">
                            </div>
                            <div class="form-row" style="margin-bottom:15px;">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Start Time</label>
                                    <input type="time" class="form-control" value="{{$category->start_time}}" name="start_time" id="" placeholder="start time">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">End Time</label>
                                    <input type="time" class="form-control" value="{{$category->end_time}}" name="end_time" id=""
                                        placeholder="end time">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Sort Order</label>
                                <input type="text" class="form-control" value="{{$category->sort_order}}" name="sort_order"
                                    placeholder="sort order" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                               <textarea class="form-control" name="description">{{$category->description}}</textarea>
                            </div>
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$category->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/category')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection
