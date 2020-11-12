@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Tax</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Tax</li>
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
                <h3 class="box-title m-b-0">Edit Tax</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('tax.update',$tax->id)}}" enctype="multipart/form-data">
                        {{ method_field('put') }}
                        {{csrf_field()}}
                       
                             <div class="form-group">
                                <label for="exampleInputEmail1">Tax Name</label>
                                <input type="text" name="tax_name" value="{{$tax->tax_name}}" class="form-control"
                                    placeholder="Enter tax Name" required>
                            </div>
                           
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tax value</label>
                                <input type="text" class="form-control" value="{{$tax->tax_value}}" name="tax_value"
                                id="txtChar" onkeypress="return isNumberKey(event)"  placeholder="Enter tax value" required>
                            </div>
                           
                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$tax->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/tax')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>
<script>
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>


@endsection
