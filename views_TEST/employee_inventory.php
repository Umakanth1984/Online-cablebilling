<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Employee Inventory List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Inventory</a></li>
			<li class="active"><a  href="#">Employee Inventory</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Inventory List</h3>
						<a  href="<?php echo base_url()?>excelsheet/employee_inventory" class="pull-right btn btn-primary">Export to Excel</a>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/employee_inventory">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="emp_first_name" class="col-md-4 control-label">Employee Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="emp_first_name" name="emp_first_name" placeholder="Employee Name">
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
							$totQty=0;
							$totVal=0;
							foreach($emp_inv as $key => $emp_inv_data)
							{
								
								$emp_ID=$emp_inv_data['emp_id'];
								$empqry=mysql_query("select * from employes_reg where emp_id='$emp_ID'");
								$empres=mysql_fetch_assoc($empqry);
								$inv_ID=$emp_inv_data['inv_id'];
								$invqry=mysql_query("select * from inventory_items where inv_id='$inv_ID'");
								$invres=mysql_fetch_assoc($invqry);
							?>  
							
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $empres['emp_first_name'];?></td>
								<td><?php echo $invres['name'];?></td>
								<td><?php echo $invres['item_number'];?></td>
								<td><?php echo $emp_inv_data['outward_qty'];?></td>
								<td><?php echo ($invres['item_price']*$emp_inv_data['outward_qty']);?></td>
							</tr>
							<?php
								$i++;
								$totQty=($emp_inv_data['outward_qty']+$totQty);
								$totVal=(($invres['item_price']*$emp_inv_data['outward_qty'])+$totVal);
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b style="color:red;">Total :<?php echo $totQty;?></b></td>
								<td><b style="color:red;">Rs. <?php echo $totVal;?></b></td>
							</tr>
							</tfoot>
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