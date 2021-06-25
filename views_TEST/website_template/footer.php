	<div id="toaster" style="position: fixed; top: 10px; right: 10px; width: 300px; z-index: 50000;" class="toaster">
	<?php $smsg = success_message(); ?>
	<?php if($smsg != ""){ ?>
		<div class="alert alert-success alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h4><i class="icon fa fa-check"></i> Success Message!</h4>
			<?php echo $smsg;?>
		</div>
	<?php } ?>
	<?php $emsg = error_message(); ?>
	<?php if($emsg != ""){ ?>
		<div class="alert alert-danger alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			<h4><i class="icon fa fa-ban"></i> Error Message!</h4>
			<?php echo $emsg;?>
		</div>
	<?php } ?>
	</div>
<footer class="main-footer">
	<div class="pull-right hidden-xs">
	    <b>Version</b> 2.2
    </div>      
	<strong>Copyright &copy; 2016-<?php echo date("Y");?><a href="#">Digital Cablebilling Solutions</a>.</strong> All rights reserved. 
</footer>
<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar --> 
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/jQuery/jquery-2.2.3.min.js">
</script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://themefiles.digitalrupay.com/theme/bootstrap/js/bootstrap.min.js"></script>
<script src="https://themefiles.digitalrupay.com/theme/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://themefiles.digitalrupay.com/theme/js/jquery.validate.js"></script>
<script src="https://themefiles.digitalrupay.com/theme/js/validations.js"></script>
<script>
$(function() {
	setTimeout(function(){
		$(".alert .close").trigger("click");
	}, 5000);
	$(".alert .close").unbind("click").bind("click", function(){
		$(this).parent(".alert").remove();
	});
});
</script>
<!-- DataTables -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/datatables/jquery.dataTables.min.js">
</script>
<script src="https://themefiles.digitalrupay.com/theme/plugins/datatables/dataTables.bootstrap.min.js">
</script>
<!-- SlimScroll -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/slimScroll/jquery.slimscroll.min.js">
</script>
<!-- FastClick -->
<script src="https://themefiles.digitalrupay.com/theme/plugins/fastclick/fastclick.js">
</script>
<!-- AdminLTE App -->
<script src="https://themefiles.digitalrupay.com/theme/dist/js/app.min.js">
</script>
<!-- AdminLTE for demo purposes -->
<script src="https://themefiles.digitalrupay.com/theme/dist/js/demo.js">
</script>
<!-- page script -->  
<script src="https://themefiles.digitalrupay.com/theme/js/jquery.multiselect.js">
</script>
<!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->  
<script>
$('#inputGroup').multiselect({
    columns: 1,
    placeholder: 'Select Groups'
  }
);
$(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true
    }
    );
  }
);
</script>
<script>
$(function() {
    $('.select2').select2();
});
</script>
</body>
</html>