@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard v3</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v3</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error:</strong> {{ Session::get('error_message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box" style="background-color:#343A40;">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tasks"></i></span>

            <a style="color: #fff;" href="{{ url('admin/categories') }}"><div class="info-box-content">
              <span class="info-box-text">Categories</span>
              <span class="info-box-number">
                {{$categoriesCount}}
                <!-- <small>%</small> -->
              </span>
            </a>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3" >
          <div class="info-box mb-3" style="background-color:#343A40;">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-th-list"></i></span>

            <a style="color: #fff;" href="{{ url('admin/brands') }}"><div class="info-box-content">
              <span class="info-box-text">Brands</span>
              <span class="info-box-number">{{$brandsCount}}</span>
            </div></a>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3" style="background-color:#343A40;">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tshirt"></i></span>

            <a style="color: #fff;" href="{{ url('admin/products') }}"><div class="info-box-content">
              <span class="info-box-text">Products</span>
              <span class="info-box-number">{{$productsCount}}</span>
            </div></a>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3" style="background-color:#343A40;">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <a style="color: #fff;" href="{{ url('admin/users') }}"><div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number">{{$usersCount}}</span>
            </div></a>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection