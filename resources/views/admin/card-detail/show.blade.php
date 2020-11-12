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

                <!-- <a href="{{url('card-details/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a>  -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Card Detail</h4>
                    <div class="table-responsive">
                        <table class="table">

                            <tr>
                                <th>Card : <b>{{$card->name}}</b></th>
                            </tr>
                            <tr>
                                @if($card->category_id != 8)
                                <th>Serial No : <b>{{$card->serial_no}}</b></th>
                            </tr>
                            <tr>
                                <th>Title : <b>{{$card->title}}</b></th>
                            </tr>
                            @endif
                            @if($card->category_id == 1)
                            <tr>
                                <th>Email : <b>{{$card->email}}</b></th>
                            </tr>
                            <tr>
                                <th>Phone no. : <b>{{$card->phone}}</b></th>
                            </tr>
                            <tr>
                                <th>Gst : <b>{{$card->gst}}</b></th>
                            </tr>
                            <tr>
                                <th>Address : <b>{{$card->address}}</b></th>
                            </tr>

                            @elseif($card->category_id == 2)
                            <tr>
                                <th>Latitude : <b>{{$card->latitude}}</b></th>
                            </tr>
                            <tr>
                                <th>Longitude : <b>{{$card->longitude}}</b></th>
                            </tr>
                            @elseif($card->category_id == 3)
                            <tr>
                                <th>Offering<b><br><br>
                                        <?php $j =0; $array=array(); $data = (array)$card->offering;
                                        foreach($data as $val){
                                         ?> <p>{{$val->val}}</p> <?php
                                        }
                                        
                                       
                                        ?>

                                    </b></th>
                            </tr>
                            @elseif($card->category_id == 4)
                            <tr>
                                <th>Famous :<b>
                                        {{$card->famous_for}}
                                    </b></th>
                            </tr>
                            @elseif($card->category_id == 5)
                            <tr>
                                <th>Facilites :<b>
                                        {{$card->facilities}}
                                    </b></th>
                            </tr>
                            @elseif($card->category_id == 6)
                            <tr>
                                <th>Story :<b>
                                        <p> {{$card->story}}</p>
                                    </b></th>
                            </tr>
                            @elseif($card->category_id == 8)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Serial No</th>
                                        <th>Title</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($custom_card))
                                    <?php $i=1; ?>
                                    @foreach($custom_card as $val)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$val->serial_no}}</td>
                                        <td>{{$val->title}}</td>
                                        <td style="word-wrap: break-word">{{$val->text}}</td>
                                    </tr> 
                                    <?php $i++; ?>
                                    @endforeach 
                                    @endif                                 
                                </tbody>
                            </table>
                            @elseif($card->category_id == 9)
                            <tr>
                                <th>Social Media : <b>{{$social_card->social_media}}</b></th>
                            </tr>
                            <tr>
                                <th>Link : <b>{{$social_card->link}}</b></th>
                            </tr>
                            <tr>
                                <th>Image : <img src="{{url('public/card-images/'.$social_card->image)}}" style="width:100px;height:100px;"></th>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection