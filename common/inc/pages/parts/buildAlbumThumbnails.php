<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: px_buildAlbumList thumbnails -->
<a href="#goBack" name="px_buildAlbumList" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Album Thumbnail Size', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('Select a thumbnail size', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_albumThumbnailSelect">
					<option value="0"><?php _e('Small', 'photoxhibit'); ?> (<?php echo $this->vars['options_thumbailW'], ' X ',$this->vars['options_thumbailH'];?>)</option>
					<?php if ( $this->vars['options_thumbailSet'] == 1 ): ?>
					<option value="1"><?php _e('Medium', 'photoxhibit'); ?> (<?php echo $this->vars['options_thumbailW2'], ' X ',$this->vars['options_thumbailH2'];?>)</option>
					<?php endif; ?>
					<option value="2"><?php _e('Large', 'photoxhibit'); ?> (<?php echo $this->vars['options_MaxWidth'], ' X ',$this->vars['options_MaxHeight'];?>)</option>
				</select>
			</td>
			<td>
				<?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.', 'photoxhibit'); ?>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_getPhotos" class="px_getPhotos" value="<?php _e('Get Photos', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_buildAlbumList" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: px_buildAlbumList thumbnails -->