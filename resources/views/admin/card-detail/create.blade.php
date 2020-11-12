@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Card Detail</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Card Detail</li>
                </ol>
                <!-- <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>
                    Create New</button> -->

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            @include('admin.admin-layouts.flash-message')
            <div class="error"></div>
            <div class="card card-body">

                <h3 class="box-title m-b-0">Add Card Detail</h3>

                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('card-details.store')}}" id="myForm"
                            enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Card Category<span class="color-required"></span></label>
                                <select class="form-control" name="card" id="card" required>
                                    <option value="">Select</option>
                                    @foreach($card as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="head_serial">
                                <label for="exampleInputEmail1">Serial No.</label>
                                <input type="text" name="serial_no" id="serial_no" maxlength="2" class="form-control"
                                    placeholder="Enter serial no"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>

                            <div class="form-group" id="head_title">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Enter title">
                            </div>

                            <div id="quick_info" style="display:none;">



                                <div class="form-group">
                                    <input type="text" style="width:107px;" name="email_code" class="form-control"
                                        placeholder="Enter Code">
                                    <input type="email" style="width:700px;" name="email" id="email"
                                        class="form-control" placeholder="Enter Email">
                                    <a href="https://fontawesome.com/icons?d=gallery" target="_blank"
                                        style="margin-left:17px; color:black;">Help</a>
                                </div>
                                <div class="form-group">
                                    <input type="text" style="width:107px;" name="gst_code" class="form-control"
                                        placeholder="Enter Code">
                                    <input type="text" style="width:700px;" name="gst" maxlength="15" id="gst"
                                        class="form-control" placeholder="Enter gst">
                                </div>
                                <div class="form-group">
                                    <input type="text" style="width:107px;" name="phone_code" class="form-control"
                                        placeholder="Enter Code">
                                    <input type="number" name="phone" style="width:700px;" maxlength="10" id="phone"
                                        class="form-control" placeholder="Enter phone no.">
                                </div>
                                <div class="form-group">
                                    <input type="text" style="width:107px;" name="address_code" class="form-control"
                                        placeholder="Enter Code">
                                    <input type="text" name="address" style="width:700px;" id="address"
                                        class="form-control" placeholder="Enter address">
                                </div>

                            </div>
                            <div id="meet_us_here" style="display:none;">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                        placeholder="Enter latitude">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                        placeholder="Enter longitude">
                                </div>
                            </div>
                            <div id="our_offering" style="display:none;">
                                <input type="hidden" id="offering" name="offering" />
                                <?php $array= array('(',')','+','@','-','[',']','{','}','!','/','<','>','?','&','%','^','*','$','-','=','|'); ?>
                                @foreach($items as $val)
                                <div class="form-group form-check-inline">
                                    <input type="checkbox"
                                        class="form-check-input checked {{str_ireplace($array,'',str_replace(' ', '_',$val->item_name))}}"
                                        value="{{$val->item_name}}"
                                        data-class="{{str_ireplace($array,'',str_replace(' ', '_',$val->item_name))}}"
                                        id="materialInline3">
                                    <label class="form-check-label" for="materialInline3">{{$val->item_name}}</label>
                                </div>
                                @endforeach
                            </div>
                            <div id="famous" style="display:none;">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Famous For</label>
                                    <textarea name="famous_for" id="famous_for" rows="3" cols="3" class="form-control"
                                        placeholder="Enter famous for"></textarea>
                                </div>
                            </div>

                            <div id="facility" style="display:none;">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Facilities</label>
                                    <textarea name="facilities" id="facilities" rows="3" cols="3" class="form-control"
                                        placeholder="Enter facilities"></textarea>
                                </div>
                            </div>

                            <div id="our_story" style="display:none;">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Our Story</label>
                                    <textarea name="story" id="story" rows="5" cols="5" class="form-control"
                                        placeholder="Ente story"></textarea>
                                </div>
                            </div>
                            <div id="custom" style="display:none;">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Card Color</label>
                                    <input type="color" id="favcolor" name="card_color" value="#ffffff">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Font Color</label>
                                    <input type="color" id="color" name="font_color" value="#ffffff">
                                </div>
                                <div class="form-group">
                                    <span><a class="btn btn-success addmore" style="border-radius:16px;" id="addtext"
                                            data-class="text">Add Text</a><span>
                                            <span><a class="btn btn-success addmore" style="border-radius:16px;"
                                                    id="addtextarea" data-class="area">Add Textarea</a><span>
                                                    <span><a href="https://fontawesome.com/icons?d=gallery"
                                                            target="_blank"
                                                            style="margin-left:17px; color:black;">Help</a></span>
                                </div>
                            </div>
                            <input type="hidden" name="custom_data" id="custom_data" />
                            <div class="all">
                                <div class="row scheme_slabs" style="padding:0 15px;" id="slabs">

                                </div>
                            </div>
                             <div id="social" style="display:none;">
                             <div class="form-group">
                                <label for="name">Social Media<span class="color-required"></span></label>
                                <select class="form-control" name="social_media" id="social_media">
                                    <option value="">Select</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="instagram">Instagram</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link</label>
                                <input type="text" name="link" id="link" class="form-control"
                                    placeholder="Enter link">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo</label>
                                <input type="file" name="social_image" id="social_image" class="form-control"
                                   >
                            </div>


                             </div>

                            <!-- <div class="form-group">
                                <label for="exampleInputPassword1">Card Color</label>&nbsp
                                <input type="color" id="favcolor" name="card_color" value="#ffffff">
                            </div> -->


                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"
                                id="cardDetails">Submit</button>
                            <a class="btn btn-secondary width-sm waves-effect waves-light"
                                href="{{url('/card-details')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

<script>
$(window).on("load", function() {
    typearray = [];
    var count = 0;
    var count1 = 0;
    $(".addmore").click(function() {

        var attr = $(this).attr('data-class');

        var double = count + 2;
        count += 1;
        if (attr == 'text') {
            // var str="text";
            // typearray.push(str);
            // $('#text_type').val(typearray);
            var string = '<div class="col-md-6 text' + count + '" style="padding:0 5px;">' +
                '<div class="form-group sl">' +
                '<input type="text" style="width:425px;" value="" id="custom_value" class="form-control am to_amount' +
                count +
                ' " name="custom_value[]" required  placeholder="text" >' +
                '<input type="hidden" name="field_type[]" value="text">' +
                '</div>' +
                '</div>';
        } else {
            // var str="textarea";
            // typearray.push(str);
            // $('#text_type').val(typearray);
            var string = '<div class="col-md-6 text' + count + '" style="padding:0 5px;">' +
                '<div class="form-group sl">' +
                '<textarea style="width:425px;" data-class="" value="" rows="3" cols="3" id="custom_value" class="form-control am ' +
                count +
                ' " name="custom_value[]" required  placeholder="textarea" ></textarea>' +
                '<input type="hidden" name="field_type[]" value="textarea">' +
                '</div>' +
                '</div>';

        }

        var abc = '<div class="col-md-1 text' + count + '" style="padding:0 5px;padding-left:10px">' +
            '<div class="form-group sl">' +
            '<input type="text" value="" id="custom_serial" class="form-control am from_amount' +
            count + '" name="custom_serial[]" required placeholder="serial no">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2 text' + count + '" style="padding:0 5px;">' +
            '<div class="form-group sl">' +
            '<input type="text" value="" id="custom_title" class="form-control am from_amount' +
            count + '" name="custom_title[]" required placeholder="Title">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2 text' + count + '" style="padding:0 5px;">' +
            '<div class="form-group sl">' +
            '<input type="text" value="" id="custom_code" class="form-control am from_amount' +
            count + '" name="custom_code[]" required placeholder="Code">' +
            '</div>' +
            '</div>' +
            string +
            '<div class="col-md-1 text' + count + '" style="">' +
            '<a class="btn btn-danger remove" data-attr="text' + count + '">-</a>' +
            '</div>';




        $('#slabs').append(abc);

    });













});
</script>

<script>
$(document).ready(function() {
    $("#cardDetails").click(function() {
        var val = $('#card').val();
        var custom = [];
        if (val == 8) {
            // var cus_serial =$('#custom_serial').val();
            //  var cus_serial =$('input[id^="custum_serial"]').val();
            var cus_serial = [];
            var cus_title = [];
            var cus_value = [];
            $('input[id^="custom_serial"]').each(function() {
                cus_serial.push(this.value);
            });
            $('input[id^="custom_title"]').each(function() {
                cus_title.push(this.value);
            });
            $('input[id^="custom_value"]').each(function() {
                cus_value.push(this.value);
            });
            $('textarea[id^="custom_value"]').each(function() {
                cus_value.push(this.value);
            });

            custom.push({
                serial: cus_serial,
                title: cus_title,
                value: cus_value
            });
        }
        console.log('custom');
        $('#custom_data').val(JSON.stringify(custom));
        //console.log(JSON.stringify(custom));
        //return false;

    });
});

$(document).ready(function() {
    $("#cardDetails").click(function() {



        var card = $('#card').val();
        var title = $('#title').val();
        var serial = $('#serial_no').val();
        var email = $('#email').val();
        var gst = $('#gst').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var lat = $('#latitude').val();
        var long = $('#longitude').val();
        var offering = $('#offering').val();
        var famous = $('#famous_for').val();
        var facility = $('#facilities').val();
        var story = $('#story').val();

        if (card == 1) {
            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (email == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Email is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }


            if (phone == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Phone no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (gst == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Gst is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (gst.length != 15) {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Gst length must be 15 character</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (address == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Address is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }
        }


        if (card == 2) {
            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (lat == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Latitude is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (long == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Longitude is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

        }

        if (card == 3) {
            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (offering.length == 0) {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Offering product is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

        }

        if (card == 4) {

            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (famous == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Famous for is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }
        }

        if (card == 5) {

            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (facility == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Facilities is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }
        }


        if (card == 6) {

            if (title == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Title is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (serial == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Serial no. is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }

            if (story == "") {
                var html = '<div class="alert alert-danger">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>Our story is required</strong>' +
                    '</div>';
                $('.error').html(html);
                return false;
            }


        }

    });
});
/////////////////////////////////////////////////////



///////////////////////////////////////////
$(document).ready(function() {

    $('#card').change(function(event) {
        var val = $(this).val();
        if (val == 1) {


            $('#quick_info').css('display', 'block');
        } else {
            $('#quick_info').css('display', 'none');
        }

        if (val == 2) {


            $('#meet_us_here').css('display', 'block');
        } else {
            $('#meet_us_here').css('display', 'none');
        }

        if (val == 3) {


            $('#our_offering').css('display', 'block');
        } else {
            $('#our_offering').css('display', 'none');
        }
        if (val == 4) {


            $('#famous').css('display', 'block');
        } else {
            $('#famous').css('display', 'none');
        }
        if (val == 5) {


            $('#facility').css('display', 'block');
        } else {
            $('#facility').css('display', 'none');
        }
        if (val == 6) {


            $('#our_story').css('display', 'block');
        } else {
            $('#our_story').css('display', 'none');
        }
        if (val == 8) {


            $('#custom').css('display', 'block');
        } else {
            $('#custom').css('display', 'none');
        }

        if (val == 9) {
           $('#social').css('display', 'block');
          } else {
          $('#social').css('display', 'none');
           }


    });




    var data = [];
    //$(".checked").click(function () {
    $('body').on('click', '.checked', function() {

        // $(this).addClass('active');
        var check2 = $(this).hasClass('active');
        var get_class = $(this).attr("data-class");
        var ch2 = $(this).val();
        var ch3 = $(this).attr("data-class");
        //            console.log(data);
        //             console.log(ch2);
        if (check2 == true) {

            $('.' + get_class).prop("checked", false);

            $('div').remove('.' + get_class);

            $('.' + get_class).removeClass('active');

            var a = {
                class: get_class,
                val: $(this).val()
            };
            $.each(data, function(k, v) {

                var len = data.length;

                if (v == undefined) {
                    console.log(v);
                    // if(len >= 2 ){

                    // location.reload();   

                    //} 

                } else {

                    if (v['val'] == ch2 && v['class'] == ch3) {

                        delete data[k];
                        //delete data.k; 
                        console.log(data);
                    }
                    if (len == 1) {
                        //location.reload();              
                    }

                }

            });


        } else {

            $('.' + get_class).prop("checked", true);
            $('.' + get_class).addClass('active');
            var check12 = $(this).hasClass('active');

            if (check12 == true) {

                data.push({
                    val: $(this).val(),
                    class: $(this).attr("data-class")
                });


                console.log(data);
                var y = '';

                $.each(data, function(k, v) {

                    if (v == undefined) {

                    } else {
                        y += '<div onclick=\'remove_div_checkbox("' + v['class'] + '","' + v[
                                'val'] +
                            '")\'  class="chip waves-effect waves-effect m-0 p-0 mb-1 ' + v[
                                'class'] + '">' + v['val'] +
                            '<i class="close fa fa-times "></i></div>';
                    }
                });
                // console.log(data);
                //  $("#show_filter").html(y);

            }

        }

        var myArrayNew = data.filter(function(el) {
            return el != null && el != "";
        });
        console.log('check');
        console.log(myArrayNew);
        $('#offering').val(JSON.stringify(myArrayNew));

    });

});




$(function() {
    $('body').on('click', '.remove', function() {
        var atr = $(this).attr('data-attr');
        $('.' + atr).remove();


    });
});
</script>



@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->