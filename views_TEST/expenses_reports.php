<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1))
{
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Expenses List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Expenses</a></li>
			<li class="active"><a  href="#">Expenses</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				    <h3 class="box-title">Expenses Report</h3>
                    <form id="expenseExport" name="expenseExport" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>excelsheet/export_expenses">
                        <input type="hidden" class="form-control" id="receipt_date" name="receipt_date" <?php if(isset($_REQUEST['receipt_date']) && $_REQUEST['receipt_date']!=''){?> value="<?php echo $_REQUEST['receipt_date']; ?>" <?php } ?>>
                        <input type="hidden" class="form-control" id="to_date" name="to_date" <?php if(isset($_REQUEST['to_date']) && $_REQUEST['to_date']!=''){?> value="<?php echo $_REQUEST['to_date']; ?>" <?php } ?>>
                        <input type="submit" value="Export to Excel" name="submit11" id="submit11" class="btn btn-primary pull-right"/>
                    </form>
				</div>
				<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/expenses">
					<div class="box-body">
					<div class="form-group">
								<div class="col-md-4">									
									<div class="col-md-12">										
									<input type="date" class="form-control" id="receipt_date" name="receipt_date" value="<?php echo $_REQUEST['receipt_date']; ?>" placeholder="By Booking Date">
									</div>
								</div>
								<div class="col-md-4">									
									<div class="col-md-12">										
									<input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo $_REQUEST['to_date']; ?>" placeholder="By Booking Date">
									</div>
								</div>								
								<!--<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="exp_id" name="exp_id">
											<option value="">Select Category</option>
						 					<?php $sel_item=mysql_query("select * from expenses_items");
													while($row_item=mysql_fetch_assoc($sel_item)){
											?>
											<option value="<?php echo $row_item['exp_id']; ?>"><?php echo $row_item['name']; ?></option>
											<?php }?>
										</select>
									</div>
								</div> -->
								<div class="col-md-1">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
				<!-- /.box-header -->
				<div class="box-body col-md-12">
				<div class=" col-md-4">
				<h3> Payment Receipts</h3>
					<table id="example21" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Date</th>
							<th>Amount Collected</th>
						</tr>
						</thead>
						<tbody>
						<?php
                        $Cdate=date('Y-m-00 00:00:00');
						$frmDate=$_REQUEST['receipt_date'];
						$toDate=$_REQUEST['to_date'];
						$i=1;
						$totalColl='';
						if($frmDate!='' && $toDate!=''){
						    $cust_payments= mysql_query("SELECT LEFT(dateCreated, 10) month, SUM(amount_paid) as amount FROM payments  WHERE  dateCreated BETWEEN '$frmDate' AND '$toDate' GROUP BY month") ;	
						}
						else{
						    $cust_payments= mysql_query("SELECT LEFT(dateCreated, 10) month, SUM(amount_paid) as amount FROM payments  WHERE  dateCreated >= '$Cdate' GROUP BY month") ;
						}
						while($resCust1=mysql_fetch_assoc($cust_payments))
						{
							?>  
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $resCust1['month'];?></td>
								<td style="text-align:right"><?php echo $resCust1['amount'];?></td>
							</tr>
							<?php
								$i++;
								$totalColl+=$resCust1['amount'];
						 }
						?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="13" align="right">Total Collections : <b style="color:red;">Rs. <?php echo $totalColl;?></b></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<div class=" col-md-8">
				<h3>Expenses </h3>
					<table id="example22" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>S.No</th>
							<th>Category</th>
							<th>Name</th>
							<th>Receipt No</th>
							<th>Booking Date</th>
							<th>Remarks</th>
							<th>Price</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;$totalExp=0;
						foreach($getExp as $key => $row_item)
						{
							$totalExp=$totalExp+$row_item['inward_qty'];
							$sel_inward_item=mysql_query("select name,exp_cat_id from expenses_items where exp_id=".$row_item['exp_id']);
							$res_inward_item=mysql_fetch_assoc($sel_inward_item);
							$sel_exp_cat=mysql_query("select catName from expenses_cat where exp_cat_id=".$res_inward_item['exp_cat_id']);
							$res_exp_cat=mysql_fetch_assoc($sel_exp_cat);
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo ucwords($res_exp_cat['catName']);?></td>
							<td><?php echo ucwords($res_inward_item['name']);?></td>
							<td><?php echo ucwords($row_item['receipt_no']);?></td>
							<td><?php echo ucwords($row_item['receipt_date']);?></td>
							<td><?php echo ucwords($row_item['remarks']);?></td>
							<td><?php echo $row_item['inward_qty'];?></td>
						</tr>
						<?php
							$i++;
						}
						?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="13" align="right">Total Expenses : <b style="color:red;">Rs. <?php echo $totalExp;?></b></td>
							</tr>
						</tfoot>
					</table>
				</div>
            <!-- /.box-body -->
				</div>
			</div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
		</div>
      <!-- /.row -->
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo $pagination; ?>
			</div>
		</div>
    </section>
    <!-- /.content -->
</div>
  <?php } else{ 
	 redirect('/');
  }?>  