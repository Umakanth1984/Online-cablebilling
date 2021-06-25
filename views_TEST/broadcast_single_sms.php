<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables - Send SMS</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Send SMS</a></li>
			<li class="active">Individual SMS</li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	    <?php if(isset($msg)){ echo $msg; } ?>
		<form id="complaintsForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>broadcast_sms/sendSingleSms"> 
			<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>">
			<div class="col-md-10">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Individual SMS</h3>
					</div>         
					<div class="box-body">
						<div class="form-group">
							<label for="inputcustomerno" class="col-sm-4 control-label">Mobile Number *</label>
							<div class="col-sm-8 ui-widget">
								<input type="text" maxlength=10 id="inputcustomerno" name="inputcustomerno" class="form-control" required>
							</div>
						</div>
						<div class="form-group">
							<label for="msgFormat" class="col-sm-4 control-label">SMS Format *</label>
							<div class="col-sm-8">
								<textarea id="msgFormat" name="msgFormat" rows="8" class="form-control" required></textarea>
							</div>
							<div class="col-sm-offset-2">
							</div>
						</div>
					</div>
					<div class="box-footer" style="text-align: left;">
						<div class="col-md-6 col-md-6 offset">
							<button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Send SMS</button>
						</div>
					</div>
				</div>
			</div>
		</form>
      </div>
    </section>
</div>