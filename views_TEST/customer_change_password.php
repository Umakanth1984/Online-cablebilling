<?php

 if($cust_id !=''){

 $custQry=mysql_query("select * from customers where cust_id='$cust_id'");
	$custRes=mysql_fetch_assoc($custQry);
   ?>
 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Change Password</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		  	<li class="active">Change Password</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($get_common as $key => $common_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>changepwd/change_password"> 
		<input type="hidden" id="cust_id" value="<?php echo $custRes['cust_id']; ?>" name="cust_id">
        <!-- left column -->
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Change Password</h3>
				</div>
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="old_password" class="col-sm-4 control-label">Old Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="old_password" value="" name="old_password" placeholder="Old Password" autofill="off" required> 
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="new_password" class="col-sm-4 control-label">New Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="new_password" value="" name="new_password" placeholder="New Password" required autofill="off">
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="reenter" class="col-sm-4 control-label">Re-enter New Password <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="password" class="form-control" id="reenter" name="reenter" placeholder="Re-enter New Password" autofill="off" required>
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
 <?php } // End of IF 
 ?>