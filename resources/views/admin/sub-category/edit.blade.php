@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Sub Category</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Edit Sub Category</li>
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
                <h3 class="box-title m-b-0">Edit Sub Category</h3>
                <br>
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <form method="post" action="{{route('sub-category.update',$sub_category->id)}}" enctype="multipart/form-data">
                            {{ method_field('put') }}
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Category<span class="color-required"></span></label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select</option>
                                    @foreach($categories as $val)
                                    <option value="{{$val->id}}" @if($sub_category->category_id==$val->id) selected
                                        @endif>{{$val->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Category Name</label>
                                <input type="text" name="sub_category_name" value="{{$sub_category->name}}" class="form-control"
                                    placeholder="Enter Sub Category Name" required>
                            </div>
                                                                  
                            <img src="{{asset('public/assets/images/sub-category-icon/'.$sub_category->icon)}}" width="50"
                                height="50">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Image</label>
                                <input type="file" class="form-control" name="logo" placeholder="">
                            </div>                         
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="enabled" class="custom-control-input"
                                        id="customSwitch1" {{$sub_category->enabled == 1 ? 'checked': ''}}>
                                    <label class="custom-control-label" for="customSwitch1">Enabled</label>
                                </div>

                                <button type="submit"
                                    class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                                    <a class="btn btn-secondary width-sm waves-effect waves-light" href="{{url('/sub-category')}}">Back</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>





</div>

<script>

</script>
<script>
// var limit = 10;
// var allready_upload = {
//     {
//         count($images)
//     }
// };
// $(document).ready(function() {
//     $('#images').change(function() {
//         var files = $(this)[0].files;
//         if (files.length + parseInt(allready_upload) > limit) {
//             alert("You can select max " + limit + " multiple images.");
//             $('#images').val('');
//             return false;
//         } else {
//             return true;
//         }
//     });
// });
</script>

@endsection
<!--User “brandstu_resto” was added to the database “brandstu_resturant”.-->