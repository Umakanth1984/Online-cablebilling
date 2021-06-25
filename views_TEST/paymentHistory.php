<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($paymentsV ==1) || ($paymentsE ==1) ||($paymentsD ==1)){ ?>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete this Payment ?")
  if (x) {
    return true;
  } else {
    return false;
  }
}
</script>
<?php
	$cust_id=$customer_id;
	$custQry=mysql_query("select * from customers where cust_id='$cust_id'");
	$custRes=mysql_fetch_assoc($custQry);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Payment History      
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Customers</a></li>
        <li class="active"><a  href="#">Payment History</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Payment Details of <?php echo $custRes['first_name'];?></h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/paymentHistory/<?php echo $cust_id;?>">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate">
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="todate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" >
									</div>
								</div>
								<div class="col-md-4 pull-right" >
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<?php if(isset($msg) && $msg!=''){ echo $msg;} ?>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Date</th>
									<th>Invoice No</th> 
									<th>Payment Mode</th>
									<th>Amount</th>
									<th>&nbsp;&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
					 
							$i=1;
							$thismonth=date('Y-m-00 00:00:00');
							foreach($paymenthistory as $key => $customers )
							// for($i = 0; $i < count($customers); ++$i)
							{
								
							?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $customers['dateCreated'];?></td>
									<td><?php echo $customers['invoice'];?></td>
									<td><?php  if($customers['transaction_type']==1){ echo "Cash";} else if($customers['transaction_type']==2){ echo "Check /DD";}else if($customers['transaction_type']==3){ echo "Adjustment";}else if($customers['transaction_type']==4){ echo "Google pay";}else if($customers['transaction_type']==5){ echo "Phone pay";}else if($customers['transaction_type']==6){ echo "Paytm";};?></td>
									<td><?php echo $customers['amount_paid'];?></td>
									<td>
									<?php
									if($thismonth<=$customers['dateCreated']){
									if($paymentsE ==1){?><a  data-toggle="tooltip" data-placement="bottom"  title="Reverse Payment" href="<?php echo base_url()?>customer/paymentEdit/<?php echo $customers['customer_id']?>/<?php echo $customers['payment_id'];?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;<?php }?>
									<!--<button title="Delete Payment" value="<?php echo $customers['payment_id'];?>" onclick="ShowConfirmYesNo(this.value)"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>-->
									<?php if($paymentsD ==1){
										
										?>
									<a  href="<?php echo base_url()?>customer/paymentDeleteView/<?php echo $customers['customer_id']?>/<?php echo $customers['payment_id'];?>/<?php echo $customers['amount_paid'];?>" title="Delete Payment" value="<?php echo $customers['payment_id'];?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
									
										<?php 
										}?></button>
									</td>
								</tr>
								<?php 
								  }
								$i++;
							}
								?>
							</tbody>
						</table>
					</div>
				<!-- /.box-body -->
				</div>
          <!-- /.box -->
			</div>
        <!-- /.col -->
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script>
	function ShowConfirmYesNo(){  
    alert(this.value);
}
</script>

    <script type="text/javascript">
        function ShowConfirmYesNo() {
            AsyncConfirmYesNo(
                    "Remarks",
                    '<textarea name="remarks" id="remarks" placeholder="Enter Remarks" class="form-control"></textarea>',
                    MyYesFunction,
                    MyNoFunction
                );
        }
        function MyYesFunction() {
			//window.location.href="dash.html";
			window.location.href="<?php echo base_url()?>customer/paymentDelete/<?php echo $customers['customer_id']?>/<?php echo $customers['payment_id']?>";
        }
        function MyNoFunction() {
            //alert("You pressed No");
           // $("#lblTestResult").html("You are not hungry");
		   $("#modalConfirmYesNo").modal("hide");
        }
        function AsyncConfirmYesNo(title, msg, yesFn, noFn) {
            var $confirm = $("#modalConfirmYesNo");
            $confirm.modal('show');
            $("#lblTitleConfirmYesNo").html(title);
            $("#lblMsgConfirmYesNo").html(msg);
            $("#btnYesConfirmYesNo").off('click').click(function () {
                yesFn();
            });
            $("#btnNoConfirmYesNo").off('click').click(function () {
                noFn();
            });
        }
    </script>
  <?php } else{ 
	 redirect('/');
  }?>