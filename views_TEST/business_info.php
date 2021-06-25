<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Business Information</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Business Information</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($business_information as $key => $common_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url()?>business/save_business"> 
        <!-- left column -->
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Business Information</h3>
				</div>
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="business_name" class="col-sm-4 control-label">Business Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="business_name" value="<?=$common_data['business_name'];?>" name="business_name" placeholder="Business Name" required maxlength=60>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="address1" class="col-sm-4 control-label">Address 1 <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="address1" value="<?=$common_data['address1'];?>" name="address1" placeholder="Address 1" required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="address2" class="col-sm-4 control-label">Address 2</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="address2" value="<?=$common_data['address2'];?>" name="address2" placeholder="Address 2">
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="address3" class="col-sm-4 control-label">Address 3</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="address3" value="<?=$common_data['address3'];?>" name="address3" placeholder="Address 3">
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="city" class="col-sm-4 control-label">City <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="city" value="<?=$common_data['city'];?>" name="city" placeholder="City" maxlength=30 required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="state" class="col-sm-4 control-label">State <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="state" value="<?=$common_data['state'];?>" name="state" placeholder="State" maxlength=30 required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="country" class="col-sm-4 control-label">Country <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="country" value="<?=$common_data['country'];?>" name="country" placeholder="Country" maxlength=30 required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="pincode" class="col-sm-4 control-label">Pincode <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="pincode" value="<?=$common_data['pincode'];?>" name="pincode" placeholder="Pincode" maxlength=6 required>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email Id <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="email" value="<?=$common_data['email'];?>" name="email" placeholder="Email Id" maxlength=40>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="mobile" class="col-sm-4 control-label">Mobile * <b style="color:red;">*</b></label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="mobile" required value="<?=$common_data['mobile'];?>" name="mobile" placeholder="Mobile Number" maxlength=13>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="service_tax_no" class="col-sm-4 control-label">GSTIN</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="service_tax_no" value="<?=$common_data['service_tax_no'];?>" name="service_tax_no" placeholder="GSTIN" maxlength=30>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="invoice_code" class="col-sm-4 control-label">Invoice Format Code</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="invoice_code" value="<?=$common_data['invoice_code'];?>" name="invoice_code" placeholder="Enter Invoice Format Code" maxlength=20>
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
					<div class="form-group">
						<label for="business_image" class="col-sm-4 control-label">Business Image</label>
						<div class="col-sm-6">
							<input type="file" class="form-control" id="business_image" name="business_image" value="<?php echo $common_data['business_image']; ?>"> 
							<img src="<?php echo base_url()?>images/<?php echo $common_data['business_image']; ?>" width="150" height="auto">
						</div>
						<div class="col-sm-offset-2">
						</div>
					</div>
				</div>
				<div class="box-footer" style="text-align:center;">
					<button type="submit" id="commonupdate" name="commonupdate" class="btn btn-info">Update</button>
				</div>
			</div>
		</div>
        </div>
		</form>
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>