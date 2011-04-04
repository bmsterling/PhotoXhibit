<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: flickr basic -->
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Flickr Options', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('What Options?', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_flickrOptionsDD" id="px_flickrOptionsDD">
					<option selected="selected"></option>
					<option value="px_buildFlickrBasic"><?php _e('Basic', 'photoxhibit'); ?></option>
					<!--<option value="flickrQuickAdvanced"><?php _e('Quick Advanced', 'photoxhibit'); ?></option>-->
					<option value="px_buildFlickrPhotoset"><?php _e('Advanced Photoset', 'photoxhibit'); ?></option>
					<option value="px_buildFlickrSearch"><?php _e('Advanced Search', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
				<?php _e('Select the set of flickr options you would like to work with', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<?php _e('For Flickr you have three options:', 'photoxhibit'); ?>
				<ol>
					<li><?php _e('Basic will bring you to a frame that you can enter your Flickr RSS feed into.', 'photoxhibit'); ?></li>
					<li><?php _e('Advance Photoset will bring you to a frame where you will be able to enter the ID to the photoset you want to grab images from.', 'photoxhibit'); ?></li>
					<li><?php _e('Advanced Search will bring you to a frame where you will be able to enter a USER ID, a Group ID, and/or Tags to grab images from.', 'photoxhibit'); ?></li>
				</ol>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_flickrOpt" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: flickr basic -->