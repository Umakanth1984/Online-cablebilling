<?php //$this->load->view('website_template/header');?>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
    return true;
  } else {
    return false;
  }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Employee Inward Inventory Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Inventory</a></li>
        <li class="active">Employee Inward Inventory</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php foreach($edit_inventory as $key => $edit_inward )
			{
			} 
		?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>emp_inward/emp_inward_updated/<?php echo $edit_inward['emp_inward_id'];?>"> 
        <!-- left column -->
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Employee Inward Inventory Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
				<div class="form-group col-md-6">
                  <label for="emp_id" class="col-sm-4 control-label">Choose Customers *</label>
                  <div class="col-sm-8">
						<select class="form-control select2" id="customer_id" name="customer_id" >
							<option value="">Select Customer </option>
							 
							<?php $sel_cust=mysql_query("select * from customers");
									while($row_item1=mysql_fetch_assoc($sel_cust)){
							?>
							<option value="<?php echo $row_item1['cust_id']; ?>"><?php echo $row_item1['first_name']." ".$row_item1['last_name']; ?></option>
							<?php }?>
						</select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inv_id" class="col-sm-4 control-label">Inventory Item Name *</label>
                  <div class="col-sm-8">
						<select class="form-control" id="inv_id" name="inv_id" >
							<option value="">Select Item</option>
							 
							<?php $sel_item=mysql_query("select * from inventory_items");
									while($row_item=mysql_fetch_assoc($sel_item)){
							?>
							<option value="<?php echo $row_item['inv_id']; ?>"><?php echo $row_item['name']; ?></option>
							<?php }?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-4 control-label">Quantity No.</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php echo $edit_inward['inward_qty'];?>" id="inward_qty" name="inward_qty" placeholder=" Quantity No." required>
					</div>
				</div>			  
				 <div class="form-group col-md-6">
					<label for="inward_remarks" class="col-sm-4 control-label">Remarks</label>
					<div class="col-sm-8">
						<textarea class="form-control" id="inward_remarks" name="inward_remarks" placeholder=" Enter Remarks" ><?Php echo $edit_inward['remarks'];?></textarea>
					</div>
				</div>	
				<div class="form-group col-md-6">
					<div class="box-footer">
						<!-- <button type="submit" class="btn btn-default">Cancel</button> -->
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
					</div>
                </div>
              </div>
          </div>
        </div>
		<div class="col-md-4">
			<div class="box-header with-border">
				<h3 class="box-title">Employee Inventory List</h3>
            </div>
		<table id="example2" class="table table-bordered table-hover">
                <thead>
					<tr>
						<th>Emp Name</th>
						<th>Item Name</th>
						<th>Quantity</th>
					</tr>
                </thead>
                <tbody>
               <?php 
					$sel_inward_item=mysql_query("select * from dealer_inward_qty where emp_id='1'");
					while($res_inward_item=mysql_fetch_assoc($sel_inward_item)){
						$sel_item=mysql_fetch_assoc(mysql_query("select * from inventory_items where inv_id=".$res_inward_item['inv_id']));
						$sel_emp=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=".$res_inward_item['emp_id']));
				?>
				<tr>
					<td><?php echo $sel_emp['emp_first_name']." ".$sel_emp['emp_last_name']?></td>
					<td><?php echo $sel_item['name']?></td>
					<td><?php echo $res_inward_item['inward_qty']?></td>
				</tr> 
				<?php  } echo mysql_error();//while ?>
                </tbody>
        </table>
		</div>
        <!--/.col (left) -->
		</form>
		
      </div>
	  <!-- Group List Starts Here -->
	  <div class="row">
		<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee Inward Inventory List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>Id #</th>
				  <th>Customer Name</th>
                  <th>Item Name</th>
				  <th>Quantity</th>
				  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
			   	foreach($inventories as $key => $inventory )
				{		
					 $sel_inward_item=mysql_query("select * from inventory_items where inv_id=".$inventory['inv_id']);
					 $res_inward_item=mysql_fetch_assoc($sel_inward_item);
					 $sel_emp=mysql_query("select * from  customers where cust_id=".$inventory['customer_id']);
					 $res_emp=mysql_fetch_assoc($sel_emp);
					 
					?>
						<tr>
							<td><?php echo $inventory['emp_inward_id']?></td>
							<td><?php echo $res_emp['first_name']." ".$res_emp['last_name']?></td>
							<td><?php echo $res_inward_item['name']?></td>
							<td><?php echo $inventory['inward_qty']?></td>
							<td><a  href="<?php echo base_url()?>emp_inward/edit/<?php echo $inventory['emp_inward_id']?>">Edit</a> &nbsp;&nbsp;
							<a  href="<?php echo base_url()?>emp_inward/delete/<?php echo $inventory['emp_inward_id']?>" onclick="return ConfirmDialog();">Delete</a> &nbsp;&nbsp;
							</td>
						</tr>
				 <?php  
				} // while?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
	  </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>