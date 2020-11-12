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
                <h3 class="box-title m-b-0">Edit Card Detail</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('card-details.update',$cardDetail->id)}}" enctype="multipart/form-data">
                        {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Card Category<span class="color-required"></span></label>
                                <select class="form-control"  id="card" required>
                                <option value="">Select</option>
                                    @foreach($card as $val)
                                    <option value="{{$val->id}}"@if($cardDetail->category_id == $val->id) selected @endif>{{$val->name}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="card" value="{{$cardDetail->category_id}}" />
                            </div>
                            <div class="form-group" id="head_serial">
                                <label for="exampleInputEmail1">Serial No.</label>
                                <input type="text" name="serial_no" id="serial_no" maxlength="2" value="{{$cardDetail->serial_no}}" class="form-control" placeholder="Enter serial no"
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" >
                            </div>        
                            <div class="form-group" id="head_title">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="title" id="title" value="{{$cardDetail->title}}" class="form-control" placeholder="Enter title"
                                    >
                            </div>
                            <div id="quick_info" style="display:none;" >
                           
                            <div class="form-group">
                           
                            <input type="text"  style="width:107px;" name="email_code" value="{{$cardDetail->email_code}}" class="form-control" placeholder="Enter Code">
                                <input type="email" name="email" style="width:700px;"   id="email" value="{{$cardDetail->email}}" class="form-control" placeholder="Enter Email">
                                <a href="https://fontawesome.com/icons?d=gallery" target="_blank" style="margin-left:17px; color:black;">Help</a>
                            </div>
                            
                            <div class="form-group">
                            <input type="text"  style="width:107px;" name="gst_code" value="{{$cardDetail->gst_code}}" class="form-control" placeholder="Enter Code">
                                <input type="text" name="gst" maxlength="15"  style="width:700px;" id="gst" value="{{$cardDetail->gst}}" class="form-control" placeholder="Enter gst"
                                    >
                            </div>
                            <div class="form-group">
                            <input type="text"  style="width:107px;" name="phone_code" value="{{$cardDetail->phone_code}}" class="form-control" placeholder="Enter Code">
                                <input type="number" name="phone" style="width:700px;" maxlength="10" id="phone" value="{{$cardDetail->phone}}" class="form-control" placeholder="Enter phone no."
                                    >
                            </div>
                            <div class="form-group">
                            <input type="text"  style="width:107px;" name="address_code" value="{{$cardDetail->address_code}}" class="form-control" placeholder="Enter Code">
                                <input type="text" name="address" style="width:700px;" id="address" value="{{$cardDetail->address}}" class="form-control" placeholder="Enter address"
                                    >
                            </div>
                            </div>
                            <div id="meet_us_here" style="display:none;" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Latitude</label>
                                <input type="text" name="latitude" id="latitude" value="{{$cardDetail->latitude}}" class="form-control" placeholder="Enter latitude"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Longitude</label>
                                <input type="text" name="longitude" id="longitude" value="{{$cardDetail->longitude}}" class="form-control" placeholder="Enter longitude"
                                    >
                            </div>                         
                            </div>
                            <div id="our_offering" style="display:none;" >
                            <input type="hidden" id="offering" name="offering" />
                            <?php $array= array('(',')','+','@','-','[',']','{','}','!','/','<','>','?','&','%','^','*','$','-','=','|'); $data_item = unserialize($cardDetail->offering); $data_item2 =(array)$data_item; ?>
                           
                           

                            @foreach($items as $val)
                
                            <div class="form-group form-check-inline">
                            <input type="checkbox" class="form-check-input checked {{str_ireplace($array,'',str_replace(' ', '_',$val->item_name))}}" value="{{$val->item_name}}" data-class="{{str_ireplace($array,'',str_replace(' ', '_',$val->item_name))}}" id="materialInline3">
                            <label class="form-check-label" for="materialInline3">{{$val->item_name}}</label>
                             </div>  
                           
                             @endforeach                     
                            </div>
                            <div id="famous" style="display:none;" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Famous For</label>
                                <textarea name="famous_for" id="famous_for" rows="3" cols="3" class="form-control" placeholder="Enter famous for"
                                    >{{$cardDetail->famous_for}}</textarea>
                            </div>                         
                            </div>

                            <div id="facility" style="display:none;" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Facilities</label>
                                <textarea name="facilities" id="facilities" rows="3" cols="3" class="form-control" placeholder="Enter facilities"
                                    >{{$cardDetail->facilities}}</textarea>
                            </div>                         
                            </div>

                            <div id="our_story" style="display:none;" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Our Story</label>
                                <textarea name="story" id="story" rows="5" cols="5" class="form-control" placeholder="Ente story"
                                    >{{$cardDetail->story}}</textarea>
                            </div>                         
                            </div>
                            <div id="custom" style="display:none;" >
                            <div class="form-group">
                                <label for="exampleInputPassword1">Card Color</label>&nbsp
                                <input type="color" id="favcolor" name="card_color" value="{{$cardDetail->card_color}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Font Color</label>
                                <input type="color" id="color" name="font_color" value="{{$cardDetail->font_color}}">
                            </div>
                            <div class="form-group">
                            <span><a class="btn btn-success addmore" style="border-radius:16px;" id="addtext" data-class="text">Add Text</a><span>  
                            <span><a class="btn btn-success addmore" style="border-radius:16px;" id="addtextarea" data-class="area">Add Textarea</a><span>  
                            <a href="https://fontawesome.com/icons?d=gallery" target="_blank" style="margin-left:17px; color:black;">Help</a>                      
                            </div>
                            </div>
                            <input type="hidden" name="custom_data" id="custom_data"/>
                            <div class="all">
                            <div class="row scheme_slabs" style="padding:0 15px;" id="slabs">
                               @if(!empty($custom_card) > 0)  
                               <?php $i=1; ?>
                               @foreach($custom_card as $val)
                               <input type="hidden" class="text{{$i}}" name="update_id[]" value="{{$val->id}}">
                              <div class="col-md-1 text{{$i}}" style="padding:0 5px;padding-left:10px">
                                <div class="form-group sl">
                                 <input type="text" value="{{$val->serial_no}}" id="custom_serial" class="form-control am from_amount"
                                 name="custom_serial[]" required placeholder="serial no">
                                  </div>
                                 </div>
                                <div class="col-md-2 text{{$i}}" style="padding:0 5px;">
                                <div class="form-group sl">
                                <input type="text" value="{{$val->title}}" id="custom_title" class="form-control am from_amount"
                                    name="custom_title[]" required placeholder="Title">
                                   </div>
                                  </div>
                                  <div class="col-md-2 text{{$i}}" style="padding:0 5px;">
                                <div class="form-group sl">
                                <input type="text" value="{{$val->code}}" id="custom_code" class="form-control am from_amount"
                                    name="custom_code[]" required placeholder="Code">
                                   </div>
                                  </div>
                                  @if($val->type =='text')
                                  <div class="col-md-6 text{{$i}}" style="padding:0 5px;">
                                    <div class="form-group sl">
                                   <input type="text" style="width:425px;" value="{{$val->text}}" id="custom_value" class="form-control am to_amount"
                                    name="custom_value[]" required  placeholder="text" >
                                   <input type="hidden" name="field_type[]" value="{{$val->type}}">
                                   </div>
                                      </div>
                                    @else
                                   <div class="col-md-6 text{{$i}}" style="padding:0 5px;">
                                     <div class="form-group sl">
                                      <textarea style="width:425px;" data-class="" value="" rows="3" cols="3" id="custom_value" class="form-control am"
                                       name="custom_value[]" required  placeholder="textarea" >{{$val->text}}</textarea>
                                      <input type="hidden" name="field_type[]" value="{{$val->type}}">
                                        </div>
                                    </div>

                                    @endif
                                   <div class="col-md-1 text{{$i}}" >
                                    <a class="btn btn-danger remove" data-attr="text{{$i}}">-</a>
                                    </div>
                                    <?php $i++; ?>
                               @endforeach
                               @endif                               
                            </div>
                             </div>
                           
                             <div id="social" style="display:none;">
                             @if(!empty($social_card) > 0)
                             <div class="form-group">
                                <label for="name">Social Media<span class="color-required"></span></label>
                                <select class="form-control" name="social_media" id="social_media">
                                    <option value="">Select</option>
                                    <option value="facebook"@if($social_card->social_media == 'facebook') selected @endif>Facebook</option>
                                    <option value="twitter"@if($social_card->social_media == 'twitter') selected @endif>Twitter</option>
                                    <option value="instagram"@if($social_card->social_media == 'instagram') selected @endif>Instagram</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Link</label>
                                <input type="text" name="link" id="link" value="{{$social_card->link}}" class="form-control"
                                    placeholder="Enter link">
                            </div>
                            <img src="{{url('public/card-images/'.$social_card->image)}}" style="weight:80px; height:80px;" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo</label>
                                <input type="file" name="social_image" id="social_image" value="{{$social_card->image}}" class="form-control"
                                   >
                            </div>
                                  @endif

                             </div>
                             
                            <!-- <div class="form-group">
                                <label for="exampleInputPassword1">Card Color</label>&nbsp
                                <input type="color" id="favcolor" name="card_color" value="#ffffff">
                            </div> -->
                         

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10" id="cardDetails">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/card-details')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

<script>
$(window).on("load", function() {


    var count = <?php if(!empty($custom_card)){echo count($custom_card);} else{ 0; } ?>;
var count1 = 0;
$(".addmore").click(function() {

 var attr =$(this).attr('data-class');
 
    var double = count + 2;
    count += 1;
    if(attr == 'text'){
        var string ='<div class="col-md-6 text'+count+'" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<input type="text" style="width:425px;" value="" id="custom_value" class="form-control am to_amount' + count +
        ' " name="custom_value[]" required  placeholder="text" >' +
        '<input type="hidden" name="field_type[]" value="text">'+
        '</div>'+
        '</div>';
    }else{

        var string ='<div class="col-md-6 text'+count+'" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<textarea style="width:425px;" data-class="" value="" rows="3" cols="3" id="custom_value" class="form-control am '+count+
        ' " name="custom_value[]" required  placeholder="textarea" ></textarea>' +
        '<input type="hidden" name="field_type[]" value="textarea">'+
        '</div>'+
        '</div>';
    }

    var abc = '<div class="col-md-1 text'+count+'" style="padding:0 5px;padding-left:10px">' +
        '<div class="form-group sl">' +
        '<input type="text" value="" id="custom_serial" class="form-control am from_amount' +
        count + '" name="custom_serial[]" required placeholder="serial no">' +
        '</div>' +
        '</div>' +
        '<div class="col-md-2 text'+count+'" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<input type="text" value="" id="custom_title" class="form-control am from_amount' +
        count + '" name="custom_title[]" required placeholder="Title">' +
        '</div>' +
        '</div>'+
        '<div class="col-md-2 text'+count+'" style="padding:0 5px;">' +
        '<div class="form-group sl">' +
        '<input type="text" value="" id="custom_title" class="form-control am from_amount' +
        count + '" name="custom_code[]" required placeholder="Code">' +
        '</div>' +
        '</div>'+
        string+
        '<div class="col-md-1 text'+count+'" style="">' +
        '<a class="btn btn-danger remove" data-attr="text'+count+'">-</a>'+
        '</div>';
        
        
        
        
    $('#slabs').append(abc);








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
    $("#cardDetails").click(function(){

var card =$('#card').val();
var title = $('#title').val();
var serial = $('#serial_no').val();
var email = $('#email').val();
var phone = $('#phone').val();
var gst = $('#gst').val();
var address = $('#address').val();
var lat = $('#latitude').val();
var long = $('#longitude').val();
var offering = $('#offering').val();
var famous = $('#famous_for').val();
var facility = $('#facilities').val();
var story = $('#story').val();

if(card == 1){
    if(title == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Title is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }
    if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(phone == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Phone no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(email == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Email is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(gst == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Gst is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(gst.length != 15){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Gst length must be 15 character</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(address == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Address is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }
}


if(card ==2)
{
    if(title == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Title is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }
    if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(lat == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Latitude is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(long == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Longitude is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

}

if(card == 3){
    if(title == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Title is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(offering.length == 0){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Offering product is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

}

if(card == 4){

    if(title == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Title is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

    if(famous == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Famous for is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }
}

if(card == 5){

if(title == ""){
    var html ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>Title is required</strong>'+
     '</div>';
     $('.error').html(html);
     return false;
}

if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

if(facility == ""){
    var html ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>Facilities is required</strong>'+
     '</div>';
     $('.error').html(html);
     return false;
}
}


if(card == 6){

if(title == ""){
    var html ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>Title is required</strong>'+
     '</div>';
     $('.error').html(html);
     return false;
}

if(serial == ""){
        var html ='<div class="alert alert-danger">'+
    	'<button type="button" class="close" data-dismiss="alert">×</button>'+	
        '<strong>Serial no. is required</strong>'+
         '</div>';
         $('.error').html(html);
         return false;
    }

if(story == ""){
    var html ='<div class="alert alert-danger">'+
    '<button type="button" class="close" data-dismiss="alert">×</button>'+	
    '<strong>Our story is required</strong>'+
     '</div>';
     $('.error').html(html);
     return false;
}

}


    });
});

$(window).on('load', function(){
    var val=$('#card').val();
   
    $('#card').prop('disabled', true);
    $('#social_media').prop('disabled', true);
    if(val == 1){  
          
             
             $('#quick_info').css('display','block');
         }else{
            $('#quick_info').css('display','none');
         }

         if(val == 2){ 
           
               
             $('#meet_us_here').css('display','block');
         }else{
            $('#meet_us_here').css('display','none');
         }

         if(val == 3){  
           
           
             $('#our_offering').css('display','block');
         }else{
            $('#our_offering').css('display','none');
         }
         if(val == 4){ 
            
             
             $('#famous').css('display','block');
         }else{
            $('#famous').css('display','none');
         }
         if(val == 5){  
           
               
             $('#facility').css('display','block');
         }else{
            $('#facility').css('display','none');
         }
         if(val == 6){  
           
            
             $('#our_story').css('display','block');
         }else{
            $('#our_story').css('display','none');
         }
         if(val == 8){ 
           
            
              
             $('#custom').css('display','block');
         }else{
            $('#custom').css('display','none');
         }

         if(val == 9){ 
           $('#social').css('display','block');
       }else{
          $('#social').css('display','none');
       }


});    


    $(document).ready(function () {
       
        $('#card').change(function (event) {
            var val=$(this).val();
         if(val == 1){        
             $('#quick_info').css('display','block');
         }else{
            $('#quick_info').css('display','none');
         }

         if(val == 2){        
             $('#meet_us_here').css('display','block');
         }else{
            $('#meet_us_here').css('display','none');
         }

         if(val == 3){        
             $('#our_offering').css('display','block');
         }else{
            $('#our_offering').css('display','none');
         }
         if(val == 4){        
             $('#famous').css('display','block');
         }else{
            $('#famous').css('display','none');
         }
         if(val == 5){        
             $('#facility').css('display','block');
         }else{
            $('#facility').css('display','none');
         }
         if(val == 6){        
             $('#our_story').css('display','block');
         }else{
            $('#our_story').css('display','none');
         }
           
            
        });
  



    var data = [];
    //$(".checked").click(function () {
        $('body').on('click','.checked',function(){
        
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

            var a = {class: get_class, val: $(this).val()};
            $.each(data, function (k, v) {
                                     
                 var len =data.length;
                 
                   if (v == undefined ){
                    console.log(v); 
                   // if(len >= 2 ){
                      
                     // location.reload();   
                 
                    //} 
                      
                }
                else {

                     if (v['val'] == ch2 && v['class'] == ch3) {
                      
                        delete data[k];                       
                        //delete data.k; 
                        console.log(data);
                    }
                      if(len == 1){
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

                   $.each(data, function (k, v) {

                    if (v == undefined) {

                    } else {
                        y += '<div onclick=\'remove_div_checkbox("' + v['class'] + '","' + v['val'] + '")\'  class="chip waves-effect waves-effect m-0 p-0 mb-1 ' + v['class'] + '">' + v['val'] + '<i class="close fa fa-times "></i></div>';
                    }
                    });
                // console.log(data);
                  //  $("#show_filter").html(y);

                   }
                       
                    }

                    var myArrayNew = data.filter(function (el) {
                    return el != null && el != "";
                         });
                     console.log('check');
                     console.log(myArrayNew);
                  $('#offering').val(JSON.stringify(myArrayNew));

        });

    });

    $(function(){
    $('body').on('click','.remove',function(){
    var atr = $(this).attr('data-attr');
    $('.'+atr).remove();
   

});
});

</script>



@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->