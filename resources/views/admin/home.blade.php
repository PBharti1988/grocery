@extends('admin.admin-layouts.app')

@section('content')


<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">{{__('Dashboard')}}</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                    
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">{{__('Admin')}}</a></li>
                                <li class="breadcrumb-item active">{{__('Dashboard')}}</li>
                            </ol>
                            <!-- <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button> -->
                        </div>
                    </div>
                </div>
                <?php // dd($resturant); ?>
                <div class="card-group">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="fa fa-qrcode"></i> {{$resturant->name}}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <img class="qrImage" src="data:image/png;base64, {!! base64_encode(QR::format('png')->size(200)->generate($resturant_qr->project_url)) !!}" />
                            </div>
                            <p class="text-muted"><b align-items-center></b></p>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-bag"></i>{{__('Products')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="text-muted">{{__('Max Items')}}: {{$totalItems}}</p>
                                <p class="text-muted">{{__('Active Items')}}: {{$activeItem}}</p>


                                <div class="progress">
                                    <div class="progress-bar bg-purple" role="progressbar" style="width: 63%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                                <!-- <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                    <!-- Column -->                   
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="fa fa-bolt"></i>{{__('Quick Action')}}</h3>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <!---<div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4>{{__('Home Delivery')}}</h4>
                                        <p class="text-muted"></p>
                                    </div>
                
                                    <div class="ml-auto">
                                        <div class="form-group" style="margin-left:12px;">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="delivery_enabled" data-attr="{{$resturant->home_delivery== 0 ? 1 : 0}}" class="custom-control-input" id="switch2"
                                                    {{$resturant->home_delivery == 1 ? 'checked': ''}}>
                                                <label class="custom-control-label" for="switch2">{{$resturant->home_delivery== 0 ? __('Disabled') : __('Enabled')  }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>  -->

                                <?php 
                        
                                    if(Auth::guard('restaurant')->id()){
                                        $id= Auth::guard('restaurant')->id();
                                    }
                                    else{
                                        $manager_id = Auth::guard('manager')->id();
                                        $res_id=App\Manager::find($manager_id);
                                        $restaurant_id=$res_id->restaurant_id;
                                        $user_type=$res_id->user_type;
                                        $perms=get_admin_module_permission($restaurant_id,$user_type,'dashboard');
                                    }
                                ?>
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4>{{__('Take Away')}}</h4>
                                        <p class="text-muted"></p>
                                    </div>
                
                                    <div class="ml-auto">
                                        <div class="form-group" style="margin-left:12px;">
                                            
                                        <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="switch1" data-attr="{{$resturant->take_away== 0 ? 1 : 0}}" name="example"  {{$resturant->take_away == 1 ? 'checked': ''}}   @if(isset($perms)){{ $perms->update != 1 ? 'disabled="disabled"': ''}} @endif >
                                          <label class="custom-control-label" for="switch1">{{$resturant->take_away== 0 ? __('Disabled') : __('Enabled') }}</label>
                                           </div>


                                            <!-- <div class="custom-control custom-switch">
                                                <input type="checkbox" name="take_away_enabled" class="custom-control-input" id="customSwitch3"
                                                    {{$resturant->take_away == 1 ? 'checked': ''}}>
                                                <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                            </div> -->
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4> GST</h4>
                                        <p class="text-muted"></p>
                                    </div>
                                    <?php // print_r($resturant); ?>
                                    <div class="ml-auto">
                                        <div class="form-group" style="margin-left:12px;">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" name="gst_enabled" class="custom-control-input" id="customSwitch1"
                                                    {{$resturant->gst == 1 ? 'checked': ''}} @if(isset($perms)){{ $perms->update != 1 ? 'disabled="disabled"': ''}} @endif >
                                                <label class="custom-control-label" for="customSwitch1">{{__('Enabled')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h4>{{__('Order Accepting')}}</h4>
                                        <p class="text-muted"></p>
                                    </div>
                
                                    <div class="ml-auto">
                                        <div class="form-group" style="margin-left:12px;">
                                            
                                        <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="switch5" data-attr="{{$resturant->order_accepting== 0 ? 1 : 0}}" name="example"  {{$resturant->order_accepting == 1 ? 'checked': ''}} @if(isset($perms)){{ $perms->update != 1 ? 'disabled="disabled"': ''}} @endif>
                                          <label class="custom-control-label" for="switch5">{{$resturant->order_accepting == 0 ? __('Disabled') : __('Enabled') }}</label>
                                           </div>


                                            <!-- <div class="custom-control custom-switch">
                                                <input type="checkbox" name="take_away_enabled" class="custom-control-input" id="customSwitch3"
                                                    {{$resturant->take_away == 1 ? 'checked': ''}}>
                                                <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                            </div> -->
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <!-- <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- Column -->                    
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3><i class="fa fa-users"></i>{{__('Visits')}}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="text-muted">{{__('Scans Count')}}: {{$counter}}</p>
                                    <p class="text-muted">{{__('Orders Placed')}}: {{$orderPlaced}}</p>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php if( $orderPlaced > 0){ echo (($orderPlaced/$counter)*100); } else{echo "0";}?>%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="text-muted">{{__('Conversion Rate')}}: <?php if($orderPlaced > 0){echo round(($orderPlaced/$counter)*100,2); } else{echo "0";}?>%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <!-- Column -->
<!--                     <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex m-b-40 align-items-center no-block">
                                    <h5 class="card-title ">YEARLY SALES</h5>
                                    <div class="ml-auto">
                                        <ul class="list-inline font-12">
                                            <li><i class="fa fa-circle text-cyan"></i> Iphone</li>
                                            <li><i class="fa fa-circle text-primary"></i> Ipad</li>
                                            <li><i class="fa fa-circle text-purple"></i> Ipod</li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="morris-area-chart" style="height: 340px;"></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">{{$today}}<sup></sup></div>
                                        <p class="text-white">{{__('Orders')}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!-- <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1> -->
                                        <b class="text-white">{{__('Today')}}</b>
                                        <p class="op-5">{{date("M")}} {{ date("d")}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">{{$weekly}}<sup></sup></div>
                                        <p class="text-white">{{__('Orders')}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <b class="text-white">{{('Last 7 Days')}}</b>
                                        <p class="op-5"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">{{$monthly}}<sup></sup></div>
                                        <p class="text-white">{{__('Orders')}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <b class="text-white">{{('Last 30 Days')}}</b>
                                        <p class="op-5"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
<!--                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">73<sup>°F</sup></div>
                                        <p class="text-white">AHMEDABAD, INDIA</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1>
                                        <b class="text-white">SUNNEY DAY</b>
                                        <p class="op-5">April 14</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>


                <div class="row">
                    <!-- Column -->
<!--                     <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex m-b-40 align-items-center no-block">
                                    <h5 class="card-title ">YEARLY SALES</h5>
                                    <div class="ml-auto">
                                        <ul class="list-inline font-12">
                                            <li><i class="fa fa-circle text-cyan"></i> Iphone</li>
                                            <li><i class="fa fa-circle text-primary"></i> Ipad</li>
                                            <li><i class="fa fa-circle text-purple"></i> Ipod</li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="morris-area-chart" style="height: 340px;"></div>
                            </div>
                        </div>
                    </div> -->
                    <!-- Column -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div><h3>{{$symbol}} {{$today_amt}}</h3></div>
                                        <p class="text-white">Collection</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <!-- <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1> -->
                                        <b class="text-white">Today</b>
                                        <p class="op-5">{{date("M")}} {{ date("d")}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div>
                                           <h3>{{$symbol}} {{$weekly_amt}}
                                             </h3>
                                           </div>
                                        <p class="text-white">{{('Collection')}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <b class="text-white">{{('Last 7 Days')}}</b>
                                        <p class="op-5"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                    <h3>&nbsp;</h3>
                                        <div>
                                           <h3>{{$symbol}} {{$monthly_amt}}
                                             </h3>
                                           </div>
                                        <p class="text-white">{{('Collection')}}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <b class="text-white">{{('Last 30 Days')}}</b>
                                        <p class="op-5"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
<!--                    <div class="col-lg-4 col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">73<sup>°F</sup></div>
                                        <p class="text-white">AHMEDABAD, INDIA</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1>
                                        <b class="text-white">SUNNEY DAY</b>
                                        <p class="op-5">April 14</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
                <!-- ============================================================== -->
                <!-- Comment - table -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- Comment widgets -->
                    <!-- ============================================================== -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{('Recent Comments')}}</h5>
                            </div>
                            <!-- ============================================================== -->
                            <!-- Comment widgets -->
                            <!-- ============================================================== -->
                            <div class="comment-widgets">
                                <!-- Comment Row -->

                                 @if(count($lastFeed) > 0)
                                @foreach($lastFeed as $val)
                                <div class="d-flex no-block comment-row">
                                    <!-- <div class="p-2"><span class="round"><img src="../assets/images/users/1.jpg" alt="user" width="50"></span></div> -->
                                    <div class="comment-text w-100">
                                        <h5 class="font-medium">{{$val->name}}</h5>
                                        <p class="m-b-10 text-muted">I was at my grand ma place in New delhi so for afternoon snacks we had ordered some snacks from this specialist outlet located in New delhi.
They are expertise in there all types of amazing and delicious south indian food the quality and taste of there food is just amazing.</p>
                                        <div class="comment-footer">
                                            <span class="text-muted pull-right">{{date("d-F-Y", strtotime($val->created_at))}}</span> <span class="badge badge-pill badge-info">{{__('Rating')}}</span> <span style="color:#ffcd00">
                                            <?php 
                                            if($val->rating != ""){
                                             for($i=0;$i<=$val->rating - 1; $i++){                                            
                                              echo "★";                                          
                                            }
                                            }else{
                                            echo "★";  
                                            }
                                            ?>
                                                    <!-- <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>     -->
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                @else
                                <div class="d-flex no-block comment-row">
                                <div class="comment-text w-100">
                                <h3 class="font-medium">{{__('No Record')}}</h3>
                                </div>
                                </div>
                                @endif
                                <!-- Comment Row -->
                                <!-- <div class="d-flex no-block comment-row border-top">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/2.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text active w-100">
                                        <h5 class="font-medium">Vishal Gupta</h5>
                                        <p class="m-b-10 text-muted">My experience with this place was amazing
Super quick delivery
Variety of options available too.
I had ordered mumbai masala pasta which was so delicious and cheesy.
The quantity was also sufficient..</p>
                                        <div class="comment-footer">
                                            <span class="text-muted pull-right">May 14, 2020</span>
                                            <span class="badge badge-pill badge-success">Approved</span>
                                            <span class="action-icons active">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Comment Row -->
                                <!-- <div class="d-flex no-block comment-row border-top">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/3.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5 class="font-medium">Ravi Chandran</h5>
                                        <p class="m-b-10 text-muted">I have great experience with gourmet hub mall in Sagar ratna whole team members they're manager such a great person Mr.Prashant Nair.</p>
                                        <div class="comment-footer">
                                            <span class="text-muted pull-right">May 11, 2020</span>
                                           
                                            <span class="badge badge-pill badge-success">Approved</span>
                                            <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- Comment Row -->
                                <!-- <div class="d-flex no-block comment-row border-top">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/4.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text active w-100">
                                        <h5 class="font-medium">Genelia D'souza</h5>
                                        <p class="m-b-10 text-muted">I THINK THIS IS THE BEST PLACE TO EAT GOOD QUALITY AND VERY HYGIENIC FOOD AT REASONABLE PRICE. MUST TRY GHEE RAWA DOSA. QUANTITY IS MORE THAN SUFFICIENT. KEEP IT UP..</p>
                                        <div class="comment-footer">
                                            <span class="text-muted pull-right">May 11, 2020</span>
                                            <span class="badge badge-pill badge-success">Approved</span>
                                            <span class="action-icons active">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                                </span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h5 class="card-title">{{__('Orders Overview')}}</h5>
                                        <!-- <h6 class="card-subtitle">Check the monthly sales </h6> -->
                                    </div>
                                    <!-- <div class="ml-auto">
                                        <select class="custom-select b-0">
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5"  selected="">May</option>
                                            <option value="6">June</option>
                                        </select>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row">
                                    <div class="col-6">
                                        <h3>{{date('d-F-Y')}}</h3>
                                        <h5 class="font-light m-t-0">{{__('Current 10 order details')}}</h5></div>
                                    <div class="col-6 align-self-center display-6 text-right">
                                        <h2 class="text-success">{{$currency->symbol}}<span id="lastTenAmt">57,690</span></h2></div>
                                        <!-- <h3 class="text-success">Tax- {{$currency->symbol}} 5,690</h3></div> -->
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>{{__('NAME')}}</th>
                                            <th>{{__('STATUS')}}</th>
                                            <th>{{__('DATE')}}</th>
                                            <th>{{__('AMOUNT')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; $lastTenAmt = 0;?>
                                    @if(count($lastTenOrder) > 0)
                                  
                                    @foreach($lastTenOrder as $val)
                                        <tr>
                                            <td class="text-center">{{$i}}</td>
                                            <td class="txt-oflo">{{$val->name}}</td>
                                            <td><span class="">{{$val->status}}</span></td>
                                            <td class="txt-oflo">{{date("d-m-Y", strtotime($val->created_at))}}</td>
                                            <td><span class="text-success">{{$currency->symbol }}{{$val->total}}</span></td>
                                        </tr>
                                        <?php $i++; $lastTenAmt += $val->total; ?>
                                      @endforeach

                                      @else
                                      <tr>
                                      <td>{{__('No Record')}}</td>
                                      </tr>
                                      @endif  
                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <!-- Column -->
<!--                     <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex m-b-40 align-items-center no-block">
                                    <h5 class="card-title ">SALES DIFFERENCE</h5>
                                    <div class="ml-auto">
                                        <ul class="list-inline font-12">
                                            <li><i class="fa fa-circle text-cyan"></i> SITE A</li>
                                            <li><i class="fa fa-circle text-primary"></i> SITE B</li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="morris-area-chart2" style="height: 340px;"></div>
                            </div>
                        </div>
                    </div> -->
                   
                    <!-- <div class="col-lg-4 col-md-12">
                        <div class="row">
                           
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">SALES DIFFERENCE</h5>
                                        <div class="row">
                                            <div class="col-6  m-t-30">
                                                <h1 class="text-info">$647</h1>
                                                <p class="text-muted">APRIL 2017</p>
                                                <b>(150 Sales)</b> </div>
                                            <div class="col-6">
                                                <div id="sparkline2dash" class="text-right"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-12">
                                <div class="card bg-purple text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">VISIT STATASTICS</h5>
                                        <div class="row">
                                            <div class="col-6  m-t-30">
                                                <h1 class="text-white">$347</h1>
                                                <p class="light_op_text">APRIL 2017</p>
                                                <b class="text-white">(150 Sales)</b> </div>
                                            <div class="col-6">
                                                <div id="sales1" class="text-right"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div> -->
                </div>
            </div>
<!--  <div class="card-body">
                            <p class="text-muted"><b align-items-center><h3><i class="icon-doc"></i>  Taxes</h3></b></p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-flex no-block align-items-center">
                                        <div>
                                            <h3> GST</h3>
                                            <p class="text-muted"></p>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="form-group" style="margin-left:12px;">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1" checked="">
                                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                                </div>
                                            </div>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="{!!URL::to('/') . '/public/js/add-download-btn.js' !!}"></script>
 <script>
    var text = "{{__('DOWNLOAD')}}";
    var className = "btn btn-primary qr_button";

    $(".qrImage").each(function(){
      $(this).addDownloadBtn(text, className)
      $('.qr_button').css('top','184px');
      $('.qr_button').css('bottom','-17px');
      $('.qr_button').css('margin-right','38px');
    });
</script>


<script>

$(document).ready(function(){

     var lastTenAmt = '<?php echo $lastTenAmt ?>';
     $('#lastTenAmt').text(lastTenAmt);


    $('#switch1').click(function() {

        var val =$(this).attr('data-attr');
        var text = 'Are you sure want to disable?';
        if(val == '1'){
            text = 'Are you sure want to enable?';
        }
        var r = confirm(text);
        if (r == true) {
            $.ajax({
                type: "GET",
                url: "{{url('/take-away-action')}}",
                data: 'action=' + val,
                success: function(data) {
                    //console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        }
  });



  $('#switch2').click(function() {

var val =$(this).attr('data-attr');
var text = 'Are you sure want to disable?';
if(val == '1'){
    text = 'Are you sure want to enable?';
}
var r = confirm(text);
if (r == true) {
    $.ajax({
        type: "GET",
        url: "{{url('/delivery-action')}}",
        data: 'action=' + val,
        success: function(data) {
            //console.log(data);
            if (data.status == 'success') {
                location.reload();
            }
        }
    });
}
});



$('#switch5').click(function() {

var val =$(this).attr('data-attr');
var text = 'Are you sure want to disable?';
if(val == '1'){
    text = 'Are you sure want to enable?';
}
var r = confirm(text);
if (r == true) {
    $.ajax({
        type: "GET",
        url: "{{url('/orderAccepting-action')}}",
        data: 'action=' + val,
        success: function(data) {
            //console.log(data);
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


<!-- top: 184px;
    bottom: -17px;
    margin-right: 38px; -->
