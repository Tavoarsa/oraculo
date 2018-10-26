 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b></b> 
    </div>
    <strong> Tavoarsa 89&copy; <?php echo date('Y'); ?></strong> 
  </footer>

 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>_template/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>_template/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>_template/plugins/select2/select2.full.min.js"></script>
    
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>_template/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>_template/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>_template/plugins/slimScroll/jquery.slimscroll.min.js"></script>
     <script src="<?php echo base_url(); ?>_template/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>_template/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>_template/dist/js/app.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>_template/dist/js/demo.js"></script>
  
  <script src="<?php echo base_url(); ?>_template/js/bootstrap-datepicker.js" type="text/javascript"></script>
    
  <script type="text/javascript" src="<?php echo base_url(); ?>_template/js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
    
    
    
    
    
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });

      
    </script>
</body>
</html>
