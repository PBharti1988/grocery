@extends('admin.admin-layouts.app')
@section('content')

<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Shelves</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Shelf Offers</li>
                </ol>
                <a href="{{url('shelf-offers/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Shelves</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Shelf Number</th>
                                    <th>Image</td>
                                    <th>Start Date</td>
                                    <th>End Date</td>
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
                                @foreach($offers as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->shelf_number}}</td>
                                    <td><img src="{{asset('public/assets/images/shelf-offers/'.$val->offer_image)}}" width="60" height="60"></td>
                                    <td>{{$val->start_date}}</td>
                                    <td>{{$val->end_date}}</td>
                                    <td class="">@if($val->enabled == 1) Yes @else No @endif</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{url('/shelf-offers/'.$val->id.'/edit')}}" class="btn btn-success btn-xs">
                                                <i class="fa fa-edit"></i> Edit </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                @endforeach
                            </tbody>
                        </table>
                        {{$offers->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection