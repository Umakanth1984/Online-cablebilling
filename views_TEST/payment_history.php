<?php //$this->load->view('website_template/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Digital Cables  - Payments History
      </h1>
      <ol class="breadcrumb">
        <li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a  href="#">Payments History</a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payments History</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
					<th>Sr #</th>
					<th>Cust. ID/Acc. No</th>
					<th>Customer</th>
					<th>Mobile</th>
					<th>Bill Amount Paid</th> 
					<th>Total Pending Amount</th>
					<th>Transaction Type </th>
					<th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
               <?php
			 //  print_r($payments); die;	
			   	foreach($payments as $key => $payment )
				{	
				echo "SELECT first_name,last_name,mobile_no,amount FROM customers WHERE cust_id="$payment['customer_id']; die;
					$sql=mysql_query("SELECT first_name,last_name,mobile_no,amount FROM customers WHERE cust_id="$payment['customer_id']);
					$row=mysql_fetch_assoc($sql);
					$name=$row['first_name']." ".$row['last_name'];
					$mobile=$row['mobile_no'];
					$amount=$row['amount'];
			?>  
                <tr>
                  	<td><?php echo $payment['payment_id'];?></td>
					<td><?php echo $payment['customer_id'];?></td>
					<td><?php echo $name;?></td>
					<td><?php echo $mobile;?></td>
					<td><?php echo $payment['amount_paid'];?></td>
					<td><?php echo $amount;?></td> 
					<td><?php echo $payment['transaction_type'];?></td>		
					<td>&nbsp;</td>
                </tr>
             
			<?php }?>
                </tbody>
                <tfoot>
               <tr>
					<th>Sr #</th>
					<th>Cust. ID/Acc. No</th>
					<th>Customer</th>
					<th>Address</th>
					<th>STB</th>
					<th>Bill Amount</th> 
					<th>Prev. Pending</th> 
					<th>Total Pending</th>		
					<th>Total Paid</th>		
					<th>&nbsp;</th> 
				</tr>
                </tfoot>
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