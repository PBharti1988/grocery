
@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">{{__('Language')}}</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{__('Language')}}</li>
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
                <h3 class="box-title m-b-0">{{__('Choose Language')}}</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                    <form method="post" action="{{url('set-language')}}" enctype="multipart/form-data">
                        {{csrf_field()}}

                             
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{__('Language')}}</label>
                              <select class="form-control" name="locale" required>
                              <option value="">{{__('Select')}}</option>
                              @foreach($lang as $val)
                                  <option value="{{$val->code}}"@if(Session::get('locale') == $val->code) selected @endif>{{$val->language}}</option>
                              @endforeach
                              </select>
                            </div>
                            
                           
                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">{{__('Submit')}}</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/admin')}}">{{__('Back')}}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>

<script>
$(document).ready(function() {
    $('#start_date,#end_date').flatpickr({
        dateFormat: "Y-m-d",
    });

});
</script>

@endsection








