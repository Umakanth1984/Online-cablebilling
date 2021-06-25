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
		<h1>Digital Cables - Credentials</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">LCO</a></li>
			<li class="active">Credentials</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php
			if(isset($_REQUEST['type']) && $_REQUEST['type']!='')
			{
				if($_REQUEST['type']==1){ $color='GREEN';}else{ $color='RED';}
				echo '<div style="color:'.$color.';font-size:20px;text-align:center">'.$_REQUEST['msg'].'</div>';
			}
			?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action=""> 
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo $page_type;?> Credential</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="user_name" class="col-sm-4 control-label">User Name</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Enter User Name" required value="<?php echo $data['user_name'];?>">
							</div>
							<div class="col-sm-2"></div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-4 control-label">Password</label>
							<div class="col-sm-6">
								<input class="form-control" type="text" id="password" name="password" placeholder="Enter Password" required value="<?php echo $data['password'];?>">
							</div>
							<div class="col-sm-2"></div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
					<?php
						if($page_type=='Edit')
						{
					?>
						<input type="hidden" name="crd_id" id="crd_id" value="<?php echo $data['crd_id'];?>">
					<?php
						}
					?>
						<input type="submit" id="submit" name="submit" class="btn btn-info" value="Save">
					</div>
				</div>
			</div>
		</form>
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Credentials List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Username</th>
									<th>Password</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
								foreach($credentials as $key => $credentialInfo )
								{	
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $credentialInfo['user_name'];?></td>
									<td><?php echo $credentialInfo['password'];?></td>
									<td><a title="Edit Credential" href="<?php echo base_url()?>user/edit_credential/<?php echo $credentialInfo['crd_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									<!--&nbsp;<a title="Delete Credential" href="<?php echo base_url()?>user/delete_credential/<?php echo $credentialInfo['crd_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>-->
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
		</div>
    </section>
</div>