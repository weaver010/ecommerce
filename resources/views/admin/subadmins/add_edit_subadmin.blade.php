@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
              </div>
              <!-- /.card-header -->
              @if(Session::has('error_message')) 
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 5px;">
                <strong>Error!</strong> {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 5px;">
                <strong>Success!</strong> {{ Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 5px;">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              @endif
              <!-- form start -->
              <form name="subadminForm" id="subadminForm" @if(empty($subadmindata['id'])) action="{{ url('admin/add-edit-subadmin') }}" @else action="{{ url('admin/add-edit-subadmin/'.$subadmindata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group col-md-6">
                    <label for="title">Subadmin Name*</label>
                    <input type="text" class="form-control" name="subadmin_name" id="subadmin_name" placeholder="Enter Subadmin Name" @if(!empty($subadmindata['name'])) value="{{ $subadmindata['name'] }}" @else value="{{ old('subadmin_name') }}" @endif required="">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="mobile">Subadmin Mobile</label>
                    <input type="text" class="form-control" name="subadmin_mobile" id="subadmin_mobile" placeholder="Enter Subadmin Mobile" @if(!empty($subadmindata['mobile'])) value="{{ $subadmindata['mobile'] }}" @else value="{{ old('subadmin_mobile') }}" @endif required="">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="email">Subadmin Email</label>
                    <input @if($subadmindata['id']!="") disabled="" @else required="" @endif type="email" class="form-control" name="subadmin_email" id="subadmin_email" placeholder="Enter Subadmin Email" @if(!empty($subadmindata['email'])) value="{{ $subadmindata['email'] }}" @else value="{{ old('subadmin_email') }}" @endif>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="mobile">Subadmin Password</label>
                    <input type="password" class="form-control" name="subadmin_password" id="subadmin_password" placeholder="Enter Subadmin Password" @if($subadmindata['id']=="") required="" @endif>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="subadmin_image">Subadmin Image</label>
                    <input type="file" class="form-control" name="subadmin_image" id="subadmin_image" accept="image/*">
                    @if(!empty($subadmindata['image']))
                    <a target="_blank" href="{{ url('admin/images/photos/'.$subadmindata['image']) }}">View Image</a>
                    <input type="hidden" name="current_subadmin_image" value="{{ Auth::guard('admin')->user()->image }}">
                    @endif
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection