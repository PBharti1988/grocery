@extends('admin.admin-layouts.app')
<style>
#item-list {
    float: left;
    list-style: none;
    padding:0!important;
    /* width: 190px; */
    
}

#item-list li {
    padding: 10px;
    background: white;
    margin-right:20px;
}

#item-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}
.delete:hover{
    cursor: pointer;
}

.list span{
            
            background: #1da1f2;
            color:white;
            font-size: 15px;
            border-radius: 1px;
            margin-left: 5px;
            display: inline-block;
        }

   
.align-middle {
    vertical-align: middle!important;
}

    .center {
    width: 120px;
    /* margin: 24px auto; */
}
    .input-group {
    position: relative;
    display: table;
    /* border-collapse: separate; */
}
input.form-control.input-number {
    padding: 5px;
    text-align: center;
    height: 34px;
}

button.btn.btn-danger.btn-number{
    padding: 9px;
    font-size: 14px;
    height: 34px;
    width: 33px;

}

.input-group-btn {
    position: relative;
    font-size: 0;
    white-space: nowrap;
}     
</style>
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"></h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add item in order</li>
                </ol>
                <!-- <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>
                    Create New</button> -->

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="errors"></div>
            <div class="card card-body">
                <h3 class="box-title m-b-0">Add More Item</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{url('item-add-in-order/'.$order_id.'/'.$order_type.'/'.$tab)}}" enctype="multipart/form-data">
                            {{csrf_field()}}                            
                           
                           <div class="form-group row">
                        <label class="col-md-2 col-form-label">Item Name<span class="color-required"></span></label>
                        <div class="col-md-6">
                            <input type="text" autocomplete="off" class="form-control" id="search-box" placeholder="search here...." />
                            <input type="hidden" name="items" id="items"/>
                            <div id="suggesstion-box"></div>
                            
                        </div>
                    </div>

                           <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="variety_slabs">

                            </div>
                             </div>
                             
                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10 submit">Submit</button>
                                @if($order_type =='new')
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('order/'.$order_id.'/detail')}}">Back</a>
                                @else
                                    <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('table-order/'.$tab)}}">Back</a>
                                @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

<script>
// $(window).on("load", function() {
$(document).ready(function(){

 $("#search-box").keyup(function() {

var val = $('#search-box').val();
$.ajax({
    type: "GET",
    url: "{{url('/search-item')}}",
    data: 'keyword=' + val,
    beforeSend: function() {
        $("#search-box").css("background",
            "#FFF url(LoaderIcon.gif) no-repeat 165px");
    },
    success: function(data) {
        $("#suggesstion-box").show();
        $("#suggesstion-box").html(data);
        $("#search-box").css("background", "#FFF");
        var check_len = $('#search-box').val();
        if (check_len == "") {
            $("#suggesstion-box").hide();
        }
    }
});
});   



});




$('body').on('click', '.remove', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
    });

    $('body').on('click', '.removedesc', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
    });

   
 

$('body').on('click', '.removeVariety', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();
    });

    $('body').on('click', '.submit', function() {
       
        var checks =$('#items').val();

        if(checks ==""){
            var error='<div class="alert alert-danger">'+
	           '<button type="button" class="close" data-dismiss="alert">×</button>'+	
               '<strong>Please Add Item</strong>'+
               '</div>';
                $('.errors').html(error);
            return false;
        }
         
    }); 



 count1 = 0;

function selectItem(name,id,price){
    $("#search-box").val('');
    $("#suggesstion-box").hide();
     
    count1 += 1;
    $('#items').val(count1);
    var abc = '<div class="col-md-3 variety' + count1 +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="hidden" name="item_id[]" value="'+id+'" >'+
        '<input type="text" style="width:200px" id="from_amount1" class="form-control am va3riety' +
        count1 + '" name="item_name[]" value="'+name+'" readonly required placeholder="Item Name">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-3 variety' + count1 +
        ' " style="">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:200px;" value="'+price+'" readonly id="to_amount1" class="form-control am va3riety' + count1 +
        ' " name="price[]" required  placeholder="Price" >' +
        '</div>' +
        '</div>'+
        '<div class="col-md-3 variety' + count1 +
        '" style="">' +
        '<strong>'+
       '<div class="center">'+
         '<div class="input-group" data-itemid="" data-status="" data-orderid="" data-itemorderid="" data-itemname="" data-price="">'+
        '<span class="input-group-btn">'+
         '<button type="button" class="btn btn-danger btn-number removeItem"  data-type="minus" data-field="quant[2]">'+
         '<span class="glyphicon glyphicon-minus"></span>-'+
          '</button>'+
          '</span>'+
         '<input type="text" name="qty[]" class="form-control input-number itemcount" readonly="true" value="1" min="1" max="100">'+
          '<span class="input-group-btn">'+
            '<button type="button" class="btn btn-success btn-number addItem" data-type="plus" data-field="quant[2]">'+
              '<span class="glyphicon glyphicon-plus"></span>+'+
                '</button>'+
                '</span>'+
                 '</div>'+
               '</div>'+
              '</strong>'+
        '</div>'+
        '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<div class="col-md-1 variety' + count1 + '" style="">' +
        '<a class="btn btn-danger removeVariety" data-attr="variety' + count1 + '"><i class="fa fa-trash"></i></a>' +
        '</div>';
    $('#variety_slabs').append(abc);

 };

$(document).ready(function(){

    $('body').on('click', '.addItem', function() {
     
    var itemQty= $(this).parent().prev().val();
    var action = $(this).attr('data-type');
    itemQty=parseInt(itemQty)+1;
    var itemQty1 = pad_with_zeroes(itemQty, 1);
    $(this).parent().prev().val(itemQty1);
   });


   $('body').on('click', '.removeItem', function() {
    var itemQty= $(this).parent().next().val();
    var action = $(this).attr('data-type');
    if(parseInt(itemQty)!=0)
     {
    itemQty=parseInt(itemQty)-1;
    var itemQty1 = pad_with_zeroes(itemQty, 1);
      $(this).parent().next().val(itemQty1);
      if(itemQty1<=1)
      {
        $(this).parent().next().val(1);
       
      }
     }
   });
  });

  function pad_with_zeroes(number, length) {
   var my_string = '' + number;
   while (my_string.length < length) {
    my_string = '0' + my_string;
   }
   return my_string;
   }

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