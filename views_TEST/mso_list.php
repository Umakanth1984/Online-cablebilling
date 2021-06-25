<?php //$this->load->view('website_template/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - MSO List      
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Users</a></li>
        <li class="active">MSO List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">MSO List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>				  
                  <th>MSO Name</th>
				  <th>MSO Remarks</th>                                           
				   <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
			   	foreach($mso as $key => $mso )
				{		 
			?>  
                <tr>                 
				  <td><?php echo $mso['mso_name']?></td>
                  <td><?php echo $mso['mso_remarks']?></td>                                  
				  <td><a  href="<?php echo base_url()?>mso/view/<?php echo $mso['mso_id']?>">View</a> &nbsp;&nbsp;<a  href="<?php echo base_url()?>mso/edit/<?php echo $mso['mso_id']?>">Edit</a> &nbsp;&nbsp;</td>
                </tr>
             
			<?php }?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>