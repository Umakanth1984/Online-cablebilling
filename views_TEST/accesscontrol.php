<?php $userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
	extract($userAccess);		 
 $checkEmpType=mysql_fetch_assoc(mysql_query("SELECT * FROM employes_reg WHERE emp_id=$access_emp_id"));
 if(($usersE ==1) || ($usersV ==1) || ($usersD ==1)){ ?>
  
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Access Control</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Users</a></li>
			<li class="active">Access Control</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
		 <?php  foreach($emp_access_list as $key => $user_access ){}?>  
		 <?php if(isset($msg)){ echo $msg; } ?>
		<form id="empGrpForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>user/emp_access_edit"> 
				<input type="hidden" name="access_emp_id" id="access_emp_id" value="<?php echo $access_emp_id; ?>">
				<input type="hidden" name="userType" id="userType" value="<?php echo $checkEmpType['user_type']; ?>">
	 
			<div class="box">
            <div class="box-header">
              <h3 class="box-title"> Access Control </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-body">
						<table border="1" class="table table-bordered table-hover" style="width:100%;">
						<!-- <tr align="middle">
							  <th style="text-align:left;" >Select All <input type="checkbox" name="checkAll" id="checkAll"></th>
							  <th style="text-align:center;"></th>
							  <th style="text-align:center;"></th>
							  <th style="text-align:center;"></th>
							  <th style="text-align:center;"></th>
						</tr> -->
							<tr align="middle">
							  <th style="text-align:center;">Modules</th>
							  <th style="text-align:center;">Add</th>
							  <th style="text-align:center;">Edit</th>
							  <th style="text-align:center;">View</th>
							  <th style="text-align:center;">Delete</th>
							</tr>
							<tr>
							  <th style="text-align:center;">Customer</th>
							  <td align="middle"><input type="checkbox" name="custA" id="custA" value="1" <?php if($user_access['custA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="custE" id="custE" value="1" <?php if($user_access['custE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="custV" id="custV" value="1" <?php if($user_access['custV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="custD" id="custD" value="1" <?php if($user_access['custD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Package</th>
								 <td align="middle"><input type="checkbox" name="packageA" id="packageA" value="1" <?php if($user_access['packageA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="packageE" id="packageE" value="1" <?php if($user_access['packageE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="packageV" id="packageV" value="1" <?php if($user_access['packageV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="packageD" id="packageD" value="1" <?php if($user_access['packageD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Complaints</th>
								 <td align="middle"><input type="checkbox" name="complA" id="complA" value="1" <?php if($user_access['complA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="complE" id="complE" value="1" <?php if($user_access['complE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="complV" id="complV" value="1" <?php if($user_access['complV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="complD" id="complD" value="1" <?php if($user_access['complD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Groups</th>
								 <td align="middle"><input type="checkbox" name="gropusA" id="gropusA" value="1" <?php if($user_access['gropusA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="gropusE" id="gropusE" value="1" <?php if($user_access['gropusE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="gropusV" id="gropusV" value="1" <?php if($user_access['gropusV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="gropusD" id="gropusD" value="1" <?php if($user_access['gropusD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Expenses</th>
								 <td align="middle"><input type="checkbox" name="invA" id="invA" value="1" <?php if($user_access['invA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="invE" id="invE" value="1" <?php if($user_access['invE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="invV" id="invV" value="1" <?php if($user_access['invV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="invD" id="invD" value="1" <?php if($user_access['invD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Users</th>
								 <td align="middle"><input type="checkbox" name="usersA" id="usersA" value="1" <?php if($user_access['usersA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="usersE" id="usersE" value="1" <?php if($user_access['usersE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="usersV" id="usersV" value="1" <?php if($user_access['usersV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="usersD" id="usersD" value="1" <?php if($user_access['usersD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Settings</th>
								 <td align="middle"><input type="checkbox" name="settingsA" id="settingsA" value="1" <?php if($user_access['settingsA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="settingsE" id="settingsE" value="1" <?php if($user_access['settingsE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="settingsV" id="settingsV" value="1" <?php if($user_access['settingsV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="settingsD" id="settingsD" value="1" <?php if($user_access['settingsD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Payments</th>
								 <td align="middle"><input type="checkbox" name="paymentsA" id="paymentsA" value="1" <?php if($user_access['paymentsA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="paymentsE" id="paymentsE" value="1" <?php if($user_access['paymentsE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="paymentsV" id="paymentsV" value="1" <?php if($user_access['paymentsV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="paymentsD" id="paymentsD" value="1" <?php if($user_access['paymentsD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Employee Deposite</th>
								 <td align="middle"><input type="checkbox" name="empdepositeA" id="empdepositeA" value="1" <?php if($user_access['empdepositeA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empdepositeE" id="empdepositeE" value="1" <?php if($user_access['empdepositeE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empdepositeV" id="empdepositeV" value="1" <?php if($user_access['empdepositeV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empdepositeD" id="empdepositeD" value="1" <?php if($user_access['empdepositeD']==1){ echo "checked";} ?>></td>
							</tr>
							<!--<tr>
							  <th style="text-align:center;">Dealer Inventory</th>
								 <td align="middle"><input type="checkbox" name="dealerinvA" id="dealerinvA" value="1" <?php if($user_access['dealerinvA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="dealerinvE" id="dealerinvE" value="1" <?php if($user_access['dealerinvE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="dealerinvV" id="dealerinvV" value="1" <?php if($user_access['dealerinvV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="dealerinvD" id="dealerinvD" value="1" <?php if($user_access['dealerinvD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Employee Inventory</th>
								 <td align="middle"><input type="checkbox" name="empinvA" id="empinvA" value="1" <?php if($user_access['empinvA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empinvE" id="empinvE" value="1" <?php if($user_access['empinvE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empinvV" id="empinvV" value="1" <?php if($user_access['empinvV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="empinvD" id="empinvD" value="1" <?php if($user_access['empinvD']==1){ echo "checked";} ?>></td>
							</tr>
							<tr>
							  <th style="text-align:center;">Indent</th>
								 <td align="middle"><input type="checkbox" name="indentA" id="indentA" value="1" <?php if($user_access['indentA']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="indentE" id="indentE" value="1" <?php if($user_access['indentE']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="indentV" id="indentV" value="1" <?php if($user_access['indentV']==1){ echo "checked";} ?>></td>
							  <td align="middle"><input type="checkbox" name="indentD" id="indentD" value="1" <?php if($user_access['indentD']==1){ echo "checked";} ?>></td>
							</tr>-->
							<tr>
							  <th style="text-align:center;">Reset Password</th>
							  <td align="middle">X</td>
							  <td align="middle">X</td>
							  <td align="middle"><input type="checkbox" name="resetPwd" id="resetPwd" value="1" <?php if($user_access['resetPwd']==1){ echo "checked";} ?>></td>
							  <td align="middle">X</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
            </div>
          </div>
			<div class="box-footer">
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Submit</button>
            </div>
		</form>
        </div>
      </div>
    </section>
  </div>
	<?php 
	}
	else
	{ 
		redirect('/welcome');
	}?>