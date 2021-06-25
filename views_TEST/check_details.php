<?php 
if(isset($cust_id)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Confirm Payment    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Payments</a></li>
        <li class="active">Confirm Payment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>

		
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Confirm Payment</h3>
            </div>
<style>
.razorpay-payment-button{display:none;}
</style>
<?php
$busInfo=mysql_fetch_assoc(mysql_query("SELECT * FROM business_information"));
$qryRec=mysql_fetch_assoc(mysql_query("select * from payments order by payment_id DESC limit 1"));
$recNo=$qryRec['payment_id']+1;
$invoice=$busInfo['invoice_code']."/".date('ymdHis')."/".$recNo;

// $custName=$resCust['first_name'];
$busiName=$busInfo['business_name'];
$busiImage=base_url()."images/".$busInfo['business_image'];

 ?>
	<form action="<?php echo base_url()?>check_payment" method="POST" class="form-horizontal" role="form" autocomplete="off">
			<input type="hidden" class="form-control" id="cust_id" name="cust_id" value="<?php echo $_POST['cust_id'];?>" >
			<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $_POST['emp_id'];?>" >
			<input type="hidden" class="form-control" id="grp_id" name="grp_id" value="<?php echo $_POST['grp_id'];?>" >
			<input type="hidden" class="form-control" id="orderAmount" name="orderAmount" value="<?php echo $_POST['orderAmount'];?>" >
 
			 <div class="box-body"> 
				<div class="form-group">
					<label for="inputcustomername" class="col-sm-2 control-label">Customer Name </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="inputcustomername" name="inputcustomername" value="<?php echo $_POST['first_name']." ".$_POST['last_name'];?>" readonly >
					</div>
				</div>			  
				<div class="form-group">
                  <label for="inputcustomermobile" class="col-sm-2 control-label">Pending Amount </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="pendingAmt" name="pendingAmt"  value="<?php echo $_POST['pendingAmt']; ?>" readonly >
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputcustomeraddr" class="col-sm-2 control-label">Amount *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="orderAmount" name="orderAmount" placeholder="Amount Payble" value="<?php echo $_POST['orderAmount']; ?>" readonly>
                  </div>
                </div>
			  <div class="box-footer"> 
				<input type="Submit" value="Confirm" class="btn btn-info pull-right"/>
              </div> 
              </div> 
		<script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="rzp_live_FUvOIwfOBMSlWM"
        data-amount=<?php echo ($_POST['orderAmount']*100);?>
        data-name="<?php echo $custName." ".$busiName; ?>"
        data-description="Monthly Subscription"
        data-image="<?php echo $busiImage; ?>"
        data-netbanking="true"
        data-description="Tron Legacy"
        data-prefill.name="<?php echo $_POST['first_name']." ".$_POST['last_name'];?>"
        data-prefill.email="<?php echo $_POST['email_id'];?>"
        data-prefill.contact="<?php echo $_POST['mobile_no'];?>"
		data-notes.url="<?php echo base_url(); ?>"
        data-notes.invoice_id="<?php echo $invoice; ?>"
		data-notes.operator="<?php echo $busiName; ?>">
      </script> 
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
            