<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<html><head>
	<style>
		body,table,p{
			font-family:"Times New Roman",Georgia,Serif;
			font-size:15px;
		}
		h2,p{
			line-height:7px;
		}
		#main{
			float:left;
			width:700px;
			margin:20px 0 10px 80px;
			padding-bottom:10px;
			border:1px solid #000;
		}
		#header{
			float:left;
			width:700px;
			height:100px;
			border:1px solid #fff;
		}
		#logo{
			float:left;
			width:100px;
			height:100px;
			border:1px solid #fff;
		}
		#head{
			float:left;
			width:500px;
			height:auto;
			margin:0 0 0 50px;
			border:1px solid #fff;
		}
		#headcontent{
			float:left;
			width:700px;
			height:auto;
			margin:0 0 0 0;
			border:1px solid #fff;
		}
		#tablecontent{
			float:left;
			width:700px;
			margin:10px 0 0 2px;
			border:1px solid #fff;
		}
		#tablecontent table{
			line-height:30px;
		}
	</style>
<title>Customer Card</title></head>
<?php
	foreach($customer as $key => $cust_data){}
	$packRes=mysql_fetch_assoc(mysql_query("select * from packages where package_id=".$cust_data['package_id']));
	$busInfo=mysql_fetch_assoc(mysql_query("select business_image from business_information where business_id=1"));
?>
<body onload="window.print()">
	<div id="main">
		<div id="header">
			<div id="logo"><img src="<?php echo base_url()?>images/<?php echo $busInfo['business_image'];?>" height="100px" width="100px"></div>
			<div id="head">
				<h2><?php echo $cust_data['first_name']." ".$cust_data['last_name'];?></h2>
				<p><?php echo $cust_data['addr1'];?></p>
				<p>Mobile No. <?php echo $cust_data['mobile_no'];?></p>
			</div>
		</div>
		<div id="headcontent">
			<table width="100%" border="0" cellspacing="5" cellpadding="3">
				<tbody>
					<tr>
						<td width="18%">Card No.</td>
						<td width="3%">:</td>
						<td width="35%"> <b><?php echo $cust_data['custom_customer_no'];?></b></td>
						<td width="15%">Contact No.</td><td width="3%">:</td><td width="35%"><?php echo $cust_data['mobile_no'];?></td>
					</tr>
					<tr>
						<!--<td width="15%">Subscriber Name</td><td width="3%">:</td><td width="35%"> <b>sivaraman6 KHAN</b></td>-->
						<td width="15%">Email</td><td width="3%">:</td><td width="35%"> <b></b></td>
					</tr>
					<tr>
						<td width="15%">Address</td><td width="3%">:</td><td colspan="4" width="35%"> <?php echo $cust_data['addr1'];?></td>
					</tr>
					<tr>
						<td width="15%">City</td><td width="3%">:</td><td width="35%"> <?php echo $cust_data['city'];?> </td>
						<td width="15%">Pin Code</td><td width="3%">:</td><td width="35%"><?php echo $cust_data['pin_code'];?></td>
					</tr>
					<tr>
						<td width="15%">Package Name</td><td width="3%">:</td><td width="35%"><?php echo $packRes['package_name'];?></td>
						<td width="15%">Bill Amount</td><td width="3%">:</td><td width="35%"><?php echo $packRes['package_price'];?></td>
					</tr>
					<tr>
						<td width="15%">No of Tvs </td><td width="3%">:</td><td width="35%"></td>
						<td width="15%">STB Details</td><td width="3%">:</td><td width="35%"><?php echo $cust_data['stb_no'];?></td>
					</tr>				
				</tbody>
			</table>
		</div>
		<div id="tablecontent">
			<table width="99%" border="1" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th>Months</th>
						<th>Previous Due</th>
						<th>Monthly Bill</th>
						<th>Date of Payment</th>
						<th>Paid Amount</th>
						<th>Signature of Employee</th>
						<th>Balance</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$billQry=mysql_query("select * from billing_info where cust_id=".$cust_data['cust_id']);
					// $count=mysql_num_rows($billQry);
					// $billRes=mysql_fetch_array($billQry);
					// for($i=0;$i<$count-1;$i++)
					// foreach($billQry as $key => $billRes)
					while($billRes=mysql_fetch_assoc($billQry))
					{
					$dateGen=$billRes['dateGenerated'];
					// echo "select SUM(amount_paid) as sumAmt ,dateCreated from payments where customer_id=".$billRes['cust_id']." AND DATEPART(mm,dateCreated) = DATEPART(mm,".$dateGen.")";
					$mnth=$billRes['current_month_name'];
					$date = $mnth.' 01 '.date('Y');
					$reqDate=date('Y-m-d', strtotime($date));
					$toDate=date('Y-m-31', strtotime($date));
					// echo "select SUM(`amount_paid`) AS tot from payments where customer_id=".$billRes['cust_id']." AND dateCreated BETWEEN '".$reqDate."' AND '".$toDate."'";
						$payRes=mysql_fetch_assoc(mysql_query("select SUM(`amount_paid`) AS tot,dateCreated from payments where customer_id=".$billRes['cust_id']." AND dateCreated BETWEEN '".$reqDate."' AND '".$toDate."'"));
				?>
					<tr>
						<td><?php echo $billRes['current_month_name'];?></td>
						<td><?php echo $billRes['previous_due'];?></td>
						<td><?php echo $billRes['current_month_bill'];?></td>
						<td><?php echo $payRes['dateCreated'];?></td>
						<td><?php echo $payRes['tot'];?></td>
						<td></td>
						<td><?php echo $tot=($billRes['previous_due']+$billRes['current_month_bill']-$payRes['tot']);?></td>
					</tr>
				<?php
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
	<?php 
	}
	else
	{ 
		redirect('/');
	}?>