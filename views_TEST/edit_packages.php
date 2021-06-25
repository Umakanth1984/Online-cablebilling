<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if($packageE ==1)
{ 
?>
<!-- Select2 -->
<link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/assets/bower_components/select2/dist/css/select2.min.css">
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
		<?php
		    foreach($edit_packages as $key => $packages){}
			$netPrice = $packages['package_price'];
		?>
		<form id="packagesForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>packages/packages_updated/<?php echo $packages['package_id']?>">
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
        					<input type="text" class="form-control" id="PackageName" value="<?php echo $packages['package_name'];?>" name="PackageName" required>
        				</div>
                    </div>
        			<div class="form-group">
        				<label for="PackageDescription" class="col-sm-4 control-label">Package Description </label>
        				<div class="col-sm-8">
        				    <textarea class="form-control" rows="3" id="PackageDescription" name="PackageDescription"><?php echo $packages['package_description'];?></textarea>
        			    </div>
                    </div>
        			<div class="form-group">
        				<label for="PackagePrice" class="col-sm-4 control-label">Customer Package Price *</label>
        				<div class="col-sm-8">
        					<input type="text" min="0" max="99999" class="form-control" id="PackagePrice" value="<?php echo $netPrice;?>" name="PackagePrice" required>
        				</div>
                    </div>
					<div class="form-group">
						<label for="lcoPrice" class="col-sm-4 control-label">LCO Price *</label>
						<div class="col-sm-8">
							<input type="number" min="0" max="99999" class="form-control" id="lcoPrice" name="lcoPrice" value="<?php echo $packages['package_tax2'];?>" maxlength=7 placeholder="LCO Package Price" required>
						</div>
					</div>
        			<div class="extratax" id="extratax">
        				<div class="form-group">
        					<label for="Tax1" class="col-sm-4 control-label">GST %</label>
        					<div class="col-sm-8">
        						<input type="number" min="0" max="100" class="form-control" id="Tax1" value="<?php echo $packages['package_tax1'];?>" name="Tax1" required>
        					</div>
        				</div>
        			</div>
        			<div class="form-group">
        				<label for="ValidityInMonths" class="col-sm-4 control-label">Validity In Months *</label>
        				<div class="col-sm-8">
        					<input type="text" class="form-control" id="ValidityInMonths" value="<?php echo $packages['package_validity'];?>" name="ValidityInMonths" required>
        				</div>
        			</div>
					<div class="form-group">
						<label for="mso_pack_id" class="col-sm-4 control-label">MSO PACKAGE ID *</label>
						<div class="col-sm-8">
							<input type="number" min="0" max="9999" class="form-control" id="mso_pack_id" name="mso_pack_id" value="<?php echo $packages['mso_pack_id'];?>" maxlength=4 required>
						</div>
					</div>
        			<div class="form-group">
						<label for="package_cat" class="col-sm-4 control-label">Package Type *</label>
						<div class="col-sm-8">
							<select class="form-control" id="package_cat" name="package_cat" required>
								<option value="">Select Type</option>
							<?php
								$getPackCat = $this->db->query("select cat_id,cat_name from package_cat where status=1")->result_array();
								foreach($getPackCat as $key => $resPackCat)
								{
							?>
								<option value="<?php echo $resPackCat['cat_id'];?>" <?php if($resPackCat['cat_id']==$packages['package_validity']){ echo "selected";}?>><?php echo $resPackCat['cat_name'];?></option>
							<?php
								}
							?>
							</select>
						</div>
					</div>
        			<div class="box-footer">
        				<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
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