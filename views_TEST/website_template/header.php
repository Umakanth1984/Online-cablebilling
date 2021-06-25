<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if(isset($title)){ echo $title." - ";} ?>Digital Cable Billing</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/dist/css/skins/_all-skins.min.css">
  
  <link href="https://themefiles.digitalrupay.com/theme/js/jquery.multiselect.css" rel="stylesheet" type="text/css">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/select2/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/datatables/dataTables.bootstrap.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
.col-sm-10 {
    width: 80% !important;
}
.col-sm-2 {
    width: 20% !important;
}
.sidebar-menu li > a > .fa-angle-left, .sidebar-menu li > a > .pull-right-container > .fa-angle-left {
    height: auto;
    margin-right: 10px;
   
    padding: 0;
    width: auto;
}
.user-footer,.user-body {
    background: #3c8dbc none repeat scroll 0 0 !important;
}

.error {
    color: RED;
    display: inline-block;
    font-weight: NORMAL;
    margin-bottom: 0;
    max-width: 100%;
}
.content {
     min-height: 550px;  
}

.fa-link {
    color: BLUE !important;
}
.fa-eye {
       color: GREEN !important;
}
.fa-pencil-square-o {
    color: ORANGE !important;
}
.fa-cogs {
    color: black !important;
}
.fa-trash {
      color: RED !important;
}

.col-sm-12 {
    overflow-x: scroll !important;
}
#example2{
    padding-bottom: 30px;
}
<?php
$accInfo = shortBusiAccInfo();
if($accInfo!=0)
{
$gPeriod = $accInfo['grace_period'];
$prstWallet = $accInfo['wallet'];
$prstCustBase = $accInfo['customer_base'];
$custWiseAmount = $accInfo['package'];
$mnthDays = date("t");
$perDayAmount = round(($prstCustBase*$custWiseAmount)/$mnthDays,2);
$lwstWallet = round($perDayAmount*$gPeriod,2);
$suspendWallet = $lwstWallet+$perDayAmount;
if(($prstWallet<=$lwstWallet))
{
    $no_of_days = (int) ($prstWallet/$perDayAmount);
    $expDt = strtotime(" ".$no_of_days." days");
    $expDateShow = date("dS F Y",$expDt);
    $wallet = $accInfo['wallet'];
    if($prstWallet<0)
    {
        $color = 'red';
        $hMessage1 = "You are running with low balance.";
        $hMessage2 = "Your account expired on : <span style='color:".$color."'><b>".$expDateShow.".</b></span>";
        $hMessage3 = "Your wallet Balance : <span style='color:".$color."'>Rs. ".$wallet."</span>";
        $hMessage4 = "Request you to pay by clicking";
    }
    else
    {
        $color = 'coral';//darkorange
        $hMessage1 = "Your subscription renewal is nearing soon.";
        $hMessage2 = "Renewal Date : <span style='color:".$color."'><b>".$expDateShow.".</b></span>";
        $hMessage3 = "Your wallet Balance : <span style='color:".$color."'>Rs. ".$wallet."</span>";
        $hMessage4 = "To have uninterrupted service,<br>please pay by clicking";
    }
    $key = pack('H*', "nav49een94kum11ar04uma1994ka20n07th98765abcd43210zyxw110494navvy");
	$plaintext = $accInfo['cc_id']; 
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); 
	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
    $plaintext, MCRYPT_MODE_CBC, $iv); 
	$ciphertext = $iv . $ciphertext; 
	$encrypted_id = base64_encode($ciphertext);
?>
body.modal-open .wrapper{
    -webkit-filter: blur(4px);
    -moz-filter: blur(4px);
    -o-filter: blur(4px);
    -ms-filter: blur(4px);
    filter: blur(4px);
}
<?php
}
}
?>
</style>
	<link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/flip/demo.css">
	<script src="https://themefiles.digitalrupay.com/theme/flip/modernizr.js"></script>
	<script src="https://themefiles.digitalrupay.com/theme/flip/fusionad.js"></script>
