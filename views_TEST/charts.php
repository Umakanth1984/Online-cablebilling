<?php
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);		 
if(($custE ==1) || ($custV ==1) ||($custD ==1))
{

include("website_template/header.php");

$total=$active+$inactive;
$active_cust=($active*100)/$total;
$inactive_cust=($inactive*100)/$total;
$jsonData = array
(
    array("Active", $active_cust),
    array("Inactive" , $inactive_cust),
);

/*$emp_qry=mysql_query("select DISTINCT(emp_id) from payments");
$packageEmpID='';
 while($packageRes=mysql_fetch_assoc($emp_qry)){
	extract($packageRes);
	$packageEmpID.=$emp_id.", "; 
}$empIdList=substr("$packageEmpID", 0, -2); */
				$empList=array();
				$empName='';
				$today=date('Y-m-d 00:00:00');
				$week=date('Y-m-d 00:00:00',time()-604800);
				$month=date('Y-m');
				$qry=mysql_query("SELECT * FROM `employes_reg`");
				while($res=mysql_fetch_assoc($qry))
				{
				extract($res);
					$emp_qry=mysql_query("SELECT SUM(amount_paid) as total FROM payments WHERE emp_id=$emp_id AND dateCreated > '$month'");
						$packageEmpID='';
						while($packageRes=mysql_fetch_assoc($emp_qry))
						{
							extract($packageRes);
							echo $total;
							$packageEmpID.=$total.", "; 
						}
						$empIdList=substr("$packageEmpID", 0, -2); 
						if($total==0){$totalAmt=0;}else{$totalAmt=$total;}
					$empName.='["'.$emp_first_name.' '.$emp_last_name.'",'.$totalAmt.'], ';
				} 
				$empList=substr("$empName", 0, -2);
				$empList1=array();
				$empName1='';
			$qry1=mysql_query("SELECT * FROM `employes_reg`");
			while($res1=mysql_fetch_assoc($qry1))
			{
				extract($res1);
					$emp_qry1=mysql_query("SELECT SUM(amount_paid) as total1 FROM payments WHERE emp_id=$emp_id AND dateCreated <= '$week'");
						$packageEmpID1='';
						while($packageRes1=mysql_fetch_assoc($emp_qry1))
						{
							extract($packageRes1);
							echo $total1;
							$packageEmpID1.=$total1.", "; 
						}
						$empIdList1=substr("$packageEmpID1", 0, -2); 
						if($total1==0){$totalAmt=0;}else{$totalAmt=$total1;}
				$empName1.='["'.$emp_first_name.' '.$emp_last_name.'",'.$totalAmt.'], '; 
			}
			$empList1=substr("$empName1", 0, -2);
			$empList2=array();
			$empName2='';
			$qry2=mysql_query("SELECT * FROM `employes_reg`");
			while($res2=mysql_fetch_assoc($qry2))
			{
				extract($res2);
					$emp_qry2=mysql_query("SELECT SUM(amount_paid) as total2 FROM payments WHERE emp_id=$emp_id AND dateCreated >= '$today'");
						$packageEmpID2='';
						while($packageRes2=mysql_fetch_assoc($emp_qry2))
						{
							extract($packageRes2);
							echo $total2;
							$packageEmpID2.=$total2.", "; 
						}
						$empIdList2=substr("$packageEmpID2", 0, -2); 
						if($total2==0){$totalAmt=0;}else{$totalAmt=$total2;}
				$empName2.='["'.$emp_first_name.' '.$emp_last_name.'",'.$totalAmt.'], '; 
			}
			$empList2=substr("$empName2", 0, -2); 
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Digital Cables  - Employee wise Collection Chart</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Charts</a></li>
			<li><a  href="#">Employee</a></li>
			<li class="active"><a  href="#">Employee wise Collection</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
		    <div class="box box-primary">
				<div class="box-header with-border">
					<i class="fa fa-bar-chart-o"></i>
					<h3 class="box-title">Employee wise Monthly Collection Chart</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
				  <div id="bar-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
		
		<div class="row">
		    <div class="box box-primary">
				<div class="box-header with-border">
					<i class="fa fa-bar-chart-o"></i>
					<h3 class="box-title">Employee wise Weekly Collection Chart</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
				  <div id="bar-chart1" style="height: 300px;"></div>
				</div>
			</div>
		</div>

		<div class="row">
		    <div class="box box-primary">
				<div class="box-header with-border">
					<i class="fa fa-bar-chart-o"></i>
					<h3 class="box-title">Employee wise Today Collection Chart</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
				  <div id="bar-chart2" style="height: 300px;"></div>
				</div>
			</div>
		</div>
    </section>
    <!-- /.content -->

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
      data: [<?php echo $empList; ?>],
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
	
	/*
     * BAR CHART WEEKLY
     * ---------
     */

    var bar_data = {
      data: [<?php echo $empList1; ?>],
      color: "#3c8dbc"
    };
    $.plot("#bar-chart1", [bar_data], {
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

	
	
	/*
     * BAR CHART DAILY
     * ---------
     */

    var bar_data = {
      data: [<?php echo $empList2; ?>],
      color: "#3c8dbc"
    };
    $.plot("#bar-chart2", [bar_data], {
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

    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      {label: "Active Customers", data: <?php echo $active_cust;?>, color: "#3c8dbc"},
      {label: "Inactive Customers", data: <?php echo $inactive_cust;?>, color: "#00c0ef"}
    ];
    $.plot("#donut-chart", donutData, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });
    /*
     * END DONUT CHART
     */

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
<?php 
} 
else
{ 
	redirect('/');
}
?> 