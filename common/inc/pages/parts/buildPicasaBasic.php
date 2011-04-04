<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: picasa basic -->
<a href="#goBack" name="px_picasaOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Picasa Basic', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%"><?php _e('Your Picasa Album URL', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="px_picasaAlbumUrl"/></td>
			<td><?php _e('Input the URL for the RSS feed for your Picasa', 'photoxhibit'); ?></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_picasaThumbnails" class="px_pxOptBasic" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_picasaOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: picasa basic -->