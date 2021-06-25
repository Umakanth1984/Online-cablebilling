<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if($packageV ==1)
	{ 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - View Package Details</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Packages</a></li>
			<li class="active">View Package</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	  <?php foreach($packages as $key => $packages ){}?>
        <!-- left column -->
		<div class="col-md-2"></div>
        <div class="col-md-8">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Package Details</h3>
				</div>
            <!-- /.box-header -->
				<div class="box-body form-horizontal">
					<div class="form-group">
					  <label for="inputpackagename" class="col-sm-2 control-label">Package Name</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackagename" value="<?php echo $packages['package_name'];?>" readonly name="inputpackagename">
					  </div>
					</div>
					<div class="form-group">
						<label for="inputpackagedesc" class="col-sm-2 control-label">Package Description</label>
						<div class="col-sm-10">
							<textarea class="form-control" rows="3"  id="inputpackagedesc" readonly name="inputpackagedesc" ><?php echo $packages['package_description'];?></textarea>
						</div>
					</div>
					<div class="form-group">
					  <label for="inputpackageprice" class="col-sm-2 control-label">Package Price</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackageprice" value="<?php echo $packages['package_price'];?>" readonly name="inputpackageprice">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputpackagetax1" class="col-sm-2 control-label">Tax 1</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackagetax1" value="<?php echo $packages['package_tax1'];?>" readonly name="inputpackagetax1">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputpackagetax2" class="col-sm-2 control-label">Tax 2</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackagetax2" value="<?php echo $packages['package_tax2'];?>" readonly name="inputpackagetax2">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputpackagetax3" class="col-sm-2 control-label">Tax 3</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackagetax3" value="<?php echo $packages['package_tax3'];?>" readonly name="inputpackagetax3">
					  </div>
					</div>
					<div class="form-group">
						<label for="inputpackagevalidity" class="col-sm-2 control-label">Package Validity </label>
						<div class="col-sm-10">
						   <input type="text" class="form-control" id="inputpackagevalidity" value="<?php echo $packages['package_validity'];?>" readonly  name="inputpackagevalidity">
						</div>
					</div>
					<div class="form-group">
					  <label for="inputpackagediscount" class="col-sm-2 control-label">Package Discount</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="inputpackagediscount" value="<?php echo $packages['package_discount'];?>" readonly name="inputpackagediscount">
					  </div>
					</div>
					<div class="form-group">
						<label for="inputservicetax" class="col-sm-2 control-label">Including Service Tax </label>
						<div class="col-sm-10">
						   <input type="text" class="form-control" id="inputservicetax" value="<?php if($packages['service_tax']==1){ echo "Yes";}else { echo "No"; }?>" readonly  name="inputservicetax">
						</div>
					</div>		
				</div>
				<div class="box-footer">
					<a class="btn btn-info pull-right" href="../../packages/packages_list/">Back</a>
				</div>
			</div>
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php 
	}
	else
	{ 
		redirect('/');
	}
?>