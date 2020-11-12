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
                    <li class="breadcrumb-item active">SMS Template View</li>
                </ol>
               
             <a href="{{url('sms-template')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class=""></i>Back</a> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-box">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Message<span class="color-required"></span></label>
                    <div class="col-md-6">
                        <p class="col-form-label text-justify">{{$template->message}}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Date<span class="color-required"></span></label>
                    <div class="col-md-6">
                        <p class="col-form-label">{{date('d-m-Y', strtotime($template->created_at))}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
</div>


@endsection