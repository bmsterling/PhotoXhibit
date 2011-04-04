<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: flickr basic -->
<a href="#goBack" name="px_buildSmugMugOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('SmugMug Basic', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%"><?php _e('Your SmugMug URL', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="px_smugmug_basic_url" id="px_smugmug_basic_url"/></td>
			<td><?php _e('Input the URL for the RSS feed for your SmugMug account', 'photoxhibit'); ?></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_buildSmugMugThumbnails" class="px_pxSmugMugOptBasic" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_buildSmugMugOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: flickr basic -->