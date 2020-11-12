@extends('admin.admin-layouts.app')
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
                    <h4 class="card-title">Priviledge Table : Manager</h4>

                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="module_type" value="" />
                    <div class="table-responsive mb-3">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>View</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($module as $val)
                                <input type="hidden" name="ModuleId[]" value="{{$val->id}}" />
                                <input type="hidden" name="ModuleSlug[]" value="{{$val->module_slug}}" />
                                <tr>
                                    <td>{{$val->module_name}}</td>

                                    <td>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role1_1_{{$val->id}}" value="{{$val->view}}" id="role1_1_{{$val->id}}"
                                            @if (isset($modulePrivileges['1'][$val->module_slug]['view']) && $modulePrivileges['1'][$val->module_slug]['view']==1) checked @endif >
                                            <label class="custom-control-label" for="role1_1_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role2_1_{{$val->id}}" value="{{$val->create}}" id="role2_1_{{$val->id}}"
                                            @if (isset($modulePrivileges['1'][$val->module_slug]['create']) && $modulePrivileges['1'][$val->module_slug]['create']==1) checked @endif >
                                            <label class="custom-control-label" for="role2_1_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role3_1_{{$val->id}}" value="{{$val->update}}" id="role3_1_{{$val->id}}"
                                            @if (isset($modulePrivileges['1'][$val->module_slug]['update']) && $modulePrivileges['1'][$val->module_slug]['update']==1) checked @endif >
                                            <label class="custom-control-label" for="role3_1_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                        <a href="javascript:" class="btn btn-xs btn-primary update_priviledge"
                                            data-attr="{{$val->id}}" data-type="1"  data-slug="{{$val->module_slug}}"  >Update</a>
                                    </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>



                </div>
                <div class="card-body">
                    <h4 class="card-title">Priviledge Table : Staff </h4>

                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="module_type" value="" />
                    <div class="table-responsive mb-3">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>View</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($module as $val)
                                <input type="hidden" name="ModuleId[]" value="{{$val->id}}" />
                                <input type="hidden" name="ModuleSlug[]" value="{{$val->module_slug}}" />

                                <tr>
                                    <td>{{$val->module_name}}</td>

                                    <td>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role1_2_{{$val->id}}" value="{{$val->view}}" id="role1_2_{{$val->id}}"
                                            @if (isset($modulePrivileges['2'][$val->module_slug]['view']) && $modulePrivileges['2'][$val->module_slug]['view']==1) checked @endif >
                                            <label class="custom-control-label" for="role1_2_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role2_2_{{$val->id}}" value="{{$val->create}}" id="role2_2_{{$val->id}}"
                                            @if (isset($modulePrivileges['2'][$val->module_slug]['create']) && $modulePrivileges['2'][$val->module_slug]['create']==1) checked @endif>
                                            <label class="custom-control-label" for="role2_2_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input role3_2_{{$val->id}}" value="{{$val->update}}" id="role3_2_{{$val->id}}"
                                            @if (isset($modulePrivileges['2'][$val->module_slug]['update']) && $modulePrivileges['2'][$val->module_slug]['update']==1) checked @endif>
                                            <label class="custom-control-label" for="role3_2_{{$val->id}}">
                                                </label>
                                        </div>
                                    </td>



                                    <td>
                                        <a href="javascript:" class="btn btn-xs btn-primary update_priviledge"
                                        data-attr="{{$val->id}}" data-type="2" data-slug="{{$val->module_slug}}">Update</a>
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

<script>
$(document).ready(function() {

    $('.update_priviledge').click(function(){
   var attr =$(this).attr('data-attr');
   var slug =$(this).attr('data-slug');
   var user_type =$(this).attr('data-type');
   if ($('.role1_'+user_type+'_'+attr).is(':checked')) {
       var role1 = 1;
    } else {
        var role1 = 0;
    }

    if ($('.role2_'+user_type+'_'+attr).is(':checked')) {
       var role2 = 1;
    } else {
        var role2 = 0;
    }

    if ($('.role3_'+user_type+'_'+attr).is(':checked')) {
       var role3 = 1;
    } else {
        var role3 = 0;
    }

   
   $.ajax({
                type: "GET",
                url: "{{url('/permission-update')}}",
                data: 'id=' + attr + '&slug=' +slug +'&type=' +user_type + '&role1=' +role1 + '&role2='+role2+'&role3='+role3,
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