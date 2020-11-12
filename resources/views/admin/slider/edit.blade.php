@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Slider</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Slider</li>
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
                <h3 class="box-title m-b-0">Edit Slider</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('sliderupdate',$area->id)}}" enctype="multipart/form-data">
                  
                        {{csrf_field()}}
                       
                             <div class="form-group">
                                <label for="slider_name">Slider Name</label>
                                <input type="text" id="slider_name" name="slider_name" value="{{$area->slider_name}}" class="form-control"
                                    placeholder="Enter Slider Name" required>
                            </div>
                           
                            <div class="form-group">
                                 <label for="start_date">Start Date</label>
                                <input type="text" style="width:191px;" class="form-control flatpickr-input active" id="start_date" name="start_date" placeholder="Start Date" required="" readonly="readonly" value="{{$area->start_date}}">
                                 &nbsp;
                                 <label for="end_date">End Date</label>
                                <input type="text" style="width:191px;" class="form-control flatpickr-input" id="end_date" name="end_date" placeholder="End Date" required="" readonly="readonly" value="{{$area->end_date}}">
                                    
                            </div>


                            <img src="{{asset('public/assets/images/slider/'.$area->icon)}}" width="50" height="50">
                            <input type="hidden" name="tempfile_img" value="{{$area->icon}}">
                              <div class="form-group">
                                <label for="">Background Image</label>
                                <input type="file" class="form-control" name="slider_img" placeholder="" >
                            </div>

                             <div class="form-group">
                                <label for="section_order">Section Order</label>
                                <input type="text" name="section_order" id="section_order" class="form-control" required="" value="{{ $area->section_order}}">
                            </div>
                                                      
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$area->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/slider')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>
<script>
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>

<script>
$(document).ready(function() {
    $('#start_date,#end_date').flatpickr({
        dateFormat: "Y-m-d",
    });

});
</script>


@endsection
