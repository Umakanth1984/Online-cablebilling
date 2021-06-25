<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Connections List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Customers</a></li>
			<li class="active"><a  href="#">Connections Customers</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Connections Customers List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Group Name</th>
							<th>Total Connections</th>
							<th>Active Connections</th>
							<th>Inactive Connections</th>
							<!--<th>New Connections</th>
							<th>Reactive Connections</th>
							<th>Disconnected Connections</th>
							<th>Closing Active Connections</th> -->
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($connection as $key => $connection_data)
						{
							$pack_ID=$connection_data['package_id'];
							$packqry=mysql_query("select * from packages where package_id='$pack_ID'");
							$packres=mysql_fetch_assoc($packqry);
							$grp_ID=$connection_data['group_id'];
							$activeqry=mysql_query("select * from customers where group_id='$grp_ID' and status=1");
							$activeres=mysql_num_rows($activeqry);
							$inactiveqry=mysql_query("select * from customers where group_id='$grp_ID' and status != 1");
							$inactiveres=mysql_num_rows($inactiveqry);
							$today=date("Y-m-d");
							$new_con_qry=mysql_query("select * from customers where group_id='$grp_ID' and status=1 and connection_date >= '$today'");
							$new_con_res=mysql_num_rows($new_con_qry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $connection_data['group_name'];?></td>
							<td><?php echo $packres['package_name'];?></td>
							<td><?php echo $activeres;?></td>
							<td><?php echo $inactiveres;?></td>
							<!-- <td><?php echo $new_con_res;?></td>
							<td></td>
							<td></td>
							<td></td> -->
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