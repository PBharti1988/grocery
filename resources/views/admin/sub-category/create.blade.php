@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Sub Category</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Sub Category</li>
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
                <h3 class="box-title m-b-0">Add Sub Category</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('sub-category.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Category<span class="color-required"></span></label>
                                <select class="form-control" name="category" required>
                                <option value="">Select</option>
                                    @foreach($categories as $val)
                                    <option value="{{$val->id}}">{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Category Name</label>
                                <input type="text" name="sub_category_name" class="form-control" placeholder="Enter Name"
                                    required>
                            </div>
                          
                            <div class="form-group">
                                <label for="exampleInputPassword1">Logo</label>
                                <input type="file" class="form-control" name="logo" placeholder="">
                            </div>
                        
                         

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/sub-category')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

<script>
$(window).on("load", function() {

var count = 0;
$("#addmore").click(function() {
 $("#addmore").text('Add More');
    var double = count + 2;
    count += 1;

    var abc = '<div class="col-md-6" style="padding:0 5px;padding-left:10px">' +
        '<div class="form-group sl">' +
        '<input type="text" value="" id="from_amount1" class="form-control am from_amount' +
        count + '" name="title[]" required placeholder="Title">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-6" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:400px;" value="" id="to_amount1" class="form-control am to_amount' + count +
        ' " name="description[]" required  placeholder="Description" >' +
        '</div>' +
        '</div>';
    $('#slabs').append(abc);

});

$("#multi_image").click(function() {
 $("#multi_image").text('Add More');
    var double = count + 2;
    count += 1;
    if(count <= 10){
    var abc = '<div class="col-md-12" style="padding:0 5px;padding-left:10px">' +
        '<div class="form-group sl">' +
        '<input type="file" value="" id="from_amount1" class="form-control am from_amount' +
        count + '" name="images[]" required placeholder="images" required>' +
        '</div>' +
        '</div>';
    $('#image_slab').append(abc);
    }else{
        alert('only 10 multiple images are allowed');
    }
});



});

</script>

<script>
var limit = 10;
$(document).ready(function(){
    $('#images').change(function(){
        var files = $(this)[0].files;
        if(files.length > limit){
            alert("You can select max "+limit+" multiple images.");
            $('#images').val('');
            return false;
        }else{
            return true;
        }
    });
});
</script>
@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->