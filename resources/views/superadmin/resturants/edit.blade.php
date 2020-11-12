@extends('superadmin.superadmin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Resturant</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Resturant</li>
                </ol>
                @if(checkForCopy($restaurant->id) == "")
                <a href="{{url('restaurant/'.$restaurant->id.'/menu-copy')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-pencil"></i>Copy Menu</a> 
                 @endif
                <a href="{{url('restaurant/'.$restaurant->id.'/role')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-pencil"></i>Add Role</a> 
                <a href="{{url('restaurant/'.$restaurant->id.'/config')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-pencil"></i>Restaurant Config</a> 
                
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
                        
                        <form method="post" action="{{route('restaurant.update',$restaurant->id)}}" enctype="multipart/form-data">
                        {{method_field('put')}}
                        {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Resturant Name</label>
                                <input type="text" name="name" value="{{$restaurant->name}}" class="form-control"
                                    placeholder="Enter Resturant Name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Resturant Handle</label>
                                <input type="text" name="handle" value="{{$restaurant->handle}}" class="form-control"
                                    placeholder="Enter Resturant URL Handle" required >
                                    <!-- readonly="readonly" -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input type="text" name="address" value="{{$restaurant->address}}" class="form-control" id=""
                                    placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contact No.</label>
                                <input type="text" name="contact_number" value="{{$restaurant->contact_number}}" class="form-control" id=""
                                    placeholder="Conact Number"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="email" class="form-control" value="{{$restaurant->email}}" readonly name="email"
                                    placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Latitude</label>
                                <input type="text" class="form-control" value="{{$restaurant->latitude}}" name="latitude"
                                    placeholder="Enter Latitude" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Longitude</label>
                                <input type="text" class="form-control" value="{{$restaurant->longitude}}" name="longitude"
                                    placeholder="Enter Longitude" required>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Currency</label>
                                <select name="currency" required class="form-control">
                                    <option value="">select</option>
                                    @foreach($currency as $val)
                                    <option value="{{$val->code}}"@if($restaurant->currency==$val->code) selected
                                        @endif>{{$val->code}} ( {{$val->symbol}} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Manager Name</label>
                                <input type="text" class="form-control" value="{{$restaurant->manager_name}}" name="manager_name"
                                    placeholder="Enter Manager Name" required>
                            </div>
                            <img src="{{asset('public/assets/restaurant-logo/'.$restaurant->logo)}}" width="50"
                                height="50">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Logo</label>
                                <input type="file" class="form-control" name="resturant-logo"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Text Title</label>
                                <input type="text" class="form-control" value="{{$restaurant->text_title}}" name="text_title"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Text Detail</label>
                                <input type="text" class="form-control" value="{{$restaurant->text_detail}}" name="text_detail"
                                    placeholder="">
                            </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/restaurant')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection
