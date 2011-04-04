<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: picasa thumbnails -->
<a href="#goBack" name="" class="goBack px_picasaTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Picasa Thumbnail Size', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('Select a thumbnail size for Picasa', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_picasaThumbnailSelect">
					<option value="0"><?php _e('Small', 'photoxhibit'); ?> (72 width)</option>
					<option value="1"><?php _e('Medium', 'photoxhibit'); ?> (144 width)</option>
					<option value="2"><?php _e('Large', 'photoxhibit'); ?> (288 width)</option>
					<option value="512">512 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="576">576 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="640">640 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="720">720 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="800">800 <?php _e('width', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
				<?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr class="">
			<td width="18%"><?php _e('Select a full size for Picasa', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_picasaFullSizeSelect">
					<option value="512">512 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="576">576 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="640">640 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="720">720 <?php _e('width', 'photoxhibit'); ?></option>
					<option value="800" selected="selected">800 <?php _e('width', 'photoxhibit'); ?></option>
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
<a href="#goBack" name="" class="goBack px_picasaTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: picasa thumbnails -->