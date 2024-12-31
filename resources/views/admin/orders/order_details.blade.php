<?php use App\Models\Product; ?>
@extends('admin.layout.layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Orders</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Order #{{ $orderDetails['_id'] }} Detail</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
    <section class="content">
      @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 5px;">
        <strong>Success!</strong> {{ Session::get('success_message')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Order Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>Order ID</td>
                      <td>{{ $orderDetails['_id'] }}</td>
                    </tr>
                    <tr>
                      <td>Order Status</td>
                      <td>{{ $orderDetails['order_status'] }}</td>
                    </tr>
                    <tr>
                      <td>Order Total</td>
                      <td>INR {{ $orderDetails['grand_total'] }}</td>
                    </tr>
                    <tr>
                      <td>Shipping Charges</td>
                      <td>INR {{ $orderDetails['shipping_charges'] }}</td>
                    </tr>
                    <tr>
                      <td>Coupon Code</td>
                      <td>{{ $orderDetails['coupon_code'] }}</td>
                    </tr>
                    <tr>
                      <td>Coupon Amount</td>
                      <td>{{ $orderDetails['coupon_amount'] }}</td>
                    </tr>
                    <tr>
                      <td>Payment Method</td>
                      <td>{{ $orderDetails['payment_method'] }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Details</h3>
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                   <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['user']['name'] }}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>{{ $orderDetails['user']['email'] }}</td>
                      </tr>
                    </table>
                  </tbody>
                </table>
              </div>
              </div>
              <!-- /.card-header -->
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Billing Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['user']['name'] }}</td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>{{ $orderDetails['user']['address'] }}</td>
                      </tr>
                      <tr>
                        <td>City</td>
                        <td>{{ $orderDetails['user']['city'] }}</td>
                      </tr>
                      <tr>
                        <td>State</td>
                        <td>{{ $orderDetails['user']['state'] }}</td>
                      </tr>
                      <tr>
                        <td>Country</td>
                        <td>{{ $orderDetails['user']['country'] }}</td>
                      </tr>
                      <tr>
                        <td>Pincode</td>
                        <td>{{ $orderDetails['user']['pincode'] }}</td>
                      </tr>
                      <tr>
                        <td>Mobile</td>
                        <td>{{ $orderDetails['user']['mobile'] }}</td>
                      </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Address</h3>
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                   <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails['name'] }}</td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td>{{ $orderDetails['address'] }}</td>
                      </tr>
                      <tr>
                        <td>City</td>
                        <td>{{ $orderDetails['city'] }}</td>
                      </tr>
                      <tr>
                        <td>State</td>
                        <td>{{ $orderDetails['state'] }}</td>
                      </tr>
                      <tr>
                        <td>Country</td>
                        <td>{{ $orderDetails['country'] }}</td>
                      </tr>
                      <tr>
                        <td>Pincode</td>
                        <td>{{ $orderDetails['pincode'] }}</td>
                      </tr>
                      <tr>
                        <td>Mobile</td>
                        <td>{{ $orderDetails['mobile'] }}</td>
                      </tr>
                    </table>
                  </tbody>
                </table>
              </div>
              <!-- /.card-header -->
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Order Status</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td colspan="2">
                        <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                          <input type="hidden" name="order_id" value="{{ $orderDetails['_id'] }}">
                          <select name="order_status" id="order_status" required="">
                          <option value="">Select</option>
                          @foreach($orderStatuses as $status)
                          <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                          @endforeach
                          </select>&nbsp;&nbsp;

                          <input style="width:120px;" type="text" id="courier_name" name="courier_name" placeholder="Courier Name">

                          <input style="width:120px;" type="text" id="tracking_number" name="tracking_number" placeholder="Tracking Number">

                          <button type="submit">Update</button>
                        </form>

                        <br>
                        @foreach($orderDetails['log'] as $log)
                            <strong> {{ $log['order_status'] }}</strong>

                              @if($log['order_status']=="Shipped")

                                @if(!empty($orderDetails['courier_name']))
                                  <br><span>Courier Name: {{ $orderDetails['courier_name'] }}</span>
                                @endif

                                @if(!empty($orderDetails['tracking_number']))
                                  <br><span>Tracking Number: {{ $orderDetails['tracking_number']}} </span>
                                @endif

                              @endif

                              <br>
                            {{  date('j F, Y, g:i a', strtotime($log['created_at'])) }}
                            <hr>
                        @endforeach
                      </td>     
                    </tr>
                  </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Ordered Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Product Image</th>
                      <th>Product Code</th>
                      <th>Product Name</th>
                      <th>Product Size</th>
                      <th>Product Color</th>
                      <th>Product Qty</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($orderDetails['orders_products'] as $product)
                    <tr>
                      <td>
                        <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                        <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width: 80px;" src="{{ asset('front/images/products/small/'.$getProductImage) }}"></a>
                      </td>
                      <td>{{ $product['product_code'] }}</td>
                      <td>{{ $product['product_name'] }}</td>
                      <td>{{ $product['product_size'] }}</td>
                      <td>{{ $product['product_color'] }}</td>
                      <td>{{ $product['product_qty'] }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection