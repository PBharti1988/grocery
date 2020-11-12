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
                    <li class="breadcrumb-item active">Edit Item</li>
                </ol>
                <a href="{{url('item/'.$item->id.'/addon')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add Addon</a> 

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                <h3 class="box-title m-b-0">Edit Item</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('item.update',$item->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Category<span class="color-required"></span></label>
                                <select class="form-control" name="category" id="category" required>
                                    <option value="">Select</option>
                                    @foreach($categories as $val)
                                    <option value="{{$val->id}}" @if($item->category_id==$val->id) selected
                                        @endif>{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Sub Category<span class="color-required"></span></label>
                                <select class="form-control" name="sub_category" id="sub_category">
                                <option value="">Select</option>
                                   @foreach($sub_categories as $val)
                                   <option value="{{$val->id}}" @if($item->sub_category_id==$val->id) selected
                                        @endif>{{$val->category_name}}</option>
                                   @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Name</label>
                                <input type="text" name="item_name" value="{{$item->item_name}}" class="form-control"
                                    placeholder="Enter Item Name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Price</label>
                                <input type="text" name="item_price" value="{{$item->item_price}}" class="form-control"
                                    placeholder="Enter Item Price" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Discount Price</label>
                                <input type="text" name="discount_price" value="{{$item->discount_price}}"
                                    class="form-control" placeholder="Enter Discount Price">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Order Limit</label>
                                <input type="text" name="order_limit"  value="{{$item->order_limit}}" class="form-control"
                                    placeholder="Enter order quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Short Description</label>
                                <input type="text" name="short_description" value="{{$item->short_description}}"
                                    class="form-control" placeholder="Enter short Description">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Item Type</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-1" value="1" name="item_type"
                                    @if($item->item_type == 'veg') checked @endif
                                data-radio="iradio_flat-red">
                                <label for="flat-radio-1">Veg</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-2" value="2" name="item_type"
                                    @if($item->item_type == 'non-veg') checked @endif
                                data-radio="iradio_flat-red">
                                <label for="flat-radio-2">Non-Veg</label>
                                &nbsp&nbsp
                                <input type="radio" class="check" id="flat-radio-3" value="3" name="item_type" 
                                    @if($item->item_type == '') checked @endif
                                    data-radio="iradio_flat-red">
                                <label for="flat-radio-3">None</label>
                            </div>
                            <img src="{{asset('public/assets/images/item-images/'.$item->image)}}" width="50"
                                height="50">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label>
                                <input type="file" class="form-control" name="item_image" placeholder="">
                            </div>
                           
                            <div class="form-group">
                                <label for="description">Add Multiple Images</label>
                                <a class="btn btn-success" style="border-radius:16px;" id="multi_image">Add</a>
                            </div>
                            <div class="row scheme_slabs" style="padding:0 0px;" id="image_slab">
                            @if(!empty($images))
                            <?php $it=1; ?>
                            @foreach($images as $value)
 
                            <img src="{{asset('public/assets/images/item-images/'.$value->image)}}" width="50px"
                                height="50px" class="img{{$it}}">
                              
                            <input type="hidden" class="img{{$it}}" name="img_id[]" value="{{$value->id}}">
                         
                               
                                    <div class="col-md-9 img{{$it}}" style="padding:0 5px;padding-left:10px; margin-top:8px;">
                                        <div class="form-group sl">
                                            <input type="file" value="{{$value->image}}" id="from_amount1"
                                                class="form-control am from_amount" name="images[]"
                                                placeholder="images">
                                        </div>
                                    </div>
                                     <div class="col-md-2 img{{$it}}" >
                                     <div class="form-group">
                                         <a class="btn btn-danger remove" data-attr="img{{$it}}">-</a>
                                     </div>
                                     </div>
                                   
                               <?php $it++; ?>                         
                            @endforeach
                            @endif
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Long Description</label>
                                <textarea class="form-control" value=""
                                    name="long_description">{{$item->long_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="description">Add Other Description</label>
                                <a class="btn btn-success" style="border-radius:16px;" id="addmore">Add</a>
                            </div>
                            <div class="all">
                                <div class="row scheme_slabs" style="padding:0 15px;" id="slabs">
                                    @if(!empty($descriptions))
                                    <?php  $dc=1; ?>
                                    @foreach($descriptions as $value)
                                    <input type="hidden" class="desc{{$dc}}" value="{{$value->id}}" name="desc_id[]">
                                    <div class="col-md-5 desc{{$dc}}" style="padding:0 5px;padding-left:10px">
                                        <div class="form-group sl">
                                            <input type="text" value="{{$value->title}}" id="from_amount1"
                                                class="form-control am from_amount" name="title[]" required
                                                placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-md-5 desc{{$dc}}" style="padding:0 5px;">
                                        <div class="form-group sl">
                                            <input type="text" style="width:350px;" value="{{$value->description}}"
                                                id="to_amount1" class="form-control am to_amount" name="description[]"
                                                required placeholder="Description">
                                        </div>
                                    </div>
                                    <div class="col-md-2 desc{{$dc}}">
                                    <a class="btn btn-danger removedesc" data-attr="desc{{$dc}}">-</a>
                                    </div>
                                    <?php  $dc++; ?>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="description">Add Variety</label>
                            <a class="btn btn-success" style="border-radius:16px;" id="add_variety">Add</a>
                           </div>
                           <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="variety_slabs">
                                @if(!empty($variety)) 
                                <?php $va=1; ?>                              
                                @foreach($variety as $value)
                                <input type="hidden" class="variety{{$va}}" value="{{$value->id}}" name="variety_id[]">
                                <div class="col-md-4 variety{{$va}}" >
                                <div class="form-group sl">
                               <input type="text" style="width:200px" value="{{$value->name}}" class="form-control" name="name[]" required placeholder="Name">
                               </div>
                              </div>
                              <div class="col-md-4 variety{{$va}}" >
                              <div class="form-group sl">
                             <input type="text" style="width:200px;" value="{{$value->price}}" id="to_amount1" class="form-control" name="price[]" required  placeholder="Price" >
                             </div>
                              </div>
                             <div class="col-md-3 variety{{$va}}" >
                            <div class="form-group sl">
                            <input type="text" style="width:200px;" value="{{$value->description}}" id="to_amount1" class="form-control" name="variety_description[]" required  placeholder="Description" >
                            </div>
                            </div>
                            <div class="col-md-1 variety{{$va}}">
                             <a class="btn btn-danger removeVariety" data-attr="variety{{$va}}">-</a>
                             </div>
                                <?php $va++ ?>
                                @endforeach
                                @endif
                            </div>
                             </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Card Background Color</label>&nbsp
                                <input type="color" id="favcolor" value="{{$item->card_color}}" name="card_color"/>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputPassword1">Font Color</label>&nbsp
                                <input type="color" id="favcolor" value="{{$item->font_color}}" name="font_color"/>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input"
                                        id="customSwitch1" {{$item->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
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

    
    var count1 = 0;
    var count3 = 0;
    var img_count =0;
    var cntDesc =  parseInt(<?php if(!empty($descriptions)){echo count($descriptions);} else{ 0; } ?>);
    $("#addmore").click(function() {
        $("#addmore").text('Add More');
     //   var double = count + 2;
     
      
      
       cntDesc++;
      

        var abc = '<div class="col-md-5 desc'+cntDesc+'" style="padding:0 5px;padding-left:10px">' +
            '<div class="form-group sl">' +
            '<input type="text" value="" id="from_amount1" class="form-control am from_amount' +
            cntDesc + '" name="title[]" required placeholder="Title">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-5 desc'+cntDesc+'" style="padding:0 5px;">' +
            '<div class="form-group sl">' +
            '<input type="text" style="width:350px;" value="" id="to_amount1" class="form-control am to_amount' +
            cntDesc +
            ' " name="description[]" required  placeholder="Description" >' +
            '</div>' +
            '</div>'+
           '<div class="col-md-2 desc'+cntDesc+'">'+
             '<a class="btn btn-danger removedesc" data-attr="desc'+cntDesc+'">-</a>'+
             '</div>';
        $('#slabs').append(abc);

    });

    var count_img =  parseInt(<?php if(!empty($images)){echo count($images);} else{ 0; } ?>);
    $("#multi_image").click(function() {
        $("#multi_image").text('Add More');
       // var double = count + 2;
        
       
     count_img++;
        console.log(count_img);
        // count3 =  parseInt(already);
        //count3++;
       // img_count++;
      //  console.log(count3);
        if (count_img <= 10) {
            var abc = '<div class="col-md-10 img' + count_img + '" style="padding:0 5px;padding-left:10px">' +
                '<div class="form-group sl">' +
                '<input type="file" value="" id="from_amount1" class="form-control am from_amount' +
                count_img + '" name="images[]" required placeholder="images" required>' +
                '</div>' +
                '</div>'+
                '<div class="col-md-2 img' + count_img + '" style="">' +
                '<a class="btn btn-danger remove" data-attr="img' + count_img + '">-</a>' +
                '</div>';
            $('#image_slab').append(abc);
        } else {
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



    
    cntVrty = parseInt(<?php if(!empty($variety)){echo count($variety);} else{ 0; } ?>);
$("#add_variety").click(function() {
 $("#add_variety").text('Add More');
  // var double = count1 + 2;
     
 
    cntVrty++;

    var abc = '<div class="col-md-4 variety' + cntVrty +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px" id="from_amount1" class="form-control am from_amount' +
        cntVrty + '" name="name[]" required placeholder="Name">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-4 variety' + cntVrty +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am to_amount' + cntVrty +
        ' " name="price[]" required  placeholder="Price" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-3 variety' + cntVrty +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="" id="to_amount1" class="form-control am to_amount' + cntVrty +
        ' " name="variety_description[]" required  placeholder="Description" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-1 variety' + cntVrty + '" style="">' +
        '<a class="btn btn-danger removeVariety" data-attr="variety' + cntVrty + '">-</a>' +
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
// var limit = 10;
// var allready_upload = {
//     {
//         count($images)
//     }
// };
// $(document).ready(function() {
//     $('#images').change(function() {
//         var files = $(this)[0].files;
//         if (files.length + parseInt(allready_upload) > limit) {
//             alert("You can select max " + limit + " multiple images.");
//             $('#images').val('');
//             return false;
//         } else {
//             return true;
//         }
//     });
// });
</script>

@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->