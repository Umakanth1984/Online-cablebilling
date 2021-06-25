<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
 if(($complA ==1)){
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - New Complaint</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Complaints</a></li>
			<li class="active">New Complaint</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<?php if(isset($_REQUEST['msg']) && $_REQUEST['msg']=='success'){ echo '<div style="color:GREEN;font-size:30px;text-align:center;padding-bottom:20px;">Complaint Registered Successfully ..</div>'; }
		if(isset($_REQUEST['msg']) && $_REQUEST['msg']!=''){ $url=base_url().'complaints';header("refresh:3;url=$url");}
		?>
		<div class="row">		
			<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>complaints">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-body">
								<div class="form-group col-md-12">
									<!--<label for="cust_id" class="col-md-6 control-label">Customer ID / Mobile Number *</label>-->
									<div class="col-md-10">
										<input type="text" class="form-control" id="cust_id" name="cust_id" placeholder="Enter Customer ID / Registered Mobile Number / STB NO" maxlength=50 required value="<?php if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id']!=''){ echo $_REQUEST['cust_id'];}?>">
									</div>
									<div class="col-md-2">
										<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info">Search</button>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
			<?php
				if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id']!='')
				{
					$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id='$emp_id'"));
					$grp_ids=$chkEmpGrps['group_ids'];
					$cust_id=$_REQUEST['cust_id'];
					$admQry=mysql_query("select * from customers where (custom_customer_no='$cust_id' OR mobile_no='$cust_id' OR stb_no='$cust_id') AND customers.group_id IN ($grp_ids) AND admin_id='$adminId'");
					$count=mysql_num_rows($admQry);
					$admRes=mysql_fetch_assoc($admQry);
					// $customer=mysql_fetch_assoc($admQry);
					if($count==1)
					{
							$cust_grp_id=$admRes['group_id'];
							$empQry=mysql_query("select * from employes_reg where user_type=3 AND admin_id='$adminId'");
							$emp_ids='';
							while($empRes=mysql_fetch_assoc($empQry))
							{
								$emp_ids.=$empRes['emp_id'].",";
							}
							$org_emps=substr($emp_ids, 0, -1);
							$empIDs=explode(",",$org_emps);
							$count=count($empIDs);
							$empID='';
							for($i=0;$i<$count;$i++)
							{
								$grpRes=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=".$empIDs[$i]));
								$grpIDS=$grpRes['group_ids'];
								$grp_arr=explode(",",$grpIDS);
								if(in_array($cust_grp_id, $grp_arr))
								{
									$empID.=$grpRes['emp_id'].",";
								}
							}
							$ids=$empID;
							$org_ids=substr($ids,0,-1);
							$tech_persons=explode(",",$org_ids);
							$tech_ids=count($tech_persons);
						$grpRes=mysql_fetch_assoc(mysql_query("select * from groups where group_id=".$admRes['group_id']));
						$colEmp=mysql_fetch_assoc(mysql_query("select employes_reg.emp_first_name,employes_reg.emp_id,employes_reg.emp_mobile_no from employes_reg RIGHT JOIN emp_to_group ON employes_reg.emp_id=emp_to_group.emp_id where employes_reg.user_type='2' AND employes_reg.user_role='Collection Boy' AND emp_to_group.group_ids IN (".$admRes['group_id'].")"));
						// echo $colEmp['emp_first_name'];
			?>
					<div class="row">
						<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>complaints/complaints_save"> 
							<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
							<input type="hidden" name="cust_id" id="cust_id" value="<?php echo $admRes['cust_id']; ?>">
							<input type="hidden" name="collectionEmp" id="collectionEmp" value="<?php echo $colEmp['emp_mobile_no']; ?>">
							<div class="col-md-2"></div>
							<div class="col-md-8">
								<div class="box box-info">
									<div class="box-body">
										<div class="form-group">
											<label for="first_name" class="col-md-4 control-label">Customer Name </label>
											<div class="col-md-8">
												<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $admRes['first_name'];?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="addr1" class="col-md-4 control-label">Address </label>
											<div class="col-md-8">
												<input type="text" class="form-control" id="addr1" name="addr1" value="<?php echo $admRes['addr1'].",".$admRes['addr2'].",".$admRes['city'].",".$admRes['state'];?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="mobile_no" class="col-md-4 control-label">Mobile Number </label>
											<div class="col-md-8">
												<input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $admRes['mobile_no'];?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="group_name" class="col-md-4 control-label">Area Name </label>
											<div class="col-md-8">
												<input type="text" class="form-control" id="group_name" name="group_name" value="<?php echo $grpRes['group_name'];?>" readonly>
											</div>
										</div>
										<?php for($j=0;$j<$tech_ids;$j++){
											$employee=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=".$tech_persons[$j]));
										?>
										<div class="form-group">
											<label for="tech_name<?php echo $j+1;?>" class="col-md-4 control-label">Technical Person <?php echo $j+1;?></label>
											<div class="col-md-8">
												<div class="col-md-1">
													<input type="checkbox" class="checkbox" id="chkbox" name="chkbox[]" value="<?php echo $employee['emp_mobile_no'];?>">
												</div>
												<div class="col-md-11"><input type="text" class="form-control" id="tech_name<?php echo $j+1;?>" value="<?php echo $employee['emp_first_name']." ".$employee['emp_last_name']." - ".$employee['emp_mobile_no'];?>" name="tech_name" readonly>
												</div>
											</div>
										</div>
										<?php } ?>										
										<div class="form-group">
											<label for="complaint_category" class="col-md-4 control-label">Complaint Category *</label>
											<div class="col-md-8">
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
											<label for="inputcomplaint" class="col-md-4 control-label">Complaint *</label>
											<div class="col-md-8">
												<textarea name="inputcomplaint" id="inputcomplaint" class="form-control" rows="4"></textarea>
											</div>
										</div>
									</div>
									<div class="box-footer col-md-offset-5 col-md-7">
										<button type="submit" id="complaintSubmit" name="complaintSubmit" class="btn btn-info">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="box box-info">
							<div class="box-body">
								<table id="example2" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>S.No</th>
											<th>Ticket No</th>
											<th>Complaint Category</th>
											<th>Complaint</th>
											<th>Created On</th>
											<th>Closed On</th>
											<th>Status</th>
											<th>Remarks</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$DI=1;
									$compQry=mysql_query("select * from create_complaint where customer_id=".$admRes['cust_id']." limit 0,10");
									while($comlpaint=mysql_fetch_assoc($compQry))
									{
										if($comlpaint['comp_status']==2){ $style='GREEN';}
										else{ $style='';}
										$compCatRes=mysql_fetch_assoc(mysql_query("select * from complaint_prefer where id=".$comlpaint['comp_cat']));
										?>
										<tr>
											<td><?php echo $DI;?></td>
											<td><?php echo $comlpaint['comp_ticketno'];?></td>
											<td><?php echo $compCatRes['category'];?></td>
											<td><?php echo $comlpaint['complaint'];?></td>
											<td><?php echo $comlpaint['created_date'];?></td>
											<td><?php echo $comlpaint['edited_on'];?></td>
											<td style="background-color:<?php echo $style;?>"><?php if($comlpaint['comp_status']=="0"){ echo "Pending";}elseif($comlpaint['comp_status']=="1"){ echo "Processing";}elseif($comlpaint['comp_status']=="2"){ echo "Closed";}?></td>
											<td><?php echo $comlpaint['comp_remarks'];?></td>
										</tr>
									<?php 
										$DI++;
									}
									?>
									</tbody>
								</table>
							</div>
						</div>							
					</div>
			<?php
					}
					elseif($count>1)
					{
			?>
					<div class="row">
						<h3 align="center">Multiple results found by this number..</h3>
					</div>
			<?php
					}
					else
					{
			?>
					<div class="row">
						<h3 align="center">No results found..</h3>
					</div>
			<?php
					}
				}
			?>
    </section>
</div>
	<?php 
	}
	else
	{ 
		redirect('/');
	}?>