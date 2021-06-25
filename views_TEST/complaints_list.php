<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($complA ==1) || ($complV ==1) || ($complE ==1)){
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Complaint List</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Complaint</a></li>
			<li class="active">Complaint List</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Complaint List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>complaints/complaints_list">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="customer_id" name="customer_id" placeholder="Customer ID">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name">
									</div>
								</div>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="comp_status" name="comp_status" >
											<option value="">By Complaint Status</option>
											<!--<option value="">All</option>-->
											<option value="0" <?php if(isset($_REQUEST['comp_status']) && $_REQUEST['comp_status']=='0'){ echo "selected";}?>>Pending Complaints</option>
											<option value="1" <?php if(isset($_REQUEST['comp_status']) && $_REQUEST['comp_status']=='1'){ echo "selected";}?>>Processing Complaints</option>
											<option value="2" <?php if(isset($_REQUEST['comp_status']) && $_REQUEST['comp_status']=='2'){ echo "selected";}?>>Closed Complaints</option>						
										</select>
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
							<th>S.No</th>
							<th>Cust.ID</th>
							<th>Customer Name</th>
							<th>Ticket No</th>
							<!--<th>Customer Name</th>
							<th>Address</th>  -->
							<th>Complaint</th>
							<th>Date Created</th>
							<!--<th>Updated on</th>-->
							<th>Complaint Duration</th>
							<th>Status</th>
							<th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
					   <?php
					   	$i=1;
						foreach($complaints as $key => $complaints )
						{
							$cust_id=$complaints['customer_id'];
							$qry1=mysql_query("select * from customers where cust_id='$cust_id'");
							$res1=mysql_fetch_assoc($qry1);
					?>  
						<tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $res1['custom_customer_no'];?></td>
						  <td><?php echo $res1['first_name'];?></td>
						  <td><?php echo $complaints['comp_ticketno'];?></td>
						 <!-- <td><?php echo $res1['addr1']." ".$res1['addr2'];?></td>-->
						    <td><?php echo $complaints['complaint'];?></td>
						   <!-- <td><?php echo "Due Amount";?></td>
							<td><?php echo "Complaint Time";?></td>-->
						   <td><?php echo $complaints['created_date'];?></td>
						   <!--<td><?php echo $complaints['edited_on'];;?></td>-->
						   <td><?php
									$date1 = strtotime($complaints['created_date']);
									// $date2 = strtotime($complaints['edited_on']);
									$subTime = time() - $date1;
									//$y = ($subTime/(60*60*24*365));
									$d = ($subTime/(60*60*24))%365;
									$h = ($subTime/(60*60))%24;
									$m = ($subTime/60)%60;

									// echo "Complaint Duration is: ";
									echo $d." days, ";
									echo $h." hours, ";
									echo $m." minutes";
								?></td>
						   <?php if($complaints['comp_status']==0){ echo "<td class='bg-red'>Pending</td> ";}elseif($complaints['comp_status']==1){ echo "<td class='bg-blue'>Processing</td>";}elseif($complaints['comp_status']==2){ echo "<td class='bg-green'>Closed</td>";}?> 
						  <td><a title="View" href="<?php echo base_url()?>complaints/view/<?php echo $complaints['complaint_id']?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a> <?php if($complaints['comp_status']!=2){?>&nbsp;&nbsp;<a title="Edit" href="<?php echo base_url()?>complaints/edit/<?php echo $complaints['complaint_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a><?php } ?></td>
						</tr>
					<?php
						$i++;
					 }?>
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