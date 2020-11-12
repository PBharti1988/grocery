@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Category</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
               
             <a href="{{url('category/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>

                     <?php
                      if(isset($_GET['search'])){
                            $category =$_GET['category_name'];
                          }else{
                           $category ="";                
                         }
                         ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <form  method="get">
                    {{ csrf_field() }}
                    <div class="row">
                       <input type="hidden" name="search" value="search">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Category name<span class="color-required">*</span></label>
                                <input value="" type="text" class="form-control" id="" name="category_name"
                                    placeholder="search here..." required>
                            </div>
                        </div>
                        <div class="col-md-1">                
                        <button type="submit" style="margin-top:30px;" class="btn btn-primary width-sm waves-effect waves-light">Search</button>                   
                        </div>
                                              
                       <a href="{{url('/category')}}" style="margin-top:34px; margin-left:10px;" ><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                       
                    </div>
                   
                </form>
                    <h4 class="card-title">Category Table </h4>
                    @if($_GET && isset($_GET['search']))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Category Name</th>
                                    <th>Parent</td>
                                    <th>Icon</th>
                                    <th>Description.</th>
                                    <th>Sort Order</th>
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
                          @if(count($categories) > 0)
                            @foreach($categories as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->category_name}}</td>
                                    <td>{{getParent($val->parent_id)}}</td>
                                    <td><img src="{{asset('public/assets/images/category-icon/'.$val->icon)}}" width="50" height="50"></td>
                                    <td class="wrap">{{$val->description}}</td>
                                    <td class="wrap">{{$val->sort_order}}</td>
                                    <td class="">@if($val->enabled == 1) Yes @else No @endif</td>
                                    <td>
                                    <div class="btn-group">
                                        <a href="{{url('/category/'.$val->id.'/edit')}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                    </div>
                                </td>
                                                                                      
                                </tr>
                                <?php $i++;?>
                              @endforeach
                           @else
                           <tr>
                                    <td colspan="4"><h3>No data found</h3></td>
                           </tr>    
                           @endif
                              
                            </tbody>
                        </table>
                        {{$categories->appends(['search'=>'search','category_name'=>$category])->links()}}
                       
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                     <th>#</th>
                                    <th>Category Name</th>
                                    <th>Parent</td>
                                    <th>Icon</th>
                                    <th>Description.</th>
                                    <th>Sort Order</th>
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
                            @foreach($categories as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->category_name}}</td>
                                    <td>{{getParent($val->parent_id)}}</td>
                                    <td><img src="{{asset('public/assets/images/category-icon/'.$val->icon)}}" width="50" height="50"></td>
                                    <td class="wrap">{{$val->description}}</td>
                                    <td class="wrap">{{$val->sort_order}}</td>
                                    <td class="">@if($val->enabled == 1) Yes @else No @endif</td>
                                    <td>
                                    <div class="btn-group">
                                        <a href="{{url('/category/'.$val->id.'/edit')}}"
                                            class="btn btn-success btn-xs">
                                            <i class="fa fa-edit"></i> Edit </a>
                                    </div>
                                </td>
                                                                                      
                                </tr>
                                <?php $i++;?>
                              @endforeach
                          
                              
                            </tbody>
                        </table>
                        {{$categories->links()}}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>


@endsection