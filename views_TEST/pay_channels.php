<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
    return true;
  } else {
    return false;
  }
}
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Ala-carte Pay Channels</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Packages</a></li>
			<li><a href="#">Ala-carte</a></li>
			<li class="active">Pay Channels</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<?php
			if(isset($_REQUEST['type']) && $_REQUEST['type']!='')
			{
				if($_REQUEST['type']==1){ $color='GREEN';}else{ $color='RED';}
				echo '<div style="color:'.$color.';font-size:20px;text-align:center">'.$_REQUEST['msg'].'</div>';
			}
			?>
		<form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action=""> 
        <!-- left column -->
			<div class="col-md-6">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Ala-carte Channel</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="channel_category" class="col-sm-4 control-label">Pay Channel Category</label>
							<div class="col-sm-8">
								<select class="form-control" id="channel_category" name="channel_category" required>
									<option value="">Select Category</option>
									<?php
										foreach($package_cat as $key => $pcInfo)
										{
									?>
									<option value="<?php echo $pcInfo['cat_id'];?>" <?php if($data['ala_ch_category']==$pcInfo['cat_id']){ echo "selected";}?>><?php echo $pcInfo['cat_name'];?></option>
									<?php
										}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="channel_name" class="col-sm-4 control-label">Pay Channel Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="channel_name" id="channel_name" placeholder="Enter Pay Channel Name" required value="<?php echo $data['ala_ch_name'];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="channel_price" class="col-sm-4 control-label">Pay Channel Price</label>
							<div class="col-sm-8">
								<input class="form-control" min="0" max="99999" type="number" id="channel_price" name="channel_price1" placeholder="Enter Pay Channel Price" required value="<?php echo $data['ala_ch_price'];?>" onkeyup="sum();">
							</div>
						</div>
						<div class="form-group">
    	                  	<label for="totalPrice" class="col-sm-4 control-label">Total Price (with 18% GST)</label>
    	                  	<div class="col-sm-8">
    	                    		<input type="text" class="form-control" id="totalPrice" name="channel_price" maxlength=6 placeholder="Total Package Price" readonly>
    	                	</div>
    	                </div>
						<div class="form-group">
							<div class="col-md-12">
								<div class="col-md-6">
									<label class="control-label col-md-4">MSO % :<i class="mand">*</i></label>
									<div class="col-md-8"><input type="number" maxlength="3" max=100 name="mso" id="mso" placeholder="Enter MSO %" class="form-control" required onchange="calcOp()" value="<?php echo $data['mso_ratio'];?>"/></div>
								</div>
								<div class="col-md-6">
									<label class="control-label col-md-4">Operator % :<i class="mand">*</i></label>
									<div class="col-md-8"><input type="number" name="operator" id="operator" placeholder="Enter Operator %" class="form-control" readonly value="<?php echo $data['lco_ratio'];?>"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align:center;">
					<?php
						if($data['action']=='Edit')
						{
					?>
						<input type="hidden" name="ala_ch_id" id="ala_ch_id" value="<?php echo $data['ala_ch_id'];?>">
					<?php
						}
					?>
						<input type="submit" id="submit" name="submit" class="btn btn-info" value="Save">
					</div>
				</div>
			</div>
		</form>
			<div class="col-md-6">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Pay Channels List</h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Channel Category</th>
									<th>Channel Name</th>
									<th>Channel Price</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=1;
								foreach($payChannels as $key => $payChannelsInfo )
								{	
								?>
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $payChannelsInfo['cat_name'];?></td>
									<td><?php echo $payChannelsInfo['ala_ch_name'];?></td>
									<td><?php echo $payChannelsInfo['ala_ch_price'];?></td>
									<td><a title="Edit Pay Channel" href="<?php echo base_url()?>packages/edit_pay_channel/<?php echo $payChannelsInfo['ala_ch_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
									&nbsp;<a title="Delete Pay Channel" href="<?php echo base_url()?>packages/delete_pay_channel/<?php echo $payChannelsInfo['ala_ch_id']?>" onclick="return ConfirmDialog();"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
									</td>
								</tr>
								<?php 
								$i=$i+1;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
function calcOp(){
  if ($("#mso").val() == "")
	$("#mso").val("0");
	var temp = parseInt($("#mso").val());
	$("#mso").val(temp);
	var operator = 100 - $("#mso").val();
	$("#operator").val(operator);
}
function sum()
{
    var packValue = document.getElementById('channel_price').value;
   	var gstValue = 18;
    var yourscore = parseInt(packValue) + (parseInt(packValue)*(gstValue/100));
    if (!isNaN(yourscore)) {
        document.getElementById('totalPrice').value = yourscore;
	}
}
</script>