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
       Digital Cables  - Expenses Management
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Expenses</a></li>
        <li class="active">Expenses Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
        <div class="col-md-12">
		 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>expenses_inward/expenses_inward_save"> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Expenses Details</h3>
            </div>
              <div class="box-body">
                <div class="form-group col-md-6">
                  <label for="exp_id" class="col-sm-5 control-label">Expenses Item Name *</label>
                  <div class="col-sm-7">
						<select class="form-control" id="exp_id" name="exp_id"  required>
						<option value="">Select Item</option>
						 
						<?php $sel_item=mysql_query("select * from expenses_items where admin_id='$adminId'");
								while($row_item=mysql_fetch_assoc($sel_item)){
						?>
						<option value="<?php echo $row_item['exp_id']; ?>"><?php echo $row_item['name']; ?></option>
						<?php }?>
					  </select>
                  </div>
                </div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Price.</label>
					<div class="col-sm-7">
						<input type="number" min="1" max="9999999"  class="form-control" id="inward_qty" name="inward_qty" placeholder="Price." maxlength=5 required>
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Receipt no.</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="receipt_no" name="receipt_no" placeholder="Enter Receipt no.">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="inward_qty" class="col-sm-5 control-label">Booking Date</label>
					<div class="col-sm-7">
						<input type="date" class="form-control" id="receipt_date" name="receipt_date" placeholder="Date">
					</div>
				</div>
				 <div class="form-group col-md-6">
                  <label for="name" class="col-sm-5 control-label">Remarks *</label>
                  <div class="col-sm-7">
                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Expenses Remarks" required></textarea>
                  </div>
                </div>
				 <div class="form-group col-md-6">
                   <div class="box-footer">
						<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
				  </div>
                </div>
              </div>
          </div>
		  </form>
        </div>
        <!--Outward -->
		 
      </div>
	  <!-- Group List Starts Here -->
	  <div class="row">
		<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Expenses List</h3>
            </div>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
				  <th>S.No</th>
				  <th>Category</th>
                  <th>Name</th>
				  <th>Receipt No</th>
				  <th>Booking Date</th>
				  <th>Remarks</th>
				  <th>Price</th>
				  <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
				$totalExp=0;
				$i=1;
			   	foreach($inventories as $key => $expenses )
				{		
					$totalExp=$totalExp+$expenses['inward_qty'];
					 $sel_inward_item=mysql_query("select * from expenses_items where exp_id=".$expenses['exp_id']);
					 $res_inward_item=mysql_fetch_assoc($sel_inward_item);
					  $sel_exp_cat=mysql_query("select * from expenses_cat where exp_cat_id=".$res_inward_item['exp_cat_id']);
					 $res_exp_cat=mysql_fetch_assoc($sel_exp_cat);
					?>
					 <tr>
						<td><?php echo $i;?></td>
						<td><?php echo ucwords($res_exp_cat['catName']);?></td>
						<td><?php echo ucwords($res_inward_item['name']);?></td>
						<td><?php echo ucwords($expenses['receipt_no']);?></td>
						<td><?php echo ucwords($expenses['receipt_date']);?></td>
						<td><?php echo ucwords($expenses['remarks']);?></td>
						<td><?php echo $expenses['inward_qty'];?></td>
						 <td><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>expenses_inward/edit/<?php echo $expenses['exp_inv_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;
							 <a  href="<?php echo base_url()?>expenses_inward/delete/<?php echo $expenses['exp_inv_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;  
						  </td>
					</tr>
				 <?php  
				$i++;
				} // while
				?>
					<tr>
						   <td><b>Total</b></td>
						   <td>&nbsp;</td>
						  <td>&nbsp;</td>
						   <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td><b><?php echo $totalExp;?></b></td>
						 <td>&nbsp;</td>
					</tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
		 
	  </div>
    </section>
  </div>