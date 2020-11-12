@extends('admin.admin-layouts.app')
@section('content')

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Shelf</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Shelf</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Edit Shelf</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('shelves.update',$shelf->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Floor Name</label>
                                <select class="form-control" name="floor_id">
                                    <option value="">Select</option>
                                    @foreach($floors as $val)
                                    <option value="{{$val->id}}" @if($shelf->floor_id==$val->id) selected @endif>
                                    {{$val->floor_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Shelf Number</label>
                                <input type="text" name="shelf_number" value="{{$shelf->shelf_number}}" class="form-control" placeholder="Enter Shelf Number" required>
                            </div>
                            <img src="{{asset('public/assets/images/shelves/'.$shelf->shelf_image)}}" width="50" height="50">
                            <div class="form-group">
                                <label for="shelf">Image</label>
                                <input type="file" class="form-control" name="image" placeholder="">
                            </div>
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1" {{$shelf->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/shelves')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
