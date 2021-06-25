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
		<h1>Digital Cables  - NodePoint Categories Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li><a  href="#">Preferences</a></li>
			<li class="active">Edit NodePoint Categories Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php foreach($editeednodepointlist as $key => $edit_data){}?>
			<?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/edit_node_prefer/<?php echo $edit_data['id']?>"> 
        <!-- left column -->
			<input type="hidden" name="id" id="id" value="<?php echo $edit_data['id']?>">
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Edit NodePoint Categories</h3>
					</div>
				<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label for="category" class="col-sm-4 control-label">Category</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="category" id="category" placeholder="Category" value="<?php echo $edit_data['category'];?>" maxlength=30 required>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="save" name="save" class="btn btn-info">Update</button>
					</div>
				</div>
			</div>
		</form>

			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">NodePoint Preferences List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Category</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($nodepointlist as $key => $edit_node_prefer )
								{	
								?>
								<tr>
									<td><?=$edit_node_prefer['id'];?></td>
									<td><?=$edit_node_prefer['category'];?></td>
									<td><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>preferences/edit_node_prefer/<?php echo $edit_node_prefer['id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>preferences/delete_node_prefer/<?php echo $edit_node_prefer['id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
									</td>
								</tr>
								<?php  
								} 
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>