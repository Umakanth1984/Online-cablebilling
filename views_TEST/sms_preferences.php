<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - SMS Preferences</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Settings</a></li>
			<li>Preferences</li>
			<li class="active">SMS Preferences</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			<?php foreach($get_sms as $key => $sms_data){}?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>preferences/save_sms_prefer"> 
        <!-- left column -->
        <div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">SMS</h3>
				</div>
            <!-- /.box-header -->
				<div class="box-body">
					<div class="form-group">
						<label for="sendsms" class="col-sm-6 control-label">Send SMS</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendsms" name="sendsms">
								<option value="Yes" <?php if($sms_data['sendsms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendsms']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendinvoicesms" class="col-sm-6 control-label">Send Invoice Generation SMS</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendinvoicesms" name="sendinvoicesms">
								<option value="Yes" <?php if($sms_data['sendinvoicesms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendinvoicesms']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendpaymentsms" class="col-sm-6 control-label">Send Payment Receipt SMS</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendpaymentsms" name="sendpaymentsms">
								<option value="Yes" <?php if($sms_data['sendpaymentsms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendpaymentsms']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendservicesmscustomer" class="col-sm-6 control-label">Send Service SMS to Customer	</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendservicesmscustomer" name="sendservicesmscustomer">
								<option value="Yes" <?php if($sms_data['sendservicesmscustomer']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendservicesmscustomer']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendservicesmsdealer" class="col-sm-6 control-label">Send Service SMS to Dealer	</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendservicesmsdealer" name="sendservicesmsdealer">
								<option value="Yes" <?php if($sms_data['sendservicesmsdealer']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendservicesmsdealer']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendservicesmsemployee" class="col-sm-6 control-label">Send Service SMS to Employee</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendservicesmsemployee" name="sendservicesmsemployee">
								<option value="Yes" <?php if($sms_data['sendservicesmsemployee']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendservicesmsemployee']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendcomplaintsms" class="col-sm-6 control-label">Send Complaint Extend SMS</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendcomplaintsms" name="sendcomplaintsms">
								<option value="Yes" <?php if($sms_data['sendcomplaintsms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendcomplaintsms']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendwelcomesms" class="col-sm-6 control-label">Send Welcome SMS To Customer</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendwelcomesms" name="sendwelcomesms">
								<option value="Yes" <?php if($sms_data['sendwelcomesms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendwelcomesms']=='No'){ echo "selected";} ?>>No</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="sendonetimesms" class="col-sm-6 control-label">Send One Time Charges SMS</label>
						<div class="col-sm-6">
							<select class="form-control" id="sendonetimesms" name="sendonetimesms">
								<option value="Yes" <?php if($sms_data['sendonetimesms']=='Yes'){ echo "selected";} ?>>Yes</option>
								<option value="No" <?php if($sms_data['sendonetimesms']=='No'){ echo "selected";} ?>>No</option>
							</select>
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
            <!-- /.box-header -->
            <!-- form start -->
				<div class="box-body">
					<div class="form-group">
						<label for="smsuser" class="col-sm-6 control-label">SMS User</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="smsuser" name="smsuser" value="<?=$sms_data['smsuser'];?>" placeholder="SMS User" maxlength=20 required>
						</div>
					</div>
					<div class="form-group">
						<label for="smspwd" class="col-sm-6 control-label">SMS Password</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="smspwd" name="smspwd" value="<?=$sms_data['smspwd'];?>" placeholder="SMS Password" maxlength=32 required>
						</div>
					</div>
					<div class="form-group">
						<label for="sms_sender_id" class="col-sm-6 control-label">SMS Sender ID</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="sms_sender_id" name="sms_sender_id" value="<?=$sms_data['sms_sender_id'];?>" placeholder="SMS Sender ID" maxlength=7 required>
						</div>
					</div>
					<div class="form-group">
						<label for="pendingamountsms" class="col-sm-4 control-label">Pending Amount SMS</label>
						<div class="col-sm-4">
							<select class="form-control" id="smstype" name="smstype">
								<option value="frequency" <?php if($sms_data['smstype']=='frequency'){ echo "selected";} ?>>Frequency</option>
								<option value="fixedrate" <?php if($sms_data['smstype']=='fixedrate'){ echo "selected";} ?>>Fixed Rate</option>
							</select>
						</div>
						<div class="col-sm-4">
							<select class="form-control" id="smsfrequency" name="smsfrequency">
								<option value="0" <?php if($sms_data['smsfrequency']=='0'){ echo "selected";} ?>>Never</option>
								<option value="1" <?php if($sms_data['smsfrequency']=='1'){ echo "selected";} ?>>1</option>
								<option value="2" <?php if($sms_data['smsfrequency']=='2'){ echo "selected";} ?>>2</option>
								<option value="3" <?php if($sms_data['smsfrequency']=='3'){ echo "selected";} ?>>3</option>
								<option value="4" <?php if($sms_data['smsfrequency']=='4'){ echo "selected";} ?>>4</option>
								<option value="5" <?php if($sms_data['smsfrequency']=='5'){ echo "selected";} ?>>5</option>
								<option value="6" <?php if($sms_data['smsfrequency']=='6'){ echo "selected";} ?>>6</option>
								<option value="7" <?php if($sms_data['smsfrequency']=='7'){ echo "selected";} ?>>7</option>
								<option value="8" <?php if($sms_data['smsfrequency']=='8'){ echo "selected";} ?>>8</option>
								<option value="9" <?php if($sms_data['smsfrequency']=='9'){ echo "selected";} ?>>9</option>
								<option value="10" <?php if($sms_data['smsfrequency']=='10'){ echo "selected";} ?>>10</option>
								<option value="11" <?php if($sms_data['smsfrequency']=='11'){ echo "selected";} ?>>11</option>
								<option value="12" <?php if($sms_data['smsfrequency']=='12'){ echo "selected";} ?>>12</option>
								<option value="13" <?php if($sms_data['smsfrequency']=='13'){ echo "selected";} ?>>13</option>
								<option value="14" <?php if($sms_data['smsfrequency']=='14'){ echo "selected";} ?>>14</option>
								<option value="15" <?php if($sms_data['smsfrequency']=='15'){ echo "selected";} ?>>15</option>
								<option value="16" <?php if($sms_data['smsfrequency']=='16'){ echo "selected";} ?>>16</option>
								<option value="17" <?php if($sms_data['smsfrequency']=='17'){ echo "selected";} ?>>17</option>
								<option value="18" <?php if($sms_data['smsfrequency']=='18'){ echo "selected";} ?>>18</option>
								<option value="19" <?php if($sms_data['smsfrequency']=='19'){ echo "selected";} ?>>19</option>
								<option value="20" <?php if($sms_data['smsfrequency']=='20'){ echo "selected";} ?>>20</option>
								<option value="21" <?php if($sms_data['smsfrequency']=='21'){ echo "selected";} ?>>21</option>
								<option value="22" <?php if($sms_data['smsfrequency']=='22'){ echo "selected";} ?>>22</option>
								<option value="23" <?php if($sms_data['smsfrequency']=='23'){ echo "selected";} ?>>23</option>
								<option value="24" <?php if($sms_data['smsfrequency']=='24'){ echo "selected";} ?>>24</option>
								<option value="25" <?php if($sms_data['smsfrequency']=='25'){ echo "selected";} ?>>25</option>
								<option value="26" <?php if($sms_data['smsfrequency']=='26'){ echo "selected";} ?>>26</option>
								<option value="27" <?php if($sms_data['smsfrequency']=='27'){ echo "selected";} ?>>27</option>
								<option value="28" <?php if($sms_data['smsfrequency']=='28'){ echo "selected";} ?>>28</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="txtSMSAmtLimit" class="col-sm-6 control-label">Amount Limit For SMS</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="txtSMSAmtLimit" value="<?=$sms_data['txtSMSAmtLimit'];?>" name="txtSMSAmtLimit" placeholder="Amount Limit For SMS">
						</div>
					</div>
					<div class="form-group">
						<label for="sendoutstandingsms" class="col-sm-6 control-label">Send OutStanding Amount SMS</label>
						<div class="col-sm-6">
							<select name="sendoutstandingsms" name="sendoutstandingsms" class="form-control">
								<option value="No"  <?php if($sms_data['sendoutstandingsms']=='No'){ echo "selected";} ?>>No</option>
								<option value="Yes"  <?php if($sms_data['sendoutstandingsms']=='Yes'){ echo "selected";} ?>>Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="senddailyreportsms" class="col-sm-6 control-label">Send Daily Report SMS</label>
						<div class="col-sm-6">
							<select name="senddailyreportsms" id="senddailyreportsms" class="form-control">
								<option value="No" <?php if($sms_data['senddailyreportsms']=='No'){ echo "selected";} ?>>No</option>
								<option value="Yes" <?php if($sms_data['senddailyreportsms']=='Yes'){ echo "selected";} ?>>Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="SendCustomerDeactivationSms" class="col-sm-6 control-label">Send Customer Deactivation SMS</label>
						<div class="col-sm-6">
							<select name="SendCustomerDeactivationSms" id="SendCustomerDeactivationSms" class="form-control">
								<option value="No" <?php if($sms_data['SendCustomerDeactivationSms']=='No'){ echo "selected";} ?>>No</option>
								<option value="Yes" <?php if($sms_data['SendCustomerDeactivationSms']=='Yes'){ echo "selected";} ?>>Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="PendingSmstoAll" class="col-sm-6 control-label">Send Pending Amount SMS To</label>
						<div class="col-sm-6">
							<select name="PendingSmstoAll" id="PendingSmstoAll" class="form-control">
								<option value="activecustomers" <?php if($sms_data['PendingSmstoAll']=='activecustomers'){ echo "selected";} ?>>Active Customers</option>
								<option value="allcustomers" <?php if($sms_data['PendingSmstoAll']=='allcustomers'){ echo "selected";} ?>>ALL Customers</option>
							</select>
						</div>
					</div>
				</div>
			</div>
        </div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="sms_api_url" class="col-sm-2 control-label">SMS API URL</label>
					<div class="col-sm-10">
						<!--	<input type="text" class="form-control" id="sms_api_url" name="sms_api_url" value="<?=$sms_data['sms_api_url'];?>" placeholder="SMS API URL" required>	-->
						<textarea class="form-control" id="sms_api_url" name="sms_api_url" rows=2 required><?php echo $sms_data['sms_api_url'];?></textarea>
					</div>
				</div>
			</div>
			<div class="box-footer" style="text-align:center;">
                <button type="submit" id="smsupdate" name="smsupdate" class="btn btn-info">Update</button>
            </div>
		</form>
		</div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>