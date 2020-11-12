@extends('superadmin.superadmin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Role</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Role</li>
                </ol>
               
             <a href="{{url('/role/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
        @include('superadmin.superadmin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Role Table </h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
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
                           
                            @foreach($role as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->role_name}}</td>
                                    <td>@if($val->description != null){{$val->description}} @else null @endif</td>                                   
                                   <td> {{$val->enabled== 1 ? 'Yes' : 'No'}}</td>   
                                    <td> 
                                        <a href="{{url('/role/'.$val->id.'/edit')}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                                                                                            
                                   
                                   <a href="javascript:" data-attr="{{$val->id}}"
                                    attr-value="{{$val->enabled== 0 ? 1 : 0}}"
                                    class="btn btn-xs btn-{{$val->enabled== 0 ? 'success' : 'danger'}} action">
                                    @if($val->enabled== 1)
                                    <i class="fa fa-ban"></i>
                                    @else
                                    <i class="fa fa-check"></i>
                                    @endif
                                    {{$val->enabled== 0 ? 'Enable' : 'Disable'}}</a></td>
                                </tr>
                                <?php $i++; ?>
                              @endforeach
                              
                            </tbody>
                        </table>
                        {{$role->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="{!!URL::to('/') . '/public/js/add-download-btn.js' !!}"></script>
 <script>
    var text = "DOWNLOAD";
    var className = "btn";

    $(".qrImage").each(function(){
      $(this).addDownloadBtn(text, className)
    });
</script>

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
            url: "{{url('/role-action')}}",
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