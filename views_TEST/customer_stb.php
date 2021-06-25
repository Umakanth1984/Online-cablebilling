<link rel="stylesheet" href="https://themefiles.digitalrupay.com/theme/plugins/select2/select2.min.css">
<style>
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('https://themefiles.digitalrupay.com/images/loading.gif')
                50% 50% 
                no-repeat;
}
body.loading .modal {
    overflow: hidden;
}
body.loading .modal {
    display: block;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
	<h1>Digital Cables  - Customer Bouquet & Ala-carte</h1>
     	<ol class="breadcrumb">
		<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a  href="#">Customers</a></li>
		<li class="active">Customer Bouquet & Ala-carte</li>
     	</ol>
    </section>

    <!-- Main content -->
    <section class="content">
		<!--<div class="row">
			<form id="alacarteForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">STB Details</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="stb_id" class="col-md-4 control-label">STB / VC / MAC ID *</label>
								<div class="col-md-8">
									<select class="form-control" id="stb_id" name="stb_id" required>
										<option value="">Select STB / VC / MAC ID</option>
										<?php
											foreach($customer_stb as $key => $cstbInfo)
											{
										?>
										<option value="<?php echo $cstbInfo['stb_id'];?>" <?php if((isset($stb_id) && $stb_id!='') && $stb_id==$cstbInfo['stb_id']){ echo "selected";}?>><?php echo $cstbInfo['stb_no'];?> / <?php echo $cstbInfo['mac_id'];?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<input type="submit" id="stbSubmit" name="stbSubmit" class="btn btn-info pull-right" value="Select & Proceed">
					</div>
				</div>
				<div class="col-md-2"></div>
			</form>
		</div>-->
		<div class="row">
			<?php
				$lcoPrice = 0;
				foreach($stb_bouquets as $key => $stb_bouquet)
				{
					$lcoPrice+=$stb_bouquet['lco_price']+($stb_bouquet['lco_price']*($stb_bouquet['pack_tax']/100));
				}
			?>
		    <div class="col-md-2"></div>
			<div class="col-md-8">
    		    <!--<table id="example2" class="table table-bordered table-hover">-->
				<?php
					if($stb_expiry['expiry']!='')
					{
						if(strtotime(date("Y-m-d"))<=strtotime($customer_stb[0]['end_date']))
						{
							$nxt_stb_expiry = round((strtotime($customer_stb[0]['end_date'])-strtotime(date("Y-m-d")))/86400)." days left";
						}
						else
						{
							$nxt_stb_expiry = "Expired";
						}
					}
				?>
    				<tr>
    					<td><h4>Name : <?php echo $customer_stb[0]['first_name'];?></h4></td>
    					<td><h4>STB NO : <?php echo $customer_stb[0]['stb_no'];?></h4></td>
    					<td><h4>Account NO : <?php echo $customer_stb[0]['custom_customer_no'];?></h4></td>
    					<td><h4>End Date : <?php echo $customer_stb[0]['end_date'];?></h4></td>
    				</tr>
    				<tr>
    				    <td><h4>LCO Amount : <?php echo round($lcoPrice,2);?></h4></td>
    				    <td><h4>Customer Payment : <?php echo $customer_stb[0]['pending_amount'];?></h4></td>
    				    <td><a class="btn btn-danger" onclick="check_stb_expiry(<?php echo $custId;?>,<?php echo $stb_id;?>,'<?php echo $customer_stb[0]['stb_no'];?>');">NXT Expiry : <?php if($stb_expiry['expiry']!=''){ echo $nxt_stb_expiry;}?></a></td>
    			    </tr>
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<?php
				if(isset($stage) && $stage==2)
				{
			?>
						<?php
							$disabledFlag = "";
							$today = date("Y-m-d");
							$renewFlag = 1;
							if(strtotime($customer_stb[0]['end_date'])>strtotime("now"))
							{
								$endDt = strtotime($customer_stb[0]['end_date']);
								if(strtotime($today)<($endDt-(2*86400)))
								{
									$disabledFlag = " disabled";
									$renewFlag = 0;
								}
							}
							else
							{
								$disabledFlag = "";
							}
						?>
			<div class="col-md-2"></div>
			<div class="col-md-8">
			<div class="box-header with-border">
				<h3 class="box-title">Bouquet Information</h3>
            </div>
			<?php
				$i=0;
				$bq_ids='';
				foreach($stb_bouquets as $key => $stb_bouquet)
				{
					$bq_ids[]=$stb_bouquet['pack_id'];
			?>
				<div id="bq<?php echo $i; ?>" class="fmain">
					<input type="hidden" name="stbId[]" id="stbId" value="<?php echo $stb_id;?>">
					<div  class="box-body row">
						<div class="form-group col-md-6">
							<div class="col-md-12">
								<input type="text" class="form-control" id="bqs" name="bqs[]" value="<?php echo $stb_bouquet['package_name'];?>" readonly>
							</div>
						</div>
						<?php $packName = $stb_bouquet['package_name'];?>
						<div class="form-group col-md-3">
							<div class="col-md-12">
								<input type="text" class="form-control" id="bqs1" name="bqs1[]" value="<?php echo round($stb_bouquet['lco_price']+($stb_bouquet['lco_price']*0.18),2);?>" readonly>
							</div>
						</div>
						<button type="button" class="btn btn-danger back-btn" onclick="removeRowBQ(<?php echo $i;?>,<?php echo $custId;?>,<?php echo $stb_id;?>,<?php echo $stb_bouquet['pack_id'];?>,'<?php echo $packName;?>');">delete</button>
					</div>
				</div>
				<?php
				$i++;
				}
				$bq_req_ids='';
				foreach($stb_bouquets_req as $key3 => $stb_bouquet_req)
				{
					$bq_req_ids[]=$stb_bouquet_req['pack_id'];
				}
				?>
			</div>
			<?php if($renewFlag == 1){?>
			<div class="col-md-3 col-md-offset-3">
				<button type="button" id="renew" name="renew" onclick="stb_renew(<?php echo $custId;?>,<?php echo $stb_id;?>,'<?php echo $customer_stb[0]['stb_no'];?>');" class="btn btn-info pull-right">Renew</button>
			</div>
			<?php } ?>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<form id="alacarteAddForm" class="form-horizontal" role="form" method="post" autocomplete="off" action="">
				<div class="box-header with-border">
					<h3 class="box-title">Add Bouquet & Ala-carte</h3>
				</div>
				<div class="box-body">
				    <div class="form-group">
						<label for="newBouquet" class="col-md-4 control-label">Base Pack *</label>
						<div class="col-md-8">
							<select class="form-control select2 calculate" name="newBouquet[]" id="newBouquet" data-placeholder="Select Base Pack" style="width:100%">
								<option value="">Select Base Pack</option>
								<?php foreach($bouquets as $key2 => $bouquetInfo)
								{
								    if($bouquetInfo['cat_id']==1)
								    {
								?>
								<option value="<?php echo $bouquetInfo['package_id'];?>" data-price="<?php echo $bouquetInfo['cust_price'];?>" data-lcoprice="<?php echo $bouquetInfo['lco_price'];?>" data-tr="<tr><td><?php echo $bouquetInfo['package_name'];?></td><td><?php echo $bouquetInfo['cust_price'];?></td></tr>" <?php if(in_array($bouquetInfo['package_id'],$bq_ids)){ echo "disabled";}elseif(in_array($bouquetInfo['package_id'],$bq_req_ids)){ echo "disabled";}?><?php echo $disabledFlag;?>><?php echo $bouquetInfo['package_name']." - Rs.".$bouquetInfo['package_price'];?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="newBouquet" class="col-md-4 control-label">Broadcaster Packs *</label>
						<div class="col-md-8">
							<select class="form-control select2 calculate" name="newBouquet[]" id="newBouquet" multiple="multiple" data-placeholder="Select Bouquets" style="width:100%">
								<option value="">Select Broadcaster</option>
								<?php foreach($bouquets as $key2 => $bouquetInfo)
								{
								    if($bouquetInfo['cat_id']==3)
								    {
								?>
								<option value="<?php echo $bouquetInfo['package_id'];?>" data-price="<?php echo $bouquetInfo['cust_price'];?>" data-lcoprice="<?php echo $bouquetInfo['lco_price'];?>" data-tr="<tr><td><?php echo $bouquetInfo['package_name'];?></td><td><?php echo $bouquetInfo['cust_price'];?></td></tr>" <?php if(in_array($bouquetInfo['package_id'],$bq_ids)){ echo "disabled";}elseif(in_array($bouquetInfo['package_id'],$bq_req_ids)){ echo "disabled";}?>><?php echo $bouquetInfo['package_name']." - Rs.".$bouquetInfo['package_price'];?></option>
								<?php } }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="newBouquet" class="col-md-4 control-label">Ala-carte *</label>
						<div class="col-md-8">
							<select class="form-control select2 calculate" name="newBouquet[]" id="newBouquet" multiple="multiple" data-placeholder="Select Ala-carte" style="width:100%">
								<option value="">Select Ala-carte</option>
								<?php foreach($bouquets as $key2 => $bouquetInfo)
								{
								    if($bouquetInfo['cat_id']==4)
								    {
								?>
								<option value="<?php echo $bouquetInfo['package_id'];?>" data-price="<?php echo $bouquetInfo['cust_price'];?>" data-lcoprice="<?php echo $bouquetInfo['lco_price'];?>" data-tr="<tr><td><?php echo $bouquetInfo['package_name'];?></td><td><?php echo $bouquetInfo['cust_price'];?></td></tr>" <?php if(in_array($bouquetInfo['package_id'],$bq_ids)){ echo "disabled";}elseif(in_array($bouquetInfo['package_id'],$bq_req_ids)){ echo "disabled";}?>><?php echo $bouquetInfo['package_name']." - Rs.".$bouquetInfo['package_price'];?></option>
								<?php } }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="newBouquet" class="col-md-4 control-label">Local / MSO Pack *</label>
						<div class="col-md-8">
							<select class="form-control select2 calculate" name="newBouquet[]" id="newBouquet" multiple="multiple" data-placeholder="Select Local / MSO Pack" style="width:100%">
								<option value="">Select Local / MSO Pack</option>
								<?php foreach($bouquets as $key2 => $bouquetInfo)
								{
								    if($bouquetInfo['cat_id']==2)
								    {
								?>
								<option value="<?php echo $bouquetInfo['package_id'];?>" data-price="<?php echo $bouquetInfo['cust_price'];?>" data-lcoprice="<?php echo $bouquetInfo['lco_price'];?>" data-tr="<tr><td><?php echo $bouquetInfo['package_name'];?></td><td><?php echo $bouquetInfo['cust_price'];?></td></tr>" <?php if(in_array($bouquetInfo['package_id'],$bq_ids)){ echo "disabled";}elseif(in_array($bouquetInfo['package_id'],$bq_req_ids)){ echo "disabled";}?>><?php echo $bouquetInfo['package_name']." - Rs.".$bouquetInfo['package_price'];?></option>
								<?php } }?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
				<div class="col-md-6 col-md-offset-3">
				    <table id="example3" class="table table-bordered table-hover">
				        <thead>
							<tr>
								<th>Product Name</th>
								<th>MRP</th>
							</tr>
						</thead>
						<tbody id="example3tbody">
						</tbody>
				    </table>
				    <h4>Customer Price : Rs. <span id="item-price"></span></h4>
				    <h4>LCO Price : Rs. <span id="item-total"></span></h4>
				</div>
				</div>
				<?php if($renewFlag == 1){?>
				<input type="hidden" name="renewFlag" value="1">
				<?php } ?>
				<input type="hidden" name="stb_id" value="<?php echo $stb_id;?>">
				<div class="col-md-3 col-md-offset-3">
					<input type="submit" id="submit" name="submit" class="btn btn-info pull-right" value="Confirm & Go">
				</div>
				</form>
				<?php
				}
			?>
		</div>
    </section>
</div>
<div id="loadingImage" style="display: none;position:fixed;z-index:1000;top:0;left:0;height:100%;width:100%;background: rgba( 255, 255, 255, .8 ) url('https://themefiles.digitalrupay.com/images/loading.gif') 50% 50% no-repeat;">
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$("#submit").attr("disabled",true);
    var basePrice = 0;
    $(".calculate").change(function() {
        newPrice = basePrice;
        newLcoPrice = basePrice;
        trs='';
		var opCount = 0;
        $(".calculate option:selected").each(function() {
			if($(this).data('price')!==undefined)
			{
				opCount++;
				newPrice = parseFloat(newPrice) + parseFloat($(this).data('price'));
				newLcoPrice = parseFloat(newLcoPrice) + parseFloat($(this).data('lcoprice'));
				trs+=$(this).data('tr');
			}
        });
		if(opCount>0)
		{
			$("#submit").attr("disabled",false);
		}
		else
		{
			$("#submit").attr("disabled",true);
		}
        var gstV=18;
        var gst = newPrice.toFixed(2)*(gstV/100);
        var newPricetotAmount = parseFloat(gst)+parseFloat(newPrice);
        var gst2 = newLcoPrice.toFixed(2)*(gstV/100);
        var newPricetotAmount2 = parseFloat(gst2)+parseFloat(newLcoPrice);
        $("#example3tbody").html(trs);
        $("#item-price").html(newPricetotAmount.toFixed(2));
        $("#item-total").html(newPricetotAmount2.toFixed(2));
        $("#example3tbody").html(trs);
    });
});
</script>
<script>
function stb_renew(cust_id,stb_id,box_no)
{
	$("#submit").attr("disabled",true);
	$("#loadingImage").show();
	if(confirm("Are you sure to Renew Existing Packs for "+box_no+" ?"))
	{
var data = "cust_id="+cust_id+"&stb_id="+stb_id+"&box_no="+box_no+"&existing_price=<?php echo round($lcoPrice,2);?>";
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;
xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
		var resp = JSON.parse(this.responseText);
        if(resp.status=='Success')
        {
            location.reload();
			$("#loadingImage").hide();
        }
        else
        {
			$("#loadingImage").hide();
            alert(resp.msg);
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>customer/renew_stb");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
	}
	else
	{
		alert("Cancel");
		setTimeout(function() {
    	    $("#loadingImage").hide();
    	}, 3000);
	}
}
function removeRowBQ(id1,id2,id3,id4,id5) {
    if(confirm("Are you sure to Delete "+id5+" ?"))
    {
        //if(removeNum<rowCount)
        //{
var data = "id2="+id2+"&id3="+id3+"&id4="+id4;
var data2 = "id1="+id1+"&id2="+id2+"&id3="+id3+"&id4="+id4+"&action=remove";
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            jQuery('#bq'+id1).remove();
            //location.reload();
        }
        else
        {
            alert("Something went wrong !");
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>customer/del_cust_bq");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
        //}
    }
}
function removeRowPC(id1,id2,id3,id4,id5)
{
    if(confirm("Are you sure to Delete "+id5+" ?"))
    {
var data = "id2="+id2+"&id3="+id3+"&id4="+id4;
var data2 = "id1="+id1+"&id2="+id2+"&id3="+id3+"&id4="+id4+"&action=remove";
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            jQuery('#pc'+id1).remove();
        }
        else
        {
            alert("Something went wrong !");
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>customer/del_cust_alacarte");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
    }
}

function check_stb_expiry(id1,id2,id3)
{
var data = "cust_id="+id1+"&stb_id="+id2+"&stb_no="+id3;
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;
xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4)
	{
		var res = JSON.parse(this.responseText);
		if(res.message=='success')
		{
			alert("STB Expiry Request Successfull");
		}
		else
		{
			alert(res.text);
		}
    }
});
xhr.open("POST", "<?php echo base_url();?>customer/check_stb_expiry");
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
}
</script>