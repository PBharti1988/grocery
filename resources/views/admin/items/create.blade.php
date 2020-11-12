@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Item</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Item</li>
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
                <h3 class="box-title m-b-0">Add Item</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('item.store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Category<span class="color-required"></span></label>
                                <select class="form-control" name="category" id="category" required>
                                <option value="">Select</option>
                                    @foreach($categories as $val)
                                    <option value="{{$val->id}}">{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Sub Category<span class="color-required"></span></label>
                                <select class="form-control" name="sub_category" id="sub_category">
                                <option value="">Select</option>
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Name</label>
                                <input type="text" name="item_name" class="form-control" placeholder="Enter Item Name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Price</label>
                                <input type="text" name="item_price" class="form-control" placeholder="Enter Item Price"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Discount Price</label>
                                <input type="text" name="discount_price" class="form-control"
                                    placeholder="Enter Discount Price">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Order Limit</label>
                                <input type="text" name="order_limit" class="form-control"
                                    placeholder="Enter order quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Short Description</label>
                                <input type="text" name="short_description" class="form-control"
                                    placeholder="Enter short Description">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Type</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-1" value="1" name="item_type" checked
                                    data-radio="iradio_flat-red">
                                <label for="flat-radio-1">Veg</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-2" value="2" name="item_type" 
                                    data-radio="iradio_flat-red">
                                <label for="flat-radio-2">Non-Veg</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-3" value="3" name="item_type" 
                                    data-radio="iradio_flat-red">
                                <label for="flat-radio-3">None</label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label>
                                <input type="file" class="form-control" name="item_image" placeholder="">
                            </div>
                            <!-- <div class="form-group">
                                <label for="exampleInputPassword1">Multiple Images (Max 10 )</label>
                                <input type="file" class="form-control" id="images" name="images[]" placeholder="" multiple>
                            </div> -->
                            <div class="form-group">
                            <label for="description">Add Multiple Images</label>
                            <a class="btn btn-success" style="border-radius:16px;" id="multi_image">Add</a>
                           </div>
                           <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="image_slab">

                            </div>
                             </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Long Description</label>
                                <textarea class="form-control" name="long_description"></textarea>
                            </div>
                            <div class="form-group">
                            <label for="description">Add Other Description</label>
                            <a class="btn btn-success" style="border-radius:16px;" id="addmore">Add</a>
                           </div>
                           <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="slabs">

                            </div>
                             </div>
                             <div class="form-group">
                            <label for="description">Add Variety</label>
                            <a class="btn btn-success" style="border-radius:16px;" id="add_variety">Add</a>
                           </div>
                           <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="variety_slabs">

                            </div>
                             </div>
                             
                            <div class="form-group">
                                <label for="exampleInputPassword1">Card Background Color</label>&nbsp
                                <input type="color" id="favcolor" name="card_color" value="#ffffff">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Font Color</label>&nbsp
                                <input type="color" id="favcolor" name="font_color" value="#ffffff">
                            </div>
                         

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/item')}}">Back</a>

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

    var abc = '<div class="col-md-5 desc' + count + '" style="padding:0 5px;padding-left:10px">' +
        '<div class="form-group sl">' +
        '<input type="text" value="" id="from_amount1" class="form-control am from_amount' +
        count + '" name="title[]" required placeholder="Title">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-5 desc' + count + '" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:350px;" value="" id="to_amount1" class="form-control am to_amount' + count +
        ' " name="description[]" required  placeholder="Description" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-2 desc' + count + '" style="">' +
        '<a class="btn btn-danger removedesc" data-attr="desc' + count + '">-</a>' +
        '</div>';
    $('#slabs').append(abc);

});

$("#multi_image").click(function() {
 $("#multi_image").text('Add More');
    var double = count + 2;
    count += 1;
    if(count <= 10){
    var abc = '<div class="col-md-10 img'+count+'" style="padding:0 5px;padding-left:10px">' +
        '<div class="form-group sl" >' +
        '<input  type="file" value="" id="from_amount1" class="form-control am from_amount' +
        count + '" name="images[]" required placeholder="images" required>' +
        '</div>' +
        '</div>'+
        '<div class="col-md-2 img' + count + '" style="">' +
        '<a class="btn btn-danger remove" data-attr="img' + count + '">-</a>' +
        '</div>';
    $('#image_slab').append(abc);
    }else{
        alert('only 10 multiple images are allowed');
    }
});


$('body').on('click', '.remove', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
    });

    $('body').on('click', '.removedesc', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
    });



$("#add_variety").click(function() {
 $("#add_variety").text('Add More');
    var double = count1 + 2;
    count1 += 1;

    var abc = '<div class="col-md-4 variety' + count1 +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px" id="from_amount1" class="form-control am va3riety' +
        count1 + '" name="name[]" required placeholder="Name">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4 variety' + count1 +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am va3riety' + count1 +
        ' " name="price[]" required  placeholder="Price" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-3 va3riety' + count1 +
        '" style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am va3riety' + count1 +
        ' " name="variety_description[]" required  placeholder="Description" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-1 variety' + count1 + '" style="">' +
        '<a class="btn btn-danger removeVariety" data-attr="variety' + count1 + '">-</a>' +
        '</div>';
    $('#variety_slabs').append(abc);

});


$('body').on('click', '.removeVariety', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
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