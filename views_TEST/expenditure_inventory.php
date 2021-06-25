<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Expenditure Inventory List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Inventory</a></li>
			<li class="active"><a  href="#">Expenditure Inventory</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
				  <h3 class="box-title">Expenditure Inventory List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>S.No</th>
							<th>Customer Name</th>
							<th>Item Name</th>
							<th>Item Number</th>
							<th>Quantity</th>
							<th>Total Value</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($closed_comp as $key => $all_payments_data)
						{
						?>  
						<tr>
							<td><?php echo $i;?></td>
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