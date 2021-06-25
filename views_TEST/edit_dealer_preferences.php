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
		<h1>Digital Cables  - Edit Dealer Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li><a  href="#">Preferences</a></li>
			<li class="active">Edit Dealer Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($dealer as $key => $dealer_info ){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/update_dealer_prefer/<?php echo $dealer_info['id'];?>"> 
			<input type="hidden" name="dealer_prefer_id" id="dealer_prefer_id" value="<?php echo $dealer_info['id'];?>">
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Edit Dealer Preferences</h3>
					</div>
				<!-- /.box-header -->
					<div class="box-body">
						<div class="form-group">
							<label for="onetimechargetype" class="col-sm-4 control-label">One Time Charge Type Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="onetimechargetype" id="onetimechargetype" value="<?php echo $dealer_info['onetimechargetype'];?>" maxlength=30 required>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="dealercreate" name="dealercreate" class="btn btn-info pull-middle">Update</button>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Dealer Preferences List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>One Time Charge Type Name</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($dealerlist as $key => $dealer_data )
								{	
								?>
								<tr>
									<td><?=$dealer_data['id'];?></td>
									<td><?=$dealer_data['onetimechargetype'];?></td>
									<td><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>preferences/edit_dealer_prefer/<?php echo $dealer_data['id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>preferences/delete_dealer_prefer/<?php echo $dealer_data['id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
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
		</form>
		</div>
      <!-- /.row -->
    <!-- /.content -->
	</section>
</div>