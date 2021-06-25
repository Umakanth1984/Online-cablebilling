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
       Digital Cables  - Indent
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Indent</a></li>
        <li class="active"></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>indent/indent_save"> 
        <!-- left column -->
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Indent Details</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                  <div class="form-group col-md-12">
                  <label for="inv_id" class="col-sm-5 control-label">Select Inventory *</label>
                  <div class="col-sm-7">
						<select class="form-control" id="inv_id" name="inv_id" required >
						<option value="">Select Inventory</option>
						 
						<?php $sel_item=mysql_query("select * from inventory_items");
								while($row_item=mysql_fetch_assoc($sel_item)){
						?>
						<option value="<?php echo $row_item['inv_id']; ?>"><?php echo $row_item['name']; ?></option>
						<?php }?>
					  </select>
                  </div>
                </div>
				 <div class="form-group col-md-12">
					<label for="inward_qty" class="col-sm-5 control-label">Required Quantity</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="required_qty" name="required_qty" placeholder="Required Quantity No." maxlength=5 required>
					</div>
				</div>			  
				  <div class="form-group col-md-12">
					<label for="inward_qty" class="col-sm-5 control-label">Required On</label>
					<div class="col-sm-7">
						<input type="date" class="form-control" id="required_date" name="required_date" placeholder="Required Date." required>
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
		<div class="col-xs-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Indent Items</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <!--<th>Id #</th> -->
                  <th>Inventory Id</th>
				  <th>Inventory Name</th>
                  <th>Quantity</th>		
				  <th>Required On</th>				  
				  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
			   	foreach($indents as $key => $indent )
				{		
					 $sel_qty=mysql_fetch_assoc(mysql_query("SELECT * FROM inventory_items WHERE inv_id=".$indent['inv_id']));
					
					?>
					 <tr>
						<td><?php echo $indent['inv_id']?></td> 
						<td><?php echo $sel_qty['name']?></td>
						<td><?php echo $indent['required_qty']?></td>
						<td><?php echo $indent['required_date']?></td>
						<td><?php if($indent['status'] == 1){ echo "Assigned";}?><?php if($indent['status'] == 0){ ?><a  href="<?php echo base_url()?>indent/indent_updated/<?php echo $indent['indent_id']?>">Assign</a><?php } ?></td>
					</tr>
				<?php } // while?>
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