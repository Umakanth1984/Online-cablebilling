<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Outstanding Summary List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Collection</a></li>
			<li class="active"><a  href="#">Outstanding Summary</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Outstanding Summary List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>Sl.No</th>
							<th>Group Name</th>
							<th>Opening Balance</th>
							<th>Bill Amount</th>
							<th>Paid Amount</th>
							<th>Closing Balance</th>
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