<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Add Common Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li class="active">Common Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($get_common as $key => $common_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/save_common_prefer"> 
        <!-- left column -->
		<div class="col-md-3"></div>
        <div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Common</h3>
				</div>
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="customnumber" class="col-sm-6 control-label">Use Custom Number</label>
						<div class="col-sm-6">
							<select class="form-control" id="customnumber" name="customnumber">
								<option value="Yes" <?php if($common_data['customnumber']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($common_data['customnumber']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="records" class="col-sm-6 control-label">Records Per Page</label>
						<div class="col-sm-6">
							<select class="form-control" id="records" name="records">
								<option value="10" <?php if($common_data['records']=='10'){ echo "selected";} ?>>10</option>
								<option value="20" <?php if($common_data['records']=='20'){ echo "selected";} ?>>20</option>
								<option value="30" <?php if($common_data['records']=='30'){ echo "selected";} ?>>30</option>
								<option value="40" <?php if($common_data['records']=='40'){ echo "selected";} ?>>40</option>
								<option value="50" <?php if($common_data['records']=='50'){ echo "selected";} ?>>50</option>
								<option value="60" <?php if($common_data['records']=='60'){ echo "selected";} ?>>60</option>
								<option value="70" <?php if($common_data['records']=='70'){ echo "selected";} ?>>70</option>
								<option value="80" <?php if($common_data['records']=='80'){ echo "selected";} ?>>80</option>
								<option value="90" <?php if($common_data['records']=='90'){ echo "selected";} ?>>90</option>
								<option value="100" <?php if($common_data['records']=='100'){ echo "selected";} ?>>100</option>
							</select>
						</div>
					</div>
					<div class="form-group" style="display:none;">
						<label for="mobilerecords" class="col-sm-6 control-label">Mobile Records Per Page</label>
						<div class="col-sm-6">
							<select class="form-control" id="mobilerecords" name="mobilerecords">
								<option value="10" <?php if($common_data['mobilerecords']=='10'){ echo "selected";} ?>>10</option>
								<option value="20" <?php if($common_data['mobilerecords']=='20'){ echo "selected";} ?>>20</option>
								<option value="30" <?php if($common_data['mobilerecords']=='30'){ echo "selected";} ?>>30</option>
								<option value="40" <?php if($common_data['mobilerecords']=='40'){ echo "selected";} ?>>40</option>
								<option value="50" <?php if($common_data['mobilerecords']=='50'){ echo "selected";} ?>>50</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="billdate" class="col-sm-6 control-label">Bill Date</label>
						<div class="col-sm-6">
							<select class="form-control" id="billdate" name="billdate">
								<option value="1" <?php if($common_data['billdate']=='1'){ echo "selected";} ?>>1</option>
							</select>
						</div>
					</div>
					<div class="form-group" style="display:none;">
						<label for="sortby" class="col-sm-6 control-label">Sort By</label>
						<div class="col-sm-6">
							<select class="form-control" id="sortby" name="sortby">
								<option value="customerid" <?php if($common_data['sortby']=='customerid'){ echo "selected";} ?>>Customer Id</option>
								<option value="customernumber" <?php if($common_data['sortby']=='customernumber'){ echo "selected";} ?>>Customer Number</option>
								<option value="customername" <?php if($common_data['sortby']=='customername'){ echo "selected";} ?>>Customer Name</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="invoiceformat" class="col-sm-6 control-label">Invoice Number Format</label>
						<div class="col-sm-6">
							<select class="form-control" id="invoiceformat" name="invoiceformat">
								<option value="1" <?php if($common_data['invoiceformat']=='1'){ echo "selected";} ?>>ABC/20160914165152/01</option>
								<option value="2" <?php if($common_data['invoiceformat']=='2'){ echo "selected";} ?>>ABC-20160914165152-21</option>
								<option value="3" <?php if($common_data['invoiceformat']=='3'){ echo "selected";} ?>>ABC-21-20160914165152</option>
								<option value="4" <?php if($common_data['invoiceformat']=='4'){ echo "selected";} ?>>ABC20160914165152-21</option>
								<!--
								<option value="newformat" <?php if($common_data['invoiceformat']=='newformat'){ echo "selected";} ?>>New Format</option>
								<option value="withtaxinfoandboxinfo" <?php if($common_data['invoiceformat']=='withtaxinfoandboxinfo'){ echo "selected";} ?>>With Tax Info and Box Info</option>
								<option value="withsplittaxinfoandboxinfo" <?php if($common_data['invoiceformat']=='withsplittaxinfoandboxinfo'){ echo "selected";} ?>>With Split Tax Info and Box Info</option>
								<option value="smallinvoiceformat" <?php if($common_data['invoiceformat']=='smallinvoiceformat'){ echo "selected";} ?>>Small Invoice Format</option>
								-->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="tax1" class="col-sm-6 control-label">TAX1</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="tax1" value="<?=$common_data['tax1'];?>" name="tax1" placeholder="TAX1">
						</div>
					</div>
					<div class="form-group">
						<label for="tax2" class="col-sm-6 control-label">TAX2</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="tax2" value="<?=$common_data['tax2'];?>" name="tax2" placeholder="TAX2">
						</div>
					</div>
					<div class="form-group">
						<label for="tax3" class="col-sm-6 control-label">TAX3</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="tax3" value="<?=$common_data['tax3'];?>" name="tax3" placeholder="TAX3">
						</div>
					</div>
					<div class="form-group">
						<label for="nextcustomerid" class="col-sm-6 control-label">Next Customer Id</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="nextcustomerid" name="nextcustomerid" value="<?=$common_data['nextcustomerid'];?>" placeholder="Next Customer Id">
						</div>
					</div>
				</div>
				<div class="box-footer" style="text-align:center;">
					<button type="submit" id="commonupdate" name="commonupdate" class="btn btn-info">Update</button>
				</div>
			</div>
        </div>
        <div class="col-md-3"></div>
		<div class="col-md-3" style="display:none;">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">&nbsp;</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label for="template" class="col-sm-6 control-label">Site Template -1</label>
						<div class="col-sm-6">
							<select class="form-control" id="template" name="template">
								<option>Select</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="admingroup" class="col-sm-6 control-label">Admin Group Control</label>
						<div class="col-sm-6">
							<select class="form-control" id="admingroup" name="admingroup">
								<option value="Yes" <?php if($common_data['admingroup']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($common_data['admingroup']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="amountdisplay" class="col-sm-6 control-label">Amount Display</label>
						<div class="col-sm-6">
							<select class="form-control" id="amountdisplay" name="amountdisplay">
								<option value="actual" <?php if($common_data['amountdisplay']=='actual'){ echo "selected";} ?>>Actual</option>
								<option value="round" <?php if($common_data['amountdisplay']=='round'){ echo "selected";} ?>>Round</option>
								<option value="ceil" <?php if($common_data['amountdisplay']=='ceil'){ echo "selected";} ?>>Ceil</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="financialyear" class="col-sm-6 control-label">Use Financial Year</label>
						<div class="col-sm-6">
							<select class="form-control" id="financialyear" name="financialyear">
								<option value="Yes" <?php if($common_data['financialyear']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($common_data['financialyear']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="months" class="col-sm-6 control-label">No. Of Months</label>
						<div class="col-sm-6">
							<select class="form-control" id="months" name="months">
								<option value="12" <?php if($common_data['months']=='12'){ echo "selected";} ?>>12</option>
								<option value="13" <?php if($common_data['months']=='13'){ echo "selected";} ?>>13</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="showbillamount" class="col-sm-6 control-label">Show Bill Amount in Customer Card</label>
						<div class="col-sm-6">
							<select class="form-control" id="showbillamount" name="showbillamount">
								<option value="Yes" <?php if($common_data['showbillamount']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($common_data['showbillamount']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="showonetime" class="col-sm-6 control-label">Show One Time Charges in Collections</label>
						<div class="col-sm-6">
							<select class="form-control" id="showonetime" name="showonetime">
								<option value="Yes" <?php if($common_data['showonetime']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($common_data['showonetime']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="showmonthbill" class="col-sm-6 control-label">Show Bill Month</label>
						<div class="col-sm-6">
							<select class="form-control" id="showmonthbill" name="showmonthbill">
								<option value="currentmonth" <?php if($common_data['showmonthbill']=='currentmonth'){ echo "selected";} ?>>Current Month</option>
								<option value="prevmonth" <?php if($common_data['showmonthbill']=='prevmonth'){ echo "selected";} ?>>Previous Month</option>
							</select>
						</div>
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