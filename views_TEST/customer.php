<?php
extract($emp_access);
if($custA ==1)
{
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#lco_id").on('change',function() {
	var program_id2 = $("#lco_id").val();
		$.ajax({
		url: "<?php echo base_url()?>customer/get_lco_groups",
		type: "POST",
		// dataType: "json",
		data: {lco_id: program_id2},
			success: function(res)
			{
				$("#inputGroup1").html(res);
			}
		});
	});
	$("#inputGroup1").on('change',function() {
	var program_id = $("#inputGroup1").val();
		$.ajax({
		url: "<?php echo base_url()?>customer/get_program_data",
		type: "POST",
		dataType: "json",
		data: {program_id: program_id},
			success: function(res) {
				alert("Last Customer ID in this Group is : " + res);
				jQuery("#inputCCN").val(res);
			}
		});
	});
	$("#inputCCN").on('change',function() {
		var inputCCN = $("#inputCCN").val();
		var lco_id = $("#lco_id").val();
		$.ajax({
		url: "<?php echo base_url()?>customer/check_customer_no",
		type: "POST",
		data: {value: inputCCN,lco_id: lco_id},
			success: function(res)
			{
				if(res==1)
				{
					alert("Customer No Already Exist");
					$("#customerSubmit").attr("disabled",true);
				}
				else
				{
					$("#customerSubmit").attr("disabled",false);
				}
			}
		});
	});
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Digital Cables  - Add New Customer</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Customers</a></li>
        <li class="active">Add New Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<form id="customerForm" name="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/customer_save">
		<div class="row"> 
        <!-- left column -->
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Personal Data</h3>
            </div>
              <div class="box-body">
		<div class="form-group">
                  <label for="inputFname" class="col-sm-4 control-label">Customer Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputFname" name="inputFname" placeholder="First Name" maxlength=25 minlength=3 required>
                  </div>
                </div>
		<div class="form-group">
                  <label for="inputLname" class="col-sm-4 control-label">Last Name </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputLname" name="inputLname" placeholder="Last Name" maxlength=25 minlength=3  >
                  </div>
                </div>
		<div class="form-group">
			<label for="inputAddr1" class="col-sm-4 control-label">Area *</label>
			<div class="col-sm-8">
				<textarea  class="form-control"  rows="3"  id="inputAddr1" name="inputAddr1" placeholder="Address 1" ></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="inputAddr2" class="col-sm-4 control-label">Area 1:</label>
			<div class="col-sm-8">
				<textarea  class="form-control"  rows="3"  id="inputAddr2" name="inputAddr2" placeholder="Address 2" ></textarea>
			</div>
              	</div>
		<!--
		<div class="form-group">
			<label for="inputAddr3" class="col-sm-4 control-label">Address 3:</label>
			<div class="col-sm-8">
				<textarea  class="form-control"  rows="3"  id="inputAddr3" name="inputAddr3" placeholder="Address 3" ></textarea>
			</div>
		</div>
                -->
		<div class="form-group">
                  <label for="inputCity" class="col-sm-4 control-label">Location *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="Location"  maxlength=25 minlength=3  required>
                  </div>
                </div>
		<div class="form-group">
                  <label for="inputPincode" class="col-sm-4 control-label">PinCode *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputPincode" name="inputPincode" placeholder="Pincode" maxlength=6 minlength=6   required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputCountry" class="col-sm-4 control-label">Country</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputCountry" name="inputCountry" maxlength=25 minlength=3 placeholder="Country" value="IND">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputState" class="col-sm-4 control-label">State *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputState" name="inputState" placeholder="State" maxlength=25 minlength=2 required value="TS">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPhone" class="col-sm-4 control-label">Phone </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputPhone" name="inputPhone" placeholder="Phone Number" maxlength=13 minlength=10 >
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputMobile" class="col-sm-4 control-label">Mobile *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputMobile" name="inputMobile" placeholder="Mobile" maxlength=10 minlength=10 required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputEmail" class="col-sm-4 control-label">Email Id </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" maxlength=40 minlength=4>
                  </div>
                </div>
				<div class="form-group">
                  <label for="install_charge" class="col-sm-4 control-label">Installation Charges</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="install_charge" name="install_charge" placeholder="Installation Charges" maxlength=5>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Package Information</h3>
			</div>
				<div class="box-body">
                <?php if($employee_info['user_type']==9){?>
				<div class="form-group">
					<label for="lco_id" class="col-sm-4 control-label">LCO *</label>
					<div class="col-sm-8">
						<select class="form-control" id="lco_id" name="lco_id" required>
							<option value="">Select LCO</option>
							<?php foreach($lco_list as $key => $lco){?>
							<option value="<?php echo $lco['admin_id']; ?>" <?php if(isset($_REQUEST['lco_id']) && $_REQUEST['lco_id']==$lco['admin_id']){ echo "selected";}?>><?php echo $lco['adminFname'];?></option>
							<?php }?>
					    </select>
					</div>
				</div>
				<div class="form-group">
					<label for="crd_id" class="col-sm-4 control-label">Credential *</label>
					<div class="col-sm-8">
						<select class="form-control" id="crd_id" name="crd_id" required>
							<option value="">Select Credential</option>
							<?php foreach($credentials as $key => $credential){?>
							<option value="<?php echo $credential['crd_id'];?>" <?php if(isset($_REQUEST['crd_id']) && $_REQUEST['crd_id']==$credential['crd_id']){ echo "selected";}?>><?php echo $credential['user_name'];?></option>
							<?php }?>
					    </select>
					</div>
				</div>
                <div class="form-group">
                    <label for="inputGroup" class="col-sm-4 control-label">Group *</label>
				    <div class="col-sm-8">
					    <select class="form-control" id="inputGroup1" name="inputGroup" required>
    					    <option value="">Select Group</option>
    						<?php
    				        /*foreach($groups as $key => $group)
    				        {
    						?>
    						<option value="<?php echo $group['group_id'];?>"><?php echo $group['group_name'];?></option>
    						<?php
    						}*/
    						?>
					    </select>
				    </div>
                </div>
				<?php } ?>
				<div class="form-group">
					<label for="inputCCN" class="col-sm-4 control-label">Unique Customer Number *</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputCCN" name="inputCCN" placeholder="Unique Customer Number" maxlength=25 minlength=4 required>
					</div>
                </div>
                <div class="form-group">
                    <label for="stb_no" class="col-sm-4 control-label">STB Number *</label>
    				<div class="col-md-8">
    					<input type="text" class="form-control" id="stb_no" name="stb_no" placeholder="Enter STB Number" maxlength=25 minlength=4 required>
    				</div>
    			</div>
    			<div class="form-group">
    			    <label for="card_no" class="col-sm-4 control-label">VC No</label>
    				<div class="col-md-8">
    					<input type="text" class="form-control" id="card_no" name="card_no" placeholder="Enter VC Card Number" maxlength=255>
    				</div>
    			</div>
				<div class="form-group">
                    <label for="connectionDate" class="col-sm-4 control-label">Connection Date: *</label>
                    <div class="col-sm-8">
						<input type="date" class="form-control pull-right" id="connectionDate" name="connectionDate" placeholder="YYYY-MM-DD" value="<?php echo date('Y-m-d');?>" required>
                    </div>
                </div>
			    <div class="form-group">
                    <label for="inputRemarks" class="col-sm-4 control-label">Remarks:</label>
                    <div class="col-sm-8">
    					<textarea class="form-control" rows="3" id="inputRemarks" name="inputRemarks" placeholder="Remarks"></textarea>
                    </div>
                </div>
			</div>
          </div>
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Subscription Data</h3>
            </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="inputAmount" class="col-sm-4 control-label">Outstanding Amount *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="inputAmount" id="inputAmount" placeholder="Amount" maxlength=5 minlength=1 value="0" required>
                  </div>
                </div>
				 <div class="form-group">
                  <label for="inputTaxRate" class="col-sm-4 control-label">Tax Rate</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputTaxRate" name="inputTaxRate" placeholder="Tax Rate" maxlength=5 minlength=1>
                  </div>
                </div>
				<div class="form-group">
                <label for="startDate" class="col-sm-4 control-label">Start Date: *</label>
                <div class="col-sm-8">
                   <input type="date" class="form-control pull-right" id="startDate"  name="startDate" placeholder="YYYY-MM-DD" required>
                </div>
              </div>
			  <div class="form-group">
                <label for="endDate" class="col-sm-4 control-label">End Date:</label>
                <div class="col-sm-8">
                     <input type="date" class="form-control pull-right" id="endDate" placeholder="YYYY-MM-DD" name="endDate">
                </div>
              </div>
              </div>
          </div>
        </div>
		</div>
      <!-- /.row -->
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
            </div>
		</form>
    </section>
    <!-- /.content -->
  </div>
<?php
    }
    else
    { 
	    redirect('/welcome');
    }?>