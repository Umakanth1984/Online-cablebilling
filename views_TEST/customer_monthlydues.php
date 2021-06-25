<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Customers Monthly Dues      
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Customers</a></li>
        <li class="active"><a  href="#">Customers Monthly Dues</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Customers Monthly Dues</h3>
					</div>
					 
					<?php if(isset($msg) && $msg!=''){ echo $msg;} ?>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Customer No</th>
									<th>Name</th>
									<th>Mobile</th> 
									<th>Group</th>
									<th>Package / Monthly Bill</th>
									 
								</tr>
							</thead>
							<tbody>
							<?php
						 
							$i=1;
							$totDues='';
							foreach($customers as $key => $customer ){
						 
								/*extract($customers);
								$pkg_id=mysql_fetch_assoc(mysql_query("select package_id,group_name from groups where group_id=".$customer['group_id']));
								$qry_price=mysql_query("select package_price from packages where package_id=".$customer['package_id']);
								$sel_price=mysql_fetch_assoc($qry_price);*/
								$sel_payment=mysql_fetch_assoc(mysql_query("select * from  payments where customer_id=".$customer['cust_id']." ORDER BY payment_id DESC LIMIT 1"));
								$totDues=$totDues+$customer['package_price'];
							?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $customer['custom_customer_no'];?></td>
									<td><?php echo $customer['first_name'] ." ".$customer['last_name'];?></td>
									<td><?php echo $customer['mobile_no'];?></td>  
									<td><?php echo $customer['group_name'];?></td>
									<td><?php echo "Rs.".$customer['package_price'];?></td>
									 
								</tr>
								<?php 
								$i=$i+1;
								
							}
								?>
							</tbody>
							<tfoot>
								<tr><td colspan="11" align="right" rowspan="1">Total Amount : <b style="color:red;"><?php echo "Rs.".$totDues; ?></b></td></tr>
							</tfoot>
						</table>
					</div>
				<!-- /.box-body -->
				</div>
          <!-- /.box -->
			</div>
        <!-- /.col -->
		</div>
      <!-- /.row -->
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<?php echo $pagination; ?>
			</div>
		</div>
	  
    </section>
    <!-- /.content -->
  </div>
  
  <?php } else{ 
	 redirect('/');
  }?>  