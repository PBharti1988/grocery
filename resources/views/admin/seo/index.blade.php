@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Restaurant Seo</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Restaurant Seo</li>
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
                <h3 class="box-title m-b-0">Add Seo Details</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{url('seo-store')}}" enctype="multipart/form-data">
                            {{csrf_field()}}                
                            <div class="form-group">
                                <label for="exampleInputEmail1">Google Analytic ID</label>
                                <textarea name="google_analytic_id" value="" rows="3" cols="3" class="form-control" placeholder="Enter google analytic id"
                                    >{{$seo->google_analytic_id}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Facebook Pixel ID</label>
                                <textarea name="facebook_pixel_id" value="" rows="3" cols="3" class="form-control" placeholder="Enter facebook pixel id"
                                    >{{$seo->facebook_pixel_id}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tracking ID</label>
                                <textarea name="tracking_id" value="" rows="3" cols="3" class="form-control"
                                    placeholder="Enter tracking id">{{$seo->tracking_id}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta Title</label>
                                <input type="text" name="meta_title" value="{{$seo->meta_title}}" class="form-control"
                                    placeholder="Enter meta title">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta Description</label>
                                <input type="text" name="meta_description" value="{{$seo->meta_description}}"  class="form-control"
                                    placeholder="Enter meta description">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta Keyword</label>
                                <input type="text" name="meta_keyword" value="{{$seo->meta_keyword}}" class="form-control"
                                    placeholder="Enter meta keyword">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Open Graph Tag Facebook</label>
                                <input type="text" name="og_tag_facebook" value="{{$seo->og_tag_facebook}}"  class="form-control"
                                    placeholder="Enter open graph tag facebook">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Open Graph Tag Twitter</label>
                                <input type="text" name="og_tag_twitter" value="{{$seo->og_tag_twitter}}"   class="form-control"
                                    placeholder="Enter open graph tag twitter">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Open Graph Tag Linkeden</label>
                                <input type="text" name="og_tag_linkeden" value="{{$seo->og_tag_linkeden}}"   class="form-control"
                                    placeholder="Enter open graph tag linkeden">
                            </div>

                            <button type="submit"
                                class="btn btn-success waves-effect waves-light m-r-10">Save</button>
                                <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/admin')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->