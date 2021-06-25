<?php 
	$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);
	if(($empdepositeV ==1) || ($empdepositeE ==1) || ($empdepositeD ==1)){ 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Employee Deposit List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Employee</a></li>
			<li><a href="#">Employee Deposit List</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Employee Deposit List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>empdeposit/empdeposit_list">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<label for="emp_first_name" class="col-md-4 control-label">Employee Name</label>
									<div class="col-md-8">
										<input type="text" class="form-control" id="emp_first_name" name="emp_first_name" placeholder="Employee Name">
									</div>
								</div>
								<div class="col-md-2">
									<button name="submit" id="submit" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box-body">
					  <table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>				  
						  <th>Employee Name</th>
						  <th>Deposit Amount</th>
						  <th>Deposit Date</th>
						  <th>Remarks</th>                               
						   <th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
					   <?php
						foreach($empdeposit as $key => $empdeposit )
						{
							$emp_ID=$empdeposit['emp_name'];
							$empqry=mysql_query("select * from employes_reg where emp_id='$emp_ID'");
							$empres=mysql_fetch_assoc($empqry);
					?>  
						<tr>                 
						  <td><?php echo $empres['emp_first_name']?></td>
						  <td><?php echo $empdeposit['depos_amount']?></td>
						  <td><?php echo $empdeposit['depos_date']?></td>
						  <td><?php echo $empdeposit['remarks']?></td>                  
						  <td><a  data-toggle="tooltip" data-placement="bottom"  title="View" href="<?php echo base_url()?>empdeposit/view/<?php echo $empdeposit['emp_depos_id']?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php if($empdepositeE ==1) {?><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>empdeposit/edit/<?php echo $empdeposit['emp_depos_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }?></td>
						</tr>
					<?php }?>
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
	}
?>