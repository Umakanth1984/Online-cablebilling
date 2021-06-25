<?php //$this->load->view('website_template/header');?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Digital Cables  - Edit MSO Details    
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Users</a></li>
        <li class="active"><a  href="#">Edit MSO Details</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
	  <?php foreach($edit_mso as $key => $mso )
				{
				} ?>
	    <?php if(isset($msg)){ echo $msg; } ?>
		<?php //echo form_open('/customer/customer_save', 'id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off"') ?>
	 <form id="customerForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>mso/mso_updated/<?php echo $mso['mso_id']?>"> 
        <!-- left column -->
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body">              
				<div class="form-group">
                  <label for="inputmsoname" class="col-sm-2 control-label">MSO Name *</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputmsoname" value="<?php echo $mso['mso_name'];?>" name="inputmsoname" required>
                  </div>
                </div>				
			    <div class="form-group">
                <label for="inputmsoRemarks" class="col-sm-2 control-label">MSO Remarks *</label>
                <div class="col-sm-10">
					<textarea  class="form-control"  rows="3"  id="inputmsoRemarks" name="inputmsoRemarks" required><?php echo $mso['mso_remarks'];?></textarea>
                </div>
              </div>
			  <div class="box-footer">
                <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                <button type="submit" id="customerSubmit" name="customerSubmit" class="btn btn-info pull-right">Update</button>
              </div>
			  </div>
             
          </div>

        </div>
        <!--/.col (left) -->
		</form>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>