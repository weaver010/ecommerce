@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Users Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title">Users</h3><br>
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
                <table id="users" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Registered on</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                  <tr>
                    <td>@if(isset($user['name'])) {{ $user['name'] }} @endif</td>
                    <td>@if(isset($user['address'])) {{ $user['address'] }} @endif</td>
                    <td>@if(isset($user['city'])) {{ $user['city'] }} @endif</td>
                    <td>@if(isset($user['state'])) {{ $user['state'] }} @endif</td>
                    <td>@if(isset($user['country'])) {{ $user['country'] }} @endif</td>
                    <td>@if(isset($user['pincode'])) {{ $user['pincode'] }} @endif</td>
                    <td>@if(isset($user['mobile'])) {{ $user['mobile'] }} @endif</td>
                    <td>@if(isset($user['email'])) {{ $user['email'] }} @endif</td>
                    <td>{{ date("F j, Y, g:i a", strtotime($user['created_at'])); }}</td>
                    <td>
                      @if($usersModule['edit_access']==1 || $usersModule['full_access']==1)
                      @if($user['status']==1)
                          <a class="updateUserStatus" id="user-{{ $user['_id'] }}" user_id="{{ $user['_id'] }}" style='color:#3f6ed3' href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                        @else
                          <a class="updateUserStatus" id="user-{{ $user['_id'] }}" user_id="{{ $user['_id'] }}" style="color:grey" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
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