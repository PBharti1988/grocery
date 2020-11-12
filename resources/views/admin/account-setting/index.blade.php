@extends('admin.admin-layouts.app')
@section('content')



<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor"></h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">account setting</li>
                </ol>
               
             
            </div>
        </div>
    </div>
    

<!-- 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Item Table </h4>
          
                </div>
            </div>
        </div>

    </div> -->

    <div class="container-fluid">
    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Send Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="error"></span>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submit-notification" class="ladda-button btn btn-primary" data-style="expand-right">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-left">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/app-user')}}">account setting</a></li>
                        
                    </ol>
                </div>
                <h4 class="page-title"></h4>
            </div>
        </div>
    </div>
    @include('admin.admin-layouts.flash-message')
    @if(Session::has('successChangepassword'))
      <div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert">×</button>	
    <strong>{{ Session::get('successChangepassword') }}</strong>
  </div>
      @endif
       @if(Session::has('errorChangepassword'))
          <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>	
           <strong>{{ Session::get('errorChangepassword') }}</strong>
       </div>
         @endif
    
    <div class="row">
        <div class="col-lg-3 col-xl-3">
            <div class="card-box text-center" style="padding-left:0.5rem; padding-right:0.5rem">
            @if(!$user->logo)
                <img src="{{url('public/assets/images/logo-icon.png')}}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">
            @else
                <img src="{{url('public/assets/restaurant-logo/'.$user->logo)}}" style="width:115px;" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">
            @endif

                <h4 class="mb-0">{{$user->name}}</h4>
                <p class="text-muted">
                
                </p>

                <div class="nav nav-pills flex-column navtab-bg nav-pills-tab text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active show py-2" id="custom-v-pills-account-tab" data-toggle="pill" href="#custom-v-pills-account" role="tab" aria-controls="custom-v-pills-account"
                        aria-selected="false">
                        <i class="mdi mdi-seal d-block font-24"></i>
                        Account Overview</a>
                    <a class="nav-link mt-2 py-2" id="custom-v-pills-personal-tab" data-toggle="pill" href="#custom-v-pills-personal" role="tab" aria-controls="custom-v-pills-personal"
                        aria-selected="true">
                        <i class="mdi mdi-account-circle d-block font-24"></i>
                        Store Information
                    </a>
                    <a class="nav-link mt-2 py-2" id="custom-v-pills-changepassword-tab" data-toggle="pill" href="#custom-v-pills-changepassword" role="tab" aria-controls="custom-v-pills-changepassword"
                        aria-selected="false">
                        <i class="mdi mdi-key d-block font-24"></i>
                        Change Password</a>
                    <a class="nav-link mt-2 py-2" id="custom-v-pills-setting-tab" data-toggle="pill" href="#custom-v-pills-setting" role="tab" aria-controls="custom-v-pills-setting"
                        aria-selected="false">
                        <i class="mdi mdi-settings d-block font-24"></i>
                        Store Settings</a>
                    
                   
                   
                </div>  

            </div>

        </div>

        <div class="col-lg-9 col-xl-9">
            <div class="card-box">
                <div class="tab-content p-1">
                    <div class="tab-pane fade active show" id="custom-v-pills-account" role="tabpanel" aria-labelledby="custom-v-pills-account-tab">
                        <div>
                            <!--begin::Header-->
                            <div class="row mb-3" style="border-bottom: 1px dotted #ccc">
                                <div class="col" style="margin-bottom: 20px;">
                                    <h4 class="card-label font-weight-bolder text-dark">Account Overview</h4>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Store information</span>
                                </div>
                            </div>
                            <!--end::Header-->

                            <div class="text-left mt-3">
                                <p class="text-muted mb-2 font-13"><strong>Store Name :</strong> <span
                                        class="ml-2 ">{{$user->name}}</span></p>
                               
                                <p class="text-muted mb-2 font-13"><strong>Contact no:</strong> <span
                                        class="ml-2">{{$user->contact_number}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span
                                        class="ml-2">{{$user->email}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Manager name :</strong> <span
                                        class="ml-2">{{$user->manager_name}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Address:</strong> <span
                                        class="ml-2 ">{{$user->address}}</span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Active:</strong> <span
                                        class="ml-2 ">{{$user->is_verified ? 'Yes' : 'No' }}</span></p>

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-v-pills-personal" role="tabpanel" aria-labelledby="custom-v-pills-personal-tab">
                        <div>
                            <!-- <p class="sub-header color-required mb-3 text-align-right ">
                                Fields marked with * are mandatory
                            </p> -->
                            <form action="{{url('restaurant-update/'.$user->id) }}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                               
                                <span class="error"></span>
                                <!--begin::Header-->
                                <div class="row mb-3" style="border-bottom: 1px dotted #ccc">
                                    <div class="col-md-7" style="margin-bottom: 20px;">
                                        <h4 class="card-label font-weight-bolder text-dark">Store Information</h4>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">View store information</span>
                                    </div>
                                    <div class="col-md-5" style="margin-top: 10px;text-align:right">
                                        <button type="submit" class="btn btn-success mr-1"><i
                                            class="mdi mdi-content-save"></i> Save Changes</button>
                                        <a class="btn btn-secondary" href="{{url('/admin')}}"><i
                                            class="mdi mdi-window-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!--end::Header-->

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Logo</label>
                                    <div class="col-lg-9 col-xl-6">
                                    @if(!$user->logo)
                                        <img src="{{url('public/assets/images/logo-icon.png')}}" class="img-thumbnail avatar-xl" id="profile-image">
                                    @else
                                        <img src="{{url('public/assets/restaurant-logo/'.$user->logo)}}" style="width:120px;" class="img-thumbnail avatar-xl" id="profile-image">
                                    @endif
                                    <i onclick="openDialog()" style="font-size:24px" class="mdi mdi-pencil-circle"></i>
                                    @if($user->logo)
                                    <i onclick="removeImage()" style="font-size:24px" class="mdi mdi-delete-circle btn-delete-profile"></i>
                                    @else
                                    <i onclick="removeImage()" style="font-size:24px;display:none" class="mdi mdi-delete-circle btn-delete-profile"></i>
                                    @endif
                                    </div>
                                    <input type="hidden" name="hidden_profile" id="hidden_profile" value="1"/>
                                    <input style="display:none" type="file" name="image" id="profile_image_input" accept="image/*" onchange="loadProfileImage(event)">
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Store Name<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="name"
                                    value="{{$user->name}}"  placeholder="Enter Name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Contact number<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="contact_number"
                                    value="{{$user->contact_number}}"  placeholder="Enter contact number" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Email<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="email"
                                    value="{{$user->email}}"  placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Manager name<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="manager_name"
                                    value="{{$user->manager_name}}"  placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                    <div class="col-lg-9 col-xl-6">
                                    <textarea placeholder="Enter Address" class="form-control" name="address">{{$user->address}}</textarea>
                                    </div>
                                </div>
                            
                               
                
                                
                            </form>
                        </div>    
                    </div>
                    <div class="tab-pane fade" id="custom-v-pills-changepassword" role="tabpanel" aria-labelledby="custom-v-pills-changepassword-tab">
                        <div>
                            <!-- <p class="sub-header color-required mb-3 text-align-right ">
                                Fields marked with * are mandatory
                            </p> -->
                            <form action="{{url('/change-password-restaurant/'.$user->id) }}" method="post">
                                {{ csrf_field() }}
                               
                                <span class="error"></span>
                                <!--begin::Header-->
                                <div class="row mb-3" style="border-bottom: 1px dotted #ccc">
                                    <div class="col-md-7" style="margin-bottom: 20px;">
                                        <h4 class="card-label font-weight-bolder text-dark">Change Password</h4>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Change login password</span>
                                    </div>
                                    <div class="col-md-5" style="margin-top: 10px;text-align:right">
                                        <button type="submit" class="btn btn-success mr-1"><i
                                            class="mdi mdi-content-save"></i> Save Changes</button>
                                        <a class="btn btn-secondary" href="{{url('/admin')}}"><i
                                            class="mdi mdi-window-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!--end::Header-->
                                <div class="form-group col-md-6">
                                    <label>*New Password:</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password" required="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>*Confirm New Password:</label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm new password" required="">
                                </div>
                            </form>
                        </div> 
                    </div>
                    <div class="tab-pane fade" id="custom-v-pills-setting" role="tabpanel" aria-labelledby="custom-v-pills-setting-tab">
                        <div>
                            <!-- <p class="sub-header color-required mb-3 text-align-right ">
                                Fields marked with * are mandatory
                            </p> -->
                            <form action="{{url('restaurant-setting/'.$user->id) }}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                               
                                <span class="error"></span>
                                <!--begin::Header-->
                                <div class="row mb-3" style="border-bottom: 1px dotted #ccc">
                                    <div class="col-md-7" style="margin-bottom: 20px;">
                                        <h4 class="card-label font-weight-bolder text-dark">Store Settings</h4>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">Layout configuration</span>
                                    </div>
                                    <div class="col-md-5" style="margin-top: 10px;text-align:right">
                                        <button type="submit" class="btn btn-success mr-1"><i
                                            class="mdi mdi-content-save"></i> Save Changes</button>
                                        <a class="btn btn-secondary" href="{{url('/admin')}}"><i
                                            class="mdi mdi-window-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!--end::Header-->
	
	                            <div class="form-group">
	                                <label for="bgcolor">Background Color</label>&nbsp
	                                <input type="color" id="bgcolor" name="bg_color" value="{{$user->bg_color}}">
	                            </div>

	                            <div class="form-group">
	                                <label for="bgcolor1">Add to cart button background color</label>&nbsp
	                                <input type="color" id="bgcolor1" name="cb_color" value="{{$user->cb_color}}">
	                            </div>

	                            <div class="form-group">
	                                <label for="bgcolor2">Add to cart button text color</label>&nbsp
	                                <input type="color" id="bgcolor2" name="cbt_color" value="{{$user->cbt_color}}">
	                            </div>   
                                <div class="form-group">
                                    <label for="bgcolor2">Time Zone</label>&nbsp
                                    <select name="time_zone">
                                        <option value="">Select</option>
                                      <?php $time=timezone_identifiers_list(); 
                                          for($i=0;$i<=count($time)-1;$i++){
                                              ?>
                                           <option value="{{$time[$i]}}" @if($user->time_zone==$time[$i]) selected
                                        @endif>{{$time[$i]}}</option>
                                           <?php
                                            }
                                   ?>
                                  </select>
                                </div> 
                                
                                <div class="form-group" style="margin-left:12px;">
                               
                                <div class="custom-control custom-switch">
                                
                                    <input type="checkbox" name="enabled" class="custom-control-input" id="customSwitch1"
                                        {{$user->logo_enabled == 1 ? 'checked': ''}}>
                                        <label class="custom-control-label" for="customSwitch1">Logo Enabled</label>
                                </div>
                            </div>
                            </form>
                        </div>    
                    </div>
                 
     
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<script>
    function changeNotificationType(type){
        if(type == 'SMS'){
            $('#notifications-title-block').hide();
            $('#notifications-image-block').hide();
        }
        else{
            $('#notifications-title-block').show();
            $('#notifications-image-block').show();
        }
    }

    function openDialog(){
        $('#profile_image_input').click();
    }

    function openDialog2(){
        $('#id_image_input').click();
    }

    function removeImage(){
        var r = confirm("Are you sure want to delete?");
        if (r == true) {
            $('#profile-image').attr("src","{{url('public/assets/images/logo-icon.png')}}");
            $('#profile_image_input').val('');
            $('#hidden_profile').val('0');
            $('.btn-delete-profile').hide();
        }
    }

    function removeImage2(){
        var r = confirm("Are you sure want to delete?");
        if (r == true) {
            $('#id-file').attr("src","{{url('public/assets/images/logo-icon.png')}}");
            $('#id_image_input').val('');
            $('#hidden_id').val('0');
            $('#id-file').hide();
            $('.no-id-file').show();
            $('.no-id-file').text('No File Available');
            $('.btn-delete-id').hide();
        }
    }

    function loadProfileImage(event){
        var reader = new FileReader();
        reader.onload = function(){
            $('#profile-image').attr("src",reader.result);
        };
        $('.btn-delete-profile').show();
        reader.readAsDataURL(event.target.files[0]);
    }

    function loadIdImage(event){
        var reader = new FileReader();
        reader.onload = function(){
            $('#id-file').attr("src",reader.result);
        };
        $('.no-id-file').text(event.target.files[0].name);
        $('.btn-delete-id').show();
        reader.readAsDataURL(event.target.files[0]);
    }




$(document).ready(function(){

//     var hash = window.location.hash;

// if (location.hash) {
//     $('div.nav-pills-tab a[href="' + hash + '"]').tab('show');
// }

// $('.nav-pills-tab a').click(function (e) {
//     $(this).tab('show');
//     window.location.hash = this.hash;
// });

//     $(window).on("popstate", function(e) {
//         $('div.nav-pills-tab a[href="' + location.hash + '"]').tab('show');
//     });

    });
</script>

@endsection