@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Banners Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Banners</li>
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
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Banners</h3><br>
                @if($bannersModule['edit_access']==1 || $bannersModule['full_access']==1)
                  <a style="max-width: 150px; float:right; display: inline-block;" href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-primary">Add Banner</a><br>
                @endif
              </div>
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 5px;">
                <strong>Success!</strong> {{ Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <!-- /.card-header -->
              <div class="card-body">
                <table id="banners" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Link</th>
                    <th>Title</th>
                    <th>Alt</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td>
                            <a target="_blank" href="{{ url('front/images/banners/'.$banner['image']) }}"><img style="width:180px;" src="{{ asset('front/images/banners/'.$banner['image']) }}"></a>
                        </td>
                        <td>
                            {{ $banner['type'] }}
                        </td>
                        <td>
                            {{ $banner['link'] }}
                        </td>
                        <td>
                            {{ $banner['title'] }}
                        </td>
                        <td>
                            {{ $banner['alt'] }}
                        </td>
                        <td>
                           @if($bannersModule['edit_access']==1 || $bannersModule['full_access']==1)
                            @if($banner['status']==1)
                                <a class="updateBannerStatus" id="banner-{{ $banner['_id'] }}" banner_id="{{ $banner['_id'] }}" style='color:#3f6ed3' href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                              @else
                                <a class="updateBannerStatus" id="banner-{{ $banner['_id'] }}" banner_id="{{ $banner['_id'] }}" style="color:grey" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                              @endif
                          @endif
                          @if($bannersModule['edit_access']==1 || $bannersModule['full_access']==1)
                            &nbsp;&nbsp;
                            <a style='color:#3f6ed3;' href="{{ url('admin/add-edit-banner/'.$banner['_id']) }}"><i class="fas fa-edit"></i></a>
                            &nbsp;&nbsp;
                          @endif
                          @if($bannersModule['full_access']==1)
                            <a style='color:#3f6ed3;' class="confirmDelete" title="Delete Banner" href="javascript:void(0)" record="banner" recordid="{{ $banner['_id'] }}"><i class="fas fa-trash"></i></a>
                          @endif
                        </td>
                    </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection