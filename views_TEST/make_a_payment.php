<?php 
 	 
 if(isset($cust_id)){ ?>

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
				$sel_pkg=mysql_query("select package_id,group_id from groups where group_id=".$customer['group_id']);
				$pkg_id=mysql_fetch_assoc($sel_pkg);
				//echo $pkg_id['package_id'];
				//echo "select package_price from packages where package_id=".$pkg_id['package_id'];
				$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);

				?>
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
		
	
		
		
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Make A Payment</h3>
            </div>
            <!-- /.box-header 
			 <form id="selOpt" class="form-horizontal" role="form" method="post" autocomplete="off" action="#"> 
			<div class="form-group box-body">
					<label for="inputcomplaintstatus" class="col-sm-2 control-label">Payment Mode *</label>
					<div class="col-sm-10">
						<select class="form-control" id="transactionType" name="transactionType" required>
							<option value="">Select</option>
							<option value="1" selected>Cash</option>
							<option value="2">Online Payment</option>						
							<option value="3" disabled>Adjustment</option>						
						</select>
					</div>
                </div>
			</form>	
            <!-- form start -->
 <style>
.razorpay-payment-button{display:none;}
</style>

 <form action="<?php echo base_url()?>check_payment/check/<?php echo $customer['cust_id'];?>" method="POST" class="form-horizontal" role="form" autocomplete="off">
	   <input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $cust_id;?>" >
	 <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="0" >
	 <input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $pkg_id['group_id'];?>" >
	 <input type="hidden" class="form-control" id="first_name" name="first_name" value="<?php echo $customer['first_name'];?>" >
	 <input type="hidden" class="form-control" id="last_name" name="last_name" value="<?php echo $customer['last_name'];?>" >
	 <input type="hidden" class="form-control" id="email_id" name="email_id" value="<?php echo $customer['email_id'];?>" >
	 <input type="hidden" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $customer['mobile_no'];?>" >
	 
              <div class="box-body"> 
				<div class="form-group">
					<label for="inputcustomername" class="col-sm-2 control-label">Customer Name </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $customer['first_name']." ".$customer['last_name'];?>" readonly >
					</div>
				</div>			  
				<div class="form-group">
                  <label for="inputcustomermobile" class="col-sm-2 control-label">Pending Amount </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="pendingAmt" name="pendingAmt"  value="<?php if($customer['pending_amount']==''){echo $customer['current_due'];}else{ echo $customer['current_due'];}?>" readonly >
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputcustomeraddr" class="col-sm-2 control-label">Amount *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="orderAmount" name="orderAmount" placeholder="Amount Payble" value="<?php if($customer['pending_amount']==''){echo $customer['current_due'];}else{ echo $customer['current_due'];}?>" maxlength=5 minlength=1  required>
                  </div>
                </div>
			  <div class="box-footer">
                <!-- <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button> -->
				<input type="Submit" value="Pay Now" class="btn btn-info pull-right"/>
              </div> 
              </div> 
		</form>
          </div> 
        </div>
        <!--/.col (left) --> 
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 
       <?php } else{ 
	 redirect('/');
  }?>  	
            