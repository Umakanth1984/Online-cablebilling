<script src="https://themefiles.digitalrupay.com/theme/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
	function setupPage() {
		pramukhIME.enable(["myinputid"]);
		pramukhIME.on('languagechange', languageChangeHandler);
	}
    
    function onDropdownChange()
    {
        var dd = document.getElementById("mydropdownid");
        var lang = dd.options[dd.selectedIndex].value;
        pramukhIME.setLanguage(lang.split(':')[1],lang.split(':')[0]);
    }

    function languageChangeHandler(data)
    {
		// Select correct option if the value exist
		var optvalue = data.kb + ':' + data.language;
        var dd = document.getElementById("mydropdownid");
        var i;
        for(i=0; i< dd.options.length; i++)
        {
            if(dd.options[i].value == optvalue)
            {
                dd.selectedIndex = i;
                break;
            }
        }
		// Notify that language is changed.
		document.getElementById("message").innerHTML = "Language changed.";
    }
	tinymce.init({
	    selector: 'textarea#msgFormat',
		theme: "modern",
		// Add pramukhime plugin
		plugins: [
			"pramukhime"
		],
		//content_css: "css/development.css",
		add_unload_trigger: false,
		autosave_ask_before_unload: false,
		// Add buttons to toolbar
		toolbar1: "pramukhime pramukhimehelp pramukhimesettings pramukhimeresetsettings pramukhimetogglelanguage | bold italic underline",
		menubar: false,
		toolbar_items_size: 'small',

		// pramukhime customization
		// Uncomment this section to customize pramukhime plugin
/*		 
        pramukhime_options : { // pramukhime_options is Optional. If you don't provide, it will use the default settings
			languages: [ // Optional. If this value is not provided, it will list all the available languages
				// Explanation for the values
				//{
				//	text: 'Sanskrit', // Required
				//	value: 'pramukhindic:sanskrit', // Required. Format = KEYBOARD_NAME:LANGUAGE_NAME
				//	disabled: false // Optional. To make the item non-selectable in the list
				//}
				
				// Uncomment the following to show title + two languages + english
					{text:'Pramukh Indic', value:'', disabled:true}, // May be used for title
					{text:'Gujarati', value:'pramukhindic:gujarati'},
					{text:'Sanskrit', value:'pramukhindic:sanskrit'},
					{text:'-', value:''}, // This will turn into menu separator
					{text:'English', value:'pramukhime:english'}
			],
			// Uncomment the following value to select Sanskrit as the default language
			selected_value: 'pramukhindic:sanskrit', // Not required. Default value is 'pramukhime:english'
			toggle_key: { // Not required. Default value is {key:120, ctrl: false, alt: false, title: 'F9'}. Customizes a toggle key which is a shortcut key responsible for switching
			// between currently and last selected languages.
					key : 119, // Required. F8 key's keycode
					ctrl : false, // Not required. If true, user must press "Ctrl" key + key to switch
					alt : false,  // Not required. If true, user must press "Alt" key + key to switch
					title:'F8' // Required. This title will be appended to the title of "English" language.
				}
        },
*/
        setup: function(editor)
        {
			editor.on('init', function(e) { 
				var intervalId;
				var checkInit = function() {
					if (typeof pramukhIME !== 'undefined' && typeof PramukhIndic !== 'undefined') {
						clearInterval(intervalId);
						setupPage();
					}
				}
				intervalId = setInterval(checkInit, 100);
				
			});
        }
	});
</script>
<style>
 
.mce-branding-powered-by{
	display:none !important;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
		<h1>Digital Cables  - Broadcast SMS</h1>
		<ol class="breadcrumb">
			<li><a  href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Broadcast SMS</li>
		</ol>
    </section>
	
    <section class="content">
		<div class="row">
			<?php if(isset($msg)){ echo $msg; } ?>
			 
			<form id="importCustomerForm" name="importCustomerForm" class="form-horizontal" role="form" method="post" autocomplete="off" enctype="multipart/form-data" action="<?php echo base_url()?>broadcast_sms/sendSms">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Broadcast SMS</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="import_customer" class="col-sm-4 control-label">Broadcast By Group</label>
								<div class="col-sm-8">
								<?php $selGrp=mysql_query("select * from groups where admin_id='$adminId'");
									while($resGrp=mysql_fetch_assoc($selGrp))
									{	 
								?>
									<div class="col-sm-11">
									    <input type="checkbox" class="checkbox" name="grpName[]" id="grpName" value="<?php echo $resGrp['group_name'];?>">
										<div class="col-sm-1"><input type="checkbox" class="checkbox" name="grp[]" id="grp" value="<?php echo $resGrp['group_id'];?>"></div>
										<div class="col-sm-11"><label><?php echo $resGrp['group_name'];?></label></div>
									</div>
							   <?php }?>		
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="unpaidCust" class="col-sm-4 control-label">Unpaid Customers</label>
								<div class="col-sm-8">
									 <input type="checkbox" class="checkbox" name="unpaidCust" id="unpaidCust" value="unpaid">
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="allgroups" class="col-sm-4 control-label">All Groups</label>
								<div class="col-sm-8">
									 <input type="checkbox" class="checkbox" name="allgroups" id="allgroups" value="allgroups">
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-body">
							<div class="form-group">
								 <label for="import_customer" class="col-sm-4 control-label">SMS Format</label>
								<div class="col-sm-6 pull-left">
									 <textarea id="msgFormat" name="msgFormat" rows="20" cols="80" style="width: 80%; height:200px;"></textarea>
									<!--<textarea id="msgFormat" name="msgFormat"  rows="8" cols="60"></textarea> -->
								</div>
								<div class="col-sm-offset-2">
								</div>
							</div>
						</div>
						<div class="box-footer" style="text-align:center;">
							<button type="submit" id="commonupdate" name="commonupdate" class="btn btn-info">Send SMS</button>
						</div>
					</div>
				</div>
			</form>
        </div>
    </section>
</div>