@extends('superadmin.superadmin-layouts.app')
@section('content')
<style>
    .form-check-inline {
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding-left: 0;
        margin-right: .75rem;
    }
</style>


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Restaurant Priviledge</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Restaurant Priviledge</li>
                </ol>

                <!-- <a href="{{url('/module/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            @include('superadmin.superadmin-layouts.flash-message')
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Restaurant Priviledge</h4>

                 
                  
                        {{ csrf_field() }}
                    
                        <div class="table-responsive mb-3">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Module Name</th>
                                        <th>Module Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($module as $val)
                                    
                                    <tr>
                                        <td>{{$val->module_name}}</td>
                                        <td>
                                       <input type="hidden" name="update_id[]" value="{{$val->id}}" >
                                       <!-- <input type="hidden" name="update_status[]"  id="status_{{$val->id}}"> -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input check-status" id="stat_{{$val->id}}"  name="status{{$val->id}}" data-attr="{{$val->id}}"  @if($val->status==1) checked @endif >
                                                <label class="custom-control-label" for="stat_{{$val->id}}">
                                                </label>
                                            </div>
                                        </td>

                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        

                   



                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="{!!URL::to('/') . '/public/js/add-download-btn.js' !!}"></script>
<script>
    var text = "DOWNLOAD";
    var className = "btn";

    $(".qrImage").each(function() {
        $(this).addDownloadBtn(text, className)
    });
</script>

<script>
    $(document).ready(function() {

        $('.check-status').click(function() {
          
            var attr = $(this).attr('data-attr');
         
            if ($('#stat_'+attr).is(':checked')) {
               var action =1;
            } else {
                var action =0;
            }

            $.ajax({
                type: "GET",
                url: "{{url('/restaurant-priviledge-action')}}",
                data: 'id=' + attr + '&action=' + action,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        // location.reload();
                    }
                    else
                    {
                        if ($('#stat_'+attr).is(':checked')) {
                           $('#stat_'+attr).prop('checked',false);
                        } else {
                           $('#stat_'+attr).prop('checked',true);
                        }                        
                    }
                }
            });

          


          

        })

    });
</script>

@endsection