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
<style>
.btn-info {
    background-color: GREEN;
    border-color: #00acd6;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Dealer Inward Quantity Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Inventory</a></li>
        <li class="active">Edit Dealer Inward Quantity</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php
	 
			   	foreach($edit_inventory as $key => $inventory )
				{		
				}
					?>
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>dealer_inward/dealer_inward_updated/<?php echo $inventory['dealer_inv_id'];?>"> 
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Dealer Inward Quantity</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="inv_id" class="col-sm-4 control-label">Inventory Item Name *</label>
                  <div class="col-sm-8">
						<select class="form-control" id="inv_id" name="inv_id"  required>
						<option value="">Select Item</option>
						 
						<?php $sel_item=mysql_query("select * from inventory_items");
								while($row_item=mysql_fetch_assoc($sel_item)){
						?>
						<option value="<?php echo $row_item['inv_id']; ?>"  <?php if($row_item['inv_id'] == $inventory['inv_id']){?> selected <?php }?>><?php echo $row_item['name']; ?></option>
						<?php }?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-4 control-label">Inward Quantity No.</label>
					<div class="col-sm-8">
						<input type="number" min="1" max="9999" class="form-control" id="inward_qty" name="inward_qty" value="<?php echo $inventory['inward_qty'];?>" placeholder="Inward Quantity No." required>
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
        <!--/.col (left) -->
		</form>
		
      </div>
	  <!-- Group List Starts Here -->
	  
              
				 
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

    	
    	
            