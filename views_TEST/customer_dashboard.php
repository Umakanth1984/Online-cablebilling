
<div class="content-wrapper">
    <section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<h6><?php //echo $empIdList;
		// echo $emp_id;
		?></h6>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
    </section>

    <section class="content">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer/make_a_payment/<?php echo $cust_id;?>'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-aqua card__front">
					<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
					 
						<div class="card__text">
							<h3><sup style="font-size: 20px">Outstanding</sup></h3>
					 
						</div>
						<a  href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-aqua card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
						<?php $qry1=mysql_query("select * from customers where cust_id='$cust_id'");
							  $res1=mysql_fetch_assoc($qry1);?>
							<h3><sup style="font-size: 20px">Rs.</sup><?php echo $res1['current_due'];?></h3>
							<p>Outstanding</p>
						</div>
						<a  href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			 
        	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" onclick="location.href='<?php echo base_url()?>customer_dashboard/complaints'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-maroon card__front">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text">
							<h3><sup style="font-size: 20px">Complaints</sup></h3>
							 
						</div>
						
						<a  href="<?php echo base_url()?>customer_dashboard/complaints" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-maroon card__back">
						<div class="icon" style="top:10px !important;"><i class="fa fa-inr" aria-hidden="true"></i></div>
						<div class="card__text"> 
							<h3><sup style="font-size: 20px">Complaints</sup></h3>
							
						</div>
						
						<a  href="<?php echo base_url()?>customer_dashboard/complaints" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-md-4 col-sm-4  col-xs-6" onclick="location.href='<?php echo base_url()?>customer_dashboard/payment_history'" style="padding-bottom: 15px;">
				<div class="card effect__hover">
					<div class="small-box bg-red card__front">
						<div class="card__text">
							<h3><sup style="font-size: 20px">Payment History</sup></h3>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>customer_dashboard/payment_history" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
					
					<div class="small-box bg-red card__back">
						<div class="card__text">
							 
							<p>Payment History</p>
						</div>
						<div class="icon" style="top:10px !important;"><i class="ion ion-person-stalker"></i></div>
						<a  href="<?php echo base_url()?>customer_dashboard/payment_history" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>			
			
			 
			 
		</div>
    </section>
	
	 
</div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url()?>theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url()?>theme/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>theme/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>theme/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>theme/dist/js/demo.js"></script>
<!-- FLOT CHARTS -->
<script src="<?php echo base_url()?>theme/plugins/flot/jquery.flot.min.js"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url()?>theme/plugins/flot/jquery.flot.resize.min.js"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url()?>theme/plugins/flot/jquery.flot.pie.min.js"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="<?php echo base_url()?>theme/plugins/flot/jquery.flot.categories.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    /*
     * BAR CHART MONTHLY
     * ---------
     */

    var bar_data = {
      data: [<?php echo $empIdList; ?>],
      color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
      grid: {
        borderWidth: 1,
        borderColor: "#f3f3f3",
        tickColor: "#f3f3f3"
      },
      series: {
        bars: {
          show: true,
          barWidth: 0.5,
          align: "center"
        }
      },
      xaxis: {
        mode: "categories",
        tickLength: 0
      }
    });
    /* END BAR CHART */

  });

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
  }
</script>
</body>
</html>