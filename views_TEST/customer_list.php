<?php
extract($emp_access);
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
function retrack_stb(id1,id2,id3)
{
var data = "cust_id="+id1+"&stb_id="+id2+"&stb_no="+id3;
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;
xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4)
	{
		var res = JSON.parse(this.responseText);
		if(res.message=='success')
		{
			alert("Re-track Successfull");
		}
		else
		{
			alert(res.text);
		}
    }
});
xhr.open("POST", "<?php echo base_url();?>customer/stb_retrack");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Customers List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a  href="#">Customers List</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
		    <?php
			if(isset($_REQUEST['type']) && $_REQUEST['type']!='')
			{
				if($_REQUEST['type']==1){ $color='GREEN';}else{ $color='RED';}
				echo '<div style="color:'.$color.';font-size:20px;text-align:center">'.$_REQUEST['msg'].'</div>';
			}
			?>
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Customers List</h3>
					</div>
					<form id="customerForm111" name="customerForm111" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/customer_list">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-2">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputCCN" name="inputCCN" 
										<?php if(isset($_REQUEST['inputCCN']) && $_REQUEST['inputCCN']!=''){ ?> value=<?php echo $_REQUEST['inputCCN'];?><?php } ?> placeholder="By Customer ID">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputFname" name="inputFname" <?php if(isset($_REQUEST['inputFname']) && $_REQUEST['inputFname']!=''){ ?> value=<?php echo $_REQUEST['inputFname'];?><?php } ?>  placeholder="By Customer Name">
									</div>
								</div>
								<div class="col-md-3">
								 
									<div class="col-md-12">
										<input type="text" class="form-control" id="inputMobile" name="inputMobile" <?php if(isset($_REQUEST['inputMobile']) && $_REQUEST['inputMobile']!=''){ ?> value=<?php echo $_REQUEST['inputMobile'];?><?php } ?>  placeholder="By Mobile/STB No">
									</div>
								</div>
								<?php
								    if($employee_info['user_type']!=9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup2" name="inputGroup">
											<option value="">Select All Groups</option>
										<?php
											foreach($groups as $key =>$group)
											{
										?>
											<option value="<?php echo $group['group_id'];?>" <?php if($group['group_id'] == $search_group){ echo "selected";} ?>><?php echo $group['group_name'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
								    }
								    if($employee_info['user_type']==9)
								    {
								?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputEmp" name="inputEmp">
											<option value="">Select LCO</option>
										<?php
											foreach($lco_list as $key2 => $lco)
											{
										?>
											<option value="<?php echo $lco['admin_id'];?>"  <?php if($lco['admin_id'] == $_REQUEST['inputEmp']){ echo "selected";} ?>><?php echo $lco['adminFname'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
								    }
								?>
								<div class="col-md-1">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>								
							</div>
						</div>
					</form>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Customer No</th>
									<th>Name</th>
									<th>Mobile</th> 
									<th>Group</th>
									<th>STB NO</th>
									<th>End Date</th>
									<th>Due</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($customers as $key => $customer ){
								$fullName= $customer['first_name'] ." ".$customer['last_name'];
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><a data-toggle="tooltip" data-placement="right"  title="<?php echo $customer['custom_customer_no'];?>"><?php echo $customer['custom_customer_no'];?></a></td>
									<td><a data-toggle="tooltip" data-placement="right"  title="<?php echo $fullName;?>"><?php if(strlen($fullName)>10){echo ucwords(substr($fullName,0,10))."...";}else{echo  ucwords(substr($fullName,0,10));}?></a></td>
									<td><?php echo $customer['mobile_no'];?></td>  
									<td><a data-toggle="tooltip" data-placement="right"  title="<?php echo $customer['group_name'];?>"><?php if(strlen($customer['group_name'])>10){echo ucwords(substr($customer['group_name'],0,10))."...";}else{echo  ucwords(substr($customer['group_name'],0,10));}?></a></td>
									<td><a href="<?php echo base_url()?>customer/customer_stb/<?php echo $customer['cust_id']?>"><?php echo $customer['stb_no'];?></a></td>
									<td><?php echo $customer['end_date'];?></td>
									<td><?php echo $customer['pending_amount'];?></td>
									<td>
									<?php if($custV ==1){?><a data-toggle="tooltip" data-placement="bottom"  href="<?php echo base_url()?>customer/view/<?php echo $customer['cust_id']?>"  title="View" ><i class="fa fa-eye fa-lg" aria-hidden="true"  title="View" ></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<?php }if($custE ==1){?><a data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo base_url()?>customer/edit/<?php echo $customer['cust_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }?>
									&nbsp;&nbsp;<?php if($custE ==1){?><a  data-toggle="tooltip" data-placement="bottom"  style="color:red;" title="Disable Customer" href="<?php echo base_url()?>customer/inactive_customer/<?php echo $customer['cust_id']?>" onclick="return ConfirmDialog1(<?php echo  $customer['pending_amount']; ?>);"><i class="fa fa-user-times fa-lg" aria-hidden="true"></i></a><?php }?>
									&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="bottom" data-stb_no="<?php echo $customer['stb_no'];?>" title="Re-track" onclick="retrack_stb(<?php echo $customer['cust_id'];?>,<?php echo $customer['stb_id'];?>,'<?php echo $customer['stb_no'];?>');" class="btn btn-danger">Re-track</a><!--<a data-toggle="tooltip" data-placement="bottom" title="Customer STB" href="<?php echo base_url()?>customer/customer_stb/<?php echo $customer['cust_id']?>"><i class="fa fa-hdd-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Make Payment" href="<?php echo base_url()?>customer/make_payment/<?php echo $customer['cust_id']?>"><i class="fa fa-money fa-lg" aria-hidden="true"></i></a>-->
									<?php if($paymentsV ==1){?><!--&nbsp;&nbsp;&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="bottom" title="Payment History" href="<?php echo base_url()?>customer/paymentHistory/<?php echo $customer['cust_id']?>"><i class="fa fa-history" aria-hidden="true"></i></a>--><?php }?>
									</td>
								</tr>
								<?php 
								$i=$i+1;
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