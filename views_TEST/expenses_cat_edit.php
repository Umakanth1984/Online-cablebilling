<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($invA ==1) || ($invE ==1) || ($invV ==1) ||($invD ==1))
	{ ?>
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
	  <?php foreach($edit_expenses_cat as $key => $expenses ) { }	 ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses/expenses_cat_updated/<?php echo $expenses['exp_cat_id']?>"> 
        <!-- left column -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Expenses Category</h3>
            </div>
              <div class="box-body">
                <div class="form-group col-md-8">
                  <label for="name" class="col-sm-4 control-label">Item Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="catName" name="catName" placeholder="Expenses Item Name" value="<?php echo $expenses['catName'];?>" maxlength=30 required>
                  </div>
                </div>
				 
				 <div class="form-group col-md-4">
                   <div class="box-footer">
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
				  </div>
                </div>
              </div>
          </div>
        </div>
		</form>
      </div>
    </section>
  </div>
  <?php
	}
	else
	{ 
		redirect('/');
	}
	?> 