<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
             
                        
                        <li> <a class="has-arrow waves-effect waves-dark module-list" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu">{{__('All List')}}</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('billbook')}}">{{__('Bill Book')}}</a></li>
                                <li><a href="{{url('category')}}">{{__('Categories')}}</a></li>
                                <li><a href="{{url('coupon')}}">{{__('Coupons')}}</a></li>
                                <li><a href="{{url('admin/feedback')}}">{{__('Feedbacks')}}</a></li>
                                <li><a href="{{url('banners')}}">{{__('Banners')}}</a></li>
                                <li><a href="{{url('shelves')}}">{{__('Shelves')}}</a></li>
                                <li><a href="{{url('floors')}}">{{__('Floors')}}</a></li>
                                <li><a href="{{url('shelf-offers')}}">{{__('Shelf Offers')}}</a></li>                                  
                                <li><a href="{{url('item')}}">{{__('Items')}}</a></li>
                                <li><a href="{{url('addon')}}">{{__('Item Addons')}}</a></li>
                                <!-- <li><a href="{{url('new-table-order')}}">New Table Orders</a></li> -->
                                <li><a href="{{url('timing')}}">{{__('Opening Hours')}}</a></li>
                                <li><a href="{{url('order')}}">{{__('Orders')}}</a></li>
                                <li><a href="{{url('payment-config')}}">{{__('Payment Configuration')}}</a></li>
                                <li><a href="{{url('sms-config')}}">{{__('SMS Configuration')}}</a></li>
                                <li><a href="{{url('sms-template')}}">{{__('SMS Template')}}</a></li>
                                <li><a href="{{url('storelocation')}}">{{__('Store City Areas')}}</a></li>
                                <li><a href="{{url('slider')}}">Slider Options</a></li>
                                <li><a href="{{url('language')}}">{{__('Language')}}</a></li>
                                <!-- <li><a href="{{url('card-details')}}">Card Details</a></li>
                                <li><a href="{{url('promotion')}}">Promotions</a></li> -->
                                <li><a href="{{url('table')}}">{{__('Table Master')}}</a></li>
                                <li><a href="{{url('table-order')}}">{{__('Table Orders')}}</a></li>
                                <li><a href="{{url('tax')}}">{{__('Taxes')}}</a></li>
                               
                            </ul>
                        </li>
                        @if(Auth::guard('restaurant')->id())
                        <li> <a class="has-arrow waves-effect waves-dark module-list" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">{{__('Users')}}</span></a>
                            <ul aria-expanded="false" class="collapse">
                            <li><a href="{{url('restaurant-manager')}}">{{__('All Users')}}</a></li>
                            </ul>        
                        </li>
                        @endif
                       
                        <li> <a class="has-arrow waves-effect waves-dark module-list" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-file"></i><span class="hide-menu">{{__('Reports')}}</span></a>
                            <ul aria-expanded="false" class="collapse">
                            <li><a href="{{url('order-reports')}}">{{__('Order Report')}}</a></li>
                            <li><a href="{{url('customer-reports')}}">{{__('Customer Report')}}</a></li>
                            <li><a href="{{url('payment-reports')}}">{{__('Payment Report')}}</a></li>
                            </ul>        
                        </li>
                        
                       
                        <li> <a class="has-arrow waves-effect waves-dark module-list" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-cogs"></i><span class="hide-menu">{{__('Settings')}}</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{url('question')}}">{{__('Feedback Questions')}}</a></li>
                                <li><a href="{{url('restaurant-seo')}}">{{__('SEO Details')}}</a></li>
                                @if(Auth::guard('restaurant')->id())
                                <li><a href="{{url('account-setting')}}">{{__('Account Setting')}}</a></li>
                                @endif
                            </ul>        
                        </li>
                     
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>