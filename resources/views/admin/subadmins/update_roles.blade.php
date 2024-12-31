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
              <form name="subadminForm" id="subadminForm" action="{{ url('admin/update-role/'.$id) }}" method="post">@csrf
                <input type="hidden" name="subadmin_id" value="{{ $id }}">
                @if(!empty($subadminRoles))
                  @foreach($subadminRoles as $role)

                    @if($role['module']=="cms_pages")
                      @if($role['view_access']==1)
                        @php $viewCMSPages = "checked"; @endphp
                      @else
                        @php $viewCMSPages = ""; @endphp
                      @endif
                      @if($role['edit_access']==1)
                        @php $editCMSPages = "checked"; @endphp
                      @else
                        @php $editCMSPages = ""; @endphp
                      @endif
                      @if($role['full_access']==1)
                        @php $fullCMSPages = "checked"; @endphp
                      @else
                        @php $fullCMSPages = ""; @endphp
                      @endif
                    @endif

                    @if($role['module']=="categories")
                      @if($role['view_access']==1)
                        @php $viewCategories = "checked" @endphp
                      @else
                        @php $viewCategories = "" @endphp
                      @endif
                      @if($role['edit_access']==1)
                        @php $editCategories = "checked" @endphp
                      @else
                        @php $editCategories = "" @endphp
                      @endif
                      @if($role['full_access']==1)
                        @php $fullCategories = "checked" @endphp
                      @else
                        @php $fullCategories = "" @endphp
                      @endif
                    @endif

                    @if($role['module']=="brands")
                      @if($role['view_access']==1)
                        @php $viewBrands = "checked" @endphp
                      @else
                        @php $viewBrands = "" @endphp
                      @endif
                      @if($role['edit_access']==1)
                        @php $editBrands = "checked" @endphp
                      @else
                        @php $editBrands = "" @endphp
                      @endif
                      @if($role['full_access']==1)
                        @php $fullBrands = "checked" @endphp
                      @else
                        @php $fullBrands = "" @endphp
                      @endif
                    @endif

                    @if($role['module']=="products")
                      @if($role['view_access']==1)
                        @php $viewProducts = "checked" @endphp
                      @else
                        @php $viewProducts = "" @endphp
                      @endif
                      @if($role['edit_access']==1)
                        @php $editProducts = "checked" @endphp
                      @else
                        @php $editProducts = "" @endphp
                      @endif
                      @if($role['full_access']==1)
                        @php $fullProducts = "checked" @endphp
                      @else
                        @php $fullProducts = "" @endphp
                      @endif
                    @endif

                  @endforeach
                @endif  
                <div class="card-body">
                  <div class="form-group col-md-12">
                    <label for="title">CMS Pages: &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" name="cms_pages[view]" value="1" @if(isset($viewCMSPages)) {{ $viewCMSPages }} @endif> View Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="cms_pages[edit]" value="1" @if(isset($editCMSPages)) {{ $editCMSPages }} @endif> View/Edit Access &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="cms_pages[full]" value="1" @if(isset($fullCMSPages)) {{ $fullCMSPages }} @endif> Full Access
                  </div>
                  <div class="form-group col-md-12">
                    <label for="categories">Categories: &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" name="categories[view]" value="1" @if(isset($viewCategories)) {{ $viewCategories }} @endif>&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="categories[edit]" value="1" @if(isset($editCategories)) {{ $editCategories }} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="categories[full]" value="1" @if(isset($fullCategories)) {{ $fullCategories }} @endif>&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="form-group col-md-12">
                    <label for="brands">Brands: &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" name="brands[view]" value="1" @if(isset($viewBrands)) {{ $viewBrands }} @endif>&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="brands[edit]" value="1" @if(isset($editBrands)) {{ $editBrands }} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="brands[full]" value="1" @if(isset($fullBrands)) {{ $fullBrands }} @endif>&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                  </div>
                  <div class="form-group col-md-12">
                    <label for="products">Products: &nbsp;&nbsp;&nbsp;</label>
                    <input type="checkbox" name="products[view]" value="1" @if(isset($viewProducts)) {{ $viewProducts }} @endif>&nbsp;View Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="products[edit]" value="1" @if(isset($editProducts)) {{ $editProducts }} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="products[full]" value="1" @if(isset($fullProducts)) {{ $fullProducts }} @endif>&nbsp;Full Access &nbsp;&nbsp;&nbsp;&nbsp;
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="form-group col-md-6">
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