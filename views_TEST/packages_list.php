<?php
extract($emp_access);
if(($packageE ==1) || ($packageV ==1) ||($packageD ==1))
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
        <h1>Digital Cables  - Packages List</h1>
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
								<div class="col-md-5">
									<label for="package_name" class="col-md-6 control-label">Package Name</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="package_name" name="package_name" placeholder="Package Name">
									</div>
								</div>
								<?php
								    if($employee_info['user_type']==9)
								    {
								?>
								<div class="col-md-5">
								    <label for="inputEmp" class="col-md-3 control-label">LCO</label>
									<div class="col-md-9">
										<select class="form-control" id="inputEmp" name="inputEmp">
											<option value="">Select LCO</option>
										<?php
											foreach($lco_list as $key2 => $lco)
											{
										?>
											<option value="<?php echo $lco['admin_id'];?>"  <?php if($lco['admin_id'] == $_REQUEST['inputEmp']){ echo "selected";} ?>><?php echo $lco['adminFname'];?></option>
										<?php
											}
										?>
										</select>
									</div>
								</div>
								<?php
								    }
								?>
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
                                <th>Pack ID</th>
                                <th>Package Name</th>
                                <th>Description</th>
                                <th>Validity (in months)</th>
                                <?php
                                if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!='')
                                {
                                ?>
                                <th>LCO Price</th>
                                <th>Customer Price</th>
                                <?php
                                }
                                else
                                {
                                ?>
                                <th>Price</th>
                                <?php
                                }
                                ?>
                                <th>Tax(%)</th>
                                <th>Base Pack</th>
                                <?php
                                if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!='')
                                {}else{
                                ?>
                                <th>&nbsp;</th>
                                <?php
                                }
                                ?>
						    </tr>
						</thead>
						<tbody>
					<?php
						$i=1;
						foreach($packages as $key => $package )
						{
					?>
						<tr>
					        <td><?php echo $package['package_id'];?></td>
                            <td><?php echo $package['package_name'];?></td>
                            <td><?php echo $package['package_description'];?></td>
                            <td><?php echo $package['package_validity'];?></td>
                            <?php
                            if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!='')
                            {
                            ?>
                            <td><?php echo $package['lco_price'];?></td>
                            <td><?php echo $package['cust_price'];?></td>
                            <?php
                            }
                            else
                            {
                            ?>
                            <td><?php echo $package['package_price'];?></td>
                            <?php
                            }
                            ?>
                            <td><?php echo $package['package_tax1'];?></td>
                            <td><?php echo $package['isbase'];?></td>
                            <?php
                            if(isset($_REQUEST['inputEmp']) && $_REQUEST['inputEmp']!='')
                            {}else{
                            ?>
    						<?php
    							$empQry=mysql_query("select user_type from employes_reg where emp_id='$emp_id'");
    							$empRes=mysql_fetch_assoc($empQry);
    						?>
						    <td><?php if($packageV ==1){?><a  data-toggle="tooltip" data-placement="bottom"  title="View" href="<?php echo base_url()?>packages/view/<?php echo $package['package_id']?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php }if($packageE ==1){ ?><a  data-toggle="tooltip" data-placement="bottom"  title="Edit" href="<?php echo base_url()?>packages/edit/<?php echo $package['package_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php } if($empRes['user_type']==1){ if($packageD ==1){ ?><a  data-toggle="tooltip" data-placement="bottom"  title="Delete Package" onclick="return ConfirmDialog();" href="<?php echo base_url()?>packages/delete/<?php echo $package['package_id']?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a> &nbsp;&nbsp;<?php } }?></td>
						    <?php
						    }
						    ?>
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