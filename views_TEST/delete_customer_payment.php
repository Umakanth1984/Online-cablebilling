<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
 <style>
.button.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}
</style>

 <script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete this Payment ?")
  if (x) {
	  document.getElementById("delPayment").className = "disabled btn btn-info pull-right";
    return true;
  } else {
    return false;
  }
}
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Delete Payment </h1>

		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Payments</a></li>
			<li class="active">Delete Payment</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php
		 
	   foreach($paymentdelete as $key => $customer )
				{
				}
				$cust_id=$customer_id;
				$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
				$custRes=mysql_fetch_assoc($custQry);
				
				$sel_pkg=mysql_query("select package_id from groups where group_id=".$customer['group']);
				$pkg_id=mysql_fetch_assoc($sel_pkg);
				$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" 
	 action="<?php echo base_url()?>customer/paymentDelete/<?php echo $custRes['cust_id'];?>/<?php echo $custRes['payment_id'];?>/<?php echo $customer['amount_paid'];?>"> 

	 <input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $custRes['cust_id'];?>" >
	 <input type="hidden" class="form-control" id="payment_id" name="payment_id" value="<?php echo $customer['payment_id'];?>" > 
	 <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>" > 
	 <input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $customer['group_id'];?>" >

        <!-- left column -->

        <div class="col-md-10"> 
          <div class="box box-info"> 
            <div class="box-header with-border"> 
              <h3 class="box-title">Delete A Payment</h3> 
            </div>
              <div class="box-body">
  

				<div class="form-group">

					<label for="inputcustomername" class="col-sm-2 control-label">Customer Name </label>

					<div class="col-sm-10">

						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $custRes['first_name']." ".$custRes['last_name'];?>" readonly >

					</div>

				</div>			  
 

				<div class="form-group">

                  <label for="inputcustomeraddr" class="col-sm-2 control-label">Amount *</label>

                  <div class="col-sm-10">

                    <input type="text" class="form-control" id="amount" name="amount" readonly placeholder="Amount Paid" value="<?php echo $customer['amount_paid'];?>" maxlength=5 minlength=1  required>

                  </div>

                </div>
				 <div class="form-group">

                  <label for="inputcomplaintstatus" class="col-sm-2 control-label">Remarks *</label>

				   <div class="col-sm-10">

					  <select class="form-control" id="delReason" name="delReason" required>

						<option value="">Select a Reason</option>

						<option value="1">Duplicate Entry</option>

						<option value="2">Payment Reversal</option>						

					  </select>

				  </div>

                </div>
 
              </div>
				<div class="box-footer">
					<button type="submit" id="delPayment" name="delPayment" class="btn btn-info pull-right" onclick="return ConfirmDialog();">Delete</button>
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
 

<?php 
	}
 else
	{ 
		redirect('/');
	}
?>