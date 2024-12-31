@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Products Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">Products</h3><br>
                @if($productsModule['edit_access']==1 || $productsModule['full_access']==1)
                  <a style="max-width: 150px; float:right; display: inline-block;" href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-primary">Add Product</a><br>
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
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Category</th>
                    <th>Parent Category</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                  <tr>
                    <td>{{ $product['product_name'] }}</td>
                    <td>{{ $product['product_code'] }}</td>
                    <td>{{ $product['product_color'] }}</td>
                    <td>{{ $product['category']['category_name'] }}</td>
                    <td>
                      @if(isset($product['category']['parentcategory']['category_name']))
                        {{ $product['category']['parentcategory']['category_name'] }}
                      @else
                        ROOT
                      @endif
                    </td>
                    <td>
                      @if($productsModule['edit_access']==1 || $productsModule['full_access']==1)
                        @if($product['status']==1)
                          <a class="updateProductStatus" id="product-{{ $product['_id'] }}" product_id="{{ $product['_id'] }}" style='color:#3f6ed3' href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                        @else
                          <a class="updateProductStatus" id="product-{{ $product['_id'] }}" product_id="{{ $product['_id'] }}" style="color:grey" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                        @endif
                      @endif
                      @if($productsModule['edit_access']==1 || $productsModule['full_access']==1)
                        &nbsp;&nbsp;
                        <a style='color:#3f6ed3;' href="{{ url('admin/add-edit-product/'.$product['_id']) }}"><i class="fas fa-edit"></i></a>
                        &nbsp;&nbsp;
                      @endif
                      @if($productsModule['full_access']==1)
                        <a style='color:#3f6ed3;' class="confirmDelete" title="Delete Product" href="javascript:void(0)" record="product" recordid="{{ $product['_id'] }}"><i class="fas fa-trash"></i></a> 
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