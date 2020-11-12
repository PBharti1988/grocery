@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Card Details</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Card Details</li>
                </ol>
               
             <a href="{{url('card-details/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>
    


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Item Table </h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Card</th>                              
                                    <th>Title</th> 
                                    <th>Serial No</th>  
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
                               
                            @foreach($card as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->name}}</td>                               
                                    <td>{{$val->title}}</td>    
                                    <td>{{$val->serial_no}}</td>    
                                    <td>{{$val->enabled==1?'Yes':'No'}}</td>           
                                    <td><div class="btn-group">
                                    <a href="{{url('/card-details/'.$val->id)}}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> View </a>
                                        <a href="{{url('/card-details/'.$val->id.'/edit')}}"
                                            class="btn btn-info btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                            <a href="javascript:" data-attr="{{$val->id}}"
                                    attr-value="{{$val->enabled== 0 ? 1 : 0}}"
                                    class="btn btn-xs btn-{{$val->enabled== 0 ? 'success' : 'danger'}} action">
                                    @if($val->enabled== 1)
                                    <i class="fa fa-ban"></i>
                                    @else
                                    <i class="fa fa-check"></i>
                                    @endif
                                    {{$val->enabled== 0 ? 'Enable' : 'Disable'}}</a>
                                    </div>
                                </td>                                                                                      
                                </tr>
                               <?php $i++; ?>
                              @endforeach
                           
                          
                              
                            </tbody>
                        </table>
                       {{$card->links()}}
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
            url: "{{url('/card-action')}}",
            data: 'id=' + id + '&action=' + action,
            success: function(data) {
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