<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Import LCO Package Details</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Settings</a></li>
			<li class="active">Import LCO Package Details</li>
		</ol>
    </section>
	
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo '<div style="color:GREEN;font-size:20px;text-align:center">'.$msg.' Packages Uploaded.</div>';}?>
			<?php if(isset($error_data)){ echo '<div style="color:RED;font-size:20px;text-align:center">'.$error_data.'</div>';}?>
			<form id="importCustomerForm" name="importCustomerForm" class="form-horizontal" role="form" method="post" autocomplete="off" enctype="multipart/form-data" action="">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Import LCO Package Details</h3>
						</div>
						<table class="table table-bordered table-hover"><tr><th>LCO Reg Email - A</th><th>Package ID - B</th><th>Package Name - C</th><th>Customer Price - D</th><th>LCO Price - E</th><th>Tax (%) - F</th><th>Hidden (0-Yes,1-No) - G</th></tr></table>
						<div class="box-body">
							<div class="form-group">
								<label for="import_package" class="col-sm-4 control-label">Choose File</label>
								<div class="col-sm-6">
									<input type="file" class="form-control" id="import_package" name="import_package" value="" required accept=".csv">
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-footer" style="text-align:center;">
							<input type="submit" id="uploadPackage" name="uploadPackage" class="btn btn-info" value="Upload LCO Packages">
						</div>
					</div>
				</div>
			</form>
        </div>
    </section>
</div>