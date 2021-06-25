<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<style>
.button.disabled {
  opacity: 0.9; 
  cursor: not-allowed;
  display: none;
}
</style>
<script>
function ConfirmPayNow() {
  var x=confirm("Are you sure to Add Credits?")
  if (x) {
    return true;
  }else{
	return false;
  }
}
</script>
 
<div class="content-wrapper">
    <section class="content-header">
      <h1>Digital Cables  - Add Credits to LCO</h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Users</a></li>
        <li class="active">Add Credits to LCO</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <form id="creditsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
        <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>" >
        <!-- left column -->
        <div class="col-md-10">
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Credits</h3>
                </div>
                <div class="box-body">
    				<div class="form-group">
    					<label for="lco" class="col-sm-2 control-label">LCO Name *</label>
    					<div class="col-sm-10">
    					    <select class="form-control" name="lco" id="lco" required>
								<option value="">Select LCO</option>
								<?php
								$i=1;
								foreach($values as $key => $lco)
								{
								?>
								<option value="<?php echo $lco['admin_id'];?>" <?php if(isset($_REQUEST['req_pos']) && $_REQUEST['req_pos']!='' && ($_REQUEST['req_pos']==$lco['admin_id'])){ echo "selected";}?>><?php echo $lco['adminFname'];?></option>
								<?php
								}
								?>
							</select>
    					</div>
    				</div>			  
    				<div class="form-group">
                        <label for="total_balance" class="col-sm-2 control-label">Balance :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control total_balance" id="total_balance" name="total_balance" value="0" readonly>
                        </div>
                    </div>
    				<div class="form-group">
                        <label for="amount" class="col-sm-2 control-label">Amount *</label>
                        <div class="col-sm-10">
                            <input type="number" max=999999 class="form-control" id="amount" name="amount" placeholder="Amount" value="" maxlength=5 minlength=1 required>
                        </div>
                    </div>
					<div class="form-group">
					  <label for="inputcustomeraddr" class="col-sm-2 control-label">Description </label>
					  <div class="col-sm-10">
						<textarea class="form-control" rows="3" id="remarks" name="remarks" placeholder="Enter any remarks" required></textarea>
					  </div>
					</div>
				</div>
				<div class="box-footer">
					<input type="submit" id="lcoCredits" name="lcoCredits" class="btn btn-info pull-right" onclick="return ConfirmPayNow();" value="Add Credits">
				</div>
          </div>
        </div>
		</form>
      </div>
    </section>
  </div>
<script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#lco").on('change',function() {
	var program_id = $("#lco").val();
	// alert(program_id);
		$.ajax({
		url: "<?php echo base_url()?>dashboard/get_ajax_lco_data",
		type: "POST",
		dataType: "json",
		data: {program_id: program_id},
			success: function(res) {
				jQuery("#total_balance").val(res);
			}
		});
	});

<?php
if(isset($_REQUEST['req_pos']) && $_REQUEST['req_pos']!='')
{
?>
    setTimeout(function() {
		var program_id = $('#lco').val();
		if(program_id){
			$.ajax({
    		url: "<?php echo base_url()?>dashboard/get_ajax_lco_data",
    		type: "POST",
    		dataType: "json",
    		data: {program_id: program_id},
    			success: function(res) {
    				jQuery("#total_balance").val(res);
    			}
    		});
		}
	}, 1000);
<?php
}
?>	
});
</script>
    <?php 
	}
	else
	{ 
		redirect('/');
	}?>