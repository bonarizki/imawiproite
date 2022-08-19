<!-- jQuery -->
<script src="{{ asset('assets_admin_lte/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets_admin_lte/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{ asset('assets_admin_lte/assets/dist/js/sweetalert2.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets_admin_lte/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets_admin_lte/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('assets_admin_lte/assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('assets_admin_lte/assets/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('assets_admin_lte/assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('assets_admin_lte/assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('assets_admin_lte/assets/plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('assets_admin_lte/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets_admin_lte/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('assets_admin_lte/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('assets_admin_lte/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('assets_admin_lte/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets_admin_lte/assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{asset('assets_admin_lte/assets/dist/js/pages/dashboard.js')}}"></script> --}}
<!-- AdminLTE for demo purposes -->
<script src="{{asset('assets_admin_lte/assets/dist/js/demo.js')}}"></script>

<!-- DataTables -->
<script src="{{asset('assets_admin_lte/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets_admin_lte/assets/plugins/select2/js/select2.full.min.js')}}"></script>

<script src="{{asset('assets_admin_lte/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

<script src="{{asset('assets_admin_lte/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets_admin_lte/assets/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>

<script src="{{asset('js/time.js')}}"></script>


<script>
  $(document).ready(function () {
      $('.select2bs4').select2({
          theme: 'bootstrap4'
      })

      $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
      });
  });

</script>



