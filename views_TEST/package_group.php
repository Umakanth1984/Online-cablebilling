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
       Digital Cables  - Packages & Groups    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Packages & Groups</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>packages/group_packages_updated/"> 
        <!-- left column -->
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Packages & Groups Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
               
				<div class="form-group col-md-12">
					<label for="inputcustomername" class="col-sm-4 control-label">Group *</label>
					<div class="col-sm-8">
						<select class="form-control" id="group_id" name="group_id" required >
						<option value="">Select Group</option>
						<?php $sel_grp=mysql_query("select * from groups");
								while($row_grp=mysql_fetch_assoc($sel_grp)){
						?>
						<option value="<?php echo $row_grp['group_id']; ?>"><?php echo $row_grp['group_name']; ?></option>
						<?php }?>
					  </select>
					</div>
				</div>			  
				 <div class="form-group col-md-12">
					<label for="inputcustomername" class="col-sm-4 control-label">Packages *</label>
					<div class="col-sm-8">
						<select class="form-control" id="package_id" name="package_id" required>
						<option value="">Select Package</option>
						<?php $sel_grp=mysql_query("select * from packages");
								while($row_grp=mysql_fetch_assoc($sel_grp)){
						?>
						<option value="<?php echo $row_grp['package_id']; ?>"><?php echo $row_grp['package_name']; ?></option>
						<?php }?>
					  </select>
					</div>
				</div>	
				 <div class="form-group col-md-12">
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
		<div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Groups List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Group Name</th>
				  <th>Package Name</th>
                </tr>
                </thead>
                <tbody>
               <?php
			   	foreach($groups as $key => $group )
				{		
					//echo "SELECT * FROM groups WHERE is_parent=".$group['group_id'];
					$chk_grp=mysql_fetch_assoc(mysql_query("SELECT * FROM groups WHERE group_id=".$group['group_id']));
					$chk_pkg=mysql_fetch_assoc(mysql_query("SELECT * FROM packages WHERE package_id=".$group['package_id']));
					 
					?>
					 <tr>
					    <td><?php echo $chk_grp['group_name']?></td>
						<td><?php echo $chk_pkg['package_name']?></td>
					</tr>
					 
			 
				<?php } // while?>
                </tbody>
                <tfoot>
               
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
 
        </div>
      </div>
	  <!-- Group List Starts Here -->
	  <div class="row">
		
	  </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

    	
    	
            