<?php
extract($emp_access);
extract($employee_info);
if($custE ==1){ ?>
<?php foreach($edit_customer as $key => $customer){}?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	<?php if($employee_info['user_type']==9){?>
	$("#lco_id").on('change',function() {
	var program_id2 = $("#lco_id").val();
		$.ajax({
		url: "<?php echo base_url()?>customer/get_lco_groups",
		type: "POST",
		data: {lco_id: program_id2},
			success: function(res)
			{
				$("#inputGroup1").html(res);
			}
		});
	});
	
	setTimeout(function(){
		var program_id3 = $("#lco_id").val();
		$.ajax({
		url: "<?php echo base_url()?>customer/get_lco_groups",
		type: "POST",
		data: {lco_id: program_id3},
			success: function(res)
			{
				$("#inputGroup1").html(res);
				setTimeout(function(){$("#inputGroup1").val(<?php echo $customer['group_id'];?>)},1000);
			}
		});
	},2000);
	<?php }else{ ?>
	setTimeout(function(){
		var program_id3 = <?php echo $customer['admin_id'];?>;
		$.ajax({
		url: "<?php echo base_url()?>customer/get_lco_groups",
		type: "POST",
		data: {lco_id: program_id3},
			success: function(res)
			{
				$("#inputGroup1").html(res);
				setTimeout(function(){$("#inputGroup1").val(<?php echo $customer['group_id'];?>)},1000);
			}
		});
	},2000);
	<?php } ?>
	/*$("#inputGroup1").on('change',function() {
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
	});*/
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
					$("#customerEdit").attr("disabled",true);
				}
				else
				{
					$("#customerEdit").attr("disabled",false);
				}
			}
		});
	});
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Digital Cables - Edit Customer</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Customer</a></li>
            <li class="active">Edit Customer</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
	    <?php if(isset($msg)){ echo $msg; }?>
		<form id="customerFormEdit" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/customer_updated/<?php echo $customer['cust_id']?>"> 
		<div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Personal Data</h3>
                </div>
                  <div class="box-body">
    				<div class="form-group">
                      <label for="inputFname" class="col-sm-2 control-label">First Name *</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFname" value="<?php echo $customer['first_name'];?>" name="inputFname" placeholder="First Name" required>
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="inputLname" class="col-sm-2 control-label">Last Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputLname" value="<?php echo $customer['last_name'];?>"  name="inputLname" placeholder="Last Name">
                      </div>
                    </div>
    				<div class="form-group">
    					<label for="inputAddr1" class="col-sm-2 control-label">Address 1:</label>
    					<div class="col-sm-10">
    						<textarea  class="form-control"  rows="3"  id="inputAddr1"   name="inputAddr1" placeholder="Address 1" ><?php echo $customer['addr1'];?></textarea>
    					</div>
    				</div>
    			    <div class="form-group">
    					<label for="inputAddr2" class="col-sm-2 control-label">Address 2:</label>
    					<div class="col-sm-10">
    						<textarea  class="form-control"  rows="3"  id="inputAddr2"    name="inputAddr2" placeholder="Address 2"><?php echo $customer['addr2'];?></textarea>
    					</div>
                    </div>
    				 <div class="form-group">
                      <label for="inputCity" class="col-sm-2 control-label">Location </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCity" value="<?php echo $customer['city'];?>"  name="inputCity" placeholder="City">
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="inputState" class="col-sm-2 control-label">State </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputState" value="<?php echo $customer['state'];?>"  name="inputState" placeholder="State">
                      </div>
                    </div>
    				<div class="form-group">
    				  <label for="inputPincode" class="col-sm-2 control-label">PinCode </label>
    				  <div class="col-sm-10">
    					<input type="text" class="form-control" id="inputPincode" value="<?php echo $customer['pin_code'];?>"  name="inputPincode" placeholder="Pincode">
    				  </div>
                    </div>
    				<div class="form-group">
                      <label for="inputCountry" class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCountry" value="<?php echo $customer['country'];?>"  name="inputCountry" placeholder="Country" >
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPhone" value="<?php echo $customer['phone_no'];?>"  name="inputPhone" placeholder="Phone Number">
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="inputMobile" class="col-sm-2 control-label">Mobile *</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputMobile" value="<?php echo $customer['mobile_no'];?>"  name="inputMobile" placeholder="Mobile" maxlength=10 minlength=10 required>
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">Email Id</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputEmail" value="<?php echo $customer['email_id'];?>"  name="inputEmail" placeholder="Email">
                      </div>
                    </div>
    				<div class="form-group">
                      <label for="install_charge" class="col-sm-2 control-label">Installation Charges</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="install_charge" value="<?php echo $customer['install_charge'];?>"  name="install_charge" placeholder="Installation Charges">
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
                    <!-- /.box-header -->
                    <!-- form start -->
                      <div class="box-body">
                        <?php if($employee_info['user_type']==9){?>
        				<div class="form-group">
        					<label for="lco_id" class="col-sm-4 control-label">LCO *</label>
        					<div class="col-sm-8">
        						<select class="form-control" id="lco_id" name="lco_id" required>
        							<option value="">Select LCO</option>
        							<?php foreach($lco_list as $key => $lco){?>
        							<option value="<?php echo $lco['admin_id']; ?>" <?php if($customer['admin_id']==$lco['admin_id']){ echo "selected";}?>><?php echo $lco['adminFname'];?></option>
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
        							<option value="<?php echo $credential['crd_id'];?>" <?php if($customer['crd_id']==$credential['crd_id']){ echo "selected";}?>><?php echo $credential['user_name'];?></option>
        							<?php }?>
        					    </select>
        					</div>
        				</div>
        				<?php } ?>
                        <div class="form-group">
                            <label for="inputGroup" class="col-sm-4 control-label">Group *</label>
        				    <div class="col-sm-8">
        					    <select class="form-control" id="inputGroup1" name="inputGroup" required>
            					    <option value="">Select Group</option>
            						<?php
            				        /*foreach($groups as $key => $group)
            				        {
            						?>
            						<option value="<?php echo $group['group_id'];?>" <?php if($group['group_id'] == $customer['group_id']){ echo "selected";} ?>><?php echo $group['group_name'];?></option>
            						<?php
            						}*/
            						?>
        					    </select>
        				    </div>
                        </div>
        				<div class="form-group">
                          <label for="inputCCN" class="col-sm-4 control-label">Unique Customer Number *</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputCCN" value="<?php echo $customer['custom_customer_no'];?>" name="inputCCN" placeholder="Unique Customer Number" required>
                          </div>
                        </div>
                        <div class="form-group">
                            <label for="stb_no" class="col-sm-4 control-label">STB Number *</label>
            				<div class="col-md-8">
            					<input type="text" class="form-control" id="stb_no" name="stb_no" value="<?php echo $customer['stb_no'];?>" placeholder="Enter STB Number" maxlength=25 minlength=4 required <?php if($user_type!=9){ echo 'readonly';}?>>
            				</div>
            			</div>
            			<div class="form-group">
            			    <label for="card_no" class="col-sm-4 control-label">VC No</label>
            				<div class="col-md-8">
            					<input type="text" class="form-control" id="card_no" name="card_no" value="<?php echo $customer['card_no'];?>" placeholder="Enter VC Card Number" maxlength=255>
            				</div>
            			</div>
        				<div class="form-group">
                            <label for="connectionDate" class="col-sm-4 control-label">Connection Date:</label>
                            <div class="col-sm-8">
                               <input type="date" class="form-control pull-right" id="connectionDate" value="<?php echo $customer['connection_date'];?>" name="connectionDate">
                            </div>
                        </div>
        			    <div class="form-group">
                            <label for="inputRemarks" class="col-sm-4 control-label">Remarks:</label>
                            <div class="col-sm-8">
            					<textarea class="form-control" rows="3" id="inputRemarks" name="inputRemarks" placeholder="Remarks"><?php echo $customer['remarks'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
        		<div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Subscription Data</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group" <?php if($user_type!=9){ echo 'style="display:none;"';}?>>
                          <label for="inputAmount" class="col-sm-4 control-label">Outstanding Amount </label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="inputAmount" id="inputAmount" value="<?php echo $customer['pending_amount'];?>" placeholder="Amount">
                          </div>
                        </div>
        				<div class="form-group" <?php if($user_type!=9){ echo 'style="display:none;"';}?>>
                          <label for="inputTaxRate" class="col-sm-4 control-label">Discount</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputTaxRate" name="inputTaxRate" value="<?php echo $customer['tax_rate'];?>" placeholder="Discount">
                          </div>
                        </div>
        				<div class="form-group">
                            <label for="startDate" class="col-sm-4 control-label">Start Date:</label>
                            <div class="col-sm-8">
                               <input type="date" class="form-control pull-right" id="startDate"  name="startDate" value="<?php echo $customer['start_date'];?>"  placeholder="YYYY-DD-MM">
                            </div>
                        </div>
        			    <div class="form-group">
                            <label for="endDate" class="col-sm-4 control-label">End Date:</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control pull-right" id="endDate" value="<?php echo $customer['end_date'];?>" placeholder="YYYY-DD-MM" name="endDate" <?php if($user_type!=9){ echo 'readonly';}?>>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="box-footer">
            <input type="submit" id="customerEdit" name="customerEdit" class="btn btn-info pull-right" value="Update">
        </div>
		</form>
    </section>
    <!-- /.content -->
</div>
   <?php 
	}
	else
	{	   
		redirect('/');
	}?>