<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Import Customer Details</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Import Customer Details</li>
		</ol>
    </section>
	
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo '<div style="color:GREEN;font-size:20px;text-align:center">'.$msg.' Customers Uploaded.</div>';}?>
			<?php if(isset($error_data)){ echo '<div style="color:RED;font-size:20px;text-align:center">'.$error_data.'</div>';}?>
			<form id="importCustomerForm" name="importCustomerForm" class="form-horizontal" role="form" method="post" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url()?>import/import_save">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Import Customer Details</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="import_customer" class="col-sm-4 control-label">Choose File</label>
								<div class="col-sm-6">
									<input type="file" class="form-control" id="import_customer" name="import_customer" value="" required>
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								 <label for="import_customer" class="col-sm-4 control-label">&nbsp;</label>
								<div class="col-sm-6 pull-left">
									<b>Note</b> : <a  href="<?php echo base_url()?>images/sample-data-csv.csv">Click Here</a> to Download Import customer file Format
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-footer" style="text-align:center;">
							<button type="submit" id="commonupdate" name="commonupdate" class="btn btn-info">Upload Customer Data</button>
						</div>
					</div>
				</div>
			</form>
        </div>
    </section>
</div>