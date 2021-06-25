<?php 
 	 
 if($cust_id !=''){ ?>
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
					  <h3 class="box-title">Payment Datails of <?php echo $custRes['first_name'];?></h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer_dashboard/paymentHistory/<?php echo $cust_id;?>">
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
									<th>Paid to</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($transactionslist as $key => $customers )
							// for($i = 0; $i < count($customers); ++$i)
							{
								$selEmp=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=".$customers['emp_id']));
							?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $customers['dateCreated'];?></td>
									<td><?php echo $customers['invoice'];?></td>
									<td><?php if($customers['transaction_type']==1){echo "Cash";}else{ echo "Online";}?></td>
									<td><?php echo $customers['amount_paid'];?></td>
									<td><?php echo $selEmp['emp_first_name'].' '.$selEmp['emp_last_name'];?></td>
									 
									<!--
									<form method="post" action="">
										<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customers['customer_id'];?>">
										<input type="hidden" name="payment_id" id="payment_id" value="<?php echo $customers['payment_id'];?>">
										<div id="modalConfirmYesNo" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 id="lblTitleConfirmYesNo" class="modal-title">Remarks</h4>
													</div>
													<div class="modal-body">
														<div id="lblMsgConfirmYesNo"></div>
													</div>
													<div class="modal-footer">
														<button id="btnYesConfirmYesNo" type="button" value="<?php echo $customers['payment_id'];?>" onclick='f1(this)' class="btn btn-primary">Yes</button>
														<button id="btnNoConfirmYesNo" type="button" class="btn btn-default">No</button>
													</div>
												</div>
											</div>
										</div>
									</form>
									-->
								</tr>
								<?php 
								// }
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