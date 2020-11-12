@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Items</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Items</li>
                </ol>
               
             <a href="{{url('item/create')}}" class="btn btn-info d-none d-lg-block m-l-15" ><i class="fa fa-plus-circle"></i>Add New</a> 
            </div>
        </div>
    </div>
    
    <?php
                      if(isset($_GET['search'])){
                            $item =$_GET['item_name'];
                          }else{
                           $item ="";                
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
                                <label for="name">Item name<span class="color-required">*</span></label>
                                <input value="" type="text" class="form-control" id="" name="item_name"
                                    placeholder="search here..." required>
                            </div>
                        </div>
                        <div class="col-md-1">                
                        <button type="submit" style="margin-top:30px;" class="btn btn-primary width-sm waves-effect waves-light">Search</button>                   
                        </div>
                                              
                       <a href="{{url('/item')}}" style="margin-top:34px; margin-left:10px;" ><i class="fa fa-refresh" aria-hidden="true"></i></a>                 
                       
                    </div>
                   
                </form>
                    <h4 class="card-title">Item Table </h4>
                    @if($_GET && isset($_GET['search']))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>                              
                                    <th>Item Price</th>
                                    <th>Short Description</th>  
                                    <th>Item Type</th> 
                                    <th>Image</th> 
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
                            @if(count($items) > 0)
                            @foreach($items as $val)
                                <tr>
                                  <td>{{$i}}</td>
                                  <td>{{$val->item_name}}</td>
                                
                                  <td>{{$val->item_price}}</td>
                                  <td>{{$val->short_description}}</td>
                                  <td>{{$val->item_type}}</td>
                                  <td><img src="{{asset('public/assets/images/item-images/'.$val->image)}}" width="50" height="50"></td>
                                  <td class="">
                                    <!-- @if($val->enabled == 1) Yes @else No @endif -->
                                    <div class="form-group" style="margin-left:12px;">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="enabled" class="custom-control-input change_status" data-id="{{$val->id}}" id="customSwitch{{$val->id}}"
                                                {{$val->enabled == 1 ? 'checked': ''}}>
                                            <label class="custom-control-label" for="customSwitch{{$val->id}}"></label>
                                        </div>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="btn-group">
                                      <a href="{{url('/item/'.$val->id.'/edit')}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                    </div>
                                  </td>
                                </tr>
                                <?php $i++ ?>
                              @endforeach
                              
                              @else
                           <tr>
                                    <td colspan="4"><h3>No data found</h3></td>
                           </tr>    
                           @endif
                              
                            </tbody>
                        </table>
                        {{$items->appends(['search'=>'search','item_name'=>$item])->links()}}
                      </div>


                    @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>                              
                                    <th>Item Price</th>
                                    <th>Short Description</th>  
                                    <th>Item Type</th> 
                                    <th>Image</th> 
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
                            @foreach($items as $val)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$val->item_name}}</td>
                                  
                                    <td>{{$val->item_price}}</td>
                                    <td>{{$val->short_description}}</td>
                                    <td>{{$val->item_type}}</td>
                                    <td><img src="{{asset('public/assets/images/item-images/'.$val->image)}}" width="50" height="50"></td>
                                    <td class="">
                                      <!-- @if($val->enabled == 1) Yes @else No @endif -->
                                      <div class="form-group" style="margin-left:12px;">
                                          <div class="custom-control custom-switch">
                                              <input type="checkbox" name="enabled" class="custom-control-input change_status" data-id="{{$val->id}}" id="customSwitch{{$val->id}}"
                                                  {{$val->enabled == 1 ? 'checked': ''}}>
                                              <label class="custom-control-label" for="customSwitch{{$val->id}}"></label>
                                          </div>
                                      </div>
                                    </td>
                                    <td>
                                      <div class="btn-group">
                                        <a href="{{url('/item/'.$val->id.'/edit')}}" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit </a>
                                      </div>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                              @endforeach
                                                      
                            </tbody>
                        </table>
                        {{$items->links()}}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){


    $('.change_status').on('change',function(){
        var change_status=$(this).is(':checked');
        change_status = change_status?1:0;
        var item_id=$(this).data('id');
        var send_data=new FormData();
        send_data.append('item_id',item_id);
        send_data.append('status',change_status);
        send_data.append('fn_action','status_change');
        if(item_id!='')
        {
            $.ajax({
                 headers: {
                  'X-CSRF-TOKEN': $('input[name=_token]').val()
                   },
                type: "POST",
                url: "{{url('/itemstatus')}}",           
                data:send_data,
                async: false,
                dataType: 'json',
                success: function(result){
                    if(result.status == 'success'){
                    }
                    else{
                    }
                },
                cache: false,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false
            });            
        }
    });


});
    

</script>

@endsection