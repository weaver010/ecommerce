<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>AdminLTE 3 | Dashboard 3</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ url('admin/plugins/select2/css/select2.min.css') }}">
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  
  @include('admin.layout.header')

  @include('admin.layout.sidebar')

  @yield('content')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  @include('admin.layout.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('admin/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('admin/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admin/js/pages/dashboard3.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('admin/js/custom.js') }}"></script>
<!-- Select2 -->
<script src="{{ url('admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$('.select2').select2();
</script>
<!-- DataTables -->
<script src="{{ url('admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ url('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script>
  $(function () {
    $("#cmspages").DataTable({
      "aaSorting": []
    });
    $("#subadmins").DataTable({
      "aaSorting": []
    });
    $("#categories").DataTable({
      "aaSorting": [] 
    });
    $("#products").DataTable({
      "aaSorting": []
    });
    $("#brands").DataTable({
      "aaSorting": []
    });
    $("#banners").DataTable({
      "aaSorting": []
    });
    $("#coupons").DataTable({
      "aaSorting": []
    });
    $("#users").DataTable({
      /* Disable initial sort */
        "aaSorting": []
    });
    $("#orders").DataTable({
      /* Disable initial sort */
        "aaSorting": []
    });
    $("#shipping").DataTable({
      /* Disable initial sort */
        "aaSorting": []
    });
  });
</script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</body>
</html>
