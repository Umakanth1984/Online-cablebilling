<div class="content-wrapper">
    <section class="content-header">
      <h1>Digital Cables  - View Complaint Details </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Complaint</a></li>
        <li class="active">View Complaint</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	  
	  <?php  foreach($complaints as $key => $complaints )
				{
				} ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
        <!-- left column -->
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Complaint</h3>
            </div>
            <!-- /.box-header -->
				<?php
					$cust_id=$complaints['customer_id'];
					$qry1=mysql_query("select * from customers where cust_id='$cust_id'");
					$res1=mysql_fetch_assoc($qry1);
				?>
              <div class="box-body">
                <div class="form-group col-md-12">
                  <label for="inputcustomerno" class="col-sm-4 control-label">Customer ID/Custom Number </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputcustomerno" value="<?php echo $res1['custom_customer_no'];?>" name="inputcustomerno" readonly>
                  </div>
                </div>
				<div class="form-group col-md-12">
					<label for="inputcustomername" class="col-sm-4 control-label">Customer Name </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="inputcustomername" value="<?php echo $res1['first_name'];?>" name="inputcustomername" readonly>
					</div>
				</div>			  
				 <div class="form-group col-md-12">
                  <label for="inputcustomermobile" class="col-sm-4 control-label">Customer Mobile Number </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputcustomermobile" value="<?php echo $res1['mobile_no'];?>" name="inputcustomermobile" readonly>
                  </div>
                </div>
				<div class="form-group col-md-12">
                  <label for="inputcustomeraddr" class="col-sm-4 control-label">Customer Address</label>
                  <div class="col-sm-8">
					<textarea  class="form-control"  rows="3"  id="inputcustomeraddr" name="inputcustomeraddr"  readonly><?php echo $res1['addr1']." ".$res1['addr2'];?></textarea>
                  </div>
                </div>
				<div class="form-group col-md-12">
                  <label for="inputcomplaint" class="col-sm-4 control-label">Complaint </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputcomplaint" value="<?php echo $complaints['complaint'];?>" name="inputcomplaint" readonly>
                  </div>
                </div>
				<div class="form-group col-md-12">
                  <label for="inputcomplaint" class="col-sm-4 control-label">Complaint Remarks</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputcomplaint" value="<?php echo $complaints['comp_reamrks'];?>" name="inputcomplaint" readonly>
                  </div>
                </div>    
				
				<div class="form-group col-md-12">
					<label for="inputcomplaintstatus" class="col-sm-4 control-label">Complaint Status</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" value="<?php if($complaints['comp_status']==0){ echo $status='Pending';}
		elseif($complaints['comp_status']==1){ echo $status='Processing';}
		elseif($complaints['comp_status']==2){ echo $status='Closed';}?>" readonly>
					</div>
                </div>  
				<div class="box-footer col-md-5-offset col-md-7">
					<a class="btn btn-info pull-right" href="<?php echo base_url()?>complaints/complaints_list">Back</a>
				</div>
              </div>    
          </div>
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>