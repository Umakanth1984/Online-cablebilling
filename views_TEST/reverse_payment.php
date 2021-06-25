<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Reverse Payment    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Payments</a></li>
        <li class="active">Reverse Payment</li>
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
				//echo $pkg_id['package_id'];
				//echo "select package_price from packages where package_id=".$pkg_id['package_id'];
				$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
				$sel_price=mysql_fetch_assoc($qry_price);
				
				$qry1=mysql_query("select * from payments where customer_id=".$customer['cust_id']." ORDER BY payment_id DESC LIMIT 1");
				$res1=mysql_fetch_assoc($qry1);
				?>
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/payment_reverse"> 
	 <input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $customer['cust_id'];?>" >
	 <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>" >
	 <input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $customer['group_id'];?>" >
        <!-- left column -->
        <div class="col-md-10">
			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Reverse Payment <?php echo $res1['amount_paid'];?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body">
				<div class="form-group">
					<label for="inputcustomername" class="col-sm-2 control-label">Customer Name </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $customer['first_name']." ".$customer['last_name'];?>" readonly >
					</div>
				</div>			  
				<div class="form-group">
                  <label for="inputcustomermobile" class="col-sm-2 control-label">Amount Paid</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="pendingAmt" name="pendingAmt"  value="<?php if($customer['pending_amount']==''){echo $customer['pending_amount'];}else{ echo $res1['amount_paid'];}?>" readonly >
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputcustomeraddr" class="col-sm-2 control-label">Amount *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount Payble" value="<?php echo $res1['amount_paid'];?>" maxlength=5 minlength=1  required>
                  </div>
                </div>
				
              </div>
             
				<div class="box-footer">
					<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
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
       <?php } else{ 
	 redirect('/');
  }?>