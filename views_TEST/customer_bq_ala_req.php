<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids'];
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<style>
.button.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}
</style>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
	document.getElementById("submit").className = "disabled";
    return true;
  } else {
    return false;
  }
}
</script>

<script>
function ConfirmDialog1(a) {
	if(a==0){
		var x=confirm("Are you sure to Inactivate this Customer ?")
	}
	else{
		var x=confirm("Customer has Outstanding Amount Rs."+a+".  Are you sure to Inactivate this Customer ?")
	}
	
	if (x) {
		return true;
	} else {
		return false;
	}
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
$(document).ready(function() {
  $("#selectall").change(function(){
    if(this.checked){
      $(".case").each(function(){
        this.checked=true;
      })
    }else{
      $(".case").each(function(){
        this.checked=false;
      })
    }
});

$(".case").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".case").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })
      if(isAllChecked == 0){ $("#selectall").prop("checked", true); }
    }else {
      $("#selectall").prop("checked", false);
    }
});
var checkboxes = $("input[type='checkbox']"),
    submitButt = $("input[type='submit']");

checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
});

	$('#bulkApprove').click(function () {
		var check = $("input:checkbox:checked").length
		if ($("#selectall").is(":checked"))
			var count= check-1;
		else
		var count= 0;
		count = check;
		if(count==0)
			alert("Please select atleast one");
		else
		var x=confirm("Are you sure to Approve "+count+" ?")
		if (x) {
			return true;
		} else {
			return false;
		}
	});
});
</script>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Customer Bouquet & Ala-carte</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a  href="#">Customers Bouquet & Ala-carte</a></li>
		</ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					    <h3 class="box-title">Customers Bouquet & Ala-carte</h3>
					    <form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url();?>excelsheet/req_download">						
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" class="form-control" id="inputLco" name="inputLco" value="<?php echo $_REQUEST['inputLco']; ?>">
							<input type="hidden" class="form-control" id="fromdate" name="fromdate" value="<?php echo $_REQUEST['fromdate']; ?>">
							<input type="hidden" class="form-control" id="todate" name="todate" value="<?php echo $_REQUEST['todate']; ?>">
							<input type="hidden" class="form-control" id="inputCCN" name="inputCCN" <?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){?> value="<?php echo $_REQUEST['inputCCN']; ?>" <?php } ?>>
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
					</div>
					<form id="customerForm111" name="customerForm111" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>dashboard">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" 
										<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){ ?> value=<?php echo $_REQUEST['inputCCN'];?><?php } ?> placeholder="By Customer ID /MAC / VC No">
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php } ?>>
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="todate">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php } ?>>
									</div>
								</div>
							</div>
							<div class="form-group">
							    <?php
								    if($user_type==9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputLco" name="inputLco">
											<option value="">Select LCO</option>
										<?php
											foreach($lco_list as $key1 => $lcoInfo1)
											{
										?>
											<option value="<?php echo $lcoInfo1['admin_id'];?>" <?php if(isset($_REQUEST['inputLco']) && $_REQUEST['inputLco']==$lcoInfo1['admin_id']){ echo "selected";}?>><?php echo $lcoInfo1['adminFname'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
								    }
								    else
								    {
								        echo '<div class="col-md-6"></div>';
								    }
								?>
								<div class="col-md-1">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover col-sm-12">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Cust ID</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Employee Name</th>
									<!--<th>Package</th>
									<th>MAC ID</th>-->
									<th>STB No</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($customer_requets as $key => $customer_req)
							{
							    if(isset($customer_req['alacarte']) || isset($customer_req['bouquet']))
							    {
							?>
								<tr>
								    <input type="hidden" name="cId[]" value="<?php echo $customer_req['cust_id'];?>">
								    <input type="hidden" name="sId[]" value="<?php echo $customer_req['stb_id'];?>">
									<td><?php echo $i;?></td>
									<td><?php echo $customer_req['custom_customer_no'];?></td>
									<td><?php echo $customer_req['first_name'];?></td>
									<td><?php echo $customer_req['mobile_no'];?></td>
									<td><?php echo $customer_req['empName'];?></td>
									<!--<td><?php echo $customer_req['basePackage']." - Rs.".$customer_req['basePackagePrice'];?></td>
									<td><?php echo $customer_req['mac_id'];?></td>-->
									<td><a href="<?php echo base_url();?>dashboard/bq_ala_req/<?php echo $customer_req['cust_id']."/".$customer_req['stb_id'];?>"><?php echo $customer_req['stb_no'];?></a></td>
									<td><a class="btn btn-info" href="<?php echo base_url();?>dashboard/bq_ala_req/<?php echo $customer_req['cust_id']."/".$customer_req['stb_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo implode(",",$customer_req['alacarte'])." & ".implode(",",$customer_req['bouquet']);?>">View</a></td>
								</tr>
							<?php 
						    	$i=$i+1;
							    }
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo $pagination; ?>
			</div>
		</div>
	</section>
	</div>
  <?php
	}
	else
	{		
		redirect('/');
	}?>