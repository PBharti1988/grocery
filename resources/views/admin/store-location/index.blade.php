@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Store City & Location</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Store Locations</li>
                </ol>
                <a href="{{url('storelocation/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New Area</a> 
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
        @include('admin.admin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">City Details</h4>

                  <form method="post" action="{{url('storelocation/cityupdate')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="restaurant_id" value="{{$res_id}}">
                    <div class="form-group">
                      <label for="city_name">City Name</label>
                      <input type="text" id="city_name" name="city_name" value="{{$city->city_name}}" class="form-control" placeholder="Enter City Name" required>
                    </div>

                            <div class="form-group" style="margin-left:12px;">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$city->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>
                            </div>

                    <button type="submit"
                    class="btn btn-success waves-effect waves-light m-r-10">Submit</button>                 
                  </form>



                    <br/>
                    <br/>
                    <br/>



                    <h4 class="card-title">Area List</h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>City Name</th>
                                    <th>Area Name</td>                                
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
                                    <td>{{$val->city_name}}</td>
                                    <td>{{$val->area_name}}</td>
                                    <td class="">@if($val->enabled == 1) Yes @else No @endif</td>
                                    <td>
                                    <div class="btn-group">
                                        <a href="{{url('/storelocation/'.$val->id.'/edit')}}"
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