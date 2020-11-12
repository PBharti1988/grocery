@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Question</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Question</li>
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
                <h3 class="box-title m-b-0">Add Question</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('question.store')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="form-group">
                                <label for="exampleInputEmail1">Question Type</label>
                               <select class="form-control" name="question_type" id="question_type" required>
                                   <option value="">select</option>
                                  @foreach($type as $val)
                                  <option value="{{$val->id}}">{{$val->type}}</option>
                                  @endforeach
                               </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Question</label>
                                <textarea name="question" rows="3" cols="4" class="form-control"
                                    placeholder="Enter Question" required></textarea>
                            </div>

                     <div class="form-group" id="option_section" style="display:none;">
                        <label for="description">Add Option<span class="color-required">*</span></label>
                       
                    </div>
                    <div class="error1"></div>
                    <div class="row scheme_slabs" style="display:none;" id="slabs">
                    <div class="col-md-9" style="padding:0 5px;">
                                <div class="form-group sl">
                                    <input type="text" style="width:87%;" value="" id="to_amount1"
                                        class="form-control am to_amount option_name" name="option_name[]"
                                        placeholder="Option Name">
                                </div>
                            </div>
                    </div>
                    <div class="form-group" id="option_button" style="display:none;">
                    <a class="btn btn-success btn-xs" style="margin-bottom:5px; color:white;" id="addmore"> <i class="fa fa-plus"></i> Add</a>
                   
                      
                    </div>
                            
                          
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                {{old('Enabled') == 'on' ? 'checked': ''}}>
                            <label class="custom-control-label" for="customSwitch1">Enabled</label>
                        </div>
                    </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10 submit">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/tax')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


<script>
function removeOption(x){
  //  $(x).parent().parent().prev('div').remove();
    $(x).parent().parent('div').remove();
}

$(document).ready(function() {


    var count = 0;

    $("#addmore").click(function() {
        $("#addmore").text('Add More');
        var double = count + 2;
        count += 1;

        var option_html = `
        <div class="col-md-9" style="padding:0 5px;">
            <div class="form-group sl">
                <input type="text" style="width:87%;display:inline-block" value="" id="to_amount1"
                    class="form-control am to_amount${count} option_name" name="option_name[]" required
                    placeholder="Option Name">
                <img onclick="removeOption(this)" class="remove-button" style="display:inline-block;" width="32" src="{{url('public/assets/images/remove.png')}}"/>
            </div>
        </div>
        `;

        // var abc = '<div class="col-md-3" style="padding:0 5px;padding-left:10px">' +
        //     '<div class="form-group sl">' +
        //     '<input type="text" value="" id="from_amount1" maxlength="1" class="form-control am option_number from_amount'+
        //     count + '" name="option_number[]" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="Option Number">' +
        //     '</div>' +
        //     '</div>' +
        //     '<div class="col-md-9" style="padding:0 5px;">' +
        //     '<div class="form-group sl">' +
        //     '<input type="text" style="width:87;" value="" id="to_amount1" class="form-control am to_amount' +
        //     count +
        //     ' " name="option_name[]" required  placeholder="Option Name" >' +
        //     '</div>' +
        //     '</div>';
        $('#slabs').append(option_html);

    });



    $('#question_type').change(function(event) {
        var val = $(this).val();
       
       if(val == 3){
        $('#option_section').css('display', 'none');
        $('#option_button').css('display', 'none');
        $('#slabs').css('display', 'none');
       }else{
        $('#option_section').css('display', 'block');
        $('#option_button').css('display', 'block');
        $('#slabs').css('display', 'block');
       }

    });




    $(".submit").click(function() {
    var val = $('#question_type').val();
        
     if(val == 2 || val == 1){

     var data = [];
     $("#slabs").find('.option_name').each(function() {
     var value = $(this).val();
        data.push(
                value,
            );
        });


    var count_len = data.length;   
    var i;
    var j;
   
    //if(data[0] != ""){
    for (i = 0; i < count_len; i++) {
    for(j=0; j<=count_len-1-i;j++){
        
         if(data[j] == ""){    
                var t = j+1;
            var error1 = '<div class="alert alert-danger" style="width:55%;">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>option number '+t+' is blank</strong>' +
                    '</div>';
                $('.error1').html(error1);
             return false;
         }
    }
    }
    }
         
    });

});
</script>


@endsection
