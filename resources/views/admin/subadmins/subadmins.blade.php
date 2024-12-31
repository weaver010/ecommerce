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
            <li class="breadcrumb-item active">Subadmins</li>
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
                <h3 class="card-title">Subadmins</h3>
                <a style="max-width: 150px; float:right; display: inline-block;" href="{{url('admin/add-edit-subadmin')}}" class="btn btn-block btn-primary">Add Sub Admin</a>
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
                <table id="subadmins" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                  <th>Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($subadmins as $subadmin)
                <tr>
                  <td>{{ $subadmin->name }}</td>
                  <td>{{ $subadmin->mobile }}</td>
                  <td>{{ $subadmin->email }}</td>
                  <td>{{ $subadmin->type }}</td>
                  <td>
                      @if($subadmin->status==1)
                        <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->_id }}" subadmin_id="{{ $subadmin->_id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                        <a class="updateSubadminStatus" id="subadmin-{{ $subadmin->_id }}" subadmin_id="{{ $subadmin->_id }}" href="javascript:void(0)"><i style='color:grey' class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                      &nbsp;&nbsp;
                      <a title="Edit Subadmin" href="{{ url('admin/add-edit-subadmin/'.$subadmin->id) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;
                      <a title="Set Permissions for Sub-admin" href="{{ url('admin/update-role/'.$subadmin->id) }}"><i class="fas fa-unlock"></i></a>
                      &nbsp;&nbsp;
                      <a class="confirmDelete" name="Subadmin" title="Delete Subadmin" href="javascript:void(0)" record="subadmin" recordid="{{ $subadmin->id }}"><i class="fas fa-trash"></i></a>
                    
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