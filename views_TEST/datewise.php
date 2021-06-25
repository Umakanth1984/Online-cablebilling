<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Digital Cables  - Datewise Group History
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Reports</a></li>
        <li class="active">Datewise Group History</li>
      </ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Datewise Group History</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>reports/datewise">
						<div class="box-body">
							<div class="form-group">
								<!--<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="inputGroup" name="inputGroup">
											<option value="">Select Group</option>
										<?php
											$grp_qry=mysql_query("select group_id,group_name from groups");
											while($grp_res=mysql_fetch_assoc($grp_qry))
											{
										?>
											<option value="<?php echo $grp_res['group_id'];?>" <?php if(isset($_REQUEST['inputGroup']) && $_REQUEST['inputGroup']==$grp_res['group_id']){ echo "selected";}?>><?php echo $grp_res['group_name'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>-->
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="fromdate">From Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="fromdate" name="fromdate" <?php if(isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!=''){?> value="<?php echo $_REQUEST['fromdate']; ?>" <?php }else{ ?> value="<?php echo date("Y-m-d");?>"<?php } ?>>
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-4">
										<label for="todate">To Date</label>
									</div>
									<div class="col-md-8">
										<input type="date" class="form-control" id="todate" name="todate" <?php if(isset($_REQUEST['todate']) && $_REQUEST['todate']!=''){?> value="<?php echo $_REQUEST['todate']; ?>" <?php }else{ ?> value="<?php echo date("Y-m-d",strtotime("+1 day"));?>"<?php } ?>>
									</div>
								</div>
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
									<th>Amount</th>
									<th>Group Name</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
						   <?php
							$i=1;$totAmt=0;
							$month=date("Y-m-00 00:00:00");
							if((isset($_REQUEST['fromdate']) && $_REQUEST['fromdate']!='') && (isset($_REQUEST['todate']) && $_REQUEST['todate']!=''))
							{
								$org_fromdate=strtotime($_REQUEST['fromdate']);
								$from_date=date("Y-m-d H:i:s",$org_fromdate);
								// $org_todate=strtotime('+23 hours +59 minutes +59 seconds', strtotime('2016-12-03'));
								$org_todate=strtotime($_REQUEST['todate']);
								$to_date=date("Y-m-d H:i:s",$org_todate);
							}
							else
							{
								$from_date = date("Y-m-d");
								$to_date = date("Y-m-d",strtotime("+1 day"));
							}
							foreach($payments as $key => $payment )
							{	
								$grp_id=$payment['group_id'];
								$payQry=mysql_query("select SUM(amount_paid) as total,dateCreated from payments where dateCreated BETWEEN '$from_date' AND '$to_date' and grp_id='$grp_id'");
								$payRes=mysql_fetch_assoc($payQry);
							?>  
								<tr>
									<td><?php echo $i;?></td>
									<td><?php if($payRes['total']==''){ echo '0';}else{ echo $payRes['total'];}?></td>
									<td><?php echo $payment['group_name'];?></td>
									<td><?php echo $payRes['dateCreated'];?></td>
								</tr>
						<?php
							$i=$i+1;
							$totAmt=$totAmt+$payRes['total'];
							}?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="11" align="right">Total Amount : <b style="color:red;">Rs. <?php echo $totAmt;?></b></td>
								</tr>
							</tfoot>
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
<?php } else{ 
	 redirect('/');
  }?>