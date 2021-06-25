<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
 <style>
.button.disabled {
  opacity: 0.9; 
  cursor: not-allowed;
  display: none;
}
</style>
<script>
function ConfirmPayNow() {
  var x=confirm("Are you sure to Pay?")
  if (x) {
	document.getElementById("customerSubmit").className = "disabled btn btn-info pull-right";
    return true;
  }else{
	return false;
  }
}
</script>
 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Make A Payment    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Payments</a></li>
        <li class="active">Make A Payment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php foreach($payment_customer as $key => $customer )
				{
				}
				$sel_pkg=mysql_query("select package_id from groups where group_id=".$customer['group']);
				$pkg_id=mysql_fetch_assoc($sel_pkg);
				$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/payment"> 
	 <input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $customer['cust_id'];?>" >
	 <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>" >
	 <input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $customer['group_id'];?>" >
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Make A Payment</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group" style="display:none;">
                  <label for="inputcustomerno" class="col-sm-2 control-label">Is this an Adjustment? </label>
                  <div class="col-sm-10">
                    <input type="checkbox" class="minimal" id="isAdjustment" name="isAdjustment" value="1"  >
                  </div>
                </div>
				<div class="form-group">
					<label for="inputcustomername" class="col-sm-2 control-label">Customer Name </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $customer['first_name']." ".$customer['last_name'];?>" readonly >
					</div>
				</div>			  
				<div class="form-group">
                  <label for="pendingAmt" class="col-sm-2 control-label">Pending Amount </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="pendingAmt" name="pendingAmt"  value="<?php echo $customer['pending_amount'];?>" readonly >
                  </div>
                </div>
				<div class="form-group">
                  <label for="amount" class="col-sm-2 control-label">Amount *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount Payble" value="<?php echo $customer['pending_amount'];?>" maxlength=5 minlength=1  required>
                  </div>
                </div>
			 
				<div class="form-group">
					<label for="transactionType" class="col-sm-2 control-label">Type *</label>
					<div class="col-sm-10">
						<select class="form-control" id="transactionType" name="transactionType" required>
							<option value="">Select</option>
							<option value="1">Cash</option>
							<option value="2">Cheque / DD</option>						
							<option value="3">Adjustment</option>
							<option value="4">Google pay</option>
							<option value="5">Phone pay</option>
							<option value="6">Paytm</option>
						</select>
					</div>
                </div>
				<div id="Bank1" style="display:none;">
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Cheque/DD Number *</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="cheque_number " name="cheque_number" placeholder="Cheque/DD Number">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Bank *</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="bank" name="bank" placeholder="Bank">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Branch *</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="branch" name="branch" placeholder="Branch">
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Instrument Date *</label>
					  <div class="col-sm-10">
						<input type="date" class="form-control" id="instrument_date" name="instrument_date" placeholder="Instrument Date">
					  </div>
					</div>				
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Remarks </label>
					  <div class="col-sm-10">
						<textarea  class="form-control"  rows="3"  id="remarks"   name="remarks" placeholder="Remarks"></textarea>
					  </div>
					</div>		
				</div>
              </div>
				<div class="box-footer">
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right"  onclick="return ConfirmPayNow();">Pay Now</button>
				</div>
          </div>
        </div>
		</form>
      </div>
    </section>
  </div>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) { 
	 $('#transactionType').on('change',function() { 
	if(this.value==2)
			{ 
			$("#Bank1").show();
			}
	if(this.value!=2)
			{ 
			$("#Bank1").hide();
			}  
    });
});
</script>
    <?php 
	}
	else
	{ 
		redirect('/');
	}?>