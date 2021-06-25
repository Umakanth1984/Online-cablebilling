<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
			extract($userAccess);		 
 if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Indent Inventory List      
      </h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Reports</a></li>
			<li><a  href="#">Inventory</a></li>
			<li class="active"><a  href="#">Indent Inventory</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
        <div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Indent Inventory List</h3>
					<a  href="<?php echo base_url()?>excelsheet/empindent" class="pull-right btn btn-primary">Export to Excel</a>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<table id="example2" class="table table-bordered table-hover">
						<thead>
						<tr>
							<th>S.No</th>
							<th>Employee Name</th>
							<th>Item Name</th>
							<th>Item Number</th>
							<th>Quantity</th>
							<th>Requested Date</th>
							<th>Delivery Date</th>
							<th>Received Date</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach($indent as $key => $indent_data)
						{
							$emp_ID=$indent_data['emp_id'];
							$empqry=mysql_query("select * from employes_reg where emp_id='$emp_ID'");
							$empres=mysql_fetch_assoc($empqry);
							$inv_ID=$indent_data['inv_id'];
							$invqry=mysql_query("select * from inventory_items where inv_id='$inv_ID'");
							$invres=mysql_fetch_assoc($invqry);
						?>  
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $empres['emp_first_name'];?></td>
							<td><?php echo $invres['name'];?></td>
							<td><?php echo $invres['item_number'];?></td>
							<td><?php echo $indent_data['required_qty'];?></td>
							<td><?php echo $indent_data['required_date'];?></td>
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