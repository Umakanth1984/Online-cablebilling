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
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>inventory/inventory_save"> 
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Inventory Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="name" class="col-sm-4 control-label">Item Name *</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Inventory Item Name" maxlength=30 required>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="item_number" class="col-sm-4 control-label">Item Number</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="item_number" name="item_number" placeholder="Inventory Item Number" required maxlength=10>
					</div>
				</div>			  
				<div class="form-group col-md-6">
                  <label for="item_price" class="col-sm-4 control-label">Price Per Unit</label>
				   <div class="col-sm-8">
					 <input type="text" class="form-control" id="item_price" name="item_price" maxlength=4 placeholder="Item Price Per Unit" required>
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
					  <h3 class="box-title">Inventory List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>inventory">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="name" class="col-md-4 control-label">Item Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="name" name="name" maxlength=30 placeholder="Item Name">
									</div>
								</div>
								<div class="col-md-3">
									<label for="item_number" class="col-md-4 control-label">Item Number</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="item_number" name="item_number" maxlength=10 placeholder="Item Number">
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
						  <th>Id #</th>
						  <th>Item Name</th>
						  <th>Item Number</th>
						  <th>Price Per Unit</th>
						  <th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
					   <?php
						foreach($inventories as $key => $inventory )
						{
							?>
							<tr>
								<td><?php echo $inventory['inv_id']?></td>
								<td><?php echo $inventory['name']?></td>
								<td><?php echo $inventory['item_number']?></td>
								<td><?php echo $inventory['item_price']?></th>
								<td><?php if($invE ==1){?><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>inventory/edit/<?php echo $inventory['inv_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }if($invD ==1){ ?><a  data-toggle="tooltip" data-placement="bottom"  title="Delete" href="<?php echo base_url()?>inventory/delete/<?php echo $inventory['inv_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php } ?>
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
  <?php
	}
	else
	{ 
		redirect('/');
	}
	?> 