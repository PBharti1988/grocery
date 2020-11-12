@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">SMS Template</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit sms template</li>
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
                <h3 class="box-title m-b-0">Edit sms template</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('sms-template.update',$template->id)}}" enctype="multipart/form-data">
                        {{ method_field('put') }}
                        {{csrf_field()}}
                      
                            <div class="form-group">
                                <label for="exampleInputEmail1">Message</label>
                                <textarea rows="8" cols="50" type="text" name="message" class="form-control"
                                    placeholder="Enter message" required>{{$template->message}}</textarea>
                            </div>
                           
                         <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$template->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>
                           

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/sms-template')}}">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>


@endsection
