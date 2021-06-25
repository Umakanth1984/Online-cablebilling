<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
    return true;
  } else {
    return false;
  }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - MSO Preferences</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li><a href="#">Preferences</a></li>
			<li class="active">MSO Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/save_mso_prefer"> 
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">MSO Preferences</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="mso" class="col-sm-4 control-label">MSO Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="mso" id="mso" placeholder="Enter MSO Name" required>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="save" name="save" class="btn btn-info">Save</button>
					</div>
				</div>
			</div>
		
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">MSO List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>MSO Name</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
								foreach($emplist as $key => $mso_data )
								{	
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $mso_data['mso_name'];?></td>
									<td><a title="Edit MSO" href="<?php echo base_url()?>preferences/edit_mso_prefer/<?php echo $mso_data['mso_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a title="Delete MSO" href="<?php echo base_url()?>preferences/delete_mso_prefer/<?php echo $mso_data['mso_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
									</td>
								</tr>
								<?php 
								$i=$i+1;
								} 
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
		</div>
    </section>
    <!-- /.content -->
</div>