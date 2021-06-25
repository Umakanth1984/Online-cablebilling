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
       Digital Cables  - Expenses Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Expenses</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		<?php foreach($edit_expenses as $key => $expenses ) { }	 ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="itemsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses/expenses_updated/<?php echo $expenses['exp_id']?>"> 
        <!-- left column -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Expenses Details</h3>
            </div>
              <div class="box-body">
				<div class="form-group col-md-12">
                  <label for="name" class="col-sm-4 control-label">Category *</label>
                  <div class="col-sm-8">
					<select class="form-control js-example-basic-single" id="exp_cat_id" name="exp_cat_id" data-live-search="true" required>
						<option value="">Select Category</option>
						<?php  
						$getCat=mysql_query("select * from expenses_cat where admin_id='$adminId'");
						while($getRes=mysql_fetch_assoc($getCat))
						{
						?>  
						<option data-tokens="<?php echo $getRes['catName'];?>" value="<?php echo $getRes['exp_cat_id'];?>" <?php if($expenses['exp_cat_id'] == $getRes['exp_cat_id']){;?> selected <?php }?>><?php echo $getRes['catName'];?></option>
						<?php
						}
						?>
					</select>
                  </div>
                </div>
                <div class="form-group col-md-12">
                  <label for="name" class="col-sm-4 control-label">Item Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $expenses['name'];?>" placeholder="expenses Item Name" required>
                  </div>
                </div>
			 
				 <div class="form-group col-md-12">
                   <div class="box-footer">
						<button type="submit" id="itemEdit" name="itemEdit" class="btn btn-info pull-right">Update</button>
				  </div>
                </div>
              </div>
          </div>
        </div>
		</form>
      </div>
    </section>
  </div>