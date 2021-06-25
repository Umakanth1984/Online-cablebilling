<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - New Connection List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Customers</a></li>
			<li class="active"><a  href="#">New Connection Customers</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">New Connection Customers List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Cust ID/ Acc. No.</th>
							<th>Name</th>
							<th>Address</th>
							<th>Group</th>
							<th>Created Date</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($new_con as $key => $new_con_data)
						{
							$grp_ID=$new_con_data['group_id'];
							//$today=date("Y-m-d");
							//$new_con_qry=mysql_query("select * from customers where group_id='$grp_ID' and status=1 and connection_date > '$today'");
							//$new_con_res=mysql_fetch_assoc($new_con_qry);
							$grp_qry=mysql_query("select * from groups where group_id='$grp_ID'");
							$grp_res=mysql_fetch_assoc($grp_qry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $new_con_data['custom_customer_no'];?></td>
							<td><?php echo $new_con_data['first_name'];?></td>
							<td><?php echo $new_con_data['addr1'];?></td>
							<td><?php echo $grp_res['group_name'];?></td>
							<td><?php echo $new_con_data['dateCreated'];?></td>
							<td>Active</td>
							<td>None</td>
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