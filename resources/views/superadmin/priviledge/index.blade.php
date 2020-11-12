@extends('superadmin.superadmin-layouts.app')
@section('content')
<style>
.form-check-inline {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    padding-left: 0;
    margin-right: .75rem;
}
</style>


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Priviledge</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Priviledge</li>
                </ol>

                <!-- <a href="{{url('/module/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            @include('superadmin.superadmin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Priviledge Table </h4>

                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="module_type" value="" />
                    <div class="table-responsive mb-3">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>Role 1</th>
                                    <th>Role 2</th>
                                    <th>Role 3</th>
                                    <th>Role 4</th>
                                    <th>Role 5</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($module as $val)
                                <input type="hidden" name="ModuleId[]" value="{{$val->id}}" />

                                <tr>
                                    <td>{{$val->module_name}}</td>

                                    <td>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role1_{{$val->id}}" value="{{$val->role_type_1}}" id="role1_{{$val->id}}"
                                            @if($val->role_type_1==1) checked @endif >
                                            <label class="custom-control-label" for="role1_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                    <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role2_{{$val->id}}" value="{{$val->role_type_2}}" id="role2_{{$val->id}}"
                                            @if($val->role_type_2==1) checked @endif>
                                            <label class="custom-control-label" for="role2_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                    <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role3_{{$val->id}}" value="{{$val->role_type_3}}" id="role3_{{$val->id}}"
                                               @if($val->role_type_3==1) checked @endif >
                                            <label class="custom-control-label" for="role3_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                    <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role4_{{$val->id}}" value="{{$val->role_type_4}}" id="role4_{{$val->id}}"
                                            @if($val->role_type_4==1) checked @endif >
                                            <label class="custom-control-label" for="role4_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>
                                    <td>
                                     <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role5_{{$val->id}}" value="{{$val->role_type_5}}" id="role5_{{$val->id}}"
                                            @if($val->role_type_5==1) checked @endif >
                                            <label class="custom-control-label" for="role5_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:" class="btn btn-xs btn-primary update_priviledge"
                                            data-attr="{{$val->id}} ">Update</a>
                                    </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="{!!URL::to('/') . '/public/js/add-download-btn.js' !!}"></script>
<script>
var text = "DOWNLOAD";
var className = "btn";

$(".qrImage").each(function() {
    $(this).addDownloadBtn(text, className)
});
</script>

<script>
$(document).ready(function() {

    $('.update_priviledge').click(function(){
   var attr =$(this).attr('data-attr');
   if ($('.role1_'+attr).is(':checked')) {
       var role1 = 1;
    } else {
        var role1 = 0;
    }

    if ($('.role2_'+attr).is(':checked')) {
       var role2 = 1;
    } else {
        var role2 = 0;
    }

    if ($('.role3_'+attr).is(':checked')) {
       var role3 = 1;
    } else {
        var role3 = 0;
    }

    if ($('.role4_'+attr).is(':checked')) {
       var role4 = 1;
    } else {
        var role4 = 0;
    }

    if ($('.role5_'+attr).is(':checked')) {
       var role5 = 1;
    } else {
        var role5 = 0;
    }

   
   $.ajax({
                type: "GET",
                url: "{{url('/role-priviledge-action')}}",
                data: 'id=' + attr + '&role1=' +role1 + '&role2='+role2+'&role3='+role3+'&role4='+role4+'&role5='+role5,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
   
})

});
</script>

@endsection