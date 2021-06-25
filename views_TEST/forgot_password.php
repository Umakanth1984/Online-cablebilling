<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php if(isset($title)){ echo $title." - ";} ?>  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url()?>theme/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
	<div class="login-logo">
		<a  href="#"><b>Digital</b> Cable Billing System</a>
	</div>
  <!-- /.login-logo -->
	<div class="login-box-body">
    <!--<p class="login-box-msg">Sign in to start your session</p>-->
	<?php if((isset($msg)) && $msg !=''){ echo $msg;} ?>
	<form id="loginFrm" class="form-horizontal" role="form" method="post" autocomplete="off" action="<?php echo base_url()?>login/check_forgot" enctype="multipart/form-data"> 
		<div class="form-group has-feedback">
			<input type="text" class="form-control" name="loginEmail" id="loginEmail" placeholder="Email or Registered Mobile Number" required>
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		</div>
		<div class="row">
			<div class="col-xs-4">
				<button type="submit" id="loginSubmit" name="loginSubmit" class="btn btn-info pull-right">Submit</button>
			</div>
			<div class="col-xs-4"></div>
			<div class="col-xs-4">
				<a  href="<?php echo base_url()?>login" class="btn btn-danger">Back to Login</a><br>
			</div>
		</div>
    </form>
	
	</div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<script src=".<?php echo base_url()?>theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url()?>theme/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url()?>theme/plugins/iCheck/icheck.min.js"></script>
</body>
</html>