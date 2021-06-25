<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Payment Gateway Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li><a  href="#">Preferences</a></li>
			<li class="active">Payment Gateway Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/save_payment_prefer"> 
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Payment Gateway</h3>
					</div>
				<!-- /.box-header -->
				<!-- form start -->
					<div class="box-body">
						<div class="form-group">
							<label for="accID" class="col-sm-4 control-label">Account Id</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="accID" id="accID" placeholder="Account Id" maxlength=30 required>
							</div>
						</div>
						<div class="form-group">
							<label for="secretkey" class="col-sm-4 control-label">Secret Key</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="secretkey" id="secretkey" placeholder="Secret Key" maxlength=30 required>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
						<button type="submit" id="paymentcreate" name="dealercreate" class="btn btn-info">Create</button>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Payment Preferences List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Account Id</th>
									<th>Secret Key</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($paymentlist as $key => $payment_data )
								{	
								?>
								<tr>
									<td><?=$payment_data['id'];?></td>
									<td><?=$payment_data['accID'];?></td>
									<td><?=$payment_data['secretkey'];?></td>
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
    </section>
    <!-- /.content -->
</div>