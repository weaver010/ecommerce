@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Coupons Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Coupons</li>
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
                <h3 class="card-title">Coupons</h3><br>
                @if($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                  <a style="max-width: 150px; float:right; display: inline-block;" href="{{ url('admin/add-edit-coupon') }}" class="btn btn-block btn-primary">Add Coupon</a><br>
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
                <table id="coupons" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Coupon Type</th>
                    <th>Amount</th>
                    <th>Expiry Date</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($coupons as $coupon)
                  <tr>
                    <td>{{ $coupon->coupon_code }}</td>
                    <td>{{ $coupon->coupon_type }}</td>
                    <td>
                      {{ $coupon->amount }}
                      @if($coupon->amount_type=="Percentage")
                        %
                      @else
                        INR
                      @endif
                    </td>
                    <td>{{ date("F j, Y, g:i a", strtotime($coupon->expiry_date)); }}</td>
                    <td>
                      @if($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                      @if($coupon['status']==1)
                          <a class="updateCouponStatus" id="coupon-{{ $coupon['_id'] }}" coupon_id="{{ $coupon['_id'] }}" style='color:#3f6ed3' href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                        @else
                          <a class="updateCouponStatus" id="coupon-{{ $coupon['_id'] }}" coupon_id="{{ $coupon['_id'] }}" style="color:grey" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                        @endif
                      @endif
                      @if($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                        &nbsp;&nbsp;
                        <a style='color:#3f6ed3;' href="{{ url('admin/add-edit-coupon/'.$coupon['_id']) }}"><i class="fas fa-edit"></i></a>
                        &nbsp;&nbsp;
                      @endif
                      @if($couponsModule['full_access']==1)
                        <a style='color:#3f6ed3;' class="confirmDelete" title="Delete Coupon" href="javascript:void(0)" record="coupon" recordid="{{ $coupon['_id'] }}"><i class="fas fa-trash"></i></a>
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