<?php
if($accInfo!=0)
{
if(($prstWallet<=$lwstWallet))
{
    if($this->session->userdata('alert_count')==0 || $this->session->userdata('alert_count')==1)
    {
        if($this->session->userdata('alert_flag')!='hide')
        {
    echo '
<script>
window.onload=function(){
  document.getElementById("click_me").click();
};
$("#myModal").modal({
    backdrop: "static",
    keyboard: false
})
</script>';
        }
    }
}
}
?>
</head>
<!--<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">-->
<body class="skin-blue sidebar-mini">
<?php if($accInfo!=0){ ?>
    <a style="display:none !important;" id="click_me" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Hidden</a>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Hi, <?php echo $hMessage1;?></h4>
                </div>
                <div class="modal-body">
                    <h4><?php echo $accInfo['custom_message'];?></h4>
                    <h3><?php echo $hMessage2;?></h3>
                    <h3><?php echo $hMessage3;?>
                    <br><?php echo $hMessage4;?> &nbsp;&nbsp;<a href="https://accounts.digitalrupay.com/payment?slug=<?php echo $encrypted_id;?>" target="_blank" class="btn btn-success">Pay Now</a></h3>
                </div>
                <?php if($prstWallet>=-$lwstWallet){ ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php
                    $this->session->set_userdata("alert_flag","hide");
                }
                ?>
            </div>
        </div>
    </div>
    <?php } ?>
