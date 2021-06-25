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
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses/expenses_cat_save"> 
        <!-- left column -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Expenses Category</h3>
            </div>
              <div class="box-body">
                <div class="form-group col-md-8">
                  <label for="name" class="col-sm-4 control-label">Item Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="catName" name="catName" placeholder="Expenses Item Name" maxlength=30 required>
                  </div>
                </div>
				 
				 <div class="form-group col-md-4">
                   <div class="box-footer">
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
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Expenses Categories</h3>
					</div>
					<!--<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-8">
									<label for="name" class="col-md-4 control-label">Item Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="name" name="name" maxlength=30 placeholder="Item Name">
									</div>
								</div>
								 
								<div class="col-md-4">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form> -->
					<div class="box-body">
					  <table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
						  <th>S.No</th>
						  <th>Item Name</th>
						  <th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
					   <?php
						$i=1;
						foreach($categories as $key => $expenses )
						{
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $expenses['catName']?></td>
								 
								<td><?php if($invE ==1){?><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>expenses/cat_edit/<?php echo $expenses['exp_cat_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }if($invD ==1){ ?><a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>expenses/cat_delete/<?php echo $expenses['exp_cat_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php } ?>
								</td>
							</tr>
						 <?php  
						$i++;
						}
						// while?>
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
  <?php
	}
	else
	{ 
		redirect('/');
	}
	?> 