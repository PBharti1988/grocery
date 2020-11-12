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
                         <form method="post" action="{{route('slideroptionsstore')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                     <input type="hidden" name="slider_id" value="{{ $area->slider_id }}">
                     <input type="hidden" name="id" value="{{ $area->id ?? '' }}">
                    
                     <img src="{{asset('public/assets/images/slideroptions/'.$area->icon)}}" width="50" height="50">
                     
                     <input type="hidden" name="tempfile_img" value="{{ $area->icon ?? '' }}">
                    <div class="form-group">
                      <label for="slider_img">Image</label>
                      <input type="file" name="slider_img" class="form-control" id="slider_img">
                    </div>

                    <div class="form-group">
                      <label for="date_from">Date From</label>

                       <input type="text" style="width:191px;" class="form-control flatpickr-input active" id="date_from" name="date_from" placeholder="Start Date" required="" readonly="readonly" value="{{ $area->date_from ?? '' }}">
                                 &nbsp;
                       <label for="date_to">Date To</label>
                       <input type="text" style="width:191px;" class="form-control flatpickr-input" id="date_to" name="date_to" placeholder="End Date" required="" readonly="readonly" value="{{ $area->date_to ?? '' }}">

                    </div>
                     <div class="form-group">
                                <label for="sort_order">Sort Order</label>
                                <input type="text" name="sort_order" id="sort_order" class="form-control" required="" value="{{ $area->sort_order ?? '' }}">
                    </div>

                    <div class="form-group">
                        
                        <label for="type">Type</label>
                         <select class="form-control" name="type" id="type">
                                <option value="">Select</option>
                                <option value="category" @if($area->type=='category') selected @endif>Category</option>
                                <option value="product" @if($area->type=='product') selected @endif>Product</option>
                                <option value="none" @if($area->type=='none') selected @endif >None</option>   
                        </select>

                    </div>

                     <div class="form-group category" style="display: none">
                        
                        <label for="type">Category</label>
                         <select class="form-control" name="category" id="category">
                                <option value="">Select</option>
                                 @foreach($categories as $val)
                                <option value="{{$val->id}}" @if($area->category == $val->id) selected @endif>
                                    {{$val->category_name}}
                                </option>
                                    @endforeach
                        </select>

                    </div>

                    <div class="form-group product" style="display: none;">
                        
                        <label for="type">Products</label>
                         <select class="form-control" name="product" id="product">
                                <option value="">Select</option>
                                 @foreach($products as $val)
                                    <option value="{{$val->id}}" @if($area->product == $val->id) selected @endif>{{$val->item_name}}</option>
                                    @endforeach
                        </select>

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
                    <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/slideroption/'.$area->slider_id)}}">Back</a>                
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
    
    $(document).ready(function(){

     var type = $('#type').val();

    // alert(type);
    if(type =="category"){

     $(".category").css('display','block');
     $(".product").css('display','none');
    }
     if(type =="product"){

     $(".product").css('display','block');
     $(".category").css('display','none');
    } 
    if(type =="none"){

     $(".category").css('display','none');
     $(".product").css('display','none');
    }


    })
</script>

<script>
    $('#type').on('change',function(){

    var type = $('#type').val();

    // alert(type);
    if(type =="category"){

     $(".category").css('display','block');
     $(".product").css('display','none');
    }
     if(type =="product"){

     $(".product").css('display','block');
     $(".category").css('display','none');
    } 
    if(type =="none"){

     $(".category").css('display','none');
     $(".product").css('display','none');
    }



    })
</script>

<script>
$(document).ready(function() {
    $('#date_from,#date_to').flatpickr({
        dateFormat: "Y-m-d",
    });

});
</script>


@endsection
