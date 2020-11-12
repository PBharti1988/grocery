@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Addon</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Addon</li>
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
                <h3 class="box-title m-b-0">Add Addon</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('addon.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Top Up Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Price</label>
                                <input type="text" name="price" class="form-control" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Enter Price"
                                    required>
                            </div> 
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label>
                                <input type="file" class="form-control" name="topup_image" placeholder="" required>
                            </div>
                        
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Description</label>
                                <textarea class="form-control" name="description"></textarea>
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
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/addon')}}">Back</a>

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
var count1 = 0;
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



$("#add_variety").click(function() {
 $("#add_variety").text('Add More');
    var double = count1 + 2;
    count1 += 1;

    var abc = '<div class="col-md-4" style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px" id="from_amount1" class="form-control am from_amount' +
        count1 + '" name="name[]" required placeholder="Name">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4" style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am to_amount' + count1 +
        ' " name="price[]" required  placeholder="Price" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-4" style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am to_amount' + count1 +
        ' " name="variety_description[]" required  placeholder="Description" >' +
        '</div>' +
        '</div>';
    $('#variety_slabs').append(abc);

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





    $(document).ready(function () {
       
        $('#category').change(function (event) {
            var val=$(this).val();
          //  alert(val);
             $.ajax({
            type: "GET",
            url: "{{url('/dropdown/sub-category')}}",
            data: 'id=' + val,
            success: function (data) {
                console.log(data);
                $("#sub_category").html(data);
            }
        });
           
            
        });
    });
</script>



@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->