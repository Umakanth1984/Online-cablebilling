<?php
extract($emp_access);
if($usersE ==1){ ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Digital Cables  - Edit LCO</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">LCO</a></li>
            <li class="active">Edit LCO</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
	   <?php foreach($edit_user as $key => $user ){} ?>
	    <?php if(isset($msg)){ echo $msg;} ?>
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
                  <label for="inputLname" class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputLname" value="<?php echo $user['emp_last_name'];?>" name="inputLname" placeholder="Last Name">
                  </div>
                </div>
				<div class="form-group">
					<label for="inputAddr1" class="col-sm-2 control-label">Address 1 *:</label>
					<div class="col-sm-10">
						<textarea class="form-control" rows="3" id="inputAddr1" name="inputAddr1" required><?php echo $user['emp_add1'];?></textarea>
					</div>
				</div>
			    <!--<div class="form-group">
					<label for="lco_portal_url" class="col-sm-2 control-label">LCO Portal URL</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lco_portal_url" name="lco_portal_url" placeholder="LCO Portal URL" value="<?php echo $user['lco_portal_url'];?>" maxlength=100 required>
					</div>
				</div>
				<div class="form-group">
					<label for="lco_username" class="col-sm-2 control-label">LCO Portal Username</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lco_username" name="lco_username" placeholder="LCO Portal Username" value="<?php echo $user['lco_username'];?>" maxlength=30 required>
					</div>
				</div>
				<div class="form-group">
					<label for="lco_password" class="col-sm-2 control-label">LCO Portal Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lco_password" name="lco_password" placeholder="LCO Portal Password" value="<?php echo $user['lco_password'];?>" maxlength=30 required>
					</div>
				</div>-->
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
                  <label for="inputCity" class="col-sm-2 control-label">City</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputCity" value="<?php echo $user['emp_city'];?>" name="inputCity">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPincode" class="col-sm-2 control-label">PinCode</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputPincode" value="<?php echo $user['emp_pin_code'];?>" name="inputPincode">
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputEmail" class="col-sm-2 control-label">Email Id *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail" value="<?php echo $user['emp_email'];?>" name="inputEmail" required readonly>
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
                    <input type="text" class="form-control" id="inputMobile" value="<?php echo $user['emp_mobile_no'];?>" name="inputMobile" required>
                  </div>
                </div>
				<div class="form-group">
                    <label for="inputusertype" class="col-sm-2 control-label">User Type *</label>
				    <div class="col-sm-10">
					    <select class="form-control" id="inputusertype" name="inputusertype" required>
    						<option value="">Select Option</option>
    						<option value="1" <?php if($user['user_type']==1){echo "Selected";} ?>>Admin</option>
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
					<a class="btn btn-default pull-right" href="<?php echo base_url()?>user/employees_list">Back</a>
			<?php 	}
					else
					{
			?>
					<button type="submit" id="userSubmit" name="userSubmit" class="btn btn-info pull-right">Update</button>
					<a class="btn btn-default pull-right" href="<?php echo base_url()?>user/employees_list">Back</a>	
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