<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Batchwise Upload</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a  href="#">Dashboard</a></li>
			<li class="active">Import Batch File</li>
		</ol>
    </section>
	
    <section class="content">
		<div class="row">
			<form id="importBatchForm" name="importBatchForm" class="form-horizontal" role="form" method="post" autocomplete="off" enctype="multipart/form-data" action="">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Import Batch File</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="import_file" class="col-sm-4 control-label">Choose File</label>
								<div class="col-sm-6">
									<input type="file" class="form-control" id="import_file" name="import_file" value="" required>
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								 <label for="import_sample" class="col-sm-4 control-label">&nbsp;</label>
								<div class="col-sm-6 pull-left">
									<b>Note</b> : <a  href="<?php echo base_url()?>images/sample-data-csv.csv">Click Here</a> to Download Import Batch file Format
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-footer" style="text-align:center;">
						    <button type="button" id="commonupdate" onclick="return ValidateUpload();" name="commonupdate" class="btn btn-danger">Check Bulk Data</button>
							<input type="submit" id="uploadBatch" name="uploadBatch" onclick="return validateForm();" class="btn btn-info" value="Upload Customer Data">
						</div>
					</div>
				</div>
			</form>
        </div>
    </section>
</div>
<script>
function ValidateUpload(){
	var Upload_file = document.getElementById('import_file');
	var myfile = Upload_file.value;
	if (myfile.indexOf("csv") > 0) {
		var file_data = $('#import_file').prop('files')[0];
// 		var file_data = Upload_file.files[0];
		var form_data = new FormData();                  
		form_data.append('file', file_data);
		$.ajax({
			url: "<?php echo base_url();?>dashboard/check_import",
			type: "POST",
			dataType: 'text',
			cache: false,
            contentType: false,
            processData: false,
            data: form_data,
				success: function(res) {
					alert(res);
					if(res!=0)
					{
						return false;
					}
				}
			});
/*var data = form_data;
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;
xhr.addEventListener("readystatechange", function () {
    if (this.readyState === 4) {
        if(this.responseText==true || this.responseText=='true')
        {
            location.reload();
        }
        else
        {
            alert(this.responseText);
        }
    }
});
xhr.open("POST", "<?php echo base_url();?>dashboard/check_import", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("cache-control", "no-cache");
xhr.send(data);
//console.log(file_data);*/
	}
	else {
		alert('Invalid Format');
		myfile.value = '';
	}
	return false;
}
function validateForm(){
	var x=confirm("Are you sure to Proceed ?")
	if (x) {
		return true;
	} else {
		return false;
	}
}
</script>