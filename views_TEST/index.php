<?php
	$empList=array();
	$empName='';
	$today=date('Y-m-d 00:00:00');
	extract($employee_info);
	extract($emp_access);
	$month=date('Y-m-00 00:00:00');
	$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
	$grp_ids=$chkEmpGrps['group_ids'];
	$admin_id = $employee_info['admin_id'];
	if($user_type==9)
	{
	    $today_qry=mysql_query("select SUM(amount) as amount_paid from f_accounting where dateCreated > '$today' AND type='debit'");
    	$today_res=mysql_fetch_assoc($today_qry);
    	$amt_qry=mysql_query("select SUM(amount) as amount_paid from f_accounting where dateCreated >= '".$month."' AND type='debit'");
    	$amt_res=mysql_fetch_assoc($amt_qry);
    	$online_amt_qry=mysql_query("select SUM(amount_paid) as amount_paid from payments where emp_id=0 AND dateCreated >= '$month'");
    	$online_amt_res=mysql_fetch_assoc($online_amt_qry);
	}
	elseif($user_type!=9)
	{
	    $today_qry=mysql_query("select SUM(amount) as amount_paid from cust_accounting where dateCreated > '$today' AND admin_id = '$admin_id'");
    	$today_res=mysql_fetch_assoc($today_qry);
    	$amt_qry=mysql_query("select SUM(amount) as amount_paid from cust_accounting where dateCreated >= '".$month."' AND admin_id = '$admin_id'");
    	$amt_res=mysql_fetch_assoc($amt_qry);
    	$online_amt_qry=mysql_query("select SUM(amount_paid) as amount_paid from payments where emp_id=0 AND dateCreated >= '$month'");
    	$online_amt_res=mysql_fetch_assoc($online_amt_qry);
	}
?>
<style>
.bg-red1{
background-color:#D2D820 !important;
}
.bg-purple1{
background-color:#2058D8 !important;	
}

