@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Categories Management</h1>
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
              <form name="categoryForm" id="categoryForm" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$category['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="category_name">Category Name*</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name" @if(!empty($category['category_name'])) value="{{ $category['category_name'] }}" @else value="{{ old('category_name') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="parent_id">Category Level*</label>
                    <select name="parent_id" class="form-control"> 
                        <option value="">Select</option>
                            <option value="0" @if( empty($category['parent_id'])) selected @endif>Main Category</option>
                            <?php foreach ($getCategories as $key => $cat) {?>
                                  <option value="{{$cat['_id']}}"@if(isset($category['parent_id']) && $category['parent_id'] ==$cat['_id']) selected @endif>&#9679;&nbsp;{{$cat['category_name']}}</option>
                                  <?php if(!empty($cat['subcategories'])){
                                      foreach ($cat['subcategories'] as $key => $subcat) { ?>
                                          <option value="{{$subcat['_id']}}"@if(isset($category['parent_id']) && $category['parent_id'] ==$subcat['_id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['category_name']}}</option>
                                          <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                          <option value="{{$subcat['_id']}}">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['category_name']}}</option>
                                      <?php } 
                                      }
                                  }
                              } ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label for="category_image">Category Image</label>
                    <input type="file" class="form-control" id="category_image" name="category_image">
                    @if(!empty($category['category_image']))
                        <div><img style="width:80px; margin-top: 5px;" src="{{ asset('front/images/categories/'.$category['category_image']) }}">
                        &nbsp;
                        <a class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{ $category['_id'] }}" <?php /* href="{{ url('admin/delete-category-image/'.$category['id']) }}" */ ?>>Delete Image</a>
                        </div>
                    @endif
                  </div>
                  <div class="form-group">
                      <label for="category_discount">Category Discount</label>
                      <input type="text" class="form-control" id="category_discount" placeholder="Enter Category Discount" name="category_discount" @if(!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @else value="{{ old('category_discount') }}" @endif>
                    </div>
                  <div class="form-group">
                    <label for="url">Category URL*</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Enter Category URL" @if(!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="description">Category Description*</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Enter Description">@if(!empty($category['description'])) {{ $category['description'] }} @else {{ old('description') }} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter Meta Title" @if(!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description" placeholder="Enter Meta Description" @if(!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter Meta Keywords" @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords'] }}" @endif>
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