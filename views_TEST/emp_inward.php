<?php
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids'];
?>
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
    <section class="content-header">
      <h1>
       Digital Cables  - Employee Inward Inventory Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Employee Inward Inventory</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
        <!-- left column -->
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
				  <h3 class="box-title">Employee Inventory List</h3>
				</div>
				<table id="example2" class="table table-bordered table-hover">
					<thead>
					<tr>
					  <th>Emp Name</th>
					  <th>Item Name</th>
					  <th>Item Number</th>
					  <th>Quantity</th>
					</tr>
					</thead>
					<tbody>
				   <?php 
					//	echo "select * from dealer_outward_qty where emp_id=1";
						 $chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
						 if($chkEmpType['user_type']==1){
							 $sel_inward_item=mysql_query("select * from dealer_outward_qty");
						 }else{
							$sel_inward_item=mysql_query("select * from dealer_outward_qty where emp_id=$emp_id");
						 }
						while($res_inward_item=mysql_fetch_assoc($sel_inward_item)){
							$sel_item=mysql_fetch_assoc(mysql_query("select * from inventory_items where inv_id=".$res_inward_item['inv_id']));
							$sel_emp=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=".$res_inward_item['emp_id']));
					?>
					 <tr>
						 <td><?php echo $sel_emp['emp_first_name']." ".$sel_emp['emp_last_name']?></td>
						  <td><?php echo $sel_item['name'];?></td>
						   <td><?php echo $sel_item['item_number'];?></td>
						  <td><?php echo $res_inward_item['outward_qty']?></td>
					</tr> 
					<?php  } //while ?>
					</tbody>
				  </table>
			</div>
		</div>
        <div class="col-md-6">
		<form id="empInwardForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>emp_inward/emp_inward_save"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Employee Outward Inventory Details</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
				<div class="form-group col-md-12">
                  <label for="emp_id" class="col-sm-5 control-label">Choose Customers *</label>
                  <div class="col-sm-7">
						<select class="form-control select2" id="customer_id" name="customer_id" required>
							<option value="">Select Customer </option>
							<?php $sel_cust=mysql_query("select * from customers where group_id IN ($grp_ids)");
									while($row_item1=mysql_fetch_assoc($sel_cust)){
							?>
							<option value="<?php echo $row_item1['cust_id']; ?>"><?php echo $row_item1['first_name']." ".$row_item1['last_name']; ?></option>
							<?php }?>
					  </select>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label for="inv_id" class="col-sm-5 control-label">Inventory Item Name *</label>
                  <div class="col-sm-7">
						<select class="form-control" id="inv_id" name="inv_id" required>
							<option value="">Select Item</option>
							<?php //$sel_item=mysql_query("select * from inventory_items");
									//$sel_inward_item1=mysql_query("select * from dealer_outward_qty where emp_id=$emp_id");
									$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
									 if($chkEmpType['user_type']==1){
										 $sel_inward_item1=mysql_query("select * from dealer_outward_qty");
									 }else{
										$sel_inward_item1=mysql_query("select * from dealer_outward_qty where emp_id=$emp_id");
									 }
									while($res_inward_item1=mysql_fetch_assoc($sel_inward_item1)){
										$sel_item=mysql_query("select * from inventory_items where inv_id=".$res_inward_item1['inv_id']);
									
									while($row_item=mysql_fetch_assoc($sel_item)){
							?>
							<option value="<?php echo $row_item['inv_id']; ?>"><?php echo $row_item['name']; ?></option>
							<?php }
									}?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-12">
					<label for="Outward_qty" class="col-sm-5 control-label">Quantity No.</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="inward_qty" name="inward_qty" placeholder=" Quantity No." maxlength=5 required>
					</div>
				</div>			  
				 <div class="form-group col-md-12">
					<label for="Outward_qty" class="col-sm-5 control-label">Remarks</label>
					<div class="col-sm-7">
						<textarea class="form-control" id="inward_remarks" name="inward_remarks" placeholder=" Enter Remarks" required></textarea>
					</div>
				</div>	
				 <div class="form-group col-md-12">
                   <div class="box-footer">
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				  </div>
                </div>
              </div>
          </div>
		  	</form>
        </div>
      </div>
	  <!-- Group List Starts Here -->
	  <div class="row">
		<div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee Outward Inventory List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>Id #</th>
				  <th>Customer Name</th>
                  <th>Item Name</th>
				   <th>Item Number</th>
				  <th>Quantity</th>
				 <!-- <th>&nbsp;</th> -->
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
						  <td><?php echo $res_inward_item['name'];?></td>
						  <td><?php echo $res_inward_item['item_number'];?></td>
						  <td><?php echo $inventory['inward_qty']?></td>
						 <!-- <td><a  href="<?php echo base_url()?>emp_inward/edit/<?php echo $inventory['emp_inward_id']?>">Edit</a> &nbsp;&nbsp;
							<a  href="<?php echo base_url()?>emp_inward/delete/<?php echo $inventory['emp_inward_id']?>" onclick="return ConfirmDialog();">Delete</a> &nbsp;&nbsp;
						  </td> -->
					</tr>
				 
						
				 <?php  
				} // while?>
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
 
        </div>
		
		  <div class="col-md-6">
		 <form id="empOutswardForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>emp_inward/emp_inward_return"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Employee Inward Inventory Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
				<div class="form-group col-md-12">
                  <label for="emp_id" class="col-sm-5 control-label">Choose Customers *</label>
                  <div class="col-sm-7">
				 
						<select class="form-control select2"  style="width: 100%; id="customer_id" name="customer_id" >
							<option value="">Select Customer </option>
							 
							<?php $sel_cust=mysql_query("select * from customers where group_id IN ($grp_ids)");
									while($row_item1=mysql_fetch_assoc($sel_cust)){
							?>
							<option value="<?php echo $row_item1['cust_id']; ?>"><?php echo $row_item1['first_name']." ".$row_item1['last_name']; ?></option>
							<?php }?>
					  </select>
                  </div>
                </div>
				
                <div class="form-group col-md-12">
                  <label for="inv_id" class="col-sm-5 control-label">Inventory Item Name *</label>
                  <div class="col-sm-7">
						<select class="form-control" id="inv_id" name="inv_id" >
							<option value="">Select Item</option>
							 
							<?php //$sel_item=mysql_query("select * from inventory_items");
									//$sel_inward_item1=mysql_query("select * from dealer_outward_qty where emp_id=1");
									//$sel_inward_item1=mysql_query("select * from dealer_outward_qty");
									$chkEmpType=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
									 if($chkEmpType['user_type']==1){
										 $sel_inward_item1=mysql_query("select * from dealer_outward_qty");
									 }else{
										$sel_inward_item1=mysql_query("select * from dealer_outward_qty where emp_id=$emp_id");
									 }
									while($res_inward_item1=mysql_fetch_assoc($sel_inward_item1)){
										$sel_item=mysql_query("select * from inventory_items where inv_id=".$res_inward_item1['inv_id']);
									
									while($row_item=mysql_fetch_assoc($sel_item)){
							?>
							<option value="<?php echo $row_item['inv_id']; ?>"><?php echo $row_item['name']; ?></option>
							<?php }
									}?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-12">
					<label for="Outward_qty" class="col-sm-5 control-label">Quantity No.</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="outward_qty" name="outward_qty" placeholder=" Quantity No." maxlength=5 required>
					</div>
				</div>			  
				 <div class="form-group col-md-12">
					<label for="Outward_qty" class="col-sm-5 control-label">Remarks</label>
					<div class="col-sm-7">
						<textarea class="form-control" id="outward_remarks" name="outward_remarks" placeholder=" Enter Remarks" required></textarea>
					</div>
				</div>	
				 <div class="form-group col-md-12">
                   <div class="box-footer">
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				  </div>
                </div>
              </div>
          </div>
		</form>
	   </div>
	  </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>