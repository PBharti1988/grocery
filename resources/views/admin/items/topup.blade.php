@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Item Addon</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Item Addon</li>
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
                <h3 class="box-title m-b-0">Add Item Addon</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form class="form-inline" method="get">
                        {{csrf_field()}}
                            <input type="hidden" name="item_id" id="item_id" value="{{$item_id}}" >
                            @if(count($varient) > 0)
                            <div class="form-group mx-sm-3 mb-2">
                                <select class="form-control" name="varient" required>
                                    <option value="">select Varient</option>
                                    @foreach($varient as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                            @endif
                            <div class="form-group mx-sm-3 mb-2">
                                <select class="form-control" name="addon" required>
                                    <option value="">select Addon</option>
                                    @foreach($topup as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                            <button type="submit" class="btn btn-success mb-2">Add To Item</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-12">

            <div class="card card-body">
                <h3 class="box-title m-b-0">Item Addon</h3>
                <br>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                      
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Varient</th>
                                    <th>Addon Name</th>                              
                                    <th>Price</th>
                                    <th>Image</th>  
                                    <th>Custom Price</th> 
                                                                  
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
                      ?>
 
                            @foreach($itemAddon as $val)
                           
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>@if(varient($val->varient_id != '0')){{varient($val->varient_id)}} @else Default @endif</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->price}}</td>
                                    <td> <img src="{{asset('public/assets/topup-images/'.$val->image)}}" width="50"
                                          height="50"></td>             
                                </td>
                                     <td><input style="width: 141px;" type="text" name="custom_price" value="{{$val->custom_price}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control price{{$val->id}}">
                                     <a href="javascript:" class="btn btn-xs btn-success add_custom_price" data-attr="{{$val->id}} ">Add Custom Price</a>
                                     <a href="javascript:" data-attr="{{$val->id}}"
                                    attr-value="{{$val->enabled== 0 ? 1 : 0}}"
                                    class="btn btn-xs btn-{{$val->enabled== 0 ? 'success' : 'danger'}} action">
                                    @if($val->enabled== 1)
                                    <i class="fa fa-ban"></i>
                                    @else
                                    <i class="fa fa-check"></i>
                                    @endif
                                    {{$val->enabled== 0 ? 'Enable' : 'Disable'}}</a>
                                    <a href="javascript:" data-attr="{{$val->id}}"
                                    class="btn btn-xs btn-danger delete">
                                    <i class="fa fa-trash">Delete</i>        
                                     </a>
                                     </td>                                               
                                </tr>
                               
                                <?php $i++ ?> 
                              @endforeach
                            </tbody>
                        </table>
                     
                    </div>

                    </div>
                </div>
            </div>
        </div>

    </div>






</div>

<script>


$(document).ready(function(){

$('.add_custom_price').click(function(){
   var attr =$(this).attr('data-attr');
   var price =$('.price'+attr).val();
  
   $.ajax({
                type: "GET",
                url: "{{url('/custom-price-action')}}",
                data: 'price=' + price + '&id=' + attr,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
   
})

$('.action').click(function() {
        var id = $(this).attr('data-attr');
        var action = $(this).attr('attr-value');
        var text = 'Are you sure want to disable?';
        if(action == '1'){
            text = 'Are you sure want to enable?';
        }
        var r = confirm(text);
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "{{url('/addon-enabled-action')}}",
                data: 'id=' + id + '&action=' + action,
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        }
    });




    
$('.delete').click(function() {
        var id = $(this).attr('data-attr');
        var text = 'Are you sure want to delete?';
        var r = confirm(text);
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "{{url('/addon-delete-action')}}",
                data: 'id=' + id,
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        }
    });
  


});
















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
            if (count <= 10) {
                var abc = '<div class="col-md-12" style="padding:0 5px;padding-left:10px">' +
                    '<div class="form-group sl">' +
                    '<input type="file" value="" id="from_amount1" class="form-control am from_amount' +
                    count + '" name="images[]" required placeholder="images" required>' +
                    '</div>' +
                    '</div>';
                $('#image_slab').append(abc);
            } else {
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
                '</div>' +
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
    $(document).ready(function() {
        $('#images').change(function() {
            var files = $(this)[0].files;
            if (files.length > limit) {
                alert("You can select max " + limit + " multiple images.");
                $('#images').val('');
                return false;
            } else {
                return true;
            }
        });
    });





    $(document).ready(function() {

        $('#category').change(function(event) {
            var val = $(this).val();
            //  alert(val);
            $.ajax({
                type: "GET",
                url: "{{url('/dropdown/sub-category')}}",
                data: 'id=' + val,
                success: function(data) {
                    console.log(data);
                    $("#sub_category").html(data);
                }
            });


        });
    });
</script>



@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->