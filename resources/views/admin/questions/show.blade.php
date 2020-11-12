@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Feedback Questions</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Feedback Questions</li>
                </ol>
  
           
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-8">
            <div class="card-box">
                <h4 class="header-title">Feedback Question</h4>
                <p class="sub-header mb-0">{{$question->question}}</p>

                <div class="mt-3">
                    <?php $i=1; ?>
                    @foreach($options as $val)
                    <p>{{$i++}}. &nbsp{{$val->options}}</p>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-4">
            <div class="card-box">
               
                <h5 class="mt-0">Option Name<span class="text-muted float-right">22%</span></h5>
                <div class="progress progress-md" style="margin-bottom:20px">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width:99%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            
            </div>
        </div> -->
     
    </div>

</div>


    <!-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Feedback Questions</h4>
                 
                    <div class="table-responsive">
                   
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> -->



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
                url: "{{url('/question-action')}}",
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