<div class="wrapper">
<?php if(isset($cust_id) && ($cust_id != '')) {?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url();?>/customer_dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="font-size: 14px;"><b>D</b>Cables</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Digital</b>Cables</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<?php  if($businessData['business_image']==''){?>
              <img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="user-image" alt="User Image">
			<?php } else{?>
			 <img src="<?php echo base_url()?>images/<?php echo $businessData['business_image']; ?>" class="user-image" alt="User Image">
			<?php }?>
              <span class="hidden-xs"><?php $qry1=mysql_query("select * from customers where cust_id='$cust_id'");
			  $res1=mysql_fetch_assoc($qry1);
				echo ucwords($res1['first_name'].''.$res1['last_name']); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
				<li class="user-header">
					<?php  if($businessData['business_image']==''){?>
					<img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="img-circle" alt="User Image">
					<?php } else{?>
					<img src="<?php echo base_url()?>images/<?php echo $businessData['business_image']; ?>" class="img-circle" alt="User Image">
					<?php }?>
					<p>
					<?php $name=$emp_first_name." ".$emp_last_name; echo ucwords($name);?> - <?php if($user_type == 1){ echo "Admin";}elseif($user_type == 2){ echo "Employee";}elseif($user_type == 3){ echo "Technical Person";}?>
					<small>Member since <?php echo $date_created; ?></small>
					</p>
				</li>
              <!-- Menu Footer-->
				<li class="user-footer">
					<div class="pull-right">
						<a href="<?php echo base_url()?>login/customer_logout" class="btn btn-default btn-flat">Sign out</a>
					</div>
				</li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
			<li>
				<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
			</li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php $qry1=mysql_query("select * from customers where cust_id='$cust_id'");
			  $res1=mysql_fetch_assoc($qry1);
				echo ucwords($res1['first_name'].''.$res1['last_name']); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION </li>
			<li class="treeview">
				<a href="<?php echo site_url();?>/customer_dashboard">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li>
				<a href="<?php echo base_url()?>customer_dashboard/payment_history">
					<i class="fa fa-users"></i> <span>Payment History</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>			 
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-envelope-o"></i> <span>Complaint</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url()?>customer_dashboard/add_complaint"><i class="fa fa-circle-o"></i> Create Complaint</a></li>
					<li><a href="<?php echo base_url()?>customer_dashboard/complaints"><i class="fa fa-circle-o"></i> Complaint List</a></li>
				</ul>
			</li>
			<li>
				<a href="<?php echo base_url()?>changepwd">
					<i class="fa fa-key"></i> <span>Change Password</span>
				</a>			 
			</li>
			<li>
				<a href="<?php echo base_url()?>login/customer_logout">
					<i class="fa fa-sign-out"></i> <span>Sign out</span>
				</a>			 
			</li>
		</ul>
    </section>
    <!-- /.sidebar -->
  </aside>
<?php } elseif($emp_id != '') {
	$userData=mysql_fetch_assoc(mysql_query("select * from employes_reg where emp_id=$emp_id"));
	extract($userData); 
	$businessData=mysql_fetch_assoc(mysql_query("select * from business_information"));
	extract($businessData);
	if($user_type==9)
	{
	    $balance_show=0;
	    $userVar1 = "LCO's";
	    $userVar2 = "LCO";
	}
	else
	{
	    $balance_show=1;
	    $userVar1 = "Employees";
	    $userVar2 = "Employee";
	    $lco_admin_id=$userData['admin_id'];
	    $lcoInfo1=mysql_fetch_assoc(mysql_query("select balance from admin where admin_id='$lco_admin_id'"));
	    $balanceAmount=$lcoInfo1['balance'];
	}
?>
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini" style="font-size: 14px;"><b>D</b>Cables</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Digital</b>Cables</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <?php if($user_type==9){?>
			<li class="dropdown user user-menu"><a href="tel:+914067889999" target='_top'><span class="hidden-xs"><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;For Support : 040-67889999 Ext : 612</span></a></li>
			<li class="dropdown user user-menu"><a href="mailto:support@digitalrupay.com" target='_top'><span class="hidden-xs"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Mail : support@digitalrupay.com</span></a></li>
			<?php }?>
			<?php if($balance_show==1){ ?>
			<li class="dropdown user user-menu"><a><span class="hidden-xs"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;My Balance : <?php echo $balanceAmount;?></span></a></li>
			<?php } ?>
			<!--<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<span class="hidden-xs"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp;&nbsp; Register A Complaint</span>
				</a>
				<ul class="dropdown-menu">
					<li class="user-header">
						<form method="post" name="registerComplaint" id="registerComplaint" action="https://accounts.digitalrupay.com/complaints/register">
							<input type="hidden" name="url" id="url" value="<?php echo base_url(uri_string());?>">
							<input type="hidden" name="businessName" id="businessName" value="<?php echo $business_name;?>">
							<input type="hidden" name="ownerMobile" id="ownerMobile" value="<?php echo $mobile;?>">
							<input type="hidden" name="ownerEmail" id="ownerEmail" value="<?php echo $email;?>">
							<textarea type="text" name="issue" id="issue" rows="3" required class="form-control" placeholder="Enter your Complaint..."></textarea><br>
							<input type="submit" name="raise" id="raise" class="btn btn-danger btn-lg" value="Submit">
						</form>
					</li>
				</ul>
			</li>-->
			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?php  if($businessData['business_image']==''){?>
				<img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="user-image" alt="User Image">
				<?php } else{?>
				<img src="<?php echo base_url()?>images/<?php echo $businessData['business_image']; ?>" class="user-image" alt="User Image">
				<?php }?>
				<span class="hidden-xs"><?php $name=$emp_first_name." ".$emp_last_name; echo ucwords($name);   ?></span>
				</a>
				<ul class="dropdown-menu">
					<!-- User image -->
					<li class="user-header">
						<?php  if($businessData['business_image']==''){?>
						<img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="img-circle" alt="User Image">
						<?php } else{?>
						<img src="<?php echo base_url()?>images/<?php echo $businessData['business_image']; ?>" class="img-circle" alt="User Image">
						<?php }?>
						<p>
						<?php $name=$emp_first_name." ".$emp_last_name; echo ucwords($name);?> - <?php if($user_type == 1){ echo "Admin";}elseif($user_type == 2){ echo "Employee";}elseif($user_type == 3){ echo "Technical Person";}?>
						<small>Member Since <?php echo $date_created; ?></small>
						<?php $logRes=mysql_fetch_assoc(mysql_query("select * from login_history where emp_id='$emp_id' ORDER BY login_id DESC limit 0,1")); ?>
						<small>Last Login from : <?php echo $logRes['ip']; ?></small>
						</p>
					</li>
				  <!-- Menu Footer-->
					<li class="user-footer">
						<div class="pull-right">
							<a href="<?php echo base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a>
						</div>
					</li>
				</ul>
			</li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
         <?php  if($businessData['business_image']==''){?>
              <img src="https://themefiles.digitalrupay.com/theme/dist/img/default-50x50.gif" class="user-image" alt="User Image">
			<?php } else{?>
			 <img src="<?php echo base_url()?>images/<?php echo $businessData['business_image']; ?>" class="user-image" alt="User Image">
			<?php }?>
        </div>
        <div class="pull-left info">
          <p><?php $name=$emp_first_name." ".$emp_last_name; echo ucwords($name);?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
	<?php
		$userAccess1=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
		extract($userAccess1);
	?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION </li>
        <li class="treeview">
          <a href="<?php echo site_url();?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
		<?php if(($custA ==1) || ($custE ==1) || ($custV ==1) || ($custD ==1)){ ?>
			<li class="treeview">
				<a href="#"><i class="fa fa-users"></i> <span>Customer</span><i class="fa fa-angle-left pull-right"></i></a>
				<ul class="treeview-menu">
					<?php if($custA ==1){?><li><a href="<?php echo base_url()?>customer/"><i class="fa fa-circle-o"></i> Create Customer</a></li><?php } ?>
					<?php if(($custE ==1) || ($custV ==1)) {?><li><a href="<?php echo base_url()?>customer/customer_list"><i class="fa fa-circle-o"></i> List Customer</a></li><?php }?>
					<?php if($custE ==1) {?><li><a href="<?php echo base_url()?>customer/inactive_customer_list"><i class="fa fa-circle-o"></i> Inactive Customers List</a></li><?php }?>
					<?php if(($gropusA ==1) || ($gropusE ==1) || ($gropusV ==1) ||($gropusD ==1)) {?><li><a href="<?php echo base_url()?>groups"><i class="fa fa-circle-o"></i> Groups</a></li><?php }?>
				</ul>
			</li>
		<?php }?>
		<?php if(($usersA ==1) || ($usersE ==1) || ($usersV ==1) || ($usersD ==1)){ ?>
        <li class="treeview">
			<a href="#"><i class="fa fa-user"></i> <span><?php echo $userVar1;?></span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if($usersA ==1){?><li><a href="<?php echo base_url()?>user/"><i class="fa fa-circle-o"></i> Create <?php echo $userVar2;?></a></li><?php } ?>
				<?php if(($usersE ==1) || ($usersV ==1) || ($usersD ==1)) {?><li><a href="<?php echo base_url()?>user/employees_list/"><i class="fa fa-circle-o"></i> List <?php echo $userVar2;?></a></li><?php }?>
				<?php
        			if($user_type==9)
        			{
        		?>
        		<li><a href="<?php echo base_url()?>user/credentials"><i class="fa fa-circle-o"></i> Credentials</a></li>
        		<?php
        			}
        		?>
			</ul>
        </li>
		<?php }?>
		<?php if(($packageA ==1) || ($packageE ==1) || ($packageV ==1) || ($packageD ==1)){ ?>
		<li class="treeview">
			<a href="#"><i class="fa fa-bookmark-o"></i> <span>Packages</span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if($user_type==9){?><?php if($packageA ==1){?><li><a href="<?php echo base_url()?>packages"><i class="fa fa-circle-o"></i> Create Package</a></li><?php } }?>
				<?php if(($packageE ==1) || ($packageV ==1) || ($packageD ==1)) {?> <li><a href="<?php echo base_url()?>packages/packages_list"><i class="fa fa-circle-o"></i> Package List</a></li><?php }?>
				<?php
        			if($user_type==9)
        			{
        		?>
        		<!--<li><a href="<?php echo base_url()?>packages/pay_channels"><i class="fa fa-circle-o"></i> Pay Channels</a></li>-->
        		<?php
        			}
        		?>
			</ul>
        </li>
		<?php }?>
		<?php if((($complA ==1) || ($complE ==1) || ($complV ==1) || ($complD ==1)) && $user_type!=9){ ?>
		<li class="treeview">
			<a href="#"><i class="fa fa-envelope-o"></i> <span>Complaint</span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<?php if($complA==1) {?><li><a href="<?php echo base_url();?>complaints"><i class="fa fa-circle-o"></i> Create Complaint</a></li><?php } ?>
				<?php if($complV==1) {?><li><a href="<?php echo base_url()?>complaints/complaints_list"><i class="fa fa-circle-o"></i> Complaint List</a></li><?php }?>
			</ul>
        </li>
		<?php
		}
			if($user_type==1)
			{/*
		?>
		<li class="treeview">
			<a href="#"><i class="fa fa-calculator"></i> <span>Expenses</span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url()?>expenses/category"><i class="fa fa-circle-o"></i>Expenses Category</a></li>
				<li><a href="<?php echo base_url()?>expenses"><i class="fa fa-circle-o"></i>Expenses Items</a></li>
				<li><a href="<?php echo base_url()?>expenses_inward"><i class="fa fa-circle-o"></i>Expenses Details</a></li>
			</ul>
        </li>
		<li class="treeview">
			<a href="#"><i class="fa fa-paper-plane-o"></i> <span>Send SMS </span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url()?>broadcast_sms/"><i class="fa fa-circle-o"></i>Broadcast SMS</a></li>
				<li><a href="<?php echo base_url()?>broadcast_sms/single_sms"><i class="fa fa-circle-o"></i>Individual SMS</a></li>
			</ul>
       	</li>
		<?php*/
			}
		?>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-line-chart"></i> <span>Reports</span><i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> Customers<i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<!--<li><a href="<?php echo base_url()?>reports/paid"><i class="fa fa-circle-o"></i>Paid Customers</a></li>
						<li><a href="<?php echo base_url()?>reports/unpaid"><i class="fa fa-circle-o"></i>Unpaid Customers</a></li>
						<li><a href="<?php echo base_url()?>reports/advancepaid"><i class="fa fa-circle-o"></i>Advance Paid Customers</a></li>-->
						<li><a href="<?php echo base_url()?>reports/active_customers"><i class="fa fa-circle-o"></i>Active Customers</a></li>
						<li><a href="<?php echo base_url()?>reports/inactive_customers"><i class="fa fa-circle-o"></i>Inactive Customers</a></li>
					</ul>
				</li>
				<?php if($user_type==1){?>
				<li><a href="#"><i class="fa fa-circle-o"></i> Collections <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<!--<li><a href="<?php echo base_url()?>reports/collection"><i class="fa fa-circle-o"></i>Employee Collection</a></li>
						<li><a href="<?php echo base_url()?>reports/allcollections"><i class="fa fa-circle-o"></i>All Collections</a></li>-->
						<li><a href="<?php echo base_url()?>reports/cust_accounting"><i class="fa fa-circle-o"></i>All Collections</a></li>
						<!--<li><a href="<?php echo base_url()?>reports/monthdemand"><i class="fa fa-circle-o"></i>Monthly Demand</a></li>
						<li><a href="<?php echo base_url()?>reports/current_month_demand"><i class="fa fa-circle-o"></i>Current Month Due</a></li>
						<li><a href="<?php echo base_url()?>reports/datewise"><i class="fa fa-circle-o"></i>Datewise Collection</a></li>-->
					</ul>
				</li>
				<?php } ?>
				<li><a href="<?php echo base_url()?>reports/ala_approved"><i class="fa fa-circle-o"></i> Activated List</a></li>
				<!--<li><a href="<?php echo base_url()?>reports/ala_reject"><i class="fa fa-circle-o"></i> Ala-carte Reject</a></li>
				<li><a href="<?php echo base_url()?>reports/removal_requests"><i class="fa fa-circle-o"></i> Ala-carte Remove</a></li>-->
				<?php if($user_type==9){ ?><li><a href="<?php echo base_url()?>reports/lco_wallets"><i class="fa fa-circle-o"></i> LCO Wallets</a></li><?php }?>
				<?php if($user_type==9 || $user_type==1){ ?><li><a href="<?php echo base_url()?>reports/franchise"><i class="fa fa-circle-o"></i> Franchise</a></li><?php }?>
				<?php if($user_type!=9){ ?><li><a href="<?php echo base_url()?>reports/complaints"><i class="fa fa-circle-o"></i> Compalints</a></li><?php }?>
			<?php
				if($user_type==1)
				{
			?>
				<li><a href="<?php echo base_url()?>reports/log_history"><i class="fa fa-circle-o"></i>Change Log Report</a></li>
			<?php
				}
			?>
			</ul>
        </li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-cog"></i> <span>Settings</span><i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url()?>settings"><i class="fa fa-circle-o"></i> Change Password</a></li>
				<?php if(($settingsA ==1) || ($settingsE ==1) || ($settingsV ==1) || ($settingsD ==1)){ ?>
				<?php if($user_type==9){?><li><a href="<?php echo base_url()?>import/package_import"><i class="fa fa-circle-o"></i> Import LCO Packages</a></li><?php } ?>
				<!--<li><a href="<?php echo base_url()?>settings/assign_batch_import"><i class="fa fa-circle-o"></i> Assign Batch Excelsheet</a></li>-->
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>Preferences</span><i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<!--<li><a href="<?php echo base_url()?>preferences"><i class="fa fa-circle-o"></i> Common</a></li>-->
						<!--<li><a href="<?php echo base_url()?>preferences/node_prefer"><i class="fa fa-circle-o"></i> NodePoint</a></li>-->
						<?php if($user_type==9){?>
						<li><a href="<?php echo base_url()?>preferences/sms_prefer"><i class="fa fa-circle-o"></i> SMS</a></li>
						<?php } ?>
						<li><a href="<?php echo base_url()?>preferences/complaint_prefer"><i class="fa fa-circle-o"></i> Complaint Categories</a></li>
						<!--<li><a href="<?php echo base_url()?>preferences/mso_prefer"><i class="fa fa-circle-o"></i> MSO </a></li>-->
						<li><a href="<?php echo base_url()?>preferences/emp_prefer"><i class="fa fa-circle-o"></i> Employee Role</a></li>
					</ul>
				</li>
				<?php if($user_type==9){?>
				<li><a href="<?php echo base_url()?>settings/assign_import"><i class="fa fa-circle-o"></i> Assign Excelsheet</a></li>
				<li><a href="<?php echo base_url()?>import/index"><i class="fa fa-circle-o"></i> Import Customer Details</a></li>
				<li><a href="<?php echo base_url()?>business"><i class="fa fa-circle-o"></i> Business Information</a></li>
				<?php }}?>
			</ul>
        </li>
        	<li class="treeview">
			<a href="#"><i class="fa fa-sign-out"></i> <span>Sign out </span><i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url()?>login/logout"><i class="fa fa-circle-o"></i>Sign out</a></li>
			</ul>
       		</li>
	</ul>
    </section>
    <!-- /.sidebar -->
</aside>
<?php  }?>