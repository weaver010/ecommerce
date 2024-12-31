@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Orders Management</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
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
                <h3 class="card-title">Orders</h3><br>
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
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Ordered Products</th>
                    <th>Order Amount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $order)
                      <tr>
                        <td>{{ $order['_id'] }}</td>
                        <td>{{  date('d-m-Y', strtotime($order['created_at'])) }}</td>
                        <td>{{ $order['name'] }}</td>
                        <td>{{ $order['email'] }}</td>
                        <td>
                          @foreach($order['orders_products'] as $pro)
                            {{ $pro['product_code'] }} ({{ $pro['product_qty'] }})<br>
                          @endforeach
                        </td>
                        <td>{{ $order['grand_total'] }}</td>
                        <td>{{ $order['order_status'] }}</td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>
                      <a title="View Order Details" style='color:#3f6ed3;' href="{{ url('admin/orders/'.$order['_id']) }}"><i class="fas fa-file"></i></a>
                      &nbsp;&nbsp;
                      <a title="Print Order Invoice" target="_blank" href="{{ url('admin/view-order-invoice/'.$order['_id']) }}"><i class="fas fa-print"></i></a>
                      &nbsp;&nbsp;
                      <a title="Print PDF Order Invoice" target="_blank" href="{{ url('admin/print-pdf-invoice/'.$order['_id']) }}"><i class="fas fa-file-pdf"></i></a>
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
