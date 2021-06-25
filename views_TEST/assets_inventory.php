<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Total Assets Inventory List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Inventory</a></li>
			<li class="active"><a  href="#">Total Assets Inventory</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Total Assets Inventory List</h3>
						<a  href="<?php echo base_url()?>excelsheet/assets_inventory" class="pull-right btn btn-primary">Export to Excel</a>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/assets_inventory">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="name" class="col-md-4 control-label">Item Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="name" name="name" placeholder="Item Name">
									</div>
								</div>
								<div class="col-md-3">
									<label for="item_number" class="col-md-4 control-label">Item Number</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="item_number" name="item_number" placeholder="Item Number">
									</div>
								</div>
								<div class="col-md-2">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>Sl.No</th>
								<th>Item Name</th>
								<th>Item Number</th>
								<th>Total Quantity</th>
								<th>Dealer Quantity</th>
								<th>Employee Quantity</th>
								<th>Customer Quantity</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($total_inv as $key => $total_inv_data)
							{
								$inv_ID=$total_inv_data['inv_id'];
								$invqry=mysql_query("select * from dealer_inward_qty where inv_id='$inv_ID'");
								$invres=mysql_fetch_assoc($invqry);
								//$emp_ID=$total_inv_data['inv_id'];
								$empqry=mysql_query("select * from dealer_outward_qty where inv_id='$inv_ID'");
								$empres=mysql_fetch_assoc($empqry);
								$cust_qry=mysql_query("select * from emp_inward_qty WHERE inv_id='$inv_ID'");
								$totCustInv=0;
								while($cust_res=mysql_fetch_assoc($cust_qry))
								{
									$totCustInv=$totCustInv+$cust_res['inward_qty'];
								}
							?>  
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $total_inv_data['name'];?></td>
								<td><?php echo $total_inv_data['item_number'];?></td>
								<td><?php echo ($invres['inward_qty']+$empres['outward_qty']+$totCustInv);?></td>
								<td><?php echo $invres['inward_qty'];?></td>
								<td><?php echo $empres['outward_qty'];?></td>
								<td><?php echo $totCustInv;?></td>
							</tr>
							<?php
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
  <?php } else{ 
	 redirect('/');
  }?>