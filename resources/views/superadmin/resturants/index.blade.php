@extends('superadmin.superadmin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Resturants</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Resturant</li>
                </ol>
               
             <a href="{{url('/restaurant/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
        @include('superadmin.superadmin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Resturants Table </h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Conact No.</th>                              
                                    <th>ID</th>
                                    <th>Enabled</th>
                                    <th>Action</th>
                                    <th>QR Code</th>
                                   
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
                           
                            @foreach($resturant as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->name}}</td>
                                    <td>{{$val->address}}</td>
                                    <td>{{$val->contact_number}}</td>                               
                                    <td>{{$val->resturant_id}}</td>  
                                    <td><a href="#" data-attr="{{$val->id}}"  attr-value="{{$val->enabled== 1 ? 0 : 1}}" class="btn btn-xs btn-{{$val->enabled== 1 ? 'success' : 'danger'}} action">
                                    {{$val->enabled== 1 ? 'Yes' : 'No'}}</a></td>   
                                    <td> <div class="btn-group">
                                        <a href="{{url('/restaurant/'.$val->id.'/edit')}}"
                                            class="btn btn-xs btn-success btn-xl">
                                            <i class="fa fa-edit"></i> Edit </a>
                                    </div></td>                                                                           
                                    <td> <img class="qrImage" src="data:image/png;base64, {!! base64_encode(QR::format('png')->size(200)->generate($val->project_url)) !!}" />
                                    </td>
                                </tr>
                                <?php $i++; ?>
                              @endforeach
                              
                            </tbody>
                        </table>
                        {{$resturant->links()}}
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
$(document).ready(function(){

$('.action').click(function(){
  var id = $(this).attr('data-attr');
  var action = $(this).attr('attr-value');
  //console.log(id);
  //console.log(action);

  $.ajax({
        type: "GET",
        url: "{{url('/restaurant-action')}}",
        data: 'id=' + id + '&action=' +action,
        success: function(data) {
          if(data.status == 'success'){
              location.reload();
          }
        }
    });

});
});


</script>

@endsection