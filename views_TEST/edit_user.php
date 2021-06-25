<?php $userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
if($usersE ==1){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Digital Cables  - Edit Employee</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Employee</a></li>
            <li class="active">Edit Employee</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php foreach($edit_user as $key => $user ){} ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
	<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/user_updated/<?php echo $user['emp_id']?>"> 
        <!-- left column -->
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Personal Data</h3>
            </div>
            <div class="box-body">
				<div class="form-group">
                  <label for="inputFname" class="col-sm-2 control-label">First Name *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputFname" value="<?php echo $user['emp_first_name'];?>" name="inputFname" placeholder="First Name" required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputLname" class="col-sm-2 control-label">Last Name *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputLname" value="<?php echo $user['emp_last_name'];?>" name="inputLname" placeholder="Last Name" required>
                  </div>
                </div>
				<div class="form-group">
					<label for="inputAddr1" class="col-sm-2 control-label">Address 1 *:</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="3" id="inputAddr1" name="inputAddr1" required><?php echo $user['emp_add1'];?> </textarea>
					</div>
				</div>
			   <div class="form-group">
					<label for="inputAddr2" class="col-sm-2 control-label">Address 2:</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="3" id="inputAddr2" name="inputAddr2"><?php echo $user['emp_add2'];?></textarea>
					</div>
              </div>
			   <div class="form-group">
					<label for="inputAddr3" class="col-sm-2 control-label">Address 3:</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="3" id="inputAddr3" name="inputAddr3"><?php echo $user['emp_add3'];?></textarea>
					</div>
              </div>
            </div>
          </div>
        </div>
        <!--/.col (left) -->
		<div class="col-md-6">
          <div class="box box-info">
              <div class="box-header with-border">
              <h3 class="box-title">&nbsp;</h3>
            </div>
              <div class="box-body">
                
				 <div class="form-group">
                  <label for="inputCity" class="col-sm-2 control-label">City *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputCity" value="<?php echo $user['emp_city'];?>" name="inputCity" required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPincode" class="col-sm-2 control-label">PinCode *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPincode" value="<?php echo $user['emp_pin_code'];?>" name="inputPincode" required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email Id *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail" value="<?php echo $user['emp_email'];?>" name="inputEmail" required>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPhone" class="col-sm-2 control-label">Phone </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPhone" value="<?php echo $user['emp_phone_no'];?>" name="inputPhone">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputMobile" class="col-sm-2 control-label">Mobile *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputMobile" value="<?php echo $user['emp_mobile_no'];?>" name="inputMobile"  required>
                  </div>
                </div>
			 
				 <div class="form-group">
                  <label for="inputusertype" class="col-sm-2 control-label">User Type *</label>
				   <div class="col-sm-10">
					  <select class="form-control" id="inputusertype" name="inputusertype" required>
						<option value="">Select Option</option>
						<option value="1" <?php if($user['user_type']==1){echo "Selected";} ?>>Admin</option>
						<option value="2" <?php if($user['user_type']==2){echo "Selected";} ?>>Employee</option>
						<option value="3" <?php if($user['user_type']==3){echo "Selected";} ?>>Technical Person </option>
					  </select>
				  </div>
                </div>
				<div class="form-group">
					<label for="inputusertype" class="col-sm-2 control-label">User Role *</label>
					<div class="col-sm-10">
						<select class="form-control" id="inputuserrole" name="inputuserrole" required>
							<option value="">Select Employee Role</option>
						<?php 
							$roleqry=mysql_query("select * from emp_prefer");
							while($roleres=mysql_fetch_assoc($roleqry))
							{
						?>	
								<option value="<?=$roleres['employeerole'];?>" <?php if($roleres['employeerole'] == $user['user_role']){echo "Selected";} ?>><?=$roleres['employeerole'];?></option>
						<?php
							}
						?>
						</select>
					</div>
                </div>
              </div>
          </div>
        </div>
			<div class="box-footer">
			<?php if($user_exists == 1)
					{ 
			?>
					<a class="btn btn-default pull-right" href="<?php echo base_url()?>user/employees_list/">Back</a>
			<?php 	}
					else
					{
			?>
					<button type="submit" id="userSubmit" name="userSubmit" class="btn btn-info pull-right">Update</button>
					<a class="btn btn-default pull-right" href="<?php echo base_url()?>user/employees_list/">Back</a>	
			<?php 	} ?>
            </div>
	</form>
      </div>
    </section>
  </div>
 <?php 
	}
	else
	{ 
		redirect('/welcome');
	}?>