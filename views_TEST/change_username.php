<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Change Username</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Change Username</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($get_common as $key => $common_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>settings/change_username"> 
        <!-- left column -->
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Change Username</h3>
				</div>
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="user_name" class="col-sm-4 control-label">User Name <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="user_name" value="<?=$common_data['user_name'];?>" name="user_name" placeholder="User Name" required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="new_user_name" class="col-sm-4 control-label">New User Name <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="new_user_name" name="new_user_name" placeholder="New User Name" required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="reenter_username" class="col-sm-4 control-label">Re-enter New User Name <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="reenter_username" name="reenter" placeholder="Re-enter New Username" required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
				</div>
				<div class="box-footer" style="text-align:center;">
					<button type="submit" id="businessupdate" name="businessupdate" class="btn btn-info">Update</button>
				</div>
			</div>
		</div>
		</form>
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>