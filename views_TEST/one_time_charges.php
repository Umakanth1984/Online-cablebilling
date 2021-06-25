<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - One Time Charges List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Customers</a></li>
			<li class="active"><a  href="#">One Time Charges Customers</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">One Time Charges Customers List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Cust ID/ Acc No.</th>
							<th>Name</th>
							<th>Address</th>
							<th>Group Name</th>
							<th>Date</th>
							<th>Charge Type</th>
							<th>Charge Amount</th>
							<th>Remarks</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($inactive as $key => $active_customer_data)
						{
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $active_customer_data['custom_customer_no'];?></td>
							<td><?php echo $active_customer_data['first_name'];?></td>
							<td><?php echo $active_customer_data['addr1'].",".$active_customer_data['addr2']."<br>".$active_customer_data['addr3'];?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php
							$i++;
						}
						?>
						</tbody>
					</table>
				</div>
            <!-- /.box-body -->
			</div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
  <?php } else{ 
	 redirect('/');
  }?>  