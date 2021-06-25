<?php 
$userAccess=mysql_fetch_assoc(mysql_query("select * from emp_access_control where emp_id=$emp_id"));
extract($userAccess);
$chkEmpGrps=mysql_fetch_assoc(mysql_query("select * from emp_to_group where emp_id=$emp_id"));
$grp_ids=$chkEmpGrps['group_ids'];
if(($custE ==1) || ($custV ==1) ||($custD ==1)){ ?>
<style>
.button.disabled {
  opacity: 0.65; 
  cursor: not-allowed;
}
</style>
<script>
function ConfirmDialog() {
  var x=confirm("Are you sure to delete record?")
  if (x) {
	document.getElementById("submit").className = "disabled";
    return true;
  } else {
    return false;
  }
}
</script>

<script>
function ConfirmDialog1(a) {
	if(a==0){
		var x=confirm("Are you sure to Inactivate this Customer ?")
	}
	else{
		var x=confirm("Customer has Outstanding Amount Rs."+a+".  Are you sure to Inactivate this Customer ?")
	}
	
	if (x) {
		return true;
	} else {
		return false;
	}
}
</script>
<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Customer Bouquet & Ala-carte Approve</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Customers</a></li>
			<li class="active"><a  href="#">Customers Bouquet & Ala-carte Approve</a></li>
		</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Customer Bouquet & Ala-carte Approve</h3><br>
					  <h3 class="box-title">LCO Balance : <span style="color:red;">Rs. <?php echo $lcoInfo['balance'];?></span></h3><br>
					  <h3 class="box-title">Customer Balance : <span style="color:red;">Rs. <?php echo $customer_requets[0]['pending_amount'];?></span></h3>
					</div>
					<div class="box-body">
						<table id="example2" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Cust ID</th>
									<th>Name</th>
									<th>MAC ID</th>
									<th>STB No</th>
									<th>Name of Pack</th>
									<th>Price</th>
									<th>&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							foreach($customer_requets as $key => $customer_req1)
							{
								if(isset($customer_req1['bouquet'])){
									$packName=$customer_req1['bouquet']['0']['package_name'];$packPrice=$customer_req1['bouquet']['0']['lco_price'];}
							    else{ $packName=$customer_req1['alacarte']['0']['ala_ch_name'];$packPrice=$customer_req1['alacarte']['0']['ala_ch_price'];}
							?>
								<tr>
								    <input type="hidden" name="v1-<?php echo $customer_req1['alacarte_req_id']?>" id="v1-<?php echo $customer_req1['alacarte_req_id']?>" value="<?php echo $customer_req1['cust_id'];?>">
							    <input type="hidden" name="v2-<?php echo $customer_req1['alacarte_req_id']?>" id="v2-<?php echo $customer_req1['alacarte_req_id']?>" value="<?php echo $customer_req1['stb_id'];?>">
							    <input type="hidden" name="v3-<?php echo $customer_req1['alacarte_req_id']?>" id="v3-<?php echo $customer_req1['alacarte_req_id']?>" value="<?php echo $customer_req1['alacarte_req_id'];?>">
							    <input type="hidden" name="v4-<?php echo $customer_req1['alacarte_req_id']?>" id="v4-<?php echo $customer_req1['alacarte_req_id']?>" value="<?php echo $packName;?>">
									<td><?php echo $i;?></td>
									<td><?php echo $customer_req1['custom_customer_no'];?></td>
									<td><?php echo $customer_req1['first_name'];?></td>
									<td><?php echo $customer_req1['mac_id'];?></td>
									<td><?php echo $customer_req1['stb_no'];?></td>
									<td><?php echo $packName;?></td>
									<td><?php echo $packPrice;?></td>
									<td>
									    <?php
									    if($lcoInfo['balance']>=200)
									    {
									    ?>
									    <button class="btn btn-info" name="test1" id="test1" onclick="addTo(<?php echo $customer_req1['cust_id']?>,<?php echo $customer_req1['stb_id']?>,<?php echo $customer_req1['alacarte_req_id']?>,'<?php echo $packName;?>');">Add</button> &nbsp;&nbsp;&nbsp;<button class="btn btn-danger" name="test2" id="test2" onclick="removeTo(<?php echo $customer_req1['cust_id']?>,<?php echo $customer_req1['stb_id']?>,<?php echo $customer_req1['alacarte_req_id']?>,'<?php echo $packName;?>');">Reject</button>
									    <?php
									    }
									    ?>
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
<script>
function addTo(id1,id2,id3,id4) {
	if (confirm("Are you sure to Add "+id4+" ?")) {
    var temp1 = true;
var data = "id1="+id1+"&id2="+id2+"&id3="+id3;
var data2 = "id1="+id1+"&id2="+id2+"&id3="+id3+"&id4="+id4+"&action=add";

/*// For View 
var xhr2 = new XMLHttpRequest();
xhr2.withCredentials = true;
xhr2.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            location.reload();
        }
        else if(this.responseText=='0' || this.responseText==0)
        {
            alert("Robotic Request Already added !");
        }
        else
        {
            alert(this.responseText);
        }
    }
});
xhr2.open("POST", "<?php echo base_url();?>dashboard/addToStb2");
xhr2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr2.setRequestHeader("cache-control", "no-cache");
xhr2.send(data2);
// End of View*/

var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            location.reload();
        }
        else if(this.responseText=='0' || this.responseText==0)
        {
            alert("Already added !");
        }
        else
        {
            temp1 = false;
            alert(this.responseText);
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>dashboard/addToStb");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
    }
}

function removeTo(id1,id2,id3,id4) {
	if (confirm("Are you sure to Reject "+id4+" ?")) {
var data2 = "id1="+id1+"&id2="+id2+"&id3="+id3;
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            location.reload();
        }
        else if(this.responseText=='0' || this.responseText==0)
        {
            alert("Already Removed !");
        }
        else
        {
            alert(this.responseText);
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>dashboard/removeFromStb");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data2);
    }
}
</script>
  <?php 
	}
	else
	{		
		redirect('/');
	}?>