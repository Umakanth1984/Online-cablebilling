<?php
    $mysqli = mysqli_connect('202.53.92.6:3306', 'robotics', 'N@veen@3054', 'rpa');
// $mysqli = mysqli_connect('27.116.16.98:3306', 'root', 'Eaiesb123', 'rpa');
if (mysqli_connect_errno()) {
    echo "Connect failed:".mysqli_connect_error();
    exit();
}
// print_r($_REQUEST);die;
	$now=date('Y-m-d H:i:s');
	$nwname="smcn452";
	$portal_url="http://partnerportal.acttv.in";
	$Username="krishnapavanvarma@gmail.com";
	$Password="pavan180005";
	$Cust_id=$cust_id;
	if($action=='add')
	{
	    $Action=ucfirst($action);
	}
	elseif($action=='remove')
	{
	    $Action=ucfirst($action);
	}
	else
	{
	    $Action="Add";
	}
	$lco_id="159357423";
	$Mac_id=$CustInfo[0]['mac_id'];
	//$Vc_no=$CustInfo[0]['stb_no'];
	$Vc_no="35128";
	if($PackInfo[0]['package_name']!='')
	{
    	$Pack_price=$PackInfo[0]['package_price'];
    	if($Action=='Remove')
    	{
    	    $Pack_name=$PackInfo[0]['package_description'];
    	}
    	else
    	{
    	    $Pack_name=$PackInfo[0]['package_name'];
    	}
	}
	else
	{
	    $Pack_price=$PackInfo[0]['ala_ch_price'];
	    if($Action=='Remove')
    	{
    	    $Pack_name=$PackInfo[0]['ala_ch_descr'];
    	}
    	else
    	{
    	    $Pack_name=$PackInfo[0]['ala_ch_name'];
    	}
	}
	$Status="Pending";
	$insQry=mysqli_query($mysqli,"INSERT INTO addingchannel (network_name,lco_id, portal_url, Username, Password, Cust_id, Mac_id, Vc_no, Pack_name, Pack_price, Action, Datecreated, Status) VALUES ('$nwname','$lco_id', '$portal_url', '$Username', '$Password', '$Cust_id', '$Mac_id', '$Vc_no', '$Pack_name', '$Pack_price', '$Action', '$now','$Status')");
	if($insQry)
	{
		return true;
	}
?>

