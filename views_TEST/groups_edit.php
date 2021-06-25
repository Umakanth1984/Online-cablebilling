<?php 
extract($emp_access);
if(($gropusA ==1) || ($gropusE ==1) || ($gropusV ==1) ||($gropusD ==1))
	{ 
?>
<style>
.btn-info {
    background-color: GREEN;
    border-color: #00acd6;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Groups</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Groups</a></li>
			<li class="active">Edit Group</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<?php
		if(($gropusE ==1))
		{
	?>
		<div class="row">
	    <?php if(isset($msg)){ echo $msg; }
		foreach($edit_group as $key => $groupedit ){}?>
			<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>groups/group_updated/<?php echo $groupedit['group_id']?>"> 
				<!-- left column -->
				<div class="col-md-10">
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Edit Group Details</h3>
					</div>
					  <div class="box-body">
						<div class="form-group col-md-6">
						  <label for="group_name" class="col-sm-4 control-label">Group Name *</label>
						  <div class="col-sm-8">
							<input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $groupedit['group_name']?>" placeholder="Custom Number" required>
						  </div>
						</div>
						<?php if($employee_info['user_type']==9){?>
							<div class="form-group col-md-5">
								<label for="lco_id" class="col-sm-4 control-label">Select LCO *</label>
								<div class="col-sm-8">
									<select class="form-control" id="lco_id" name="lco_id" required>
									<option value="">Select LCO</option>
									<?php
									foreach($lco_list as $key => $lco){
									?>
									<option value="<?php echo $lco['admin_id'];?>" <?php if($groupedit['admin_id']==$lco['admin_id']){ echo "selected";}?>><?php echo $lco['adminFname'];?></option>
									<?php }?>
								  </select>
								</div>
							</div>
						<?php } ?>
						 <div class="form-group col-md-1">
							<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info">Update</button>
						  </div>
						</div>
					  </div>
				  </div>
				</div>
			</form>
		</div>
	<?php
		}
	?>	  
    </section>
  </div>
<?php 
	}
	else
	{ 
		redirect('/');
	}
?>