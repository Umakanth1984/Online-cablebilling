<?php
extract($emp_access);
if($packageE ==1)
{
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Edit Package</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Packages</a></li>
			<li class="active">Edit Package</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
		    <form id="packagesForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
                <div class="col-md-2"></div>
                <div class="col-md-8">
         	        <div class="box box-info">
	                    <div class="box-header with-border">
			                <h3 class="box-title">Package Details</h3>
	                    </div>
        	            <div class="box-body">
                            <div class="form-group">
                                <label for="PackageName" class="col-sm-4 control-label">Package Name *</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="PackageName" value="<?php echo $data['package_name'];?>" name="PackageName" required>
                                </div>
                            </div>
                			<div class="form-group">
                				<label for="PackageDescription" class="col-sm-4 control-label">Package Description </label>
                				<div class="col-sm-8">
                					<textarea class="form-control" rows="3" id="PackageDescription" name="PackageDescription"><?php echo $data['package_description'];?></textarea>
                				</div>
                			</div>
                			<div class="form-group">
                              	<label for="lcoPrice" class="col-sm-4 control-label">LCO Price</label>
                              	<div class="col-sm-8">
                                	<input type="text" min="0" max="99999" class="form-control" id="lcoPrice" name="lcoPrice" value="<?php echo $data['lco_price'];?>" placeholder="LCO Price" readonly>
                            	</div>
                	        </div>		  
                			<div class="form-group">
                				<label for="PackagePrice" class="col-sm-4 control-label">Customer Price *</label>
                				<div class="col-sm-8">
                					<input type="text" min="0" max="99999" class="form-control" id="PackagePrice" value="<?php echo $data['cust_price'];?>" name="PackagePrice" required>
                				</div>
                        	</div>
                			<div class="box-footer">
                				<input type="submit" id="updatePackage" name="updatePackage" class="btn btn-info pull-right" value="Update">
                			</div>
			            </div>
		            </div>
		        </div>
	        </form>
        </div>
    </section>
    </div>
<?php
	}
	else
	{ 
		redirect('/');
	}
?>