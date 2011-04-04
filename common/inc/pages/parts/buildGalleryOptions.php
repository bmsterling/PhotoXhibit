<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div class="wrap">
	<fieldset class="options px_content" style="margin:0 auto;">
		<legend><?php _e('Gallery Options', 'photoxhibit'); ?></legend>
		<table width="100%" cellpadding="3" cellspacing="3" border="0">
			<tbody>
				<tr>
					<td><?php _e('Name your gallery', 'photoxhibit'); ?></td>
					<td><input type="text" name="px_galleryName" value="<?php echo $this->cur_gallery_info->gallery_title;?>"/></td>
				</tr>
				<tr>
					<td><?php _e('Select the gallery style', 'photoxhibit'); ?></td>
					<td><?php echo $this->get_plugins_selectMenu($this->cur_gallery_info->plugin_id);?></td>
				</tr>
				<tr>
					<td colspan="2" id="selectGalleryUrl"></td>
				</tr>
			</tbody>
		</table>
	</fieldset>

	<fieldset class="options px_content" style="margin:0 auto;">
		<legend><?php _e('Optional Params', 'photoxhibit'); ?></legend>
		<table id="params" width="100%" cellpadding="3" cellspacing="3" border="0">
			<tbody><?php $this->get_OptionTable($this->cur_gallery_info->gallery_params, $this->cur_gallery_info->plugin_id);?></tbody>
		</table>
	</fieldset>
	<p class="submit" style="width:650px;margin:0 auto;">
		<input type="submit" name="px_buildSubmit" id="px_buildSubmit" value="<?php _e('Submit Changes', 'photoxhibit'); ?>" />
	</p>
</div>