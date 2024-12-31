@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pages Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">CMS Pages</li>
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
                <h3 class="card-title">CMS Pages</h3>
                @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                  <a style="max-width: 150px; float:right; display: inline-block;" href="{{url('admin/add-edit-cms-page')}}" class="btn btn-block btn-primary">Add CMS Page</a>
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
                <table id="cmspages" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Created on</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($cms_pages as $page)
                  <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->url }}</td>
                    <td>{{ $page->created_at }}</td>
                    <td>
                      @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                      <a title="Edit CMS Page" href="{{ url('admin/add-edit-cms-page/'.$page->_id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;
                      @endif
                      @if($pagesModule['full_access']==1)
                      <a class="confirmDelete" name="CMS Page" title="Delete CMS Page" href="javascript:void(0)" record="cms-page" recordid="{{ $page->id }}"><i class="fas fa-trash"></i></a>
                      &nbsp;&nbsp;
                      @endif
                      @if($pagesModule['edit_access']==1 || $pagesModule['full_access']==1)
                        @if($page->status==1)
                          <a class="updateCmsPageStatus" id="page-{{ $page->_id }}" page_id="{{ $page->_id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                        @else
                          <a class="updateCmsPageStatus" id="page-{{ $page->_id }}" page_id="{{ $page->_id }}" href="javascript:void(0)"><i style='color:grey' class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                        @endif
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