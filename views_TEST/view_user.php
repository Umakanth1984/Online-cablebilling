<?php $userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if($usersV ==1){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php foreach($employee as $key => $employees )
				{
				} ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
    <section class="content-header">
      <h1>Digital Cables  - Employee Details of <b><?php echo ucwords($employees['emp_first_name']." ".$employees['emp_last_name']);?></b></h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Employee</a></li>
        <li class="active">View Employee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li class="active"><a  href="#activity" data-toggle="tab">Personal Data</a></li>
				<li><a  href="#joining" data-toggle="tab">Joining Date</a></li>
				<li><a  href="#complaints" data-toggle="tab">Pending Complaints</a></li>
				<li><a  href="#complaints_closed" data-toggle="tab">Completed Complaints</a></li>
            </ul>
			<?php
				// $invoiceRes=mysql_fetch_assoc($invoiceQry);
			?>
            <div class="tab-content">
				<div class="active tab-pane" id="activity">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Name : </b><?php echo ucwords($employees['emp_first_name']);?> 
							<?php if($employees['emp_last_name']!='NULL'){ echo ucwords($employees['emp_last_name']);}?></td>
							<td><b>Address : </b><?php echo $employees['emp_add1'];?> , <?php echo $employees['emp_add2']." , ".$employees['emp_city']." , ".$employees['emp_pin_code'];?></td>
						</tr>
						<tr>
							<td><b>Email Id : </b><?php if($employees['emp_email']==''){ echo "No email id";}else{ echo $employees['emp_email'];}?></td>
							<td><b>Group Name : </b> <?php
								// $grpQry=mysql_query("select * from groups");
							echo $employees['group_id'];?></td>
						</tr>
						<tr>
							<td><b>Mobile No: </b> <?php echo $employees['emp_mobile_no'];?></td>
						</tr>
					</table>
				</div>
				
				<div class="tab-pane" id="joining">
					<table id="example2" class="table table-bordered table-hover">
						<tr>
							<td><b>Joining Date : </b><?php echo $employees['date_created'];?></td>
							<td><b>Inactive Date : </b><?php if($employees['inactive_date']!='0000-00-00 00:00:00'){ echo $employees['inactive_date'];}?></td>
						</tr>
					</table>
				</div>
				
				<div class="tab-pane" id="complaints">
					<?php 
						$emp_id=$employees['emp_id'];
						$check_grp=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
						$grp_ids=$check_grp['group_ids'];
						$compQry1=mysql_query("SELECT * FROM customers RIGHT JOIN create_complaint ON customers.cust_id=create_complaint.customer_id WHERE customers.group_id IN ($grp_ids) AND create_complaint.comp_status!=2");
						$cnt=mysql_num_rows($compQry1);
						if($cnt){
					?>
					<table id="example2" class="table table-bordered table-hover">
					
						<thead>
							<tr>
								<th>Customer No</th>
								<th>Ticket Number</th>
								<th>Complaint Category</th>
								<th>Complaint Remarks</th>
								<th>Status</th>
							 
							</tr>
						</thead>
					<?php
					
						 
						//$compQry1=mysql_query("select * from create_complaint where created_by=$emp_id");
						while($invoiceRes1=mysql_fetch_assoc($compQry1))
						{
							 
							$cust_data=mysql_fetch_assoc(mysql_query("SELECT * FROM  customers  WHERE cust_id=".$invoiceRes1['customer_id']));
							$complaint_data=mysql_fetch_assoc(mysql_query("SELECT * FROM  complaint_prefer  WHERE id=".$invoiceRes1['comp_cat']));
					?>
						<tr>
							<td><?php echo $cust_data['first_name']." (".$cust_data['custom_customer_no'].")";?></td>
							<td><?php echo $invoiceRes1['comp_ticketno'];?></td>
							<td><?php echo $complaint_data['category'];?></td>
							<td><?php echo $invoiceRes1['complaint'];?></td>
							 <?php if($invoiceRes1['comp_status']==0){ echo "<td class='bg-red'>Pending</td> ";}elseif($invoiceRes1['comp_status']==1){ echo "<td class='bg-blue'>Processing</td>";}elseif($invoiceRes1['comp_status']==2){ echo "<td class='bg-green'>Closed</td>";}?> 
							<!-- <td><?php echo $invoiceRes1['comp_status'];?></td>-->
						</tr>
					<?php
						}
					?>
					</table>
						<?php }else{?>
						<h2 style="text-align:center;"> No Complaints Assigned... </h2>
						<?php }?>
				</div>
				<div class="tab-pane" id="complaints_closed">
				<?php 
						$emp_id=$employees['emp_id'];
						$check_grp=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
						$grp_ids=$check_grp['group_ids'];
						$compQry1=mysql_query("SELECT * FROM customers RIGHT JOIN create_complaint ON customers.cust_id=create_complaint.customer_id WHERE customers.group_id IN ($grp_ids) AND create_complaint.comp_status=2");
						$cnt=mysql_num_rows($compQry1);
						if($cnt){
					?>
					<table id="example2" class="table table-bordered table-hover">
					
						<thead>
							<tr>
								<th>Customer No</th>
								<th>Ticket Number</th>
								<th>Complaint Category</th>
								<th>Complaint Remarks</th>
								<th>Status</th>
							 
							</tr>
						</thead>
					<?php
					
						 
						//$compQry1=mysql_query("select * from create_complaint where created_by=$emp_id");
						while($invoiceRes1=mysql_fetch_assoc($compQry1))
						{
							 
							$cust_data=mysql_fetch_assoc(mysql_query("SELECT * FROM  customers  WHERE cust_id=".$invoiceRes1['customer_id']));
							$complaint_data=mysql_fetch_assoc(mysql_query("SELECT * FROM  complaint_prefer  WHERE id=".$invoiceRes1['comp_cat']));
					?>
						<tr>
							<td><?php echo $cust_data['first_name']." (".$cust_data['custom_customer_no'].")";?></td>
							<td><?php echo $invoiceRes1['comp_ticketno'];?></td>
							<td><?php echo $complaint_data['category'];?></td>
							<td><?php echo $invoiceRes1['complaint'];?></td>
							 <?php if($invoiceRes1['comp_status']==0){ echo "<td class='bg-red'>Pending</td> ";}elseif($invoiceRes1['comp_status']==1){ echo "<td class='bg-blue'>Processing</td>";}elseif($invoiceRes1['comp_status']==2){ echo "<td class='bg-green'>Closed</td>";}?> 
							<!-- <td><?php echo $invoiceRes1['comp_status'];?></td>-->
						</tr>
					<?php
						}
					?>
					</table>
						<?php }else{?>
						<h2 style="text-align:center;"> No Complaints Assigned... </h2>
						<?php }?>
				</div>
            </div>
            <!-- /.tab-content -->
          </div>
				<div class="box-footer">
					<a class="btn btn-info pull-right" href="<?php echo base_url()?>user/employees_list/">Back</a> 
				</div>
          <!-- /.nav-tabs-custom -->
        </div>		
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
 <?php } else{ 
	 redirect('/welcome');
  }?>