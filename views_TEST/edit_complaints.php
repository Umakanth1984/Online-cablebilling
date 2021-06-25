<div class="content-wrapper">
    <section class="content-header">
      <h1>Digital Cables  - Edit Complaint </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Complaint</a></li>
        <li class="active">Edit Complaint</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php foreach($edit_complaints as $key => $complaints ){}?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>complaints/complaints_updated/<?php echo $complaints['complaint_id']?>"> 
	 <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
	 <input type="hidden" name="cust_id" id="cust_id" value="<?php echo $complaints['customer_id']; ?>">
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Complaint Details</h3>
            </div>
			<?php
				$cust_id=$complaints['customer_id'];
				$comp_qry=mysql_query("select * from customers where cust_id='$cust_id'");
				$comp_res=mysql_fetch_assoc($comp_qry);
			?>
            <div class="box-body">
				<div class="form-group">
        			<label for="inputcustomerno" class="col-sm-2 control-label">Unique Customer Number </label>
        			<div class="col-sm-10">
        				<input type="text" class="form-control" id="inputcustomerno" name="inputcustomerno" readonly value="<?php echo $comp_res['custom_customer_no']." - ".$comp_res['first_name']." - ".$comp_res['mobile_no'];?>">
        			</div>
                </div>
				<div class="form-group">
                  <label for="inputcomplaint" class="col-sm-2 control-label">Complaint *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputcomplaint" value="<?php echo $complaints['complaint'];?>" name="inputcomplaint" required>
                  </div>
                </div>
				<div class="form-group">
					<label for="inputcomplaintstatus" class="col-sm-2 control-label">Complaint Status</label>
					<div class="col-sm-10">
						<select class="form-control" id="inputcomplaintstatus" name="inputcomplaintstatus" >
							<option value="">All</option>
							<option value="0" <?php if($complaints['comp_status']=="0"){ echo "selected";}?>>Pending</option>
							<option value="1" <?php if($complaints['comp_status']=="1"){ echo "selected";}?>>Processing</option>
							<option value="2" <?php if($complaints['comp_status']=="2"){ echo "selected";}?>>Closed</option>			
						</select>
					</div>
                </div>
				<div class="form-group">
                  <label for="inputcomplaint" class="col-sm-2 control-label">Remarks </label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="inputRemarks" name="inputRemarks" placeholder="Enter Remarks"><?php echo $complaints['comp_remarks'];?></textarea>
                  </div>
                </div>  
            </div>
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
            </div>
          </div>
        </div>
		</form>
      </div>
    </section>
</div>