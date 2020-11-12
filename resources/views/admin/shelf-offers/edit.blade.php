@extends('admin.admin-layouts.app')
@section('content')

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Shelf Offers</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Shelf Offers</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Edit Shelf Offers</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('shelf-offers.update',$offer->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Shelf Number</label>
                                <select class="form-control" name="shelf_id">
                                    <option value="">Select</option>
                                    @foreach($shelves as $val)
                                    <option value="{{$val->id}}" @if($offer->shelf_id==$val->id) selected @endif>
                                    {{$val->shelf_number}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <img src="{{asset('public/assets/images/shelf-offers/'.$offer->offer_image)}}" width="50" height="50">
                            <div class="form-group">
                                <label for="shelf">Image</label>
                                <input type="file" class="form-control" name="image" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="name">Start Date</label>
                                <input type="text" name="start_date" id="start_date" value="{{$offer->start_date}}" class="form-control" placeholder="Enter Start Date" required>
                            </div>
                            <div class="form-group">
                                <label for="name">End Date</label>
                                <input type="text" name="end_date" id="end_date" value="{{$offer->end_date}}" class="form-control" placeholder="Enter End Date" required>
                            </div>
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1" {{$offer->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/shelf-offers')}}">Back</a>
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
