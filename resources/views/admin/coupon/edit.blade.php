

@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Coupon</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Coupon</li>
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
                <h3 class="box-title m-b-0">Edit Coupon</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                    <form method="post" action="{{route('coupon.update',$coupon->id)}}" enctype="multipart/form-data">
                        {{ method_field('put') }}
                            {{csrf_field()}}                          
                            <div class="form-group">
                                <label for="exampleInputEmail1">Coupon Type</label>
                              <select class="form-control" name="coupon_type" required>
                              <option value="">Select</option>
                                  <option value="percentage"@if($coupon->coupon_type=='percentage') selected
                                        @endif>Percentage</option>
                                  <option value="fixed"@if($coupon->coupon_type=='fixed') selected
                                        @endif>Fixed</option>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Titile</label>
                                <input type="text" name="title" class="form-control"
                                    placeholder="Enter title" value="{{$coupon->title}}" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <input type="text" name="description" class="form-control"
                                    placeholder="Enter some description" value="{{$coupon->description}}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Coupon Code</label>
                                <input type="text" maxlength="20" class="form-control" name="coupon_code"
                                    placeholder="Enter code" value="{{$coupon->coupon_code}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Coupon Value</label>
                                <input type="text" maxlength="8" class="form-control" name="coupon_value"
                                    placeholder="Enter value" value="{{$coupon->coupon_value}}" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Max Discount (If blank then no limit)</label>
                                <input type="number" class="form-control" name="max_discount"
                                    placeholder="Set max discount limit" value="{{$coupon->max_discount}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Coupon Count</label>
                                <input type="text" maxlength="6" class="form-control" name="coupon_count"
                                    placeholder="Enter count" value="{{$coupon->count}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                            </div>
                            
                            <div class="form-group">
                                <input type="text"  style="width:191px;" class="form-control" value="{{$coupon->start_date}}" id="start_date" name="start_date"
                                    placeholder="Start Date" required>
                                    <input type="text" style="width:191px;" class="form-control" value="{{$coupon->end_date}}" id="end_date" name="end_date"
                                    placeholder="End Date" required>
                            </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                            {{$coupon->enabled == 1 ? 'checked': ''}}>
                            <label class="custom-control-label" for="customSwitch1">Enabled</label>
                        </div>
                    </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/coupon')}}">Back</a>
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








