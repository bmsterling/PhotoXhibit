<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="" class="goBack px_smugMugTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('SmugMug Thumbnail Size', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('Select a thumbnail size for SmugMug', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_smugMugThumbnailSelect" id="px_smugMugThumbnailSelect">
					<option value="0">(<?php _e('up to 100 x up to 100', 'photoxhibit'); ?>)</option>
					<option value="1">(<?php _e('up to 150 x up to 150', 'photoxhibit'); ?>)</option>
					<option value="2">(<?php _e('up to 400 x up to 300', 'photoxhibit'); ?>)</option>
					<option value="3">(<?php _e('up to 600 x up to 450', 'photoxhibit'); ?>)</option>
					<option value="4">(<?php _e('up to 800 x up to 600', 'photoxhibit'); ?>)</option>
					<option value="5">(<?php _e('up to 1024 x up to 768', 'photoxhibit'); ?>)</option>
				</select>
			</td>
			<td>
				<?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr class="">
			<td width="18%">Select a full size for SmugMug', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_smugMugFullSizeSelect">
					<option value="2">(<?php _e('up to 400 x up to 300', 'photoxhibit'); ?>)</option>
					<option value="3">(<?php _e('up to 600 x up to 450', 'photoxhibit'); ?>)</option>
					<option value="4" selected="selected">(<?php _e('up to 800 x up to 600', 'photoxhibit'); ?>)</option>
					<option value="5">(<?php _e('up to 1024 x up to 768', 'photoxhibit'); ?>)</option>
				</select>
			</td>
			<td>
				<?php _e('Select the size of the full size image you want to display in the plugin.', 'photoxhibit'); ?>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_getPhotos" class="px_getPhotos" value="<?php _e('Get Photos', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="" class="goBack px_smugMugTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>