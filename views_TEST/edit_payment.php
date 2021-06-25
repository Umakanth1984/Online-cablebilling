<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Edit Payment </h1>

		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Payments</a></li>
			<li class="active">Edit Payment</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
          
	   <?php foreach($edit_payment as $key => $customer )
				{
				}
				
				// $cust_id=$customer_id;
		       $cust_id=$customer['customer_id'];
		      //echo "select * from customers where cust_id='$cust_id'";exit;
				$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
				$custRes=mysql_fetch_assoc($custQry);
				
				$sel_pkg=mysql_query("select package_id from groups where group_id=".$customer['group']);
				$pkg_id=mysql_fetch_assoc($sel_pkg);
				$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				?>
			
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <?php //print_r($customer);exit; ?>
	 <?php //print_r($custRes);exit;?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" 
	 action="<?php echo base_url()?>customer/editPayment/<?php echo $custRes['cust_id'];?>"> 

	 <input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $custRes['cust_id'];?>" >
	 <input type="hidden" class="form-control" id="payment_id" name="payment_id" value="<?php echo $customer['payment_id'];?>" > 
	 <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>" > 
	 <input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $customer['group_id'];?>" >

        <!-- left column -->

        <div class="col-md-10"> 
          <div class="box box-info"> 
            <div class="box-header with-border"> 
              <h3 class="box-title">Edit A Payment</h3> 
            </div>
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

						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $custRes['first_name']." ".$custRes['last_name'];?>" readonly >

					</div>

				</div>			  

				 <div class="form-group">

                  <label for="inputcustomermobile" class="col-sm-2 control-label">Pending Amount </label>

                  <div class="col-sm-10">

                    <input type="text" class="form-control" id="pendingAmt" name="pendingAmt"  value="<?php echo $customer['amount_paid'];?>" readonly >

                  </div>

                </div>

				<div class="form-group">

                  <label for="inputcustomeraddr" class="col-sm-2 control-label">Amount *</label>

                  <div class="col-sm-10">

                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount Payble" value="<?php echo $customer['amount_paid'];?>" maxlength=5 minlength=1  required>

                  </div>

                </div>
				 <div class="form-group">

                  <label for="inputcomplaintstatus" class="col-sm-2 control-label">Type *</label>
    <?php //echo $customer['transaction_type'];exit; ?>
				   <div class="col-sm-10">

					  <select class="form-control" id="transactionType" name="transactionType"  required>

						<option value="">Select</option>
						<option value="1" <?php if($customer['transaction_type'] == 1) {  echo "selected";  } ?>>Cash</option>						
							<option value="2" <?php if($customer['transaction_type'] == 2) {  echo "selected"; } ?>>Cheque / DD</option>						
							<option value="3" <?php if($customer['transaction_type'] == 3) { echo "selected"; } ?>>Adjustment</option>
							<option value="4" <?php if($customer['transaction_type'] == 4) {  echo "selected";  } ?>>Google pay</option>
							<option value="5" <?php if($customer['transaction_type'] == 5) { echo "selected";  } ?>>Phone pay</option>
							<option value="6" <?php if($customer['transaction_type'] == 6) { echo "selected";  } ?>>Paytm</option>					

					  </select>

				  </div>

                </div>

				<div id="Bank" style="display:none;">

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
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
				</div>
          </div>
        </div>
        <!--/.col (left) -->
		</form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($) { 
	 $('#transactionType').on('change',function() { 
	if(this.value==2)
			{ 
			$("#Bank").show();
			}
	if(this.value==1)
			{ 
			$("#Bank").hide();
			}
    });
});
</script>

<?php 
	}
 else
	{ 
		redirect('/');
	}
?>