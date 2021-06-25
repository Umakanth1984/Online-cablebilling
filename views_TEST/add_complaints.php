<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 5px 10px;
  }
</style>
<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
       Digital Cables  - Add Complaint    
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Complaints</a></li>
        <li class="active">Add Complaint</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
	 <form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" 
	 action="<?php echo base_url()?>customer_dashboard/complaints_save"> 
	 <input type="hidden" name="emp_id" id="emp_id" value="0">
	 <input type="hidden" name="inputcustomerno" id="inputcustomerno" value="<?php echo $cust_id; ?>">
        <!-- left column -->
        <div class="col-md-10">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Complaint Details</h3>
            </div>
            <!-- /.box-header -->          
            <div class="box-body">
				<div class="form-group">
					<label for="complaint_category" class="col-sm-2 control-label">Complaint Category</label>
					<div class="col-sm-10">
						<select class="form-control" id="complaint_category" name="complaint_category" required>
							<option value="">Select Category</option>
							<?php  
							$qry1=mysql_query("select * from complaint_prefer");
							while($res1=mysql_fetch_assoc($qry1))
							{
							?>  
							<option value="<?php echo $res1['id'];?>"><?php echo $res1['category'];?></option>
							<?php
							}
							?>
						</select>
					</div>
                </div>
				
				<div class="form-group">
					<label for="inputcomplaint" class="col-sm-2 control-label">Complaint *</label>
					<div class="col-sm-10">
						<textarea name="inputcomplaint" id="inputcomplaint" class="form-control" rows="4"></textarea>
					</div>
                </div>
            </div>
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
            </div>
          </div>
        </div>
        <!--/.col (left) -->
		</form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>