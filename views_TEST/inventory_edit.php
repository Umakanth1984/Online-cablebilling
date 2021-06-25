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
       Digital Cables  - Inventory Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Inventory</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	  <?php foreach($edit_inventory as $key => $inventory ) { }	 ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="itemsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>inventory/inventory_updated/<?php echo $inventory['inv_id']?>"> 
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Inventory Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="name" class="col-sm-4 control-label">Item Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $inventory['name'];?>" placeholder="Inventory Item Name" required>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="item_number" class="col-sm-4 control-label">Item Number</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="item_number" name="item_number" value="<?php echo $inventory['item_number'];?>" placeholder="Inventory Item Number" required>
					</div>
				</div>			  
				 <div class="form-group col-md-6">
                  <label for="item_price" class="col-sm-4 control-label">Price Per Unit</label>
				   <div class="col-sm-8">
					 <input type="text" class="form-control" id="item_price" name="item_price" value="<?php echo $inventory['item_price'];?>" placeholder="Item Price Per Unit" required>
				  </div>
                </div>
				 <div class="form-group col-md-6">
                   <div class="box-footer">
						<!-- <button type="submit" class="btn btn-default">Cancel</button> -->
						<button type="submit" id="itemEdit" name="itemEdit" class="btn btn-info pull-right">Update</button>
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

    	
    	
            