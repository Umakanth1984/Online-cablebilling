<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Customer Inventory List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Inventory</a></li>
			<li class="active"><a  href="#">Customer Inventory</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Customer Inventory List</h3>
						<a  href="<?php echo base_url()?>excelsheet/customer_inventory" class="pull-right btn btn-primary">Export to Excel</a>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/customer_inventory">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="first_name" class="col-md-4 control-label">Customer Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Customer Name">
									</div>
								</div>
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
								<th>Customer Name</th>
								<th>Employee Name</th>
								<th>Item Name</th>
								<th>Item Number</th>
								<th>Quantity</th>
								<th>Total Value</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($cust_inv as $key => $cust_inv_data)
							{
								$cust_ID=$cust_inv_data['customer_id'];
								$custqry=mysql_query("select * from customers where cust_id='$cust_ID'");
								$custres=mysql_fetch_assoc($custqry);
								$inv_ID=$cust_inv_data['inv_id'];
								$invqry=mysql_query("select * from inventory_items where inv_id='$inv_ID'");
								$invres=mysql_fetch_assoc($invqry);
								$emp_ID=$cust_inv_data['emp_id'];
								$emp_qry=mysql_query("select * from employes_reg where emp_id='$emp_ID'");
								$emp_res=mysql_fetch_assoc($emp_qry);
							?>  
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $custres['first_name'];?></td>
								<td><?php echo $emp_res['emp_first_name']." ".$emp_res['emp_last_name'];?></td>
								<td><?php echo $invres['name'];?></td>
								<td><?php echo $invres['item_number'];?></td>
								<td><?php echo $cust_inv_data['inward_qty'];?></td>
								<td><?php echo ($invres['item_price']*$cust_inv_data['inward_qty']);?></td>
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