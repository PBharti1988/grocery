@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Feedback</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Feedback View</li>
                </ol>


            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Feedback Detail</h4>

                    <div class="table-responsive">
                        <table class="table">

                            <tr>
                                <th>Name : <b>{{$feedback->name}}</b></th>
                            </tr>
                            <tr>                           
                                <th>Email : <b>{{$feedback->email}}</b></th>
                            </tr>
                            <tr>                           
                                <th>Mobile : <b>{{$feedback->mobile}}</b></th>
                            </tr>
                            <tr>                           
                                <th>Rating : <b>{{$feedback->rating}}</b></th>
                            </tr>
                           
                                                  
                        </table>
                        <h3>Feedback Answers</h3>
                        <br>
                        <div class="form-group">
                            @if(count($questions) > 0)
                            <?php $i =1; ?>
                            @foreach($questions as $val)
                         <label  class="control-label">Q{{$i}}:&nbsp&nbsp{{$val->question}}</label>
                         <p>ans:&nbsp&nbsp {{$val->real_answer}}</p>
                         <?php $i++; ?>
                             @endforeach                        
                         @endif
                        </div> 
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection