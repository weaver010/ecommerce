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
              <form class="forms-sample" @if(empty($banner['_id'])) action="{{ url('admin/add-edit-banner') }}" @else action="{{ url('admin/add-edit-banner/'.$banner['_id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                  <div class="card-body">  
                    <div class="form-group">
                      <label for="link">Banner Type</label>
                      <select class="form-control" id="type" name="type" required="">
                        <option value="">Select</option>
                        <option @if(!empty($banner['type'])&& $banner['type']=="Slider") selected="" @endif value="Slider">Slider</option>
                        <option @if(!empty($banner['type'])&&$banner['type']=="Fix") selected @endif value="Fix">Fix</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="admin_image">Banner Image</label>
                      <input type="file" class="form-control" id="image" name="image">
                      @if(!empty($banner['image']))
                        <a target="_blank" href="{{ url('front/images/banners/'.$banner['image']) }}">View Image</a>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="link">Banner Link</label>
                      <input type="text" class="form-control" id="link" placeholder="Enter Banner Link" name="link" @if(!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="title">Banner Title</label>
                      <input type="text" class="form-control" id="title" placeholder="Enter Banner Title" name="title" @if(!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="alt">Banner Alternate Text</label>
                      <input type="text" class="form-control" id="alt" placeholder="Enter Banner Alternate Text" name="alt" @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="sort">Banner Sort</label>
                      <input type="number" class="form-control" id="sort" placeholder="Enter Banner Sort" name="sort" @if(!empty($banner['sort'])) value="{{ $banner['sort'] }}" @else value="{{ old('sort') }}" @endif>
                    </div>
                  </div>
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