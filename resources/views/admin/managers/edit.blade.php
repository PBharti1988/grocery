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
                    <li class="breadcrumb-item active">Manager</li>
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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/restaurant-manager')}}">Edit User</a></li>
                        
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
           
                <div class="nav nav-pills flex-column navtab-bg nav-pills-tab text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active show py-2" id="custom-v-pills-account-tab" data-toggle="pill" href="#custom-v-pills-account" role="tab" aria-controls="custom-v-pills-account"
                        aria-selected="false">
                        <i class="mdi mdi-card-account-details d-block font-24"></i>
                        User Overview</a>
                    <a class="nav-link mt-2 py-2" id="custom-v-pills-personal-tab" data-toggle="pill" href="#custom-v-pills-personal" role="tab" aria-controls="custom-v-pills-personal"
                        aria-selected="true">
                        <i class="mdi mdi-account-circle d-block font-24"></i>
                        User Information
                    </a>
                    <a class="nav-link mt-2 py-2" id="custom-v-pills-changepassword-tab" data-toggle="pill" href="#custom-v-pills-changepassword" role="tab" aria-controls="custom-v-pills-changepassword"
                        aria-selected="false">
                        <i class="mdi mdi-key d-block font-24"></i>
                        Change Password</a>
                    
                   
                   
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
                                    <h4 class="card-label font-weight-bolder text-dark">Restaurant User Overview</h4>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">Restaurant user information</span>
                                </div>
                            </div>
                            <!--end::Header-->

                            <div class="text-left mt-3">
                                <p class="text-muted mb-2 font-13"><strong>User Name :</strong> <span
                                        class="ml-2 ">{{$manager->name}}</span></p>
                               
                                <p class="text-muted mb-2 font-13"><strong>Mobile no:</strong> <span
                                        class="ml-2">{{$manager->mobile_no}}</span></p>

                                <p class="text-muted mb-2 font-13"><strong>Email:</strong> <span
                                        class="ml-2">{{$manager->email}}</span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Active:</strong> <span
                                        class="ml-2 ">{{$manager->user_type == 1 ? 'Manager' : 'User' }}</span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Active:</strong> <span
                                        class="ml-2 ">{{$manager->active ? 'Yes' : 'No' }}</span></p>

                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-v-pills-personal" role="tabpanel" aria-labelledby="custom-v-pills-personal-tab">
                        <div>
                            <!-- <p class="sub-header color-required mb-3 text-align-right ">
                                Fields marked with * are mandatory
                            </p> -->
                            <form action="{{url('restaurant-manager-update/'.$manager->id) }}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                               
                                <span class="error"></span>
                                <!--begin::Header-->
                                <div class="row mb-3" style="border-bottom: 1px dotted #ccc">
                                    <div class="col-md-7" style="margin-bottom: 20px;">
                                        <h4 class="card-label font-weight-bolder text-dark">Restaurant User Information</h4>
                                        <span class="text-muted font-weight-bold font-size-sm mt-1">View restaurant user information</span>
                                    </div>
                                    <div class="col-md-5" style="margin-top: 10px;text-align:right">
                                        <button type="submit" class="btn btn-success mr-1"><i
                                            class="mdi mdi-content-save"></i> Save Changes</button>
                                        <a class="btn btn-secondary" href="{{url('/restaurant-manager')}}"><i
                                            class="mdi mdi-window-close"></i> Cancel</a>
                                    </div>
                                </div>
                                <!--end::Header-->

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">name<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="name"
                                    value="{{$manager->name}}"  placeholder="Enter Name" required>
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Contact number<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="mobile_no"
                                    value="{{$manager->mobile_no}}"  placeholder="Enter mobile number" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Email<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" name="email"
                                    value="{{$manager->email}}"  placeholder="Enter Email" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">User Type<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <select class="form-control" name="user_type">
                                     <option value="1"<?php if($manager->user_type == 1) echo 'selected'; ?>>Manager</option>
                                     <option value="2"<?php if($manager->user_type == 2) echo 'selected'; ?>>User</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Active<span class="color-required">*</span></label>
                                    <div class="col-lg-9 col-xl-6">
                                    <select class="form-control" name="active">
                                     <option value="1"<?php if($manager->active == 1) echo 'selected'; ?>>Yes</option>
                                     <option value="0"<?php if($manager->active == 0) echo 'selected'; ?>>No</option>
                                    </select>
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
                            <form action="{{url('/change-password-manager/'.$manager->id) }}" method="post">
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



    });
</script>

@endsection