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
                    <li class="breadcrumb-item active">Feedback</li>
                </ol>
               
         
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Feedback Table </h4>
                 
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Star Rating</th>
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
                            @foreach($feedbacks as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->name}}</td>                                   
                                    <td class="wrap">{{$val->email}}</td>
                                    <td class="">{{$val->mobile}}</td>
                                    <td class="">{{$val->rating}}</td>
                                   <td><a href="{{url('/admin/feedback/'.$val->id)}}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i> View </a>
                                    <td>                 
                               
                                                                                      
                                </tr>
                                <?php $i++;?>
                              @endforeach
                          
                              
                            </tbody>
                        </table>
                        @if(count($feedbacks) >0)
                        {{$feedbacks->links()}}
                      @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection