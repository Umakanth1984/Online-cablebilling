<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Sender ID & Groups </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Groups</a></li>
			<li class="active">Sender ID & Groups</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>senderid/group_sender_ids_updated/"> 
			<!-- left column -->
				<div class="col-md-6">
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Add Sender ID & Groups Details</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body">
						<div class="form-group col-md-12">
							<label for="inputcustomername" class="col-sm-4 control-label">Group *</label>
							<div class="col-sm-8">
								<select class="form-control" id="group_id" name="group_id" required >
								<option value="">Select Group</option>
								<?php $sel_grp=mysql_query("select * from groups");
										while($row_grp=mysql_fetch_assoc($sel_grp)){
								?>
								<option value="<?php echo $row_grp['group_id']; ?>"><?php echo $row_grp['group_name']; ?></option>
								<?php }?>
							  </select>
							</div>
						</div>			  
						 <div class="form-group col-md-12">
							<label for="inputcustomername" class="col-sm-4 control-label">Sender ID *</label>
							<div class="col-sm-8">
								<select class="form-control" id="sender_id" name="sender_id" required>
								<option value="">Select Sender ID</option>
								<?php $sel_grp=mysql_query("select * from sender_ids");
										while($row_grp=mysql_fetch_assoc($sel_grp)){
								?>
								<option value="<?php echo $row_grp['sender_id']; ?>"><?php echo $row_grp['sender_name']; ?></option>
								<?php }?>
							  </select>
							</div>
						</div>	
						 <div class="form-group col-md-12">
						   <div class="box-footer">
								<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
						  </div>
						</div>
					  </div>
				  </div>
				</div>
        <!--/.col (left) -->
			</form>
			<div class="col-xs-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Groups & Sender ID List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					  <table id="example2" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Group Name</th>
								<th>Sender ID</th>
							</tr>
						</thead>
						<tbody>
					   <?php
						foreach($groups as $key => $group )
						{
							$chk_grp=mysql_fetch_assoc(mysql_query("SELECT * FROM groups WHERE group_id=".$group['group_id']));
							$chk_pkg=mysql_fetch_assoc(mysql_query("SELECT * FROM sender_ids WHERE sender_id=".$group['sender_id']));
						?>
							<tr>
								<td><?php echo $chk_grp['group_name'];?></td>
								<td><?php echo $chk_pkg['sender_name'];?></td>
							</tr>
						<?php } ?>
						</tbody>
					  </table>
					</div>
				<!-- /.box-body -->
				</div>
			  <!-- /.box -->
			</div>
		</div>
    </section>
    <!-- /.content -->
</div>