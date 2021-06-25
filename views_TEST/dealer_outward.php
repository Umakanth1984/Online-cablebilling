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
       Digital Cables  - Dealer Outward Quantity Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Inventory</a></li>
        <li class="active">Dealer Outward Quantity</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>dealer_outward/dealer_outward_save"> 
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Dealer Outward Quantity Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
				<div class="form-group col-md-6">
                  <label for="emp_id" class="col-sm-4 control-label">Choose Employee *</label>
                  <div class="col-sm-8">
						<select class="form-control" id="emp_id" name="emp_id"  required>
							<option value="">Select </option>
							 
							<?php $sel_item1=mysql_query("select * from employes_reg");
									while($row_item1=mysql_fetch_assoc($sel_item1)){
							?>
							<option value="<?php echo $row_item1['emp_id']; ?>"><?php echo $row_item1['emp_first_name']." ".$row_item1['emp_last_name']; ?></option>
							<?php }?>
					  </select>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="inv_id" class="col-sm-4 control-label">Inventory Item Name *</label>
                  <div class="col-sm-8">
						<select class="form-control" id="inv_id" name="inv_id"  required>
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
					<label for="inward_qty" class="col-sm-4 control-label">Outward Quantity No.</label>
					<div class="col-sm-8">
						<input type="number" min="1" max="99999"  class="form-control" id="outward_qty" name="outward_qty" placeholder="Inward Quantity No." required>
					</div>
				</div>			  
				 
				 <div class="form-group col-md-6">
                   <div class="box-footer">
						<!-- <button type="submit" class="btn btn-default">Cancel</button> -->
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				  </div>
                </div>
              </div>
          </div>
        </div>
        <!--/.col (left) -->
		</form>
		
      </div>
	  <!-- Group List Starts Here -->
	  <div class="row">
		<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Dealer Outward Quantity List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>Id #</th>
				  <th>Employee Name</th>
                  <th>Item Name</th>
				  <th>Quantity</th>
				  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
			   	foreach($inventories as $key => $inventory )
				{		
					 $sel_outward_item=mysql_query("select * from inventory_items where inv_id=".$inventory['inv_id']);
					 $res_outward_item=mysql_fetch_assoc($sel_outward_item);
					 $sel_emp=mysql_query("select * from employes_reg where emp_id=".$inventory['emp_id']);
					 $res_emp=mysql_fetch_assoc($sel_emp);
					 
					?>
					 <tr>
						  <td><?php echo $inventory['dealer_outward_id']?></td>
						  <td><?php echo $res_emp['emp_first_name']." ".$res_emp['emp_last_name']?></td>
						  <td><?php echo $res_outward_item['name']?></td>
						  <td><?php echo $inventory['outward_qty']?></td>
						 <td><a  href="<?php echo base_url()?>dealer_outward/edit/<?php echo $inventory['dealer_outward_id']?>">Edit</a> &nbsp;&nbsp;
							<a  href="<?php echo base_url()?>dealer_outward/delete/<?php echo $inventory['dealer_outward_id']?>" onclick="return ConfirmDialog();">Delete</a> &nbsp;&nbsp;
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

    	
    	
            