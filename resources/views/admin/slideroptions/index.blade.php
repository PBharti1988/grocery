@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Slider Options</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Slider Options</li>
                    <a href="{{url('slideroptioncreate/'.$id)}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
                </ol>
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
                                    <th>Slider Image</th>
                                    <th>Date From</td>                                
                                    <th>Date To</th>
                                    <th>Sort Order</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Product</th>
                                    <th>Enabled</th>
                                    <th>Action</th>                                
                                </tr>
                            </thead>
                            @if(count($areas) > 0 )
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
                                    <td><img src="{{asset('public/assets/images/slideroptions/'.$val->icon)}}" width="50" height="50"></td>
                                    <td>{{$val->date_from}}</td>
                                    <td>{{$val->date_to}}</td>
                                    <td>{{$val->sort_order}}</td>
                                    <td>
                                        
                                        @if($val->type == 'category')
                                         Category
                                        @endif
                                        @if($val->type == 'product')
                                        Product
                                        @endif
                                        @if($val->type=='none')
                                        None
                                        @endif

                                    </td>
                                    <td>{{getCategoryName($val->category) ?? "Not Available" }}</td>
                                    <td>{{getProductName($val->product) ?? "Not Available"}}</td>
                                    <td>
                                        @if($val->enabled == 1) Yes @else No @endif</td>
                        
                                    <td>
                                    <div class="btn-group">
                                         <!-- <a href="{{url('slideroption')}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Add </a>
                                             &nbsp; -->
                                        <a href="{{route('slideroptionupdate',$val->id)}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                    </div>
                                </td>
                                                                                      
                                </tr>
                                <?php $i++;?>
                              @endforeach
                              

                          
                              
                            </tbody>
                            @else
                              <tbody>
                              <tr><td>Data Not Available</td></tr>
                              </tbody>
                              @endif
                        </table>
                        {{$areas->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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