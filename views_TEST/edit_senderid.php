<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete Sender ID ?")
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
		<h1>Digital Cables  - Sender ID</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Sender ID</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; }
					foreach($get_senderid_by_id as $key => $edit_senderid_data ){}
			?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>senderid/update_senderid/<?php echo $edit_senderid_data['sender_id'];?>"> 
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Edit Sender ID</h3>
					</div>
				<!-- /.box-header -->
				<!-- form start -->
				
					<div class="box-body">
						<div class="form-group">
							<label for="sender_name" class="col-sm-4 control-label">Sender ID Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="sender_name" id="sender_name" value="<?php echo $edit_senderid_data['sender_name'];?>" placeholder="Enter Sender ID Name" required maxlength="6" minlength="6" style="text-transform:uppercase;">
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="save" name="save" class="btn btn-info">Update</button>
					</div>
				</div>
			</div>
		
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Sender ID List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Sender ID Name</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($get_senderid as $key => $senderid_data )
								{	
								?>
								<tr>
									<td><?=$senderid_data['sender_id'];?></td>
									<td><?=$senderid_data['sender_name'];?></td>
									<td><a  data-toggle="tooltip" data-placement="bottom"  title="Edit Sender ID" href="<?php echo base_url()?>senderid/edit_senderid/<?php echo $senderid_data['sender_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a  data-toggle="tooltip" data-placement="bottom"  title="Delete Sender ID" href="<?php echo base_url()?>senderid/delete_senderid/<?php echo $senderid_data['sender_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
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

		<!--	row end	-->
    </section>
    <!-- /.content -->
</div>