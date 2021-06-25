<div class="content-wrapper">
    <section class="content-header">
	<h1>Digital Cables  - Add New Package</h1>
     	<ol class="breadcrumb">
		<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a  href="#">Packages</a></li>
		<li class="active">Add New Package</li>
     	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="packagesForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>packages/packages_save"> 
        <!-- left column -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Package Details</h3>
            </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputpackagename" class="col-sm-4 control-label">Package Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputpackagename" name="inputpackagename" placeholder="Package Name" maxlength=100 required>
                  </div>
                </div>
		<div class="form-group">
			<label for="inputpackagedesc" class="col-sm-4 control-label">Package Description</label>
			<div class="col-sm-8">
				<textarea  class="form-control" rows="3"  id="inputpackagedesc" name="inputpackagedesc" placeholder="Package Description"></textarea>
			</div>
		</div>
		<div class="form-group">
            <label for="inputpackageprice" class="col-sm-4 control-label">Customer Package Price *</label>
            <div class="col-sm-8">
                <input type="number" min="0" max="99999" class="form-control" id="inputpackageprice" name="inputpackageprice" maxlength=7 placeholder="Package Price" required>
            </div>
        </div>
		<div class="form-group">
            <label for="lcoPrice" class="col-sm-4 control-label">LCO Price *</label>
            <div class="col-sm-8">
                <input type="number" min="0" max="99999" class="form-control" id="lcoPrice" name="lcoPrice" maxlength=7 placeholder="LCO Package Price" required>
            </div>
        </div>
		<div class="extratax" id="extratax">
			<div class="form-group">
                <label for="inputpackagetax1" class="col-sm-4 control-label">GST % *</label>
                <div class="col-sm-8">
                    <input type="number" min="0" max="100" class="form-control" id="inputpackagetax1" name="inputpackagetax1" maxlength=2 required>
                </div>
     		</div>
		</div>
        <div class="form-group">
          <label for="inputpackagevalidity" class="col-sm-4 control-label">Validity In Months *</label>
          <div class="col-sm-8">
            <input type="number" min="1" max="12" class="form-control" id="inputpackagevalidity" name="inputpackagevalidity" maxlength=2 value="1" required>
          </div>
        </div>
        <div class="form-group">
			<label for="mso_pack_id" class="col-sm-4 control-label">MSO PACKAGE ID *</label>
			<div class="col-sm-8">
				<input type="number" min="0" max="9999" class="form-control" id="mso_pack_id" name="mso_pack_id" maxlength=4 required>
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
        					<option value="<?php echo $resPackCat['cat_id'];?>"><?php echo $resPackCat['cat_name'];?></option>
						<?php
							}
						?>
        				</select>
        			</div>
                </div>
        </div>
              </div>
  		<div class="box-footer">
			<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
		</div>
		  </div>
		</form>
      </div>
    </section>
  </div>