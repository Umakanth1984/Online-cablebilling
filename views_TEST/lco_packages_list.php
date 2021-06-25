<?php
extract($emp_access);
if(($packageE==1) || ($packageD ==1))
{
?>
<script>
function ConfirmDialog()
{
    var x=confirm("Are you sure to delete this Package ?")
    if (x)
    {
        return true;
    }
    else
    {
        return false;
    }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Digital Cables - Packages List</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Packages</a></li>
            <li class="active">Packages List</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					    <h3 class="box-title">Packages List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>packages/packages_list">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-6">
									<label for="package_name" class="col-md-6 control-label">Package Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="package_name" name="package_name" placeholder="Package Name">
									</div>
								</div>
								<div class="col-md-4">
									<label for="package_price" class="col-md-6 control-label">Package Price</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="package_price" name="package_price" placeholder="Package Price">
									</div>
								</div>
								<div class="col-md-2">
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
                            <th>Package Name</th>
                            <th>Description</th>
                            <th>LCO Price</th>
                            <th>Customer Price</th>
                            <th>Tax (%)</th>
                            <th>&nbsp;</th>
						</tr>
						</thead>
						<tbody>
    					<?php
						$i=1;
						foreach($packages as $key => $packages)
				        {
    					?>
				        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $packages['package_name'];?></td>
                            <td><?php echo $packages['package_description'];?></td>
                            <td><?php echo $packages['lco_price'];?></td>
                            <td><?php echo $packages['cust_price'];?></td>
                            <td><?php echo $packages['pack_tax'];?></td>
                            <td><?php if($packageE ==1){?><a data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>packages/edit/<?php echo $packages['op_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a><?php }?></td>
						</tr>
    					<?php
    						$i++;
    					}
    					?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
    </section>
  </div>
  <?php
	}
	else
	{ 
		redirect('/');
	}
	?>