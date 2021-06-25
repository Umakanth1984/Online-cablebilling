<?php
extract($emp_access);
extract($employee_info);
if(($usersE ==1) || ($usersV ==1) || ($usersD ==1)){ ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables - <?php if($user_type==9){ echo "LCO";}else{?>Employees<?php }?> List </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#"><?php if($user_type==9){ echo "LCO";}else{?>Employees<?php }?></a></li>
			<li class="active"><?php if($user_type==9){ echo "LCO";}else{?>Employees<?php }?> List </li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
			<?php if(isset($msg)){ echo $msg; } ?>
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><?php if($user_type==9){ echo "LCO";}else{?>Employees<?php }?> List</h3>
					</div>
					<form id="customerForm11" name="customerForm11" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/employees_list">
						<div class="box-body">
							<div class="form-group">
								<div class="col-md-3">
									<div class="col-md-12">
										<input type="text" class="form-control" id="emp_first_name" name="emp_first_name" <?php if(isset($_REQUEST['emp_first_name']) && $_REQUEST['emp_first_name']!=''){ ?> value=<?php echo $_REQUEST['emp_first_name'];?><?php } ?>  placeholder="Employee Name">
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-12">
										<input type="text" class="form-control" id="mobile" name="mobile" <?php if(isset($_REQUEST['mobile']) && $_REQUEST['mobile']!=''){ ?> value=<?php echo $_REQUEST['mobile'];?><?php } ?> placeholder="Employee Mobile">
									</div>
								</div>
								<?php if($user_type==9){?>
								<?php }else{?>
								<div class="col-md-3">
									<div class="col-md-12">
										<select class="form-control" id="type" name="type">
											<option value="">Select Option</option>
											<option value="1" <?php if($_REQUEST['type']==1){ echo "selected";} ?>>Admin</option>
											<option value="2" <?php if($_REQUEST['type']==2){ echo "selected";} ?>>Employee</option>
											<option value="3" <?php if($_REQUEST['type']==3){ echo "selected";} ?>>Technical Person </option>
										</select>
									</div>
								</div>
								<?php } ?>
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
									<th>Name</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>Type</th>
									<?php if($user_type==9){?><th>Download Packages</th><?php }?>
									<?php if($resetPwd ==1){?><th>&nbsp;</th><?php }?>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php $i=1;
							foreach($users as $key => $employees )
							{		 
							?>  
								<tr>
								  <td><?php echo $i;?></td>
								  <td><?php echo $employees['emp_first_name'] ." ".$employees['emp_last_name'];?></td>
								  <td><?php echo $employees['emp_mobile_no']?></td>
								  <td><?php echo $employees['emp_email']?></td>
								  <td><?php if($employees['user_type']==1){ echo "Admin";}elseif($employees['user_type']==2){echo "Employee";}elseif($employees['user_type']==3){echo "Technical Person";}?></td>
								  <?php if($user_type==9){?><td><a data-toggle="tooltip" data-placement="bottom" href="javascript:void(0)" data-adm="<?php echo $employees['admin_id'];?>" class="btn btn-primary downloadPack">Download</a></td><?php }?>
								  <?php if($resetPwd ==1){?><td><a data-toggle="tooltip" data-placement="bottom" href="<?php echo base_url()?>user/reset_password/<?php echo $employees['emp_id']?>" class="btn btn-primary">Reset Password</a></td><?php }?>
								  <td><?php if($usersV ==1){?><a data-toggle="tooltip" data-placement="bottom" title="View" href="<?php echo base_url()?>user/view/<?php echo $employees['emp_id']?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a><?php }?> &nbsp;&nbsp;
								  <?php if($usersE ==1){?><a data-toggle="tooltip" data-placement="bottom" title="Edit" href="<?php echo base_url()?>user/edit/<?php echo $employees['emp_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;
								  <a  data-toggle="tooltip" data-placement="bottom" title="Link Group" href="<?php echo base_url()?>user/emp_group/<?php echo $employees['emp_id']?>"><i class="fa fa-link fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;<?php }?>
								  <?php if($user_type ==1 || $user_type==9){?><a data-toggle="tooltip" data-placement="bottom" title="Access Control" href="<?php echo base_url()?>user/emp_access/<?php echo $employees['emp_id']?>"><i class="fa fa-cogs fa-lg" aria-hidden="true"></i></a><?php }?>&nbsp;&nbsp;
								    <?php if($usersD ==1){?><a data-toggle="tooltip" data-placement="bottom" title="Inactive Employee" href="<?php echo base_url()?>user/inactive_user/<?php echo $employees['emp_id']?>" onclick="javascrip:confirm('Do you want to Inactivate this Employee??')"><i class="fa fa-user-times fa-lg" aria-hidden="true"></i></a><?php }?></td>
								</tr>
							<?php $i=$i+1; }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </section>
</div>
<script>
$(document).ready(function(){
    $(".downloadPack").click(function () {
        var id = $(this).data("adm");
        $.ajax({
            type: "POST",
    		data: {id:id},
            url: "<?php echo base_url();?>user/package_download",
            success: function (result)
            {
                result = JSON.parse(result);
                if (result.status == 'success')
                {
                    window.open("<?php echo base_url(); ?>" + result.file);
                }
            }
        });
    });
});
</script>
    <?php
    }
    else
    { 
	    redirect('/welcome');
    }?>