<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright © <?= date('Y') ?> <a href="<?= base_url('/admin') ?>">WIS Super Admin</a>,</strong>
    Inc All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<input type="hidden" id="BaseURL" value="<?= base_url() ?>" />
<!-- jQuery -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/moment/moment.min.js"></script>
<script src="<?= base_url() ?>/public/admin_assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Summernote -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url(); ?>/public/admin_assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Validation -->
<script src="<?= base_url() ?>/public/admin_assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<!-- Jquery Cookie -->
<script src="<?= base_url() ?>/public/admin_assets/jquery.cookie.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/public/admin_assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>/public/admin_assets/dist/js/demo.js"></script>
<script src="<?= base_url() ?>/public/admin_assets/plugins/multiselect/bootstrap-multiselect.js"></script>
<script>
  // for sidebar menu entirely but not cover treeview
  $('ul.nav-sidebar a').filter(function () {
    return this.id == $("#CurrentPage").val();
  }).addClass('active');

  // for treeview
  $('ul.nav-treeview a').filter(function () {
    return this.id == $("#CurrentPage").val();
  }).addClass('active').parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>

