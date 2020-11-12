@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">TIming</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Add Timing</li>
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
                <h3 class="box-title m-b-0">Add Timing</h3>
                <br>
                <div class="table-responsive mb-3">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>opening Time</th>
                                        <th>Closing Time</th>
                                        <th>Break Time From</th>
                                        <th>Break Time To</th>
                                        <th>Week Off</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timing as $val)
                                    
                                    <tr>
                                        <td>{{$val->day_name}}</td>          
                                        <td><input type="time" class="form-control" id="open_{{$val->id}}" value="{{$val->opening_time}}" name="opening_time"></td>
                                        <td><input type="time" class="form-control" id="close_{{$val->id}}" value="{{$val->closing_time}}" name="closing_time"></td>
                                        <td><input type="time" class="form-control" id="break_on_{{$val->id}}" value="{{$val->break_time_from}}" name="break_time_from"></td>
                                        <td><input type="time" class="form-control" id="break_off_{{$val->id}}"  value="{{$val->break_time_to}}" name="break_time_to"></td>
                                        <td>         
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input check-status" id="week_{{$val->id}}"  name="week_{{$val->id}}" data-attr="{{$val->id}}"  @if($val->week_off==1) checked @endif >
                                                <label class="custom-control-label" for="week_{{$val->id}}">
                                                </label>
                                            </div>
                                        </td>
                                        <td><a href="javascript:" class="btn btn-xs btn-success add_timing" data-attr="{{$val->id}} ">Add</a></td>

                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>

    </div>


</div>

<script>





    $(document).ready(function() {

        $('.add_timing').click(function() {
          
            var attr = $(this).attr('data-attr');
         
            if ($('#week_'+attr).is(':checked')) {
               var action =1;
            } else {
                var action =0;
            }

            var open_time =$('#open_'+attr).val();
            var close_time =$('#close_'+attr).val();
            var break_on =$('#break_on_'+attr).val();
            var break_off =$('#break_off_'+attr).val();
            
            // console.log(open_time);
            // console.log(close_time);
            // console.log(break_on);
            // console.log(break_off);
            // console.log(action);
           
           

            $.ajax({
                type: "GET",
                url: "{{url('/restaurant-timing-action')}}",
                data: 'id=' + attr + '&open_time=' + open_time+'&close_time='+close_time+'&break_on='+break_on+'&break_off='+break_off+'&week_off='+action,
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        // location.reload();
                    }
                    else
                    {
                        if ($('#week_'+attr).is(':checked')) {
                           $('#week_'+attr).prop('checked',false);
                        } else {
                           $('#week_'+attr).prop('checked',true);
                        }                        
                    }
                }
            });

          


          

        })

    });
</script>

@endsection
