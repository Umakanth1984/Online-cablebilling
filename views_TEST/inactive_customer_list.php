<?php
extract($emp_access);
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to Activate this Customer?")
  if (x) {
    return true;
  } else {
    return false;
  }
}

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    alert('Hi');
});
</script>
<script>
function ConfirmDialog2() {
  var x=confirm("Are you sure to Delete this Customer ?")
  if (x) {
    return true;
  } else {
    return false;
  }
}

}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
  <script>
$(function(){
	// add multiple select / deselect functionality
	$("#selectall").click(function () {
		  $('.case').attr('checked', this.checked);
	});
	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".case").click(function(){
		if($(".case").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}
	});
});
  </script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Inactive Customers List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a href="#">Inactive Customers List</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Inactive Customers List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/inactive_customer_list">
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
										<input type="text" class="form-control" id="inputMobile" name="inputMobile" <?php if(isset($_REQUEST['inputMobile']) && $_REQUEST['inputMobile']!=''){ ?> value=<?php echo $_REQUEST['inputMobile'];?><?php } ?>  placeholder="By Mobile/MAC ID/VC No">
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
					<?php if(isset($msg) && $msg!=''){ echo $msg;} ?>
					<div class="box-body">
					<form id="checkboxForm" name="checkboxForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>customer/multi_del">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" name="selectall" value="all"/>
									<?php if($custD ==1){ ?><input type="submit" id="delSubmit" name="delSubmit" value="Delete Customers" class="btn btn-primary"/><?php } ?></th>
									<th>S.No</th>
									<th>Account No</th>
									<th>Name</th>
									<th>Mobile</th> 
									<th>Group</th>
									<th>STB NO</th>
									<th>End Date</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							// foreach($customers as $key => $customer )
							for($i = 0; $i < count($customers); ++$i)
							{
								extract($customers);
							$pkg_id=mysql_fetch_assoc(mysql_query("select package_id,group_name from groups where group_id=".$customers[$i]['group_id']));
							$qry_price=mysql_query("select package_price from packages where package_id=".$pkg_id['package_id']);
							$sel_price=mysql_fetch_assoc($qry_price);
							$sel_payment=mysql_fetch_assoc(mysql_query("select * from  payments where customer_id=".$customers[$i]['cust_id']." ORDER BY payment_id DESC LIMIT 1"));
							?>
								<tr>
									<td><input type="checkbox" class="case" name="case[]" value="<?php echo $customers[$i]['cust_id'];?>"/></td>
									<td><?php echo $i+1;?></td>
									<td><?php echo $customers[$i]['custom_customer_no'];?></td>
									<td><?php echo $customers[$i]['first_name'] ." ".$customers[$i]['last_name'];?></td>
									<td><?php echo $customers[$i]['mobile_no'];?></td>  
									<td><?php echo $pkg_id['group_name'];?></td>
									<td><?php echo $customers[$i]['stb_no'];?></td>
									<td><?php echo $customers[$i]['end_date'];?></td>
									<td>
									<?php if($custV ==1){?><a data-toggle="tooltip" data-placement="bottom"  href="<?php echo base_url()?>customer/view/<?php echo $customers[$i]['cust_id']?>" title="View"><i class="fa fa-eye fa-lg" aria-hidden="true" title="View"></i></a> &nbsp;&nbsp;<?php } ?>
									<?php if($custE ==1){?><a data-toggle="tooltip" data-placement="bottom"  title="Enable Customer" href="<?php echo base_url()?>customer/activate_customer/<?php echo $customers[$i]['cust_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-user fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }?>
									<?php if($custD ==1){?><a data-toggle="tooltip" data-placement="bottom"  title="Delete Customer" href="<?php echo base_url()?>customer/delete/<?php echo $customers[$i]['cust_id']?>" onclick="return ConfirmDialog2();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a><?php }?>
									</td>
								</tr>
								<?php 
								// }
							}
								?>
							</tbody>
						</table>
					</div>
				</div>
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