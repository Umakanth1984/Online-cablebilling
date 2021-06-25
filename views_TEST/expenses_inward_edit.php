<?php 
	$empQry=mysql_query("select user_type from employes_reg where emp_id='$emp_id'");
	$empRes=mysql_fetch_assoc($empQry);
	if($empRes['user_type']==1)
	{
?>
<style>
.btn-info {
    background-color: GREEN;
    border-color: #00acd6;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Expenses Management</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Expenses</a></li>
			<li class="active">Edit Expenses</li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<?php foreach($edit_expenses as $key => $expenses ){}?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses_inward/expenses_inward_updated/<?php echo $expenses['exp_inv_id'];?>">
      <div class="row"> 
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
				<h3 class="box-title">Edit Expenses</h3>
            </div>
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="exp_id" class="col-sm-5 control-label">Expenses Item Name *</label>
                  <div class="col-sm-7">
						<select class="form-control" id="exp_id" name="exp_id" required>
						<option value="">Select Item</option>
						<?php $sel_item=mysql_query("select * from expenses_items where admin_id='$adminId'");
								while($row_item=mysql_fetch_assoc($sel_item)){
						?>
						<option value="<?php echo $row_item['exp_id']; ?>"  <?php if($row_item['exp_id'] == $expenses['exp_id']){?> selected <?php }?>><?php echo $row_item['name']; ?></option>
						<?php }?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Price</label>
					<div class="col-sm-7">
						<input type="number" min="1" max="999999" class="form-control" id="inward_qty" name="inward_qty" value="<?php echo $expenses['inward_qty'];?>" placeholder="Price in Rs." required>
					</div>
				</div>	
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Receipt No</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="receipt_no" name="receipt_no" placeholder="Enter Receipt No." value="<?php echo $expenses['receipt_no'];?>">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Booking Date</label>
					<div class="col-sm-7">
						<input type="date" class="form-control" id="receipt_date" name="receipt_date" placeholder="Date" value="<?php echo $expenses['receipt_date'];?>">
					</div>
				</div>				
				 <div class="form-group col-md-6">
                  <label for="name" class="col-sm-5 control-label">Remarks *</label>
                  <div class="col-sm-7">
                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Expenses Remarks" required><?php echo $expenses['remarks'];?></textarea>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<div class="box-footer">
						<button type="submit" id="expenseSubmit" name="expenseSubmit" class="btn btn-info pull-right">Update</button>
					</div>
                </div>
              </div>
          </div>
        </div>
      </div>
		</form>
    </section>
  </div>
<?php 
	}
	else
	{ 
		redirect('/');
	}
?>