<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="" class="goBack px_flickrTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Flickr Thumbnail Size', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('Select a thumbnail size for Flickr', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="bsg_flickr_thumbnailSelect" id="bsg_flickr_thumbnailSelect">
					<option value="0"><?php _e('Square', 'photoxhibit'); ?> (75 x 75)</option>
					<option value="1"><?php _e('Thumbnail', 'photoxhibit'); ?> (100 on longest side)</option>
					<option value="2"><?php _e('Small', 'photoxhibit'); ?> (240 on longest side)</option>
					<option value="3"><?php _e('Medium', 'photoxhibit'); ?> (500 on longest side)</option>
					<option value="4"><?php _e('Large', 'photoxhibit'); ?> (1024 on longest side)</option>
					<option value="5"><?php _e('Orginal', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
				<?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.  The large option is only available from flickr if the original is very large.', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr class="">
			<td width="18%"><?php _e('Select a Large size for Flickr', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_flickr_largeSelect" id="px_flickr_largeSelect">
					<option value="2"><?php _e('Small', 'photoxhibit'); ?> (240 on longest side)</option>
					<option value="3"><?php _e('Medium', 'photoxhibit'); ?> (500 on longest side)</option>
					<option value="4"><?php _e('Large', 'photoxhibit'); ?> (1024 on longest side)</option>
					<option value="5"><?php _e('Orginal', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
			<?php _e('The large option is only available from flickr if the original is very large.', 'photoxhibit'); ?>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_getPhotos" class="px_getPhotos" value="<?php _e('Get Photos', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="" class="goBack px_flickrTn">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>