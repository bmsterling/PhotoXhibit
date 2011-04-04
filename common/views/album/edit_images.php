<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
	<link href="<?php echo $this->options['css'];?>jqModal.css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo $this->options['js'];?>jqmodal.js"></script>
<?php if( $this->vars['flash_version_multi_upload'] == 1 ): ?>
	<script type="text/javascript" src="<?php echo $this->options['js'];?>swfupload.js"></script>
	<script type="text/javascript" src="<?php echo $this->options['js'];?>swfupload.graceful_degradation.js"></script>
	<script type="text/javascript" src="<?php echo $this->options['js'];?>swfupload.queue.js"></script>
	<script type="text/javascript" src="<?php echo $this->options['js'];?>handlers.js"></script>
	<script type="text/javascript">
		var upload2;

		window.onload = function() {

			upload2 = new SWFUpload({
				// Backend Settings
				upload_url: "<?php echo str_replace( array($_SERVER['HTTP_HOST'], "http://"), "", $this->parentFileUrl);?>?option=upload&aid=<?php echo $_GET['aid'];?>",	// Relative to the SWF file (or you can use absolute paths)
				post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},

				// File Upload Settings
				file_size_limit : "102400",	// 200 kb
				file_types : "*.jpg;*.gif;*.png",
				file_types_description : "Image Files",
				file_upload_limit : "0",
				file_queue_limit : "0",

				// Event Handler Settings (all my handlers are in the Handler.js file)
				file_dialog_start_handler : fileDialogStart,
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,

				// Flash Settings
				flash_url : "<?php echo $this->options['js'];?>swfupload_f9.swf",	// Relative to this file (or you can use absolute paths)

				swfupload_element_id : "flashUI2",		// Setting from graceful degradation plugin
				degraded_element_id : "degradedUI2",	// Setting from graceful degradation plugin

				custom_settings : {
					progressTarget : "fsUploadProgress2",
					cancelButtonId : "btnCancel2"
				},

				// Debug Settings
				debug: <?php echo (isset($_GET['debugme'])) ?  'true' : 'false';?>
			});

	     }
	</script>
<?php else:?>
<script type="text/javascript" src="<?php echo $this->options['js'];?>jquery.MultiFile.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('input.Filedata').MultiFile();
});
</script>
<?php endif;?>

<div id="px_message" class="updated" style="display:none"><p></p></div>

</pre>
<div class="wrap">
	<?php if ( $this->safe_mode ):?>
	<div class="error"><p><?php _e('Safe Mode is turn on on this server, you will need to manually create a folder for each album you want.', 'photoxhibit'); ?></p>
		<p><?php _e('A folder named', 'photoxhibit'); ?> "<?php
		$this->get_album_dir($_GET['aid']);
		echo array_pop(explode('/',$this->cur_album_dir));
		?>" <?php _e('needs to be manually created in the', 'photoxhibit'); ?> "<?php echo $this->vars['options_path'];?>" <?php _e('folder', 'photoxhibit'); ?></p>
	</div>
	<?php endif; ?>
	<h2><?php _e('Album Images', 'photoxhibit'); ?></h2>
	<fieldset class="options">
		<legend><?php _e('Quick Album Edit', 'photoxhibit'); ?></legend>
		<div class="px_contentHolder clearfix">
			<div class="editImageLeft">
				<table cellpadding="0" cellspacing="0" border="0" id="imageTable"><tbody><tr><td>
<?php
if( count($imageGroup) > 0 ){
	foreach($imageGroup as $k => $v){
?>
				<table cellpadding="0" cellspacing="0" border="0" imageid="<?php echo $v->albumPhotos_id;?>">
					<tr>
						<td rowspan="5" align="left" valign="top" width="105" style="width:105; overflow:auto;">
							<img src="<?php echo $this->cur_album_dir . '/' . $v->albumPhotos_file . '_tn.' . $v->albumPhotos_ext;?>"/>
						</td>
						<td><?php _e('Image Name:', 'photoxhibit'); ?> <?php echo $v->albumPhotos_file;?></td>
					</tr>
					<tr>
						<td><?php _e('Image Alt/Title:', 'photoxhibit'); ?>  <?php echo (empty($v->albumPhotos_alt)) ? 'None Yet' : $v->albumPhotos_alt;?></td>
					</tr>
					<tr>
						<td><?php _e('Image Tags:', 'photoxhibit'); ?>  <?php echo (empty($v->albumPhotos_tags)) ? 'None Yet' : $v->albumPhotos_tags;?></td>
					</tr>
					<tr>
						<td><?php _e('Is Active:', 'photoxhibit'); ?> <?php echo ($v->albumPhotos_isactive == '1') ? 'true' : 'false';?></td>
					</tr>
					<tr>
						<td><?php _e('Description:', 'photoxhibit'); ?>  <?php echo (empty($v->albumPhotos_desc)) ? 'None Yet' : $v->albumPhotos_desc;?></td>
					</tr>
					<tr>
						<td colspan="2" style="height:15px;" align="right">
							[<a href="<?php echo $this->parentFileUrl;?>?option=delete_image&amp;iid=<?php echo $v->albumPhotos_id;?>" imageid="<?php echo $v->albumPhotos_id;?>" class="deleteImageLink"><?php _e('Delete Image', 'photoxhibit'); ?></a>]
							|
							<a href="<?php echo $this->parentFileUrl;?>?option=edit_image_form&amp;iid=<?php echo $v->albumPhotos_id;?>" class="editTextLink"><?php _e('Edit text', 'photoxhibit'); ?></a>
							|
							<a href="admin.php?page=px_manageAlbum&amp;action=edit_image&amp;aid=<?php echo $_GET['aid'];?>&amp;iid=<?php echo $v->albumPhotos_id;?>" class="editImageLink"><?php _e('Edit Image', 'photoxhibit'); ?></a>
						</td>
					</tr>
				</table>
<?php
	}//
}
?>
				</td></tr></tbody></table>
			</div>
			
			<div class="editImageRight">
				<form id="form1" action="admin.php?page=px_manageAlbum&amp;action=edit_images&amp;do=upload&amp;aid=<?php echo $_GET['aid'];?>" method="post" enctype="multipart/form-data">
					<div class="content">
						<table>
							<tr valign="top">
								<td>
									<div id="flashUI2" style="display: none;">
										<fieldset class="flash options" id="fsUploadProgress2">
											<legend><?php _e('Multiple Photo Upload (flash version)', 'photoxhibit'); ?></legend>
										</fieldset>
										<div>
											<input type="button" value="<?php _e('Upload file', 'photoxhibit'); ?> " onclick="upload2.selectFiles()" style="font-size: 8pt;" />
											<input id="btnCancel2" type="button" value="<?php _e('Cancel Uploads', 'photoxhibit'); ?>" onclick="cancelQueue(upload2);" disabled="disabled" style="font-size: 8pt;" /><br />
										</div>
									</div>
									<div id="degradedUI2">
										<fieldset class="options">
											<legend><?php _e('Multiple Photo Upload', 'photoxhibit'); ?></legend>
											<input type="file" class="Filedata" name="Filedata[]" /> <br/>
										</fieldset>
										<div>
											<input type="submit" value="<?php _e('Submit Files', 'photoxhibit'); ?>" />
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</fieldset>
</div>
