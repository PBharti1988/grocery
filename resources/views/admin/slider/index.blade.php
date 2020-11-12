@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Slider</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Slider</li>
                </ol>
                <a href="{{url('slider/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
        @include('admin.admin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                   
                    <h4 class="card-title">Slider List</h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Slider Name</th>
                                    <th>Start Date</td>                                
                                    <th>End Date</th>
                                    <th>Image</th>
                                    <th>Section Order</th>
                                    <th>Enabled</th>
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                      if (isset($_REQUEST['page'])) {
                      $page_no = $_REQUEST['page'];
                      $i = ($page_no - 1) * 10 + 1;
                      }
                      ?>
                            @foreach($areas as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->slider_name}}</td>
                                    <td>{{$val->start_date}}</td>
                                    <td>{{$val->end_date}}</td>
                                    <td><img src="{{asset('public/assets/images/slider/'.$val->icon)}}" width="50" height="50"></td>
                                    <td>{{$val->section_order}}</td>

                                    <td class="">@if($val->enabled == 1) Yes @else No @endif</td>
                                    <td>
                                    <div class="btn-group">
                                         <a href="{{url('slideroption/'.$val->id)}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Add </a>
                                             &nbsp;
                                        <a href="{{url('/slider/'.$val->id.'/edit')}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                    </div>
                                </td>
                                                                                      
                                </tr>
                                <?php $i++;?>
                              @endforeach
                          
                              
                            </tbody>
                        </table>
                        {{$areas->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<script>
$(document).ready(function() {

    $('.action').click(function() {
        var id = $(this).attr('data-attr');
        var action = $(this).attr('attr-value');
        var text = 'Are you sure want to disable?';
        if(action == '1'){
            text = 'Are you sure want to enable?';
        }
        var r = confirm(text);
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "{{url('/tax-action')}}",
                data: 'id=' + id + '&action=' + action,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        }
    });

});
</script>

@endsection