.bg-lime1{
background-color:#852895 !important;	

}
.bg-purple2{
background-color:#AB69FA !important;
}
.bg-lime2{
background-color:#F77C36 !important;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding-bottom: 15px;" onclick="location.href='<?php echo base_url()?>reports/franchise?fromdate=<?php echo date("Y-m-d");?>&todate=<?php echo date("Y-m-d");?>'">
				<div class="card effect__hover">
					<div class="small-box bg-aqua card__front">
					<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Today Collection</sup></h3>
						</div>
						<a href="<?php echo base_url()?>reports/franchise?fromdate=<?php echo date("Y-m-d");?>&todate=<?php echo date("Y-m-d");?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-aqua card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Rs.</sup><?php echo round($today_res['amount_paid'],2);?></h3>
							<p>Today Collection</p>
						</div>
						<a href="<?php echo base_url()?>reports/franchise?fromdate=<?php echo date("Y-m-d");?>&todate=<?php echo date("Y-m-d");?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
		    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" onclick="location.href='<?php echo base_url()?>customer/onlinepayment'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-maroon card__front">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Online Collection</sup></h3>
						</div>
						<a href="<?php echo base_url()?>customer/onlinepayment" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-maroon card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Rs.</sup><?php echo round($online_amt_res['amount_paid'],2);?></h3>
							<p>Online Collection</p>
						</div>
						<a  href="<?php echo base_url()?>customer/onlinepayment" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-maroon card__front">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Monthly Collection</sup></h3>
						</div>
						<!--<a  href="<?php echo base_url()?>customer/monthlypaymentslist" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
					</div>
					<div class="small-box bg-maroon card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Rs.</sup><?php echo round($amt_res['amount_paid'],2);?></h3>
							<p>Monthly Collection</p>
						</div>
						<!--<a  href="<?php echo base_url()?>customer/monthlypaymentslist" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
					</div>
				</div>
			</div>
			<!--<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer/totaloutstanding'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-red card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Total Outstanding</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>customer/totaloutstanding" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-red card__back">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Rs.</sup><?php  
							if($user_type=='9')
							{
								$tot_out_qry=mysql_query("select pending_amount from customers where 1=1");
							}
							else
							{
								$tot_out_qry=mysql_query("select pending_amount from customers where group_id IN ($grp_ids) AND admin_id='$adminId'");
							}
								$totOutAmt=0;
								while($tot_out_res=mysql_fetch_assoc($tot_out_qry))
								{
									$totOutAmt=$totOutAmt+$tot_out_res['pending_amount'];
								}
							echo $totOutAmt;?></h3>
							<p>Total Outstanding</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>customer/totaloutstanding" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<?php
			    $chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
				$grp_ids=$chkEmpGrps['group_ids'];
			    if($user_type=='9')
				{
					$tot_qry=mysql_num_rows(mysql_query("select cust_id from customers where 1=1 AND status=1"));
				}
				else
				{
					$tot_qry=mysql_num_rows(mysql_query("select cust_id from customers where 1=1 AND group_id IN ($grp_ids) AND admin_id='$adminId' AND status=1"));
				}
				if($user_type=='9')
				{
					$inact_cnt=mysql_num_rows(mysql_query("select cust_id from customers where 1=1 AND status=0"));
				}
				else
				{
					$inact_cnt=mysql_num_rows(mysql_query("select cust_id from customers where 1=1 AND group_id IN ($grp_ids) AND admin_id='$adminId'AND status=0"));
				}
			?>
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer/customer_list'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-yellow card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Active Customers</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-people"></i></div>
						<a  href="<?php echo base_url()?>customer/customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-yellow card__back">
						<div class="card__text">
							<h3><?php echo $tot_qry;?></h3>
							<p>Active Customers</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-people"></i></div>
						<a  href="<?php echo base_url()?>customer/customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer/inactive_customer_list'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-red1 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Inactive Customers</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-people"></i></div>
						<a  href="<?php echo base_url()?>customer/inactive_customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-red1 card__back">
						<div class="card__text">
							<h3><?php echo $inact_cnt;?></h3>
							<p>Inactive Customers</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-people"></i></div>
						<a  href="<?php echo base_url()?>customer/inactive_customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<!--
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer/customer_monthlydues'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-olive card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Monthly Dues</sup></h3>
						</div> 
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-color-filter"></i></div>
						<a  href="<?php echo base_url()?>customer/customer_monthlydues" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-olive card__back">
						<div class="card__text">
							<?php
								if($user_type=='9')
								{
									$monthlyDuesQry=mysql_query("select monthly_bill from customers where status=1");
								}
								else
								{
									$monthlyDuesQry=mysql_query("select monthly_bill from customers where group_id IN ($grp_ids) AND admin_id='$adminId' AND status=1");
								}
								$totDue=0;
								while($monthlyDuesRes=mysql_fetch_assoc($monthlyDuesQry))
								{
									$totDue=$totDue+$monthlyDuesRes['monthly_bill'];
								}
							?>
							<h3><sup style="font-size: 20px">Rs.</sup><?php echo $totDue;?></h3>
							<p>Monthly Dues</p>
						</div> 
						<div class="icon" style="top:10px !important;"><i class="ion ion-ios-color-filter"></i></div>
						<a  href="<?php echo base_url()?>customer/customer_monthlydues" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<?php
			    if($complV==1 && $user_type!=9)
			    {
			?>
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>complaints/complaints_list'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-lime1 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Open Complaints</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>complaints/complaints_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-lime1 card__back">
						<div class="card__text">
							<h3><?php  
							if($user_type=='9')
							{
								$complaint_cnt=mysql_num_rows(mysql_query("select * from create_complaint where comp_status=0"));
							}
							else
							{
								$complaint_cnt=mysql_num_rows(mysql_query("select * from create_complaint where comp_status=0 AND admin_id='$adminId'"));
							}
							echo $complaint_cnt;?></h3>
							<p>Open Complaints</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>complaints/complaints_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>complaints/closed_complaints'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-purple card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Closed Complaints</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>complaints/closed_complaints" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-purple card__back">
						<div class="card__text">
							<h3><?php 
							if($user_type=='9')
							{
								$complaint_cnt1=mysql_num_rows(mysql_query("select * from create_complaint where comp_status=2"));
							}
							else
							{
								$complaint_cnt1=mysql_num_rows(mysql_query("select * from create_complaint where comp_status=2 AND admin_id='$adminId'"));
							}
							echo $complaint_cnt1;?></h3>
							<p>Closed Complaints</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>complaints/closed_complaints" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<?php
			    }
			?>
			<!--
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>reports/expenses'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-purple2 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Total Expenses</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>reports/expenses" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-purple2 card__back">
						<div class="card__text">
							<h3><?php echo $exp_amt_qry['total_exp'];?></h3>
							<p>Total Expenses</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>reports/expenses" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>dashboard'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-aqua card__front">
					<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
					<?php
						$month=date('Y-m-00 00:00:00');
						if($user_type=='9')
						{
							$alaReq=mysql_fetch_assoc(mysql_query("select COUNT(DISTINCT(stb_id)) as totCount from alacarte_request where dateCreated >= '$month' AND sms_status=0 AND status IS NULL"));
						}
						else
						{
							$alaReq=mysql_fetch_assoc(mysql_query("select COUNT(DISTINCT(ar.stb_id)) as totCount from alacarte_request ar left join customers c ON c.cust_id=ar.cust_id where ar.dateCreated >= '$month' AND c.admin_id='$adminId' AND c.group_id IN ($grp_ids) AND ar.sms_status=0 AND ar.status IS NULL"));
						}
					?>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Pending Requests </sup></h3>
						</div>
						<a  href="<?php echo base_url();?>dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-aqua card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px"></sup><?php echo $alaReq['totCount'];?></h3>
							<p>Pending Requests</p>
						</div>
						<a  href="<?php echo base_url();?>dashboard" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" onclick="location.href='<?php echo base_url()?>customer/expiry_customer_list'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-maroon card__front">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Expired Customers</sup></h3>
						</div>
						<a href="<?php echo base_url()?>customer/expiry_customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-maroon card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
						<?php
						    $today=date("Y-m-d");
						    $tomorrow=date("Y-m-d",strtotime("+1 days"));
							if($user_type=='9')
							{
								$expiry1=$this->db->query("select COUNT(cust_id) as expiredCount from customers where status=1 AND (date(end_date)<'$today')")->row_array();
								$expiry2=$this->db->query("select COUNT(cust_id) as todayexpiryCount from customers where status=1 AND (date(end_date)='$today')")->row_array();
								$expiry3=$this->db->query("select COUNT(cust_id) as tomorrowexpiryCount from customers where status=1 AND (date(end_date)='$tomorrow')")->row_array();
							}
							else
							{
								$expiry1=$this->db->query("select COUNT(cust_id) as expiredCount from customers where status=1 AND admin_id='$adminId' AND (date(end_date)<'$today')")->row_array();
								$expiry2=$this->db->query("select COUNT(cust_id) as todayexpiryCount from customers where status=1 AND admin_id='$adminId' AND (date(end_date)='$today')")->row_array();
								$expiry3=$this->db->query("select COUNT(cust_id) as tomorrowexpiryCount from customers where status=1 AND admin_id='$adminId' AND (date(end_date)='$tomorrow')")->row_array();
							}
						?>
							<h3><sup style="font-size: 20px"></sup><?php echo $expiry1['expiredCount'];?></h3>
							<h5>Today : <b style="color:RED"><?php echo $expiry2['todayexpiryCount'];?></b>
							/Tomorrow : <b style="color:BLUE"><?php echo $expiry3['tomorrowexpiryCount'];?></b></h5>
							<p>Expired Customers</p>
						</div>
						<a href="<?php echo base_url()?>customer/expiry_customer_list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" style="padding-bottom: 15px;" onclick="location.href='<?php echo base_url()?>dashboard/requests_in_que'">
				<div class="card effect__hover">
				<?php
					$today=date("Y-m-d");
					if($user_type=='9')
					{
						$que1=$this->db->query("select cust_id from before_expiries where be_status=0 GROUP BY cust_id")->num_rows();
					}
					else
					{
						$que1=$this->db->query("select be.cust_id from before_expiries be left join customers c ON be.cust_id=c.cust_id where be.be_status=0 AND c.admin_id='$adminId' GROUP BY be.cust_id")->num_rows();
					}
				?>
					<div class="small-box bg-purple2 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Requests in Que</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-purple2 card__back">
						<div class="card__text">
							<h3><?php echo round($que1);?></h3>
							<p>Requests in Que</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a href="<?php echo base_url()?>dashboard/requests_in_que" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<!--<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>dashboard/temp_approved'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-lime2 card__front">
					<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
					<?php
						$month=date('Y-02-00 00:00:00');
						if($user_type=='9')
						{
							$alaReqTemp=mysql_fetch_assoc(mysql_query("select COUNT(DISTINCT(stb_id)) as totCount from alacarte_request where dateCreated >= '$month' AND sms_status=0 AND status=1"));
						}
						else
						{
							$alaReqTemp=mysql_fetch_assoc(mysql_query("select COUNT(DISTINCT(ar.stb_id)) as totCount from alacarte_request ar left join customers c ON c.cust_id=ar.cust_id where ar.dateCreated >= '$month' AND c.admin_id='$adminId' AND c.group_id IN ($grp_ids) AND ar.sms_status=0  AND ar.status=1"));
						}
					?>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Temp Approved Bouquet & Ala-carte Requests </sup></h3>
						</div>
						<a  href="<?php echo base_url();?>dashboard/temp_approved" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-lime2 card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px"></sup><?php echo $alaReqTemp['totCount'];?></h3>
							<p>Temp Approved Bouquet & Ala-carte Requests</p>
						</div>
						<a  href="<?php echo base_url();?>dashboard/temp_approved" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<?php
			if($user_type=='9' || $user_type=='1')
			{
			?>
			<!--<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>dashboard/batch_approve'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-purple2 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Upload Batch File</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-upload"></i></div>
						<a  href="<?php echo base_url()?>dashboard/batch_approve" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-purple2 card__back">
						<div class="card__text">
							<p>Upload Batch File</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-file"></i></div>
						<a  href="<?php echo base_url()?>dashboard/batch_approve" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<!--<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>reports/customer_renewals'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-green card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Expired</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-upload"></i></div>
						<a  href="<?php echo base_url()?>reports/customer_renewals" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-green card__back">
						<div class="card__text">
							<p>Expired</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-file"></i></div>
						<a  href="<?php echo base_url()?>reports/customer_renewals" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<!--<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>reports/removal_requests'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-purple2 card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Remove Requests</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-upload"></i></div>
						<a  href="<?php echo base_url()?>reports/removal_requests" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					<div class="small-box bg-purple2 card__back">
						<div class="card__text">
							<p>Remove Requests</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="fa fa-file"></i></div>
						<a  href="<?php echo base_url()?>reports/removal_requests" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>-->
			<?php
			}
			?>
		</div>
		<?php
		if($user_type==9)
		{
		?>
		<div class="row">
		    <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Lco Wallets List</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
						<form id="customerForm12" name="customerForm12" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url();?>excelsheet/lco_wallet_balance">
							<input type="hidden" class="form-control" id="emp_id" name="emp_id" value="<?php echo $emp_id;?>">
							<input type="submit" name="submit11" id="submit11" class="btn btn-primary pull-right" value="Export to Excel">
						</form>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>LCO Name</th>
                                        <th>Wallet Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								    $ll=1;
									foreach($lcoList as $key => $lcoListInfo)
									{
									    $a1id=$lcoListInfo['admin_id'];
								?>
                                    <tr>
                                        <td><?php echo $ll;?></td>
                                        <td><?php echo $lcoListInfo['adminFname'];?></td>
                                        <td><?php echo $lcoListInfo['balance'];?></td>
                                        <td><a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>dashboard/add_lco_credits?req_pos=<?php echo $a1id;?>'" class="btn btn-sm btn-info btn-flat pull-left">Add Wallet Balance</a></td>
                                    </tr>
								<?php
								    $ll++;
									}
								?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>dashboard/add_lco_credits'" class="btn btn-sm btn-info btn-flat pull-left">Add Credits</a>
                        <a href="javascript:void(0)" onclick="location.href='<?php echo base_url();?>dashboard/add_lco_credits'" class="btn btn-sm btn-default btn-flat pull-right">View All LCO Wallets</a>
                    </div>
                </div>
            </div>
	    </div>
	    <?php
		}
	    ?>
    </section>
</div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->