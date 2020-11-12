@extends('admin.admin-layouts.app')
@section('content')


<div class="container-fluid">

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Admin</h4>
        </div>
    </div>
    
    <?php ?>

    <div class="row">
        <div class="col-12">
            @include('admin.admin-layouts.flash-message')
            <div class="card card-body">
                You don't have permission to this feature.            
            </div>
        </div>

    </div>
</div>


@endsection